<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  $judul_halaman = "Tambah Unsur Kegiatan";
?>
<html>
<head>
  <?php
    include("../template/head.php");
  ?>
</head>
<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">
  <?php include "../template/menu-staff.php"; ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <?php
      include("breadcrumb.php");
    ?>
    <section class="content">
      <div class="box">
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/unsur/proses_tambah.php">
              <div class="form-group">
                <label class="form-label">Nama Unsur</label>
                <input class="form-control"  type="text" name="nm_unsur" required />
              </div>
              <div class="form-group">
                <label class="form-label">Kategori</label>
                <select class="form-control" name="kategori">
                  <option value="Unsur Utama">Unsur Utama</option>
                  <option value="Unsur Penunjang">Unsur Penunjang</option>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-flat btn-primary" >Simpan</button>
                <button type="reset" class="btn btn-flat btn-danger" >Reset</button>
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
