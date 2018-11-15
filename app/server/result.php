<?php

require('functions.php');

header("Content-Type: application/json");

/**
 * Data received from the form
 */
$data = read_post_data();

/**
 * Configuration object
 */
$config = read_config();


/**
 * @TODO add checks
 */



ajax_exit(array(
    "config" => $config,
    "data" => $data
));
