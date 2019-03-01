<?php
session_start();
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $query = $db->prepare("UPDATE tbl_pesan SET status_pesanan = :status_pesanan WHERE id_pesan = :id_pesan");
  $query->bindParam("status_pesanan", $_POST['status_pesanan']);
  $query->bindParam("id_pesan", $_POST['id_pesan']);
  $query->execute();
  
}

// Arahkan menu ke halaman menu kembali
header("Location: $alamat_web/dapur");
?>

