<?php
session_start();
include "koneksi.php";

$pesan = "";

if (isset($_POST['btn_login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $pesan = "Username dan password tidak boleh kosong!";
    } else {
        $query  = "SELECT * FROM tb_login WHERE username = '$username' AND password = MD5('$password')";
        $hasil  = mysqli_query($koneksi, $query);
        $jumlah = mysqli_num_rows($hasil);

        if ($jumlah == 1) {
            $data = mysqli_fetch_assoc($hasil);
            $_SESSION['id_user']  = $data['id_user'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role']     = $data['role'];

            if ($data['role'] == 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard_mahasiswa.php");
            }
            exit();
        } else {
            $pesan = "Username atau password salah!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT Prambanan Beton</title>
    <style>
        /* ---- CSS UNTUK TAMPILAN PROTOTIPE ---- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        body {
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .main-container {
            display: flex;
            width: 1000px;
            height: 600px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        /* Sisi Kiri (Hijau) */
        .left-side {
            flex: 1.2;
            background-color: #14532d; /* Hijau Tua sesuai prototipe */
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }

        .left-side img.logo-big {
            width: 280px;
            margin-bottom: 20px;
        }

        .left-side h1 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .left-side p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.9;
            max-width: 400px;
        }

        .footer-text {
            position: absolute;
            bottom: 30px;
            font-size: 12px;
            opacity: 0.7;
        }

        /* Sisi Kanan (Form) */
        .right-side {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #f8fafc;
        }

        .login-box {
            width: 100%;
            max-width: 350px;
            margin: 0 auto;
        }

        .login-box img.logo-small {
            width: 120px;
            display: block;
            margin: 0 auto 15px;
        }

        .login-box h2 {
            text-align: center;
            color: #1e293b;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .login-box p.welcome-back {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            margin-bottom: 30px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 20px;
            background: #ffffff;
            transition: 0.3s;
        }

        input:focus {
            border-color: #14532d;
            outline: none;
            box-shadow: 0 0 0 3px rgba(20, 83, 45, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: #14532d;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #166534;
            transform: translateY(-2px);
        }

        .error-msg {
            background-color: #fef2f2;
            color: #991b1b;
            padding: 10px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            border: 1px solid #fee2e2;
        }

        .link-register {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: #64748b;
        }

        .link-register a {
            color: #14532d;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="main-container">
    <div class="left-side">
        <img src="logo_prambanan.png" alt="Logo PT Prambanan Beton" class="logo-big">
        <h1>PT PRAMBANAN BETON</h1>
        <p>Sistem ERP untuk manajemen proyek, penjualan, dan laporan perusahaan secara terintegrasi. Silakan login untuk mengakses dashboard sesuai role Anda.</p>
        
        <div class="footer-text">© 2026 PT Prambanan Beton</div>
    </div>

    <div class="right-side">
        <div class="login-box">
            <img src="logo_prambanan.png" alt="Logo Small" class="logo-small">
            <h2>Masuk Akun Prambanan</h2>
            <p class="welcome-back">Selamat datang kembali</p>

            <?php if ($pesan != "") : ?>
                <div class="error-msg">⚠️ <?= $pesan ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <label>Username / Email</label>
                <input type="text" name="username" placeholder="username" required>

                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>

                <button type="submit" name="btn_login" class="btn-login">Masuk</button>
            </form>

            <div class="link-register">
                Belum punya akun? <a href="register.php">Daftar di sini</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>