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
            background: linear-gradient(to right, #20A726, #095E0D);
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
            background: linear-gradient(to right, #20A726, #095E0D);
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid white;
        }

        .nav-login:hover {
            background: linear-gradient(to right, #095E0D, #20A726);
            transform: scale(1.05);
        }

        /* Konten utama */
        .content {
            max-width: 1000px;
            width: 100%;
            margin-top: 80px;
        }

        h1 {
            color: #095E0D;
            margin-bottom: 15px;
            font-size: 28px;
        }

        p {
            line-height: 1.6;
            margin-bottom: 20px;
            color: #333;
        }

        .btn-green,
        .download-btn {
            background: linear-gradient(to right, #20A726, #095E0D);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 15px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 8px rgba(9, 94, 13, 0.3);
        }

        .btn-green:hover,
        .download-btn:hover {
            background: linear-gradient(to right, #095E0D, #20A726);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(9, 94, 13, 0.4);
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
            border-left: 4px solid #095E0D;
        }

        .visimisi-column h2 {
            color: #095E0D;
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
            background: #f0f9f0;
            padding: 20px;
            border-radius: 12px;
            width: 250px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            border-top: 3px solid #20A726;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            background: linear-gradient(to right, #20A726, #095E0D);
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
            filter: invert(1);
        }

        .feature-title {
            font-size: 16px;
            color: #095E0D;
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
            background: #f0f9f0;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #20A726;
        }

        .waste-icon {
            font-size: 32px;
            margin-bottom: 10px;
            color: #095E0D;
        }

        .waste-name {
            font-weight: bold;
            color: #095E0D;
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

        /* === FOOTER BAWAH BARU === */
        .footer-bottom {
            background: linear-gradient(to right, #095E0D, #053a08);
            color: white;
            padding: 40px 20px;
            margin-top: 40px;
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.9s ease-out, transform 0.9s ease-out;
            position: relative;
            z-index: 5;
        }

        .footer-bottom.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: space-between;
        }

        .footer-col {
            flex: 1;
            min-width: 250px;
        }

        .footer-col h3 {
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .footer-col p {
            line-height: 1.6;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .footer-col .copyright {
            font-size: 12px;
            opacity: 0.9;
            margin-top: 15px;
        }

        .footer-col ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-col ul li {
            margin-bottom: 8px;
        }

        .footer-col ul li a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .footer-col ul li a:hover {
            color: #20A726;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .social-icons a img {
            width: 24px;
            height: 24px;
            filter: brightness(0) invert(1);
        }

        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                gap: 20px;
            }

            .footer-col {
                min-width: 100%;
            }

            .footer-bottom {
                padding: 30px 15px;
            }

            .footer-col h3 {
                font-size: 16px;
            }

            .footer-col p {
                font-size: 13px;
            }

            .social-icons a img {
                width: 20px;
                height: 20px;
            }
        }

        /* Animasi */
        @keyframes waveImage {
            0% { transform: scaleY(1) skewY(0deg); }
            50% { transform: scaleY(1.03) skewY(3deg); }
            100% { transform: scaleY(1) skewY(0deg); }
        }

        html { scroll-behavior: smooth; }

        @media (max-width: 768px) {
            .nav-menu { gap: 10px; font-size: 12px; }
            .content { padding: 20px; }
            .feature-card { width: 100%; }
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
            <a href="#main-footer" id="report-link">Pengaduan Laporan</a>
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
        <div class="profil-logo" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
            <img src="/assets/logo_dlh.jpg" alt="Logo DLH" style="max-width: 250px; height: auto; border-radius: 50%;">
            <img src="/assets/Dlh.png" alt="Logo DLH Kecil" style="width: 70px; height: 40px;">
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
                <a href="#main-footer" class="download-btn" style="padding: 12px 24px; font-size: 16px;">Download APK →</a>
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

   <!-- Download -->
<div class="section" id="download" style="min-height: auto; padding: 30px 20px;">
    <div class="content" style="max-width: 800px; text-align: center;">
        <h1>Download Aplikasi</h1>
        <p style="margin: 12px 0 24px;">
            Simpelsi adalah platform yang memudahkan pelaporan sampah ilegal dengan perangkat mobile/smartphone yang bisa diakses online.
        </p>
        <a href="#main-footer" class="download-btn">DOWNLOAD APK</a>
    </div>
</div>

    <!-- FOOTER BAWAH -->
    <footer id="main-footer" class="footer-bottom">
        <div class="footer-container">
            <div class="footer-col">
                <h3>Simpelsi</h3>
                <p>Berawal dari foto, Berakhir pada Kelestarian. Langkah kecil memberikan dampak besar pada pelestarian lingkungan.</p>
                <p class="copyright">©2025 Simpelsi All rights reserved.</p>
            </div>

            <div class="footer-col">
                <h3>Menu</h3>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#profil">Informasi</a></li>
                    <li><a href="#fitur">Layanan</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>Social Media</h3>
                <div class="social-icons">
                    <a href="#" aria-label="Instagram">
                        <img src="https://cdn-icons-png.flaticon.com/512/174/174855.png  " alt="Instagram" width="24">
                    </a>
                    <a href="#" aria-label="Facebook">
                        <img src="https://cdn-icons-png.flaticon.com/512/174/174848.png  " alt="Facebook" width="24">
                    </a>
                    <a href="#" aria-label="YouTube">
                        <img src="https://cdn-icons-png.flaticon.com/512/174/174856.png  " alt="YouTube" width="24">
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll untuk semua link internal
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Login redirect
        document.getElementById('loginBtn').addEventListener('click', function() {
            window.location.href = 'login/login.php';
        });

        // Animasi footer: muncul saat terlihat di viewport
        const footer = document.getElementById('main-footer');

        function checkFooterVisibility() {
            const rect = footer.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            if (rect.top <= windowHeight * 0.9) {
                footer.classList.add('visible');
            }
        }

        // Pastikan animasi jalan saat di-scroll ke footer via klik
        function forceFooterVisible() {
            setTimeout(() => {
                footer.classList.add('visible');
            }, 300);
        }

        window.addEventListener('scroll', checkFooterVisibility);
        window.addEventListener('load', checkFooterVisibility);

        // Saat klik link ke footer → pastikan animasi muncul
        document.querySelectorAll('a[href="#main-footer"]').forEach(link => {
            link.addEventListener('click', forceFooterVisible);
        });
        
    </script>
</body>

</html>