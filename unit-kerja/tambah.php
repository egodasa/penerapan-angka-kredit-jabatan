<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Tambah Unit Kerja";
  $posisi = $db->select("tbl_posisi", "*");
  $pegawai = $db->select("tbl_pegawai", "*");
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
          <h3 class="box-title">Input Unit Kerja</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/unit-kerja/proses_tambah.php" enctype="multipart/form-data">
              <div class="form-group">
                <label class="form-label">Nama Unit Kerja</label>
                <input class="form-control"  type="text" name="nm_unit_kerja" required />
              </div>
              <div class="form-group">
                <label class="form-label">Atasan</label>
                <select class="form-control custom-select"  name="nip_atasan" required>
                  <?php foreach($pegawai as $d): ?>
                    <option value="<?=$d['nip']?>"><?=$d['nip']." ".$d['nm_lengkap']?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Yang Dibawahi</label>
                <select class="form-control custom-select"  name="id_posisi" required>
                  <?php foreach($posisi as $d): ?>
                    <option value="<?=$d['id_posisi']?>"><?=$d['nm_posisi']?></option>
                  <?php endforeach; ?>
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
