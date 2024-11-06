<?php
session_start();
session_unset(); // Menghapus semua session variables
session_destroy(); // Menghancurkan session

// Hapus cookie
setcookie("username", "", time() - 3600, "/"); // Menghapus cookie dengan waktu kedaluwarsa yang sudah lewat

header("Location: login.php"); // Kembali ke halaman login
exit();
?>
