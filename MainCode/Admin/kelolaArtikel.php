<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Artikel - SIMPELSI</title>
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

        .btn-add {
            background: #2e8b57;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            margin-top: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .btn-add:hover {
            background: #226b42;
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

            .btn-add {
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
                <div style="font-size: 18px; font-weight: bold;">Beranda</div>
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
                <a href="#" class="menu-item active">
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
            <h2>Kelola Artikel</h2>
        </div>

        <div class="table-container">
            <div class="table-title">Daftar Artikel Edukasi</div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="artikelTableBody">
                    <!-- Data akan diisi oleh JavaScript -->
                </tbody>
            </table>

            <button class="btn-add" onclick="tambahArtikel()">
                <span>➕</span> TAMBAH ARTIKEL
            </button>
        </div>
    </div>

    <script>
        // Simulasikan data artikel
        const artikelData = [
            { id: 1, judul: "Cara Memilah Sampah Organik", tanggal: "2025-10-25" },
            { id: 2, judul: "Pentingnya Daur Ulang Plastik", tanggal: "2025-10-22" },
            { id: 3, judul: "Tips Mengurangi Sampah Rumah Tangga", tanggal: "2025-10-18" },
            { id: 4, judul: "Mengenal Jenis-Jenis Sampah Berdasarkan Bahan", tanggal: "2025-10-15" },
            { id: 5, judul: "Dampak Sampah Terhadap Lingkungan", tanggal: "2025-10-10" }
        ];

        // Render tabel
        function renderTable() {
            const tableBody = document.getElementById('artikelTableBody');
            tableBody.innerHTML = '';

            artikelData.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${item.judul}</td>
                    <td>${item.tanggal}</td>
                    <td>
                        <div class="action-btns">
                            <div class="btn-action btn-edit" onclick="editArtikel(${item.id})">✏️</div>
                            <div class="btn-action btn-delete" onclick="hapusArtikel(${item.id})">🗑️</div>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Fungsi tambah artikel
        function tambahArtikel() {
            // Redirect ke halaman form (atau bisa juga pakai modal)
            window.location.href = 'form-artikel.php'; // Ganti dengan nama file form Anda
        }

        // Fungsi edit artikel
        function editArtikel(id) {
            // Ambil data artikel berdasarkan ID
            const artikel = artikelData.find(a => a.id === id);
            if (!artikel) return;

            // Simpan ke localStorage sementara untuk diambil di halaman form
            localStorage.setItem('editArtikel', JSON.stringify(artikel));

            // Redirect ke halaman form
            window.location.href = 'form-artikel.php';
        }

        // Fungsi hapus artikel
        function hapusArtikel(id) {
            if (confirm('Yakin ingin menghapus artikel ini?')) {
                const index = artikelData.findIndex(a => a.id === id);
                if (index !== -1) {
                    artikelData.splice(index, 1);
                    renderTable();
                    alert('Artikel berhasil dihapus!');
                }
            }
        }

        // Inisialisasi
        document.addEventListener('DOMContentLoaded', renderTable);
    </script>
</body>

</html>