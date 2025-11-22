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

<?php include __DIR__ . '/../footer.php'; ?>