<?php
// --- KONEKSI DATABASE ---
$host = 'fdb1034.awardspace.net';
$db   = '4698762_simpelsi';
$user = '4698762_simpelsi';
$pass = 'katasandi123';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Koneksi gagal: " . htmlspecialchars($e->getMessage()));
}

// Handle hapus artikel
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    try {
        // Hapus file foto jika ada
        $stmt = $pdo->prepare("SELECT foto FROM artikel WHERE id_artikel = ?");
        $stmt->execute([$id]);
        $foto = $stmt->fetchColumn();
        if ($foto && file_exists("../../api/uploads/artikel/" . $foto)) {
            unlink("../../api/uploads/artikel/" . $foto);
        }

        // Hapus dari database
        $stmt = $pdo->prepare("DELETE FROM artikel WHERE id_artikel = ?");
        $stmt->execute([$id]);

        header("Location: kelolaArtikel.php?pesan=Artikel+berhasil+dihapus!");
        exit;
    } catch (Exception $e) {
        $error = "Gagal menghapus artikel.";
    }
}

// Ambil semua artikel dari database
$stmt = $pdo->query("SELECT * FROM artikel ORDER BY tanggal DESC");
$artikelList = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Artikel - SIMPELSI</title>
    <style>
        /* --- STYLE SAMA PERSIS SEPERTI DESAINMU --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            display: flex;
            min-height: 100vh;
        }
        .header {
            width: 100%; background: #2e8b57; color: white;
            padding: 12px 30px; display: flex; justify-content: space-between;
            align-items: center; position: fixed; top: 0; left: 0; z-index: 1000;
        }
        .header-title { display: flex; align-items: center; gap: 10px; }
        .header-logo {
            width: 40px; height: 40px; border-radius: 50%;
            background: white; display: flex; align-items: center;
            justify-content: center; font-weight: bold; color: #2e8b57;
        }
        .header-exit {
            background: white; color: #2e8b57; padding: 6px 12px;
            border-radius: 5px; font-size: 12px; font-weight: bold;
            cursor: pointer; display: flex; align-items: center; gap: 5px;
            text-decoration: none;
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
        .main-content {
            flex: 1; margin-left: 250px; padding: 80px 30px 30px;
            background: white;
        }
        .content-header h2 {
            color: #2e8b57; font-size: 24px; margin-bottom: 20px;
        }
        .table-container {
            background: white; padding: 20px; border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow-x: auto;
        }
        .table-title {
            color: #2e8b57; font-size: 20px; margin-bottom: 15px;
            border-bottom: 2px solid #2e8b57; padding-bottom: 8px;
        }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: 600; color: #555; text-transform: uppercase; font-size: 13px; }
        tr:hover { background: #f8f9fa; }
        .action-btns { display: flex; gap: 8px; }
        .btn-action {
            width: 32px; height: 32px; display: flex; align-items: center;
            justify-content: center; border-radius: 4px; cursor: pointer;
            transition: all 0.2s; font-size: 14px;
        }
        .btn-edit { background: #ffc107; color: #333; }
        .btn-edit:hover { background: #e0a800; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-delete:hover { background: #c82333; }
        .btn-add {
            background: #2e8b57; color: white; padding: 10px 20px;
            border: none; border-radius: 6px; cursor: pointer;
            font-weight: bold; font-size: 14px; margin-top: 20px;
            display: inline-flex; align-items: center; gap: 8px;
            transition: background 0.2s;
        }
        .btn-add:hover { background: #226b42; }

        @media (max-width: 768px) {
            .sidebar { width: 200px; padding: 80px 15px 20px; }
            .main-content { margin-left: 200px; }
            th, td { padding: 10px 8px; font-size: 13px; }
            .btn-action { width: 28px; height: 28px; font-size: 12px; }
        }
        @media (max-width: 480px) {
            .sidebar { width: 100%; position: static; height: auto; box-shadow: none; border-bottom: 2px solid #2e8b57; }
            .main-content { margin-left: 0; padding-top: 100px; }
            .header { position: static; }
            .table-container { padding: 15px; }
            .table-title { font-size: 18px; }
            .btn-add { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

<?php if (isset($_GET['pesan'])): ?>
<script>alert("<?= htmlspecialchars(urldecode($_GET['pesan'])) ?>");</script>
<?php endif; ?>

<!-- Header -->
<div class="header">
    <div class="header-title">
        <div class="header-logo">S</div>
        <div>
            <div style="font-size: 18px; font-weight: bold;">Beranda</div>
            <div style="font-size: 12px; opacity: 0.9;">ADMIN</div>
        </div>
    </div>
    <a href="dashboardAdmin.php" class="header-exit"><span>←</span> KEMBALI</a>
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
            <a href="kelolaArtikel.php" class="menu-item active">
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
        <li>
            <a href="kelolaAkun.php" class="menu-item">
                <div class="menu-icon">🔐</div>
                <div>Kelola Akun</div>
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
            <tbody>
                <?php if (empty($artikelList)): ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px; color: #888;">
                        Belum ada artikel. <a href="form-artikel.php" style="color: #2e8b57;">Tambah artikel sekarang</a>.
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($artikelList as $index => $artikel): ?>
                <?php
                    $formattedDate = date('d-m-Y H:i', strtotime($artikel['tanggal']));
                ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($artikel['judul']) ?></td>
                    <td><?= $formattedDate ?></td>
                    <td>
                        <div class="action-btns">
                            <a href="form-artikel.php?edit=<?= $artikel['id_artikel'] ?>" class="btn-action btn-edit" title="Edit">✏️</a>
                            <a href="?hapus=<?= $artikel['id_artikel'] ?>" class="btn-action btn-delete" title="Hapus" onclick="return confirm('Yakin hapus artikel ini?')">🗑️</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="form-artikel.php" class="btn-add">
            <span>➕</span> TAMBAH ARTIKEL
        </a>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainContent = document.getElementById('mainContent');

    // Terapkan fade out saat klik link internal (kecuali logout)
    document.querySelectorAll('.menu-item a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;
            mainContent.classList.add('fade-out');
            setTimeout(() => {
                window.location.href = url;
            }, 200);
        });
    });
});
</script>
</body>
</html>