<?php
  session_start();
  require_once "../vendor/autoload.php";
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  use Dompdf\Dompdf;
  
  $data_usulan = $db->query("SELECT a.* FROM tbl_usulan a WHERE id_usulan = :id_usulan", ["id_usulan" => $_GET['id_usulan']])->fetch();
  $data_pangkat_sekarang = $db->query("SELECT a.*, b.nm_pangkat, c.nm_jabatan FROM tbl_jabatan_pangkat a JOIN tbl_pangkat b ON a.id_pangkat = b.id_pangkat JOIN tbl_jabatan c ON a.id_jabatan = c.id_jabatan WHERE a.id_jabatan_pangkat = :id", ['id' => $data_usulan['id_jabatan_pangkat_sekarang']])->fetch();
  $data_pangkat_selanjutnya = $db->query("SELECT a.*, b.nm_pangkat, c.nm_jabatan FROM tbl_jabatan_pangkat a JOIN tbl_pangkat b ON a.id_pangkat = b.id_pangkat JOIN tbl_jabatan c ON a.id_jabatan = c.id_jabatan WHERE a.id_jabatan_pangkat = :id", ['id' => $data_usulan['id_jabatan_pangkat_selanjutnya']])->fetch();
  
  $data_kegiatan_utama = $db->query("SELECT a.*, b.* FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE a.id_usulan = :id_usulan AND b.jenis_unsur = 'Unsur Utama' ORDER BY b.jenis_unsur", ['id_usulan' => $_GET['id_usulan']])->fetchAll();
  $data_kegiatan_penunjang = $db->query("SELECT a.*, b.* FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE a.id_usulan = :id_usulan AND b.jenis_unsur = 'Unsur Penunjang' ORDER BY b.jenis_unsur", ['id_usulan' => $_GET['id_usulan']])->fetchAll();
  $pegawai = $db->query("SELECT e.nm_posisi, a.*,
                                   e.jenis_posisi,
                                   b.peringkat,
                                   c.nm_jabatan,
                                   d.nm_pangkat,
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
  ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SURAT PENETAPAN ANGKA KREDIT</title>
  <style>
    body {
      font-family: Arial, Helvetica;
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
        width: 100%;
        border-collapse: collapse;
      }
    th.isi_tabel_bergaris, td.isi_tabel_bergaris {
      border: 1px solid black;
      padding: 3px;
    }
  </style>
</head>
<body>
  <div style="width: 100%;">
    <div style="width: 70%; float: right;font-weight: bold;">
      <div style="width: 30%;float: left;">
        Lampiran VIII :  
      </div>
      <div style="width: 70%;float: right;">
        Keputusan Bersama Kepala Perpustakaan Nasional <br/>
        Dan Kepala Badan Administrasi Kepegawaian Negara <br/>
        <table style="width: 100%;">
          <tr>
            <td style="text-align: left;">NOMOR</td>
            <td>:</td>
            <td style="text-align: left;">23 Tahun 2003</td>
          </tr>
          <tr>
            <td style="text-align: left;">NOMOR</td>
            <td>:</td>
            <td style="text-align: left;">21 Tahun 2003</td>
          </tr>
          <tr>
            <td style="text-align: left;">TANGGAL</td>
            <td>:</td>
            <td style="text-align: left;">13 Juni 2003</td>
          </tr>
        </table>
      </div>
      <div style="clear: both;"></div>
    </div>
  </div>
  <div style="clear: both;"></div>
  <br/>
  <br/>
  <div style="font-weight: bold;text-align: center;">
    <u>PENETAPAN ANGKA KREDIT</u> <br/> 
  </div>
  <div style="text-align: center;">
    NOMOR: <?=$data_usulan['id_usulan']?> /UN16.WR1/KP/Unand-<?=date("Y")?> <br/> <br/> MASA PENILAIAN : <?=tanggal_indo($data_usulan['masa_penilaian_awal'])." s.d ".tanggal_indo($data_usulan['masa_penilaian_akhir'])?>
  </div>
  <div style="text-align: left;">INSTANSI: Universitas Andalas</div>
  <div style="width: 100%;">
    <div style="clear: both;"></div>
    <table class="tabel_garis">
      <tr>
        <th class="isi_tabel_bergaris" style="text-align: center;">I</th>
        <th colspan="9" class="isi_tabel_bergaris" style="text-align: center;">KETERANGAN PERORANGAN</th>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;"> </td>
        <td class="isi_tabel_bergaris" style="width: 20px;text-align: center;">1</td>
        <td class="isi_tabel_bergaris" colspan="2">NAMA</td>
        <td class="isi_tabel_bergaris" colspan="6"><?=$pegawai['nm_lengkap']?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;"></td>
        <td class="isi_tabel_bergaris" style="width: 20px;text-align: center;">2</td>
        <td class="isi_tabel_bergaris" colspan="2">NIP</td>
        <td class="isi_tabel_bergaris" colspan="6"><?=$pegawai['nip']?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;"></td>
        <td class="isi_tabel_bergaris" style="width: 20px;text-align: center;">3</td>
        <td class="isi_tabel_bergaris" colspan="2">Nomor Seri KARPEG</td>
        <td class="isi_tabel_bergaris" colspan="6"><?=$pegawai['no_karpeg']?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;"></td>
        <td class="isi_tabel_bergaris" style="width: 20px;text-align: center;">4</td>
        <td class="isi_tabel_bergaris" colspan="2">Tempat dan Tanggal Lahir</td>
        <td class="isi_tabel_bergaris" colspan="6"><?=$pegawai['tempat_lahir'].", ".tanggal_indo($pegawai['tgl_lahir'])?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;"></td>
        <td class="isi_tabel_bergaris" style="width: 20px;text-align: center;">5</td>
        <td class="isi_tabel_bergaris" colspan="2">Jenis Kelamin</td>
        <td class="isi_tabel_bergaris" colspan="6"><?=$pegawai['jk']?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;"></td>
        <td class="isi_tabel_bergaris" style="width: 20px;text-align: center;">6</td>
        <td class="isi_tabel_bergaris" colspan="2">Pendidikan yang telah diperhitungkan Angka Kreditnya/A.K</td>
        <td class="isi_tabel_bergaris" colspan="6"><?=$pegawai['pendidikan']?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;"></td>
        <td class="isi_tabel_bergaris" style="width: 20px;text-align: center;">7</td>
        <td class="isi_tabel_bergaris" colspan="2">Pangkat/Gol. Ruang/T.M.T</td>
        <td class="isi_tabel_bergaris" colspan="6"><?=$pegawai['nm_pangkat']." / ".tanggal_indo($pegawai['tmt_jabatan'])?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;"></td>
        <td class="isi_tabel_bergaris" style="width: 20px;text-align: center;">8</td>
        <td class="isi_tabel_bergaris" colspan="2">Jabatan</td>
        <td class="isi_tabel_bergaris" colspan="6"><?=$pegawai['nm_jabatan']?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;" rowspan="2"></td>
        <td class="isi_tabel_bergaris" style="width: 20px;text-align: center;" rowspan="2">9</td>
        <td class="isi_tabel_bergaris" colspan="2" rowspan="2">Masa Kerja Golongan</td>
        <td class="isi_tabel_bergaris" colspan="2">Lama</td>
        <td class="isi_tabel_bergaris" colspan="4"><?=$data_usulan['masa_kerja_golongan_lama']?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" colspan="2">Baru</td>
        <td class="isi_tabel_bergaris" colspan="4"><?=$data_usulan['masa_kerja_golongan_baru']?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;"></td>
        <td class="isi_tabel_bergaris" style="width: 20px;text-align: center;">10</td>
        <td class="isi_tabel_bergaris" colspan="2">Unit Kerja</td>
        <td class="isi_tabel_bergaris" colspan="6"><?=$pegawai['nm_unit_kerja']?></td>
      </tr>
      <tr>
        <th class="isi_tabel_bergaris" style="text-align: center;">II</th>
        <th class="isi_tabel_bergaris" style="text-align: center;"> </th>
        <th colspan="2" class="isi_tabel_bergaris" style="text-align: left;">PENETAPAN ANGKA KREDIT</th>
        <th colspan="2" class="isi_tabel_bergaris" style="text-align: center;width: 100px;">LAMA</th>
        <th colspan="2" class="isi_tabel_bergaris" style="text-align: center;width: 100px;">BARU</th>
        <th colspan="2" class="isi_tabel_bergaris" style="text-align: center;width: 100px;">JUMLAH</th>
      </tr>
      <tr>
        <th class="isi_tabel_bergaris" style="text-align: center;"> </th>
        <th class="isi_tabel_bergaris" style="text-align: center;">I</th>
        <th colspan="2" class="isi_tabel_bergaris" style="text-align: left;">UNSUR UTAMA</th>
        <th colspan="2" class="isi_tabel_bergaris" style="text-align: center;"> </th>
        <th colspan="2" class="isi_tabel_bergaris" style="text-align: center;"> </th>
        <th colspan="2" class="isi_tabel_bergaris" style="text-align: center;"> </th>
      </tr>
      <?php
        $angka_kredit = 0;
        $angka_kredit_baru = 0;
        foreach($data_kegiatan_utama as $i=>$d):
        $angka_kredit += $d['angka_kredit'];
        $angka_kredit_baru += $d['angka_kredit_baru'];
      ?>
        <tr>
          <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
          <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
          <td class="isi_tabel_bergaris" style="text-align: left;width: 5px;"><?=angkaHuruf($i)?></td>
          <td class="isi_tabel_bergaris" style="text-align: left;"><?=$d['butir_kegiatan']?></td>
          <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=$d['angka_kredit']?></td>
          <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=$d['angka_kredit_baru']?></td>
          <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=($d['angka_kredit']+$d['angka_kredit_baru'])?></td>
        </tr>
      <?php endforeach; ?>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: left;width: 5px;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: left;">Jumlah Unsur Utama</td>
        <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=$angka_kredit?></td>
        <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=$angka_kredit_baru?></td>
        <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=($angka_kredit+$angka_kredit_baru)?></td>
      </tr>
      <tr>
        <th class="isi_tabel_bergaris" style="text-align: center;"> </th>
        <th class="isi_tabel_bergaris" style="text-align: center;">II</th>
        <th colspan="2" class="isi_tabel_bergaris" style="text-align: left;">UNSUR PENUNJANG</th>
        <th colspan="2" class="isi_tabel_bergaris" style="text-align: center;"> </th>
        <th colspan="2" class="isi_tabel_bergaris" style="text-align: center;"> </th>
        <th colspan="2" class="isi_tabel_bergaris" style="text-align: center;"> </th>
      </tr>
      <?php
        $angka_kredit_penjunjang = 0;
        $angka_kredit_penjunjang_baru = 0;
        foreach($data_kegiatan_penunjang as $i=>$d):
        $angka_kredit_penjunjang += $d['angka_kredit'];
        $angka_kredit_penjunjang_baru += $d['angka_kredit_baru'];
      ?>
        <tr>
          <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
          <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
          <td class="isi_tabel_bergaris" style="text-align: left;width: 5px;"><?=angkaHuruf($i)?></td>
          <td class="isi_tabel_bergaris" style="text-align: left;"><?=$d['butir_kegiatan']?></td>
          <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=$d['angka_kredit']?></td>
          <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=$d['angka_kredit_baru']?></td>
          <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=($d['angka_kredit']+$d['angka_kredit_baru'])?></td>
        </tr>
      <?php endforeach; ?>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: left;width: 5px;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: left;">Jumlah Unsur Penunjang</td>
        <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=$angka_kredit_penjunjang?></td>
        <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=$angka_kredit_penjunjang_baru?></td>
        <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=($angka_kredit_penjunjang_baru+$angka_kredit_penjunjang)?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td colspan="3" class="isi_tabel_bergaris" style="text-align: left;">Jumlah Unsur Utama dan Unsur Penunjang</td>
        <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=($angka_kredit_penjunjang + $angka_kredit)?></td>
        <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=($angka_kredit_penjunjang_baru + $angka_kredit_baru)?></td>
        <td colspan="2" class="isi_tabel_bergaris" style="text-align: center;"><?=(($angka_kredit_penjunjang + $angka_kredit)+($angka_kredit_penjunjang_baru + $angka_kredit_baru))?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris"> </td>
        <td colspan="9" class="isi_tabel_bergaris" style="text-align: left;">DAPAT DIPERTIMBANGKAN UNTUK PENYESUAIAN DALAM JABATAN <b><?=$data_pangkat_selanjutnya['nm_jabatan']." ".$data_pangkat_selanjutnya['nm_pangkat']." Terhitung ".tanggal_indo($data_usulan['tgl_penyesuaian'])?></b></td>
      </tr>
    </table>
    <br/>
    <br/>
    <div style="float: right; width: 50%;">
      <table style="width: 100%;">
        <tr>
          <td style="text-align: left;">Ditetapkan di</td>
          <td>:</td>
          <td style="text-align: left;">PADANG</td>
        </tr>
        <tr>
          <td style="text-align: left;">Pada Tanggal</td>
          <td>:</td>
          <td style="text-align: left;"><?=tanggal_indo($data_usulan['tgl_pengesahan'])?></td>
        </tr>
      </table>
    </div>
    <div style="clear: both;"></div>
    <br/>
    <br/>
    <br/>
    <div style="float: right; text-align: center; width: 50%;">
      A.n REKTOR UNIVERSITAS ANDALAS <br/> Wakil Rektor I 
      <br/>
      <br/>
      <br/>
      <b>Dr. Ir. Febrin Anas Ismail, MT</b> <br/>
      NIP. 196302211988031002
    </div>
  </div>
    <div style="float: left; text-align: left; width: 50%;">
      <br/>
      <br/>
      <br/>
      <br/>
      Asli disampaikan dengan hormat kepada: <br/>
      Kepala BKN di Jakarta
      <br/>
      <br/>
      <br/>
      TEMBUSAN disampaikan kepada: <br/>
      1. Pustakawan yang bersangkutan. <br/>
      2. Pimpinan Unit Kerja Pustakawan yang bersangkutan. <br/>
      3. Pejabat yang menetapkan angka kredit.<br/>
      4. Kepala Bagian Kepegawaian & HKTL Universitas Andalas. <br/>
    </div>
    <div style="clear: both;"></div>
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
