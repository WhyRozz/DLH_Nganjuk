<?php
// --- AWAL KODE PHP (Backend) ---
session_start();

// ⚠️ GANTI SESUAI DENGAN DATABASE DI AWARDSpace
$host = 'fdb1034.awardspace.net';
$db   = '4698762_simpelsi'; // Contoh: u123456789_simpelsi
$user = '4698762_simpelsi';   // Contoh: u123456789_admin
$pass = 'katasandi123';   // Password DB-mu
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

// Buat tabel jika belum ada (opsional, cukup sekali)
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS artikel (
        id INT AUTO_INCREMENT PRIMARY KEY,
        judul VARCHAR(255) NOT NULL,
        tanggal DATE NOT NULL,
        deskripsi TEXT NOT NULL,
        foto VARCHAR(255) NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch (Exception $e) {
    // Abaikan error tabel sudah ada
}

// Handle simpan artikel
$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $tanggal = $_POST['tanggal'] ?? '';
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    if (empty($judul) || empty($deskripsi) || empty($tanggal)) {
        $pesan = 'error:Semua kolom wajib diisi!';
    } else {
        $fotoNama = null;
        if (!empty($_FILES['foto']['name'])) {
            $targetDir = "uploads/artikel/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $fileExt = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif'])) {
                $pesan = 'error:Format gambar tidak didukung!';
            } else {
                $fotoNama = uniqid('artikel_') . '.' . $fileExt;
                $targetFile = $targetDir . $fotoNama;
                if (!move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
                    $pesan = 'error:Gagal mengupload gambar!';
                }
            }
        }

        if (empty($pesan)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO artikel (judul, tanggal, deskripsi, foto) VALUES (?, ?, ?, ?)");
                $stmt->execute([$judul, $tanggal, $deskripsi, $fotoNama]);
                $pesan = 'sukses:Artikel berhasil disimpan!';
            } catch (Exception $e) {
                $pesan = 'error:Gagal menyimpan ke database!';
            }
        }
    }

    // Redirect dengan pesan
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '?') . "?pesan=" . urlencode($pesan));
    exit;
}

// Ambil pesan dari URL
$alertPesan = '';
if (isset($_GET['pesan'])) {
    $pesanParts = explode(':', $_GET['pesan'], 2);
    $jenis = $pesanParts[0];
    $teks = $pesanParts[1] ?? '';
    $alertPesan = htmlspecialchars($teks);
}
// --- AKHIR KODE PHP ---
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Artikel - SIMPELSI</title>
    <style>
        /* --- SAMA DENGAN STYLE-MU --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            display: flex;
            min-height: 100vh;
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
        .sidebar {
            width: 250px; background: #e6e6e6;
            padding: 80px 20px 20px; position: fixed;
            top: 60px; left: 0; bottom: 0;
            overflow-y: auto; box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            z-index: 999;
        }
        .sidebar-menu { list-style: none; }
        .menu-item {
            padding: 15px 20px; margin-bottom: 10px; background: white;
            border-radius: 10px; display: flex; align-items: center;
            gap: 10px; text-decoration: none; color: #333;
        }
        .menu-item:hover { background: #f0f0f0; }
        .menu-item.active {
            background: #2e8b57; color: white; border: 2px solid white;
        }
        .menu-icon {
            width: 30px; height: 30px; background: #2e8b57;
            color: white; border-radius: 50%; display: flex;
            align-items: center; justify-content: center; font-size: 16px;
        }
        .menu-item.active .menu-icon {
            background: white; color: #2e8b57;
        }
        .main-content {
            flex: 1; margin-left: 250px; padding: 80px 30px 30px;
            background: white;
        }
        .content-header h2 {
            color: #2e8b57; font-size: 24px; margin-bottom: 20px;
        }
        .form-container {
            background: white; padding: 25px; border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            max-width: 800px; margin: 0 auto;
        }
        .form-title {
            color: #2e8b57; font-size: 20px; margin-bottom: 20px;
            border-bottom: 2px solid #2e8b57; padding-bottom: 8px;
        }
        .form-row {
            display: flex; gap: 20px; margin-bottom: 20px; flex-wrap: wrap;
        }
        .form-group { flex: 1; min-width: 250px; }
        .form-label {
            display: block; margin-bottom: 8px; font-size: 14px;
            color: #555; font-weight: 500;
        }
        .form-input, .form-textarea {
            width: 100%; padding: 10px 12px; border: 1px solid #ddd;
            border-radius: 6px; font-size: 14px;
        }
        .form-textarea { min-height: 120px; resize: vertical; }
        .upload-area {
            border: 2px dashed #ccc; border-radius: 8px; padding: 20px;
            text-align: center; background: #fafafa; cursor: pointer;
            position: relative; overflow: hidden;
        }
        .upload-area:hover {
            border-color: #2e8b57; background: #f0f9f4;
        }
        .upload-area input[type="file"] {
            position: absolute; width: 100%; height: 100%;
            opacity: 0; cursor: pointer;
        }
        .upload-icon { font-size: 36px; color: #888; margin-bottom: 10px; }
        .upload-text { color: #666; font-size: 14px; }
        .upload-preview { margin-top: 15px; display: none; }
        .upload-preview img {
            max-width: 100%; max-height: 150px; border-radius: 6px;
            object-fit: contain; border: 1px solid #ddd;
        }
        .action-buttons {
            display: flex; gap: 12px; margin-top: 25px;
            justify-content: flex-start;
        }
        .btn {
            padding: 10px 20px; border: none; border-radius: 6px;
            cursor: pointer; font-weight: bold; font-size: 14px;
        }
        .btn-primary { background: #2e8b57; color: white; }
        .btn-primary:hover { background: #226b42; }
        .btn-secondary { background: #6c757d; color: white; text-decoration: none; text-align: center; display: inline-block; }
        .btn-secondary:hover { background: #5a6268; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-danger:hover { background: #c82333; }

        @media (max-width: 768px) {
            .sidebar { width: 200px; padding: 80px 15px 20px; }
            .main-content { margin-left: 200px; }
            .form-row { flex-direction: column; }
            .form-group { min-width: 100%; }
        }
        @media (max-width: 480px) {
            .sidebar { width: 100%; position: static; height: auto; border-bottom: 2px solid #2e8b57; }
            .main-content { margin-left: 0; padding-top: 100px; }
            .header { position: static; }
            .form-container { padding: 15px; }
            .form-title { font-size: 18px; }
            .action-buttons { flex-direction: column; }
        }
    </style>
</head>
<body>

<?php if ($alertPesan): ?>
<script>
    alert("<?= $alertPesan ?>");
</script>
<?php endif; ?>

<!-- Header -->
<div class="header">
    <div class="header-title">
        <div class="header-logo">S</div>
        <div>
            <div style="font-size: 18px; font-weight: bold;">Dashboard</div>
            <div style="font-size: 12px; opacity: 0.9;">ADMIN</div>
        </div>
    </div>
    <a href="dashboardAdmin.php" class="header-exit">
        <span>←</span> EXIT
    </a>
</div>

<!-- Sidebar -->
<div class="sidebar">
    <ul class="sidebar-menu">
        <li><a href="dashboardAdmin.php" class="menu-item"><div>Kelola Laporan Aduan</div></a></li>
        <li><a href="kelolaLaporan.php" class="menu-item"><div class="menu-icon">📋</div><div>Kelola Laporan Aduan</div></a></li>
        <li><a href="kelolaArtikel.php" class="menu-item active"><div class="menu-icon">📝</div><div>Kelola Artikel Edukasi</div></a></li>
        <li><a href="kelolaTPS.php" class="menu-item"><div class="menu-icon">🗑️</div><div>Kelola Informasi TPS</div></a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="content-header">
        <h2>Kelola Artikel Edukasi</h2>
    </div>

    <div class="form-container">
        <div class="form-title">Tambah Artikel Baru</div>

        <!-- Form dengan method POST dan enctype untuk upload file -->
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group">
                <label class="form-label">Upload Foto</label>
                <div class="upload-area" id="uploadArea">
                     <div class="upload-icon">📁</div>
                     <div class="upload-text">Seret atau klik untuk upload foto artikel</div>
                      <input type="file" id="fotoInput" name="foto" accept="image/*" onchange="previewImage(event)">
                     <div class="upload-preview" id="uploadPreview"></div>
                </div>
            </div>

    <div class="form-group">
        <label class="form-label">Judul Artikel</label>
        <input type="text" class="form-input" name="judul" placeholder="Masukkan judul artikel" required>
    </div>
</div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tanggal Publikasi</label>
                    <input type="date" class="form-input" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Deskripsi Artikel</label>
                    <textarea class="form-textarea" name="deskripsi" placeholder="Masukkan deskripsi artikel..." required></textarea>
                </div>
            </div>

            <div class="action-buttons">
                <a href="kelolaArtikel.php" class="btn btn-secondary">RESET</a>
                <button type="submit" class="btn btn-primary">SIMPAN ARTIKEL</button>
            </div>
        </form>
    </div>
</div>

<script>
 // Pastikan area upload bisa diklik untuk membuka file picker
    document.getElementById('uploadArea').addEventListener('click', function() {
        document.getElementById('fotoInput').click();
    });

    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;

        const preview = document.getElementById('uploadPreview');
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        preview.innerHTML = '';
        preview.appendChild(img);
        preview.style.display = 'block';
    }
</script>
</body>
</html>