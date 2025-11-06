<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola TPS - SIMPELSI</title>
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
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
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

        /* Table Container */
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow-x: auto;
        }

        .table-title {
            color: #2e8b57;
            font-size: 20px;
            margin-bottom: 15px;
            border-bottom: 2px solid #2e8b57;
            padding-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #555;
            text-transform: uppercase;
            font-size: 13px;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .action-btns {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
        }

        .btn-edit {
            background: #ffc107;
            color: #333;
        }

        .btn-edit:hover {
            background: #e0a800;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .btn-footer {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back {
            background: #6c757d;
            color: white;
            margin-right: 10px;
        }

        .btn-back:hover {
            background: #5a6268;
        }

        .btn-create {
            background: #2e8b57;
            color: white;
        }

        .btn-create:hover {
            background: #226b42;
        }

        .footer-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
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

            th, td {
                padding: 10px 8px;
                font-size: 13px;
            }

            .btn-action {
                width: 28px;
                height: 28px;
                font-size: 12px;
            }

            .footer-buttons {
                flex-direction: column;
                gap: 10px;
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

            .table-container {
                padding: 15px;
            }

            .table-title {
                font-size: 18px;
            }

            .btn-footer {
                width: 100%;
                justify-content: center;
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
                <div style="font-size: 18px; font-weight: bold;"> Beranda</div>
                <div style="font-size: 12px; opacity: 0.9;">ADMIN</div>
            </div>
        </div>
        <div class="header-exit">
            <span>←</span> KELUAR
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="dashboardAdmin.php" class="menu-item">
                    <div>Beranda</div>
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
                <a href="#" class="menu-item active">
                    <div class="menu-icon">🗑️</div>
                    <div>Kelola Informasi TPS</div>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h2>Kelola TPS</h2>
        </div>

        <div class="table-container">
            <div class="table-title">Daftar Informasi TPS</div>

            <table>
                <thead>
                    <tr>
                        <th>NOMOR ID</th>
                        <th>NAMA TPS</th>
                        <th>KECAMATAN</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody id="tpsTableBody">
                    <!-- Data akan diisi oleh JavaScript -->
                </tbody>
            </table>

            <div class="footer-buttons">
                <button class="btn-footer btn-back" onclick="kembali()">KEMBALI</button>
                <button class="btn-footer btn-create" onclick="buatTPS()">
                    <span>➕</span> BUAT INFO TPS
                </button>
            </div>
        </div>
    </div>

    <script>
        // Simulasikan data TPS
        const tpsData = [
            { id: 1, nama: "TPS 1 KECAMATAN WILANGAN", kecamatan: "WILANGAN" },
            { id: 2, nama: "TPS 2 KECAMATAN BAGOR", kecamatan: "BAGOR" },
            { id: 3, nama: "TPS 3 KECAMATAN REJOSO", kecamatan: "REJOSO" },
            { id: 4, nama: "TPS 4 KECAMATAN NGALIJK", kecamatan: "NGALIJK" },
            { id: 5, nama: "TPS 5 KECAMATAN PACE", kecamatan: "PACE" }
        ];

        // Render tabel
        function renderTable() {
            const tableBody = document.getElementById('tpsTableBody');
            tableBody.innerHTML = '';

            tpsData.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.id}</td>
                    <td>${item.nama}</td>
                    <td>${item.kecamatan}</td>
                    <td>
                        <div class="action-btns">
                            <div class="btn-action btn-edit" onclick="editTPS(${item.id})">✏️</div>
                            <div class="btn-action btn-delete" onclick="hapusTPS(${item.id})">🗑️</div>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Fungsi kembali ke dashboard atau halaman sebelumnya
        function kembali() {
            window.history.back(); // atau ganti dengan window.location.href = 'dashboard.html';
        }

        // Fungsi buat info TPS (redirect ke form)
        function buatTPS() {
            window.location.href = 'form-tps.php'; // Ganti dengan nama file form TPS Anda
        }

        // Fungsi edit TPS
        function editTPS(id) {
            const tps = tpsData.find(t => t.id === id);
            if (!tps) return;

            localStorage.setItem('editTPS', JSON.stringify(tps));
            window.location.href = 'form-tps.php';
        }

        // Fungsi hapus TPS
        function hapusTPS(id) {
            if (confirm('Yakin ingin menghapus data TPS ini?')) {
                const index = tpsData.findIndex(t => t.id === id);
                if (index !== -1) {
                    tpsData.splice(index, 1);
                    renderTable();
                    alert('Data TPS berhasil dihapus!');
                }
            }
        }

        // Inisialisasi
        document.addEventListener('DOMContentLoaded', renderTable);
    </script>
</body>

</html>