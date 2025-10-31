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
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
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
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
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

        .status-proses { background: #fff3cd; color: #856404; }
        .status-selesai { background: #d4edda; color: #155724; }
        .status-ditolak { background: #f8d7da; color: #721c24; }

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

            th, td {
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
        <div class="header-exit">
            <span>←</span> EXIT
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="#" class="menu-item active">
                    <div>Kelola Dashboard</div>
                </a>
            </li>
            <li>
                <a href="#" class="menu-item">
                    <div class="menu-icon">📋</div>
                    <div>Kelola Laporan Aduan</div>
                </a>
            </li>
            <li>
                <a href="#" class="menu-item">
                    <div class="menu-icon">📝</div>
                    <div>Kelola Artikel Edukasi</div>
                </a>
            </li>
            <li>
                <a href="#" class="menu-item">
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
                    <!-- Baris 1 -->
                    <tr onclick="toggleDetail(1)">
                        <td>1</td>
                        <td>Siti</td>
                        <td>siti@gmail.com</td>
                        <td><span class="status-badge status-proses">PROSES</span></td>
                    </tr>
                    <tr class="detail-row" id="detail-1">
                        <td colspan="4">
                            <div class="detail-content">
                                <div class="detail-image">
                                    <img src="https://via.placeholder.com/300x200?text=FOTO+SAMPAH" alt="Foto Sampah">
                                </div>
                                <div class="detail-form">
                                    <div class="form-group">
                                        <label class="form-label">Nama:</label>
                                        <input type="text" class="form-input" value="Siti" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email:</label>
                                        <input type="email" class="form-input" value="siti@gmail.com" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Lokasi:</label>
                                        <input type="text" class="form-input" value="Jl. Raya Negara, Kec. Banyuwangi" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tanggal:</label>
                                        <input type="text" class="form-input" value="28-10-2025" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Keterangan:</label>
                                        <textarea class="form-textarea" readonly>Sampah sudah penuh belum diambil, mohon untuk mengambil sampah tersebut.</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status:</label>
                                        <div class="status-options">
                                            <div class="status-option">
                                                <input type="radio" id="status-proses-1" name="status-1" value="PROSES" checked>
                                                <label for="status-proses-1">Proses</label>
                                            </div>
                                            <div class="status-option">
                                                <input type="radio" id="status-selesai-1" name="status-1" value="SELESAI">
                                                <label for="status-selesai-1">Selesai</label>
                                            </div>
                                            <div class="status-option">
                                                <input type="radio" id="status-ditolak-1" name="status-1" value="DITOLAK">
                                                <label for="status-ditolak-1">Ditolak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn-secondary" onclick="closeDetail(1)">KEMBALI</button>
                                        <button class="btn-primary" onclick="saveStatus(1)">SIMPAAN</button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Baris 2 -->
                    <tr onclick="toggleDetail(2)">
                        <td>2</td>
                        <td>Akbar</td>
                        <td>akbar@gmail.com</td>
                        <td><span class="status-badge status-proses">PROSES</span></td>
                    </tr>
                    <tr class="detail-row" id="detail-2">
                        <td colspan="4">
                            <div class="detail-content">
                                <div class="detail-image">
                                    <img src="https://via.placeholder.com/300x200?text=FOTO+SAMPAH" alt="Foto Sampah">
                                </div>
                                <div class="detail-form">
                                    <div class="form-group">
                                        <label class="form-label">Nama:</label>
                                        <input type="text" class="form-input" value="Akbar" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email:</label>
                                        <input type="email" class="form-input" value="akbar@gmail.com" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Lokasi:</label>
                                        <input type="text" class="form-input" value="Jl. Sudirman, Kec. Banyuwangi" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tanggal:</label>
                                        <input type="text" class="form-input" value="27-10-2025" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Keterangan:</label>
                                        <textarea class="form-textarea" readonly>Sampah plastik menumpah di pinggir jalan, mohon segera ditangani.</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status:</label>
                                        <div class="status-options">
                                            <div class="status-option">
                                                <input type="radio" id="status-proses-2" name="status-2" value="PROSES" checked>
                                                <label for="status-proses-2">Proses</label>
                                            </div>
                                            <div class="status-option">
                                                <input type="radio" id="status-selesai-2" name="status-2" value="SELESAI">
                                                <label for="status-selesai-2">Selesai</label>
                                            </div>
                                            <div class="status-option">
                                                <input type="radio" id="status-ditolak-2" name="status-2" value="DITOLAK">
                                                <label for="status-ditolak-2">Ditolak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn-secondary" onclick="closeDetail(2)">KEMBALI</button>
                                        <button class="btn-primary" onclick="saveStatus(2)">SIMPAAN</button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Baris 3 -->
                    <tr onclick="toggleDetail(3)">
                        <td>3</td>
                        <td>Lutfan</td>
                        <td>lutfan@gmail.com</td>
                        <td><span class="status-badge status-selesai">SELESAI</span></td>
                    </tr>
                    <tr class="detail-row" id="detail-3">
                        <td colspan="4">
                            <div class="detail-content">
                                <div class="detail-image">
                                    <img src="https://via.placeholder.com/300x200?text=FOTO+SAMPAH" alt="Foto Sampah">
                                </div>
                                <div class="detail-form">
                                    <div class="form-group">
                                        <label class="form-label">Nama:</label>
                                        <input type="text" class="form-input" value="Lutfan" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email:</label>
                                        <input type="email" class="form-input" value="lutfan@gmail.com" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Lokasi:</label>
                                        <input type="text" class="form-input" value="Jl. Pahlawan, Kec. Banyuwangi" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tanggal:</label>
                                        <input type="text" class="form-input" value="26-10-2025" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Keterangan:</label>
                                        <textarea class="form-textarea" readonly>Sampah organik menumpah di dekat sekolah, sudah diangkat oleh petugas.</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status:</label>
                                        <div class="status-options">
                                            <div class="status-option">
                                                <input type="radio" id="status-proses-3" name="status-3" value="PROSES">
                                                <label for="status-proses-3">Proses</label>
                                            </div>
                                            <div class="status-option">
                                                <input type="radio" id="status-selesai-3" name="status-3" value="SELESAI" checked>
                                                <label for="status-selesai-3">Selesai</label>
                                            </div>
                                            <div class="status-option">
                                                <input type="radio" id="status-ditolak-3" name="status-3" value="DITOLAK">
                                                <label for="status-ditolak-3">Ditolak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn-secondary" onclick="closeDetail(3)">KEMBALI</button>
                                        <button class="btn-primary" onclick="saveStatus(3)">SIMPAAN</button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Baris 4 -->
                    <tr onclick="toggleDetail(4)">
                        <td>4</td>
                        <td>Ratih</td>
                        <td>ratih@gmail.com</td>
                        <td><span class="status-badge status-ditolak">DITOLAK</span></td>
                    </tr>
                    <tr class="detail-row" id="detail-4">
                        <td colspan="4">
                            <div class="detail-content">
                                <div class="detail-image">
                                    <img src="https://via.placeholder.com/300x200?text=FOTO+SAMPAH" alt="Foto Sampah">
                                </div>
                                <div class="detail-form">
                                    <div class="form-group">
                                        <label class="form-label">Nama:</label>
                                        <input type="text" class="form-input" value="Ratih" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email:</label>
                                        <input type="email" class="form-input" value="ratih@gmail.com" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Lokasi:</label>
                                        <input type="text" class="form-input" value="Jl. Merdeka, Kec. Banyuwangi" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tanggal:</label>
                                        <input type="text" class="form-input" value="25-10-2025" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Keterangan:</label>
                                        <textarea class="form-textarea" readonly>Foto tidak jelas, lokasi tidak spesifik. Mohon dilengkapi.</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status:</label>
                                        <div class="status-options">
                                            <div class="status-option">
                                                <input type="radio" id="status-proses-4" name="status-4" value="PROSES">
                                                <label for="status-proses-4">Proses</label>
                                            </div>
                                            <div class="status-option">
                                                <input type="radio" id="status-selesai-4" name="status-4" value="SELESAI">
                                                <label for="status-selesai-4">Selesai</label>
                                            </div>
                                            <div class="status-option">
                                                <input type="radio" id="status-ditolak-4" name="status-4" value="DITOLAK" checked>
                                                <label for="status-ditolak-4">Ditolak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn-secondary" onclick="closeDetail(4)">KEMBALI</button>
                                        <button class="btn-primary" onclick="saveStatus(4)">SIMPAAN</button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
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

        // Save status
        function saveStatus(id) {
            const selectedStatus = document.querySelector(`input[name="status-${id}"]:checked`).value;
            const statusBadge = document.querySelector(`#detail-${id} .status-badge`);
            
            // Update badge
            statusBadge.textContent = selectedStatus;
            statusBadge.className = `status-badge status-${selectedStatus.toLowerCase()}`;
            
            // Update row status (optional)
            const row = document.querySelector(`tr:nth-child(${id + 1})`);
            const statusCell = row.cells[3];
            statusCell.innerHTML = `<span class="status-badge status-${selectedStatus.toLowerCase()}">${selectedStatus}</span>`;
            
            alert(`Status laporan ID ${id} berhasil diubah menjadi ${selectedStatus}`);
            
            // Close detail after save
            closeDetail(id);
        }

        // Search functionality (dummy)
        document.querySelector('.search-btn').addEventListener('click', function() {
            const query = document.querySelector('.search-input').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                if (name.includes(query) || email.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Enter key search
        document.querySelector('.search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.querySelector('.search-btn').click();
            }
        });
    </script>
</body>

</html>