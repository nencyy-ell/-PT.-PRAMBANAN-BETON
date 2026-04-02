<?php
session_start();
include "koneksi.php";

// Proteksi Halaman: Hanya Admin yang boleh masuk [cite: 173, 234]
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil data user untuk tabel [cite: 116, 117]
$query_user = "SELECT * FROM tb_login ORDER BY id_user ASC";
$hasil_user = mysqli_query($koneksi, $query_user);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - PT Prambanan Beton</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { display: flex; background: #f8fafc; min-height: 100vh; }

        /* --- SIDEBAR (Kiri) --- */
        .sidebar { 
            width: 260px; 
            background: #064e3b; 
            color: white; 
            padding: 25px; 
            position: fixed; 
            height: 100%; 
            display: flex; 
            flex-direction: column; 
        }
        .sidebar h2 { margin-bottom: 40px; font-size: 20px; }
        .menu-item { 
            display: block; 
            padding: 12px; 
            color: #ecfdf5; 
            text-decoration: none; 
            border-radius: 8px; 
            margin-bottom: 5px; 
            font-size: 14px;
        }
        .menu-item:hover { background: #065f46; }
        .sidebar-footer { margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; }

        /* --- HEADER (Atas) --- */
        .header {
            position: fixed;
            left: 260px;
            right: 0;
            height: 70px;
            background: white;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 40px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            z-index: 100;
        }
        .user-profile { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            cursor: pointer; 
            padding: 8px 15px;
            border-radius: 10px;
            transition: 0.3s;
        }
        .user-profile:hover { background: #f1f5f9; }
        .user-icon { width: 35px; height: 35px; background: #fbbf24; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; }

        /* --- MAIN CONTENT --- */
        .main { margin-left: 260px; margin-top: 70px; flex: 1; padding: 40px; }
        .banner { background: #064e3b; color: white; padding: 30px; border-radius: 15px; margin-bottom: 30px; display: flex; justify-content: space-between; }
        
        .card-table { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #f8fafc; padding: 15px; text-align: left; font-size: 12px; color: #64748b; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; }
        .badge-admin { background: #fef3c7; color: #92400e; }
        .badge-mahasiswa { background: #dcfce7; color: #166534; }
        .btn-hapus { color: #ef4444; font-weight: bold; text-decoration: none; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>🏗️ Admin Panel</h2>
        <a href="#" class="menu-item">Dashboard</a>
        <a href="#" class="menu-item">Penjualan</a>
        <a href="#" class="menu-item">Persediaan</a>
        <a href="#" class="menu-item">Marketing</a>

        <div class="sidebar-footer">
            <a href="index.php" class="menu-item">🌐 Kembali ke Website</a>
            <a href="logout.php" class="menu-item" style="color: #fda4af;">🚪 Logout</a>
        </div>
    </div>

    <div class="header">
        <a href="dashboard_admin.php" style="text-decoration: none; color: inherit;">
            <div class="user-profile">
                <div class="user-icon">👤</div>
                <div style="text-align: right;">
                    <div style="font-size: 14px; font-weight: bold;"><?= $_SESSION['username'] ?></div>
                    <div style="font-size: 11px; color: #64748b;">User (Admin)</div>
                </div>
            </div>
        </a>
    </div>

    <div class="main">
        <div class="banner">
            <div>
                <h2>Selamat datang, <?= $_SESSION['username'] ?>! 👋</h2>
                <p style="opacity: 0.8;">Kelola operasional PT. [cite_start]Prambanan Beton melalui panel kontrol ini[cite: 144].</p>
            </div>
            <div style="font-size: 50px;">🏗️</div>
        </div>

        <div class="card-table">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3>📋 Daftar Semua Pengguna</h3>
                <a href="register.php" style="background: #064e3b; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: bold;">+ Tambah Pengguna</a>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID User</th>
                        <th>Username</th>
                        <th>Password (MD5)</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($hasil_user)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['id_user'] ?></td>
                        <td><strong><?= htmlspecialchars($row['username']) ?></strong></td>
                        [cite_start]<td style="color: #cbd5e1; font-family: monospace;"><?= substr($row['password'], 0, 15) ?>... [cite: 117]</td>
                        <td>
                            <span class="badge badge-<?= $row['role'] ?>">
                                [cite_start]<?= ucfirst($row['role']) ?> [cite: 117]
                            </span>
                        </td>
                        <td>
                            <?php if ($row['id_user'] != $_SESSION['id_user']) : ?>
                                <a href="?hapus=<?= $row['id_user'] ?>" class="btn-hapus" onclick="return confirm('Yakin hapus pengguna ini?')">Hapus</a>
                            <?php else : ?>
                                <small style="color: #94a3b8;">(Anda)</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>