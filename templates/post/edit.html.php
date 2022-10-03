<?php

/** @var \App\Model\Post $post */
/** @var \App\Service\Router $router */

$title = "Edit Post {$post->getSubject()} ({$post->getId()})";

ob_start(); ?>
    <h1><?= $title ?></h1>
    <form action="<?= $router->generatePath('post-edit') ?>" method="post">
        <label for="subject">Subject</label>
        <input type="text" id="subject" name="post[subject]" value="<?= $post ? $post->getSubject() : '' ?>">

        <label for="content">Content</label>
        <textarea id="content" name="post[content]"><?= $post? $post->getContent() : '' ?></textarea>

        <input type="submit" value="Submit">
        <input type="hidden" name="action" value="post-edit">
        <input type="hidden" name="id" value="<?= $post->getId() ?>">
    </form>

    <form action="<?= $router->generatePath('post-delete') ?>" method="post">
        <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
        <input type="hidden" name="action" value="post-delete">
        <input type="hidden" name="id" value="<?= $post->getId() ?>">
    </form>

    <a href="<?= $router->generatePath('post-index') ?>">Back to list</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
