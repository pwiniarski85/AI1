<?php

/** @var \App\Model\Post $post */
/** @var \App\Service\Router $router */

$title = 'Create Post';

ob_start(); ?>
    <h1>Create Post</h1>
    <form action="<?= $router->generatePath('post-create') ?>" method="post">
        <label for="subject">Subject</label>
        <input type="text" id="subject" name="post[subject]" value="<?= $post ? $post->getSubject() : '' ?>">

        <label for="content">Content</label>
        <textarea id="content" name="post[content]"><?= $post? $post->getContent() : '' ?></textarea>

        <input type="submit" value="Submit">
        <input type="hidden" name="action" value="post-create">
    </form>

    <a href="<?= $router->generatePath('post-index') ?>">Back to list</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
