<?php
session_start();
include 'db_users.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверка, существует ли пользователь с таким именем
    $stmt = $conn_users->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $error = "Имя пользователя уже занято. Пожалуйста, выберите другое имя.";
    } else {
        // Если пользователь не существует, регистрируем его
        $stmt = $conn_users->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, md5($password)]);
        header("Location: login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Регистрация</h1>
        <nav>
            <a href="index.php">Главная</a>
        </nav>
    </header>
    <div class="form-container">
        <form method="post" action="register.php">
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Зарегистрироваться</button>
            <p>Уже зарегистрированы? <a href="login.php">Войти</a></p>
        </form>
    </div>
</body>
</html>

