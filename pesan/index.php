<?php
  session_start();
  require("../pengaturan/helper.php");
  $judul_halaman = "Pemesanan Menu";
  require("../pengaturan/database.php");
  if(!isset($_SESSION['id_pesan'])){
    if(empty(($_SESSION['id_pesan']))){
      $_SESSION['id_pesan'] = generateNumber();
    }
  }
  
  // Ambil daftar menu
  $sql = "SELECT menu.*, kategori.nm_kategori FROM tbl_menu menu JOIN tbl_kategori kategori on menu.id_kategori = kategori.id_kategori WHERE 1";
  // Nilai default untuk filter daftar menu
  $filter_kategori = 0;
  $filter_nama = "";
  $filter_min = "";
  
  // Filter kategori
  if(isset($_GET['kategori']) && !empty($_GET['kategori'])){
    $filter_kategori = $_GET['kategori'];
    $sql .= " AND menu.id_kategori = :kategori";
  }
  // Filter nama
  if(isset($_GET['nama']) && !empty($_GET['nama'])){
    $filter_nama = $_GET['nama'];
    $sql .= " AND menu.nama LIKE CONCAT('%', :nama ,'%')";
  }
  // Filter harga minimal
  if(isset($_GET['nilai_min']) && !empty($_GET['nilai_min'])){
    $filter_min = $_GET['nilai_min'];
    $sql .= " AND menu.harga >= :min";
  }
  // Filter harga maksimal
  if(isset($_GET['nilai_max']) && !empty($_GET['nilai_max'])){
    $filter_max = $_GET['nilai_max'];
    $sql .= " AND menu.harga <= :max";
  }
  // Filter urutan harga
  if(isset($_GET['harga']) && !empty($_GET['harga'])){
    $filter_harga = $_GET['harga'];
    if($_GET['harga'] == "termurah"){
      $sql .= " ORDER BY menu.harga ASC";
    }else{
      $sql .= " ORDER BY menu.harga DESC";
    }
  }
  
  $sql .= " ORDER BY nm_kategori ASC";

  // Eksekusi query daftar menu beserta filternya
  $query = $db->prepare($sql);
  if(isset($_GET['kategori']) && !empty($_GET['kategori'])){
    $query->bindParam("kategori", $filter_kategori, PDO::PARAM_INT);
  }
  if(isset($_GET['nama']) && !empty($_GET['nama'])){
    $query->bindParam("nama", $filter_nama);
  }
  if(isset($_GET['min']) && !empty($_GET['min'])){
    $query->bindParam("min", $filter_min);
  }
  if(isset($_GET['max']) && !empty($_GET['max'])){
    $query->bindParam("max", $filter_max);
  }
  $query->execute();
  $daftar_menu = $query->fetchAll(PDO::FETCH_ASSOC);
  
  // Ambil daftar kategori
  $query = $db->prepare("SELECT * FROM tbl_kategori"); 
  $query->execute();
  $kategori = $query->fetchAll(PDO::FETCH_ASSOC);
  
  // Ambil daftar pesanan
  $query = $db->prepare("select `a`.`id_tmp` AS `id_tmp`,`a`.`id_pesan` AS `id_pesan`,`b`.`nama` AS `nama`,`b`.`harga` AS `harga`,`a`.`jumlah` AS `jumlah`,(`a`.`jumlah` * `b`.`harga`) AS `sub_bayar` from (`tbl_detail_pesan_tmp` `a` join `tbl_menu` `b` on((`a`.`id_menu` = `b`.`id_menu`))) WHERE a.id_pesan = :id_pesan");
  $query->bindParam("id_pesan", $_SESSION['id_pesan']);
  $query->execute();
  $data_pesanan = $query->fetchAll(PDO::FETCH_ASSOC);
  
  // Ambil daftar meja
  $query = $db->prepare("SELECT * FROM tbl_meja");
  $query->execute();
  $data_meja = $query->fetchAll(PDO::FETCH_ASSOC);

  // Tombol batal dan selesai akan mati jika keranjang masih kosong
  $status_tombol_pesan = "";
  if(count($data_pesanan) == 0){
    $status_tombol_pesan = "disabled";
  }
?>
<html>

<head>
  <?php
    include("../template/head.php");
  ?>
  <style>
    .user-block .username{
      margin-left: 5px;
    }
    .user-block .description{
      margin-left: 5px;
    }
  </style>
</head>

<body class="skin-blue layout-top-nav" style="height: auto; min-height: 100%;">
  <div class="wrapper" style="height: auto; min-height: 100%;">
    <?php include("../template/header-pelanggan.php"); ?>
    <div class="content-wrapper" style="min-height: 335px;">
      <div class="container">
        <section class="content-header">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
              <button type="button" class="btn btn-info btn-flat btn-block" data-toggle="modal" data-target="#pencarian">
                <i class="fa fa-search"></i>
                Pencarian Menu
              </button>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
              <button id="btn_keranjang" type="button" class="btn btn-warning btn-flat btn-block" data-toggle="modal" data-target="#keranjang">
                Keranjang Pesanan
              </button>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
              <button type="button" class="btn btn-success btn-flat btn-block" data-toggle="modal" data-target="#selesaikan" <?=$status_tombol_pesan?>>
                <i class="fa fa-check"></i>
                Selesaikan Pesanan
              </button>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
              <a class="btn btn-danger btn-flat btn-block <?=$status_tombol_pesan?>" href="<?=$alamat_web?>/pesan/reset-pesan.php"><i
                  class="fa fa-close"></i> Batalkan/Ulang Pesan</a>
            </div>
          </div>

        </section>
        <section class="content">

          <?php if(isset($_GET['simpan'])): ?>
          <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Pesanan telah berhasil dilakukan!</h4>
            Silahkan lakukan pembayaran kepada kasir atau cek status pesanan di menu <a href="<?=$alamat_web?>/pesan/daftar-pesan">STATUS PESANAN</a>.
          </div>
          <?php endif; ?>

          <?php if(isset($_GET['tambah'])): ?>
          <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Menu berhasil ditambahkan!</h4>
            Silahkan klik menu <b>SELESAIKAN PESANAN</b> atau tambahkan menu lain.
          </div>
          <?php endif; ?>

          <?php if(isset($_GET['tinggalkan_meja'])): ?>
          <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Pesanan berhasil diselesaikan!</h4>
            Anda sudah bisa meninggalkan meja makan.
          </div>
          <?php endif; ?>

          <?php if(isset($_GET['status'])): ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Anda belum melakukan pemesanan!</h4>
            Silahkan lakukan pemesanan terlebih dahulu agar bisa melihat status pesanan yang dipesan.
          </div>
          <?php endif; ?>

          <?php if(isset($_GET['hapus'])): ?>
          <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Menu berhasil dihapus dari keranjang pesanan!</h4>
          </div>
          <?php endif; ?>

          <?php if(isset($_GET['cocok'])): ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> kode Meja yang Anda entrikan tidak cocok!</h4>
            Silahkan tanya kode meja kebagian kasir.
          </div>
          <?php endif; ?>

          <?php if(isset($_GET['edit'])): ?>
          <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Pesanan berhasil diedit!</h4>
          </div>
          <?php endif; ?>

          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Menu</h3>
            </div>
            <div class="box-body table-responsive ">
              <?php
                    $no = 1;
                    if(count($daftar_menu) > 0){
                      foreach($daftar_menu as $d){
                    ?>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="box box-widget">
                  <div class="box-header with-border">
                    <div class="user-block">
                      <span class="username">
                        <?=$d['nama']?></span>
                      <span class="description">
                        <?=rupiah($d['harga'])?></span>
                    </div>
                  </div>
                  <div class="box-body table-responsive ">
                    <img class="img-responsive pad" src="<?=$alamat_web."/assets/img/produk/".$d['gambar']?>" alt="Photo">
                    <p>

                    </p>

                  </div>
                  <div class="box-footer">
                    <form action="<?=$alamat_web?>/pesan/tambah-pesan.php" method="POST" name="tambah_pesan">
                      <div class="input-group input-group-sm">
                        <input class="form-control" type="hidden" value="<?=$d['id_menu']?>" name="id_menu" />
                        <input class="form-control" type="hidden" value="<?=$_SESSION['id_pesan']?>" name="id_pesan" />
                        <input class="form-control" type="number" min=1 name="jumlah" placeholder="Jumlah" required />
                        <span class="input-group-btn">
                          <button class="btn btn-primary" type="submit"><i class="fa fa-cart-plus"></i></button>
                        </span>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php 
                      $no++;
                      }
                    }else{
                    ?>
              <p class="text-center">Menu tidak tersedia.</p>
              <?php
                    }
                    ?>
            </div>

            <!-- Modal Selesaikan Pesanan -->
            <div class="modal fade" id="selesaikan" tabindex="-1" role="dialog" aria-labelledby="selesaikan">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Selesaikan Pesanan</h4>
                  </div>
                  <form method="POST" action="<?=$alamat_web?>/pesan/simpan-pesan.php">
                    <div class="modal-body table-responsive">
                      <input class="form-control" type="hidden" name="id_pesan" value="<?=$_SESSION['id_pesan']?>" />
                      <div class="form-group">
                        <label class="form-label">Nomor Pesan</label>
                        <input class="form-control" type="text" name="id_pesan" value="<?=$_SESSION['id_pesan']?>"
                          readonly />
                      </div>
                      <div class="form-group">
                        <label class="form-label">Nama Pemesan</label>
                        <input class="form-control" type="text" name="nama_pemesan" required />
                      </div>
                      <div class="form-group">
                        <label class="form-label">Nomor Meja</label>
                        <select class="form-control custom-select" name="id_meja" required>
                          <option selected disabled>-- Pilih Meja --</option>
                          <?php foreach($data_meja as $d): ?>
                          <option value="<?=$d['id_meja']?>">
                            <?=$d['nm_meja']?>
                          </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Kode Meja</label>
                        <input class="form-control" type="text" name="kd_meja" required />
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-primary" type="submit">Selesaikan Pesanan</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>


            <!-- Modal Pencarian Menu-->
            <div class="modal fade" id="pencarian" tabindex="-1" role="dialog" aria-labelledby="pencarian">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Pencarian Menu</h4>
                  </div>
                  <form method="GET" onsubmit="return validasiFilterHarga()">
                    <div class="modal-body table-responsive">
                      <div class="form-group">
                        <label class="form-label">Nama Menu</label>
                        <input class="form-control" type="text" name="nama" value="<?=$filter_nama?>" />
                      </div>
                      <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <select class="form-control custom-select" name="kategori">
                          <option value="0" <?=$filter['kategori']==0 ? ' selected="selected"' : '' ;?>>-- Semua
                            Kategori Menu --</option>
                          <?php foreach($kategori as $d): ?>
                          <option value="<?=$d['id_kategori']?>" <?=$filter_kategori==$d['id_kategori'] ?
                            ' selected="selected"' : '' ;?>>
                            <?=$d['nm_kategori']?>
                          </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Urutan Harga</label>
                        <select class="form-control custom-select" name="harga">
                          <option selected disabled>-- Pilih Urutan --</option>
                          <option value="termurah" <?=$filter_harga=='termurah' ? ' selected="selected"' : '' ;?>>Termurah</option>
                          <option value="termahal" <?=$filter_harga=='termahal' ? ' selected="selected"' : '' ;?>>Termahal</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Harga Minimal</label>
                        <input class="form-control" type="text" name="min" id="min" value="<?=$filter_min?>" />
                        <input type="hidden" name="nilai_min" id="nilai_min" value="<?=$filter_min?>" />
                      </div>
                      <div class="form-group">
                        <label class="form-label">Harga Maksimal</label>
                        <input class="form-control" type="text" name="max" id="max" value="<?=$filter_max?>" />
                        <input type="hidden" name="nilai_max" id="nilai_max" value="<?=$filter_max?>" />
                      </div>

                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-primary" type="submit">Tampilkan</button>
                      <a href="<?=$alamat_web?>/pesan" class="btn btn-danger">Reset</a>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>


            <!-- Modal Keranjang Pesanan -->
            <div class="modal fade" id="keranjang" tabindex="-1" role="dialog" aria-labelledby="keranjang">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Keranjang Pesanan</h4>
                  </div>
                  <div class="modal-body table-responsive">
                    <table class="table table-bordered table-striped dataTable">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Menu</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                    $no = 1;
                    $total_keranjang = 0;
                    if(count($data_pesanan) > 0){
                      $total_bayar = 0;
                      foreach($data_pesanan as $d){
                      $total_keranjang += $d['jumlah'];
                      $total_bayar += $d['sub_bayar'];
                    ?>
                        <tr>
                          <td>
                            <?=$no?>
                          </td>
                          <td>
                            Nama : <?=$d['nama']?><br>
                            Harga : <?=rupiah($d['harga'])?><br>
                            Jumlah : <?=$d['jumlah']?><br>
                            Total : <?=rupiah($d['sub_bayar'])?><br>
                          </td>
                          <td>
                            <form action="<?=$alamat_web?>/pesan/proses-edit-keranjang.php" method="POST">
                              <div class="form-group">
                                <label class="form-label">Edit Jumlah Pesanan</label>
                                <input class="form-control" type="number" name="jumlah" value="<?=$d['jumlah']?>" min="0" required />
                                <input type="hidden" name="id_tmp" value="<?=$d['id_tmp']?>" />
                              </div>
                              <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary">Edit</button>
                                <a href="<?=$alamat_web?>/pesan/hapus-pesan.php?id_tmp=<?=$d['id_tmp']?>" class="btn btn-sm btn-danger">Hapus</a>
                              </div>
                            </form>
                          </td>
                        </tr>
                        <?php 
                      $no++;
                      }
                    }else{
                    ?>
                        <tr>
                          <td colspan=6 class="text-center">Keranjang pesanan Anda kosong!</td>
                        </tr>
                        <?php
                    }
                    ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan=2>Total Bayar</td>
                          <td>
                            <?=rupiah($total_bayar)?>
                          </td>
                        </tr>
                        </tr>
                      </tfoot>
                    </table>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>

        </section>
      </div>
    </div>
    <?php include("../template/footer.php"); ?>
  </div>
  <script>
    var pengaturan_rupiah = {
          currencySymbol: "Rp",
          decimalCharacter: ',',
          digitGroupSeparator: '.'
        };
    var nilai_min = new AutoNumeric('#min', pengaturan_rupiah);
    var nilai_max = new AutoNumeric('#max', pengaturan_rupiah);
    
    document.getElementById("btn_keranjang").innerHTML = '<i class="fa fa-shopping-cart"></i> Keranjang Pesanan (<?=$total_keranjang?>)'; 
    function validasiFilterHarga(){
      document.getElementById("nilai_min").value = nilai_min.getNumber();
      document.getElementById("nilai_max").value = nilai_max.getNumber();
      var minimal = document.getElementById("nilai_min").value;
      var maximal = document.getElementById("nilai_max").value;
      if(minimal > maximal){
        alert("Harga minimal dan maksimal tidak cocok!");
        return false;
      }else return true;
    }
  </script>
  <?php include("../template/script.php"); ?>
</body>

</html>
