<?php
session_start();

// Proteksi: hanya admin yang sudah login
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: ../login/login.php");
//     exit;
// }

// Load koneksi database
require_once '../KoneksiDatabase/koneksi.php';
?>

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

        /* Fade-in saat halaman load */
        body.fade-in .main-content {
            opacity: 0;
            transition: opacity 0.3s ease-out;
        }

        body.fade-in-ready .main-content {
            opacity: 1;
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
            text-decoration: none;
        }

        .header-exit:hover {
            background: #e6ffe6;
            transform: scale(1.05);
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #e6e6e6;
            position: fixed;
            top: 60px;
            left: 0;
            bottom: 0;
            padding: 20px 0;
            overflow-y: auto;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
            z-index: 999;
            display: flex;
            flex-direction: column;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0 20px;
            margin: 0;
            flex: 1;
        }

        .menu-item {
            padding: 14px 20px;
            margin-bottom: 8px;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #333;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .menu-item:hover {
            background: #f0f0f0;
            transform: translateX(4px);
        }

        .menu-item.active {
            background: #2e8b57;
            color: white;
            border: none;
            box-shadow: 0 2px 6px rgba(46, 139, 87, 0.3);
        }

        .menu-icon {
            width: 32px;
            height: 32px;
            background: #2e8b57;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .menu-item.active .menu-icon {
            background: white;
            color: #2e8b57;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 80px 30px 40px;
            background: #f9f9f9;
            min-height: 100vh;
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
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

        th,
        td {
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

            th,
            td {
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

<body class="fade-in">
    <!-- Header -->
    <div class="header">
        <div class="header-title">
            <div class="header-logo">S</div>
            <div>
                <div style="font-size: 18px; font-weight: bold;">Beranda</div>
                <div style="font-size: 12px; opacity: 0.9;">ADMIN</div>
            </div>
        </div>
        <a href="../dashboard.php" class="header-exit">
            <span>←</span> KELUAR
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="dashboardAdmin.php" class="menu-item">
                    <div class="menu-icon">📊</div>
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
                <a href="kelolaTPS.php" class="menu-item active">
                    <div class="menu-icon">🗑️</div>
                    <div>Kelola Informasi TPS</div>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="content-header">
            <h2>Kelola TPS</h2>
        </div>

        <div class="table-container">
            <div class="table-title">Daftar Informasi TPS</div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAMA TPS</th>
                        <th>LOKASI</th>
                        <th>KAPASITAS</th>
                        <th>KETERANGAN</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody id="tpsTableBody">
                    <?php
                    // Ambil semua data TPS dari database
                    try {
                        $stmt = $pdo->query("SELECT * FROM tps ORDER BY id_tps ASC");
                        $tpsList = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($tpsList as $tps): ?>
                            <tr>
                                <td><?= htmlspecialchars($tps['id_tps']) ?></td>
                                <td><?= htmlspecialchars($tps['nama_tps']) ?></td>
                                <td>
                                    <?php if (!empty($tps['lokasi']) && preg_match('/^-?\d+(\.\d+)?,-?\d+(\.\d+)?$/', $tps['lokasi'])): ?>
                                        <a href="https://maps.google.com/maps?q=<?= urlencode($tps['lokasi']) ?>"
                                            target="_blank"
                                            style="color: #2e8b57; text-decoration: none;">
                                            🗺️ Lihat di Maps
                                        </a>
                                    <?php else: ?>
                                        <?= htmlspecialchars($tps['lokasi'] ?? '-') ?>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($tps['kapasitas'] ?? '-') ?></td>
                                <td><?= htmlspecialchars(substr($tps['keterangan'] ?? '', 0, 30)) ?><?= strlen($tps['keterangan'] ?? '') > 30 ? '...' : '' ?></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="form-tps.php?id=<?= $tps['id_tps'] ?>" class="btn-action btn-edit">✏️</a>
                                        <button class="btn-action btn-delete" onclick="hapusTPS(<?= $tps['id_tps'] ?>)">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;

                        if (empty($tpsList)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 20px; color: #666;">
                                    Belum ada data TPS.
                                </td>
                            </tr>
                    <?php endif;
                    } catch (Exception $e) {
                        echo '<tr><td colspan="6" style="color: red; text-align: center;">Error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>

            <div class="footer-buttons">
                <a href="dashboardAdmin.php" class="btn-footer btn-back">KEMBALI</a>
                <a href="form-tps.php" class="btn-footer btn-create">
                    <span>➕</span> BUAT INFO TPS
                </a>
            </div>
        </div>
    </div>

    <script>
        // === ANIMASI FADE-IN/OUT ===
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const mainContent = document.getElementById('mainContent');

            // Fade-in saat halaman dimuat
            setTimeout(() => {
                body.classList.add('fade-in-ready');
            }, 50);

            // Fade-out saat klik menu
            document.querySelectorAll('.menu-item a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    mainContent.style.opacity = '0';
                    setTimeout(() => {
                        window.location.href = this.href;
                    }, 200);
                });
            });

            // Fade-out saat klik tombol KEMBALI atau BUAT
            document.querySelectorAll('.btn-back, .btn-create').forEach(btn => {
                btn.addEventListener('click', function() {
                    mainContent.style.opacity = '0';
                    setTimeout(() => {
                        // Biarkan fungsi asli jalan (karena kita tidak preventDefault)
                    }, 200);
                });
            });
        });

        function bukaGoogleMaps() {
            // Buka di tab baru, tanpa mengganggu halaman ini
            window.open('https://www.google.com/maps/@-7.5728974,110.8321999,7z', '_blank');
        }

        function formatKoordinat(input) {
            let value = input.value.replace(/\s+/g, '');
            if (/^-?\d+(\.\d+)?,-?\d+(\.\d+)?$/.test(value)) {
                input.style.borderColor = '#2e8b57';
                input.style.boxShadow = '0 0 0 2px rgba(46, 139, 87, 0.2)';
            } else {
                input.style.borderColor = '#dc3545';
                input.style.boxShadow = '0 0 0 2px rgba(220, 53, 69, 0.2)';
            }
            input.value = value;
        }

        // Fungsi hapus TPS
        function hapusTPS(id) {
            if (confirm('Yakin ingin menghapus data TPS ini?')) {
                // Kirim request via form atau AJAX
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'delete-tps.php'; // buat file delete_tps.php jika perlu
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id';
                input.value = id;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>

</html>