<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Evaluasi Pegawai";
  
  // Ambil dulu daftar posisi tenaga kependidikan
  $posisi = $db->select("tbl_posisi", "*", ['jenis_posisi' => 'Tenaga Kependidikan', 'ORDER' => ['nm_posisi' => "ASC"]]);
  $tgl_periode = [
                    date((date('Y') - 1).'-10-01'),
                    date((date('Y')).'-01-t'),
                    date((date('Y')).'-04-01'),
                    date((date('Y')).'-07-t')
                ];
  //~ $judul_periode = "Periode ".tanggal_indo($tgl_periode[0])." - ".tanggal_indo($tgl_periode[1])." dan ".tanggal_indo($tgl_periode[2])." - ".tanggal_indo($tgl_periode[3]);
  $judul_periode = "Periode April dan Oktober";
?>
<html>
<head>
  <?php
    include("../template/head.php");
  ?>
  <link rel="stylesheet" type="text/css" href="<?=$alamat_web?>/assets/css/pikaday.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" />
</head>
<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">
  <?php include "../template/menu.php"; ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-body text-center">
          <h3>Data Usulan</h3>
          <h3><?=$judul_periode?></h3>
<!--
          <div class="row">
            <form method="GET">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                  <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                  <input type="text" class="form-control" name="tgl_mulai" />
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="input-group input-group-sm">
                  <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                  <input type="text" class="form-control" name="tgl_selesai" />
                  <span class="input-group-btn">
                    <button style="margin-top: 25px;" type="submit" class="btn btn-info btn-flat">Lihat
                      Hasil</button>
                  </span>
                </div>
              </div>
            </form>
            <script>
              document.getElementsByName("tgl_mulai")[0].value = "<?=isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : ""?>";
              document.getElementsByName("tgl_selesai")[0].value = "<?=isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : ""?>";
            </script>
          </div>
-->
        </div>
      </div>
      <?php
        foreach($posisi as $nomor => $d)
        {
      ?>
        <div class="box">
          <div class="box-body table-responsive ">
            <h4><?=$d['nm_posisi']?></h4>
            <div class="row">
              <div class="col-xs-12">
                <canvas id="pie-chart-<?=$nomor?>" style="width: 100%;"></canvas>
              </div>
              <div class="col-xs-12">
                <canvas id="pie-chart-2-<?=$nomor?>" style="width: 100%;"></canvas>
              </div>
            </div>
          </div>
        </div>
      <?php
        }
      ?>
    </section>
  </div>
  <script src="<?=$alamat_web?>/assets/js/moment.js"></script>
  <script src="<?=$alamat_web?>/assets/js/pikaday.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
  <script>
    <?php
      foreach($posisi as $nomor => $d)
      {
    ?>
      new Chart(document.getElementById("pie-chart-<?=$nomor?>"), {
          type: 'pie',
          data: {
            <?php 
              $sql_unsur = "SELECT c.nm_sub_unsur,
                              a.butir_kegiatan, 
                              a.id_sub_unsur, 
                              COUNT(b.id_butir) AS banyak_butir 
                              FROM tbl_butir_kegiatan a 
                              LEFT JOIN tbl_usulan_unsur b ON a.id_butir = b.id_butir
                              JOIN tbl_sub_unsur c ON a.id_sub_unsur = c.id_sub_unsur 
                              JOIN tbl_unsur d ON c.id_unsur = d.id_unsur 
                              JOIN tbl_jabatan e ON d.id_jabatan = e.id_jabatan 
                              JOIN tbl_posisi f ON e.id_posisi = f.id_posisi 
                              WHERE f.id_posisi = 2 
                               GROUP BY a.id_butir ORDER BY COUNT(b.id_butir) DESC";
            ?>
            labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
            datasets: [{
              label: "Population (millions)",
              backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
              data: [2478,5267,734,784,433]
            }]
          },
          options: {
            title: {
              display: true,
              text: 'Data Unsur Dan Sub Unsur'
            }
          }
      });
      new Chart(document.getElementById("pie-chart-2-<?=$nomor?>"), {
          type: 'pie',
          data: {
            labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
            datasets: [{
              label: "Population (millions)",
              backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
              data: [2478,5267,734,784,433]
            }]
          },
          options: {
            title: {
              display: true,
              text: 'Data Sub Unsur Dan Butir Kegiatan'
            }
          }
      });
  <?php
      }
    ?>
  </script>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
