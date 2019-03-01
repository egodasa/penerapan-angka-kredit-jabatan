<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Tambah Unsur Kegiatan";
   $posisi = $db->select("tbl_posisi", "*", ['jenis_posisi' => "Tenaga Kependidikan"]);
?>
<html>
<head>
  <?php
    include("../template/head.php");
  ?>
</head>
<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">
  <?php include "../template/menu.php"; ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Input Unsur Kegiatan</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/unsur-kegiatan/proses_tambah.php" enctype="multipart/form-data">
              <div class="form-group">
                <label class="form-label">Nama Unsur Kegiatan</label>
                <input class="form-control"  type="text" name="nm_unsur" required />
              </div>
              <div class="form-group">
                <label class="form-label">Posisi Unsur Kegiatan</label>
                <select class="form-control custom-select"  name="id_posisi" required>
                  <?php foreach($posisi as $d): ?>
                    <option value="<?=$d['id_posisi']?>"><?=$d['nm_posisi']?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Jenis Unsur Kegiatan</label>
                <select class="form-control custom-select"  name="jenis_unsur" required>
                  <option value="Unsur Utama">Unsur Utama</option>
                  <option value="Unsur Penunjang">Unsur Penunjang</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Kategori Unsur Kegiatan</label>
                <select class="form-control custom-select"  name="kategori_unsur" required>
                  <option value="Pendidikan">Pendidikan</option>
                  <option value="Tugas Pokok">Tugas Pokok</option>
                  <option value="Pengembangan Profesi">Pengembangan Profesi</option>
                </select>
              </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary" >Simpan</button>
              <button type="reset" class="btn btn-danger" >Reset</button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
