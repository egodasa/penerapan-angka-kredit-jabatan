<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $db->insert("tbl_jabatan", ["id_posisi" => $_SESSION['current_posisi']['id_posisi'], "nm_jabatan" => $_POST['nm_jabatan']]);
  }
  
  // Arahkan user ke halaman jabatan kembali
  header("Location: $alamat_web/jabatan");
?>

