<?php
session_start();
require_once '../KoneksiDatabase/koneksi.php';

$mode = 'tambah';
$tps = null;

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM tps WHERE id_tps = ?");
    $stmt->execute([$id]);
    $tps = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$tps) die("Data TPS tidak ditemukan.");
    $mode = 'edit';
}

// Handle simpan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_tps'] ?? null;
    $nama_tps = trim($_POST['nama_tps'] ?? '');
    $lokasi = trim($_POST['lokasi'] ?? ''); // koordinat
    $alamat = trim($_POST['alamat'] ?? ''); // alamat lengkap
    $kapasitas = trim($_POST['kapasitas'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');

    if (empty($nama_tps)) {
        $error = "Nama TPS wajib diisi!";
    } else {
        try {
            $kapasitas = $kapasitas === '' ? null : (int)$kapasitas;
            $lokasi = $lokasi === '' ? null : $lokasi;
            $alamat = $alamat === '' ? null : $alamat;
            $keterangan = $keterangan === '' ? null : $keterangan;

            if ($mode === 'edit') {
                $stmt = $pdo->prepare("
                    UPDATE tps 
                    SET nama_tps = ?, lokasi = ?, alamat = ?, kapasitas = ?, keterangan = ? 
                    WHERE id_tps = ?
                ");
                $stmt->execute([$nama_tps, $lokasi, $alamat, $kapasitas, $keterangan, $id]);
            } else {
                $stmt = $pdo->prepare("
                    INSERT INTO tps (nama_tps, lokasi, alamat, kapasitas, keterangan) 
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt->execute([$nama_tps, $lokasi, $alamat, $kapasitas, $keterangan]);
            }
            header("Location: kelolaTPS.php?" . ($mode === 'edit' ? 'edit=1' : 'tambah=1'));
            exit;
        } catch (Exception $e) {
            $error = "Gagal menyimpan data: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $mode === 'edit' ? 'Edit' : 'Tambah' ?> TPS - SIMPELSI</title>
    <style>
        /* CSS tetap sama seperti sebelumnya */
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

        body.fade-in .main-content {
            opacity: 0;
            transition: opacity 0.3s ease-out;
        }

        body.fade-in-ready .main-content {
            opacity: 1;
        }

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
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .header-exit:hover {
            background: #e6ffe6;
            transform: scale(1.05);
        }

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

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 80px 30px 40px;
            background: #f9f9f9;
            min-height: 100vh;
        }

        .content-header h2 {
            color: #2e8b57;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            max-width: 1000px;
            margin: 0 auto;
            width: 100%;
        }

        .form-title {
            color: #2e8b57;
            font-size: 20px;
            margin-bottom: 20px;
            border-bottom: 2px solid #2e8b57;
            padding-bottom: 8px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 1;
            min-width: 250px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
            font-weight: 500;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .alert {
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-size: 14px;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }

        .btn-primary {
            background: #2e8b57;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
                padding: 80px 15px 20px;
            }

            .main-content {
                margin-left: 200px;
            }

            .form-row {
                flex-direction: column;
            }

            .form-group {
                min-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 100%;
                position: static;
                border-bottom: 2px solid #2e8b57;
            }

            .main-content {
                margin-left: 0;
                padding-top: 100px;
            }

            .action-buttons {
                flex-direction: column;
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
        <a href="../login/logout.php" class="header-exit">
            <span>←</span> KELUAR
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="dashboardAdmin.php" class="menu-item">
                    <div class="menu-icon">📊</div>Beranda
                </a></li>
            <li><a href="kelolaLaporan.php" class="menu-item">
                    <div class="menu-icon">📋</div>Kelola Laporan Aduan
                </a></li>
            <li><a href="kelolaArtikel.php" class="menu-item">
                    <div class="menu-icon">📝</div>Kelola Artikel Edukasi
                </a></li>
            <li><a href="kelolaTPS.php" class="menu-item active">
                    <div class="menu-icon">🗑️</div>Kelola Informasi TPS
                </a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="content-header">
            <h2><?= $mode === 'edit' ? 'Edit Informasi TPS' : 'Tambah Informasi TPS' ?></h2>
        </div>

        <div class="form-container">
            <div class="form-title"><?= $mode === 'edit' ? 'Edit TPS' : 'Form Tambah TPS' ?></div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <?php if ($mode === 'edit'): ?>
                    <input type="hidden" name="id_tps" value="<?= htmlspecialchars($tps['id_tps']) ?>">
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama TPS</label>
                        <input type="text" name="nama_tps" class="form-input"
                            value="<?= htmlspecialchars($tps['nama_tps'] ?? '') ?>" required>
                    </div>
                </div>

                <!-- KOORDINAT GPS -->
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Koordinat GPS (Latitude, Longitude)</label>
                        <div style="display: flex; gap: 10px; align-items: flex-start;">
                            <textarea name="lokasi" id="koordinatInput" class="form-textarea"
                                placeholder="Contoh: -7.854321,112.123456"
                                oninput="formatKoordinat(this)"><?= htmlspecialchars($tps['lokasi'] ?? '') ?></textarea>
                            <button type="button" class="btn btn-secondary" style="height: fit-content; padding: 12px 12px;"
                                onclick="bukaGoogleMaps()">
                                🗺️ Pilih di Maps
                            </button>
                        </div>
                        <small style="color: #666; font-size: 12px; display: block; margin-top: 6px;">
                            1. Klik tombol "Pilih di Maps"<br>
                            2. Klik lokasi di Google Maps → koordinat muncul di kiri bawah<br>
                            3. Salin & tempel ke kolom di atas
                        </small>
                    </div>
                </div>

                <!-- ALAMAT LENGKAP -->
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-textarea"
                            placeholder="Contoh: Jl. Merdeka No. 15, Kel. Beran, Kec. Nganjuk"><?= htmlspecialchars($tps['alamat'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kapasitas (opsional)</label>
                        <input type="number" name="kapasitas" class="form-input"
                            value="<?= htmlspecialchars($tps['kapasitas'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Keterangan (opsional)</label>
                        <textarea name="keterangan" class="form-textarea"><?= htmlspecialchars($tps['keterangan'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="kelolaTPS.php" class="btn btn-secondary">BATAL</a>
                    <button type="submit" class="btn btn-primary">
                        <?= $mode === 'edit' ? 'SIMPAN PERUBAHAN' : 'SIMPAN TPS' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const koordinatTersimpan = <?= json_encode($tps['lokasi'] ?? null) ?>;

        function bukaGoogleMaps() {
            let url = 'https://www.google.com/maps';

            if (koordinatTersimpan && /^-?\d+(\.\d+)?,-?\d+(\.\d+)?$/.test(koordinatTersimpan)) {
                url = `https://www.google.com/maps/@${koordinatTersimpan},18z`;
            } else {
                // Default: Nganjuk
                url = 'https://www.google.com/maps/@-7.599401,111.900081,11z';
            }

            window.open(url, '_blank');
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

        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const mainContent = document.getElementById('mainContent');

            setTimeout(() => {
                body.classList.add('fade-in-ready');
            }, 50);

            const btnBatal = document.querySelector('a.btn-secondary');
            if (btnBatal) {
                btnBatal.addEventListener('click', function(e) {
                    e.preventDefault();
                    mainContent.style.opacity = '0';
                    setTimeout(() => {
                        window.location.href = this.href;
                    }, 200);
                });
            }
        });
    </script>
</body>

</html>