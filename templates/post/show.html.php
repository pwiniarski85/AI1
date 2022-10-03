<?php

/** @var \App\Model\Post $post */
/** @var \App\Service\Router $router */

$title = "{$post->getSubject()} ({$post->getId()})";

ob_start(); ?>
    <h1><?= $post->getSubject() ?></h1>
    <article>
        <?= $post->getContent();?>
    </article>

    <a href="<?= $router->generatePath('post-index') ?>">Back to list</a>
    <a href="<?= $router->generatePath('post-edit', ['id'=> $post->getId()]) ?>">Edit</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
