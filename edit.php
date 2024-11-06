<?php
include 'db.php';
session_start();

$id = $_GET['id'];
$sql = "SELECT * FROM buku WHERE id_buku = $id";
$result = $conn->query($sql);
$buku = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];

    $sql = "UPDATE buku SET judul='$judul', penulis='$penulis', penerbit='$penerbit', tahun='$tahun' WHERE id_buku=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit; // Pastikan untuk menghentikan eksekusi script setelah header
    } else {
        echo "<script>alert('Error: " . $sql . " " . $conn->error . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
    <style>
        body {
            background-color: #121212;
            color: #E0E0E0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            color: #BB86FC;
            margin-top: 20px;
        }
        form {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #1E1E1E;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            gap: 10px; /* Jarak antara input dan tombol */
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #BB86FC;
            border-radius: 4px;
            background-color: #2C2C2C;
            color: #E0E0E0;
        }
        .button-container {
            display: flex;
            justify-content: space-between; /* Memisahkan tombol */
        }
        input[type="submit"], .cancel-button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 48%; /* Mengatur lebar tombol agar berdampingan */
        }
        input[type="submit"] {
            background-color: #BB86FC;
            color: white;
        }
        input[type="submit"]:hover {
            background-color: #9B59B6;
        }
        .cancel-button {
            background-color: #FF4081;
            color: white;
            text-align: center; /* Agar teks tombol tetap di tengah */
            text-decoration: none; /* Menghilangkan garis bawah */
            display: flex;
            justify-content: center; /* Menengahkan teks di dalam tombol */
            align-items: center; /* Menengahkan teks secara vertikal */
        }
        .cancel-button:hover {
            background-color: #FF80AB;
        }
    </style>
</head>
<body>
    <h2>Edit Buku</h2>
    <form method="POST" action="">
        <label for="judul">Judul:</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($buku['judul']) ?>" required id="judul">
        
        <label for="penulis">Penulis:</label>
        <input type="text" name="penulis" value="<?= htmlspecialchars($buku['penulis']) ?>" required id="penulis">
        
        <label for="penerbit">Penerbit:</label>
        <input type="text" name="penerbit" value="<?= htmlspecialchars($buku['penerbit']) ?>" required id="penerbit">
        
        <label for="tahun">Tahun:</label>
        <input type="number" name="tahun" value="<?= htmlspecialchars($buku['tahun']) ?>" required id="tahun">
        
        <div class="button-container">
            <input type="submit" value="Simpan Perubahan">
            <a href="index.php" class="cancel-button">Batal</a>
        </div>
    </form>
</body>
</html>
