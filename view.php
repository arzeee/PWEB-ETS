<?php
include 'db.php';
session_start();

// Cek jika pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM buku WHERE id_buku = $id";
$result = $conn->query($sql);
$buku = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Buku</title>
    <style>
        body {
            background-color: #121212;
            color: #E0E0E0;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #BB86FC;
        }
        .book-detail {
            max-width: 600px;
            margin: 50px auto;
            background-color: #1E1E1E;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        img {
            max-width: 100%;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="book-detail">
        <h1><?= htmlspecialchars($buku['judul']) ?></h1>
        <img src="uploads/<?= htmlspecialchars($buku['gambar']) ?>" alt="Gambar Buku">
        <p><strong>Penulis:</strong> <?= htmlspecialchars($buku['penulis']) ?></p>
        <p><strong>Penerbit:</strong> <?= htmlspecialchars($buku['penerbit']) ?></p>
        <p><strong>Tahun:</strong> <?= htmlspecialchars($buku['tahun']) ?></p>
        <p><strong>Deskripsi:</strong><br><?= nl2br(htmlspecialchars($buku['deskripsi'])) ?></p>
        <a href="index.php">Kembali ke Daftar Buku</a>
    </div>
</body>
</html>