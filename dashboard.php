<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
$penghuni = [];
$res = mysqli_query($conn, "SELECT * FROM penghuni");
while ($row = mysqli_fetch_assoc($res)) {
    $penghuni[$row['kamar']] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kamar Kosan Melati</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: rgba(255,255,255,0.95);
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            padding: 36px 44px 44px 44px;
            border: 2px solid #e3e8f0;
            animation: fadeIn 1.2s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 28px;
        }
        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            justify-content: center;
        }
        .kamar-box {
            width: 90px;
            height: 140px;
            background: #f7fafd;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .nomor {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .status {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            margin-bottom: 8px;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #e3e8f0;
        }
        .isi {
            background: #28a745;
        }
        .kosong {
            background: #dc3545;
        }
        .nama {
            font-size: 0.95rem;
            color: #333;
            text-align: center;
            margin-bottom: 2px;
        }
        .detail {
            font-size: 0.85rem;
            color: #555;
            text-align: center;
            margin-bottom: 2px;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
            color: #fff;
            padding: 5px 14px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            border: none;
            box-shadow: 0 2px 8px rgba(0,123,255,0.10);
            transition: background 0.2s, transform 0.2s;
            cursor: pointer;
        }
        .btn:hover {
            background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%);
            transform: scale(1.04);
        }
        .info-btn {
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            margin: 0 auto 4px auto;
            box-shadow: 0 1px 4px rgba(40,167,69,0.10);
            transition: background 0.2s;
        }
        .info-btn:hover {
            background: #218838;
        }
        .modal-bg {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0; top: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.3);
            align-items: center;
            justify-content: center;
        }
        .modal {
            background: #fff;
            border-radius: 12px;
            padding: 28px 32px 18px 32px;
            min-width: 260px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            text-align: center;
            position: relative;
        }
        .modal h3 {
            margin: 0 0 12px 0;
            color: #007bff;
        }
        .modal .close-btn {
            position: absolute;
            top: 10px;
            right: 16px;
            background: none;
            border: none;
            font-size: 1.3rem;
            color: #888;
            cursor: pointer;
        }
        @media (max-width: 600px) {
            .container {
                padding: 16px 2vw 24px 2vw;
            }
            .grid {
                gap: 10px;
            }
            .kamar-box {
                width: 70px;
                height: 120px;
            }
            .nomor {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kamar Kosan Melati</h1>
        <div class="grid">
            <?php for ($i=1; $i<=30; $i++): ?>
            <div class="kamar-box">
                <div class="nomor"><?= $i ?></div>
                <div class="status <?= isset($penghuni[$i]) ? 'isi' : 'kosong' ?>"></div>
                <?php if (isset($penghuni[$i])): ?>
                    <button class="info-btn" onclick="showModal('<?= htmlspecialchars(addslashes($penghuni[$i]['nama'])) ?>','<?= htmlspecialchars(addslashes($penghuni[$i]['alamat'])) ?>','<?= $penghuni[$i]['id'] ?>','<?= htmlspecialchars(addslashes($penghuni[$i]['jenis_kelamin'])) ?>')" title="Lihat detail">i</button>
                    <div class="nama" style="color:#28a745;font-weight:bold;">ISI</div>
                    <div class="nama"><?= htmlspecialchars($penghuni[$i]['nama']) ?></div>
                <?php else: ?>
                    <div class="nama" style="color:#dc3545;">KOSONG</div>
                    <a href="tambah.php?kamar=<?= $i ?>" class="btn">Isi Data</a>
                <?php endif; ?>
            </div>
            <?php endfor; ?>
        </div>
        <div class="modal-bg" id="modalBg">
            <div class="modal" id="modalBox">
                <button class="close-btn" onclick="closeModal()">&times;</button>
                <h3 id="modalNama"></h3>
                <div id="modalJK"></div>
                <div id="modalAlamat"></div>
                <form id="hapusForm" method="post" action="hapus.php" style="margin-top:18px;">
                    <input type="hidden" name="id" id="modalId">
                    <button type="submit" class="btn" style="background:#dc3545;">Hapus</button>
                </form>
            </div>
        </div>
        <script>
        function showModal(nama, alamat, id, jk) {
            document.getElementById('modalNama').textContent = nama;
            document.getElementById('modalJK').textContent = 'Jenis Kelamin: ' + jk;
            document.getElementById('modalAlamat').textContent = 'Alamat: ' + alamat;
            document.getElementById('modalId').value = id;
            document.getElementById('modalBg').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('modalBg').style.display = 'none';
        }
        document.getElementById('modalBg').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
        </script>
    </div>
</body>
</html> 