<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit Jabatan";
  if(isset($_GET['id_posisi']))
  {
    $detail = $db->get("tbl_posisi", "*", ["id_posisi" => $_GET['id_posisi']]); 
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
    <?php
      include("breadcrumb.php");
    ?>
    <section class="content">
      <div class="box">
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/posisi/proses_edit.php" enctype="multipart/form-data">
              <input class="form-control"  type="hidden" name="id_posisi" value="<?=$detail['id_posisi']?>" />
              <div class="form-group">
                <label class="form-label">Nama Jabatan</label>
                <input class="form-control"  type="text" name="nm_posisi" required />
              </div>
              <div class="form-group">
                <label class="form-label">Jenis Jabatan</label>
                <select class="form-control custom-select"  name="jenis_posisi" required>
                  <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                  <option value="Staff Kepegawaian">Staff Kepegawaian</option>
                  <option value="Tim Penilai">Tim Penilai</option>
                  <option value="Pejabat Pengusul">Pejabat Pengusul</option>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-flat btn-primary" >Simpan Perubahan</button>
                <button type="reset" class="btn btn-flat btn-danger" >Reset</button>
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
