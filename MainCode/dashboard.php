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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
            background: white;
            flex: 1;
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
            font-weight: bold;
        }

        .nav-logo img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            object-fit: cover;
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

        /* Home Section */
        .home-content {
            display: flex;
            align-items: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .home-text {
            flex: 1;
            min-width: 300px;
        }

        .home-image {
            flex: 1;
            min-width: 300px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .home-image img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            animation: waveImage 4s ease-in-out infinite;
            transform-origin: bottom;
            display: block;
        }

        /* Profil Section */
        .profil-content {
            display: flex;
            align-items: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .profil-text {
            flex: 1;
            min-width: 300px;
        }

        .profil-logo {
            flex: 1;
            min-width: 300px;
            text-align: center;
        }

        .profil-logo img:first-child {
            max-width: 250px;
            height: auto;
            border-radius: 50%;
        }

        .profil-logo img:last-child {
            width: 70px;
            height: 40px;
            margin-top: 15px;
        }

        /* Visi & Misi */
        .visimisi-content {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 0 10px;
            width: 100%;
        }

        .visimisi-columns {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
        }

        .visimisi-column {
            flex: 1;
            min-width: 300px;
            background: #f9f9f9;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #2e8b57;
        }

        .visimisi-column h2 {
            color: #2e8b57;
            font-size: 22px;
            margin-bottom: 15px;
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

        .feature-icon img {
            width: 40px;
            height: 40px;
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
        .download-section-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 1000px;
            gap: 40px;
        }

        .download-text {
            text-align: center;
            max-width: 600px;
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

        /* Footer (UKURAN PERSIS SEPERTI NAVBAR) */
        .footer-nav-style {
            width: 100%;
            background: #2e8b57;
            color: white;
            padding: 12px 30px; /* SAMA PERSIS DENGAN NAVBAR */
            box-shadow: 0 -2px 5px rgba(0,0,0,0.05);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin-top: 40px;
        }

        .footer-col {
            flex: 1;
            min-width: 200px;
        }

        .footer-col h3 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .footer-col p {
            line-height: 1.5;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .footer-col p.copyright {
            font-size: 12px;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .footer-col a {
            color: white;
            text-decoration: none;
            font-size: 13px;
            display: block;
            margin-bottom: 6px;
        }

        .footer-col a:hover {
            color: #ffeb3b;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-bottom: 10px;
        }

        .social-icons a {
            color: white;
            font-size: 18px;
            text-decoration: none;
        }

        .subscribe-form {
            display: flex;
            gap: 10px;
            max-width: 300px;
        }

        .subscribe-form input {
            padding: 6px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            flex: 1;
            font-size: 13px;
        }

        .subscribe-form button {
            background: white;
            color: #2e8b57;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
        }

        .subscribe-form button:hover {
            background: #f0f0f0;
        }

        /* Animasi */
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

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Responsive */
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

            .footer-nav-style {
                flex-direction: column;
                gap: 15px;
                padding: 12px 20px;
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
            <a href="#fitur">Fitur</a>
            <a href="#jenis">Jenis Sampah</a>
            <a href="#download">Pengaduan Laporan</a>
        </div>
        <div class="nav-login" id="loginBtn">LOGIN</div>
    </div>

    <!-- Home -->
    <div class="section" id="home">
        <div class="content home-content">
            <div class="home-text">
                <h1>Halo, Sahabat SIMPELSI!</h1>
                <p>
                    SIMPELSI adalah Sistem Pelaporan Sampah Ilegal. Ayo, mari kita mulai pelaporan kita lewat laporan ini untuk menghindari dampak buruk terhadap lingkungan. Setiap tindakan kecil akan membuat perbedaan besar dalam menjaga lingkungan.
                </p>
                <a href="#profil" class="btn-green">Mulai</a>
            </div>
            <div class="home-image">
                <img src="/assets/banner.png" alt="Ilustrasi SIMPELSI">
            </div>
        </div>
    </div>

    <!-- Profil -->
    <div class="section" id="profil">
        <div class="content profil-content">
            <div class="profil-text">
                <h1>Profil</h1>
                <p>
                    Dinas Lingkungan Hidup merupakan instansi pemerintah yang bertugas membantu kepala daerah dalam melaksanakan urusan pemerintahan di bidang lingkungan hidup yang menjadi kewenangan Daerah dan tugas pembantuan yang diberikan pada Daerah sesuai dengan visi, misi dan program Walikota ekologisasi wilayah dalam Rencana Pembangunan Jangka Menengah Daerah.
                </p>
                <a href="#visimisi" class="btn-green">Baca Visi & Misi →</a>
            </div>
            <div class="profil-logo">
                <img src="/assets/logo_dlh.jpg" alt="Logo DLH">
                <img src="/assets/Dlh.png" alt="Logo DLH Kecil">
            </div>
        </div>
    </div>

    <!-- Visi & Misi -->
    <div class="section" id="visimisi">
        <div class="content visimisi-content">
            <h1>Visi & Misi</h1>
            <div class="visimisi-columns">
                <div class="visimisi-column">
                    <h2>Visi</h2>
                    <p>
                        Terwujudnya lingkungan hidup yang bersih dan sehat melalui pengelolaan sampah secara terpadu, berkelanjutan, dan partisipatif untuk mewujudkan Kabupaten Negara yang ekologis dan berkelanjutan.
                    </p>
                </div>
                <div class="visimisi-column">
                    <h2>Misi</h2>
                    <p>
                        1. Meningkatkan kesadaran masyarakat dalam pengelolaan sampah melalui edukasi dan kampanye lingkungan.<br>
                        2. Memperkuat sistem pengelolaan sampah dari hulu ke hilir secara terintegrasi.<br>
                        3. Mendorong inovasi teknologi dan partisipasi masyarakat dalam penanganan sampah.<br>
                        4. Menyediakan layanan pelaporan sampah ilegal yang mudah, cepat, dan transparan.<br>
                        5. Membangun kerjasama lintas sektor untuk mencapai target pengurangan sampah.
                    </p>
                </div>
            </div>
            <div style="text-align: center; margin-top: 20px; width: 100%;">
                <a href="#download" class="download-btn" style="padding: 12px 24px; font-size: 16px;">Download APK →</a>
            </div>
        </div>
    </div>

    <!-- Fitur -->
    <div class="section" id="fitur">
        <div class="content">
            <h1>FITUR</h1>
            <p>Inovasi Fitur SIMPELSI</p>
            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon"><img src="/assets/lapor_sampah.png" alt=""></div>
                    <div class="feature-title">LAPOR SAMPAH ILEGAL</div>
                    <p>Bagikan foto sampah ke Aplikasi Simpelsi, dan arahkan letak sampah yang ada di sekitarmu.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><img src="/assets/informasi_tps.png" alt=""></div>
                    <div class="feature-title">INFORMASI LOKASI TPS</div>
                    <p>Simpelsi memudahkan informasi tempat tertang lokasi TPS Di Kabupaten Negara.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><img src="/assets/artikel_edukasi.png" alt=""></div>
                    <div class="feature-title">ARTIKEL EDUKASI</div>
                    <p>Menemukan pengumpulan sampah EcoSorted terdekat di wilayahmu.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Jenis Sampah -->
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

    <!-- Download + Footer (Footer ukuran navbar, muncul setelah tombol download) -->
    <div class="section" id="download">
        <div class="content download-section-content">
            <div class="download-text">
                <h1>Download Aplikasi</h1>
                <p>Simpelsi adalah platform yang memudahkan pelaporan sampah ilegal dengan perangkat mobile/smartphone yang bisa diakses online.</p>
                <a href="#" class="download-btn">DOWNLOAD APK</a>
            </div>

            <!-- FOOTER UKURAN PERSIS NAVBAR -->
            <div class="footer-nav-style">
                <div class="footer-col">
                    <h3>Simpelsi</h3>
                    <p>
                        Bersih dari Info. Bersih dari Keluhan. Langkah kecil memberikan dampak besar pada pelestarian lingkungan.
                    </p>
                    <p class="copyright">©2025 Simpelsi All rights reserved.</p>
                </div>

                <div class="footer-col">
                    <h3>Menu</h3>
                    <a href="#home">Beranda</a>
                    <a href="#profil">Profil</a>
                    <a href="#fitur">Fitur</a>
                    <a href="#jenis">Jenis Sampah</a>
                    <a href="#download">Pengaduan Laporan</a>
                </div>

                <div class="footer-col">
                    <h3>Social Media</h3>
                    <div class="social-icons">
                        <a href="#">📱</a>
                        <a href="#">📘</a>
                        <a href="#">🐦</a>
                    </div>
                    <div class="subscribe-form">
                        <input type="email" placeholder="Email Anda">
                        <button>Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Smooth scroll
        document.querySelectorAll('.nav-menu a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                document.querySelector(targetId).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Login redirect
        document.getElementById('loginBtn').addEventListener('click', function() {
            window.location.href = 'login/login.php';
        });
    </script>
</body>

</html>