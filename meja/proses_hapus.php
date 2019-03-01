<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");

if(isset($_GET['id_meja'])){
  $query = $db->prepare("DELETE FROM tbl_meja WHERE id_meja = :id_meja");
  $query->bindParam("id_meja", $_GET['id_meja']);
  $query->execute();
}

// Arahkan user ke halaman meja kembali
header("Location: $alamat_web/meja");
?>

