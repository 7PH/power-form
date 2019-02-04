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
    $p = $PDO->prepare(
        'INSERT INTO `'.DB_TABLE.'` (`data`, `form_identifier`, `ip`) VALUES (?, ?, ?)');
    $p->execute([json_encode($data), $form_identifier, $ip]);
}


/**
 * Get form entries
 *
 * @param $PDO
 * @param $offset
 * @param $limit
 * @return mixed
 */
function db_get_entries(&$PDO, $offset, $limit) {
    $p = $PDO->prepare("SELECT `id`, `data`, `form_identifier`, `ip`
        FROM `".DB_TABLE."`
        WHERE form_identifier=?
        ORDER BY id DESC
        LIMIT $offset,$limit");
    $p->execute([DB_IDENTIFIER]);
    return $p->fetchAll(PDO::FETCH_ASSOC);
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

    $mail_title = "Form submitted: ".date("Y/m/d")." à ".date("H:i:s");

    $mail_html = file_get_contents('../../mail_templates/default.html');
    $mail_html = mail_template_populate($mail_html, $values);

    $headers = 'From: no-reply@' . FORM_HOSTNAME . "\r\n" .
        'Reply-To: no-reply@' . FORM_HOSTNAME . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $emails = json_decode(FORM_EMAILS);
    foreach ($emails as $email)
        if (!mail($email, $mail_title, $mail_html, $headers))
            return false;
    return true;
}

/**
 * @param string $mail_html
 * @param array $values
 * @return string
 */
function mail_template_populate($mail_html, $values) {

    // Build values html
    $values_html = "";
    foreach ($values['elements'] as $element) {

        if (is_bool($element["value"]))
            $v = $element["value"] ? "Yes" : "No";
        else if (is_null($element["value"]))
            $v = null;
        else
            $v = $element["value"];

        $values_html .= $element["title"];
        if ($v != null)
            $values_html .= ": " . htmlentities($v, ENT_QUOTES);
        $values_html .= "\n";
    }
    // Replace values
    $mail_html = str_replace('$values', $values_html, $mail_html);
    return $mail_html;
}

/**
 * Auto update local installation from remote source
 *
 * @param $path
 * @return bool
 */
function update_file($path) {

    $BASE_URL = "https://raw.githubusercontent.com/7PH/power-form/master/";
    $remote_path = $BASE_URL . $path;
    $local_path = dirname(dirname(__DIR__)) . '/' . $path;
    return copy($remote_path, $local_path);
}

/**
 * Tells if the user is logged as admin
 *
 * @return bool
 */
function is_logged() {
    return isset($_SESSION) && isset($_SESSION['form_logged']) && $_SESSION['form_logged'];
}

/**
 * Logs the user as admin
 */
function log_user() {
    $_SESSION['form_logged'] = true;
}