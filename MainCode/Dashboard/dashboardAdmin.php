<?php
// Tidak ada logika login di sini — hanya tampilan
// Jika ingin cek session, bisa ditambahkan nanti
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard Admin Simpelsi</title>
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
            flex-direction: column;
            transition: background 0.5s ease;
        }

        /* === HEADER === */
        .header {
            background: #1a8c1a;
            padding: 15px 30px;
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
            gap: 15px;
        }

        .header-logo {
            width: 60px;
            height: 60px;
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
            font-size: 2em;
            font-weight: bold;
        }

        .header-subtitle {
            color: white;
            font-size: 1.2em;
            font-weight: normal;
            margin-top: 5px;
        }

        .exit-btn {
            background: white;
            color: #1a8c1a;
            border: 2px solid #1a8c1a;
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .exit-btn:hover {
            background: #e6ffe6;
            transform: scale(1.05);
        }

        /* === MAIN CONTENT === */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            background: #f5f5f5;
        }

        .dashboard-container {
            width: 100%;
            max-width: 1200px;
            padding: 30px;
            background: #dcedd1; /* hijau muda */
            border: 2px solid #1a8c1a;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .section-title {
            text-align: center;
            color: #1a8c1a;
            font-size: 2.5em;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .feature-card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            min-height: 300px;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0,0,0,0.1);
        }

        .feature-icon {
            width: 120px;
            height: 120px;
            margin: 20px auto;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .feature-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }

        .feature-title {
            color: #1a8c1a;
            font-size: 1.4em;
            font-weight: bold;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .feature-desc {
            color: #333;
            font-size: 1.1em;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .select-btn {
            background: #1a8c1a;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .select-btn:hover {
            background: #156b15;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        /* === RESPONSIVE === */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                padding: 15px 20px;
            }
            .header-title {
                font-size: 1.8em;
            }
            .header-subtitle {
                font-size: 1em;
            }
            .dashboard-container {
                padding: 20px;
                margin: 10px;
            }
            .section-title {
                font-size: 2em;
            }
            .feature-card {
                min-height: auto;
                padding: 20px;
            }
            .feature-icon {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <img src="assets/logo.jpg" alt="Logo Simpelsi" class="header-logo">
            <div>
                <div class="header-title">Dashboard</div>
                <div class="header-subtitle">ADMIN</div>
            </div>
        </div>
        <button class="exit-btn" onclick="logout()">
            <img src="assets/exit-icon.png" alt="Exit" style="width:24px;height:24px;">
            EXIT
        </button>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-container">
            <h1 class="section-title">Fitur</h1>
            <div class="features-grid">
                <!-- Fitur 1: Kelola Laporan Aduan -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="assets/clipboard-check.png" alt="Laporan Aduan">
                    </div>
                    <div class="feature-title">Kelola<br>Laporan Aduan</div>
                    <button class="select-btn" onclick="goTo('laporan-aduan')">Pilih</button>
                </div>

                <!-- Fitur 2: Kelola Artikel Edukasi -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="assets/article-edit.png" alt="Artikel Edukasi">
                    </div>
                    <div class="feature-title">Kelola<br>Artikel Edukasi</div>
                    <button class="select-btn" onclick="goTo('artikel-edukasi')">Pilih</button>
                </div>

                <!-- Fitur 3: Kelola Informasi TPS -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="assets/recycle-bin.png" alt="Informasi TPS">
                    </div>
                    <div class="feature-title">Kelola<br>Informasi TPS</div>
                    <button class="select-btn" onclick="goTo('informasi-tps')">Pilih</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi logout → kembali ke halaman login
        function logout() {
            if (confirm('Anda yakin ingin keluar?')) {
                window.location.href = 'login/login.php';
            }
        }

        // Fungsi navigasi ke halaman fitur (contoh)
        function goTo(feature) {
            alert(`Anda memilih: ${feature}`);
            // Ganti dengan redirect ke halaman nyata
            // Contoh: window.location.href = `features/${feature}.php`;
        }

        // Efek hover pada tombol exit
        document.querySelector('.exit-btn').addEventListener('mouseenter', () => {
            document.querySelector('.exit-btn').style.transform = 'scale(1.05)';
        });
        document.querySelector('.exit-btn').addEventListener('mouseleave', () => {
            document.querySelector('.exit-btn').style.transform = 'scale(1)';
        });

        // Animasi fade-in saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            document.body.style.opacity = '1';
            document.body.style.transition = 'opacity 0.8s ease';
        });

        document.body.style.opacity = '0';
    </script>
</body>
</html>