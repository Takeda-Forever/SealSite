<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
include 'db_users.php';

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>  
    <meta charset="UTF-8">
    <title>Мои заказы</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Мои заказы</h1>
        <nav>
            <a href="index.php">Главная</a>
            <a href="logout.php">Выйти</a>
        </nav>
    </header>
    <div class="container">
        <h2>Ваши заказы</h2>
        <div class="order-list">
           
        <?php
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($orders) > 0) {
        foreach ($orders as $order) {
            $sfmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
            $sfmt->execute([$order["product_id"]]);
            $product = $sfmt->fetch(PDO::FETCH_ASSOC);

            $number = htmlspecialchars($order["total_price"]);
            $formatted_number = number_format($number, 0, '.', ' ');
            echo "<div class='order'>";
            echo "<h3>Продукт: " . htmlspecialchars($product['name']) . "</h3>";
            $mainImage = null;

            if ($order["product_id"] > 0) { // Fixed typo here
                // Определите путь к папке с изображениями товара
                $directoryPath = __DIR__ . '/cars_images/' . $order["product_id"];

                if (is_dir($directoryPath)) {
                    // Откройте директорию и найдите главное изображение
                    if ($handle = opendir($directoryPath)) {
                        while (false !== ($file = readdir($handle))) {
                            if ($file != '.' && $file != '..') {
                                // Проверьте, является ли файл основным изображением
                                if (strpos($file, '_main.') !== false) {
                                    $mainImage = $file;
                                    break; // Остановите цикл, если найдено главное изображение
                                }
                            }
                        }
                        closedir($handle);
                    }
                }
            }
            //Preview image
                if(!empty($mainImage)){
                    echo "<img src='cars_images/" . $order["product_id"] . "/" . htmlspecialchars($mainImage) . "' alt='Основное изображение' width='400'>"; // Added width attribute here
                }else{
                    echo "<p>Изображение недоступно</p>";
                }
            echo "<p>Общая стоимость: " . $formatted_number . " тг</p>";
            echo "<p>Дата заказа: " . htmlspecialchars($order["order_date"]) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>У вас нет заказов.</p>";
    }
?>


        </div>
    </div>
</body>
</html>
