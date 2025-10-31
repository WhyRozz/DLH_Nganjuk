<?php
//session_start();
// 🔒 Proteksi: hanya admin yang sudah login yang boleh akses
//if (!isset($_SESSION['admin_id'])) {
//    header("Location: ../login/login.php");
//    exit;
//}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIMPELSI</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            display: flex;
            min-height: 100vh;
        }

        /* Header */
        .header {
            width: 100%;
            background: #2e8b57;
            color: white;
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-logo {
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

        .header-exit {
            background: white;
            color: #2e8b57;
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #e6e6e6;
            padding: 80px 20px 20px;
            position: fixed;
            top: 60px;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }

        .sidebar-menu {
            list-style: none;
        }

        .menu-item {
            padding: 15px 20px;
            margin-bottom: 10px;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #333;
        }

        .menu-item:hover {
            background: #f0f0f0;
        }

        .menu-item.active {
            background: #2e8b57;
            color: white;
            border: 2px solid white;
        }

        .menu-icon {
            width: 30px;
            height: 30px;
            background: #2e8b57;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .menu-item.active .menu-icon {
            background: white;
            color: #2e8b57;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 80px 30px 30px;
            background: white;
        }

        .content-header {
            margin-bottom: 20px;
        }

        .content-header h2 {
            color: #2e8b57;
            font-size: 24px;
        }

        /* Statistik Section */
        .stats-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .stats-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .stats-header h3 {
            color: #2e8b57;
            font-size: 18px;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
        }

        .filter-btn {
            background: #e6f2e6;
            border: 1px solid #2e8b57;
            color: #2e8b57;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn.active {
            background: #2e8b57;
            color: white;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #2e8b57;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
        }

        .trend-chart {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .trend-chart h4 {
            color: #2e8b57;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .mini-bar-chart {
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            height: 80px;
            gap: 5px;
        }

        .bar {
            width: 20px;
            background: #2e8b57;
            color: white;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2px 0;
            border-radius: 3px 3px 0 0;
            transition: height 0.3s ease;
        }

        .bar:hover {
            opacity: 0.8;
        }

        .recent-reports {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .recent-reports h4 {
            color: #2e8b57;
            margin-bottom: 10px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #e6f2e6;
            font-weight: bold;
        }

        .status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }

        .status-green {
            background: #d4edda;
            color: #155724;
        }

        .status-yellow {
            background: #fff3cd;
            color: #856404;
        }

        .status-red {
            background: #f8d7da;
            color: #721c24;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
                padding: 80px 15px 20px;
            }

            .main-content {
                margin-left: 200px;
            }

            .stats-cards {
                grid-template-columns: 1fr;
            }

            .filter-buttons {
                flex-wrap: wrap;
            }

            .menu-item {
                padding: 12px 15px;
                font-size: 13px;
            }

            .stat-number {
                font-size: 20px;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 100%;
                position: static;
                height: auto;
                box-shadow: none;
                border-bottom: 2px solid #2e8b57;
            }

            .main-content {
                margin-left: 0;
                padding-top: 100px;
            }

            .header {
                position: static;
            }

            .stats-header {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .filter-buttons {
                flex-wrap: nowrap;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="header-title">
            <div class="header-logo">S</div>
            <div>
                <div style="font-size: 18px; font-weight: bold;">Dashboard</div>
                <div style="font-size: 12px; opacity: 0.9;">ADMIN</div>
            </div>
        </div>
        <div class="header-exit">
            <a href="/MainCode/dashboard.php"><span>←</span> EXIT</a>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="#" class="menu-item active">
                    <div>Dashboard</div>
                </a>
            </li>
            <li>
                <a href="kelolaLaporan.php" class="menu-item">
                    <div class="menu-icon">📋</div>
                    <div>Kelola Laporan Aduan</div>
                </a>
            </li>
            <li>
                <a href="kelolaArtikel.php" class="menu-item">
                    <div class="menu-icon">📝</div>
                    <div>Kelola Artikel Edukasi</div>
                </a>
            </li>
            <li>
                <a href="kelolaTPS.php" class="menu-item">
                    <div class="menu-icon">🗑️</div>
                    <div>Kelola Informasi TPS</div>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h2>Statistik Laporan</h2>
        </div>

        <div class="stats-container">
            <!-- Statistik Header -->
            <div class="stats-header">
                <h3>Statistik Laporan</h3>
                <div class="filter-buttons">
                    <button class="filter-btn active">Hari Ini</button>
                    <button class="filter-btn">Minggu Ini</button>
                    <button class="filter-btn">Bulan Ini</button>
                    <button class="filter-btn">Tahun Ini</button>
                </div>
            </div>

            <!-- Statistik Cards -->
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-number">127</div>
                    <div class="stat-label">Total Laporan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">89</div>
                    <div class="stat-label">Selesai Diproses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">38</div>
                    <div class="stat-label">Belum Diproses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">5</div>
                    <div class="stat-label">Ditolak</div>
                </div>
            </div>

            <!-- Trend Chart -->
            <div class="trend-chart">
                <h4>Trend Laporan (7 Hari Terakhir)</h4>
                <div class="mini-bar-chart">
                    <div class="bar" style="height: 30px;">Mon</div>
                    <div class="bar" style="height: 60px;">Tue</div>
                    <div class="bar" style="height: 45px;">Wed</div>
                    <div class="bar" style="height: 80px;">Thu</div>
                    <div class="bar" style="height: 55px;">Fri</div>
                    <div class="bar" style="height: 70px;">Sat</div>
                    <div class="bar" style="height: 40px;">Sun</div>
                </div>
            </div>

            <!-- Recent Reports -->
            <div class="recent-reports">
                <h4>Laporan Terbaru</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Alamat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>28 Oct 2025</td>
                            <td>Jl. Raya Negara</td>
                            <td><span class="status status-green">Selesai</span></td>
                        </tr>
                        <tr>
                            <td>27 Oct 2025</td>
                            <td>Jl. Sudirman</td>
                            <td><span class="status status-yellow">Proses</span></td>
                        </tr>
                        <tr>
                            <td>26 Oct 2025</td>
                            <td>Jl. Pahlawan</td>
                            <td><span class="status status-red">Ditolak</span></td>
                        </tr>
                        <tr>
                            <td>25 Oct 2025</td>
                            <td>Jl. Merdeka</td>
                            <td><span class="status status-green">Selesai</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Filter button toggle
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Di sini bisa ditambahkan logika untuk update data statistik berdasarkan filter
                // Contoh: fetch data dari server berdasarkan periode
                console.log('Filter:', this.textContent.trim());
            });
        });

        // Sidebar menu active state
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Simulasi hover effect pada bar chart
        document.querySelectorAll('.bar').forEach(bar => {
            bar.addEventListener('mouseenter', function() {
                this.style.height = (parseInt(this.style.height) + 10) + 'px';
            });
            bar.addEventListener('mouseleave', function() {
                this.style.height = (parseInt(this.style.height) - 10) + 'px';
            });
        });
    </script>
</body>

</html>