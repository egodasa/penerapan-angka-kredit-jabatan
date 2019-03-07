<?php
  session_start();
  require("../pengaturan/helper.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit jenis berkas";
  if(isset($_GET['id_berkas'])){
    require_once("../pengaturan/database.php");
    $query = $db->prepare("SELECT * FROM tbl_jenis_berkas WHERE id_berkas = ? LIMIT 1"); 
    $query->bindParam(1, $_GET['id_berkas']);
    $query->execute();
    $detail = $query->fetch();
    
    // cek dulu, datanya ketemu atau tidak. Kalau gk ketemu, ya redirect ke halaman awal
    if(empty($detail)){
      header("Location: $alamat_web/jenis-berkas");
    }
  }else{
    header("Location: $alamat_web/jenis-berkas");
  }
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
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Jenis Berkas</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/jenis-berkas/proses_edit.php">
              <input class="form-control"  type="hidden" name="id_berkas" value="<?=$detail['id_berkas']?>" />
              <div class="form-group">
                <label class="form-label" >Nama jenis berkas</label>
                <input class="form-control"  type="text" name="nm_berkas" value="<?=$detail['nm_berkas']?>" required />
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-flat  btn btn-primary" >Simpan perubahan</button>
                <button type="reset" class="btn btn-flat  btn btn-danger" >Reset</button>
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
