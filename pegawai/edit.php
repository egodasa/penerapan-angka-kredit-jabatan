<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit Pegawai";
  if(isset($_GET['id_pegawai'])){
    $detail = $db->get("tbl_pegawai", "*", ["id_pegawai" => $_GET['id_pegawai']]); 
    $jabatan = $db->query("SELECT a.*, b.nm_jabatan, c.nm_pangkat FROM tbl_jabatan_pangkat a JOIN tbl_jabatan b ON a.id_jabatan = b.id_jabatan JOIN tbl_pangkat c on a.id_pangkat = c.id_pangkat")->fetchAll();; 
    $posisi = $db->query("SELECT a.*, b.nm_posisi FROM tbl_unit_kerja a JOIN tbl_posisi b ON a.id_posisi = b.id_posisi")->fetchAll();
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
          <h3 class="box-title">Edit Pegawai</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/pegawai/proses_edit.php" enctype="multipart/form-data">
              <input class="form-control"  type="hidden" name="id_pegawai" value="<?=$detail['id_pegawai']?>" />
              <div class="form-group">
                <label class="form-label">NIP</label>
                <input class="form-control"  type="text" name="nip" required />
              </div>
              <div class="form-group">
                <label class="form-label">Password</label>
                <input class="form-control"  type="password" name="password" required />
              </div>
              <div class="form-group">
                <label class="form-label">No Seri KARPEG</label>
                <input class="form-control"  type="text" name="no_karpeg" required />
              </div>
              <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input class="form-control"  type="text" name="nm_lengkap" required />
              </div>
              <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <select class="form-control custom-select"  name="jk" required>
                  <option selected disabled>-- Pilih Jenis Kelamin --</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Tempat Lahir</label>
                <input class="form-control"  type="text" name="tempat_lahir" required />
              </div>
              <div class="form-group">
                <label class="form-label">Tanggal Lahir</label>
                <input class="form-control"  type="text" name="tgl_lahir" required />
              </div>
              <div class="form-group">
                <label class="form-label">Nomor HP</label>
                <input class="form-control"  type="text" name="nohp" required />
              </div>
              <div class="form-group">
                <label class="form-label">Email</label>
                <input class="form-control"  type="text" name="email" required />
              </div>
              <input type="hidden" name="foto_lama" value="<?=$detail['foto']?>" />
              <div class="form-group">
                <label class="form-label">Foto</label>
                <small>
                  <br/>
                  <?php
                    if(empty($detail['foto']))
                    {
                      echo "Belum ada foto";
                    }
                    else
                    {
                      echo "<img src='".$alamat_web."/assets/img/foto/".$detail['foto']."' width='100' height='200' /> <br/> Silahkan upload foto baru untuk mengganti foto.";
                    }
                  ?>
                </small>
                <input class="form-control"  type="file" name="foto" />
              </div>
              <div class="form-group">
                <label class="form-label">Pendidikan</label>
                <select class="form-control custom-select"  name="pendidikan" required>
                  <option selected disabled>-- Pilih Pendidikan --</option>
                  <option value="Sarjana (S1)/Diploma IV">Sarjana (S1)/Diploma IV</option>
                  <option value="Magister (S2)">Magister (S2)</option>
                  <option value="Doktor (S3)">Doktor (S3)</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Tanggal Lulus Pendidikan Terakhir</label>
                <input class="form-control"  type="text" name="tgl_lulus" required />
              </div>
              <div class="form-group">
                <label class="form-label">Jabatan</label>
                <select class="form-control custom-select"  name="id_jabatan_pangkat" required>
                  <option selected disabled>-- Pilih Jabatan --</option>
                  <?php foreach($jabatan as $d): ?>
                    <option value="<?=$d['id_jabatan_pangkat']?>"><?=$d['nm_jabatan']." ".$d['nm_pangkat']?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">TMT Jabatan</label>
                <input class="form-control"  type="text" name="tmt_jabatan" required />
              </div>
              <div class="form-group">
                <label class="form-label">Posisi</label>
                <select class="form-control custom-select"  name="id_unit_kerja" required>
                  <option selected disabled>-- Pilih Posisi --</option>
                  <?php foreach($posisi as $d): ?>
                    <option value="<?=$d['id_unit_kerja']?>"><?=$d['nm_posisi']." - ".$d['nm_unit_kerja']?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Kredit Awal Unsur Utama</label>
                <input class="form-control"  type="number" name="kredit_awal_utama" required />
              </div>
              <div class="form-group">
                <label class="form-label">Kredit Awal Unsur Penunjang</label>
                <input class="form-control"  type="number" name="kredit_awal_penunjang" required />
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
    document.getElementsByName("nip")[0].value = "<?=$detail['nip']?>";
    document.getElementsByName("no_karpeg")[0].value = "<?=$detail['no_karpeg']?>";
    document.getElementsByName("nm_lengkap")[0].value = "<?=$detail['nm_lengkap']?>";
    document.getElementsByName("jk")[0].value = "<?=$detail['jk']?>";
    document.getElementsByName("tempat_lahir")[0].value = "<?=$detail['tempat_lahir']?>";
    document.getElementsByName("tgl_lahir")[0].value = "<?=$detail['tgl_lahir']?>";
    document.getElementsByName("nohp")[0].value = "<?=$detail['nohp']?>";
    document.getElementsByName("email")[0].value = "<?=$detail['email']?>";
    document.getElementsByName("pendidikan")[0].value = "<?=$detail['pendidikan']?>";
    document.getElementsByName("id_jabatan_pangkat")[0].value = "<?=$detail['id_jabatan_pangkat']?>";
    document.getElementsByName("id_unit_kerja")[0].value = "<?=$detail['id_unit_kerja']?>";
    document.getElementsByName("kredit_awal_utama")[0].value = "<?=$detail['kredit_awal_utama']?>";
    document.getElementsByName("kredit_awal_penunjang")[0].value = "<?=$detail['kredit_awal_penunjang']?>";
    document.getElementsByName("tmt_jabatan")[0].value = "<?=$detail['tmt_jabatan']?>";
    document.getElementsByName("tgl_lulus")[0].value = "<?=$detail['tgl_lulus']?>";
  </script>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
  <script>
    var tgl_lulus = new Pikaday({
      field: document.getElementsByName('tgl_lulus')[0],
      format: 'YYYY-MM-DD',
    });
    var tgl_lahir = new Pikaday({
      field: document.getElementsByName('tgl_lahir')[0],
      format: 'YYYY-MM-DD',
      minDate: new Date('1940-01-01')
    });
    var tmt_jabatan = new Pikaday({
      field: document.getElementsByName('tmt_jabatan')[0],
      format: 'YYYY-MM-DD',
    });
  </script>
</div>
</body>
</html>
