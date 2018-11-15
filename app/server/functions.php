<?php

require('env.php');

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
            `data` VARCHAR(4096) NOT NULL,
            `ip` VARCHAR(64) NOT NULL,
            PRIMARY KEY (`id`),
            INDEX (`ip`)
        ) ENGINE = InnoDB;');
    return $PDO;
}

/**
 * @param $PDO
 * @param $data
 * @param $ip
 */
function db_add_entry(&$PDO, $data, $ip) {
    $p = $PDO->prepare('INSERT INTO `form_results` (`data`, `ip`) VALUES (?, ?)');
    $p->execute([json_encode($data), $ip]);
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

    return json_decode(file_get_contents('../../config.json'), true);
}

/**
 * @param $data
 */
function ajax_exit($data) {

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

    $mail_title = "Form submitted: ".date("Y/m/d")." à ".date("H:i:s");

    $mail_text = json_encode($values);

    $headers = 'From: no-reply@anathea-mediterranee.com' . "\r\n" .
        'Reply-To: no-reply@anathea-mediterranee.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $emails = json_decode(FORM_EMAILS);
    foreach ($emails as $email)
        if (! mail($email, $mail_title, $mail_text, $headers))
            return false;
}