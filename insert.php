<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $deskripsi = $_POST['deskripsi']; // Ambil deskripsi
    
    // Upload gambar
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file adalah gambar
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>alert('File bukan gambar.');</script>";
        $uploadOk = 0;
    }

    // Cek ukuran file (misalnya maksimum 2MB)
    if ($_FILES["gambar"]["size"] > 2000000) {
        echo "<script>alert('Ukuran gambar terlalu besar.');</script>";
        $uploadOk = 0;
    }

    // Hanya izinkan format tertentu
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "<script>alert('Hanya file JPG, JPEG, dan PNG yang diperbolehkan.');</script>";
        $uploadOk = 0;
    }

    // Jika uploadOk = 0, upload gagal
    if ($uploadOk == 0) {
        echo "<script>alert('Maaf, gambar gagal diunggah.');</script>";
    } else {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar = basename($_FILES["gambar"]["name"]);
            
            // Simpan data buku dan nama gambar ke database
            $sql = "INSERT INTO buku (judul, penulis, penerbit, tahun, gambar, deskripsi) VALUES ('$judul', '$penulis', '$penerbit', '$tahun', '$gambar', '$deskripsi')";
            if ($conn->query($sql) === TRUE) {
                header("Location: index.php");
                exit; // Pastikan untuk menghentikan eksekusi script setelah header
            } else {
                echo "<script>alert('Error: " . $sql . " " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengunggah gambar.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku</title>
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
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #BB86FC;
            border-radius: 4px;
            background-color: #2C2C2C;
            color: #E0E0E0;
        }
        textarea {
            resize: vertical; /* Allow vertical resizing */
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
    <h2>Tambah Buku</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="judul">Judul:</label>
        <input type="text" name="judul" required id="judul">

        <label for="deskripsi">Deskripsi:</label>
        <textarea name="deskripsi" required id="deskripsi" rows="4"></textarea>
        
        <label for="penulis">Penulis:</label>
        <input type="text" name="penulis" required id="penulis">
        
        <label for="penerbit">Penerbit:</label>
        <input type="text" name="penerbit" required id="penerbit">
        
        <label for="tahun">Tahun:</label>
        <input type="number" name="tahun" required id="tahun">
        
        <label for="gambar">Gambar Buku:</label>
        <input type="file" name="gambar" required id="gambar">
        
        <div class="button-container">
            <input type="submit" value="Tambah Buku">
            <a href="index.php" class="cancel-button">Batal</a>
        </div>
    </form>
</body>
</html>
