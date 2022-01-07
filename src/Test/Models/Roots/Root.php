<?php

namespace Test\Models\Roots;

use Test\Models\ActiveRecordEntity;

class Root extends ActiveRecordEntity
{
    protected $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    protected static function getTableName(): string
    {
        return 'roots';
    }

    public static function add(): Root
    {
        $root = new Root();

        $root->insert();

        return $root;
    }

    public function getParents(): ?array
    {
        $parents =  CategoryRoots::getParentsById($this->getId());

        if ($parents === []) {
            return null;
        }

        return $parents;
    }

    public function getChild(): ?array
    {
        $child = CategoryRoots::getChildByIdLimit($this->getId());

        if ($child === []) {
            return null;
        }

        return $child;
    }

    public function getLastParent()
    {
        $parents = CategoryRoots::getParentsById($this->getId());

        if (!empty($parents)) {
            $lastParent = end($parents);
        }

        return $lastParent;
    }
}