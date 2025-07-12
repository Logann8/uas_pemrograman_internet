<?php
session_start();
include 'koneksi.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $q = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    if ($row = mysqli_fetch_assoc($q)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama'] = $row['nama'];
            header('Location: index.php');
            exit;
        } else {
            $message = 'Password salah!';
        }
    } else {
        $message = 'Username tidak ditemukan!';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Pemilik Kost</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .login-container {
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
    <div class="login-container">
        <h2>Login Pemilik Kost</h2>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="register.php">Belum punya akun? Daftar</a>
        <a href="index.php">&larr; Kembali</a>
    </div>
</body>
</html> 