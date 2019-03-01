<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_FILES['gambar'])){
    $file_tmp = $_FILES['gambar']['tmp_name'];
    $file_ext=strtolower(end(explode('.',$_FILES['gambar']['name'])));
    $nama_file = generateNumber().".".$file_ext;
    $lokasi_file = "../assets/img/produk/".$nama_file;
    move_uploaded_file($file_tmp, $lokasi_file);
    
    $query = $db->prepare("INSERT INTO tbl_menu (nama, id_kategori, deskripsi, harga, gambar) VALUES (:nama, :id_kategori, :deskripsi, :harga, :gambar)");
    $query->bindParam("id_kategori", $_POST['id_kategori'], PDO::PARAM_INT);
    $query->bindParam("nama", $_POST['nama']);
    $query->bindParam("deskripsi", $_POST['deskripsi']);
    $query->bindParam("harga", $_POST['harga'], PDO::PARAM_INT);
    $query->bindParam("gambar", $nama_file);
    $query->execute();
  }
}

// Arahkan menu ke halaman menu kembali
header("Location: $alamat_web/menu");
?>

