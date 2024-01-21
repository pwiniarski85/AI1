<?php

/** @var \App\Model\User[] $users */
/** @var \App\Service\Router $router */

$title = 'User List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>User List</h1>

    <a href="<?= $router->generatePath('user-create') ?>">Create new</a>

    <ul class="index-list">
        <?php foreach ($users as $user): ?>
            <li><h3><?= $user->getName() ?></h3>
                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('user-show', ['id' => $user->getId()]) ?>">Details</a></li>
                    <li><a href="<?= $router->generatePath('user-edit', ['id' => $user->getId()]) ?>">Edit</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
