<?php
  session_start();
  $judul_halaman = "Laporan Harian";
  require("../pengaturan/database.php");
  require("../pengaturan/helper.php");
  cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $waktu = date("Y-m-d");
  $query_string_waktu = null;
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $waktu = $_POST['tanggal'];
    $query_string_waktu = "?waktu=".$waktu;
  }
  // Ambil laporan
  $query = $db->prepare("select aa.nama, aa.harga, ifnull(bb.jumlah, 0) as jumlah,ifnull(bb.total, 0) as total  from tbl_menu aa left join (select a.tanggal_pesan, b.nama, b.id_menu, b.harga, sum(a.jumlah) as jumlah, sum(b.harga*a.jumlah) as total from (select aa.tanggal_pesan, bb.id_menu, bb.jumlah, aa.status_pesanan from tbl_pesan aa join tbl_detail_pesan bb on aa.id_pesan = bb.id_pesan WHERE aa.status_pesanan <> 'Belum Dibayar' AND date(aa.tanggal_pesan) = :waktu) a join tbl_menu b on a.id_menu = b.id_menu group by b.id_menu) bb on aa.id_menu = bb.id_menu ORDER BY bb.jumlah DESC;"); 
  $query->bindParam("waktu", $waktu);
  $query->execute();
  $laporan = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<html>

<head>
  <?php
    include("../template/head.php");
  ?>
  <link rel="stylesheet" type="text/css" href="<?=$alamat_web?>/assets/css/pikaday.css">
</head>

<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
  <div class="wrapper" style="height: auto; min-height: 100%;">
    <?php include "../template/menu-kasir.php"; ?>
    <div class="content-wrapper" style="min-height: 901px;">
      <section class="content-header">
        <h1>Laporan Pemasukan Harian</h1>
      </section>
      <section class="content">
        <div class="box">
          <div class="box-header with-border">
            <form action="" method="POST">
              <div class="form-group">
                <label class="form-label">
                  Pilih Tanggal
                </label>
                <div class="input-group input-group-sm">
                  <input class="form-control" type="text" id="tanggal" name="tanggal" value="<?=$waktu?>" readonly />
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-info btn-flat">Tampilkan</button>
                    <a href="<?=$alamat_web?>/laporan/cetak-harian.php<?=$query_string_waktu?>" target="_blank" class="btn btn-success btn-flat">Cetak</a>
                  </span>
                </div>
              </div>
            </form>
          </div>
          <div class="box-body table-responsive ">
            <h3 class="box-title">Laporan Tanggal
              <?=tanggal_indo($waktu)?>
            </h3>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Menu</th>
                  <th>Harga Satuan</th>
                  <th>Terjual</th>
                  <th>Pemasukan</th>
                </tr>
              </thead>
              <tbody>
                <?php
              $no = 1;
              if(count($laporan) > 0){
                $total_bayar = 0;
                foreach($laporan as $d){
                $total_bayar += $d['total'];
              ?>
                <tr>
                  <td>
                    <?=$no?>
                  </td>
                  <td>
                    <?=$d['nama']?>
                  </td>
                  <td>
                    <?=rupiah($d['harga'])?>
                  </td>
                  <td>
                    <?=$d['jumlah']?>
                  </td>
                  <td>
                    <?=rupiah($d['total'])?>
                  </td>
                </tr>
                <?php 
                $no++;
                }
              }else{
              ?>
                <tr>
                  <td colspan=5 class="text-center">Belum ada pemasukan saat ini.</td>
                </tr>
                <?php
              }
              ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan=4 style="text-align: right;"><b>Total Pemasukan</b></td>
                  <td>
                    <?=rupiah($total_bayar)?>
                  </td>
                </tr>
                </tr>
              </tfoot>
            </table>
            <script src="<?=$alamat_web?>/assets/js/moment.js"></script>
            <script src="<?=$alamat_web?>/assets/js/pikaday.js"></script>
            <script>
              var tanggal = new Pikaday({
                field: document.getElementById('tanggal'),
                format: 'YYYY-MM-DD',
              });
            </script>
          </div>
        </div>
      </section>
    </div>
    <?php include "../template/footer.php"; ?>
    <?php include("../template/script.php"); ?>
  </div>
</body>

</html>