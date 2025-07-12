<?php
include 'koneksi.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    // Cek username sudah ada atau belum
    $cek = mysqli_query($conn, "SELECT id FROM user WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $message = 'Username sudah terdaftar!';
    } else {
        $q = mysqli_query($conn, "INSERT INTO user (username, password, nama) VALUES ('$username', '$password', '$nama')");
        if ($q) {
            $message = 'Registrasi berhasil! Silakan login.';
        } else {
            $message = 'Registrasi gagal!';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register Pemilik Kost</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .register-container {
            max-width: 400px;
            margin: 60px auto;
            background: rgba(255,255,255,0.92);
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            padding: 32px 32px 24px 32px;
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 24px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        input[type="text"], input[type="password"] {
            padding: 9px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 15px;
        }
        button {
            background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
            color: #fff;
            border: none;
            padding: 10px 0;
            border-radius: 24px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.2s;
        }
        button:hover {
            background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%);
        }
        .message {
            text-align: center;
            color: #dc3545;
            margin-bottom: 10px;
        }
        .success {
            color: #28a745;
        }
        a {
            display: inline-block;
            margin-top: 18px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register Pemilik Kost</h2>
        <?php if ($message): ?>
            <div class="message<?= $message === 'Registrasi berhasil! Silakan login.' ? ' success' : '' ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Daftar</button>
        </form>
        <a href="login.php">Sudah punya akun? Login</a>
        <a href="index.php">&larr; Kembali</a>
    </div>
</body>
</html> 