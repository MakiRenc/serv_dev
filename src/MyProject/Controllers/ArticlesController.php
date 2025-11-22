<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\View\View;
use MyProject\Models\Users\User;

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
			$this->view->renderHtml('errors/404.php', [], 404);
			return;
		}

		$this->view->renderHtml('articles/view.php', [
			'article' => $article
		]);
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
