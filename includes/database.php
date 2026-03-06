<?php


$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$name = $_ENV['DB_NAME'];
$port = $_ENV['DB_PORT'] ?? 3306;


$db = mysqli_connect($host, $user, $pass, $name, $port);

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}

$db->set_charset("utf8");