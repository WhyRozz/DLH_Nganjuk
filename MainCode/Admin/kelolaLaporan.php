<?php
// ---- KONEKSI DATABASE ----
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

// Handle AJAX update status + balasan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    header('Content-Type: application/json');
    $id = (int)($_POST['id'] ?? 0);
    $status = trim($_POST['status'] ?? '');
    $balasan = trim($_POST['balasan'] ?? '');

    if ($id > 0 && in_array($status, ['Diproses', 'Diterima', 'Ditolak'])) {
        try {
            $stmt = $pdo->prepare("UPDATE laporan SET status = ?, balasan = ? WHERE id = ?");
            $stmt->execute([$status, $balasan ?: NULL, $id]);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false]);
    }
    exit;
}

// Ambil data laporan
$stmt = $pdo->query("SELECT * FROM laporan ORDER BY id DESC");
$laporanList = $stmt->fetchAll();
$uploadPath = '../../../api/uploads/';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Laporan Aduan - SIMPELSI</title>
    <style>
        /* --- STYLE SAMA SEPERTI SEBELUMNYA --- */
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
        .search-bar {
            background: white; padding: 15px; border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px;
        }
        .search-input {
            width: 100%; padding: 8px 15px; border: 1px solid #ddd;
            border-radius: 5px; font-size: 14px;
        }
        .table-container {
            background: white; padding: 20px; border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #e6f2e6; font-weight: bold; color: #2e8b57; }
        .status-badge {
            padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold;
            display: inline-block; text-transform: uppercase;
        }
        .status-diproses { background: #fff3cd; color: #856404; }
        .status-diterima { background: #d4edda; color: #155724; }
        .status-ditolak { background: #f8d7da; color: #721c24; }
        .detail-row { display: none; background: #f9f9f9; padding: 20px; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; }
        .detail-row.active { display: table-row; }
        .detail-content {
    		display: flex;
    		gap: 20px;
    		flex-wrap: wrap;
    		align-items: flex-start; /* Agar form tidak ikut "naik" saat gambar besar */
		}
        .detail-image {
    		flex: 0 0 400px; /* Lebarkan sedikit */
    		background: #eee;
    		border-radius: 8px;
    		overflow: hidden;
    		display: flex;
    		align-items: center;
    		justify-content: center;
    		padding: 10px; /* Beri ruang sekitar gambar */
    		box-sizing: border-box;
		}
        .detail-image img {
    		width: 100%;
    		height: auto;
    		max-height: 350px; /* Naikkan batas tinggi */
    		object-fit: contain;
    		object-position: center;
    		border-radius: 8px;
    		box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    		transition: transform 0.3s ease; /* Efek hover */
		}

		.detail-image img:hover {
    		transform: scale(1.05); /* Sedikit membesar saat hover */
		}
        .detail-form { flex: 1; min-width: 300px; }
        .form-group { margin-bottom: 15px; }
        .form-label { display: block; margin-bottom: 5px; font-size: 14px; color: #555; }
        .form-input, .form-textarea {
            width: 100%; padding: 8px 12px; border: 1px solid #ddd;
            border-radius: 5px; font-size: 14px;
        }
        .form-textarea { min-height: 80px; resize: vertical; }
        .status-options {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            flex-wrap: wrap;
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
        .readonly-note {
            background: #e9ecef;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            color: #666;
            margin-top: 15px;
        }

        @media (max-width: 768px) {
            .sidebar { width: 200px; padding: 80px 15px 20px; }
            .main-content { margin-left: 200px; }
            .detail-content { flex-direction: column; }
            .detail-image {
        		flex: 0 0 100%; /* Gambar penuh lebar di mobile */
        		max-width: 100%;
    		}
    		.detail-image img {
        		max-height: 250px; /* Batas tinggi lebih kecil di mobile */
    		}
        }
        @media (max-width: 480px) {
            .sidebar { width: 100%; position: static; height: auto; border-bottom: 2px solid #2e8b57; }
            .main-content { margin-left: 0; padding-top: 100px; }
            .header { position: static; }
            .detail-image {
        		flex: 0 0 100%;
        		max-width: 100%;
    		}
    		.detail-image img {
        		max-height: 200px;
    		}
        }
    </style>
</head>
<body>

<div class="header">
    <div class="header-title">
        <div class="header-logo">S</div>
        <div>
            <div style="font-size: 18px; font-weight: bold;">Beranda</div>
            <div style="font-size: 12px; opacity: 0.9;">ADMIN</div>
        </div>
    </div>
    <a href="dashboardAdmin.php" class="header-exit"><span>←</span> KELUAR</a>
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
            <a href="kelolaLaporan.php" class="menu-item active">
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
            <a href="kelolaAkun.php" class="menu-item">
                <div class="menu-icon">🔐</div>
                <div>Kelola Akun</div>
            </a>
        </li>
    </ul>
</div>
<div class="main-content">
    <div class="content-header">
        <h2>Kelola Laporan Aduan</h2>
    </div>

    <div class="search-bar">
        <input type="text" class="search-input" id="searchInput" placeholder="Cari laporan berdasarkan nama atau lokasi...">
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAMA</th>
                    <th>LOKASI</th>
                    <th>STATUS</th>
                    <th>TANGGAL</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($laporanList as $laporan): ?>
                <?php
                    $id = $laporan['id'] ?? 0;
                    $nama = htmlspecialchars($laporan['nama'] ?? '—');
                    $lokasi = htmlspecialchars($laporan['lokasi'] ?? '—');
                    $keterangan = htmlspecialchars($laporan['keterangan'] ?? '—');
                    $status = $laporan['status'] ?? 'Diproses';
                    $balasan = htmlspecialchars($laporan['balasan'] ?? '');
                    $foto = $laporan['foto'] ?? '';
                    $tanggal = !empty($laporan['tanggal']) && $laporan['tanggal'] !== '0000-00-00'
                        ? date('d-m-Y', strtotime($laporan['tanggal']))
                        : '—';

                    $statusClass = 'diproses';
                    if ($status === 'Diterima') $statusClass = 'diterima';
                    elseif ($status === 'Ditolak') $statusClass = 'ditolak';

                    $isEditable = ($status === 'Diproses');
                ?>
                <tr onclick="toggleDetail(<?= (int)$id ?>)">
                    <td><?= $id ?></td>
                    <td><?= $nama ?></td>
                    <td><?= $lokasi ?></td>
                    <td><span class="status-badge status-<?= $statusClass ?>"><?= $status ?></span></td>
                    <td><?= $tanggal ?></td>
                </tr>
                <tr class="detail-row" id="detail-<?= (int)$id ?>">
                    <td colspan="5">
                        <div class="detail-content">
                            <div class="detail-image">
                                <?php if (!empty($foto)): ?>
                                    <img src="http://simpelsi.medianewsonline.com/api/uploads/<?= htmlspecialchars($foto) ?>" alt="Foto Laporan">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/300x200?text=Tidak+Ada+Foto" alt="Foto tidak tersedia">
                                <?php endif; ?>
                            </div>
                            <div class="detail-form">
                                <div class="form-group">
                                    <label class="form-label">ID Laporan:</label>
                                    <input type="text" class="form-input" value="<?= $id ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nama Pelapor:</label>
                                    <input type="text" class="form-input" value="<?= $nama ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Lokasi:</label>
                                    <input type="text" class="form-input" value="<?= $lokasi ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tanggal:</label>
                                    <input type="text" class="form-input" value="<?= $tanggal ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Keterangan:</label>
                                    <textarea class="form-textarea" readonly><?= $keterangan ?></textarea>
                                </div>

                                <?php if ($isEditable): ?>
                                    <div class="form-group">
                                        <label class="form-label">Status:</label>
                                        <div class="status-options">
                                            <div class="status-option">
                                                <input type="radio" name="status-<?= $id ?>" id="opt-diproses-<?= $id ?>" value="Diproses" <?= $status === 'Diproses' ? 'checked' : '' ?>>
                                                <label for="opt-diproses-<?= $id ?>">Diproses</label>
                                            </div>
                                            <div class="status-option">
                                                <input type="radio" name="status-<?= $id ?>" id="opt-diterima-<?= $id ?>" value="Diterima" <?= $status === 'Diterima' ? 'checked' : '' ?>>
                                                <label for="opt-diterima-<?= $id ?>">Diterima</label>
                                            </div>
                                            <div class="status-option">
                                                <input type="radio" name="status-<?= $id ?>" id="opt-ditolak-<?= $id ?>" value="Ditolak" <?= $status === 'Ditolak' ? 'checked' : '' ?>>
                                                <label for="opt-ditolak-<?= $id ?>">Ditolak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Balasan untuk Masyarakat:</label>
                                        <textarea class="form-textarea" id="balasan-<?= $id ?>" placeholder="Tulis alasan perubahan status (opsional)"><?= $balasan ?></textarea>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn-secondary" onclick="closeDetail(<?= $id ?>)">TUTUP</button>
                                        <button class="btn-primary" onclick="updateStatus(<?= $id ?>)">SIMPAN STATUS</button>
                                    </div>
                                <?php else: ?>
                                    <div class="form-group">
                                        <label class="form-label">Status Akhir:</label>
                                        <input type="text" class="form-input" value="<?= $status ?>" readonly>
                                    </div>
                                    <?php if (!empty($balasan)): ?>
                                    <div class="form-group">
                                        <label class="form-label">Balasan:</label>
                                        <textarea class="form-textarea" readonly><?= $balasan ?></textarea>
                                    </div>
                                    <?php endif; ?>
                                    <div class="readonly-note">
                                        Laporan ini telah ditarik. Status tidak dapat diubah lagi.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
    // LIVE SEARCH
    document.getElementById('searchInput').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr:not(.detail-row)');
        rows.forEach(row => {
            const nama = row.cells[1]?.textContent.toLowerCase() || '';
            const lokasi = row.cells[2]?.textContent.toLowerCase() || '';
            row.style.display = (nama.includes(query) || lokasi.includes(query)) ? '' : 'none';
        });
    });

    function toggleDetail(id) {
        const detail = document.getElementById(`detail-${id}`);
        const allDetails = document.querySelectorAll('.detail-row');
        allDetails.forEach(d => {
            if (d.id !== `detail-${id}`) d.classList.remove('active');
        });
        detail.classList.toggle('active');
    }

    function closeDetail(id) {
        document.getElementById(`detail-${id}`).classList.remove('active');
    }

    function updateStatus(id) {
        const selected = document.querySelector(`input[name="status-${id}"]:checked`);
        if (!selected) return alert('Pilih status terlebih dahulu.');

        const status = selected.value;
        const balasan = document.getElementById(`balasan-${id}`).value.trim();

        fetch('', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=update_status&id=${id}&status=${encodeURIComponent(status)}&balasan=${encodeURIComponent(balasan)}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Status dan balasan berhasil disimpan!');
                closeDetail(id);
                // Refresh halaman agar perubahan terlihat
                setTimeout(() => location.reload(), 300);
            } else {
                alert('Gagal menyimpan data.');
            }
        })
        .catch(() => alert('Terjadi kesalahan koneksi.'));
    }
</script>
</body>
</html>