<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $db->insert("tbl_sub_unsur", ["nm_sub_unsur" => $_POST['nm_sub_unsur'], "id_unsur" => $_SESSION['current_unsur']['id_unsur']]);
  }
  
  // Arahkan user ke halaman unsur kembali
  header("Location: $alamat_web/sub-unsur");
?>

