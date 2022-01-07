<?php

namespace Test\Services;

use Test\Exceptions\DbException;

class Db
{
    private static $instance;
    private $pdo;

    public function __construct()
    {
        $settingDb = (require __DIR__ . '/../../settings.php')['db'];

        try {
            $this->pdo = new \PDO('mysql:host=' . $settingDb['host'] . ';dbname=' . $settingDb['dbname'],
                $settingDb['user'],
                $settingDb['password']);

            $this->pdo->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new DbException('Ошибка при подключении к БД - ' . $e->getMessage());
        }
    }

    public function query(string $sql, array $params, string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if ($result === null) {
            return null;
        }

        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getLastId(): int
    {
        return $this->pdo->lastInsertId();
    }

}