<?php
include 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $kamar = $_POST['kamar'];
    mysqli_query($conn, "INSERT INTO penghuni (nama, kamar) VALUES ('$nama', '$kamar')");
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Penghuni</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 60px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 32px 32px 24px 32px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        input[type="text"] {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 15px;
        }
        button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 0;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.2s;
        }
        button:hover {
            background: #0056b3;
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
    <div class="container">
        <h1>Tambah Penghuni Kost</h1>
        <form method="post">
            <label>Nama:
                <input type="text" name="nama" required>
            </label>
            <label>Kamar:
                <input type="text" name="kamar" required>
            </label>
            <button type="submit">Simpan</button>
        </form>
        <a href="index.php">&larr; Kembali</a>
    </div>
</body>
</html> 