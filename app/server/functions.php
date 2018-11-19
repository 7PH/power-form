<?php

require('../../config.php');

/**
 * Creates a connection to the database
 *
 * @param string $host db hostname
 * @param string $name db name
 * @param string $user db user
 * @param string $pass user password
 * @return PDO
 */
function db_connect($host, $name, $user, $pass) {

    return new PDO("mysql:host=$host;dbname=$name", $user, $pass);
}

/**
 * @return PDO
 */
function db_init() {

    $PDO = db_connect(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
    $PDO->exec(
        'CREATE TABLE IF NOT EXISTS `' . DB_TABLE . '` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `form_identifier` VARCHAR (64),
            `data` VARCHAR(4096) NOT NULL,
            `ip` VARCHAR(64) NOT NULL,
            PRIMARY KEY (`id`),
            INDEX (`form_identifier`),
            INDEX (`ip`)
        ) ENGINE = InnoDB;');
    return $PDO;
}

/**
 * @param $PDO
 * @param $data
 * @param $ip
 * @param null $form_identifier
 */
function db_add_entry(&$PDO, $data, $ip, $form_identifier=NULL) {
    $p = $PDO->prepare('INSERT INTO `form_results` (`data`, `form_identifier`, `ip`) VALUES (?, ?, ?)');
    $p->execute([json_encode($data), $form_identifier, $ip]);
}

/**
 * @return mixed
 */
function read_post_data() {

    return json_decode(file_get_contents('php://input'), true);
}

/**
 * @return mixed
 */
function read_config() {

    return array(
        "hostname" => FORM_HOSTNAME,
        "elements" => json_decode(FORM_ELEMENTS, true)
    );
}

/**
 * @param $data
 */
function ajax_exit($data) {

    header("Content-Type: application/json");
    exit(json_encode($data));
}

/**
 * @param $message
 */
function ajax_error_exit($message) {

    ajax_exit(array("error" => $message));
}

/**
 * @param $values
 * @return bool
 */
function send_email($values) {

    $host = $values['host'];

    $mail_title = "Form submitted: ".date("Y/m/d")." à ".date("H:i:s");

    $mail_text = json_encode($values);

    $headers = 'From: no-reply@' . $host . "\r\n" .
        'Reply-To: no-reply@' . $host . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $emails = json_decode(FORM_EMAILS);
    foreach ($emails as $email)
        if (!mail($email, $mail_title, $mail_text, $headers))
            return false;
    return true;
}
