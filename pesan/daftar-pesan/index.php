<?php
  session_start();
  require("../../pengaturan/helper.php");
  $judul_halaman = "Detail Pesanan";
  if(isset($_SESSION['id_pesan_siap'])){
    require_once("../../pengaturan/database.php");
    // Ambil detail pesan
    $query = $db->prepare("SELECT a.*,b.nm_meja FROM tbl_pesan a JOIN tbl_meja b ON a.id_meja = b.id_meja WHERE id_pesan = :id_pesan LIMIT 1");
    $query->bindParam("id_pesan", $_SESSION['id_pesan_siap']); 
    $query->execute();
    $detail_pesan = $query->fetch();
    
    
    // Ambil daftar pesan
    $query = $db->prepare("select `a`.`id_detail` AS `id_detail`,`a`.`id_pesan` AS `id_pesan`,`b`.`nama` AS `nama`,`b`.`harga` AS `harga`,`a`.`jumlah` AS `jumlah`,(`a`.`jumlah` * `b`.`harga`) AS `sub_bayar` from (`tbl_detail_pesan` `a` join `tbl_menu` `b` on((`a`.`id_menu` = `b`.`id_menu`))) WHERE a.id_pesan = :id_pesan");
    $query->bindParam("id_pesan", $_SESSION['id_pesan_siap']); 
    $query->execute();
    $daftar_pesan = $query->fetchAll(PDO::FETCH_ASSOC);
  }else{
    header("Location: $alamat_web/pesan?status=belum_pesan");
  }
?>
<html>

<head>
  <?php
    include("../../template/head.php");
  ?>
</head>

<body class="skin-blue layout-top-nav">

<body class="skin-blue layout-top-nav" style="height: auto; min-height: 100%;">
  <div class="wrapper" style="height: auto; min-height: 100%;">
    <?php include("../../template/header-pelanggan.php"); ?>
    <div class="content-wrapper" style="min-height: 335px;">
      <div class="container">
        <section class="content-header">
        <a href="<?=$alamat_web?>/pesan" class="btn btn-success btn-flat">< Kembali Ke Halaman Menu</a>
        </section>
        <section class="content">
          <?php
            if(empty($detail_pesan)){
          ?>
            <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Anda belum memiliki pesanan!</h4>
            Silahkan klik menu kembali ke halaman menu untuk membuat pesanan dan selesaikan pesanan.
          </div>
          <?php
            }else{
          ?>
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
                      <input class="form-control" type="text" id="id_pesan" value="<?=$detail_pesan['id_pesan']?>" name="id_pesan"
                        readonly>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Nama Pemesan</label>
                      <input class="form-control" type="text" id="nama_pemesan" value="<?=$detail_pesan['nama_pemesan']?>" readonly>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Tanggal Pesan</label>
                      <input class="form-control" type="text" id="tanggal_pesan" value="<?=tanggal_indo_waktu($detail_pesan['tanggal_pesan'])?>" readonly>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Nomor Meja</label>
                      <input class="form-control" type="text" id="nm_meja" value="<?=$detail_pesan['nm_meja']?>" readonly>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Status Pesanan</label>
                      <input class="form-control" type="text" id="status_pesanan" value="<?=$detail_pesan['status_pesanan']?>" readonly>
                    </div>
                    <a href="<?=$alamat_web?>/pesan/reset-pesan.php?tinggalkan_meja=true" class="btn btn-danger" style="display: none;">Tinggalkan Meja</a>
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
                        <th class="text-right">Harga</th>
                        <th class="text-right">Jumlah</th>
                        <th class="text-right">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
          $no = 1;
          if(count($daftar_pesan) > 0){
            $total = 0;
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
                          <?=rupiah($d['harga'])?>
                        </td>
                        <td class="text-right">
                          <?=$d['jumlah']?>
                        </td>
                        <td class="text-right">
                          <?=rupiah($d['jumlah']*$d['harga'])?>
                        </td>
                      </tr>
                      <?php 
            $no++;
            $total += ($d['jumlah']*$d['harga']);
            }
            ?>
            <tr>
                        <td colspan=4>Total Bayar</td>
                        <td class="text-right"><?=rupiah($total)?></td>
                      </tr>
            <?php
          }else{
          ?>
                      <tr>
                        <td colspan=5 class="text-center">Pesanan tidak ada!</td>
                      </tr>
                      <?php
          }
          ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          <?php
            }
          ?>
          
          </div>
          </section>
        </div>
      </div>
      <?php include("../../template/footer.php"); ?>
    </div>
    <script src="<?=$alamat_web?>/assets/js/axios.min.js"></script>
    <script>
    function getDataPesanan(){
      axios.get("<?=$alamat_web?>/pesan/daftar-pesan/daftar-pesan-api.php?id_pesan=<?=$_SESSION['id_pesan_siap']?>")
          .then(function (res) {
            var data = res.data;
              total_data = data.total;
              var baris_baru = ""
              // Tampilkan data
              if (data.total == 0) {
                baris_baru =
                  "<tr><td colspan=7 class='text-center'>Belum ada pesanan saat ini. Silahkan cek menu <b>Pencarian</b> untuk melakukan pencarian data pesanan.</td></tr>";
              } else {
                document.getElementById('id_pesan').value = data.data[0]['id_pesan'];
                document.getElementById('nama_pemesan').value = data.data[0]['nama_pemesan'];
                document.getElementById('tanggal_pesan').value = tanggal_indo_waktu(data.data[0]['tanggal_pesan']);
                document.getElementById('nm_meja').value = data.data[0]['nm_meja'];
                document.getElementById('status_pesanan').value = data.data[0]['status_pesanan'];
                }
          })
    }
    setInterval(getDataPesanan, 10000);
    </script>
    <?php include("../../template/script.php"); ?>
  </body>

</html>
