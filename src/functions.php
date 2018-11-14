<?php


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
 * Ensure the db exists. Create it if necessary
 * @TODO implement
 *
 * @param $PDO
 */
function db_init(&$PDO) {

}