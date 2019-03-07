<?php
  session_start();
  require_once("../../vendor/autoload.php");
  require("../../pengaturan/helper.php");
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Daftar Sub Unsur Kegiatan";
  require("../../pengaturan/medoo.php");
  $data= $db->query("SELECT a.*, b.nm_posisi FROM tbl_sub_unsur a JOIN tbl_posisi b ON a.id_posisi = b.id_posisi")->fetchAll();
  $detail_unsur = $db->get("tbl_unsur", ['nm_unsur'], ['id_unsur' => $_GET['id_unsur']]);
?>
<html>
<head>
  <?php
    include("../../template/head.php");
  ?>
</head>

<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
  <div class="wrapper" style="height: auto; min-height: 100%;">
    <?php include "../../template/menu.php"; ?>
    <div class="content-wrapper" style="min-height: 901px;">
      <section class="content">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Daftar Sub Unsur <?=$detail_unsur['nm_unsur']?></h3>
          </div>
          <div class="box-body table-responsive ">
            <a href="<?=$alamat_web?>/unsur" class="btn btn-flat btn btn-primary">Kembali</a>
            <a href="<?=$alamat_web?>/unsur/sub-unsur/tambah.php?id_unsur=<?=$_GET['id_unsur']?>" class="btn btn-flat  btn btn-success">Tambah Data</a>
            <table id="tabel" class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Sub Unsur Kegiatan</th>
                  <th>Posisi</th>
                  <th>Jenis Sub Unsur Kegiatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
<?php
  $no = 1;
  foreach($data as $d)
  {
?>
                <tr>
                  <td>
                    <?=$no?>
                  </td>
                  <td>
                    <?=$d['nm_unsur']?>
                  </td>
                  <td>
                    <?=$d['nm_posisi']?>
                  </td>
                  <td>
                    <?=$d['jenis_unsur']?>
                  </td>
                  <td>
                    <?=$d['kategori_unsur']?>
                  </td>
                  <td>
                    <a href="<?=$alamat_web?>/unsur/sub-unsur/proses_hapus.php?id_sub_unsur=<?=$d['id_sub_unsur']?>" class="btn btn-flat  btn btn-danger">Hapus</a>
                    <a href="<?=$alamat_web?>/unsur/sub-unsur/edit.php?id_sub_unsur=<?=$d['id_sub_unsur']?>&id_unsur=<?=$d['id_unsur']?>" class="btn btn-flat  btn btn-primary">Edit</a>
                  </td>
                </tr>
                <?php 
    $no++;
  }
?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
    <?php include("../../template/footer.php"); ?>
  </div>
  <?php include("../../template/script.php"); ?>
</body>
</html>
