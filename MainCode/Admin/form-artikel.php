<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Artikel - SIMPELSI</title>
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

        /* Form Container */
        .form-container {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            max-width: 800px;
            margin: 0 auto;
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
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #2e8b57;
            box-shadow: 0 0 0 2px rgba(46, 139, 87, 0.1);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        /* Upload Area */
        .upload-area {
            border: 2px dashed #ccc;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background: #fafafa;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .upload-area:hover {
            border-color: #2e8b57;
            background: #f0f9f4;
        }

        .upload-area input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
        }

        .upload-icon {
            font-size: 36px;
            color: #888;
            margin-bottom: 10px;
        }

        .upload-text {
            color: #666;
            font-size: 14px;
        }

        .upload-preview {
            margin-top: 15px;
            display: none;
        }

        .upload-preview img {
            max-width: 100%;
            max-height: 150px;
            border-radius: 6px;
            object-fit: contain;
            border: 1px solid #ddd;
        }

        /* Date Picker */
        .date-input {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .date-input input {
            flex: 1;
        }

        .date-icon {
            color: #888;
            cursor: pointer;
            padding: 5px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 25px;
            justify-content: flex-start;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: background 0.2s;
        }

        .btn-primary {
            background: #2e8b57;
            color: white;
        }

        .btn-primary:hover {
            background: #226b42;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
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

            .form-row {
                flex-direction: column;
                gap: 15px;
            }

            .form-group {
                min-width: 100%;
            }

            .upload-area {
                padding: 15px;
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

            .form-container {
                padding: 15px;
            }

            .form-title {
                font-size: 18px;
            }

            .action-buttons {
                flex-direction: column;
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
        <div class="header-exit">
            <span>←</span> EXIT
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="laporan.html" class="menu-item">
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
                <a href="tps.html" class="menu-item">
                    <div class="menu-icon">🗑️</div>
                    <div>Kelola Informasi TPS</div>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h2>Kelola Artikel Edukasi</h2>
        </div>

        <div class="form-container">
            <div class="form-title">Tambah/Edit Artikel</div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Upload Foto</label>
                    <div class="upload-area" id="uploadArea">
                        <div class="upload-icon">📁</div>
                        <div class="upload-text">Seret atau klik untuk upload foto artikel</div>
                        <input type="file" id="fotoInput" accept="image/*" onchange="previewImage(event)">
                        <div class="upload-preview" id="uploadPreview"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Judul Artikel</label>
                    <input type="text" class="form-input" id="judulInput" placeholder="Masukkan judul artikel" value="">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tanggal Publikasi</label>
                    <div class="date-input">
                        <input type="date" class="form-input" id="tanggalInput" value="2025-10-30">
                        <div class="date-icon">📅</div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Deskripsi Artikel</label>
                    <textarea class="form-textarea" id="deskripsiInput" placeholder="Masukkan deskripsi artikel..."></textarea>
                </div>
            </div>

            <div class="action-buttons">
                <button class="btn btn-secondary" onclick="resetForm()">KEMBALI</button>
                <button class="btn btn-primary" onclick="simpanArtikel()">SIMPAN</button>
                <button class="btn btn-danger" onclick="hapusArtikel()" style="display:none;" id="hapusBtn">HAPUS</button>
            </div>
        </div>
    </div>

    <script>
        // Simulasikan data artikel (nanti ganti dengan fetch dari API)
        let currentArticle = null;

        // Preview gambar saat diupload
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

        // Reset form
        function resetForm() {
            document.getElementById('fotoInput').value = '';
            document.getElementById('judulInput').value = '';
            document.getElementById('tanggalInput').value = '2025-10-30';
            document.getElementById('deskripsiInput').value = '';
            document.getElementById('uploadPreview').style.display = 'none';
            document.getElementById('hapusBtn').style.display = 'none';
            currentArticle = null;
            window.location.href = 'kelolaArtikel.php'; // 👈 arahkan ke sini
        }

        // Simpan artikel (nanti ganti dengan fetch PUT/POST)
        function simpanArtikel() {
            const judul = document.getElementById('judulInput').value.trim();
            const tanggal = document.getElementById('tanggalInput').value;
            const deskripsi = document.getElementById('deskripsiInput').value.trim();

            if (!judul || !deskripsi) {
                alert('Judul dan deskripsi wajib diisi!');
                return;
            }

            if (currentArticle) {
                alert(`Artikel "${judul}" berhasil diperbarui!`);
            } else {
                alert(`Artikel "${judul}" berhasil disimpan!`);
            }

            // Di sini kamu bisa kirim ke server via fetch()
            // Contoh: fetch('/api/artikel', { method: 'POST', body: JSON.stringify(...) })

            resetForm();
        }

        // Hapus artikel (jika sedang edit)
        function hapusArtikel() {
            if (confirm('Yakin ingin menghapus artikel ini?')) {
                alert('Artikel berhasil dihapus!');
                resetForm();
            }
        }

        // Jika ingin edit artikel, panggil fungsi ini dengan data
        function loadArtikel(data) {
            currentArticle = data;
            document.getElementById('judulInput').value = data.judul || '';
            document.getElementById('tanggalInput').value = data.tanggal || '2025-10-30';
            document.getElementById('deskripsiInput').value = data.deskripsi || '';

            if (data.fotoUrl) {
                const preview = document.getElementById('uploadPreview');
                const img = document.createElement('img');
                img.src = data.fotoUrl;
                preview.innerHTML = '';
                preview.appendChild(img);
                preview.style.display = 'block';
            }

            document.getElementById('hapusBtn').style.display = 'inline-block';
        }

        // Contoh: loadArtikel({ id: 1, judul: "Cara Memilah Sampah", tanggal: "2025-10-25", deskripsi: "Sampah harus dipilah...", fotoUrl: "https://via.placeholder.com/300x200  " });
    </script>
</body>

</html>