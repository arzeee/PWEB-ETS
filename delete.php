<?php
include 'db.php';
session_start();

$id = $_GET['id'];
$sql = "DELETE FROM buku WHERE id_buku = $id";
$conn->query($sql);

header("Location: index.php");
?>
