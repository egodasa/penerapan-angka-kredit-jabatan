<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $db->insert("tbl_unsur", ["nm_unsur" => $_POST['nm_unsur'], "id_jabatan" => $_SESSION['current_jabatan']['id_jabatan'], "kategori" => $_POST['kategori']]);
  }
  
  // Arahkan user ke halaman unsur kembali
  header("Location: $alamat_web/unsur");
?>

