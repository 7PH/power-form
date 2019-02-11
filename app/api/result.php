<?php

require '../lib/functions.php';

/**
 * Data received from the form
 */
$data = read_post_data();

/**
 * Configuration object
 */
$config = read_config();

// General checks
if (! $data)
    ajax_error_exit("Incomplete data");

if (! is_array($data) || count($data) !== count($config['FORM_ELEMENTS']))
    ajax_error_exit("Incorrect data");

// Check values
foreach ($config['FORM_ELEMENTS'] as $key => $element) {
    if (! isset($element['accept']))
        continue;

    $accept = $element['accept'];
    $value = $data[$key];
    $accepted = false;
    if ($accept === 'email') {
        $accepted = filter_var($value, FILTER_VALIDATE_EMAIL);
    } else {
        $accepted = $accept == $value;
    }

    if (! $accepted)
        ajax_error_exit("Error: " . $element['title']);
}

// Merge config with values
$values = $config;
foreach ($values['FORM_ELEMENTS'] as $key => $value)
    $values['FORM_ELEMENTS'][$key]['value'] = $data[$key];


// Store in db if config is set
if ($config['DB_ENABLE'])
    db_add_entry(db_init(), $values, $_SERVER['REMOTE_ADDR'], $config['DB_IDENTIFIER']);


// Send email if config tells so
if ($config['FORM_SEND_EMAIL'])
    if (! send_email($values))
        ajax_error_exit("An error occurred while sending the email");


// Exit
ajax_exit($values);
