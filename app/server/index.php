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
$config = read_config();
$config_state = $config['hostname'] === FORM_HOSTNAME && is_array($config['elements']);

?>

<h1>actions</h1>
<form action="update.php">
    <input type="submit" value="auto update">
</form>
<button onclick="document.location='../../';">exit</button>

<h1>application</h1>
<p>configuration: <b><?= $config_state ? 'OK' : 'ERROR' ?></b></p>

<h1>results</h1>
<table border="1">
    <tr>
        <th>id</th>
        <th>form</th>
        <th>data</th>
        <th>ip</th>
    </tr>
    <?php
    foreach ($entries as $entry) {
        $entry['data'] = json_decode($entry['data'], true);
        ?>
        <tr>
            <td><?= $entry['id'] ?></td>
            <td><?= $entry['form_identifier'] ?></td>
            <td>
                <ul>
                    <?php
                    foreach ($entry['data']['elements'] as $element) {
                        if ($element['type'] === 'separator')
                            continue;
                        ?>
                        <li><b><?= htmlentities($element['title'], ENT_QUOTES) ?></b> - <?= htmlentities($element['value'], ENT_QUOTES) ?></li>
                        <?php
                    }
                    ?>
                </ul>
            </td>
            <td><?= $entry['ip'] ?></td>
        </tr>
        <?php
    }
    ?>
</table>
<ul>
</ul>