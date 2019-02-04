<?php

require('functions.php');

session_start();


if (! is_logged()) {

    if (! isset($_POST['key'])) {

        ?>
        <!-- needs to register -->
        <form action="" method="post">
            <label>password: </label><input name="key" type="password">
            <input type="submit" value="send">
        </form>
        <?php
        exit();
    }

    $is_valid = $_POST['key'] === FORM_PRIVKEY;
    if (! $is_valid) {

        ?>
        <!-- invalid key -->
        <p>wrong credentials</p>
        <?php
        exit();
    }

    log_user();
}
?>

<h1>automatic update</h1>
<form action="update.php">
    <input type="submit" value="auto update">
</form>