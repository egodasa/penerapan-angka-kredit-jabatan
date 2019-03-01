<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_meja'])){
  try{
    $query = $db->prepare("UPDATE tbl_meja SET nm_meja = :nm_meja, kd_meja = :kd_meja WHERE id_meja = :id_meja");
    $query->bindParam("id_meja", $_POST['id_meja'], PDO::PARAM_INT);
    $query->bindParam("nm_meja", $_POST['nm_meja']);
    $query->bindParam("kd_meja", $_POST['kd_meja']);
    $query->execute();
  }
  catch(PDOException $e)
  {
    echo $sql . "<br>" . $e->getMessage();
  }
}

// Arahkan user ke halaman meja kembali
header("Location: $alamat_web/meja");
?>

