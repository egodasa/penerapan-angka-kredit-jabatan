<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_unsur'])){
  try{
    $query = $db->prepare("UPDATE tbl_unsur SET nm_unsur = :nm_unsur WHERE id_unsur = :id_unsur");
    $query->bindParam("id_unsur", $_POST['id_unsur'], PDO::PARAM_INT);
    $query->bindParam("nm_unsur", $_POST['nm_unsur']);
    $query->execute();
  }
  catch(PDOException $e)
  {
    echo $sql . "<br>" . $e->getMessage();
  }
}

// Arahkan user ke halaman unsur kembali
header("Location: $alamat_web/unsur");
?>

