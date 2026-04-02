<?php
session_start();
include "koneksi.php";

// Proteksi Halaman: Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Cek apakah role-nya mahasiswa
if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: dashboard_admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Mahasiswa - PT Prambanan Beton</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { display: flex; background: #f8fafc; min-height: 100vh; }

        /* --- SIDEBAR (Kiri - Hijau Gelap sesuai Prototype) --- */
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
        .sidebar h2 { margin-bottom: 40px; font-size: 20px; display: flex; align-items: center; gap: 10px; }
        .menu-item { 
            display: block; 
            padding: 12px; 
            color: #ecfdf5; 
            text-decoration: none; 
            border-radius: 8px; 
            margin-bottom: 5px; 
            font-size: 14px;
            transition: 0.3s;
        }
        .menu-item.active { background: #fbbf24; color: #064e3b; font-weight: bold; }
        .menu-item:hover:not(.active) { background: #065f46; }
        .sidebar-footer { margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; }

        /* --- HEADER (Atas - Putih Bersih) --- */
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
            padding: 8px 15px;
            border-radius: 10px;
            background: #f1f5f9;
        }
        .user-icon { width: 35px; height: 35px; background: #fbbf24; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; }

        /* --- MAIN CONTENT (Area Konten) --- */
        .main { margin-left: 260px; margin-top: 70px; flex: 1; padding: 40px; }
        .banner { background: #064e3b; color: white; padding: 30px; border-radius: 15px; margin-bottom: 30px; display: flex; justify-content: space-between; }
        
        /* Stats Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-left: 5px solid #fbbf24; }
        .card small { color: #64748b; font-size: 12px; }
        .card h3 { font-size: 24px; margin: 10px 0; color: #1e293b; }

        .btn-action { background: #064e3b; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: bold; display: inline-block; margin-top: 10px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>🧱 Panel Mahasiswa</h2>
        <a href="#" class="menu-item active">📊 Dashboard</a>
        <a href="#" class="menu-item">💰 Produk & Harga</a>

        <div class="sidebar-footer">
            <a href="index.php" class="menu-item">🌐 Kembali ke Website</a>
            <a href="logout.php" class="menu-item" style="color: #fda4af;">🚪 Logout</a>
        </div>
    </div>

    <div class="header">
        <div class="user-profile">
            <div class="user-icon">👤</div>
            <div style="text-align: right;">
                <div style="font-size: 14px; font-weight: bold;"><?= htmlspecialchars($_SESSION['username']) ?></div>
                <div style="font-size: 11px; color: #64748b;">Role (Mahasiswa)</div>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="banner">
            <div>
                <h2>Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?>! 👋</h2>
                <p style="opacity: 0.8;">Selamat datang di portal informasi PT. Prambanan Beton.</p>
            </div>
            <div style="font-size: 50px;">🧱</div>
        </div>

        <div class="stats-grid">
            <div class="card">
                <small>Halaman Informasi</small>
                <h3>Dashboard</h3>
                <small>Halaman Utama Portal</small>
            </div>
            <div class="card" style="border-left-color: #064e3b;">
                <small>Katalog Produk</small>
                <h3>8 Jenis Beton</h3>
                <small>K-225 s/d K-500</small>
                <br><a href="#" class="btn-action">Lihat Katalog</a>
            </div>
        </div>

        <div class="card" style="background: white; border-left: none; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <h4 style="margin-bottom: 15px; color: #064e3b;">📌 Catatan Portal</h4>
            <p style="font-size: 14px; color: #64748b; line-height: 1.6;">Portal ini disediakan untuk akses informasi terbatas. Sebagai mahasiswa, Anda dapat melihat informasi dasar mengenai produk dan harga beton PT. Prambanan Beton. Untuk akses fitur operasional seperti penjualan atau stok material, silakan hubungi Admin Perusahaan.</p>
        </div>
    </div>

</body>
</html>