<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  use Dompdf\Dompdf;
  $sql_unsur = "SELECT 
                    a.tgl_mulai_kegiatan,
                    a.tgl_selesai_kegiatan,
                    a.satuan,
                    a.angka_kredit_murni,
                    a.angka_kredit_murni_baru,
                    a.angka_kredit_persentase,
                    a.angka_kredit_persentase_baru,
                    a.angka_kredit,
                    a.angka_kredit_baru,
                    a.tempat,
                    a.tingkat_kesulitan,
                    a.jumlah_volume_kegiatan,
                    a.bukti_kegiatan,
                    a.id_butir,
                    b.nip,
                    e.nm_unsur,
                    b.id_usulan,
                    e.id_unsur,
                    e.kategori  
                    FROM tbl_usulan_unsur a 
                    JOIN tbl_usulan b ON a.id_usulan = b.id_usulan 
                    JOIN tbl_butir_kegiatan c ON a.id_butir = c.id_butir 
                    JOIN tbl_sub_unsur d ON c.id_sub_unsur = d.id_sub_unsur 
                    JOIN tbl_unsur e ON d.id_unsur = e.id_unsur WHERE b.id_usulan = :id_usulan GROUP BY e.id_unsur ORDER BY e.kategori";
  $sql_butir_kegiatan = "SELECT 
                    a.tgl_mulai_kegiatan,
                    a.tgl_selesai_kegiatan,
                    a.satuan,
                    a.angka_kredit_murni,
                    a.angka_kredit_murni_baru,
                    a.angka_kredit_persentase,
                    a.angka_kredit_persentase_baru,
                    a.angka_kredit,
                    a.angka_kredit_baru,
                    a.tempat,
                    a.tingkat_kesulitan,
                    a.jumlah_volume_kegiatan,
                    a.bukti_kegiatan,
                    a.id_butir,
                    b.nip,
                    c.butir_kegiatan 
                    FROM tbl_usulan_unsur a 
                    JOIN tbl_usulan b ON a.id_usulan = b.id_usulan 
                    JOIN tbl_butir_kegiatan c ON a.id_butir = c.id_butir 
                    JOIN tbl_sub_unsur d ON c.id_sub_unsur = d.id_sub_unsur 
                    JOIN tbl_unsur e ON d.id_unsur = e.id_unsur WHERE e.id_unsur = :id_unsur AND b.id_usulan = :id_usulan";
  
  $data_usulan = $db->query($sql_unsur, ["id_usulan" => $_GET['id_usulan']])->fetchAll();
  $pegawai = $db->query("SELECT 
                                  a.*,
                                  b.*,
                                  c.*,
                                  d.*,
                                  e.nm_unit_kerja
                          FROM   tbl_pegawai a
                                 LEFT JOIN tbl_pangkat b
                                        ON a.id_pangkat = b.id_pangkat
                                 LEFT JOIN tbl_jabatan c
                                        ON b.id_jabatan = c.id_jabatan
                                 LEFT JOIN tbl_posisi d
                                        ON a.id_posisi = d.id_posisi 
                          LEFT JOIN tbl_unit_kerja e ON a.id_unit_kerja = e.id_unit_kerja WHERE a.nip = :nip", ['nip' => $_GET['nip']])->fetch();
                          
  $atasan = $db->query("SELECT 
                                  a.*,
                                  b.*,
                                  c.*,
                                  d.*,
                                  e.nm_unit_kerja 
                          FROM   tbl_pegawai a
                                 LEFT JOIN tbl_pangkat b
                                        ON a.id_pangkat = b.id_pangkat
                                 LEFT JOIN tbl_jabatan c
                                        ON b.id_jabatan = c.id_jabatan
                                 LEFT JOIN tbl_posisi d
                                        ON a.id_posisi = d.id_posisi 
                          LEFT JOIN tbl_unit_kerja e ON a.id_unit_kerja = e.id_unit_kerja WHERE a.nip = :nip", ['nip' => $_GET['nip_atasan']])->fetch();
                                    
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
      BIROKRASI REPUBLIK INDONESIA 
      <?php if($_SESSION['nm_posisi'] == 'Pustakawan'): ?>
        NOMOR 9 TAHUN 2014 <br/>
        TENTANG JABATAN FUNGSIONAL PUSTAKAWAN DAN <br/>
        ANGKA KREDITNYA
      <?php elseif($_SESSION['nm_posisi'] == 'Arsiparis'): ?>
        NOMOR 3 TAHUN 2009  <br/>
        TENTANG JABATAN FUNGSIONAL
        ARSIPARIS DAN <br/> ANGKA KREDITNYA
      <?php elseif($_SESSION['nm_posisi'] == 'Pranata Laboratorium Pendidikan'): ?>
        NOMOR 03 TAHUN 2010 <br/>
        TENTANG JABATAN FUNGSIONAL
        PRANATA LABORATORIUM PENDIDIKAN DAN <br/> ANGKA KREDITNYA
      <?php endif; ?>
      
    </p>
    <div style="clear: both;"></div>
  </div>
  <div style="text-align: center; font-size: 15pt;">SURAT PERNYATAAN <br/> TELAH MELAKUKAN KEGIATAN <?=$d['kategori'] == "Unsur Penunjang" ? "PENUNJANG " : ""?><?=strtoupper($d['nm_unsur'])?></div>
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
          <td><?=$pegawai['nm_pangkat']."/".tanggal_indo($pegawai['tmt_jabatan'])?></td>
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
      $detail_usulan = $db->query($sql_butir_kegiatan, ["id_usulan" => $d['id_usulan'], "id_unsur" => $d['id_unsur']])->fetchAll();
      foreach($detail_usulan as $i=>$u):
  ?>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=($i+1)?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['butir_kegiatan']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=tanggal_indo($u['tgl_mulai_kegiatan'])." - ".tanggal_indo($u['tgl_selesai_kegiatan'])?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['satuan']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['jumlah_volume_kegiatan']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=round(($u['angka_kredit_murni']*$u['angka_kredit_murni']), 4)?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=round($u['angka_kredit'], 4)?></td>
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
