<?php

namespace MyProject\Models\Comments;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;

class Comments extends ActiveRecordEntity
{
	protected $text;
	protected $userId;
	protected $articleId;
	protected $createdAt;

	protected static function getTableName(): string
	{
		return 'comments';
	}

	public function getArticleId(): int
	{
		return $this->articleId;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getText(): string
	{
		return $this->text;
	}

	public function getUser(): User
	{
		return User::getById($this->userId);
	}

	public function getCreatedAt(): string
	{
		return $this->createdAt;
	}

	public function setText(string $text): void
	{
		$this->text = $text;
	}

	public function setArticleId(int $articleId): void
	{
		$this->articleId = $articleId;
	}

	public function setUserId(): void
	{
		$this->userId = 2;
	}

	public function setCreatedAt(): void {}
}
