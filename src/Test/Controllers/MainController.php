<?php

namespace Test\Controllers;

use Test\Exceptions\NotFoundException;
use Test\Models\Roots\CategoryRoots;
use Test\Models\Roots\Root;

class MainController extends AbstractController
{
    public function main(): void
    {
        $roots = Root::findAll();

        $this->view->renderHtml('main.php',
            ['roots' => $roots]);
    }

    public function firstAdd(): void
    {
        Root::add();

        header('Location: /', true, 302);
        return;

    }

    public function add(int $idRoot): void
    {
        $root = Root::getById($idRoot);

        if (empty($root)) {
            throw  new NotFoundException('Невозможно продолжить ветку. А кто родитель?');
        }

        if (!empty($root)) {
            $newRootLeft = Root::add();
            CategoryRoots::add($idRoot, $newRootLeft->getId());

            $newRootRight = Root::add();
            CategoryRoots::add($idRoot, $newRootRight->getId());

            $parents = CategoryRoots::getParentsById($root->getId());

            if (!empty($parents)) {
                foreach ($parents as $parent) {
                    CategoryRoots::add($parent->getIdParent(), $newRootLeft->getId());
                    CategoryRoots::add($parent->getIdParent(), $newRootRight->getId());
                }
            }

            header('Location: /', true, 302);
            return;
        }

    }


    public function delete(int $idRoot)
    {
        $root = Root::getById($idRoot);

        if (empty($root)) {
            throw  new NotFoundException('А нечего удалять =)');
        }

        if (!empty($root)) {
            $childs = CategoryRoots::getChildById($root->getId());

            if (!empty($childs)) {
                foreach ($childs as $child) {
                    Root::deleteById($child->getIdChild());
                }
            }

            Root::deleteById($idRoot);

            header('Location: /', true, 302);
            return;

        }
    }
}