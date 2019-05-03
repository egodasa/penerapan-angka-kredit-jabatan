<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit Usulan";
  if(isset($_GET['id_usulan']))
  {
    $detail = $db->get("tbl_usulan", "*", ['id_usulan' => $_GET['id_usulan']]); 
    $detail_jabatan_sekarang = $db->query("SELECT a.*, b.*, c.* FROM tbl_pangkat a JOIN tbl_jabatan b ON a.id_jabatan = b.id_jabatan JOIN tbl_posisi c ON b.id_posisi = c.id_posisi WHERE a.id_pangkat = :id_pangkat", ["id_pangkat" => $detail['id_pangkat_sekarang']])->fetch();
    $detail_jabatan_selanjutnya = $db->query("SELECT a.*, b.*, c.* FROM tbl_pangkat a JOIN tbl_jabatan b ON a.id_jabatan = b.id_jabatan JOIN tbl_posisi c ON b.id_posisi = c.id_posisi WHERE a.id_pangkat = :id_pangkat", ["id_pangkat" => $detail['id_pangkat_selanjutnya']])->fetch();
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
                <input class="form-control" type="text" name="tgl_usulan" id="tgl_usulan" readonly required />
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
                <label class="form-label">Pangkat/Golongan Sekarang</label>
                <select name="id_pangkat_sekarang" class="form-control" readonly>
                  <option><?=$detail_jabatan_sekarang['nm_pangkat']?></option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Pangkat/Golongan Selanjutnya</label>
                <select name="id_pangkat_selanjutnya" class="form-control" readonly>
                  <option><?=$detail_jabatan_selanjutnya['nm_pangkat']?></option>
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
