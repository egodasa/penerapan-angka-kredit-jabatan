<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $query = $db->prepare("UPDATE tbl_detail_pesan_tmp SET jumlah = :jumlah WHERE id_tmp = :id_tmp");
  $query->bindParam("id_tmp", $_POST['id_tmp'], PDO::PARAM_INT);
  $query->bindParam("jumlah", $_POST['jumlah'], PDO::PARAM_INT);
  $query->execute();
}
// Arahkan menu ke halaman menu kembali
header("Location: $alamat_web/pesan?edit=ya");
?>

