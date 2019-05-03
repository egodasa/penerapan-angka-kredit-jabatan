<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require("../pengaturan/medoo.php");
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Beranda";
  
  $ak_utama_total = 0;
  $ak_penunjang_total = 0;
  $ak_total = 0;
  
  $ak_utama_sekarang = $_SESSION['kredit_awal_utama'];
  $ak_penunjang_sekarang = $_SESSION['kredit_awal_penunjang'];
  
  // Ambil angka kredit utama dan penunjang dari usulan
  
  $sql_ak_utama = "SELECT 
                      SUM(IFNULL(a.angka_kredit_baru), a.angka_kredit, a.angka_kredit_baru) AS angka_kredit 
                      FROM tbl_usulan_unsur a 
                      JOIN tbl_usulan b ON a.id_usulan = b.id_usulan 
                      JOIN tbl_pegawai c ON b.nip = c.nip 
                      JOIN tbl_butir_kegiatan d ON a.id_butir = b.id_butir 
                      JOIN tbl_sub_unsur e ON d.id_sub_unsur = e.id_sub_unsur 
                      JOIN tbl_unsur f ON e.id_unsur = f.id_unsur 
                     WHERE c.nip = :nip AND f.kategori = 'Unsur Utama' GROUP BY a.id_usulan_unsur";
  $ak_utama_sementara = $db->query($sql_ak_utama, ['nip' => $_SESSION['nip']])->fetch();
  
  $sql_ak_penunjang = "SELECT 
                      SUM(IFNULL(a.angka_kredit_baru), a.angka_kredit, a.angka_kredit_baru) AS angka_kredit 
                      FROM tbl_usulan_unsur a 
                      JOIN tbl_usulan b ON a.id_usulan = b.id_usulan 
                      JOIN tbl_pegawai c ON b.nip = c.nip 
                      JOIN tbl_butir_kegiatan d ON a.id_butir = b.id_butir 
                      JOIN tbl_sub_unsur e ON d.id_sub_unsur = e.id_sub_unsur 
                      JOIN tbl_unsur f ON e.id_unsur = f.id_unsur 
                     WHERE c.nip = :nip AND f.kategori = 'Unsur Penunjang' GROUP BY a.id_usulan_unsur";
  $ak_penunjang_sementara = $db->query($sql_ak_penunjang, ['nip' => $_SESSION['nip']])->fetch();
  
  $ak_utama_total = $ak_utama_sekarang + $ak_utama_sementara['angka_kredit'];
  $ak_penunjang_total = $ak_penunjang_sekarang + $ak_penunjang_sementara['angka_kredit'];
  
  $ak_total = $ak_utama_total + $ak_penunjang_total;
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
                Golongan Anda saat ini <b><?=$_SESSION['nm_pangkat_sekarang']?></b> akan naik pangkat ke <b><?=$_SESSION['nm_pangkat_selanjutnya']?></b> <br/>
                Total KUM saat ini <?=round($ak_total, 4)?> (Unsur Utama <?=round($ak_utama_total, 4)?>, Unsur Penunjang <?=round($ak_penunjang_total, 4)?>)<br/>
                Total KUM yang harus dicapai untuk naik pangkat : <b><?=$_SESSION['angka_kredit_selanjutnya']?></b><br/>
                Total kekurangan Angka Kredit Anda <b><?=round(abs($ak_total - $_SESSION['angka_kredit_selanjutnya']), 4)?></b><br/>
                Untuk memenuhi kenaikan pangkat <b><?=$_SESSION['nm_pangkat_selanjutnya']?></b><br/>
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
