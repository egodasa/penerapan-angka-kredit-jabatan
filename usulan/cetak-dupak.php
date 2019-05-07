<?php
  session_start();
  require_once "../vendor/autoload.php";
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  use Dompdf\Dompdf;
  
  $data_usulan = $db->get('tbl_usulan', '*', ['id_usulan' => $_GET['id_usulan']]);
  $data_usulan_utama = $db->query("SELECT 
                                      a.*,
                                      c.nm_sub_unsur,
                                      d.nm_unsur,
                                      b.butir_kegiatan,
                                      b.angka_kredit,
                                      c.id_sub_unsur,
                                      d.id_unsur
                                      FROM   tbl_usulan_unsur a
                                             JOIN tbl_butir_kegiatan b ON a.id_butir = b.id_butir 
                                      JOIN tbl_sub_unsur c ON b.id_sub_unsur = c.id_sub_unsur 
                                      JOIN tbl_unsur d ON c.id_unsur = d.id_unsur 
                                      WHERE  a.id_usulan = :id_usulan AND d.kategori = 'Unsur Utama' GROUP BY c.id_sub_unsur", ["id_usulan" => $_GET['id_usulan']])->fetchAll();
  $data_usulan_penunjang = $db->query("SELECT 
                                        a.*,
                                        c.nm_sub_unsur,
                                        d.nm_unsur,
                                        b.butir_kegiatan,
                                        b.angka_kredit,
                                        c.id_sub_unsur,
                                        d.id_unsur
                                        FROM   tbl_usulan_unsur a
                                               JOIN tbl_butir_kegiatan b ON a.id_butir = b.id_butir 
                                        JOIN tbl_sub_unsur c ON b.id_sub_unsur = c.id_sub_unsur 
                                        JOIN tbl_unsur d ON c.id_unsur = d.id_unsur 
                                        WHERE  a.id_usulan = :id_usulan AND d.kategori = 'Unsur Penunjang' GROUP BY c.id_sub_unsur", ["id_usulan" => $_GET['id_usulan']])->fetchAll();
  
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
  // cara memanggil total kredit awal unsur utama $kredit_awal_utama['angka_kredit']
  $kredit_awal_utama = $db->query("SELECT 
                                      SUM(CASE WHEN a.angka_kredit_baru = 0 THEN a.angka_kredit ELSE a.angka_kredit_baru END) AS angka_kredit, b.jenis_unsur
                                      FROM tbl_usulan_unsur a 
                                      JOIN tbl_sub_unsur b ON a.id_sub_unsur = b.id_sub_unsur 
                                      JOIN tbl_usulan c ON a.id_usulan = c.id_usulan 
                                      LEFT JOIN tbl_jabatan_pangkat d ON c.id_jabatan_pangkat_sekarang = d.id_jabatan_pangkat
                                      WHERE a.status <> 'Ditolak' AND d.peringkat < :peringkat AND a.id_usulan = :id_usulan AND b.jenis_unsur = 'Unsur Utama' 
                                      GROUP BY b.jenis_unsur", ['id_usulan' => $_GET['id_usulan'], 'peringkat' => $_SESSION['peringkat_jabatan_sekarang']])->fetch();
  if(isset($kredit_awal_utama['angka_kredit']) == FALSE)
  {
    $kredit_awal_utama['angka_kredit'] = $pegawai['kredit_awal_utama'];
  }
  else
  {
    $kredit_awal_utama['angka_kredit'] += $pegawai['kredit_awal_utama'];
  }
  
  // PERHITUNGAN AK UTAMA DAN PENUNJANG
  $ak_utama_total = 0;
  $ak_penunjang_total = 0;
  $ak_total = 0;
  
  $ak_utama_sekarang = $_SESSION['kredit_awal_utama'];
  $ak_penunjang_sekarang = $_SESSION['kredit_awal_penunjang'];
  
  // Ambil angka kredit utama dan penunjang dari usulan
  
  $sql_ak_utama = "SELECT 
                      SUM(IFNULL(a.angka_kredit_baru), a.angka_kredit, a.angka_kredit_baru) AS angka_kredit 
                      FROM tbl_usulan_unsur a 
                      JOIN tbl_usulan b ON a.id_usulan = b.id_usulan 
                      JOIN tbl_pegawai c ON b.nip = c.nip 
                      JOIN tbl_butir_kegiatan d ON a.id_butir = b.id_butir 
                      JOIN tbl_sub_unsur e ON d.id_sub_unsur = e.id_sub_unsur 
                      JOIN tbl_unsur f ON e.id_unsur = f.id_unsur 
                     WHERE c.nip = :nip AND f.kategori = 'Unsur Utama' GROUP BY a.id_usulan_unsur";
  $ak_utama_sementara = $db->query($sql_ak_utama, ['nip' => $_SESSION['nip']])->fetch();
  
  $sql_ak_penunjang = "SELECT 
                      SUM(IFNULL(a.angka_kredit_baru), a.angka_kredit, a.angka_kredit_baru) AS angka_kredit 
                      FROM tbl_usulan_unsur a 
                      JOIN tbl_usulan b ON a.id_usulan = b.id_usulan 
                      JOIN tbl_pegawai c ON b.nip = c.nip 
                      JOIN tbl_butir_kegiatan d ON a.id_butir = b.id_butir 
                      JOIN tbl_sub_unsur e ON d.id_sub_unsur = e.id_sub_unsur 
                      JOIN tbl_unsur f ON e.id_unsur = f.id_unsur 
                     WHERE c.nip = :nip AND f.kategori = 'Unsur Penunjang' GROUP BY a.id_usulan_unsur";
  $ak_penunjang_sementara = $db->query($sql_ak_penunjang, ['nip' => $_SESSION['nip']])->fetch();
  
  $ak_utama_total = $ak_utama_sekarang + $ak_utama_sementara['angka_kredit'];
  $ak_penunjang_total = $ak_penunjang_sekarang + $ak_penunjang_sementara['angka_kredit'];
  
  $ak_total = $ak_utama_total + $ak_penunjang_total;
  // AKHIR DARI PERHITUNGAN AK UTAMA DAN PENUNJANG
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
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=round($ak_utama_total, 4)?></td>
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
          $detail_usulan = $db->query("SELECT 
                                          a.*,
                                          c.nm_sub_unsur,
                                          d.nm_unsur,
                                          b.butir_kegiatan,
                                          b.angka_kredit
                                          FROM   tbl_usulan_unsur a
                                                 JOIN tbl_butir_kegiatan b ON a.id_butir = b.id_butir 
                                          JOIN tbl_sub_unsur c ON b.id_sub_unsur = c.id_sub_unsur 
                                          JOIN tbl_unsur d ON c.id_unsur = d.id_unsur 
                                          WHERE  a.id_usulan = :id_usulan AND c.id_sub_unsur = :id_sub_unsur", ["id_usulan" => $d['id_usulan'], "id_sub_unsur" => $d['id_sub_unsur']])->fetchAll();
          foreach($detail_usulan as $i=>$u):
          $total_ak += $u['angka_kredit'];
          if($u['angka_kredit_baru'] == 0)
          {
            $total_ak_baru += $u['angka_kredit'];
          }
          else
          {
            $total_ak_baru += $u['angka_kredit_baru'];
          }
      ?>
            <tr>
              <td class="isi_tabel_bergaris" style="width: 15px;text-align: center;"> </td>
              <td class="isi_tabel_bergaris" style="text-align: left;"> </td>
              <td class="isi_tabel_bergaris" style="text-align: left;width: 5px;"><?=angkaHuruf($i)?></td>
              <td class="isi_tabel_bergaris" style="text-align: left;"><?=$u['butir_kegiatan']?></td>
              <td class="isi_tabel_bergaris" style="text-align: center;"></td>
              <td class="isi_tabel_bergaris" style="text-align: center;"><?=round($u['angka_kredit'], 4)?></td>
              <td class="isi_tabel_bergaris" style="text-align: center;"><?=round($u['angka_kredit'], 4)?></td>
              <td class="isi_tabel_bergaris" style="text-align: center;"></td>
              <td class="isi_tabel_bergaris" style="text-align: center;">
                <?php
                  if($u['angka_kredit_baru'] == 0)
                  {
                    echo round($u['angka_kredit'], 4);
                  }
                  else
                  {
                    echo round($u['angka_kredit_baru'], 4);
                  }
                ?>
              </td>
              <td class="isi_tabel_bergaris" style="text-align: center;">
                <?php
                  if($u['angka_kredit_baru'] == 0)
                  {
                    echo round($u['angka_kredit'], 4);
                  }
                  else
                  {
                    echo round($u['angka_kredit_baru'], 4);
                  }
                ?>
              </td>
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
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_baru?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_baru?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;" colspan="4"><b>JUMLAH UNSUR UTAMA</b></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=round($ak_utama_total, 4)?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_baru?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_baru?></td>
      </tr>
      
      
      <!-- Baris unsur penunjang -->
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;text-align: center;">II</td>
        <td class="isi_tabel_bergaris" style="text-align: left;" colspan="3"><b>UNSUR PENUNJANG</b></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=round($ak_penunjang_total, 4)?></td>
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
          $detail_usulan = $db->query("SELECT 
                                          a.*,
                                          c.nm_sub_unsur,
                                          d.nm_unsur,
                                          b.butir_kegiatan,
                                          b.angka_kredit
                                          FROM   tbl_usulan_unsur a
                                                 JOIN tbl_butir_kegiatan b ON a.id_butir = b.id_butir 
                                          JOIN tbl_sub_unsur c ON b.id_sub_unsur = c.id_sub_unsur 
                                          JOIN tbl_unsur d ON c.id_unsur = d.id_unsur 
                                          WHERE  a.id_usulan = :id_usulan AND c.id_sub_unsur = :id_sub_unsur", ["id_usulan" => $d['id_usulan'], "id_sub_unsur" => $d['id_sub_unsur']])->fetchAll();
          foreach($detail_usulan as $i=>$u):
          $total_ak_penunjang += $u['angka_kredit'];
          if($u['angka_kredit_baru'] == 0)
          {
            $total_ak_baru += $u['angka_kredit'];
          }
          else
          {
            $total_ak_baru += $u['angka_kredit_baru'];
          }
      ?>
      <tr>
        <td class="isi_tabel_bergaris" style="width: 15px;text-align: center;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: left;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: left;width: 5px;"><?=angkaHuruf($i)?></td>
        <td class="isi_tabel_bergaris" style="text-align: left;"><?=$u['butir_kegiatan']?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=round($u['angka_kredit'], 4)?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"><?=round($u['angka_kredit'], 4)?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;"></td>
        <td class="isi_tabel_bergaris" style="text-align: center;">
          <?php
            if($u['angka_kredit_baru'] == 0)
            {
              echo round($u['angka_kredit'], 4);
            }
            else
            {
              echo round($u['angka_kredit_baru'], 4);
            }
          ?>
        </td>
        <td class="isi_tabel_bergaris" style="text-align: center;">
          <?php
            if($u['angka_kredit_baru'] == 0)
            {
              echo round($u['angka_kredit'], 4);
            }
            else
            {
              echo round($u['angka_kredit_baru'], 4);
            }
          ?>
        </td>
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
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_penunjang?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_penunjang_baru?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_penunjang_baru?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;" colspan="4"><b>JUMLAH UNSUR PENUNJANG</b></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=round($ak_utama_total, 4)?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_penunjang?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_penunjang?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"> </td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_penunjang_baru?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=$total_ak_penunjang_baru?></td>
      </tr>
      <tr>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;" colspan="4"><b>JUMLAH UNSUR UTAMA DAN PENUNJANG</b></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=round($ak_total, 4)?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=($total_ak+$total_ak_penunjang)?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=($total_ak+$total_ak_penunjang)?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=($total_ak_baru+$total_ak_penunjang_baru)?></td>
        <td class="isi_tabel_bergaris" style="text-align: center;background-color: #E7E7E7;"><?=($total_ak_baru+$total_ak_penunjang_baru)?></td>
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
