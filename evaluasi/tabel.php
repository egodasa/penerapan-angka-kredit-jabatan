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
  $sql_periode = "";
  $prepared_statement = [];
  if(isset($_GET['periode']))
  {
    if($_GET['periode'] == "0")
    {
      $sql_periode = " WHERE tgl_usulan BETWEEN Date(Concat(Year(Now()) - 1, '-',
                                                                           '10-01'))
                                                                      AND Date(
                                                   Concat(Year(Now()), '-', '02-01'))
                                                    OR tgl_usulan BETWEEN Date(Concat(Year(Now()), '-',
                                                                               '04-01'))
                                                                          AND Date(
                                                                              Concat(Year(Now()), '-',
                                                                              '08-01'))";
      $judul_periode = "Periode Oktober - Januari dan April - Juli";
    }
    elseif($_GET['periode'] == "1")
    {
      $sql_periode = " WHERE tgl_usulan BETWEEN Date(Concat(Year(Now()) - 1, '-',
                                                                           '10-01'))
                                                                      AND Date(
                                                   Concat(Year(Now()), '-', '02-01'))
                                                    ";
      $judul_periode = "Periode Oktober - Januari";
    }
    elseif($_GET['periode'] == "2")
    {
      $sql_periode = " WHERE tgl_usulan BETWEEN Date(Concat(Year(Now()), '-',
                                                                               '04-01'))
                                                                          AND Date(
                                                                              Concat(Year(Now()), '-',
                                                                              '08-01'))"; 
      $judul_periode = "Periode April - Juli";
    }
  }
  else
  {
    $sql_periode = " WHERE tgl_usulan BETWEEN Date(Concat(Year(Now()) - 1, '-',
                                                                           '10-01'))
                                                                      AND Date(
                                                   Concat(Year(Now()), '-', '02-01'))
                                                    OR tgl_usulan BETWEEN Date(Concat(Year(Now()), '-',
                                                                               '04-01'))
                                                                          AND Date(
                                                                              Concat(Year(Now()), '-',
                                                                              '08-01'))";
  }
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
        <div class="box-body">
          <form>
          <div class="form-group">
            <label>Pilih Periode :</label>
            <select name="periode" class="form-control">
              <option value="0">Semua Periode</option>
              <option value="1">Oktober - Januari</option>
              <option value="2">April - Juli</option>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-flat btn-primary">Tampilkan</button>
          </div>
          </form>
        </div>
      </div>
      <div class="box">
        <div class="box-body text-center">
          <h3>Data Usulan</h3>
          <h3><?=$judul_periode?></h3>
          <?php 
            if(isset($_GET['tgl_mulai']) && isset($_GET['tgl_selesai']) && !empty($_GET['tgl_mulai']) && !empty($_GET['tgl_selesai']))
            {
              echo "<h4>Periode ".tanggal_indo($_GET['tgl_mulai'])." - ".tanggal_indo($_GET['tgl_selesai'])."</h4>";
              

            } 
          ?>
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
        foreach($posisi as $d)
        {
      ?>
        <div class="box">
          <div class="box-body table-responsive ">
            <h4><?=$d['nm_posisi']?></h4>
            <table style="overflow-x: visible; overflow-y:visible;" class="table table-bordered">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jenis Kelamin</th>
                <th>Pangkat</th>
                <th>Unit Kerja</th>
                <th>Pengajuan Usulan</th>
                <th>Keterangan</th>
              </tr>  
      <?php
          $prepared_statement['id_posisi'] = $d['id_posisi'];
          $sql_usulan = "SELECT a.id_usulan,
                                 a.tgl_usulan,
                                 a.keterangan,
                                 b.nip,
                                 b.jk,
                                 b.nm_lengkap,
                                  c.nm_unit_kerja,
                                  d.nm_pangkat
                          FROM   tbl_pegawai b
                                 LEFT JOIN (SELECT *
                                            FROM   tbl_usulan
                                            $sql_periode)
                                                                a
                                        ON b.nip = a.nip 
                          JOIN tbl_unit_kerja c ON b.id_unit_kerja = c.id_unit_kerja 
                          JOIN tbl_pangkat d ON b.id_pangkat = d.id_pangkat WHERE b.id_posisi = :id_posisi ORDER BY b.nm_lengkap";
          if(isset($_GET['tgl_mulai']) && isset($_GET['tgl_selesai']) && !empty($_GET['tgl_mulai']) && !empty($_GET['tgl_selesai']))
          {
            $prepared_statement['tgl_mulai'] = $_GET['tgl_mulai'];
            $prepared_statement['tgl_selesai'] = $_GET['tgl_selesai'];
            $sql_usulan .= " AND a.tgl_usulan >= :tgl_mulai AND a.tgl_usulan <= :tgl_selesai";
          } 
          $usulan = $db->query($sql_usulan, $prepared_statement)->fetchAll(PDO::FETCH_ASSOC);
          foreach($usulan as $nomor => $u)
          {
      ?>
        <tr>
          <td><?=($nomor+1)?></td>
          <td><?=$u['nm_lengkap']?></td>
          <td><?=$u['nip']?></td>
          <td><?=$u['jk']?></td>
          <td><?=$u['nm_pangkat']?></td>
          <td><?=$u['nm_unit_kerja']?></td>
          <td><?=empty($u['tgl_usulan']) ? "Belum Mengusulkan" : tanggal_indo($u['tgl_usulan'])?></td>
          <td><?=$u['keterangan']?></td>
        </tr>
      <?php
          }
      ?>
            </table>
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
    var tgl_mulai = new Pikaday({
      field: document.getElementsByName('tgl_mulai')[0],
      format: 'YYYY-MM-DD',
    });
    var tgl_selesai = new Pikaday({
      field: document.getElementsByName('tgl_selesai')[0],
      format: 'YYYY-MM-DD',
    });
  </script>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
