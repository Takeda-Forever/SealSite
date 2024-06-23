<?php
session_start();
include 'db.php'; 
include 'db_users.php'; 


?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Car Market</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        
        <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
            <h1>Admin</h1>
            <?php else: ?>
                <h1>Добро пожаловать в Car Market</h1>
            <?php endif; ?>
        <nav>
            <a href="index.php">Главная</a>
            <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
                <a href="admin/manage_products.php">Управление товарами</a>
                <?php elseif (isset($_SESSION['user_logged_in'])): ?>
                    <a href="my_orders.php">Мои заказы</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['admin_logged_in'])): ?>
                <a href="admin/logout.php">Выйти</a>
            <?php else: ?>
                <?php if (isset($_SESSION['user_logged_in'])): ?>
                    <a href="logout.php">Выйти</a>
                <?php else: ?>
                    <a href="login.php">Войти</a>
                    <a href="register.php">Регистрация</a>
                <?php endif; ?>
            <?php endif; ?>
            
        </nav>
    </header>
    <div class="boxer">
    <div class="text-center">
        <h2>Тачки</h2>
    </div>
    <div class="container">
        <div class="product-list">
            <?php
            $sql = "SELECT * FROM `products`;";
            foreach ($conn->query($sql) as $row) {    

                $number = htmlspecialchars($row["price"]); 
                $formatted_number = number_format($number, 0, '.', "'"); 
		        
                $product_name = htmlspecialchars($row["name"]);
                $product_description = htmlspecialchars($row["description"]);
                $product_id = htmlspecialchars($row["id"]);


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
                echo
                "<div class='product'>",
                "<div class='product_image'>";
                ?>
                <img src="<?php echo 'cars_images/' . $product_id . '/' . htmlspecialchars($mainImage); ?>" alt="Основное изображение">
                <?php
                echo "</div>",
                "<div class='product_detale'>",
                "<div class='product_detale_head'>",
                "<h3>$product_name</h3>", //    Name of product
                "<p class=\"money\" >Цена: $formatted_number тг</p>", //   Price of product
                "</div>",
                "<div class='product_detale_down'>",
                "<form method='post' action='cart.php'>", 
                "<input type='hidden' name='product_id' value='$product_id'>",
                "<button type='submit'>Подробнее</button>", //  Button to add product to cart
                "</div>",
                "</div>",
                "</div>",
                "</form>";
            }
            ?>
        </div>
    </div>
    </div>
</body>
</html>
