<?php
  session_start();
  use \Colors\RandomColor;
  require("../randomColor.php");
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);

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
<body class="skin-blue sidebar-mini sidebar-collapse" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">
  <?php include "../template/menu.php"; ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-body text-center">
          <h3>Grafik Data Usulan</h3>
          <h3><?=$judul_periode?></h3>
        </div>
      </div>
      <?php
        foreach($posisi as $nomor => $d)
        {
      ?>
        <div class="box">
          <div class="box-body" style="width: 100%;overflow-x: scroll;white-space: nowrap;">
            <h2><?=$d['nm_posisi']?></h2>
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
              $sql_unsur = "SELECT d.nm_unsur, c.nm_sub_unsur,
                                COUNT(b.id_butir) AS banyak_butir 
                                FROM tbl_butir_kegiatan a 
                                LEFT JOIN tbl_usulan_unsur b ON a.id_butir = b.id_butir
                                JOIN tbl_sub_unsur c ON a.id_sub_unsur = c.id_sub_unsur 
                                JOIN tbl_unsur d ON c.id_unsur = d.id_unsur 
                                JOIN tbl_jabatan e ON d.id_jabatan = e.id_jabatan 
                                JOIN tbl_posisi f ON e.id_posisi = f.id_posisi 
                                LEFT JOIN ((SELECT * FROM   tbl_usulan
                                            WHERE  tgl_usulan BETWEEN Date(Concat(Year(Now()) - 1, '-',
                                                                           '10-01'))
                                                                      AND Date(
                                                   Concat(Year(Now()), '-', '02-01'))
                                                    OR tgl_usulan BETWEEN Date(Concat(Year(Now()), '-',
                                                                               '04-01'))
                                                                          AND Date(
                                                                              Concat(Year(Now()), '-',
                                                                              '08-01')))) k 
                                                                               ON b.id_usulan = k.id_usulan 
                                WHERE f.id_posisi = :id_posisi 
                                 GROUP BY d.nm_unsur ORDER BY COUNT(b.id_butir) DESC";
              $data_unsur = $db->query($sql_unsur, ['id_posisi' => $d['id_posisi']])->fetchAll(PDO::FETCH_ASSOC);
              $labels = [];
              $data = [];
              $judul_unsur = [];
              $judul_sub_unsur = [];
              $colors = [];
              
              foreach($data_unsur as $i => $dd)
              {
                $colors[] = warnaAcak($colors);
                $labels[] = $dd['nm_unsur'];
                $data[] = $dd['banyak_butir'];
                $judul_unsur[] = $dd['nm_unsur'];
                $judul_sub_unsur[] = $dd['nm_sub_unsur'];
              }
            ?>
            labels: <?=json_encode($labels)?>,
            datasets: [{
              label: "Banyak",
              backgroundColor: <?=json_encode($colors)?>,
              data: <?=json_encode($data)?>,
              judul_unsur: <?=json_encode($judul_unsur)?>,
              judul_sub_unsur: <?=json_encode($judul_sub_unsur)?>
            }]
          },
          options: {
            title: {
              display: true,
              text: 'Grafik Unsur',
            },
            legend: {
              position: 'left'
            },
            tooltips: {
              callbacks: {
                title: function(tooltipItem, data) {
                  return "Unsur : " + data.datasets[0]['judul_unsur'][tooltipItem[0]['index']];
                },
                label: function(tooltipItem, data) {
                  //~ return "Sub Unsur : " + data.datasets[0]['judul_sub_unsur'][tooltipItem.index];
                  return null;
                },
                afterLabel: function(tooltipItem, data) {
                  var dataset = data['datasets'][0];
                  var keys = Object.keys(dataset["_meta"]);
                  var percent = Math.round((dataset['data'][tooltipItem['index']] / dataset["_meta"][keys[0]]['total']) * 100)
                  return 'Total : ' + data['datasets'][0]['data'][tooltipItem.index] + '/' + dataset["_meta"][keys[0]]['total'] + ' (' + percent + '%)';
                }
              },
              backgroundColor: '#1EA5FF',
              titleFontSize: 16,
              titleFontColor: '#FFF',
              bodyFontColor: '#FFF',
              bodyFontSize: 14,
              displayColors: false
            }
          }
      });
      
      new Chart(document.getElementById("pie-chart-2-<?=$nomor?>"), {
          type: 'horizontalBar',
          data: {
            <?php 
              $sql_unsur = "SELECT d.nm_unsur, c.nm_sub_unsur,
                                COUNT(b.id_butir) AS banyak_butir,
                                a.butir_kegiatan 
                                FROM tbl_butir_kegiatan a 
                                LEFT JOIN tbl_usulan_unsur b ON a.id_butir = b.id_butir
                                JOIN tbl_sub_unsur c ON a.id_sub_unsur = c.id_sub_unsur 
                                JOIN tbl_unsur d ON c.id_unsur = d.id_unsur 
                                JOIN tbl_jabatan e ON d.id_jabatan = e.id_jabatan 
                                JOIN tbl_posisi f ON e.id_posisi = f.id_posisi 
                                LEFT JOIN ((SELECT * FROM tbl_usulan
                                            WHERE  tgl_usulan BETWEEN Date(Concat(Year(Now()) - 1, '-',
                                                                           '10-01'))
                                                                      AND Date(
                                                   Concat(Year(Now()), '-', '02-01'))
                                                    OR tgl_usulan BETWEEN Date(Concat(Year(Now()), '-',
                                                                               '04-01'))
                                                                          AND Date(
                                                                              Concat(Year(Now()), '-',
                                                                              '08-01')))) k 
                                                                               ON b.id_usulan = k.id_usulan 
                                WHERE f.id_posisi = :id_posisi 
                                 GROUP BY c.nm_sub_unsur ORDER BY COUNT(b.id_butir) DESC";
              $data_unsur = $db->query($sql_unsur, ['id_posisi' => $d['id_posisi']])->fetchAll(PDO::FETCH_ASSOC);
              $labels = [];
              $data = [];
              $judul_sub_unsur = [];
              $judul_butir = [];
              $colors = [];
              foreach($data_unsur as $i => $dd)
              {
                $colors[] = warnaAcak($colors);
                $labels[] = $dd['nm_sub_unsur'];
                $data[] = $dd['banyak_butir'];
                $judul_butir[] = $dd['nm_unsur'];
                $judul_sub_unsur[] = $dd['nm_sub_unsur'];
              }
              if(!empty($data))
              {
                $data[] = $data[0] + 3;
              }
            ?>
            labels: <?=json_encode($labels)?>,
            datasets: [{
              label: [],
              backgroundColor: <?=json_encode($colors)?>,
              data: <?=json_encode($data)?>,
              judul_butir: <?=json_encode($judul_butir)?>,
              judul_sub_unsur: <?=json_encode($judul_sub_unsur)?>
            }]
          },
          options: {
            title: {
              display: true,
              text: 'Grafik Sub Unsur',
            },
            legend: {
              display: false,
              position: 'right'
            },
            tooltips: {
              callbacks: {
                title: function(tooltipItem, data) {
                  return "Sub Unsur : " + data.datasets[0]['judul_sub_unsur'][tooltipItem[0]['index']];
                },
                label: function(tooltipItem, data) {
                  return null;
                },
                afterLabel: function(tooltipItem, data) {
                  var dataset = data['datasets'][0];
                  var keys = Object.keys(dataset["_meta"]);
                  var percent = Math.round((dataset['data'][tooltipItem['index']] / dataset["_meta"][keys[0]]['total']) * 100)
                  return 'Total : ' + data['datasets'][0]['data'][tooltipItem.index];
                  //~ return 'Total : ' + data['datasets'][0]['data'][tooltipItem.index] + '/' + dataset["_meta"][keys[0]]['total'] + ' (' + percent + '%)';
                }
              },
              backgroundColor: '#FF1E91',
              titleFontSize: 16,
              titleFontColor: '#FFF',
              bodyFontColor: '#FFF',
              bodyFontSize: 14,
              displayColors: false
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
