<?php
  session_start();
  require("../pengaturan/helper.php");
  cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Daftar Menu";
  require("../pengaturan/database.php");
  $query = $db->prepare("SELECT menu.*, kategori.nm_kategori FROM tbl_menu menu JOIN tbl_kategori kategori on menu.id_kategori = kategori.id_kategori"); 
  $query->execute();
  $data = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<head>
  <?php
    include("../template/head.php");
  ?>
</head>

<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">
  <?php include "../template/menu-kasir.php"; ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Menu</h3>
        </div>
        <div class="box-body table-responsive ">
          
<a href="<?=$alamat_web?>/menu/tambah.php" class="btn btn-success">Tambah Data</a>
<table class="table table-bordered" >
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Kategori</th>
      <th class="text-right">Harga</th>
      <th>Deskripsi</th>
      <th>Gambar</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
<?php
$no = 1;
if(count($data) > 0){
  foreach($data as $d){
?>
    <tr>
      <td><?=$no?></td>
      <td><?=$d['nama']?></td>
      <td><?=$d['nm_kategori']?></td>
      <td class="text-right"><?=rupiah($d['harga'])?></td>
      <td><?=$d['deskripsi']?></td>
      <td><img src="<?=$alamat_web?>/assets/img/produk/<?=$d['gambar']?>" width="200" height="150" /></td>
      <td>
        <a href="<?=$alamat_web?>/menu/proses_hapus.php?id_menu=<?=$d[id_menu]?>" class="btn btn-danger">Hapus</a> 
        <a href="<?=$alamat_web?>/menu/edit.php?id_menu=<?=$d[id_menu]?>" class="btn btn-primary">Edit</a></td>
    </tr>
<?php 
  $no++;
  }
}else{
?>
    <tr>
      <td colspan=7 class="text-center">Tidak ada data yang ditampilkan!</td>
    </tr>
<?php
}
?>
  </tbody>
</table>
        </div>
      </div>
    </section>
  </div>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>

</html>
