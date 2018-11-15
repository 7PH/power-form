<?php

header("Content-Type: application/json");

$json = file_get_contents('php://input');
$obj = json_decode($json);

exit(json_encode($obj));
