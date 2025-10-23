<?php
// Halaman publik — tidak ada logika auth di sini
// Semua koneksi ke Supabase dilakukan via JavaScript di sisi client (jika diperlukan nanti)
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Simpelsi - Berawal dari foto, Berakhir pada Kelestarian</title>
    <style>
        /* === SAMA PERSIS DENGAN CSS ANDA === */
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
            flex-direction: column;
            transition: background 0.5s ease;
            opacity: 0; /* Untuk animasi fade-in */
        }

        /* === HEADER === */
        .header {
            background: #1a8c1a;
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
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

        .nav-menu {
            display: flex;
            gap: 30px;
        }

        .nav-item, .nav-login {
            color: white;
            font-size: 1.1em;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .nav-item:hover, .nav-login:hover {
            color: #ffeb3b;
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        .nav-login img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }

        /* === MAIN CONTENT === */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            background: #f9f9f9;
        }

        .content-placeholder {
            width: 100%;
            max-width: 800px;
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .content-placeholder h2 {
            color: #1a8c1a;
            font-size: 2em;
            margin-bottom: 20px;
        }

        .content-placeholder p {
            color: #555;
            font-size: 1.1em;
            line-height: 1.6;
        }

        /* === FOOTER === */
        .footer {
            background: linear-gradient(to right, #1a8c1a, #1e7e1e);
            padding: 40px 30px;
            color: white;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 40px;
            box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .footer-section {
            flex: 1;
            min-width: 250px;
        }

        .footer-title {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #fff;
        }

        .footer-text {
            font-size: 0.9em;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #e0f0e0;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: #ffeb3b;
            text-decoration: underline;
        }

        .social-media {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .social-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            overflow: hidden;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .subscribe {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .subscribe input {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-size: 0.9em;
            flex: 1;
        }

        .subscribe button {
            background: white;
            color: #1a8c1a;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .copyright {
            font-size: 0.8em;
            color: #d0f0d0;
            margin-top: 20px;
        }

        /* === RESPONSIVE === */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                padding: 12px 20px;
            }
            .nav-menu {
                width: 100%;
                justify-content: space-around;
                flex-wrap: wrap;
            }
            .nav-item, .nav-login {
                padding: 8px 10px;
                font-size: 0.9em;
            }
            .footer {
                flex-direction: column;
                padding: 30px 20px;
            }
            .footer-section {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <img src="assets/logo.jpg" alt="Logo Simpelsi" class="header-logo">
            <div class="header-title">SIMPELSI</div>
        </div>
        <div class="nav-menu">
            <a href="#" class="nav-item">Beranda</a>
            <a href="#" class="nav-item">Profil</a>
            <a href="#" class="nav-item">Visi & Misi</a>
            <a href="#" class="nav-item">Download APK</a>
            <!-- Tombol Login: arahkan ke login.php -->
            <a href="login.php" class="nav-login">
                <img src="assets/user-avatar.jpg" alt="Login Icon">
                <span>Login</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-placeholder">
            <h2>Selamat Datang di Simpelsi</h2>
            <p>Berawal dari foto, Berakhir pada Kelestarian. Langkah kecil memberikan dampak besar pada pelestarian lingkungan.</p>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-section">
            <div class="footer-title">Simpelsi</div>
            <div class="footer-text">
                Berawal dari foto, Berakhir pada Kelestarian. Langkah kecil memberikan dampak besar pada pelestarian lingkungan.
            </div>
            <div class="copyright">
                © 2025 Simpelsi All rights reserved
            </div>
        </div>
        <div class="footer-section">
            <div class="footer-title">Navigasi</div>
            <ul class="footer-links">
                <li><a href="#">Beranda</a></li>
                <li><a href="#">Profil</a></li>
                <li><a href="#">Visi & Misi</a></li>
                <li><a href="#">Download APK</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <div class="footer-title">Social Media</div>
            <div class="social-media">
                <img src="assets/instagram-icon.jpg" alt="Instagram" class="social-icon">
                <img src="assets/facebook-icon.jpg" alt="Facebook" class="social-icon">
                <img src="assets/youtube-icon.jpg" alt="YouTube" class="social-icon">
            </div>
            <div class="footer-title">Subscribe</div>
            <div class="subscribe">
                <input type="email" placeholder="Enter email address">
                <button>Send</button>
            </div>
        </div>
    </div>

    <script>
        // Fade-in halaman
        document.addEventListener('DOMContentLoaded', () => {
            document.body.style.opacity = '1';
        });

        // Efek header saat scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 50) {
                header.style.boxShadow = '0 4px 12px rgba(0,0,0,0.2)';
                header.style.background = '#156b15';
            } else {
                header.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
                header.style.background = '#1a8c1a';
            }
        });

        // Animasi footer saat muncul di viewport
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        observer.observe(document.querySelector('.footer'));

        // Efek hover pada elemen interaktif
        document.querySelectorAll('.nav-item, .nav-login, .social-icon, .subscribe button')
            .forEach(el => {
                el.addEventListener('mouseenter', () => el.style.transform = 'scale(1.05)');
                el.addEventListener('mouseleave', () => el.style.transform = 'scale(1)');
            });
    </script>
</body>
</html>