<?php
#define('DB_HOST', 'mariadb');
define('DB_HOST', 'localhost');
#define('DB_USER', 'root1');
define('DB_USER', 'root');
define('DB_PASS', '');
#define('DB_NAME', 'tfc1');
define('DB_NAME', 'tfc');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('Connection Failed ' . $conn->connect_error);
}

echo 'CONNECTED';
