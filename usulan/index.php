<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require("../pengaturan/medoo.php");
  use Medoo\Medoo;
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Daftar Usulan";
  $sql = "SELECT * FROM tbl_usulan WHERE 1";
  $where = [];
  if($_SESSION['jenis_posisi'] == 'Tenaga Kependidikan')
  {
    $sql .= " AND nip = :nip";
    $where = ['nip' => $_SESSION['nip']];
  }
  else if($_SESSION['jenis_posisi'] == 'Staff Kepegawaian')
  {
    $sql .= " AND status_proses <> ''";
  }
  else if($_SESSION['jenis_posisi'] == 'Tim Penilai')
  {
    $sql .= " AND status_proses IN ('Sedang Proses Verifikasi Oleh Tim Penilai', 'Angka Kredit Diterima', 'Angka Kredit Ditolak')";
  }
  $data = $db->query($sql, $where)->fetchAll(PDO::FETCH_ASSOC);
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
          <h3 class="box-title">Daftar Usulan</h3>
        </div>
        <div class="box-body table-responsive ">
          <div class="table-responsive" style="overflow-x: visible; overflow-y:visible;">
	        <div style="overflow:auto; min-height:500px; margin:0px 0 0px 0;" >
            <table id="tabel" class="table table-bordered" style="height: 500px;" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tgl Usulan</th>
                  <th>Kode Usulan</th>
                  <th>Masa Penilaian</th>
                  <th>Status</th>
                  <th>Keterangan</th>
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
                  <td><?=$no?></td>
                  <td><?=tanggal_indo($d['tgl_usulan'])?></td>
                  <td><?=$d['id_usulan']?></td>
                  <td><?=tanggal_indo($d['masa_penilaian_awal'])." - ".tanggal_indo($d['masa_penilaian_akhir'])?></td>
                  <td><?=$d['status_proses']?></td>
                  <td><?=$d['keterangan']?></td>
                  <td>
                    <?php if($_SESSION['jenis_posisi'] == "Atasan"): ?>
                      <?php if($d['status_proses'] == 'Sedang Proses Verifikasi Oleh Pejabat Pengusul' || $d['status_proses'] == 'Verifikasi Gagal Oleh Pejabat Pengusul'): ?>
                        <a href="<?=$alamat_web?>/usulan/verifikasi-data.php?id_usulan=<?=$d['id_usulan']?>" class="btn btn-flat btn-primary">Cek Data Usulan</a>
                      <?php endif; ?>
                    <?php elseif($_SESSION['jenis_posisi'] == "Tenaga Kependidikan"): ?>
                      <?php if($d['status_proses'] == ''): ?>
                        <a href="<?=$alamat_web?>/usulan/kirim-data.php?id_usulan=<?=$d['id_usulan']?>&jenis_usulan=verifikasi" class="btn btn-flat btn-sm btn-success">Kirim Data</a>
                      <?php endif; ?>
                    <?php elseif($_SESSION['jenis_posisi'] == "Staff Kepegawaian"): ?>
                      <?php if($d['status_proses'] == 'Sedang Proses Verifikasi Oleh Staff Kepegawaian' || $d['status_proses'] == 'Verifikasi Gagal Oleh Staff Kepegawaian'): ?>
                        <a href="<?=$alamat_web?>/usulan/verifikasi-data.php?id_usulan=<?=$d['id_usulan']?>" class="btn btn-flat btn-primary ">Verifikasi Angka Kredit</a>
                      <?php endif; ?>
                    <?php elseif($_SESSION['jenis_posisi'] == "Tim Penilai"): ?>
                      <?php if($d['status_proses'] == 'Sedang Proses Verifikasi Oleh Tim Penilai' || $d['status_proses'] == 'Angka Kredit Ditolak'): ?>
                        <a href="<?=$alamat_web?>/usulan/penilaian-data.php?id_usulan=<?=$d['id_usulan']?>" class="btn btn-flat btn-primary ">Penilaian Angka Kredit</a>
                      <?php else: ?>
                        <a href="<?=$alamat_web?>/usulan/penilaian-data.php?id_usulan=<?=$d['id_usulan']?>" class="btn btn-flat btn-primary ">Edit Penilaian Angka Kredit</a>
                      <?php endif; ?>
                    <?php endif; ?>
                    
                    <div class="dropdown">
                      <button class="btn btn-flat btn-sm btn-primary  dropdown-toggle" type="button" data-toggle="dropdown">Pilihan
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li class="dropdown-header">Data Usulan</li>
                        <li><a href="<?=$alamat_web?>/usulan/berkas?id_usulan=<?=$d['id_usulan']?>">Data Berkas</a></li>
                        <li><a href="<?=$alamat_web?>/usulan/unsur?id_usulan=<?=$d['id_usulan']?>">Data Unsur</a></li>
                        <?php if($_SESSION['atasan'] == "1"): ?>
                          <li><a href="<?=$alamat_web?>/usulan/cetak-dupak.php?id_usulan=<?=$d['id_usulan']?>&nip=<?=$d['nip']?>">Cetak DUPAK</a></li>
                          <li><a href="<?=$alamat_web?>/usulan/cetak-pengantar.php?id_usulan=<?=$d['id_usulan']?>&nip=<?=$d['nip']?>">Cetak Surat Pengantar</a></li>
                        <?php endif; ?>
                        <?php if($_SESSION['jenis_posisi'] == "Tenaga Kependidikan"): ?>
                          <li><a href="<?=$alamat_web?>/usulan/cetak-spmk.php?id_usulan=<?=$d['id_usulan']?>&nip=<?=$d['nip']?>">Cetak SPMK</a></li>
                        <?php elseif($_SESSION['jenis_posisi'] == "Tim Penilai"): ?>
                          <li><a href="<?=$alamat_web?>/usulan/cetak-pak.php?id_usulan=<?=$d['id_usulan']?>&nip=<?=$d['nip']?>">Cetak PAK</a></li>
                        <?php endif; ?>
                        <?php if($_SESSION['jenis_posisi'] == "Tenaga Kependidikan"): ?>
                          <li class="dropdown-header">Aksi</li>
                          <li><a href="<?=$alamat_web?>/usulan/proses_hapus.php?id_usulan=<?=$d['id_usulan']?>">Hapus Usulan</a></li>
                          <li><a href="<?=$alamat_web?>/usulan/edit.php?id_usulan=<?=$d['id_usulan']?>">Edit Usulan</a></li>
                        <?php endif; ?>
                      </ul>
                    </div>
                  </td>
                </tr>
            <?php 
              $no++;
              }
            }else{
            ?>
                <tr>
                  <td colspan=7 class="text-center">Tidak ada data yang ditampilkan!</td>
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
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
