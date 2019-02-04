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

$PDO = db_init();
$entries = db_get_entries($PDO, 0, 100);

?>

<h1>automatic update</h1>
<form action="update.php">
    <input type="submit" value="auto update">
</form>

<h1>results</h1>
<table>
    <tr>
        <th>id</th>
        <th>form</th>
        <th>data</th>
        <th>ip</th>
    </tr>
    <tr>
        <td><?= $entry['id'] ?></td>
        <td><?= $entry['form_identifier'] ?></td>
        <td><?= $entry['data'] ?></td>
        <td><?= $entry['ip'] ?></td>
    </tr>
</table>
<ul>
</ul>