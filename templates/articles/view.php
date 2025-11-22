<?php include __DIR__ . '/../header.php'; ?>
<h1><?= $article->getName() ?></h1>
<p><?= $article->getText() ?></p>
<p>Автор: <?= $article->getAuthor()->getNickname() ?></p>

<?php if (!isset($_GET['edit'])): ?>

	<a href="/articles/<?= $article->getId() ?>?edit=1">
		<button type="button">Редактировать</button>
	</a>
<?php else: ?>
	<form action="/articles/<?= $article->getId() ?>/edit" method="post">
		<div>
			<label for="name">Название статьи:</label><br>
			<input type="text" id="name" name="name" value="<?= ($article->getName()) ?>">
		</div>
		<div>
			<label for="text">Текст статьи:</label><br>
			<textarea id="text" name="text" rows="10" cols="80"><?= ($article->getText()) ?></textarea>
		</div>
		<button type="submit">Сохранить</button>
		<a href="/articles/<?= $article->getId() ?>/delete">Удалить</a>
	</form>
<?php endif; ?>

<h1>Комментарии</h1>

<?php if (!isset($_GET['editC'])): ?>

	<a href="/articles/<?= $article->getId() ?>?editC=1">
		<button type="button">Прокомментировать</button>
	</a>
<?php else: ?>
	<form action="/articles/<?= $article->getId() ?>/comments" method="post">
		<div>
			<label for="text">Оставьте Ваш комментарий</label><br>
			<textarea id="text" name="text" rows="10" cols="80"></textarea>
		</div>
		<button type="submit">Сохранить</button>
	</form>
<?php endif; ?>

<?php foreach ($comments as $comment): ?>
	<div id="comment<?= $comment->getId() ?>" class="comment">
		<p><?= ($comment->getText()) ?></p>
		<p>Автор: <?= $comment->getUser()->getNickname() ?></p>
		<p>Дата: <?= $comment->getCreatedAt() ?></p>

		<a href="?editComment=<?= $comment->getId() ?>">Редактировать</a>

		<?php if (isset($_GET['editComment']) && (int)$_GET['editComment'] === $comment->getId()): ?>

			<form action="/comments/<?= $comment->getId() ?>/edit" method="post" style="margin-top:10px;">
				<input type="text" name="text" value="<?= htmlspecialchars($comment->getText()) ?>" style="width: 80%;">
				<button type="submit">Сохранить</button>
			</form>

		<?php endif; ?>
		<hr>
	</div>
<?php endforeach; ?>

<?php include __DIR__ . '/../footer.php'; ?>