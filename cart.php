<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    form {
    display: flex;
    flex-direction: column;
}

form label {
    margin-top: 10px;
}

form input, form textarea, form button {
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

form button {
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    margin-top: 20px;
}

form button:hover {
    background-color: #45a049;
}
form {
    display: inline-block;
}


</style>
<body>
    <header>
        <h1>Корзина</h1>
        <nav>
            <a href="index.php">Главная</a>
            <a href="my_orders.php">Мои заказы</a>
            <a href="logout.php">Выйти</a>
        </nav>
    </header>
    <div class="container">
        <h2>Оформление заказа</h2>
<form method="post" action="place_order.php">
    <?php
    $product_id = $_POST['product_id']; // Проверьте, что это значение получается корректно
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    $mainImage = null;

    if ($product_id > 0) {
        // Определите путь к папке с изображениями товара
        $directoryPath = __DIR__ . '/cars_images/' . $product_id;

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

    ?>
    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product["id"]); ?>">
    <h3><?php echo htmlspecialchars($product["name"]); ?></h3>

    <div class="cart_image">
    <img src="<?php echo 'cars_images/' . $product_id . '/' . htmlspecialchars($mainImage); ?>" alt="Основное изображение">
    </div>  
    <p><?php echo htmlspecialchars($product["description"]); ?></p>
    <p>Цена: <?php     
    $number = htmlspecialchars($product["price"]); 
    $formatted_number = number_format($number, 0, '.', "'"); 
     echo $formatted_number.' тг'; ?></p>
    <button type="submit">Оформить заказ</button>
</form>

    </div>
</body>
</html>
