<?php

require '../lib/functions.php';

$config = read_config();

$config = sanitize_config($config);

ajax_exit($config);