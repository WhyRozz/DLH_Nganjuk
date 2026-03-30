<?php
session_start();

// Anti-cache headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

// Proteksi login
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../Admin/login.php");
    exit;
}

require_once '../KoneksiDatabase/koneksi.php';

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
            .header-artikel {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}
        /* --- Gaya Umum --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
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

        /* --- Header Desktop --- */
        .header-desktop {
            width: 100%; background: #2e8b57; color: white;
            padding: 12px 30px; display: flex; justify-content: space-between;
            align-items: center; position: fixed; top: 0; left: 0; z-index: 1000;
        }
        .header-desktop-title { display: flex; align-items: center; gap: 10px; }
        .header-desktop-logo {
            width: 40px; height: 40px; border-radius: 50%;
            background: white; display: flex; align-items: center;
            justify-content: center; font-weight: bold; color: #2e8b57;
        }
        .header-desktop-exit {
            background: white; color: #2e8b57; padding: 6px 12px;
            border-radius: 5px; font-size: 12px; font-weight: bold;
            cursor: pointer; display: flex; align-items: center; gap: 5px;
            text-decoration: none;
        }
        .header-desktop-exit:hover {
            background: #e6ffe6;
            transform: scale(1.05);
        }

        /* --- Sidebar Desktop --- */
        .sidebar-desktop {
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
        .sidebar-desktop-menu {
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
            
        /* Gaya khusus untuk logo gambar */
		.logo-img {
    		width: 100%;
    		height: 100%;
    		object-fit: cover; /* Agar gambar tidak terdistorsi */
    		border-radius: 50%; /* Tetap bulat */
    		display: block;
		}
            
        .menu-item.active .menu-icon {
            background: white;
            color: #2e8b57;
        }

        /* --- Navbar Mobile --- */
        .navbar-mobile {
            width: 100%;
            background: #2e8b57;
            color: white;
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1001;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-mobile-menu-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.5em;
            cursor: pointer;
            padding: 5px;
        }
        .navbar-mobile-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
            font-size: 16px;
        }
        .navbar-mobile-title .logo {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2e8b57;
            font-weight: bold;
            font-size: 14px;
        }
        .navbar-mobile-exit {
            background: white;
            color: #2e8b57;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }
        .navbar-mobile-exit:hover {
            background: #e6ffe6;
        }

        /* --- Dropdown Mobile Sidebar --- */
        .mobile-sidebar {
            display: none; /* Sembunyikan secara default */
            position: fixed;
            top: 60px; /* Sesuaikan dengan tinggi navbar */
            left: 0;
            width: 100%;
            background: #e6e6e6;
            z-index: 1000;
            padding: 10px 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-height: calc(100vh - 60px);
            overflow-y: auto;
        }
        .mobile-sidebar .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .mobile-sidebar .menu-item {
            padding: 12px 15px;
            margin-bottom: 4px;
            background: white;
            border-radius: 0;
            border-radius: 8px;
            margin: 0 10px 4px 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }
        .mobile-sidebar .menu-item:hover {
            background: #f0f0f0;
            transform: translateX(4px);
        }
        .mobile-sidebar .menu-item.active {
            background: #2e8b57;
            color: white;
            box-shadow: 0 2px 6px rgba(46, 139, 87, 0.3);
        }
        .mobile-sidebar .menu-item.active .menu-icon {
            background: white;
            color: #2e8b57;
        }

        /* --- Main Content --- */
        .main-content {
            flex: 1; margin-left: 250px; padding: 80px 30px 30px;
            background: white; /* Warna latar utama */
            min-height: 100vh;
            opacity: 1;
            transition: opacity 0.25s ease-in-out;
        }
        .main-content.fade-out {
            opacity: 0;
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

        /* --- RESPONSIF: Mobile --- */
        @media (max-width: 768px) {
            /* Sembunyikan elemen desktop */
            .header-desktop, .sidebar-desktop {
                display: none;
            }
            .main-content {
                margin-left: 0;
                padding-top: 70px; /* Sesuaikan dengan tinggi navbar mobile */
            }
            th, td { padding: 10px 8px; font-size: 13px; }
            .btn-action { width: 28px; height: 28px; font-size: 12px; }
        }
        /* --- RESPONSIF: Mobile Lebar --- */
        @media (max-width: 480px) {
            .table-container { padding: 15px; }
            .table-title { font-size: 18px; }
            .btn-add { width: 100%; justify-content: center; }
        }
        /* --- RESPONSIF: Desktop (Sembunyikan elemen mobile) --- */
        @media (min-width: 769px) {
            .navbar-mobile, .mobile-sidebar {
                display: none;
            }
        }
    </style>
</head>
<body class="fade-in">

<?php if (isset($_GET['pesan'])): ?>
<script>alert("<?= htmlspecialchars(urldecode($_GET['pesan'])) ?>");</script>
<?php endif; ?>

    <!-- Header Desktop -->
    <div class="header-desktop">
        <div class="header-desktop-title">
            <div class="header-desktop-logo">
                <img src="http://simpelsi.medianewsonline.com/WEB/assets/logo.jpg" alt="Logo SIMPELSI" class="logo-img">
            </div>
            <div>
                <div style="font-size: 18px; font-weight: bold;">Beranda</div>
                <div style="font-size: 12px; opacity: 0.9;">ADMIN</div>
            </div>
        </div>
        <a href="dashboardAdmin.php" class="header-desktop-exit"><span>←</span> KEMBALI</a>
    </div>

    <!-- Sidebar Desktop -->
    <div class="sidebar-desktop">
        <ul class="sidebar-desktop-menu">
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

    <!-- Navbar Mobile -->
    <div class="navbar-mobile">
        <button class="navbar-mobile-menu-btn" id="menuToggle">☰</button>
        <div class="navbar-mobile-title">
            <div class="logo">
                <img src="http://simpelsi.medianewsonline.com/WEB/assets/logo.jpg" alt="Logo SIMPELSI" class="logo-img">
            </div>
            <div>ARTIKEL</div>
        </div>
        <a href="dashboardAdmin.php" class="navbar-mobile-exit">←</a>
    </div>

    <!-- Dropdown Mobile Sidebar -->
    <div class="mobile-sidebar" id="mobileSidebar">
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
    <div class="main-content" id="mainContent">
        <div class="content-header">
            <h2>Kelola Artikel</h2>
        </div>

        <div class="table-container">
           <div class="header-artikel">
    <div class="table-title">Daftar Artikel Edukasi</div>
    <a href="form-artikel.php" class="btn-add">➕ Tambah Artikel</a>
</div>

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

          
            </a>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const body = document.body;
        const mainContent = document.getElementById('mainContent');
        const menuToggle = document.getElementById('menuToggle');
        const mobileSidebar = document.getElementById('mobileSidebar');

        // Toggle sidebar mobile
        menuToggle.addEventListener('click', function() {
            mobileSidebar.style.display = mobileSidebar.style.display === 'block' ? 'none' : 'block';
        });

        // Tutup sidebar jika klik di luar sidebar
        document.addEventListener('click', function(event) {
            const isClickInsideNav = menuToggle.contains(event.target);
            const isClickInsideSidebar = mobileSidebar.contains(event.target);

            if (!isClickInsideNav && !isClickInsideSidebar) {
                mobileSidebar.style.display = 'none';
            }
        });

        // Fade-in saat halaman dimuat
        setTimeout(() => {
            body.classList.add('fade-in-ready');
        }, 50);

        // Terapkan fade out saat klik link internal (kecuali logout)
        document.querySelectorAll('.menu-item a, .header-desktop-exit').forEach(link => {
            if(link.href.includes('logout.php')) return; // Lewati link logout
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.href;
                mainContent.style.opacity = '0';
                setTimeout(() => {
                    window.location.href = url;
                }, 200);
            });
        });
    });
</script>
</body>
</html>