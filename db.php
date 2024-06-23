<?php
$dbHost = 'localhost'; // Замените на свой хост
$dbUser = 'root'; // Замените на своего пользователя
$dbPass = ''; // Замените на свой пароль
$dbName = 'products'; // Замените на имя вашей базы данных

try {
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo 'Соединение с MySQL успешно установлено';
} catch (PDOException $e) {
    die('Ошибка подключения к базе данных: ' . $e->getMessage());
}
?>
