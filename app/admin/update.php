<?php

require '../lib/functions.php';

session_start();

if (! is_logged())
    exit("invalid session");

$files = array();
$files[] = 'dist/index.js';
$files[] = 'dist/index.js.map';
$files[] = 'app/admin/index.php';
$files[] = 'app/admin/update.php';
$files[] = 'app/api/config.php';
$files[] = 'app/api/result.php';
$files[] = 'app/server/update.php';

foreach ($files as $file) {
    echo "Updating $file.. ";
    $result = update_file($file);
    echo $result ? "[OK]" : "[ERROR]";
    echo "<br>\n";
}

?>
<a href="">back to admin panel</a>
