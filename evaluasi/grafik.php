<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Evaluasi Pegawai";
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
  <?php include "../template/menu-kependidikan.php"; ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-body">
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
        </div>
      </div>
      <div class="box">
        <div class="box-body table-responsive ">
          <div class="chart">
            <canvas id="grafik_usulan" width="100%"></canvas>
          </div>
        </div>
      </div>
    </section>
  </div>
  <script src="<?=$alamat_web?>/assets/js/moment.js"></script>
  <script src="<?=$alamat_web?>/assets/js/pikaday.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
  <script>
    var tgl_mulai = new Pikaday({
      field: document.getElementById('tgl_mulai'),
      format: 'YYYY-MM-DD',
    });
    var tgl_selesai = new Pikaday({
      field: document.getElementById('tgl_selesai'),
      format: 'YYYY-MM-DD',
    });
  </script>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
