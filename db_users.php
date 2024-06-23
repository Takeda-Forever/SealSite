<?php
$dbHost = 'localhost'; // Замените на свой хост
$dbUser = 'root'; // Замените на своего пользователя
$dbPass = ''; // Замените на свой пароль
$dbName = 'users'; // Замените на имя вашей базы данных

try {
    $conn_users = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $conn_users->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>
