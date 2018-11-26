<?php

require('functions.php');

$files = array();
$files[] = 'dist/index.js';
$files[] = 'dist/index.js.map';

foreach ($files as $file) {
    echo "Updating $file.. ";
    $result = update_file($file);
    echo $result ? "[OK]" : "[ERROR]";
    echo "\n";
}
