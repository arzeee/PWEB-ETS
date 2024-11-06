<?php
include 'db.php';
session_start();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ambil ID dari URL
    $sql = "SELECT gambar FROM buku WHERE id_buku = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file = 'uploads/' . $row['gambar'];

        // Cek apakah file ada
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        } else {
            echo "<script>alert('File tidak ditemukan.');</script>";
        }
    } else {
        echo "<script>alert('Buku tidak ditemukan.');</script>";
    }
} else {
    echo "<script>alert('ID buku tidak valid.');</script>";
}
?>
