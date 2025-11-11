<?php
session_start();

// Jika sudah login, langsung ke dashboard
// if (isset($_SESSION['admin_id'])) {
//     header("Location: ../Admin/dashboardAdmin.php");
//     exit;
// }

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Username dan password wajib diisi.';
    } else {
        require_once '../KoneksiDatabase/koneksi.php';

        try {
            $stmt = $pdo->prepare("SELECT id_admin, username, password FROM admin WHERE username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            if ($admin && $password === $admin['password']) {
                $_SESSION['admin_id'] = $admin['id_admin'];
                $_SESSION['admin_username'] = $admin['username'];

                header("Location: ../Admin/dashboardAdmin.php");
                exit;
            } else {
                $error = 'Username atau password salah.';
            }
        } catch (PDOException $e) {
            $error = 'Kesalahan database: ' . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Admin Simpelsi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: #2e8b57;
            padding: 12px 20px;
            /* kurangi padding horizontal */
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 10;
            color: white;
            /* Tinggi responsif */
            min-height: 60px;
        }

        .header-logo {
            width: 36px;
            /* sedikit lebih kecil */
            height: 36px;
            margin-right: 8px;
            border-radius: 50%;
            overflow: hidden;
        }

        .header-title {
            font-size: 1.3em;
            /* lebih kecil */
            font-weight: bold;
        }

        .header-title span {
            font-size: 0.75em;
            font-weight: normal;
            display: block;
        }

        .exit-btn {
            background: white;
            color: #2e8b57;
            padding: 6px 12px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            white-space: nowrap;
            /* cegah wrap */
        }

        .exit-btn:hover {
            background: #e6ffe6;
            transform: scale(1.03);
        }

        /* CARD LOGIN */
        .login-card {
            width: 100%;
            max-width: 600px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            display: flex;
            margin-top: 80px;
            /* Jarak dari navbar */
        }

        .login-form-section {
            flex: 1;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-image-section {
            flex: 1;
            min-width: 250px;
            background: #f8fdf9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-image-section img {
            max-width: 100%;
            max-height: 280px;
            border-radius: 16px;
            object-fit: cover;
            box-shadow: 0 8px 20px rgba(46, 139, 87, 0.15);
        }

        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-title {
            font-size: 24px;
            font-weight: 800;
            color: #2e8b57;
            margin-bottom: 5px;
        }

        .login-subtitle {
            font-size: 18px;
            color: #226b42;
            font-weight: 600;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2e8b57;
            font-size: 14px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #2e8b57;
            box-shadow: 0 0 0 3px rgba(46, 139, 87, 0.2);
        }

        .btn-login {
            background: #2e8b57;
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(46, 139, 87, 0.2);
        }

        .btn-login:hover {
            background: #226b42;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(46, 139, 87, 0.3);
        }

        .btn-reset {
            background: transparent;
            color: #2e8b57;
            border: 2px solid #2e8b57;
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            background: rgba(46, 139, 87, 0.05);
        }

        .alert {
            padding: 10px;
            border-radius: 8px;
            margin-top: 15px;
            font-weight: 600;
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* RESPONSIF: MOBILE */
        @media (max-width: 768px) {
            .header {
                padding: 10px 16px;
                min-height: 56px;
            }

            .header-logo {
                width: 32px;
                height: 32px;
                margin-right: 6px;
            }

            .header-title {
                font-size: 1.2em;
            }

            .header-title span {
                font-size: 0.7em;
            }

            .exit-btn {
                padding: 5px 10px;
                font-size: 13px;
                gap: 4px;
            }

            .header>div:first-child {
                margin-right: 10px;
            }

            .login-card {
                margin-top: 100px;
                flex-direction: column;
            }

            .login-form-section {
                padding: 30px 20px;
            }

            .login-image-section {
                padding: 15px;
                order: -1;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .login-image-section img {
                max-height: 220px;
                max-width: 100%;
                border-radius: 16px;
            }
        }

        @media (max-width: 480px) {
            .login-card {
                max-width: 100%;
            }

            .login-form-section {
                padding: 25px 15px;
            }

            .login-image-section {
                padding: 10px;
            }

            .login-image-section img {
                max-height: 180px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div style="display: flex; align-items: center;">
            <img src="../../assets/logo.jpg" alt="Logo Simpelsi" class="header-logo">
            <div class="header-title">
                Dashboard<br><span>ADMIN</span>
            </div>
        </div>
        <a href="../dashboard.php" class="exit-btn">← EXIT</a>
    </div>

    <!-- 1 CARD LOGIN -->
    <div class="login-card">
        <!-- Bagian Form -->
        <div class="login-form-section">
            <div class="login-header">
                <div class="login-title">LOGIN ADMIN</div>
                <div class="login-subtitle">Simpelsi</div>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>

            <form method="POST" id="loginForm">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required autocomplete="off" />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />
                </div>
                <button type="submit" class="btn-login">Login</button>
                <button type="button" class="btn-reset" onclick="resetForm()">Reset Form</button>
            </form>
        </div>

        <!-- Bagian Gambar -->
        <div class="login-image-section">
            <img src="../../assets/Login.jpg" alt="Ilustrasi Login">
        </div>
    </div>

    <script>
        function resetForm() {
            document.getElementById('loginForm').reset();
            document.getElementById('username').focus();
        }
    </script>
</body>

</html>