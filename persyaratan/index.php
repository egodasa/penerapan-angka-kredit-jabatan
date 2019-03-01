<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require("../pengaturan/medoo.php");
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Beranda";
  $detail_ak = $db->query("SELECT ifnull(SUM(CASE WHEN a.angka_kredit_baru = 0 THEN a.angka_kredit ELSE a.angka_kredit_baru END), 0) AS angka_kredit, ifnull(SUM(a.angka_kredit_baru), 0) AS angka_kredit_baru FROM tbl_usulan_unsur a JOIN tbl_usulan b on a.id_usulan = b.id_usulan JOIN tbl_unsur c on a.id_unsur = c.id_unsur WHERE b.nip = '$_SESSION[nip]' GROUP BY c.jenis_unsur")->fetchAll();
  $ak_sekarang = $detail_ak[0]['angka_kredit']+$detail_ak[1]['angka_kredit']+$_SESSION['angka_kredit'];
?>
<html>

<head>
  <?php
    include("../template/head.php");
  ?>
</head>

<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
  <div class="wrapper" style="height: auto; min-height: 100%;">
    <?php include "../template/menu-kependidikan.php"; ?>
    <div class="content-wrapper" style="min-height: 901px;">
      <section class="content">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Selamat Datang</h3>
          </div>
          <div class="box-body table-responsive ">
            Golongan Anda saat ini <b><?=$_SESSION['pangkat']?></b> akan naik pangkat ke <b><?=$_SESSION['pangkat_selanjutnya']?></b> <br/>
            Total Ak saat ini <?=$ak_sekarang?> (Unsur Utama <?=$detail_ak[0]['angka_kredit']?>, Unsur Penunjang <?=$detail_ak[1]['angka_kredit']?>)<br/>
            Total AK yang harus dicapai untuk naik pangkat : <b><?=$_SESSION['angka_kredit_selanjutnya']?></b><br/>
            Total kekurangan Angka Kredit Anda <b><?=abs($ak_sekarang-$_SESSION['angka_kredit_selanjutnya'])?></b><br/>
            Untuk memenuhi kenaikan pangkat <b><?=$_SESSION['pangkat_selanjutnya']?></b><br/>
          </div>
        </div>
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Persyaratan untuk kenaikan pangkat/jabatan</h3>
          </div>
          <div class="box-body table-responsive ">
            <ol>
              <li>File Scan Karpeg</li>
              <li>File Scan Pangkat Terakhir</li>
              <li>File Scan SK Jabatan Terakhir</li>
              <li>File Scan STTPP Diklat Fungsional</li>
              <li>File Scan PAK Terakhir</li>
              <li>File Scan Ijazah Terakhir</li>
              <li>File Scan Penilaian Prestasi Kerja 2th terakhir</li>
              <li>File Scan Pegawai CPNS & PNS</li>
              <li>File Scan Surat Tugas</li>
              <li>File Scan Bukti Fisik Hasil Kegiatan</li>
              <li>File Scan Surat Pernyataan Melakukan Kegiatan</li>
              <li>File Scan Surat Pengantar dari pejabat pengusul</li>
            </ol>
          </div>
        </div>
      </section>
    </div>
    <?php include("../template/footer.php"); ?>
  </div>
  <?php include("../template/script.php"); ?>
</body>
</html>
