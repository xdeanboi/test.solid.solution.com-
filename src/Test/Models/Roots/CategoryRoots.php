<?php

namespace Test\Models\Roots;

use Test\Models\ActiveRecordEntity;

class CategoryRoots extends ActiveRecordEntity
{
    protected $idParent;
    protected $idChild;

    /**
     * @param int $idParent
     */
    public function setIdParent(int $idParent): void
    {
        $this->idParent = $idParent;
    }

    /**
     * @return int
     */
    public function getIdParent(): int
    {
        return $this->idParent;
    }

    /**
     * @param int $idChild
     */
    public function setIdChild(int $idChild): void
    {
        $this->idChild = $idChild;
    }

    /**
     * @return int
     */
    public function getIdChild(): int
    {
        return $this->idChild;
    }

    protected static function getTableName(): string
    {
        return 'category_roots';
    }

    public static function add(int $parentId, int $childId): void
    {
        $category = new CategoryRoots();

        $category->setIdParent($parentId);
        $category->setIdChild($childId);

        $category->insert();
    }

    public static function getParentsById(int $id): ?array
    {
        $parents = CategoryRoots::getFindByColumn('id_child', $id);

        if ($parents === []) {
            return null;
        }

        return $parents;
    }

    public static function getChildByIdLimit(int $id): ?array
    {
        $childs = CategoryRoots::getFindByColumnLimit('id_parent', $id);

        if ($childs === []) {
            return null;
        }

        return $childs;
    }

    public static function getChildById(int $id): ?array
    {
        $childs = CategoryRoots::getFindByColumn('id_parent', $id);

        if ($childs === []) {
            return null;
        }

        return $childs;
    }

    public function getRootChild(): Root
    {
        return Root::getById($this->idChild);
    }

}