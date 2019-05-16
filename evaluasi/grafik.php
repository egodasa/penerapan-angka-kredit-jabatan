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
  //  MONTH(a.tgl_usulan) BETWEEN 1 AND 6 OR MONTH(a.tgl_usulan) BETWEEN 7 AND 12
  $judul_periode = "Seluruh Periode";
  $sql_periode = "";
  $prepared_statement = [];
  if(isset($_GET['periode']))
  {
    if($_GET['periode'] == "0")
    {
      $sql_periode = "";
      $judul_periode = "Seluruh Periode";
    }
    elseif($_GET['periode'] == "1")
    {
      $sql_periode = " AND MONTH(a.tgl_usulan) BETWEEN 1 AND 6";
      $judul_periode = "Periode Januari - Juni";
    }
    elseif($_GET['periode'] == "2")
    {
      $sql_periode = " MONTH(a.tgl_usulan) BETWEEN 7 AND 12"; 
      $judul_periode = "Periode Juli - Desember";
    }
  }
  else
  {
    $sql_periode = "";
  }
  
  $sql_pegawai = "";
  $detail_pegawai = new stdClass;
  
  if(isset($_GET['nip']))
  {
    if($_GET['nip'] != "0")
    {
      $detail_pegawai = $db->get("tbl_pegawai", "*", ["nip" => $_GET['nip']]);
      $sql_pegawai = " AND a.nip = :nip";
      $prepared_statement['nip'] = $_GET['nip'];
      $judul_periode .= " <br> ".$detail_pegawai['nm_lengkap'];
    }
  }
  
  
  //~ $judul_periode = "Periode ".tanggal_indo($tgl_periode[0])." - ".tanggal_indo($tgl_periode[1])." dan ".tanggal_indo($tgl_periode[2])." - ".tanggal_indo($tgl_periode[3]);
  
  $judul_halaman = "Evaluasi Pegawai";
  
  $pegawai = $db->select("tbl_pegawai", "*");
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
        <div class="box-body">
          <form>
            <div class="form-group">
              <label>Pilih Pegawai</label>
              <select name="nip" class="form-control">
                <option value="0">Semua Pegawai</option>
                <?php
                  foreach($pegawai as $d)
                  {
                ?>
                  <option value="<?=$d['nip']?>"><?=$d['nm_lengkap']?></option>
                <?php
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label>Pilih Periode</label>
              <select name="periode" class="form-control">
                <option value="0">Semua Periode</option>
                <option value="1">Januari - Juni</option>
                <option value="2">Juli - Oktober</option>
              </select>
            </div>
            <div class="form-group">
              <button type="submit" class="btn bt-flat btn-primary">Tampilkan</button>
            </div>
          </form>
        </div>
      </div>
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
              $sql_unsur = "SELECT Count(bb.id_butir) AS banyak_butir,
                                       bb.*,
                                       aa.butir_kegiatan,
                                       cc.id_sub_unsur,
                                       cc.nm_sub_unsur,
                                       dd.id_unsur,
                                       dd.nm_unsur,
                                       ee.id_jabatan
                                FROM   tbl_butir_kegiatan aa
                                       LEFT JOIN (SELECT a.tgl_usulan,
                                                         a.nip,
                                                         b.id_butir
                                                  FROM   tbl_usulan_unsur b
                                                         LEFT JOIN tbl_usulan a
                                                                ON b.id_usulan = a.id_usulan
                                                  WHERE 1 $sql_pegawai $sql_periode) bb
                                              ON aa.id_butir = bb.id_butir
                                       LEFT JOIN tbl_sub_unsur cc
                                              ON aa.id_sub_unsur = cc.id_sub_unsur
                                       LEFT JOIN tbl_unsur dd
                                              ON cc.id_unsur = dd.id_unsur
                                       LEFT JOIN tbl_jabatan ee
                                              ON dd.id_jabatan = ee.id_jabatan
                                       LEFT JOIN tbl_posisi ff
                                              ON ee.id_posisi = ff.id_posisi WHERE ff.id_posisi = :id_posisi
                                GROUP  BY dd.id_unsur";
              $prepared_statement['id_posisi'] = $d['id_posisi'];
              $data_unsur = $db->query($sql_unsur, $prepared_statement)->fetchAll(PDO::FETCH_ASSOC);
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
              $sql_unsur = "SELECT Count(bb.id_butir) AS banyak_butir,
                                 bb.*,
                                 aa.butir_kegiatan,
                                 cc.id_sub_unsur,
                                 cc.nm_sub_unsur,
                                 dd.nm_unsur,
                                 ee.id_jabatan
                          FROM   tbl_butir_kegiatan aa
                                 LEFT JOIN (SELECT a.tgl_usulan,
                                                   a.nip,
                                                   b.id_butir
                                            FROM   tbl_usulan_unsur b
                                                   LEFT JOIN tbl_usulan a
                                                          ON b.id_usulan = a.id_usulan 
                                            WHERE 1 $sql_pegawai $sql_periode) bb
                                        ON aa.id_butir = bb.id_butir
                                 LEFT JOIN tbl_sub_unsur cc
                                        ON aa.id_sub_unsur = cc.id_sub_unsur
                                 LEFT JOIN tbl_unsur dd
                                        ON cc.id_unsur = dd.id_unsur
                                 LEFT JOIN tbl_jabatan ee
                                        ON dd.id_jabatan = ee.id_jabatan
                                 LEFT JOIN tbl_posisi ff
                                        ON ee.id_posisi = ff.id_posisi WHERE ff.id_posisi = :id_posisi
                          GROUP  BY cc.id_sub_unsur";
              $prepared_statement['id_posisi'] = $d['id_posisi'];
              $data_unsur = $db->query($sql_unsur, $prepared_statement)->fetchAll(PDO::FETCH_ASSOC);
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
    document.getElementsByName("nip")[0].value = "<?=isset($_GET['nip']) ? $_GET['nip'] : '0'?>";
    document.getElementsByName("periode")[0].value = "<?=isset($_GET['periode']) ? $_GET['periode'] : '0'?>";
  </script>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
