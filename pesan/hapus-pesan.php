<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if(isset($_GET['id_tmp'])){
  $query = $db->prepare("DELETE FROM tbl_detail_pesan_tmp WHERE id_tmp = :id_tmp");
  $query->bindParam("id_tmp", $_GET['id_tmp'], PDO::PARAM_INT);
  $query->execute();
}
// Arahkan menu ke halaman menu kembali
header("Location: $alamat_web/pesan?hapus=ya");
?>

