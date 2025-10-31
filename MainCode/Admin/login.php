<?php
session_start();

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: ../Dashboard/dashboardAdmin.php");
    exit;
}

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

                header("Location: ../Dashboard/dashboardAdmin.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Admin Simpelsi</title>
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        }

        body { 
            background: #f5f5f5; 
            min-height: 100vh; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            padding: 20px; 
            position: relative; 
        }

        .header { 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            background: #095E0D; 
            padding: 12px 30px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
            z-index: 10; 
            color: white;
        }

        .header-logo { 
            width: 40px; 
            height: 40px; 
            margin-right: 10px; 
            border-radius: 50%; 
            overflow: hidden; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.2); 
        }

        .header-title { 
            font-size: 1.5em; 
            font-weight: bold; 
        }

        .header-title span { 
            font-size: 0.8em; 
            font-weight: normal; 
            display: block; 
        }

        .exit-btn { 
            background: white; 
            color: #095E0D; 
            padding: 6px 12px; 
            border-radius: 5px; 
            font-weight: bold; 
            text-decoration: none; 
            display: flex; 
            align-items: center; 
            gap: 5px; 
            transition: all 0.2s ease; 
        }

        .exit-btn:hover { 
            background: #e6ffe6; 
            transform: scale(1.05); 
        }

        .login-container { 
            display: flex; 
            gap: 30px; 
            align-items: center; 
            background: white; 
            padding: 30px; 
            border-radius: 20px; 
            box-shadow: 0 6px 20px rgba(0,0,0,0.1); 
            max-width: 1000px; 
            width: 100%; 
            margin-top: 80px; 
        }

        .login-card { 
            background: #095E0D; 
            padding: 35px 40px; 
            border-radius: 20px; 
            width: 100%; 
            max-width: 400px; 
            text-align: center; 
            color: white; 
        }

        .login-title { 
            font-size: 26px; 
            font-weight: bold; 
            margin-bottom: 10px; 
            line-height: 1.2; 
        }

        .login-subtitle { 
            font-size: 22px; 
            font-weight: normal; 
            margin-bottom: 25px; 
        }

        .form-group { 
            text-align: left; 
            margin-bottom: 20px; 
        }

        label { 
            display: block; 
            margin-bottom: 6px; 
            font-weight: 600; 
            color: white; 
            font-size: 14px; 
        }

        input[type="text"], 
        input[type="password"] { 
            width: 100%; 
            padding: 12px 15px; 
            border: none; 
            border-radius: 10px; 
            font-size: 16px; 
            background: white; 
            color: #333; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.08); 
            transition: all 0.3s ease; 
        }

        input:focus { 
            outline: none; 
            box-shadow: 0 2px 12px rgba(32, 167, 38, 0.3); 
        }

        .btn-login { 
            background: #20A726; 
            color: white; 
            border: none; 
            width: 100%; 
            padding: 12px; 
            border-radius: 10px; 
            font-size: 18px; 
            font-weight: 700; 
            cursor: pointer; 
            margin-bottom: 15px; 
            transition: all 0.3s ease; 
        }

        .btn-login:hover { 
            background: #1d9323; 
            transform: scale(1.02); 
        }

        .btn-reset { 
            background: white; 
            color: #095E0D; 
            border: 2px solid #20A726; 
            width: 100%; 
            padding: 10px; 
            border-radius: 10px; 
            font-size: 16px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.3s ease; 
        }

        .btn-reset:hover { 
            background: #e6ffe6; 
            color: #095E0D; 
            transform: scale(1.02); 
        }

        .alert { 
            padding: 10px; 
            border-radius: 8px; 
            margin-top: 20px; 
            font-weight: 600; 
            animation: fadeInUp 0.6s ease; 
            background: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb; 
        }

        @keyframes fadeInUp { 
            from { opacity: 0; transform: translateY(20px); } 
            to { opacity: 1; transform: translateY(0); } 
        }

        .illustration { 
            flex: 1; 
            min-width: 300px; 
            text-align: center; 
        }

        .illustration img { 
            max-width: 100%; 
            height: auto; 
            border-radius: 12px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); 
        }

        @media (max-width: 768px) { 
            .login-container { 
                flex-direction: column; 
                padding: 20px; 
            } 
            .illustration { 
                order: -1; 
            } 
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div style="display: flex; align-items: center;">
            <!-- GANTI PATH INI SESUAI ASET ANDA -->
            <!-- Contoh: "../assets/logo_ad.jpg" atau "../img/logo.png" -->
            <img src="../../assets/logo.jpg" alt="Logo Simpelsi" class="header-logo">
            <div class="header-title">
                Dashboard<br><span>ADMIN</span>
            </div>
        </div>
        <a href="../index.php" class="exit-btn">← EXIT</a>
    </div>

    <!-- Login Container -->
    <div class="login-container">
        <!-- Login Card -->
        <div class="login-card">
            <div class="login-title">LOGIN ADMIN</div>
            <div class="login-subtitle">Simpelsi</div>

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
                <button type="button" class="btn-reset" onclick="resetForm()">Reset Password?</button>
            </form>
        </div>

        <!-- Ilustrasi -->
        <div class="illustration">
            <!-- GANTI PATH INI SESUAI ASET ANDA -->
            <!-- Contoh: "../assets/login_illustration.png" -->
            <!-- Jika tidak pakai ilustrasi, hapus bagian ini -->
            <img src="../../assets/Login.jpg" alt="Ilustrasi Login" style="max-width: 300px;">
        </div>
    </div>

    <script>
        function resetForm() {
            document.getElementById('loginForm').reset();
            document.getElementById('username').focus();
        }

        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.style.transform = 'translateX(5px)';
            });
            input.addEventListener('blur', () => {
                input.parentElement.style.transform = 'translateX(0)';
            });
        });
    </script>
</body>
</html>