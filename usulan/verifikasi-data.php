<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require("../pengaturan/medoo.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Verifikasi Data";
  //~ $ak_pendidikan = $db->query("SELECT SUM(a.angka_kredit) AS angka_kredit FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE b.kategori_unsur = 'Pendidikan' AND a.id_usulan = :id_usulan", ['id_usulan' => $_GET['id_usulan']])->fetch();
  //~ $ak_tugas_pokok = $db->query("SELECT SUM(a.angka_kredit) AS angka_kredit FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE b.kategori_unsur = 'Tugas Pokok' AND a.id_usulan = :id_usulan", ['id_usulan' => $_GET['id_usulan']])->fetch();
  //~ $ak_pengembangan_profesi = $db->query("SELECT SUM(a.angka_kredit) AS angka_kredit FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE b.kategori_unsur = 'Pengembangan Profesi' AND a.id_usulan = :id_usulan", ['id_usulan' => $_GET['id_usulan']])->fetch();
?>

<html>
<head>
  <?php
    include("../template/head.php");
  ?>
</head>
<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">
  
  <?php include "../template/menu.php"; 
  ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Verifikasi Data</h3>
        </div>
        <div class="box-body table-responsive">
          <form action="proses_edit.php" method="POST">
            <input type="hidden" name="jenis_usulan" value="verifikasi" />
            <input type="hidden" name="id_usulan" value="<?=$_GET['id_usulan']?>" />
            <div class="form-group">
              <label class="form-label">Hasil Verifikasi</label>
              <select class="form-control custom-select" name="status_proses" required>
                <option selected disabled>-- Pilih Hasil Verifikasi --</option>
                <option value="Sedang Proses Penilaian">Verifikasi Berhasil</option>
                <option value="Verifikasi Gagal">Verifikasi Gagal</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Keterangan Verifikasi</label>
              <small><br/>*Keterangan jika verifikasi gagal.</small>
              <textarea name="keterangan" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Sekarang</button>
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
