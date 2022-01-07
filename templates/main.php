<?php include __DIR__ . '/header.php'?>
<h1 style="text-align: center">Тестовое задание</h1>

<div style="text-align: left">
    <button><a href="/add" style="text-decoration: none; color: black">Create root</a></button>
</div>

<? if (!empty($roots)):?>

    <? foreach ($roots as $root):?>
        <? if ($root->getParents() === null):?>
            <ul>

                <li>
                    <?= $root->getName() . $root->getId()?>
                    <button>
                        <a href="/add/<?= $root->getId() ?>"
                           style="text-decoration: none; color: black"><strong>+</strong></a>
                    </button>
                    <button>
                        <a href="/delete/<?= $root->getId() ?>"
                           style="text-decoration: none; color: black"><strong>-</strong></a>
                    </button>
                </li>
                <? $child = $root->getChild()?>
                <? if (!empty($child)):?>
                    <? foreach ($child as $children):?>
                        <ul>

                            <li>
                                <?= $children->getRootChild()->getName() . $children->getRootChild()->getId()?>
                                <button>
                                    <a href="/add/<?= $children->getRootChild()->getId() ?>"
                                       style="text-decoration: none; color: black"><strong>+</strong></a>
                                </button>
                                <button>
                                    <a href="/delete/<?= $children->getRootChild()->getId() ?>"
                                       style="text-decoration: none; color: black"><strong>-</strong></a>
                                </button>
                            </li>
                            <? $childrenChild = $children->getRootChild()->getChild()?>
                            <? if (!empty($childrenChild)):?>
                                <? foreach ($childrenChild as $childrenChildChildren):?>
                                    <ul>
                                        <li>
                                            <?= $childrenChildChildren->getRootChild()->getName() . $childrenChildChildren->getRootChild()->getId() ?>
                                            <button>
                                                <a href="/add/<?= $childrenChildChildren->getRootChild()->getId() ?>"
                                                   style="text-decoration: none; color: black"><strong>+</strong></a>
                                            </button>
                                            <button>
                                                <a href="/delete/<?= $childrenChildChildren->getRootChild()->getId() ?>"
                                                   style="text-decoration: none; color: black"><strong>-</strong></a>
                                            </button>
                                        </li>
                                    </ul>
                                <? endforeach;?>
                            <? endif;?>

                        </ul>
                    <? endforeach;?>
                <? endif;?>

            </ul>
        <? endif;?>
    <? endforeach;?>

<? endif; ?>

<?php include __DIR__ . '/footer.php'?>