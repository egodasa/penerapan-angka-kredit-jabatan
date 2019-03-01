<?php
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  use Dompdf\Dompdf;
  $data_usulan = $db->query("SELECT a.id_usulan, a.id_unsur, b.nm_unsur, f.nm_posisi FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur JOIN tbl_usulan c ON a.id_usulan = c.id_usulan JOIN tbl_pegawai d ON c.nip = d.nip JOIN tbl_unit_kerja e ON d.id_unit_kerja = e.id_unit_kerja JOIN tbl_posisi f ON e.id_posisi = f.id_posisi WHERE a.id_usulan = :id_usulan AND b.jenis_unsur = 'Unsur Utama' GROUP BY a.id_unsur", ["id_usulan" => $_GET['id_usulan']])->fetchAll();
  $data_usulan_penunjang = $db->query("SELECT a.id_usulan, a.id_unsur, b.nm_unsur, f.nm_posisi FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur JOIN tbl_usulan c ON a.id_usulan = c.id_usulan JOIN tbl_pegawai d ON c.nip = d.nip JOIN tbl_unit_kerja e ON d.id_unit_kerja = e.id_unit_kerja JOIN tbl_posisi f ON e.id_posisi = f.id_posisi WHERE a.id_usulan = :id_usulan AND b.jenis_unsur = 'Unsur Penunjang' GROUP BY a.id_unsur", ["id_usulan" => $_GET['id_usulan']])->fetchAll();
  $pegawai = $db->query("SELECT e.nm_posisi,
                                   e.jenis_posisi,
                                   a.kredit_awal,
                                   a.nip,
                                   a.nm_lengkap,
                                   a.jk,
                                   a.foto,
                                   b.peringkat,
                                   c.nm_jabatan,
                                   d.nm_pangkat,
                                   a.id_unit_kerja,
                                   f.nm_unit_kerja,
                                   f.nip_atasan 
                            FROM   tbl_pegawai a
                                   JOIN tbl_jabatan_pangkat b
                                     ON a.id_jabatan_pangkat = b.id_jabatan_pangkat
                                   JOIN tbl_jabatan c
                                     ON b.id_jabatan = c.id_jabatan
                                   JOIN tbl_pangkat d
                                     ON b.id_pangkat = d.id_pangkat
                                   JOIN tbl_unit_kerja f
                                     ON a.id_unit_kerja = f.id_unit_kerja
                                   JOIN tbl_posisi e
                                     ON f.id_posisi = e.id_posisi WHERE a.nip = :nip", ['nip' => $_GET['nip']])->fetch();
  $atasan = $db->query("SELECT e.nm_posisi,
                                   e.jenis_posisi,
                                   a.kredit_awal,
                                   a.nip,
                                   a.nm_lengkap,
                                   a.jk,
                                   a.foto,
                                   b.peringkat,
                                   c.nm_jabatan,
                                   d.nm_pangkat,
                                   a.id_unit_kerja,
                                   f.nm_unit_kerja
                            FROM   tbl_pegawai a
                                   JOIN tbl_jabatan_pangkat b
                                     ON a.id_jabatan_pangkat = b.id_jabatan_pangkat
                                   JOIN tbl_jabatan c
                                     ON b.id_jabatan = c.id_jabatan
                                   JOIN tbl_pangkat d
                                     ON b.id_pangkat = d.id_pangkat
                                   JOIN tbl_unit_kerja f
                                     ON a.id_unit_kerja = f.id_unit_kerja
                                   JOIN tbl_posisi e
                                     ON f.id_posisi = e.id_posisi WHERE a.nip = :nip", ['nip' => $pegawai['nip_atasan']])->fetch();
  $start_huruf = 13;
  ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SURAT PERNYATAAN MELAKUKAN KEGIATAN</title>
  <style>
    body{
      font-size: 9pt;
    }
    .kiri{
      width:100px;
      display:inline-block;
    }
    .kanan{
      min-width:200px;
      display:inline-block;
    }
    .tabel_rapi {
      padding: 5px 20px;
      width: 100%;
    }
    .tabel_rapi td {
      vertical-align: top;
    }
    .rata_kk, ol {
      text-align: justify;
      font-size: 12pt;
    }
    ol li{
      padding-bottom: 10px;
    }
    table.tabel_garis {
        padding: 5px 20px;
        width: 100%;
        border-collapse: collapse;
      }
    th.isi_tabel_bergaris, td.isi_tabel_bergaris {
      border: 1px solid black;
    }
  </style>
</head>
<body>
  <?php 
    foreach($data_usulan as $d):
  ?>
  <div style="width: 100%;">
    <p style="width: 50%; float: right;font-weight: bold;">
      ANAK LAMPIRAN 1-<?=strtolower(angkaHuruf($start_huruf))?> <br/>
      PERATURAN BERSAMA <br/>
      KEPALA PERPUSTAKAAN NASIONAL REPUBLIK INDONESIA <br/>
      DAN KEPALA BADAN KEPEGAWAIAN NEGARA<br/>
      TENTANG<br/>
      KETENTUAN PELAKSANAAN PERATURAN MENTERI <br/>
      PENDAYAGUNAAN APARATUR NEGARA DAN REFORMASI<br/>
      BIROKRASI REPUBLIK INDONESIA NOMOR 9 TAHUN 2014 <br/>
      TENTANG JABATAN FUNGSIONAL <?=strtoupper($d['nm_posisi'])?> DAN <br/>
      ANGKA KREDITNYA
    </p>
    <div style="clear: both;"></div>
  </div>
  <div style="text-align: center; font-size: 15pt;">SURAT PERNYATAAN <br/> TELAH MELAKUKAN <?=strtoupper($d['nm_unsur'])?></div>
  <p class="rata_kk">Yang bertanda tangan di bawah ini:</p>
  <table class="tabel_rapi" style="padding-left: 1.1cm">
        <tr>
          <td style="width: 40%;">Nama</td>
          <td style="width: 1%;">:</td>
          <td style="width: 59%;"><?=$atasan['nm_lengkap']?></td>
        </tr>
        <tr>
          <td>NIP</td>
          <td>:</td>
          <td><?=$atasan['nip']?></td>
        </tr>
        <tr>
          <td>Pangkat/golongan ruang</td>
          <td>:</td>
          <td><?=$atasan['nm_pangkat']?></td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>:</td>
          <td><?=$atasan['nm_jabatan']?></td>
        </tr>
        <tr>
          <td>Unit Kerja</td>
          <td>:</td>
          <td><?=$atasan['nm_unit_kerja']?></td>
        </tr>
    </table>
    
  <p class="rata_kk">Menyatakan bahwa:</p>
  <table class="tabel_rapi" style="padding-left: 1.1cm">
        <tr>
          <td style="width: 40%;">Nama</td>
          <td style="width: 1%;">:</td>
          <td style="width: 59%;"><?=$pegawai['nm_lengkap']?></td>
        </tr>
        <tr>
          <td>NIP</td>
          <td>:</td>
          <td><?=$pegawai['nip']?></td>
        </tr>
        <tr>
          <td>Pangkat/golongan ruang/TMT</td>
          <td>:</td>
          <td><?=$pegawai['nm_pangkat']."/".$pegawai['tmt_jabatan']?></td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>:</td>
          <td><?=$pegawai['nm_jabatan']?></td>
        </tr>
        <tr>
          <td>Unit Kerja</td>
          <td>:</td>
          <td><?=$pegawai['nm_unit_kerja']?></td>
        </tr>
    </table>
    <p class="rata_kk">Telah mengikuti kegiatan <?=$d['nm_unsur']?> sebagai berikut: </p>
    <table class="tabel_garis" style="margin: -5px -20px;">
      <tr>
        <th class="isi_tabel_bergaris" style="text-align: center;">No</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">Uraian <br/> Kegiatan</th>
        <th class="isi_tabel_bergaris"  style="text-align: center;">Tanggal</th>
        <th class="isi_tabel_bergaris"  style="text-align: center;">Satuan <br/> Hasil</th>
        <th class="isi_tabel_bergaris"  style="text-align: center;">Jumlah Volume <br/> Kegiatan</th>
        <th class="isi_tabel_bergaris"  style="text-align: center;">Angka <br/> Kredit</th>
        <th class="isi_tabel_bergaris"  style="text-align: center;">Jumlah Angka <br/> Kredit</th>
        <th class="isi_tabel_bergaris"  style="text-align: center;">Keterangan/ <br/> bukti fisik</th>
      </tr>
      <tr>
        <th class="isi_tabel_bergaris" style="text-align: center;">1</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">2</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">3</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">4</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">5</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">6</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">7</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">8</th>
      </tr>
  <?php
      $detail_usulan = $db->query("SELECT a.*, b.nm_unsur, b.jenis_unsur FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE a.id_usulan = :id_usulan AND a.id_unsur = :id_unsur ORDER BY b.jenis_unsur, b.nm_unsur ASC", ["id_usulan" => $d['id_usulan'], "id_unsur" => $d['id_unsur']])->fetchAll();
      foreach($detail_usulan as $i=>$u):
  ?>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=($i+1)?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['butir_kegiatan']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=tanggal_indo($u['tgl_mulai_kegiatan'])." - ".tanggal_indo($u['tgl_selesai_kegiatan'])?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['satuan']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['jumlah_volume_kegiatan']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=($u['angka_kredit_murni']*$u['angka_kredit_murni'])?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['angka_kredit']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;">
          <?php
            if($u['bukti_kegiatan'] != '')
            {
              echo "Tidak Terlampir";
            }
            else
            {
              echo "Terlampir";
            }
          ?>
        </td>
      </tr>
  <?php
      $start_huruf++;
      endforeach;
  ?>
    </table>
    <p class="rata_kk">Demikian pernyataan ini dibuat untuk dapat dipergunakan sebagaimana mestinya</p>
      <div style="width: 300px; text-align: center;float: right;">
        Padang, <?=tanggal_indo(date("Y-m-d"))?> <br/>
        <b><?=strtoupper($atasan['nm_lengkap'])?></b>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        NIP <?=$atasan['nip']?>
      </div>
      <div style="clear: both;"></div>
      <div style="page-break-before: always;"></div>
  <?php
    endforeach;
  ?>
  
  
  <?php
    // BAGIAN KEGIATAN PENUNJANG
    if(count($data_usulan_penunjang) != 0 ):
  ?>
  <div style="width: 100%;">
    <p style="width: 50%; float: right;font-weight: bold;">
      ANAK LAMPIRAN 1-<?=strtolower(angkaHuruf($start_huruf))?> <br/>
      PERATURAN BERSAMA <br/>
      KEPALA PERPUSTAKAAN NASIONAL REPUBLIK INDONESIA <br/>
      DAN KEPALA BADAN KEPEGAWAIAN NEGARA<br/>
      TENTANG<br/>
      KETENTUAN PELAKSANAAN PERATURAN MENTERI <br/>
      PENDAYAGUNAAN APARATUR NEGARA DAN REFORMASI<br/>
      BIROKRASI REPUBLIK INDONESIA NOMOR 9 TAHUN 2014 <br/>
      TENTANG JABATAN FUNGSIONAL <?=strtoupper($d['nm_posisi'])?> DAN <br/>
      ANGKA KREDITNYA
    </p>
    <div style="clear: both;"></div>
  </div>
  <div style="text-align: center; font-size: 15pt;">SURAT PERNYATAAN <br/> TELAH MELAKUKAN KEGIATAN PENUNJANG <?=strtoupper($d['nm_posisi'])?></div>
  <p class="rata_kk">Yang bertanda tangan di bawah ini:</p>
  <table class="tabel_rapi" style="padding-left: 1.1cm">
        <tr>
          <td style="width: 40%;">Nama</td>
          <td style="width: 1%;">:</td>
          <td style="width: 59%;"><?=$atasan['nm_lengkap']?></td>
        </tr>
        <tr>
          <td>NIP</td>
          <td>:</td>
          <td><?=$atasan['nip']?></td>
        </tr>
        <tr>
          <td>Pangkat/golongan ruang</td>
          <td>:</td>
          <td><?=$atasan['nm_pangkat']?></td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>:</td>
          <td><?=$atasan['nm_jabatan']?></td>
        </tr>
        <tr>
          <td>Unit Kerja</td>
          <td>:</td>
          <td><?=$atasan['nm_unit_kerja']?></td>
        </tr>
    </table>
    
  <p class="rata_kk">Menyatakan bahwa:</p>
  <table class="tabel_rapi" style="padding-left: 1.1cm">
        <tr>
          <td style="width: 40%;">Nama</td>
          <td style="width: 1%;">:</td>
          <td style="width: 59%;"><?=$pegawai['nm_lengkap']?></td>
        </tr>
        <tr>
          <td>NIP</td>
          <td>:</td>
          <td><?=$pegawai['nip']?></td>
        </tr>
        <tr>
          <td>Pangkat/golongan ruang/TMT</td>
          <td>:</td>
          <td><?=$pegawai['nm_pangkat']."/".$pegawai['tmt_jabatan']?></td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>:</td>
          <td><?=$pegawai['nm_jabatan']?></td>
        </tr>
        <tr>
          <td>Unit Kerja</td>
          <td>:</td>
          <td><?=$pegawai['nm_unit_kerja']?></td>
        </tr>
    </table>
    <p class="rata_kk">Telah melakukan kegiatan penunjang tugas <?=strtolower($d['nm_posisi'])?> sebagai berikut :</p>
    <table class="tabel_garis" style="margin: -5px -20px;">
      <tr>
        <th class="isi_tabel_bergaris" style="text-align: center;">No</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">Uraian <br/> Kegiatan</th>
        <th class="isi_tabel_bergaris"  style="text-align: center;">Tanggal</th>
        <th class="isi_tabel_bergaris"  style="text-align: center;">Satuan <br/> Hasil</th>
        <th class="isi_tabel_bergaris"  style="text-align: center;">Jumlah Volume <br/> Kegiatan</th>
        <th class="isi_tabel_bergaris"  style="text-align: center;">Angka <br/> Kredit</th>
        <th class="isi_tabel_bergaris"  style="text-align: center;">Jumlah Angka <br/> Kredit</th>
        <th class="isi_tabel_bergaris"  style="text-align: center;">Keterangan/ <br/> bukti fisik</th>
      </tr>
      <tr>
        <th class="isi_tabel_bergaris" style="text-align: center;">1</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">2</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">3</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">4</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">5</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">6</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">7</th>
        <th class="isi_tabel_bergaris" style="text-align: center;">8</th>
      </tr>
  <?php
      $detail_usulan = $db->query("SELECT a.*, b.nm_unsur, b.jenis_unsur FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE a.id_usulan = :id_usulan AND b.jenis_unsur = 'Unsur Penunjang' ORDER BY b.jenis_unsur, b.nm_unsur ASC", ["id_usulan" => $d['id_usulan']])->fetchAll();
      foreach($detail_usulan as $i=>$u):
  ?>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=($i+1)?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['butir_kegiatan']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=tanggal_indo($u['tgl_mulai_kegiatan'])." - ".tanggal_indo($u['tgl_selesai_kegiatan'])?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['satuan']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['jumlah_volume_kegiatan']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=($u['angka_kredit_murni']*$u['angka_kredit_murni'])?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['angka_kredit']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;">
          <?php
            if($u['bukti_kegiatan'] != '')
            {
              echo "Tidak Terlampir";
            }
            else
            {
              echo "Terlampir";
            }
          ?>
        </td>
      </tr>
  <?php
      $start_huruf++;
      endforeach;
  ?>
    </table>
    <p class="rata_kk">Demikian pernyataan ini dibuat untuk dapat dipergunakan sebagaimana mestinya</p>
      <div style="width: 300px; text-align: center;float: right;">
        Padang, <?=tanggal_indo(date("Y-m-d"))?> <br/>
        <b><?=strtoupper($atasan['nm_lengkap'])?></b>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        NIP <?=$atasan['nip']?>
      </div>
      <div style="clear: both;"></div>
      <div style="page-break-before: always;"></div>
  <?php
    endif;
  ?>
</body>
</html>
<?php
$content = ob_get_clean();
// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($content);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

$dompdf->stream("surat-pernyataan-melakukan-kegiatan.pdf", array("Attachment" => false));
exit(0);

?>
