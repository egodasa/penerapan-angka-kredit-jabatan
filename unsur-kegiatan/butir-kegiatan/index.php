<?php
  session_start();
  require_once("../../vendor/autoload.php");
  require("../../pengaturan/helper.php");
  require("../../pengaturan/medoo.php");
  
  $detail_butir_kegiatan = $db->get("tbl_sub_unsur", "*", ["id_sub_unsur" => $_GET['id_sub_unsur']]);
  
  $judul_halaman = "Butir Kegiatan";
  $data = $db->select("tbl_butir_kegiatan", "*", ["id_sub_unsur" => $_GET['id_sub_unsur']]);
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
            <h3 class="box-title">Butir Kegiatan <br> Sub Unsur <?=$detail_butir_kegiatan['nm_unsur']?></h3>
          </div>
          <div class="box-body table-responsive ">
            <a href="<?=$alamat_web?>/unsur-kegiatan" class="btn btn-flat btn-primary">Kembali</a>
            <a href="<?=$alamat_web?>/unsur-kegiatan/butir-kegiatan/tambah.php?id_sub_unsur=<?=$detail_butir_kegiatan['id_sub_unsur']?>" class="btn btn-flat btn-success">Tambah Data</a>
            <table id="tabel" class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Butir Kegiatan</th>
                  <th>Satuan</th>
                  <th>Angka Kredit</th>
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
                  <td>
                    <?=$no?>
                  </td>
                  <td>
                    <?=$d['butir_kegiatan']?>
                  </td>
                  <td>
                    <?=$d['satuan']?>
                  </td>
                  <td>
                    <?=$d['angka_kredit']?>
                  </td>
                  <td>
                    <a href="<?=$alamat_web?>/unsur-kegiatan/butir-kegiatan/proses_hapus.php?id_sub_unsur=<?=$detail_butir_kegiatan['id_sub_unsur']?>&id_butir=<?=$d['id_butir']?>" class="btn btn-flat btn-danger">Hapus</a>
                    <a href="<?=$alamat_web?>/unsur-kegiatan/butir-kegiatan/edit.php?id_sub_unsur=<?=$detail_butir_kegiatan['id_sub_unsur']?>&id_butir=<?=$d['id_butir']?>" class="btn btn-flat btn-primary">Edit</a>
                  </td>
                </tr>
                <?php 
  $no++;
  }
}
else
{
?>
                <tr>
                  <td colspan=5 class="text-center">Tidak ada data yang ditampilkan!</td>
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
    <?php include("../../template/footer.php"); ?>
  </div>
  <?php include("../../template/script.php"); ?>
</body>
</html>
