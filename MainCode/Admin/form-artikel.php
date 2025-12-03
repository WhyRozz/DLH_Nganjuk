<?php
// Koneksi database
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

// Inisialisasi variabel
$id = null;
$judul = '';
$deskripsi = '';
$tanggal = date('Y-m-d\TH:i');
$fotoLama = '';

// Jika edit
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM artikel WHERE id_artikel = ?");
    $stmt->execute([$id]);
    $artikel = $stmt->fetch();
    if ($artikel) {
        $judul = htmlspecialchars($artikel['judul'], ENT_QUOTES, 'UTF-8');
        $deskripsi = $artikel['deskripsi'];
        $tanggal = date('Y-m-d\TH:i', strtotime($artikel['tanggal']));
        $fotoLama = $artikel['foto'];
    } else {
        die("Artikel tidak ditemukan.");
    }
}

// Handle simpan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $judul = trim($_POST['judul'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $tanggal = $_POST['tanggal'] ?? '';

    if (empty($judul) || empty($deskripsi) || empty($tanggal)) {
        $error = "Judul, deskripsi, dan tanggal wajib diisi!";
    } else {
        $fotoNama = $fotoLama;
        if (!empty($_FILES['foto']['name'])) {
            // ✅ SESUAIKAN PATH SESUAI STRUKTUR FISIK:
            // Jika: MainCode/Admin/form-artikel.php
            // Maka: ../../../api/uploads/artikel/
            $targetDir = "../../../api/uploads/artikel/";

            // Buat folder jika belum ada
            if (!is_dir($targetDir)) {
                if (!mkdir($targetDir, 0755, true)) {
                    $error = "Gagal membuat folder uploads. Pastikan permission 'api/uploads/artikel/' = 755.";
                }
            }

            $fileExt = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif'])) {
                $error = "Format gambar tidak didukung! Gunakan: JPG, JPEG, PNG, GIF.";
            } else {
                // ✅ HAPUS FOTO LAMA DARI SERVER (jika ada & beda dari yang baru)
                if ($fotoLama && $fotoLama !== $fotoNama && file_exists($targetDir . $fotoLama)) {
                    unlink($targetDir . $fotoLama);
                }

                $fotoNama = uniqid('artikel_') . '.' . $fileExt;
                $targetFile = $targetDir . $fotoNama;

                if (!move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
                    $error = "Gagal upload gambar. Periksa: 1) Ukuran file ≤ 2MB, 2) Permission folder = 755.";
                }
            }
        }

        if (empty($error)) {
            try {
                if ($id) {
                    $stmt = $pdo->prepare("UPDATE artikel SET judul = ?, deskripsi = ?, tanggal = ?, foto = ? WHERE id_artikel = ?");
                    $stmt->execute([$judul, $deskripsi, $tanggal, $fotoNama, $id]);
                    $pesan = "Artikel berhasil diperbarui!";
                } else {
                    $stmt = $pdo->prepare("INSERT INTO artikel (judul, deskripsi, tanggal, foto) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$judul, $deskripsi, $tanggal, $fotoNama]);
                    $pesan = "Artikel berhasil disimpan!";
                }
                header("Location: kelolaArtikel.php?pesan=" . urlencode($pesan));
                exit;
            } catch (Exception $e) {
                $error = "Gagal menyimpan ke database: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? 'Edit' : 'Tambah' ?> Artikel - SIMPELSI</title>
    <style>
        /* --- STYLE SAMA --- */
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
        .upload-preview { margin-top: 15px; display: <?= $fotoLama ? 'block' : 'none' ?>; }
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

<?php if (isset($error)): ?>
<script>alert("<?= addslashes($error) ?>");</script>
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
    <a href="kelolaArtikel.php" class="header-exit"><span>←</span> BATAL</a>
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
        <h2><?= $id ? 'Edit' : 'Tambah' ?> Artikel Edukasi</h2>
    </div>

    <div class="form-container">
        <div class="form-title"><?= $id ? 'Edit' : 'Tambah' ?> Artikel</div>

        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Upload Foto</label>
                    <div class="upload-area" id="uploadArea">
                        <div class="upload-icon">📁</div>
                        <div class="upload-text">Klik untuk upload foto artikel</div>
                        <input type="file" id="fotoInput" name="foto" accept="image/*" onchange="previewImage(event)">
                        <div class="upload-preview" id="uploadPreview">
                            <?php if ($fotoLama): ?>
                                <!-- ✅ TAMPILKAN FOTO DARI URL YANG BENAR -->
                                <img src="/api/uploads/artikel/<?= htmlspecialchars($fotoLama) ?>" alt="Foto artikel">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Judul Artikel</label>
                    <input type="text" class="form-input" name="judul" value="<?= htmlspecialchars($judul, ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tanggal Publikasi</label>
                    <input type="datetime-local" class="form-input" name="tanggal" value="<?= $tanggal ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Deskripsi Artikel</label>
                    <textarea class="form-textarea" name="deskripsi" required><?= htmlspecialchars($deskripsi, ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
            </div>

            <div class="action-buttons">
                <a href="kelolaArtikel.php" class="btn btn-secondary">BATAL</a>
                <button type="submit" class="btn btn-primary"><?= $id ? 'PERBARUI' : 'SIMPAN' ?> ARTIKEL</button>
            </div>
        </form>
    </div>
</div>

<script>
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