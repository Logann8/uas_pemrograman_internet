<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id > 0) {
    // Cek apakah kamar sedang terisi
    $cek = mysqli_query($conn, "SELECT 1 FROM tb_kmr_penghuni WHERE id_kamar='$id' AND tgl_keluar IS NULL");
    if (mysqli_num_rows($cek) == 0) {
        mysqli_query($conn, "DELETE FROM tb_kamar WHERE id='$id'");
    }
}
header('Location: kelola_kamar.php');
exit; 