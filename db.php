<?php
$host_name = "127.0.0.1";
$database = "inline";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host_name;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
