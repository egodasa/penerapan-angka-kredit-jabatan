<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit Unit Kerja";
  if(isset($_GET['id_unit_kerja'])){
    $detail = $db->get("tbl_unit_kerja", "*", ["id_unit_kerja" => $_GET['id_unit_kerja']]); 
    $posisi = $db->select("tbl_posisi", "*");
    $pegawai = $db->select("tbl_pegawai", "*");
    // cek dulu, datanya ketemu atau tidak. Kalau gk ketemu, ya redirect ke halaman awal
    if(empty($detail)){
      header("Location: $alamat_web/unit");
    }
  }else{
    header("Location: $alamat_web/unit");
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
          <h3 class="box-title">Tambah Unit Kerja</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/unit-kerja/proses_edit.php" enctype="multipart/form-data">
              <input class="form-control"  type="hidden" name="id_unit_kerja" value="<?=$detail['id_unit_kerja']?>" />
              <div class="form-group">
                <label class="form-label">Nama Unit Kerja</label>
                <input class="form-control"  type="text" name="nm_unit_kerja" required />
              </div>
              <div class="form-group">
                <label class="form-label">Atasan</label>
                <select class="form-control custom-select"  name="nip_atasan" required>
                  <?php foreach($pegawai as $d): ?>
                    <option value="<?=$d['nip']?>"><?=$d['nm_lengkap']." (".$d['nip'].")"?></option>
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
                <button type="submit" class="btn btn-primary" >Simpan perubahan</button>
                <button type="reset" class="btn btn-danger" >Reset</button>
              </div>
            </form>
        </div>
      </div>
    </section>
  </div>
  <script>
    document.getElementsByName("nm_unit_kerja")[0].value = "<?=$detail['nm_unit_kerja']?>";
    document.getElementsByName("jenis_unit_kerja")[0].value = "<?=$detail['jenis_unit_kerja']?>";
    document.getElementsByName("nip_atasan")[0].value = "<?=$detail['nip_atasan']?>";
  </script>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
