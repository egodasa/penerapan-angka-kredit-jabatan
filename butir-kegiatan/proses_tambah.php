<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $db->insert("tbl_butir_kegiatan", [
        'id_sub_unsur' => $_SESSION['current_sub_unsur']['id_sub_unsur'],
        'butir_kegiatan' => $_POST['butir_kegiatan'],
        'satuan' => $_POST['satuan'],
        'angka_kredit' => $_POST['angka_kredit']
      ]);
  }
  
  // Arahkan posisi ke halaman posisi kembali
  header("Location: $alamat_web/butir-kegiatan");
?>

