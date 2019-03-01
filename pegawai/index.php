<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Daftar Pegawai";
  require("../pengaturan/medoo.php");
  $data= $db->query("SELECT a.*,
                             c.nm_jabatan,
                             d.nm_pangkat,
                             e.nm_unit_kerja,
                             f.nm_posisi 
                      FROM   tbl_pegawai a
                             LEFT JOIN tbl_jabatan_pangkat b
                                    ON a.id_jabatan_pangkat = b.id_jabatan_pangkat
                             LEFT JOIN tbl_jabatan c
                                    ON b.id_jabatan = c.id_jabatan
                             LEFT JOIN tbl_pangkat d
                                    ON b.id_pangkat = d.id_pangkat 
                      JOIN tbl_unit_kerja e ON a.id_unit_kerja = e.id_unit_kerja 
                      JOIN tbl_posisi f ON e.id_posisi = f.id_posisi")->fetchAll(PDO::FETCH_ASSOC); 
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
            <h3 class="box-title">Daftar Pegawai Aplikasi</h3>
          </div>
          <div class="box-body table-responsive ">
            <a href="<?=$alamat_web?>/pegawai/tambah.php" class="btn btn-success">Tambah Data</a>
            <div class="table-responsive" style="overflow-x: visible; overflow-y:visible;">
	        <div style="overflow:auto; min-height:500px; margin:0px 0 0px 0;" >
            <table id="tabel" class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Foto</th>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>NOHP</th>
                  <th>Email</th>
                  <th>Jabatan</th>
                  <th>Posisi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
$no = 1;
if(count($data) > 0){
  foreach($data as $d){
?>
                <tr>
                  <td>
                    <?=$no?>
                  </td>
                  <td>
                    <?php if(empty($d['foto'])): ?>
                      Foto tidak tersedia.
                    <?php else: ?>
                      <img src="<?=$alamat_web."/assets/img/foto/".$d['foto']?>" width="100" height="200" />
                    <?php endif; ?>
                  </td>
                  <td>
                    <?=$d['nip']?>
                  </td>
                  <td>
                    <?=$d['nm_lengkap']?>
                  </td>
                  <td>
                    <?=$d['jk']?>
                  </td>
                  <td>
                    <?=$d['nohp']?>
                  </td>
                  <td>
                    <?=$d['email']?>
                  </td>
                  <td>
                    <?=$d['nm_jabatan']." ".$d['nm_pangkat']?>
                  </td>
                  <td>
                    <?=$d['nm_posisi']." - ".$d['nm_unit_kerja']?>
                  </td>
                  <td>
                    <a href="<?=$alamat_web?>/pegawai/proses_hapus.php?id_pegawai=<?=$d['id_pegawai']?>" class="btn btn-danger">Hapus</a>
                    <a href="<?=$alamat_web?>/pegawai/edit.php?id_pegawai=<?=$d['id_pegawai']?>" class="btn btn-primary">Edit</a></td>
                </tr>
                <?php 
  $no++;
  }
}else{
?>
                <tr>
                  <td colspan=10 class="text-center">Tidak ada data yang ditampilkan!</td>
                </tr>
                <?php
}
?>
              </tbody>
            </table>
          </div>
          </div>
          </div>
        </div>
      </section>
    </div>
    <?php include("../template/footer.php"); ?>
  </div>
  <?php include("../template/script.php"); ?>
</body>
</html>
