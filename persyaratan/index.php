<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require("../pengaturan/medoo.php");
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Beranda";
  $detail_ak_utama = $db->query("SELECT ifnull(SUM(CASE WHEN a.angka_kredit_baru = 0 THEN a.angka_kredit ELSE a.angka_kredit_baru END), 0) AS angka_kredit, ifnull(SUM(a.angka_kredit_baru), 0) AS angka_kredit_baru FROM tbl_usulan_unsur a JOIN tbl_usulan b on a.id_usulan = b.id_usulan JOIN tbl_sub_unsur c on a.id_sub_unsur = c.id_sub_unsur WHERE b.nip = '$_SESSION[nip]' AND a.status <> 'Ditolak' AND c.jenis_unsur = 'Unsur Utama'")->fetchAll();
  $detail_ak_penunjang = $db->query("SELECT ifnull(SUM(CASE WHEN a.angka_kredit_baru = 0 THEN a.angka_kredit ELSE a.angka_kredit_baru END), 0) AS angka_kredit, ifnull(SUM(a.angka_kredit_baru), 0) AS angka_kredit_baru FROM tbl_usulan_unsur a JOIN tbl_usulan b on a.id_usulan = b.id_usulan JOIN tbl_sub_unsur c on a.id_sub_unsur = c.id_sub_unsur WHERE b.nip = '$_SESSION[nip]' AND a.status <> 'Ditolak' AND c.jenis_unsur = 'Unsur Penunjang'")->fetchAll();

  $ak_sekarang = $detail_ak_utama[0]['angka_kredit']+$detail_ak_penunjang[0]['angka_kredit']+$_SESSION['angka_kredit'];
?>
<html>

<head>
  <?php
    include("../template/head.php");
  ?>
  <script src="<?=$alamat_web?>/assets/js/pdf.js"></script>
  <style type="text/css">
    #pdf-viewer {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.1);
    overflow: auto;
  }

  .pdf-page-canvas {
    display: block;
    margin: 5px auto;
    border: 1px solid rgba(0, 0, 0, 0.2);
  }
  </style>
</head>

<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
  <div class="wrapper" style="height: auto; min-height: 100%;">
    <?php include "../template/menu-kependidikan.php"; ?>
    <div class="content-wrapper" style="min-height: 901px;">
      <section class="content">
        <div class="row">
          <div class="col-md-12 col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Selamat Datang</h3>
              </div>
              <div class="box-body table-responsive ">
                Golongan Anda saat ini <b><?=$_SESSION['pangkat']?></b> akan naik pangkat ke <b><?=$_SESSION['pangkat_selanjutnya']?></b> <br/>
                Total KUM saat ini <?=round($ak_sekarang, 4)?> (Unsur Utama <?=round($detail_ak_utama[0]['angka_kredit']+$_SESSION['kredit_awal_utama'], 4)?>, Unsur Penunjang <?=round($detail_ak_penunjang[0]['angka_kredit']+$_SESSION['kredit_awal_penunjang'], 4)?>)<br/>
                Total KUM yang harus dicapai untuk naik pangkat : <b><?=$_SESSION['angka_kredit_selanjutnya']?></b><br/>
                Total kekurangan Angka Kredit Anda <b><?=round(abs($ak_sekarang-$_SESSION['angka_kredit_selanjutnya']), 4)?></b><br/>
                Untuk memenuhi kenaikan pangkat <b><?=$_SESSION['pangkat_selanjutnya']?></b><br/>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Persyaratan untuk kenaikan pangkat/jabatan</h3>
              </div>
              <div class="box-body table-responsive ">
                <ol>
                  <li>File Scan Karpeg</li>
                  <li>File Scan Pangkat Terakhir</li>
                  <li>File Scan SK Jabatan Terakhir</li>
                  <li>File Scan PAK Terakhir</li>
                  <li>File Scan Ijazah Terakhir</li>
                  <li>File Scan Penilaian Prestasi Kerja 2th terakhir</li>
                  <li>File Scan Surat Pernyataan Melakukan Kegiatan</li>
                  <li>File Scan Surat Pengantar dari pejabat pengusul</li>
                </ol>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Informasi</h3>
              </div>
              <div class="box-body table-responsive">
                <?php
                  $file_pdf = "";
                  if($_SESSION['nm_posisi'] == "Pranata Laboratorium Pendidikan")
                  {
                    $file_pdf = "1EqMHaAIJS4eDsGMicSpRR5A3lTsb64ne";
                  }
                  else if($_SESSION['nm_posisi'] == "Pustakawan")
                  {
                    $file_pdf = "1k6a9IZEuJRNRlt0DKYVvNkq1YYoI2Ede";
                  }
                  else if($_SESSION['nm_posisi'] == "Arsiparis")
                  {
                    $file_pdf = "1F9_21EquO5HP3T6t2K_OylxGN_KIiL4u";
                  }
                ?>
                <div class="container">
                  <iframe src="https://drive.google.com/file/d/<?=$file_pdf?>/preview" style="width: 90%; height: 500px;"></iframe>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include("../template/footer.php"); ?>
  </div>
  <?php include("../template/script.php"); ?>

</body>
</html>
