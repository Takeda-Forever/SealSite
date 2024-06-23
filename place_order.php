<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db.php'; // Подключение к базе данных продуктов

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$order_date = date("Y-m-d H:i:s");

// Получаем информацию о товаре
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
$total_price = $product['price'];

// Сохраняем заказ в базу данных
$stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, total_price, order_date) VALUES (?, ?, ?, ?)");
$stmt->execute([$user_id, $product_id, $total_price, $order_date]);

// Перенаправляем пользователя на страницу с его заказами
header("Location: my_orders.php");
exit();
?>

