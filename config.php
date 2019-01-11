<?php

/** Private key for form handling */
define('FORM_PRIVKEY',  '@TODO');

/** Database credentials */
define('DB_ENABLE',     false);
define('DB_NAME',       '@TODO');
define('DB_USER',       '@TODO');
define('DB_PASSWORD',   '@TODO');
define('DB_HOST',       '@TODO');
define('DB_TABLE',      '@TODO');
define('DB_IDENTIFIER', '@TODO');

/** Contact emails */
define('FORM_SEND_EMAIL', false);
define('FORM_EMAILS', json_encode(array(
    'foo@bar.baz',
    'baz@foo.bar',
)));

/** Form config */
define('FORM_HOSTNAME', 'localhost');

/** Form elements*/
$elements = [];
$elements[] = array(
    "type" => "checkbox",
    "title" => "Checkbox 1",
    "default" => false
);
$elements[] = array(
    "type" => "checkbox",
    "title" => "Checkbox 2",
    "default" => true
);
$elements[] = array(
    "type" => "separator",
    "default" => null
);
$elements[] = array(
    "type" => "input",
    "title" => "Input 1",
    "default" => ""
);
$elements[] = array(
    "type" => "input",
    "title" => "Input 2",
    "default" => "default value"
);
$elements[] = array(
    "type" => "date",
    "title" => "Input 3 (date)",
    "default" => ""
);
$elements[] = array(
    "type" => "input",
    "title" => "Input 4 (email)",
    "accept" => "email",
    "default" => "default value"
);
$elements[] = array(
    "type" => "textarea",
    "title" => "Text area",
    "default" => ""
);
$elements[] = array(
    "type" => "select",
    "title" => "Select",
    "options" => array("One", "Two", "Three"),
    "default" => "1"
);

define('FORM_ELEMENTS', json_encode($elements));
