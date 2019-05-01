<?php
require("../vendor/autoload.php");
require("../pengaturan/medoo.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $db->update("tbl_jabatan", ["nm_jabatan" => $_POST['nm_jabatan']], ["id_jabatan" => $_POST['id_jabatan']]);
}

// Arahkan user ke halaman jabatan kembali
header("Location: $alamat_web/jabatan");
?>

