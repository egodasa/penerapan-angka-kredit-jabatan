<?php
session_start();
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $query = $db->prepare("INSERT INTO tbl_detail_pesan_tmp (id_pesan, id_menu, jumlah) VALUES (:id_pesan, :id_menu, :jumlah)");
  $query->bindParam("id_pesan", $_POST['id_pesan']);
  $query->bindParam("id_menu", $_POST['id_menu'], PDO::PARAM_INT);
  $query->bindParam("jumlah", $_POST['jumlah'], PDO::PARAM_INT);
  $query->execute();
}

// Arahkan menu ke halaman menu kembali
header("Location: $alamat_web/pesan?tambah=ya");
?>

