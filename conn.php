<?php
declare(strict_types=1);

/**
 * Conexión a MySQL (XAMPP).
 * Ajusta DB_NAME/DB_USER/DB_PASS según tu phpMyAdmin.
 */

const DB_HOST = '127.0.0.1';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'mashkabox';
const DB_PORT = 3306;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function conn(): mysqli
{
    static $mysqli = null;
    if ($mysqli instanceof mysqli) {
        return $mysqli;
    }

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    $mysqli->set_charset('utf8mb4');
    return $mysqli;
}