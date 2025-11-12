<?php
session_start();

// Proteksi: hanya admin yang sudah login
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: ../login/login.php");
//     exit;
// }

// Load koneksi database — sama persis seperti di dashboardAdmin
require_once '../KoneksiDatabase/koneksi.php';

// ==========================
// PROSES TAMBAH / EDIT / HAPUS
// ==========================

$message = '';
$error = '';

// HAPUS akun (hanya tambahan, bukan default)
if (isset($_POST['hapus_id'])) {
    $hapus_id = (int)$_POST['hapus_id'];
    // Pastikan tidak hapus default (id=1 atau email default)
    $stmt = $pdo->prepare("SELECT email FROM admin WHERE id = ?");
    $stmt->execute([$hapus_id]);
    $email = $stmt->fetchColumn();
    if ($email && $email !== 'admin@simpelsi.id') {
        $stmt = $pdo->prepare("DELETE FROM admin WHERE id = ?");
        if ($stmt->execute([$hapus_id])) {
            $message = "Akun berhasil dihapus.";
        } else {
            $error = "Gagal menghapus akun.";
        }
    } else {
        $error = "Akun default tidak dapat dihapus.";
    }
}

// TAMBAH / EDIT akun
if ($_POST['action'] ?? '' === 'simpan') {
    $id = $_POST['id'] ?? null; // null = tambah baru
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validasi
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } elseif (empty($password) && !$id) {
        $error = "Password wajib diisi untuk akun baru.";
    } else {
        // Cek duplikat email (kecuali untuk edit diri sendiri)
        $stmt = $pdo->prepare("SELECT id FROM admin WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id ?: 0]);
        if ($stmt->fetch()) {
            $error = "Email sudah terdaftar.";
        } else {
            if ($id) {
                // Edit: hanya ganti email & password (jika diisi)
                $sql = "UPDATE admin SET email = ?";
                $params = [$email];
                if (!empty($password)) {
                    $sql .= ", password = ?";
                    $params[] = password_hash($password, PASSWORD_BCRYPT);
                }
                $sql .= " WHERE id = ?";
                $params[] = $id;
                $stmt = $pdo->prepare($sql);
                if ($stmt->execute($params)) {
                    $message = "Akun berhasil diperbarui.";
                } else {
                    $error = "Gagal memperbarui akun.";
                }
            } else {
                // Tambah baru
                $stmt = $pdo->prepare("INSERT INTO admin (email, password) VALUES (?, ?)");
                if ($stmt->execute([$email, password_hash($password, PASSWORD_BCRYPT)])) {
                    $message = "Akun berhasil ditambahkan.";
                } else {
                    $error = "Gagal menambah akun.";
                }
            }
        }
    }
}

// Ambil semua akun
$stmt = $pdo->query("SELECT * FROM admin ORDER BY id ASC");
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Hitung akun tambahan (selain default)
$tambahan = array_filter($admins, fn($a) => $a['email'] !== 'admin@simpelsi.id');
$jumlah_tambahan = count($tambahan);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akun - SIMPELSI</title>
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

        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Grid 3 kolom */
        .accounts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .account-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            position: relative;
        }

        .account-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #2e8b57;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }

        .account-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .account-title img {
            width: 24px;
            height: 24px;
        }

        .account-info {
            margin-bottom: 15px;
        }

        .account-info label {
            display: block;
            font-size: 12px;
            color: #666;
            margin-bottom: 4px;
        }

        .account-info span {
            font-weight: bold;
            color: #2e8b57;
        }

        .btn-group {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: #2e8b57;
            color: white;
        }

        .btn-primary:hover {
            background: #226b43;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #2e8b57;
            color: #2e8b57;
        }

        .btn-outline:hover {
            background: #e6f2e6;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        /* Form tambah/edit */
        .form-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            margin-top: 20px;
        }

        .form-section h3 {
            color: #2e8b57;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
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
            .accounts-grid {
                grid-template-columns: 1fr;
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
                <div style="font-size: 18px; font-weight: bold;">Kelola Akun</div>
                <div style="font-size: 12px; opacity: 0.9;">ADMIN</div>
            </div>
        </div>
        <a href="dashboardAdmin.php" class="header-exit">
            <span>←</span> KEMBALI
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
                <a href="kelolaTPS.php" class="menu-item">
                    <div class="menu-icon">🗑️</div>
                    <div>Kelola Informasi TPS</div>
                </a>
            </li>
            <li>
                <a href="kelolaAkun.php" class="menu-item active">
                    <div class="menu-icon">🔐</div>
                    <div>Kelola Akun</div>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="content-header">
            <h2>Kelola Akun Admin</h2>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Tampilkan 3 akun -->
        <div class="accounts-grid">
            <?php
            // Pastikan default selalu muncul pertama
            $default = array_values(array_filter($admins, fn($a) => $a['email'] === 'admin@simpelsi.id'));
            $others = array_values(array_filter($admins, fn($a) => $a['email'] !== 'admin@simpelsi.id'));

            // Tampilkan default
            if (!empty($default)) {
                $a = $default[0];
                ?>
                <div class="account-card">
                    <span class="account-badge">DEFAULT</span>
                    <div class="account-title">🔐 Akun Utama</div>
                    <div class="account-info">
                        <label>Email:</label>
                        <span><?= htmlspecialchars($a['email']) ?></span>
                    </div>
                    <div class="account-info">
                        <label>Password:</label>
                        <span>••••••••</span>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-outline" onclick="editAccount(<?= $a['id'] ?>, '<?= htmlspecialchars($a['email'], ENT_QUOTES) ?>', '')">
                            Edit
                        </button>
                    </div>
                </div>
                <?php
            }

            // Tampilkan maksimal 2 tambahan
            $count = 0;
            foreach ($others as $a) {
                if ($count >= 2) break;
                ?>
                <div class="account-card">
                    <div class="account-title">👤 Akun Tambahan</div>
                    <div class="account-info">
                        <label>Email:</label>
                        <span><?= htmlspecialchars($a['email']) ?></span>
                    </div>
                    <div class="account-info">
                        <label>Password:</label>
                        <span>••••••••</span>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-outline" 
                            onclick="editAccount(<?= $a['id'] ?>, '<?= htmlspecialchars($a['email'], ENT_QUOTES) ?>', '')">
                            Edit
                        </button>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus akun ini?')">
                            <input type="hidden" name="hapus_id" value="<?= $a['id'] ?>">
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
                <?php
                $count++;
            }

            // Jika kurang dari 3 akun, tampilkan placeholder untuk tambah
            while ($count < 2) {
                if ($count + count($default) < 3) {
                    ?>
                    <div class="account-card" style="background: #f0f9f0; border: 1px dashed #2e8b57;">
                        <div class="account-title" style="color: #2e8b57;">➕ Tambah Akun Baru</div>
                        <p style="font-size: 13px; color: #666; margin: 15px 0;">Buat akun admin cadangan untuk login alternatif.</p>
                        <button class="btn btn-primary" onclick="scrollToForm(); setTimeout(() => document.getElementById('email').focus(), 300);">
                            Tambah Akun
                        </button>
                    </div>
                    <?php
                }
                $count++;
            }
            ?>
        </div>

        <!-- Form Tambah/Edit -->
        <div class="form-section" id="formSection">
            <h3 id="formTitle">Tambah Akun Baru</h3>
            <form method="POST" id="accountForm">
                <input type="hidden" name="action" value="simpan">
                <input type="hidden" name="id" id="formId" value="">

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password (minimal 6 karakter)</label>
                    <input type="password" name="password" id="password" class="form-control" 
                        <?= !empty($_GET['edit']) ? '' : 'required' ?>>
                    <small id="passNote" style="font-size:11px; color:#666; display:block; margin-top:4px;">
                        Untuk edit: biarkan kosong jika tidak ingin ganti password.
                    </small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-outline" onclick="resetForm()">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function scrollToForm() {
            document.getElementById('formSection').scrollIntoView({ behavior: 'smooth' });
        }

        function editAccount(id, email, password) {
            document.getElementById('formId').value = id;
            document.getElementById('email').value = email;
            document.getElementById('password').value = ''; // jangan tampilkan password lama
            document.getElementById('password').removeAttribute('required');
            document.getElementById('formTitle').textContent = 'Edit Akun';
            scrollToForm();
        }

        function resetForm() {
            document.getElementById('accountForm').reset();
            document.getElementById('formId').value = '';
            document.getElementById('formTitle').textContent = 'Tambah Akun Baru';
            document.getElementById('password').setAttribute('required', 'required');
        }

        // Auto-focus jika dari link edit
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($_GET['edit']) && is_numeric($_GET['edit'])): ?>
                const id = <?= (int)$_GET['edit'] ?>;
                const admins = <?= json_encode($admins) ?>;
                const acc = admins.find(a => a.id == id);
                if (acc) editAccount(acc.id, acc.email, '');
            <?php endif; ?>
        });
    </script>
</body>
</html>