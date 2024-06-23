<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оформление заказа</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    .container {
    border-radius: 5px;
    padding: 5px 15px;
    padding-bottom: 25px;
    background-color: rgb(255, 255, 255);
    max-width: 30vw;
    text-wrap: balance;
    border-radius: 10px;
    margin: 20px auto;
}
    label {
    display: block;
    margin-bottom: 10px;
    color: #333;
}

input[type="text"],
textarea,
select {
    width: 80%;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

textarea {
    height: 100px;
}

button[type="submit"] {
    background: #5cb85c;
    color: #fff;
    border: 0;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background: #4cae4c;
}
</style>
<body>
    <header>
        <h1>Оформление заказа</h1>
        <nav>
            <a href="index.php">Главная</a>
            <a href="cart.php">Корзина</a>
            <a href="logout.php">Выйти</a>
        </nav>
    </header>
    <div class="container">
        <h2>Введите ваши данные для доставки</h2>
        <form method="post" action="place_order.php">
            <label for="name">Имя:</label>
            <input type="text" id="name" name="name" required>
            <label for="address">Адрес:</label>
            <input type="text" id="address" name="address" required></input>
            <label for="phone">Телефон:</label>
            <input type="text" id="phone" name="phone" required>
            <label for="payment">Способ оплаты:</label>
            <select id="payment" name="payment" required>
                <option value="cash">Наличными при получении</option>
                <option value="card">Кредитная карта</option>
            </select>
            <button type="submit">Оформить заказ</button>
        </form>
    </div>
</body>
</html>
