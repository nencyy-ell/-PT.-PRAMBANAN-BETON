<?php
session_start();
include "koneksi.php";

$pesan = "";
$jenis_pesan = ""; // Untuk menentukan warna notifikasi (sukses/error)

// ---- PROSES REGISTER ----
if (isset($_POST['btn_register'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $konfirm  = trim($_POST['konfirmasi']);
    $role     = $_POST['role'];

    // --- Validasi Input ---
    if (empty($username) || empty($password) || empty($konfirm)) {
        $pesan = "Semua kolom wajib diisi!";
        $jenis_pesan = "error";
    } elseif (strlen($username) < 4) {
        $pesan = "Username minimal harus 4 karakter!";
        $jenis_pesan = "error";
    } elseif (strlen($password) < 6) {
        $pesan = "Password minimal harus 6 karakter!";
        $jenis_pesan = "error";
    } elseif ($password !== $konfirm) {
        $pesan = "Password dan Konfirmasi Password tidak cocok!";
        $jenis_pesan = "error";
    } else {
        // Cek duplikasi username
        $cek = mysqli_query($koneksi, "SELECT * FROM tb_login WHERE username = '$username'");
        if (mysqli_num_rows($cek) > 0) {
            $pesan = "Username '$username' sudah terdaftar!";
            $jenis_pesan = "error";
        } else {
            // Hash password dengan MD5 (sesuaikan dengan sistem login kamu) 
            $password_hash = MD5($password);
            $query = "INSERT INTO tb_login (username, password, role) VALUES ('$username', '$password_hash', '$role')";
            
            if (mysqli_query($koneksi, $query)) {
                $pesan = "Akun berhasil dibuat! Silakan login.";
                $jenis_pesan = "sukses";
            } else {
                $pesan = "Terjadi kesalahan sistem.";
                $jenis_pesan = "error";
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
    <title>Daftar Akun - PT Prambanan Beton</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Arial, sans-serif; }
        
        body {
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            display: flex;
            width: 1000px;
            height: 650px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        /* Bagian Kiri (Branding) */
        .left-panel {
            flex: 1.2;
            background-color: #14532d; /* Hijau gelap sesuai prototipe */
            color: white;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }

        .left-panel h1 { font-size: 32px; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px; }
        .left-panel p { font-size: 16px; line-height: 1.6; opacity: 0.8; max-width: 400px; }
        .footer-copy { position: absolute; bottom: 30px; font-size: 12px; opacity: 0.6; }

        /* Bagian Kanan (Formulir) */
        .right-panel {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #ffffff;
        }

        .form-box { width: 100%; max-width: 360px; margin: 0 auto; }
        .form-box h2 { color: #1e293b; font-size: 24px; margin-bottom: 8px; text-align: center; }
        .form-box .sub { color: #64748b; font-size: 14px; margin-bottom: 30px; text-align: center; }

        label { display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px; }
        
        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 15px;
            transition: 0.3s;
        }

        input:focus { border-color: #14532d; outline: none; box-shadow: 0 0 0 3px rgba(20, 83, 45, 0.1); }

        .btn-reg {
            width: 100%;
            padding: 14px;
            background-color: #14532d;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-reg:hover { background-color: #166534; transform: translateY(-1px); }

        /* Notifikasi */
        .notif { padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; border: 1px solid; }
        .notif-error { background: #fef2f2; color: #991b1b; border-color: #fee2e2; }
        .notif-sukses { background: #f0fdf4; color: #166534; border-color: #dcfce7; }

        .login-link { text-align: center; margin-top: 25px; font-size: 13px; color: #64748b; }
        .login-link a { color: #14532d; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="left-panel">
        <div style="background: #fbbf24; width: 60px; height: 60px; border-radius: 50%; margin-bottom: 25px;"></div>
        <h1>PT PRAMBANAN BETON</h1>
        <p>Sistem ERP manajemen proyek terpadu. Daftarkan akun baru untuk mulai mengelola penjualan, stok, dan laporan perusahaan.</p>
        <div class="footer-copy">© 2026 PT Prambanan Beton</div>
    </div>

    <div class="right-panel">
        <div class="form-box">
            <h2>Buat Akun Baru</h2>
            <p class="sub">Daftarkan akun untuk mengakses sistem</p>

            <?php if ($pesan != "") : ?>
                <div class="notif notif-<?= $jenis_pesan ?>">
                    <?= ($jenis_pesan == 'sukses' ? '✅ ' : '⚠️ ') . $pesan ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required 
                       value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">

                <label>Password</label>
                <input type="password" name="password" placeholder="Min. 6 karakter" required>

                <label>Konfirmasi Password</label>
                <input type="password" name="konfirmasi" placeholder="Ulangi password" required>

                <label>Role / Hak Akses</label>
                <select name="role">
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="admin">Admin</option>
                </select>

                <button type="submit" name="btn_register" class="btn-reg">Daftar Sekarang</button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>