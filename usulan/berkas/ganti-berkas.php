<?php
require("../../pengaturan/database.php");
require("../../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  // hapus foto lama
  unlink("../../assets/img/berkas/".$_POST['berkas_lama']);
  $nama_file = fileUpload($_FILES['berkas'], "../../assets/img/berkas/");
  $query = $db->prepare("UPDATE tbl_berkas_penilaian SET file = :file WHERE id_berkas_penilaian = :id");
  $query->bindParam("id", $_POST['id_berkas_penilaian'], PDO::PARAM_INT);
  $query->bindParam("file", $nama_file);
  $query->execute();
}

// Arahkan menu ke halaman menu kembali
header("Location: $alamat_web/usulan/berkas?id_usulan=".$_POST['id_usulan']);
?>

