<?php
session_start();
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        // Redirect via JS untuk animasi
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                const card = document.querySelector(".login-card");
                card.style.transition = "transform 0.6s ease, opacity 0.6s ease";
                card.style.transform = "scale(0.95)";
                card.style.opacity = "0.8";
                setTimeout(() => {
                    window.location.href = "dashboard.php";
                }, 600);
            });
        </script>';
        exit();
    } else {
        $message = '<div class="alert error">❌ Username atau password salah.</div>';
    }
}
?>

<!-- kodingan HTML-->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Admin Simpelsi</title>
    <!-- kodingan CSS-->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            transition: background 0.5s ease;
        }

        /* === HEADER === */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: #1a8c1a;
            padding: 12px 30px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            z-index: 10;
        }

        .header-logo {
            width: 40px;
            height: 40px;
            margin-right: 10px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }

        .header-logo:hover {
            transform: rotate(10deg) scale(1.05);
        }

        .header-title {
            color: white;
            font-size: 1.3em;
            font-weight: bold;
        }

        /* === LOGIN CARD === */
        .login-card {
            background: #e6ffe6; /* hijau muda */
            padding: 35px 40px;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
            margin-top: 80px;
            transition: all 0.4s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        /* Judul Login */
        .login-title {
            font-size: 26px;
            color: #1a8c1a; /* hijau tua */
            font-weight: bold;
            margin-bottom: 10px;
            line-height: 1.2;
            transition: color 0.3s ease;
        }

        .login-title:hover {
            color: #156b15;
        }

        .login-title span {
            display: block;
            font-size: 24px;
            font-weight: normal;
            color: #1a8c1a;
        }

        /* === FORM INPUT === */
        .form-group {
            text-align: left;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .form-group:hover {
            transform: translateX(3px);
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #333;
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            box-shadow: 0 2px 12px rgba(26, 140, 26, 0.3);
            transform: scale(1.02);
            background: #f8fff8;
        }

        /* === BUTTONS === */
        .btn-login {
            background: #1a8c1a;
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
            position: relative;
            overflow: hidden;
        }

        .btn-login:before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn-login:hover:before {
            left: 100%;
        }

        .btn-login:hover {
            background: #156b15;
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(26, 140, 26, 0.3);
        }

        .btn-login:active {
            transform: scale(0.98);
        }

        .btn-reset {
            background: white;
            color: #555;
            border: 2px solid #ddd;
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            background: #f5f5f5;
            border-color: #1a8c1a;
            color: #1a8c1a;
            transform: scale(1.02);
        }

        .btn-reset:active {
            transform: scale(0.98);
        }

        /* === ALERT === */
        .alert {
            padding: 10px;
            border-radius: 8px;
            margin-top: 20px;
            font-weight: 600;
            animation: fadeInUp 0.6s ease;
            position: relative;
            overflow: hidden;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* === RESPONSIVE === */
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 25px;
                margin-top: 100px;
            }
            .login-title {
                font-size: 22px;
            }
            .login-title span {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="logo.jpg" alt="Logo Simpelsi" class="header-logo">
        <div class="header-title">SIMPELSI</div>
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
        <form method="POST" id="loginForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="admin" required autocomplete="off" />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="admin123" required />
            </div>
            <button type="submit" class="btn-login">Login</button>
            <button type="button" class="btn-reset" onclick="resetForm()">Reset Password?</button>
        </form>
    </div>

    
     <!-- kodingan JS-->
    <script>
        // Fungsi reset form
        function resetForm() {
            document.getElementById('loginForm').reset();
            document.getElementById('username').focus();
        }

        // Animasi saat submit gagal
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const alertDiv = document.querySelector('.alert');

            if (alertDiv && alertDiv.classList.contains('error')) {
                passwordInput.focus();
                passwordInput.select();

                // Efek shake pada form
                const loginCard = document.querySelector('.login-card');
                loginCard.style.animation = 'shake 0.5s';
                setTimeout(() => {
                    loginCard.style.animation = '';
                }, 500);

                // Efek background berkedip merah
                document.body.style.background = '#ffebeb';
                setTimeout(() => {
                    document.body.style.background = '#ffffff';
                }, 800);
            }
        });

        // Animasi tombol login saat di-klik
        document.querySelector('.btn-login').addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('loginForm');
            const btn = this;

            // Efek loading
            btn.textContent = 'Logging in...';
            btn.style.opacity = '0.8';
            btn.style.cursor = 'wait';

            // Submit form setelah 1 detik
            setTimeout(() => {
                form.submit();
            }, 1000);
        });

        // Efek hover pada input
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
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