<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id > 0) {
    mysqli_query($conn, "DELETE FROM tb_barang WHERE id='$id'");
}
header('Location: kelola_barang.php');
exit; 