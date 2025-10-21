<?php
session_start();
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $message = '<div class="alert error">❌ Username atau password salah.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Admin Simpelsi</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="logo.jpg" alt="Logo Simpelsi" class="header-logo">
        <div class="header-title">SIMPELSII</div>
    </div>

    <!-- Login Card -->
    <div class="login-card">
        <!-- Judul Login -->
        <div class="login-title">
            LOGIN ADMIN<br><span>Simpelsi</span>
        </div>

        <!-- Alert -->
        <?php if ($message): ?>
            <?= $message ?>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="admin" required autocomplete="off" />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="admin123" required />
            </div>
            <button type="submit" class="btn-login">Login</button>
            <button type="button" class="btn-reset" onclick="this.form.reset()">Reset Password?</button>
        </form>
    </div>
</body>
</html>