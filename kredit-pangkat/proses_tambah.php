<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $query = $db->prepare("INSERT INTO tbl_jabatan_pangkat (id_jabatan, id_pangkat, nilai_kredit, peringkat) VALUES (?, ?, ?, ?)");
  $query->bindParam(1, $_POST['id_jabatan']);
  $query->bindParam(2, $_POST['id_pangkat']);
  $query->bindParam(3, $_POST['nilai_kredit']);
  $query->bindParam(4, $_POST['peringkat']);
  $query->execute();
}

// Arahkan user ke halaman pangkat kembali
header("Location: $alamat_web/kredit-pangkat");
?>

