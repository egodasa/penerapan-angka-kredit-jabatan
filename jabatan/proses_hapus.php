<?php
require("../vendor/autoload.php");
require("../pengaturan/medoo.php");
require("../pengaturan/helper.php");

if(isset($_GET['id_jabatan']))
{
  $db->delete("tbl_jabatan", ["id_jabatan" => $_GET['id_jabatan']]);
}

// Arahkan user ke halaman jabatan kembali
header("Location: $alamat_web/jabatan");
?>

