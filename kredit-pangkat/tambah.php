<?php
  session_start();
  require("../pengaturan/helper.php");
  require("../pengaturan/database.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Tambah pangkat";
  
  $query = $db->query("SELECT * FROM tbl_jabatan");
  $query->execute();
  $jabatan = $query->fetchAll(PDO::FETCH_ASSOC);
  
  
  //~ $query = $db->query("SELECT * FROM tbl_pangkat WHERE id_pangkat NOT IN (SELECT id_pangkat FROM tbl_jabatan_pangkat)");
  $query = $db->query("SELECT * FROM tbl_pangkat");
  $query->execute();
  $pangkat = $query->fetchAll(PDO::FETCH_ASSOC);
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
          <h3 class="box-title">Tambah Nilai Kredit Pangkat</h3>
        </div>
        <div class="box-body table-responsive ">
          <form method="POST" action="<?=$alamat_web?>/kredit-pangkat/proses_tambah.php">
            <div class="form-group">
              <label class="form-label">Jabatan</label>
              <select class="form-control custom-select"  name="id_jabatan" required>
                <option selected disabled>-- Pilih Jabatan --</option>
                <?php foreach($jabatan as $d): ?>
                  <option value="<?=$d['id_jabatan']?>"><?=$d['nm_jabatan']?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Pangkat</label>
              <select class="form-control custom-select"  name="id_pangkat" required>
                <option selected disabled>-- Pilih Pangkat --</option>
                <?php foreach($pangkat as $d): ?>
                  <option value="<?=$d['id_pangkat']?>"><?=$d['nm_pangkat']?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label" >Besar Nilai Kredit</label>
              <input class="form-control"  type="number" name="nilai_kredit" required />
            </div>
            <div class="form-group">
              <label class="form-label" >Peringkat</label>
              <small><br/>*Angka kecil = kedudukan jabatan/pangkat rendah</small>
              <input class="form-control"  type="number" name="peringkat" required />
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
