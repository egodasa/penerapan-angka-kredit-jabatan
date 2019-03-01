<?php
require_once("../vendor/autoload.php");
require("../pengaturan/medoo.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $nama_file = fileUpload($_FILES['foto'], "../assets/img/foto/");
  
  $db->insert("tbl_pegawai", [
    'nip' => $_POST['nip'],
    'password' => md5($_POST['password']),
    'no_karpeg' => $_POST['no_karpeg'],
    'nm_lengkap' => $_POST['nm_lengkap'],
    'jk' => $_POST['jk'],
    'tempat_lahir' => $_POST['tempat_lahir'],
    'tgl_lahir' => $_POST['tgl_lahir'],
    'nohp' => $_POST['nohp'],
    'email' => $_POST['email'],
    'pendidikan' => $_POST['pendidikan'],
    'tgl_lulus' => $_POST['tgl_lulus'],
    'id_jabatan_pangkat' => $_POST['id_jabatan_pangkat'],
    'id_unit_kerja' => $_POST['id_unit_kerja'],
    'kredit_awal' => $_POST['kredit_awal'],
    'foto' => $nama_file,
    'tmt_jabatan' => $_POST['tmt_jabatan'],
  ]);
}

// Arahkan pegawai ke halaman pegawai kembali
header("Location: $alamat_web/pegawai");
?>

