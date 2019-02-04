<?php

require('functions.php');

session_start();

if (! is_logged())
    exit("invalid session");

$files = array();
$files[] = 'dist/index.js';
$files[] = 'dist/index.js.map';
$files[] = 'app/server/functions.php';
$files[] = 'app/server/index.php';
$files[] = 'app/server/result.php';
$files[] = 'app/server/update.php';

foreach ($files as $file) {
    echo "Updating $file.. ";
    $result = update_file($file);
    echo $result ? "[OK]" : "[ERROR]";
    echo "<br>\n";
}

?>
<a href="./">back to admin panel</a>
