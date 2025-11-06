<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sertakan koneksi database
require_once '../KoneksiDatabase/koneksi.php';

// Ambil semua laporan dengan JOIN ke tabel masyarakat
$stmt = $pdo->query("
    SELECT 
        l.id,
        l.id_masyarakat,
        l.nama AS nama_pelapor,
        m.email AS email_pelapor,
        l.lokasi,
        l.keterangan,
        l.status,
        l.foto,
        l.created_at,
        l.tanggal
    FROM laporan l
    LEFT JOIN masyarakat m ON l.id_masyarakat = m.id_masyarakat
    ORDER BY l.id DESC
");
$laporanList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Laporan Aduan - SIMPELSI</title>
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

        /* Search Bar */
        .search-bar {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .search-input {
            flex: 1;
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .search-btn {
            background: #2e8b57;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
            font-size: 14px;
        }

        /* Table Container */
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #e6f2e6;
            font-weight: bold;
            color: #2e8b57;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }

        .status-proses {
            background: #fff3cd;
            color: #856404;
        }

        .status-selesai {
            background: #d4edda;
            color: #155724;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #721c24;
        }

        /* Detail Row (hidden by default) */
        .detail-row {
            display: none;
            background: #f9f9f9;
            padding: 20px;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        .detail-row.active {
            display: table-row;
        }

        .detail-content {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .detail-image {
            flex: 0 0 300px;
            background: #eee;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .detail-image img {
            max-width: 100%;
            max-height: 200px;
            object-fit: contain;
        }

        .detail-form {
            flex: 1;
            min-width: 300px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #555;
        }

        .form-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            min-height: 80px;
            resize: vertical;
        }

        .status-options {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .status-option {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        .status-option input[type="radio"] {
            accent-color: #2e8b57;
        }

        .status-option label {
            font-size: 14px;
            cursor: pointer;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-primary {
            background: #2e8b57;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #226b42;
        }

        .btn-secondary:hover {
            background: #5a6268;
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

            .search-bar {
                flex-direction: column;
                gap: 10px;
            }

            .search-input {
                width: 100%;
            }

            .search-btn {
                width: 100%;
            }

            .detail-content {
                flex-direction: column;
            }

            .detail-image {
                flex: 0 0 auto;
                max-width: 100%;
            }

            .detail-form {
                flex: 1;
                min-width: auto;
            }

            .status-options {
                flex-wrap: wrap;
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
                padding: 10px;
            }

            th,
            td {
                padding: 8px;
                font-size: 12px;
            }

            .status-badge {
                font-size: 10px;
                padding: 3px 6px;
            }

            .detail-image img {
                max-height: 150px;
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
        <div class="header-exit" onclick="window.location.href='../Admin/login.php'">
            <span>←</span> EXIT
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="dashboardAdmin.php" class="menu-item">
                    <div>Dashboard</div>
                </a>
            </li>
            <li>
                <a href="#" class="menu-item active">
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
            <h2>Kelola Laporan Aduan</h2>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" class="search-input" placeholder="Cari laporan berdasarkan nama atau email...">
            <button class="search-btn">Cari</button>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>NOMOR ID</th>
                        <th>NAMA</th>
                        <th>EMAIL</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($laporanList)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px;">Tidak ada laporan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($laporanList as $laporan):
                            $id = $laporan['id'];
                            $statusClass = match (strtolower($laporan['status'])) {
                                'diproses' => 'status-proses',
                                'diterima' => 'status-selesai',
                                'ditolak' => 'status-ditolak',
                                default => 'status-proses'
                            };
                            $statusLabel = strtoupper($laporan['status']);
                            $fotoPath = !empty($laporan['foto']) 
                                ? htmlspecialchars($laporan['foto']) 
                                : 'https://via.placeholder.com/300x200?text=Foto+Tidak+Ada';
                            $tanggal = $laporan['tanggal'] 
                                ? date('d-m-Y', strtotime($laporan['tanggal'])) 
                                : '-';
                        ?>
                            <tr onclick="toggleDetail(<?= $id ?>)">
                                <td><?= htmlspecialchars($id) ?></td>
                                <td><?= htmlspecialchars($laporan['nama_pelapor'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($laporan['email_pelapor'] ?? 'N/A') ?></td>
                                <td><span class="status-badge <?= $statusClass ?>"><?= $statusLabel ?></span></td>
                            </tr>
                            <tr class="detail-row" id="detail-<?= $id ?>">
                                <td colspan="4">
                                    <div class="detail-content">
                                        <div class="detail-image">
                                            <img src="<?= $fotoPath ?>" alt="Foto Sampah">
                                        </div>
                                        <div class="detail-form">
                                            <div class="form-group">
                                                <label class="form-label">Nama:</label>
                                                <input type="text" class="form-input" value="<?= htmlspecialchars($laporan['nama_pelapor'] ?? '') ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Email:</label>
                                                <input type="email" class="form-input" value="<?= htmlspecialchars($laporan['email_pelapor'] ?? '') ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Lokasi:</label>
                                                <input type="text" class="form-input" value="<?= htmlspecialchars($laporan['lokasi'] ?? '') ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Tanggal:</label>
                                                <input type="text" class="form-input" value="<?= $tanggal ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Keterangan:</label>
                                                <textarea class="form-textarea" readonly><?= htmlspecialchars($laporan['keterangan'] ?? '') ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Status:</label>
                                                <div class="status-options">
                                                    <?php foreach (['Diproses', 'Diterima', 'Ditolak'] as $opt):
                                                        $checked = ($laporan['status'] === $opt) ? 'checked' : '';
                                                    ?>
                                                        <div class="status-option">
                                                            <input type="radio" id="status-<?= $opt ?>-<?= $id ?>" name="status-<?= $id ?>" value="<?= $opt ?>" <?= $checked ?>>
                                                            <label for="status-<?= $opt ?>-<?= $id ?>"><?= $opt ?></label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn-secondary" onclick="closeDetail(<?= $id ?>)">KEMBALI</button>
                                                <button class="btn-primary" onclick="saveStatus(<?= $id ?>)">SIMPAN</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Toggle detail row
        function toggleDetail(id) {
            const detailRow = document.getElementById(`detail-${id}`);
            const allRows = document.querySelectorAll('.detail-row');
            
            // Close all other details
            allRows.forEach(row => {
                if (row.id !== `detail-${id}`) {
                    row.classList.remove('active');
                }
            });
            
            // Toggle current
            detailRow.classList.toggle('active');
        }

        // Close detail
        function closeDetail(id) {
            const detailRow = document.getElementById(`detail-${id}`);
            detailRow.classList.remove('active');
        }

        // Save status to database
        function saveStatus(id) {
            const selectedStatus = document.querySelector(`input[name="status-${id}"]:checked`).value;

            fetch('update_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${encodeURIComponent(id)}&status=${encodeURIComponent(selectedStatus)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update badge in detail
                    const badge = document.querySelector(`#detail-${id} .status-badge`);
                    badge.textContent = selectedStatus.toUpperCase();
                    badge.className = `status-badge status-${selectedStatus.toLowerCase()}`;
                    
                    // Update badge in main row
                    const row = document.querySelector(`tr[onclick*="toggleDetail(${id})"] td:last-child`);
                    row.innerHTML = `<span class="status-badge status-${selectedStatus.toLowerCase()}">${selectedStatus.toUpperCase()}</span>`;
                    
                    alert(`Status laporan ID ${id} berhasil diubah!`);
                    closeDetail(id);
                } else {
                    alert('Gagal menyimpan: ' + (data.message || 'Error tidak dikenal'));
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat menyimpan.');
            });
        }

        // Search functionality (client-side only)
        document.querySelector('.search-btn').addEventListener('click', function() {
            const query = document.querySelector('.search-input').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr:not(.detail-row)');
            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                if (name.includes(query) || email.includes(query)) {
                    row.style.display = '';
                    // Show detail if already open
                    const detailRow = row.nextElementSibling;
                    if (detailRow && detailRow.classList.contains('detail-row')) {
                        detailRow.style.display = detailRow.classList.contains('active') ? 'table-row' : 'none';
                    }
                } else {
                    row.style.display = 'none';
                    const detailRow = row.nextElementSibling;
                    if (detailRow && detailRow.classList.contains('detail-row')) {
                        detailRow.style.display = 'none';
                    }
                }
            });
        });

        document.querySelector('.search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.querySelector('.search-btn').click();
            }
        });
    </script>
</body>

</html>