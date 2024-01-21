<?php

/** @var \App\Model\User $user */
/** @var \App\Service\Router $router */

$title = "{$user->getName()} ({$user->getId()})";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $user->getName() ?></h1>
    <article>
        <?= $user->getEmail();?>
    </article>

    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('user-index') ?>">Back to list</a></li>
        <li><a href="<?= $router->generatePath('user-edit', ['id'=> $user->getId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
