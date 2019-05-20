<?php
  session_start();
  require("../../vendor/autoload.php");
  require("../../pengaturan/helper.php");
  require("../../pengaturan/medoo.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit Angka Kredit";
  $detail = $db->query("SELECT a.*, b.*, c.*, d.* FROM tbl_usulan_unsur a JOIN tbl_butir_kegiatan b ON a.id_butir = b.id_butir 
JOIN tbl_sub_unsur c ON b.id_sub_unsur = c.id_sub_unsur 
JOIN tbl_unsur d ON c.id_unsur = d.id_unsur WHERE id_usulan_unsur = :id_usulan_unsur", ['id_usulan_unsur' => $_GET['id_usulan_unsur']])->fetch();
?>
<html>
<head>
  <?php
    include("../../template/head.php");
  ?>
</head>
<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">
  <?php include "../../template/menu.php"; ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Angka Kredit Kegiatan</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/usulan/unsur/proses_edit_penilaian.php">
              <input name="id_usulan" type="hidden" value="<?=$detail['id_usulan']?>" />
              <input name="id_usulan_unsur" type="hidden" value="<?=$detail['id_usulan_unsur']?>" />
            <div class="form-group">
              <label class="form-label">Unsur Kegiatan</label>
              <input name="nm_unsur" type="text" class="form-control" value="<?=$detail['nm_unsur']?>" readonly />
            </div>
            <div class="form-group">
              <label class="form-label">Sub Unsur Kegiatan</label>
              <input name="nm_sub_unsur" type="text" class="form-control" value="<?=$detail['nm_sub_unsur']?>" readonly/>
            </div>
            <div class="form-group">
              <label class="form-label">Butir Kegiatan</label>
              <input name="butir_kegiatan" type="text" class="form-control" value="<?=$detail['butir_kegiatan']?>" readonly/>
            </div>
            <div class="form-group">
              <label class="form-label">Detail Kegiatan</label>
              <textarea class="form-control custom-select" name="keterangan" readonly><?=$detail['keterangan']?></textarea>
            </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label class="form-label">Tanggal Mulai Kegiatan</label>
                    <input class="form-control"  type="text" name="tgl_mulai_kegiatan" id="tgl_mulai_kegiatan" value="<?=$detail['tgl_mulai_kegiatan']?>" readonly />
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
	                  <label class="form-label">Tanggal Selesai Kegiatan</label>
	                  <input class="form-control"  type="text" name="tgl_selesai_kegiatan" id="tgl_selesai_kegiatan" value="<?=$detail['tgl_selesai_kegiatan']?>" readonly />
	                </div>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Tingkat Kesulitan</label>
                <input class="form-control" type="text" name="tingkat_kesulitan" value="<?=$detail['tingkat_kesulitan']?>" readonly />
              </div>
              <div class="form-group">
                <label class="form-label">Bukti Kegiatan</label>
                <p><a href="<?=$alamat_web."/assets/img/foto/".$detail['bukti_kegiatan']?>"><img src="<?=$alamat_web."/assets/img/foto/".$detail['bukti_kegiatan']?>" width="300" height="300" /></a></p>
              </div>
              <div class="form-group">
                <label class="form-label">Satuan</label>
                <input class="form-control" type="text" name="satuan" value="<?=$detail['satuan']?>" readonly />
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label class="form-label">Angka Kredit Murni</label>
                    <input class="form-control"  type="text" name="angka_kredit_murni" value="<?=$detail['angka_kredit_murni']?>" onchange="detailButirKegiatan()" required />
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label class="form-label">Angka Kredit Persentase</label>
                    <input class="form-control"  type="text" name="angka_kredit_persentase" value="<?=$detail['angka_kredit_persentase']?>" onkeyup="hitungKredit()" required />
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Tempat</label>
                <input class="form-control" type="text" name="tempat" value="<?=$detail['tempat']?>" readonly />
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                  <label class="form-label">Jumlah Volume Kegiatan</label>
                  <input class="form-control" value="<?=$detail['jumlah_volume_kegiatan']?>" type="text" name="jumlah_volume_kegiatan" onkeyup="hitungKredit()" required />
                </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                  <label class="form-label">Total Kredit</label>
                  <input class="form-control" value="<?=$detail['angka_kredit']?>" type="text" name="angka_kredit" required />
                </div>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Status Unsur Kegiatan</label>
                <select name="status" class="form-control">
                  <option value="">-- Pilih Status --</option>
                  <option value="Diterima">Diterima</option>
                  <option value="Ditolak">Ditolak</option>
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
  <?php include "../../template/footer.php"; ?>
  <?php include("../../template/script.php"); ?>
  <script>
    function hitungKredit(){
      var persentase = document.getElementsByName("angka_kredit_persentase")[0].value/100 || 0;
      var murni = document.getElementsByName("angka_kredit_murni")[0].value || 0;
      var volume = document.getElementsByName("jumlah_volume_kegiatan")[0].value || 0;
      document.getElementsByName("angka_kredit")[0].value = volume * (persentase * murni);
    }
  </script>
</div>
</body>
</html>

