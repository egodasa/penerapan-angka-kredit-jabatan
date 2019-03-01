<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_pangkat'])){
  try{
    $query = $db->prepare("UPDATE tbl_pangkat SET nm_pangkat = :nm_pangkat WHERE id_pangkat = :id_pangkat");
    $query->bindParam("id_pangkat", $_POST['id_pangkat'], PDO::PARAM_INT);
    $query->bindParam("nm_pangkat", $_POST['nm_pangkat']);
    $query->execute();
  }
  catch(PDOException $e)
  {
    echo $sql . "<br>" . $e->getMessage();
  }
}

// Arahkan user ke halaman pangkat kembali
header("Location: $alamat_web/pangkat");
?>

