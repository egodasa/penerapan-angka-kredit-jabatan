<?php
  session_start();
  require("../../pengaturan/helper.php");
  $judul_halaman = "Detail Pesanan";
  if(isset($_SESSION['id_pesan'])){
    require_once("../../pengaturan/database.php");
    // Ambil detail pesan
    $query = $db->prepare("SELECT a.*,b.nm_meja FROM tbl_pesan a JOIN tbl_meja b ON a.id_meja = b.id_meja WHERE id_pesan = :id_pesan LIMIT 1");
    $query->bindParam("id_pesan", $_SESSION['id_pesan']); 
    $query->execute();
    $detail_pesan = $query->fetch();
    
    
    // Ambil daftar pesan
    $query = $db->prepare("select `a`.`id_detail` AS `id_detail`,`a`.`id_pesan` AS `id_pesan`,`b`.`nama` AS `nama`,`b`.`harga` AS `harga`,`a`.`jumlah` AS `jumlah`,(`a`.`jumlah` * `b`.`harga`) AS `sub_bayar` from (`tbl_detail_pesan` `a` join `tbl_menu` `b` on((`a`.`id_menu` = `b`.`id_menu`))) WHERE a.id_pesan = :id_pesan");
    $query->bindParam("id_pesan", $_SESSION['id_pesan']); 
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
  <header class="main-header">
      <nav class="navbar navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <a href="<?=$alamat_web?>" class="navbar-brand"><b>
                <?=$nama_perusahaan?></b></a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
          </div>
          <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
            </ul>
          </div>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="user user-menu">
              <a href="<?=$alamat_web?>/pesan/daftar-pesan">Status Pesanan</a>     
              </li>  
              <li class="user user-menu">
              <a href="<?=$alamat_web?>/login">Login</a>     
              </li>  
            </ul>
            </div>
        </div>
      </nav>
    </header>
    <div class="content-wrapper" style="min-height: 335px;">
      <div class="container">
        <section class="content-header">
        <a href="<?=$alamat_web?>/pesan/daftar-pesan" class="btn btn-success btn-flat">< Kembali Ke Daftar Pesanan</a>
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
                    <a href="<?=$alamat_web?>/pesan/reset-pesan.php?status=tinggalkan_meja" class="btn btn-danger">Tinggalkan Meja</a>
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
      <?php include("../../template/footer.php"); ?>
    </div>
    <script src="<?=$alamat_web?>/assets/js/axios.min.js"></script>
    <script>
    function getDataPesanan(){
      axios.get("<?=$alamat_web?>/pesan/daftar-pesan/daftar-pesan-api.php?id_pesan=<?=$_SESSION['id_pesan']?>")
          .then(function (res) {
            var data = res.data;
              total_data = data.total;
              var baris_baru = ""
              // Tampilkan data
              if (data.total == 0) {
                baris_baru =
                  "<tr><td colspan=7 class='text-center'>Belum ada pesanan saat ini. Silahkan cek menu <b>Pencarian</b> untuk melakukan pencarian data pesanan.</td></tr>";
              } else {
                document.getElementById('nama_pemesan').value = data.data[0]['nama_pemesan'];
                document.getElementById('tanggal_pesan').value = data.data[0]['tanggal_pesan'];
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