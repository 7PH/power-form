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


// Merge config with values
$values = $config;
foreach ($values['elements'] as $key => $value)
    $values['elements'][$key]['value'] = $data[$key];


// Store in db if config is set
if (DB_ENABLE)
    db_add_entry(db_init(), $config, $_SERVER['REMOTE_ADDR']);


// Send email if config tells so
if (FORM_SEND_EMAIL)
    if (! send_email($config))
        ajax_error_exit("An error occurred while sending the email");


// Exit
ajax_exit($values);
