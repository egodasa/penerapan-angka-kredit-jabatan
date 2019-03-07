<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit Posisi";
  if(isset($_GET['id_posisi'])){
    $detail = $db->get("tbl_posisi", "*", ["id_posisi" => $_GET['id_posisi']]); 
    
    // cek dulu, datanya ketemu atau tidak. Kalau gk ketemu, ya redirect ke halaman awal
    if(empty($detail)){
      header("Location: $alamat_web/posisi");
    }
  }else{
    header("Location: $alamat_web/posisi");
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
  <?php include "../template/menu.php"; ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Posisi</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/posisi/proses_edit.php" enctype="multipart/form-data">
              <input class="form-control"  type="hidden" name="id_posisi" value="<?=$detail['id_posisi']?>" />
              <div class="form-group">
                <label class="form-label">Nama Posisi</label>
                <input class="form-control"  type="text" name="nm_posisi" required />
              </div>
              <div class="form-group">
                <label class="form-label">Jenis Posisi</label>
                <select class="form-control custom-select"  name="jenis_posisi" required>
                  <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                  <option value="Staff Pegawai">Staff Pegawai</option>
                  <option value="Tim Penilai">Tim Penilai</option>
                </select>
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
  <script>
    document.getElementsByName("nm_posisi")[0].value = "<?=$detail['nm_posisi']?>";
    document.getElementsByName("jenis_posisi")[0].value = "<?=$detail['jenis_posisi']?>";
  </script>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
