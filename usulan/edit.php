<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit Usulan";
  if(isset($_GET['id_usulan'])){
    $detail = $db->get("tbl_usulan", "*", ['id_usulan' => $_GET['id_usulan']]); 
    $daftar_jabatan = $db->query("SELECT a.*, b.nm_jabatan, c.id_pangkat, c.nm_pangkat FROM tbl_jabatan_pangkat a JOIN tbl_jabatan b ON a.id_jabatan = b.id_jabatan JOIN tbl_pangkat c ON a.id_pangkat = c.id_pangkat")->fetchAll();
    // cek dulu, datanya ketemu atau tidak. Kalau gk ketemu, ya redirect ke halaman awal
    if(empty($detail)){
      header("Location: $alamat_web/usulan");
    }
  }else{
    header("Location: $alamat_web/usulan");
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
  <?php include "../template/menu.php";
  ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Usulan</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/usulan/proses_edit.php">
              <input class="form-control"  type="hidden" name="id_usulan" value="<?=$detail['id_usulan']?>" />
              <div class="form-group">
                <label class="form-label">Tanggal Usulan</label>
                <input class="form-control"  type="text" name="tgl_usulan" id="tgl_usulan" readonly required />
              </div>
              <div class="form-group">
                <label class="form-label">Masa Penilaian (Mulai)</label>
                <input class="form-control"  type="text" name="masa_penilaian_awal" id="masa_penilaian_awal" readonly required />
              </div>
              <div class="form-group">
                <label class="form-label">Masa Penilaian (Selesai)</label>
                <input class="form-control"  type="text" name="masa_penilaian_akhir" id="masa_penilaian_akhir" readonly required />
              </div>
              <div class="form-group">
                <label class="form-label">Jabatan Sekarang</label>
                <select name="id_jabatan_pangkat_sekarang" class="form-control" readonly>
                  <?php foreach($daftar_jabatan as $d): ?>
                    <option value="<?=$d['id_jabatan_pangkat']?>"><?=$d['nm_pangkat']?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Jabatan Selanjutnya</label>
                <select name="id_jabatan_pangkat_selanjutnya" class="form-control" readonly>
                  <?php foreach($daftar_jabatan as $d): ?>
                    <option value="<?=$d['id_jabatan_pangkat']?>"><?=$d['nm_pangkat']?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Masa Kerja Golongan Lama</label>
                <input class="form-control"  type="text" name="masa_kerja_golongan_lama" required />
              </div>
              <div class="form-group">
                <label class="form-label">Masa Kerja Golongan Baru</label>
                <input class="form-control"  type="text" name="masa_kerja_golongan_baru" required />
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
  <script>
    document.getElementsByName("id_jabatan_pangkat_sekarang")[0].value = "<?=$detail['id_jabatan_pangkat_sekarang']?>";
    document.getElementsByName("id_jabatan_pangkat_selanjutnya")[0].value = "<?=$detail['id_jabatan_pangkat_selanjutnya']?>";
    document.getElementsByName("tgl_usulan")[0].value = "<?=$detail['tgl_usulan']?>";
    document.getElementsByName("masa_penilaian_awal")[0].value = "<?=$detail['masa_penilaian_awal']?>";
    document.getElementsByName("masa_penilaian_akhir")[0].value = "<?=$detail['masa_penilaian_akhir']?>";
    document.getElementsByName("masa_kerja_golongan_lama")[0].value = "<?=$detail['masa_kerja_golongan_lama']?>";
    document.getElementsByName("masa_kerja_golongan_baru")[0].value = "<?=$detail['masa_kerja_golongan_baru']?>";
    var tanggal = new Pikaday({
      field: document.getElementById('tgl_usulan'),
      format: 'YYYY-MM-DD',
    });
    var masa_penilaian_awal = new Pikaday({
      field: document.getElementById('masa_penilaian_awal'),
      format: 'YYYY-MM-DD',
    });
    var masa_penilaian_akhir = new Pikaday({
      field: document.getElementById('masa_penilaian_akhir'),
      format: 'YYYY-MM-DD',
    });
  </script>
</div>
</body>
</html>
