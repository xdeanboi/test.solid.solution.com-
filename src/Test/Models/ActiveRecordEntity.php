<?php

namespace Test\Models;

use http\Params;
use Test\Services\Db;

abstract class ActiveRecordEntity
{
    protected $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    abstract protected static function getTableName(): string;

    public function __set($name, $value)
    {
        $nameToCamelCase = $this->underscoreToCamelCase($name);
        $this->$nameToCamelCase = $value;
    }

    public static function camelCaseToUnderscore(string $source): string
    {
        // sTH => s_t_h
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    private function underscoreToCamelCase(string $source): string
    {
        //s_t_h => sTH
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    private function mapPropertiesToDb(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }
        return $mappedProperties;
    }

    public static function findAll(): ?array
    {
        $db = Db::getInstance();

        $result = $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);

        if (!$result) {
            return null;
        }

        return $result;
    }

    public static function getFindByColumn(string $columnName, $value): ?array
    {
        $db = Db::getInstance();

        $result = $db->query('SELECT * FROM `' . static::getTableName() . '` WHERE ' . $columnName . ' = :value' ,
            [':value' => $value], static::class);

        if ($result === []) {
            return null;
        }


        return $result;
    }

    public static function getFindByColumnLimit(string $columnName, $value): ?array
    {
        $db = Db::getInstance();

        $result = $db->query('SELECT * FROM `' . static::getTableName() . '` WHERE ' . $columnName . ' = :value LIMIT 2' ,
            [':value' => $value], static::class);

        if ($result === []) {
            return null;
        }


        return $result;
    }

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();

        $result = $db->query('SELECT * FROM ' . static::getTableName() . ' WHERE id = :id',
        [':id' => $id], static::class);

        return $result ? $result[0] : null;
    }

    protected function insert()
    {
        $mappedProperties = $this->mapPropertiesToDb();
        $filterProperties = array_filter($mappedProperties);

        $columns = [];
        $params2value = [];
        $index = 1;
        $params = [];
        foreach ($filterProperties as $columnName => $value) {
            $param = ':param' . $index++;
            $params[] = $param;
            $params2value[$param] = $value;
            $columns[] = $columnName;
        }

        $columnsForSql = implode(', ', $columns);
        $paramsForSql = implode(', ', $params);

        $db = Db::getInstance();

        $sql = 'INSERT INTO `' . static::getTableName() . '` (' . $columnsForSql . ') VALUES (' . $paramsForSql . ');';
        $db->query($sql, $params2value, static::class);
        $this->id = $db->getLastId();
    }

    public static function deleteById(int $id): void
    {
        $db = Db::getInstance();

        $db->query('DELETE FROM ' . static::getTableName() . ' WHERE id = :id;',
            [':id' => $id], static::class);

    }

}