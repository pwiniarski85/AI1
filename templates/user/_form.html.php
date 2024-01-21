<?php
    /** @var $user ?\App\Model\User */
?>

<div class="form-group">

<!--    tutaj dalej-->
    <label for="name">Name</label>
    <input type="text" id="name" name="user[name]" value="<?= $user ? $user->getName() : '' ?>">
</div>

<div class="form-group">
    <label for="email">Email</label>
    <textarea id="email" name="user[email]"><?= $user? $user->getEmail() : '' ?></textarea>
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
