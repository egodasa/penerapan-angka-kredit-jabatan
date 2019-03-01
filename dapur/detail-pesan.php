<?php
  session_start();
  require("../pengaturan/helper.php");
  cekIzinAksesHalaman(array('Dapur'), $alamat_web);
  $judul_halaman = "Detail Pesanan";
  if(isset($_GET['id_pesan'])){
    require_once("../pengaturan/database.php");
    // Ambil detail pesan
    $query = $db->prepare("SELECT a.*,b.nm_meja FROM tbl_pesan a JOIN tbl_meja b ON a.id_meja = b.id_meja WHERE id_pesan = :id_pesan LIMIT 1");
    $query->bindParam("id_pesan", $_GET['id_pesan']); 
    $query->execute();
    $detail_pesan = $query->fetch();
    
    
    // Ambil daftar pesan
    $query = $db->prepare("select `a`.`id_detail` AS `id_detail`,`a`.`id_pesan` AS `id_pesan`,`b`.`nama` AS `nama`,`b`.`harga` AS `harga`,`a`.`jumlah` AS `jumlah`,(`a`.`jumlah` * `b`.`harga`) AS `sub_bayar` from (`tbl_detail_pesan` `a` join `tbl_menu` `b` on((`a`.`id_menu` = `b`.`id_menu`))) WHERE a.id_pesan = :id_pesan");
    $query->bindParam("id_pesan", $_GET['id_pesan']); 
    $query->execute();
    $daftar_pesan = $query->fetchAll(PDO::FETCH_ASSOC);
    
  }else{
    header("Location: $alamat_web/pembayaran");
  }
?>
<html>

<head>
  <?php
    include("../template/head.php");
  ?>
</head>

<body class="skin-blue layout-top-nav">

<body class="skin-blue layout-top-nav" style="height: auto; min-height: 100%;">
  <div class="wrapper" style="height: auto; min-height: 100%;">
    <?php include("../template/header-dapur.php"); ?>

    <div class="content-wrapper" style="min-height: 335px;">
      <div class="container">
        <section class="content-header">
        <a href="<?=$alamat_web?>/dapur" class="btn btn-success btn-flat">< Kembali Ke Daftar Pesanan</a>
        </section>
        <section class="content">
          <div class="row">

            <div class="col-md-4 col-xs-12">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Informasi Pemesan</h3>
                </div>
                <div class="box-body table-responsive ">
                  <form action="<?=$alamat_web?>/dapur/proses-pesanan.php" method="POST">
                    <div class="form-group">
                      <label class="form-label">No Pesan</label>
                      <input class="form-control" type="text" value="<?=$detail_pesan['id_pesan']?>" name="id_pesan"
                        readonly>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Nama Pemesan</label>
                      <input class="form-control" type="text" value="<?=$detail_pesan['nama_pemesan']?>" readonly>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Tanggal Pesan</label>
                      <input class="form-control" type="text" value="<?=tanggal_indo_waktu($detail_pesan['tanggal_pesan'])?>" readonly>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Nomor Meja</label>
                      <input class="form-control" type="text" value="<?=$detail_pesan['nm_meja']?>" readonly>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Status Pesanan</label>
                      <select class="form-control custom-select" name="status_pesanan">
                        <option value="Sudah Dibayar" <?=$detail_pesan['status_pesanan']=='Sudah Dibayar' ?
                          ' selected="selected"' : '' ;?>>Sudah Dibayar</option>
                        <option value="Hidangan Sedang Disiapkan" <?=$detail_pesan['status_pesanan']=='Hidangan Sedang Disiapkan' ?
                          ' selected="selected"' : '' ;?>>Hidangan Sedang Disiapkan</option>
                        <option value="Hidangan Sudah Siap" <?=$detail_pesan['status_pesanan']=='Hidangan Sudah Siap' ?
                          ' selected="selected"' : '' ;?>>Hidangan Sudah Siap</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Proses Pesanan</button>
                  </form>
                </div>
              </div>
            </div>

            <div class="col-md-8 col-xs-12">
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Menu yang Dipesan</h3>
                </div>
                <div class="box-body table-responsive ">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th class="text-right">Jumlah</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
          $no = 1;
          if(count($daftar_pesan) > 0){
            foreach($daftar_pesan as $d){
          ?>
                      <tr>
                        <td>
                          <?=$no?>
                        </td>
                        <td>
                          <?=$d['nama']?>
                        </td>
                        <td class="text-right">
                          <?=$d['jumlah']?>
                        </td>
                      </tr>
                      <?php 
            $no++;
            }
          }else{
          ?>
                      <tr>
                        <td colspan=3 class="text-center">Tidak ada data yang ditampilkan!</td>
                      </tr>
                      <?php
          }
          ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
          </section>
        </div>
      </div>
      <?php include("../template/footer.php"); ?>
    </div>
    <?php include("../template/script.php"); ?>
  </body>

</html>
