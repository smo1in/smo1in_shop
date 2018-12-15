<?php

/**
 *Class db
 * Database component
 */
class Db
{

    /**
     * Establishes a database connection
     * @return \PDO <p>PDO class object for working with the database</p>
     */
    public static function getConnection()
    {
        // Get connection settings from file
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);

        // Get connection
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);

        // Set the coding
        $db->exec("set names utf8");

        return $db;
    }

}
