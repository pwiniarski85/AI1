<?php

/** @var \App\Model\Post[] $posts */
/** @var \App\Service\Router $router */

$title = 'Post List';

ob_start(); ?>
    <h1>Posts List</h1>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li><?= $post->getSubject() ?>
                <ul>
                    <li><a href="<?= $router->generatePath('post-show', ['id' => $post->getId()]) ?>">Details</a></li>
                    <li><a href="<?= $router->generatePath('post-edit', ['id' => $post->getId()]) ?>">Edit</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="<?= $router->generatePath('post-create') ?>">Create new</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
