<?php

namespace MyProject\Services;

use  MyProject\Exceptions\DbException;

class Db
{
	private static $instance;
	private static $instancesCount = 0;

	/** @var \PDO */
	private $pdo;

	private function __construct()
	{
		self::$instancesCount++;

		$dbOptions = (require __DIR__ . '/../../settings.php');

		try {
			$this->pdo = new \PDO(
				'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
				$dbOptions['user'],
				$dbOptions['password']
			);
			$this->pdo->exec('SET NAMES UTF8');
		} catch (\PDOException $e) {
			throw new DbException('Ошибка при подключении к базе данных: ' . $e->getMessage());
		}
	}

	public function query(string $sql, array $params = [], string $className = null): ?array
	{
		$sth = $this->pdo->prepare($sql);
		$result = $sth->execute($params);

		if ($result === false) {
			return null;
		}

		if ($className === null) {
			return $sth->fetchAll(\PDO::FETCH_ASSOC);
		}

		// ВАЖНО: создаём массив объектов класса
		$sth->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $className);
		return $sth->fetchAll();
	}

	public function getPdo(): \PDO
	{
		return $this->pdo;
	}

	public static function getInstance(): self
	{
		if (self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
