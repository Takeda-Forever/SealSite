<?php
session_start();
include 'db_users.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn_users->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, md5($password)]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        header("Location: my_orders.php");
    } else {
        $error = "Неправильное имя пользователя или пароль";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход пользователя</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Вход пользователя</h1>
        <nav>
            <a href="index.php">Главная</a>
        </nav>
    </header>
    <div class="form-container">
        <form method="post" action="login.php">
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Продолжить</button>
            <br>
            <a href="register.php">Зарегистрироваться</a>
        </form>
    </div>
</body>
</html>

