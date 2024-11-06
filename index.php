<?php
include 'db.php';
session_start();

// Cek jika pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Ambil pilihan sorting dari GET parameter, default adalah 'asc'
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Modifikasi query untuk sorting berdasarkan judul
$sql = "SELECT * FROM buku ORDER BY judul " . ($order === 'desc' ? 'DESC' : 'ASC');
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan</title>
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
            margin-top: 20px;
            font-size: 2.5em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .greeting {
            text-align: center;
            margin: 20px 0;
            font-size: 1.5em;
            color: #03DAC6;
            background-color: #1E1E1E;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        nav {
            text-align: center;
            margin: 20px 0;
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #BB86FC;
            font-weight: bold;
            transition: color 0.3s;
        }
        nav a:hover {
            color: #03DAC6;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #444;
        }
        th {
            background-color: #1E1E1E;
            color: #BB86FC;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        tr:hover {
            background-color: #333;
        }
        td img {
            border-radius: 5px;
            transition: transform 0.2s;
        }
        td img:hover {
            transform: scale(1.1);
        }
        td a {
            color: #BB86FC;
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #BB86FC;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }
        td a:hover {
            background-color: #BB86FC;
            color: #1E1E1E;
        }
        .sort-container {
            text-align: center;
            margin: 20px 0;
        }
        .sort-container select {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #BB86FC;
            background-color: #2C2C2C;
            color: #E0E0E0;
        }
    </style>
</head>
<body>
    <h1>Daftar Buku Perpustakaan</h1>
    <div>
        <?php if (isset($_SESSION['username'])): ?>
            <div class="greeting">
                Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?>! <a href="logout.php" style="color: #BB86FC;">Logout</a>
            </div>
            <nav>
                <a href="insert.php">Tambah Buku</a> | 
                <a href="index.php">Daftar Buku</a>
            </nav>
        <?php endif; ?>
    </div>

    <!-- Dropdown untuk sorting -->
    <div class="sort-container">
        <form method="GET" action="">
            <label for="order">Urutkan berdasarkan: </label>
            <select name="order" id="order" onchange="this.form.submit()">
                <option value="asc" <?= $order === 'asc' ? 'selected' : '' ?>>A-Z</option>
                <option value="desc" <?= $order === 'desc' ? 'selected' : '' ?>>Z-A</option>
            </select>
        </form>
    </div>

    <table>
        <tr>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Penerbit</th>
            <th>Tahun</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" width="100" alt="Gambar Buku"></td>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td><?= htmlspecialchars($row['penulis']) ?></td>
                <td><?= htmlspecialchars($row['penerbit']) ?></td>
                <td><?= htmlspecialchars($row['tahun']) ?></td>
                <td>
                    <a href="view.php?id=<?= htmlspecialchars($row['id_buku']) ?>">Lihat</a> | 
                    <a href="edit.php?id=<?= htmlspecialchars($row['id_buku']) ?>">Edit</a> | 
                    <a href="delete.php?id=<?= htmlspecialchars($row['id_buku']) ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a> | 
                    <a href="download.php?id=<?= htmlspecialchars($row['id_buku']) ?>">Unduh Gambar</a> <!-- Link untuk mengunduh gambar -->
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
