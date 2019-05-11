<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require("../pengaturan/medoo.php");
  use Medoo\Medoo;
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Daftar Usulan";
  $sql = "SELECT 
            a.*,
            b.nm_lengkap,
            d.nm_posisi,
            (SELECT SUM(IFNULL(aa.angka_kredit, 0)) FROM tbl_usulan_unsur aa WHERE aa.id_usulan = a.id_usulan) AS angka_kredit_diusulkan,
            (SELECT SUM(CASE WHEN aa.angka_kredit_baru = 0 THEN aa.angka_kredit ELSE aa.angka_kredit_baru END) FROM tbl_usulan_unsur aa WHERE aa.id_usulan = a.id_usulan AND aa.status = 'Diterima') AS angka_kredit_diterima
          FROM tbl_usulan a 
          LEFT JOIN tbl_pegawai b ON a.nip = b.nip 
          LEFT JOIN tbl_unit_kerja c ON b.id_unit_kerja = c.id_unit_kerja 
          LEFT JOIN tbl_posisi d ON c.id_posisi = d.id_posisi WHERE 1";
  $where = [];
  if($_SESSION['jenis_posisi'] == 'Tenaga Kependidikan')
  {
    $sql .= " AND a.nip = :nip";
    $where = ['nip' => $_SESSION['nip']];
  }
  else if($_SESSION['jenis_posisi'] == 'Staff Kepegawaian')
  {
    $sql .= " AND a.status_proses <> ''";
  }
  else if($_SESSION['jenis_posisi'] == 'Tim Penilai')
  {
    $sql .= " AND a.status_proses IN ('Sedang Proses Verifikasi Oleh Tim Penilai', 'Angka Kredit Diterima', 'Angka Kredit Ditolak')";
  }
  $data = $db->query($sql, $where)->fetchAll(PDO::FETCH_ASSOC);
  $sql_atasan = "SELECT a.nip, a.nm_lengkap FROM tbl_pegawai a JOIN tbl_posisi b ON a.id_posisi = b.id_posisi WHERE b.id_posisi = :id_posisi AND a.is_atasan = 1";
  $atasan = $db->query($sql_atasan, ["id_posisi" => $_SESSION['id_posisi']])->fetchAll(PDO::FETCH_ASSOC);
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
                <?php if($_SESSION['jenis_posisi'] == 'Tim Penilai' || $_SESSION['jenis_posisi'] == 'Staff Kepegawaian'):?>
                  <th>Nama Pegawai</th>
                  <th>Jenis Tenaga Kependidikan</th>
                <?php endif; ?>
                  <th>Kode Usulan</th>
                  <th>Masa Penilaian</th>
                <?php if($_SESSION['jenis_posisi'] == 'Tim Penilai' || $_SESSION['jenis_posisi'] == 'Staff Kepegawaian'):?>
                  <th>Angka Kredit Diusulkan</th>
                  <th>Angka Kredit Diterima</th>
                <?php endif; ?>
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
                <?php if($_SESSION['jenis_posisi'] == 'Tim Penilai' || $_SESSION['jenis_posisi'] == 'Staff Kepegawaian'):?>
                  <td><?=$d['nm_lengkap']?></td>
                  <td><?=$d['nm_posisi']?></td>
                <?php endif; ?>
                  <td><?=$d['id_usulan']?></td>
                  <td><?=tanggal_indo($d['masa_penilaian_awal'])." - ".tanggal_indo($d['masa_penilaian_akhir'])?></td>
                <?php if($_SESSION['jenis_posisi'] == 'Tim Penilai' || $_SESSION['jenis_posisi'] == 'Staff Kepegawaian'):?>
                  <td><?=round($d['angka_kredit_diusulkan'], 2)?></td>
                  <td><?=round($d['angka_kredit_diterima'], 2)?></td>
                <?php endif; ?>
                  <td><?=$d['status_proses']?></td>
                  <td><?=$d['keterangan']?></td>
                  <td>
                    <?php if($_SESSION['is_atasan'] == 1): ?>
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
                        <?php if($_SESSION['is_atasan'] == 1 || $_SESSION['jenis_posisi'] == "Staff Kepegawaian"): ?>
                          <li><a href="#" onclick="cetakDupak(<?=$d['id_usulan']?>)">Cetak DUPAK</a></li>
                          <li><a href="<?=$alamat_web?>/usulan/cetak-pengantar.php?id_usulan=<?=$d['id_usulan']?>&nip=<?=$d['nip']?>">Cetak Surat Pengantar</a></li>
                        <?php endif; ?>
                        <?php if($_SESSION['jenis_posisi'] == "Tenaga Kependidikan"): ?>
                          <li><a href="#" onclick="cetakSpmk(<?=$d['id_usulan']?>)">Cetak SPMK</a></li>
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
  <div class="modal fade" id="cetak-spmk" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Cetak SPMK</h4>
        </div>
        <div class="modal-body">
          <form action="<?=$alamat_web?>/usulan/cetak-spmk.php">
            <input type="hidden" name="id_usulan" />
            <input type="hidden" name="nip" value="<?=$_SESSION['nip']?>" />
            <div class="form-group">
              <label>Pilih Pejabat Pengusul</label>
              <select class="form-control" name="nip_atasan">
                <?php foreach($atasan as $d): ?>
                  <option value="<?=$d['nip']?>"><?=$d['nm_lengkap']?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group text-right">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Cetak</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="cetak-dupak" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Cetak DUPAK</h4>
        </div>
        <div class="modal-body">
          <form action="<?=$alamat_web?>/usulan/cetak-dupak.php">
            <input type="hidden" name="id_usulan" />
            <input type="hidden" name="nip" value="<?=$_SESSION['nip']?>" />
            <div class="form-group">
              <label>Pilih Pejabat Pengusul</label>
              <select class="form-control" name="nip_atasan">
                <?php foreach($atasan as $d): ?>
                  <option value="<?=$d['nip']?>"><?=$d['nm_lengkap']?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group text-right">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Cetak</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
  <script>
    function cetakSpmk(id_usulan){
      document.getElementsByName("id_usulan")[0].value = id_usulan;
      $('#cetak-spmk').modal('show');
    }
    function cetakDupak(id_usulan){
      document.getElementsByName("id_usulan")[0].value = id_usulan;
      $('#cetak-dupak').modal('show');
    }
  </script>
</div>
</body>
</html>
