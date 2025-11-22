<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\View\View;
use MyProject\Models\Users\User;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Comments\Comments;

class ArticlesController
{
	private $view;

	public function __construct()
	{
		$this->view = new View(__DIR__ . '/../../../templates');
	}

	public function view(int $articleId)
	{
		$article = Article::getById($articleId);
		if ($article === null) {
			throw new NotFoundException();
		}

		$comments = Comments::findCom($articleId);

		// var_dump($comments);
		// die;

		$this->view->renderHtml('articles/view.php', [
			'article' => $article,
			'comments' => $comments
		]);
	}

	public function addCom(int $articleId)
	{
		$article = Article::getById($articleId);
		if ($article === null) {
			throw new NotFoundException();
		}

		$text = $_POST['text'] ?? '';
		if (trim($text) === '') {
			$this->view->renderHtml('errors/404.php');
			return;
		}

		$comment = new Comments();
		$comment->setText($text);
		$comment->setArticleId($articleId);
		$comment->setUserId();

		$comment->save();

		$commentId = $comment->getId();

		header('Location: /articles/' . $article->getId() . '#comment' . $commentId);
		exit;
	}


	public function edit(int $articleId): void
	{
		/** @var Article $article */

		$article = Article::getById($articleId);

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$article->setName($_POST['name'] ?? $article->getName());
			$article->setText($_POST['text'] ?? $article->getText());

			$article->save();

			header('Location: /articles/' . $article->getId());
			exit;
		}
	}

	public function editCom(int $commentId): void
	{
		/** @var Comments $comment */
		$comment = Comments::getById($commentId);

		// var_dump($comment);
		// die;

		if ($comment === null) {
			throw new NotFoundException();
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$comment->setText($_POST['text'] ?? $comment->getText());
			$comment->save();

			header('Location: /articles/' . $comment->getArticleId() . '#comment' . $comment->getId());
			exit;
		}
	}

	public function add(): void
	{
		$author = User::getById(1);
		$article = new Article();
		$article->setAuthor($author);
		$article->setName('Новое название статьи');
		$article->setText('Новый текст статьи');
		$article->save();
		var_dump($article);
	}

	public function deleteA(int $articleId): void
	{
		/** @var Article $article */
		$article = Article::getById($articleId);
		$article->delete();
		header('Location: /www/');
	}
}
