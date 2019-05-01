<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $db->insert("tbl_pangkat", ["id_jabatan" => $_SESSION['current_jabatan']['id_jabatan'],"nm_pangkat" => $_POST['nm_pangkat'], "angka_kredit_minimal" => $_POST['angka_kredit_minimal'], "peringkat" => $_POST['peringkat']]);
  }
  
  // Arahkan user ke halaman pangkat kembali
  header("Location: $alamat_web/pangkat");
?>

