<?php
require("../vendor/autoload.php");
require("../pengaturan/medoo.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_usulan'])){
    if(isset($_POST['jenis_usulan']))
    {
      if($_POST['jenis_usulan'] == "kirim-data")
      {
        $db->update("tbl_usulan", ['status_proses' => 'Sedang Proses Verifikasi Oleh Pejabat Pengusul'], ['id_usulan' => $_POST['id_usulan']]);
      }
      if($_POST['jenis_usulan'] == "verifikasi")
      {
        $db->update("tbl_usulan", ['status_proses' => $_POST['status_proses'], 'keterangan' => $_POST['keterangan']], ['id_usulan' => $_POST['id_usulan']]);
      }
      else if($_POST['jenis_usulan'] == "penilaian")
      {
        $db->update("tbl_usulan", ['status_proses' => $_POST['status_proses'], 'keterangan' => $_POST['keterangan'], 'tgl_penyesuaian' => $_POST['tgl_penyesuaian'], 'tgl_pengesahan' => $_POST['tgl_pengesahan']], ['id_usulan' => $_POST['id_usulan']]);
      }
    }
    else
    {
      $db->update("tbl_usulan", [
        'tgl_usulan' => $_POST['tgl_usulan'],
        'masa_penilaian_awal' => $_POST['masa_penilaian_awal'],
        'masa_penilaian_akhir' => $_POST['masa_penilaian_akhir'],
        'id_jabatan_pangkat_sekarang' => $_POST['id_jabatan_pangkat_sekarang'],
        'id_jabatan_pangkat_selanjutnya' => $_POST['id_jabatan_pangkat_selanjutnya'],
        'masa_kerja_golongan_lama' => $_POST['masa_kerja_golongan_lama'],
        'masa_kerja_golongan_baru' => $_POST['masa_kerja_golongan_baru']
      ], ["id_usulan" => $_POST['id_usulan']]);
    }
  }

// Arahkan user ke halaman usulan kembali
header("Location: $alamat_web/usulan");
?>

