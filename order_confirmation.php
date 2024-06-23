<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit();
}

// В этой части кода нужно обработать данные оформленного заказа, например, сохранить их в базе данных и вывести информацию о заказе

// После обработки данных, можно вывести страницу подтверждения заказа

// Пример:
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Подтверждение заказа</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Ваш заказ успешно оформлен</h1>
        <nav>
            <a href="index.php">Главная</a>
            <a href="logout.php">Выйти</a>
        </nav>
    </header>
    <div class="container">
        <p>Номер вашего заказа: <strong>#12345</strong></p>
        <p>Спасибо за ваш заказ! Мы свяжемся с вами в ближайшее время для подтверждения и уточнения деталей доставки.</p>
        <a href="index.php">Вернуться на главную страницу</a>
    </div>
</body>
</html>
