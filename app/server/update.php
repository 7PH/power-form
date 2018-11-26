<?php

require('functions.php');

if (FORM_PRIVKEY !== $_GET['key'] && FORM_PRIVKEY !== $_POST['key'])
    exit("Incorrect password");

$files = array();
$files[] = 'dist/index.js';
$files[] = 'dist/index.js.map';
$files[] = 'app/server/update.php';

foreach ($files as $file) {
    echo "Updating $file.. ";
    $result = update_file($file);
    echo $result ? "[OK]" : "[ERROR]";
    echo "<br>\n";
}
