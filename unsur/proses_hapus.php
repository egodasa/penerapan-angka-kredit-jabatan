<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");

if(isset($_GET['id_unsur'])){
  $query = $db->prepare("DELETE FROM tbl_unsur WHERE id_unsur = :id_unsur");
  $query->bindParam("id_unsur", $_GET['id_unsur']);
  $query->execute();
}

// Arahkan user ke halaman unsur kembali
header("Location: $alamat_web/unsur");
?>

