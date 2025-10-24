<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPELSI - Portofolio Interaktif</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            overflow-x: hidden;
        }

        .section {
            height: auto;
            min-height: 100vh;
            width: 100%;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            scroll-snap-align: start;
            background: white;
        }

        /* Navbar */
        .navbar {
            background: #2e8b57;
            color: white;
            padding: 12px 30px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-logo img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #2e8b57;
        }

        .nav-menu {
            display: flex;
            gap: 20px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-menu a:hover {
            color: #ffeb3b;
        }

        .nav-login {
            background: #ff6347;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .nav-login:hover {
            background: #ff4500;
        }

        /* Konten utama */
        .content {
            max-width: 1000px;
            width: 100%;
            margin-top: 80px;
            /* agar tidak tertutup navbar */
        }

        h1 {
            color: #2e8b57;
            margin-bottom: 15px;
            font-size: 28px;
        }

        p {
            line-height: 1.6;
            margin-bottom: 20px;
            color: #333;
        }

        .btn-green {
            background: #2e8b57;
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 15px;
            transition: background 0.2s;
        }

        .btn-green:hover {
            background: #226b42;
        }

        /* Fitur Section */
        .features {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .feature-card {
            background: #e6f2e6;
            padding: 20px;
            border-radius: 12px;
            width: 250px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            background: #2e8b57;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .feature-title {
            font-size: 16px;
            color: #2e8b57;
            margin-bottom: 10px;
            font-weight: bold;
        }

        /* Jenis Sampah */
        .waste-types {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .waste-item {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .waste-icon {
            font-size: 32px;
            margin-bottom: 10px;
            color: #2e8b57;
        }

        .waste-name {
            font-weight: bold;
            color: #2e8b57;
        }

        /* Download Section */
        .download-section {
            text-align: center;
            margin-top: 30px;
        }

        .download-btn {
            background: #2e8b57;
            color: white;
            padding: 15px 30px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 18px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: background 0.2s;
        }

        .download-btn:hover {
            background: #226b42;
        }

        /* Footer */
        .footer {
            background: #2e8b57;
            color: white;
            padding: 30px 20px;
            width: 100%;
            margin-top: 40px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
        }

        .footer-col {
            flex: 1;
            min-width: 200px;
        }

        .footer-col h3 {
            margin-bottom: 15px;
            font-size: 18px;
        }

        .footer-col p {
            line-height: 1.6;
            font-size: 14px;
        }

        .social-icons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .social-icons a {
            color: white;
            font-size: 20px;
            text-decoration: none;
        }

        .subscribe {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .subscribe input {
            padding: 8px;
            border-radius: 5px;
            border: none;
            flex: 1;
        }

        .subscribe button {
            background: white;
            color: #2e8b57;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
            scroll-snap-type: y mandatory;
        }

        @media (max-width: 768px) {
            .nav-menu {
                gap: 10px;
                font-size: 12px;
            }

            .content {
                padding: 20px;
            }

            .feature-card {
                width: 100%;
            }
        }

        @keyframes waveImage {
            0% {
                transform: scaleY(1) skewY(0deg);
            }

            50% {
                transform: scaleY(1.03) skewY(3deg);
            }

            100% {
                transform: scaleY(1) skewY(0deg);
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="nav-logo">
            <img src="/assets/logo.jpg" alt="Logo SIMPELSI">
            <span>SIMPELSI</span>
        </div>
        <div class="nav-menu">
            <a href="#home">Beranda</a>
            <a href="#profil">Profil</a>
            <a href="#fitur">Visi & Misi</a>
            <a href="#jenis">Jenis Sampah</a>
            <a href="#download">Pengaduan Laporan</a>
        </div>
        <div class="nav-login" id="loginBtn">LOGIN</div>
    </div>

    <div class="section" id="home">
        <div class="content" style="display: flex; align-items: center; gap: 40px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 300px;">
                <h1 style="color: #2e8b57; font-size: 28px; margin-bottom: 15px;">Halo, Sahabat SIMPELSI!</h1>
                <p style="line-height: 1.6; color: #333; margin-bottom: 20px;">
                    SIMPELSI adalah Sistem Pelaporan Sampah Ilegal. Ayo, mari kita mulai pelaporan kita lewat laporan ini untuk menghindari dampak buruk terhadap lingkungan. Setiap tindakan kecil akan membuat perbedaan besar dalam menjaga lingkungan.
                </p>
                <a href="#" class="btn-green">Mulai</a>
            </div>

            <div style="flex: 1; min-width: 300px; text-align: center; position: relative; overflow: hidden;">
                <img src="/assets/banner.png" alt="Ilustrasi SIMPELSI" style="
                max-width: 100%;
                height: auto;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                animation: waveImage 4s ease-in-out infinite;
                transform-origin: bottom;
                display: block;
            ">
            </div>
        </div>
    </div>

    <!-- Slide 2: Profil & Visi Misi -->
    <div style="flex: 1; min-width: 300px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 20px; margin-top: 40px;">
        <img src="https://i.imgur.com/2wGzWmK.png" alt="Logo DLH" style="
        max-width: 250px;
        height: auto;
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        ">
        <img src="https://i.imgur.com/6LpYQ7F.png" alt="DLH Logo" style="
        max-width: 180px;
        height: auto;
        margin-top: 10px;
        ">
    </div>

    <!-- Slide 3: Fitur -->
    <div class="section" id="fitur">
        <div class="content">
            <h1>FITUR</h1>
            <p>Inovasi Fitur SIMPELSI</p>
            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon">📋</div>
                    <div class="feature-title">LAPOR SAMPAH ILEGAL</div>
                    <p>Bagikan foto sampah ke Aplikasi Simpelsi, dan arahkan letak sampah yang ada di sekitarmu.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📍</div>
                    <div class="feature-title">INFORMASI LOKASI TPS</div>
                    <p>Simpelsi memudahkan informasi tempat tertang lokasi TPS Di Kabupaten Negara.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📰</div>
                    <div class="feature-title">ARTIKEL EDUKASI</div>
                    <p>Menemukan pengumpulan sampah EcoSorted terdekat di wilayahmu.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 4: Jenis Sampah -->
    <div class="section" id="jenis">
        <div class="content">
            <h1>JENIS SAMPAH</h1>
            <p>Berbagai jenis sampah yang dapat dilaporkan</p>
            <div class="waste-types">
                <div class="waste-item">
                    <div class="waste-icon">📄</div>
                    <div class="waste-name">Kertas</div>
                </div>
                <div class="waste-item">
                    <div class="waste-icon">🥤</div>
                    <div class="waste-name">Plastik</div>
                </div>
                <div class="waste-item">
                    <div class="waste-icon">📦</div>
                    <div class="waste-name">Kardus</div>
                </div>
                <div class="waste-item">
                    <div class="waste-icon">🍷</div>
                    <div class="waste-name">Kaca</div>
                </div>
                <div class="waste-item">
                    <div class="waste-icon">⚙️</div>
                    <div class="waste-name">Logam</div>
                </div>
                <div class="waste-item">
                    <div class="waste-icon">🌿</div>
                    <div class="waste-name">Organik</div>
                </div>
                <div class="waste-item">
                    <div class="waste-icon">🗑️</div>
                    <div class="waste-name">Lainnya</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 5: Download APK + Footer -->
    <div class="section" id="download">
        <div class="content">
            <h1>Download Aplikasi</h1>
            <p>Simpelsi adalah platform yang memudahkan pelaporan sampah ilegal dengan perangkat mobile/smartphone yang bisa diakses online.</p>
            <a href="#" class="download-btn">DOWNLOAD APK</a>
        </div>

        <div class="footer">
            <div class="footer-col">
                <h3>Simpelsi</h3>
                <p>Bersih dari Info. Bersih dari Keluhan. Langkah kecil memberikan dampak besar pada pelestarian lingkungan.</p>
                <p>©2025 Simpelsi All rights reserved.</p>
            </div>
            <div class="footer-col">
                <h3>Simpelsi</h3>
                <p><a style="color:white; text-decoration:none;">Home</a></p>
                <p><a style="color:white; text-decoration:none;">Informasi</a></p>
                <p><a style="color:white; text-decoration:none;">Layanan</a></p>
            </div>
            <div class="footer-col">
                <h3>Social Media</h3>
                <div class="social-icons">
                    <a>📱</a>
                    <a>📘</a>
                    <a>🐦</a>
                </div>
                <div class="subscribe">
                    <input type="email" placeholder="Email Anda">
                    <button>Send</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Scroll smooth ke section
        document.querySelectorAll('.nav-menu a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                document.querySelector(targetId).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // 🔗 Arahkan tombol LOGIN ke halaman login admin
        document.getElementById('loginBtn').addEventListener('click', function() {
            window.location.href = 'login/login.php';
        });
    </script>
</body>

</html>