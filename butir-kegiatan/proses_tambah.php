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
      
    $id_butir = $db->id();
    $id_pangkat = $_POST['id_pangkat'];
    foreach($id_pangkat as $d)
    {
      $db->insert("tbl_pelaksana_butir_kegiatan", ["id_butir" => $id_butir, "id_pangkat" => $d]);
    }
  }
  
  // Arahkan posisi ke halaman posisi kembali
  header("Location: $alamat_web/butir-kegiatan");
?>

