<?php
// login.php
require "lang.php";

$error = "";

if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars(trim($_POST["username"] ?? ""));
    $password = $_POST["password"] ?? "";

    if ($username === "admin" && $password === "admin123") {
        $_SESSION["user"] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <title><?= __('login_title'); ?> - <?= __('app_title'); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="max-width: 420px; margin-top: 40px;">
        <div class="nav-bar" style="justify-content: center;">
            <div class="nav-lang">
                <a href="?lang=id">Bahasa Indonesia</a>
                <span>|</span>
                <a href="?lang=en">English</a>
            </div>
        </div>

        <h2 style="text-align: center; margin-bottom: 24px;"><?= __('login_title'); ?></h2>

        <?php if (!empty($error)): ?>
            <div class="alert-error">
                <p><?= $error; ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="form-group">
                <label><?= __('username'); ?></label>
                <input type="text" name="username" placeholder="Masukkan username" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn" style="width: 100%; padding: 12px; margin-top: 10px;"><?= __('login'); ?></button>
        </form>
    </div>
</body>
</html>