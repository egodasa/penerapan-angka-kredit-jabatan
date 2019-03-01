<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Profil Saya";
  if(isset($_SESSION['nip'])){
    $detail = $db->query("SELECT a.*,
                                 f.nm_posisi,
                                 d.nm_jabatan,
                                 e.nm_pangkat
                          FROM   tbl_pegawai a
                                 JOIN tbl_unit_kerja b
                                   ON a.id_unit_kerja = b.id_unit_kerja
                                 JOIN tbl_jabatan_pangkat c
                                   ON a.id_jabatan_pangkat = c.id_jabatan_pangkat
                                 JOIN tbl_jabatan d
                                   ON c.id_jabatan = d.id_jabatan
                                 JOIN tbl_pangkat e
                                   ON c.id_pangkat = e.id_pangkat
                                 JOIN tbl_posisi f
                                   ON b.id_posisi = f.id_posisi WHERE a.nip = :nip", ["nip" => $_SESSION['nip']])->fetch(); 
    // cek dulu, datanya ketemu atau tidak. Kalau gk ketemu, ya redirect ke halaman awal
    if(empty($detail)){
      header("Location: $alamat_web/pegawai");
    }
  }else{
    header("Location: $alamat_web/pegawai");
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
          <h3 class="box-title">Profil Saya</h3>
        </div>
        <div class="box-body table-responsive ">
              <div class="form-group">
                <label class="form-label">NIP</label>
                <p name="nip"></p>
              </div>
              <div class="form-group">
                <label class="form-label">No Seri KARPEG</label>
                <p name="no_karpeg"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <p name="nm_lengkap"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <p name="jk"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Tempat Lahir</label>
                <p name="tempat_lahir"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Tanggal Lahir</label>
                <p name="tgl_lahir"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Nomor HP</label>
                <p name="nohp"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Email</label>
                <p name="email"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Foto</label>
                <p>
                  <?php
                    if(empty($detail['foto']))
                    {
                      echo "Belum ada foto";
                    }
                    else
                    {
                      echo "<img src='".$alamat_web."/assets/img/foto/".$detail['foto']."' width='100' height='200' />";
                    }
                  ?>
                </p>
              </div>
              <div class="form-group">
                <label class="form-label">Pendidikan</label>
                <p name="pendidikan"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Tanggal Lulus Pendidikan Terakhir</label>
                <p name="tgl_lulus"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Jabatan</label>
                <p name="id_jabatan_pangkat"></p>
              </div>
              <div class="form-group">
                <label class="form-label">TMT Jabatan</label>
                <p name="tmt_jabatan"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Posisi</label>
                <p name="posisi"></p>
              </div>
        </div>
      </div>
    </section>
  </div>
  <script>
    document.getElementsByName("nip")[0].innerHTML = "<?=$detail['nip']?>";
    document.getElementsByName("no_karpeg")[0].innerHTML = "<?=$detail['no_karpeg']?>";
    document.getElementsByName("nm_lengkap")[0].innerHTML = "<?=$detail['nm_lengkap']?>";
    document.getElementsByName("jk")[0].innerHTML = "<?=$detail['jk']?>";
    document.getElementsByName("tempat_lahir")[0].innerHTML = "<?=$detail['tempat_lahir']?>";
    document.getElementsByName("tgl_lahir")[0].innerHTML = "<?=tanggal_indo($detail['tgl_lahir'])?>";
    document.getElementsByName("nohp")[0].innerHTML = "<?=$detail['nohp']?>";
    document.getElementsByName("email")[0].innerHTML = "<?=$detail['email']?>";
    document.getElementsByName("pendidikan")[0].innerHTML = "<?=$detail['pendidikan']?>";
    document.getElementsByName("id_jabatan_pangkat")[0].innerHTML = "<?=$detail['nm_jabatan'].' '.$detail['nm_pangkat']?>";
    document.getElementsByName("posisi")[0].innerHTML = "<?=$detail['nm_posisi']?>";
    document.getElementsByName("tmt_jabatan")[0].innerHTML = "<?=tanggal_indo($detail['tmt_jabatan'])?>";
    document.getElementsByName("tgl_lulus")[0].innerHTML = "<?=tanggal_indo($detail['tgl_lulus'])?>";
  </script>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
