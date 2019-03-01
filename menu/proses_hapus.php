<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");

if(isset($_GET['id_menu'])){
  // Ambil nama gambar dulu agar bisa dihapus
  $query = $db->prepare("SELECT gambar FROM tbl_menu WHERE id_menu = :id_menu LIMIT 1");
  $query->bindParam("id_menu", $_GET['id_menu']);
  $query->execute();
  $gambar = $query->fetch(PDO::FETCH_ASSOC);
  $nama_gambar = $gambar['gambar'];

  // Hapus data dari database
  $query = $db->prepare("DELETE FROM tbl_menu WHERE id_menu = :id_menu");
  $query->bindParam("id_menu", $_GET['id_menu']);
  $query->execute();

  // hapus file gambar
  unlink("../assets/img/produk/".$nama_gambar);
}

// Arahkan menu ke halaman menu kembali
header("Location: $alamat_web/menu");
?>

