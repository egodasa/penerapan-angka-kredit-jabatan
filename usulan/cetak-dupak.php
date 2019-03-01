<?php
  require_once "../vendor/autoload.php";
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  use Dompdf\Dompdf;
  
  $data_usulan = $db->get('tbl_usulan', '*', ['id_usulan' => $_GET['id_usulan']]);
  $data_usulan_utama = $db->query("SELECT a.id_usulan, a.id_unsur, b.nm_unsur FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE id_usulan = :id_usulan AND b.jenis_unsur = 'Unsur Utama' GROUP BY id_unsur", ["id_usulan" => $_GET['id_usulan']])->fetchAll();
  $data_usulan_penunjang = $db->query("SELECT a.id_usulan, a.id_unsur, b.nm_unsur FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE id_usulan = :id_usulan AND b.jenis_unsur = 'Unsur Penunjang' GROUP BY id_unsur", ["id_usulan" => $_GET['id_usulan']])->fetchAll();
  
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
	<title>SURAT PERNYATAAN MELAKUKAN KEGIATAN</title>
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
    <p style="width: 50%; float: right;font-weight: bold;">
      ANAK LAMPIRAN 1-g <br/>
      PERATURAN BERSAMA <br/>
      KEPALA PERPUSTAKAAN NASIONAL REPUBLIK INDONESIA <br/>
      DAN KEPALA BADAN KEPEGAWAIAN NEGARA<br/>
      TENTANG<br/>
      KETENTUAN PELAKSANAAN PERATURAN MENTERI <br/>
      PENDAYAGUNAAN APARATUR NEGARA DAN REFORMASI<br/>
      BIROKRASI REPUBLIK INDONESIA NOMOR 9 TAHUN 2014 <br/>
      TENTANG JABATAN FUNGSIONAL PUSTAKAWAN DAN <br/>
      ANGKA KREDITNYA
    </p>
  </div>
  <div style="clear: both;"></div>
  <br/>
  <br/>
  <div style="font-weight: bold;text-align: center;">
    DAFTAR USUL PENETAPAN ANGKA KREDIT <br/> JABATAN FUNGSIONAL PUSTAKAWAN TERAMPIL <br/> NOMOR: <?=$data_usulan['id_usulan']?>
  </div>
  <div style="width: 100%;">
    <div style="float: left; text-align: left;">Instansi: <?=$pegawai['nm_unit_kerja']?></div>
    <div style="clear: both;"></div>
    <div style="text-align: center;">
      Masa Penilaian : <?=tanggal_indo($data_usulan['masa_penilaian_awal'])." s.d ".tanggal_indo($data_usulan['masa_penilaian_akhir'])?>
    </div>
    <div style="clear: both;"></div>
    <table class="tabel_garis">
      <tr>
        <th colspan="10" class="isi_tabel_bergaris" style="text-align: center;">KETERANGAN PERORANGAN</th>
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
        <th colspan="10" class="isi_tabel_bergaris" style="text-align: center;">UNSUR YANG DINILAI</th>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;" rowspan="3"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;" rowspan="3" colspan="3"> SUB UNSUR YANG DINILAI</td>
        <td class="isi_tabel_bergaris" style="text-align: center;" colspan="6"> ANGKA KREDIT MENURUT</td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;" colspan="3"> INSTANSI PENGUSUL</td>
        <td class="isi_tabel_bergaris" style="text-align: center;" colspan="3"> TIM PENILAI</td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;width: 50px;"> LAMA</td>
        <td class="isi_tabel_bergaris" style="text-align: center;width: 50px;"> BARU</td>
        <td class="isi_tabel_bergaris" style="text-align: center;width: 50px;"> JMLH</td>
        <td class="isi_tabel_bergaris" style="text-align: center;width: 50px;"> LAMA</td>
        <td class="isi_tabel_bergaris" style="text-align: center;width: 50px;"> BARU</td>
        <td class="isi_tabel_bergaris" style="text-align: center;width: 50px;"> JMLH</td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;text-align: center;background-color: #E7E7E7;"> 1</td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;" colspan="3"> 2</td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> 3</td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> 4</td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> 5</td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> 6</td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> 7</td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> 8</td>
      </tr>
      
      
      <!-- Baris unsur utama -->
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;text-align: center;">I</td>
        <td class="isi_tabel_bergaris" style="text-align: left;" colspan="3"><b>UNSUR UTAMA</b></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
      </tr>
      <?php
        $no_unsur = 0;
        $total_ak = 0;
        $total_ak_baru = 0;
        foreach($data_usulan_utama as $index=>$d):
      ?>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: left;"><?=($index+1)?></td>
        <td class="isi_tabel_bergaris" style="text-align: left;" colspan="2"><b><?=$d['nm_unsur']?></b></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
      </tr>
      <?php
          $no_kegiatan = 0;
          $detail_usulan = $db->query("SELECT a.*, b.nm_unsur, b.jenis_unsur FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE a.id_usulan = :id_usulan AND a.id_unsur = :id_unsur ORDER BY b.jenis_unsur, b.nm_unsur ASC", ["id_usulan" => $d['id_usulan'], "id_unsur" => $d['id_unsur']])->fetchAll();
          foreach($detail_usulan as $i=>$u):
          $total_ak += $u['angka_kredit'];
          $total_ak_baru += $u['angka_kredit_baru'];
      ?>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: left;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: left;width: 5px;"><?=angkaHuruf($i)?></td>
        <td class="isi_tabel_bergaris" style="text-align: left;"><?=$u['butir_kegiatan']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['angka_kredit']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['angka_kredit_baru']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"></td>
      </tr>
      <?php
          $no_kegiatan++; 
          endforeach;
          $no_unsur++;
        endforeach;
      ?>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;" colspan="4"><b>JUMLAH</b></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_baru?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;" colspan="4"><b>JUMLAH UNSUR UTAMA</b></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_baru?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> </td>
      </tr>
      
      
      <!-- Baris unsur penunjang -->
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;text-align: center;">II</td>
        <td class="isi_tabel_bergaris" style="text-align: left;" colspan="3"><b>UNSUR PENUNJANG</b></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
      </tr>
      <?php
        $total_ak_penunjang = 0;
        $total_ak_penunjang_baru = 0;
        $no_unsur = 0;
        foreach($data_usulan_penunjang as $index=>$d):
      ?>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: left;"><?=($index+1)?></td>
        <td class="isi_tabel_bergaris" style="text-align: left;" colspan="2"><b><?=$d['nm_unsur']?></b></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
      </tr>
      <?php
          $no_kegiatan = 0;
          $detail_usulan = $db->query("SELECT a.*, b.nm_unsur, b.jenis_unsur FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE a.id_usulan = :id_usulan AND a.id_unsur = :id_unsur ORDER BY b.jenis_unsur, b.nm_unsur ASC", ["id_usulan" => $d['id_usulan'], "id_unsur" => $d['id_unsur']])->fetchAll();
          foreach($detail_usulan as $i=>$u):
          $total_ak_penunjang += $u['angka_kredit'];
          $total_ak_penunjang_baru += $u['angka_kredit_baru'];
      ?>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: left;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: left;width: 5px;"><?=angkaHuruf($i)?></td>
        <td class="isi_tabel_bergaris" style="text-align: left;"><?=$u['butir_kegiatan']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['angka_kredit']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=$u['angka_kredit_baru']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"></td>
      </tr>
      <?php
          $no_kegiatan++; 
          endforeach;
          $no_unsur++;
        endforeach;
      ?>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;" colspan="4"><b>JUMLAH</b></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_penunjang?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_penunjang_baru?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;" colspan="4"><b>JUMLAH UNSUR PENUNJANG</b></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_penunjang?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_penunjang_baru?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"></td>
      </tr>
      
      <!-- Bagian tanda tangan -->
      <tr>
        <th class="isi_tabel_bergaris" style="text-align: center;">III</th>
        <th colspan="9" class="isi_tabel_bergaris" style="text-align: left;">LAMPIRAN PENDUKUNG DUPAK</th>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td colspan="9" class="isi_tabel_bergaris" style="text-align: justify;">
          <ol style="font-size: 9pt;">
            <li>Surat pernyataan telah mengikuti pendidikan</li>
            <li>Surat pernyataan telah melakukan kegiatan pelayanan perpustakaan</li>
            <li>Surat pernyataan telah melakukan kegiatan pengembangan profesi</li>
            <li>Surat pernyataan telah melakukan kegiatan penunjang tugas pustakawan</li>
            <li>Fotocopy ijazah/sertifikat</li>
          </ol>
          <div style="float: right; margin-right: 100px; text-align: left;">
            Padang, <?=tanggal_indo(date("Y-m-d"))?> <br/>
            <?=$pegawai['nm_posisi']?> Yang Bersangkutan
            <br/>
            <br/>
            <br/>
            <?=$pegawai['nm_lengkap']?> <br/>
            NIP. <?=$pegawai['nip']?> <br/>
          </div>
          <div style="clear: both;"></div>
        </td>
      </tr>
      <tr>
        <th class="isi_tabel_bergaris" style="text-align: center;">IV</th>
        <th colspan="9" class="isi_tabel_bergaris" style="text-align: left;">CATATAN PEJABAT PENGUSUL</th>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td colspan="9" class="isi_tabel_bergaris" style="text-align: justify;">
          <div style="float: right; margin-right: 100px; text-align: left;">
            Kepala <?=$pegawai['nm_unit_kerja']?>
            <br/>
            <br/>
            <br/>
            <br/>
            <?=$atasan['nm_lengkap']?> <br/>
            NIP. <?=$atasan['nip']?> <br/>
          </div>
          <div style="clear: both;"></div>
        </td>
      </tr>
      <tr>
        <th class="isi_tabel_bergaris" style="text-align: center;">V</th>
        <th colspan="9" class="isi_tabel_bergaris" style="text-align: left;">CATATAN ANGGOTA TIM PENILAI</th>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td colspan="9" class="isi_tabel_bergaris" style="text-align: justify;">
          <div style="float: right; margin-right: 100px; text-align: left;">
            Padang, 
            <br/>
            <br/>
            <br/>
            <br/>
            (...............................)<br/>
            NIP................................<br/>
          </div>
          <div style="clear: both;"></div>
        </td>
      </tr>
      <tr>
        <th class="isi_tabel_bergaris" style="text-align: center;">VI</th>
        <th colspan="9" class="isi_tabel_bergaris" style="text-align: left;">CATATAN KETUA TIM PENILAI</th>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;"> </td>
        <td colspan="9" class="isi_tabel_bergaris" style="text-align: justify;">
          <div style="float: right; margin-right: 100px; text-align: left;">
            Padang, 
            <br/>
            <br/>
            <br/>
            <br/>
            (...............................)<br/>
            NIP................................<br/>
          </div>
          <div style="clear: both;"></div>
        </td>
      </tr>
    </table>
  </div>
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
