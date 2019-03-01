<?php
session_start();
require("../vendor/autoload.php");
require("../pengaturan/medoo.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $db->insert("tbl_usulan", [
    'nip' => $_SESSION['nip'],
    'tgl_usulan' => $_POST['tgl_usulan'],
    'masa_penilaian_awal' => $_POST['masa_penilaian_awal'],
    'masa_penilaian_akhir' => $_POST['masa_penilaian_akhir'],
    'id_jabatan_pangkat_sekarang' => $_POST['id_jabatan_pangkat_sekarang'],
    'id_jabatan_pangkat_selanjutnya' => $_POST['id_jabatan_pangkat_selanjutnya'],
    'masa_kerja_golongan_lama' => $_POST['masa_kerja_golongan_lama'],
    'masa_kerja_golongan_baru' => $_POST['masa_kerja_golongan_baru']
  ]);
  
  $id_usulan = $db->id();
  $db->query("INSERT INTO tbl_berkas_penilaian (id_usulan, id_berkas) SELECT :id AS id_usulan, id_berkas FROM tbl_jenis_berkas", ['id' => $id_usulan]);
}

// Arahkan user ke halaman jabatan kembali
header("Location: $alamat_web/usulan");
?>

