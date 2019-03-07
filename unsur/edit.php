<?php
  session_start();
  require("../pengaturan/helper.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit unsur";
  if(isset($_GET['id_unsur'])){
    require_once("../pengaturan/database.php");
    $query = $db->prepare("SELECT * FROM tbl_unsur WHERE id_unsur = ? LIMIT 1"); 
    $query->bindParam(1, $_GET['id_unsur']);
    $query->execute();
    $detail = $query->fetch();
    
    // cek dulu, datanya ketemu atau tidak. Kalau gk ketemu, ya redirect ke halaman awal
    if(empty($detail)){
      header("Location: $alamat_web/unsur");
    }
  }else{
    header("Location: $alamat_web/unsur");
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
          <h3 class="box-title">Tambah Unsur</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/unsur/proses_edit.php">
              <input class="form-control"  type="hidden" name="id_unsur" value="<?=$detail['id_unsur']?>" />
              <div class="form-group">
                <label class="form-label" >Nama unsur</label>
                <input class="form-control"  type="text" name="nm_unsur" value="<?=$detail['nm_unsur']?>" required />
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-flat btn-primary" >Simpan perubahan</button>
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
