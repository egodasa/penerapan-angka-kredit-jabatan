<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  //~ use Dompdf\Dompdf;
  //~ $data_usulan = $db->query("SELECT a.id_usulan, a.id_sub_unsur, b.nm_unsur, f.nm_posisi FROM tbl_usulan_unsur a JOIN tbl_sub_unsur b ON a.id_sub_unsur = b.id_sub_unsur JOIN tbl_usulan c ON a.id_usulan = c.id_usulan JOIN tbl_pegawai d ON c.nip = d.nip JOIN tbl_unit_kerja e ON d.id_unit_kerja = e.id_unit_kerja JOIN tbl_posisi f ON e.id_posisi = f.id_posisi WHERE a.id_usulan = :id_usulan AND b.jenis_unsur = 'Unsur Utama' GROUP BY a.id_sub_unsur", ["id_usulan" => $_GET['id_usulan']])->fetchAll();
  //~ $data_usulan_penunjang = $db->query("SELECT a.id_usulan, a.id_sub_unsur, b.nm_unsur, f.nm_posisi FROM tbl_usulan_unsur a JOIN tbl_sub_unsur b ON a.id_sub_unsur = b.id_sub_unsur JOIN tbl_usulan c ON a.id_usulan = c.id_usulan JOIN tbl_pegawai d ON c.nip = d.nip JOIN tbl_unit_kerja e ON d.id_unit_kerja = e.id_unit_kerja JOIN tbl_posisi f ON e.id_posisi = f.id_posisi WHERE a.id_usulan = :id_usulan AND b.jenis_unsur = 'Unsur Penunjang' GROUP BY a.id_sub_unsur", ["id_usulan" => $_GET['id_usulan']])->fetchAll();
  //~ $pegawai = $db->query("SELECT e.nm_posisi,
                                   //~ e.jenis_posisi,
                                   //~ a.kredit_awal,
                                   //~ a.nip,
                                   //~ a.nm_lengkap,
                                   //~ a.jk,
                                   //~ a.foto,
                                   //~ b.peringkat,
                                   //~ c.nm_jabatan,
                                   //~ d.nm_pangkat,
                                   //~ a.id_unit_kerja,
                                   //~ f.nm_unit_kerja,
                                   //~ f.nip_atasan 
                            //~ FROM   tbl_pegawai a
                                   //~ JOIN tbl_jabatan_pangkat b
                                     //~ ON a.id_jabatan_pangkat = b.id_jabatan_pangkat
                                   //~ JOIN tbl_jabatan c
                                     //~ ON b.id_jabatan = c.id_jabatan
                                   //~ JOIN tbl_pangkat d
                                     //~ ON b.id_pangkat = d.id_pangkat
                                   //~ JOIN tbl_unit_kerja f
                                     //~ ON a.id_unit_kerja = f.id_unit_kerja
                                   //~ JOIN tbl_posisi e
                                     //~ ON f.id_posisi = e.id_posisi WHERE a.nip = :nip", ['nip' => $_GET['nip']])->fetch();
  //~ $atasan = $db->query("SELECT e.nm_posisi,
                                   //~ e.jenis_posisi,
                                   //~ a.kredit_awal,
                                   //~ a.nip,
                                   //~ a.nm_lengkap,
                                   //~ a.jk,
                                   //~ a.foto,
                                   //~ b.peringkat,
                                   //~ c.nm_jabatan,
                                   //~ d.nm_pangkat,
                                   //~ a.id_unit_kerja,
                                   //~ f.nm_unit_kerja
                            //~ FROM   tbl_pegawai a
                                   //~ JOIN tbl_jabatan_pangkat b
                                     //~ ON a.id_jabatan_pangkat = b.id_jabatan_pangkat
                                   //~ JOIN tbl_jabatan c
                                     //~ ON b.id_jabatan = c.id_jabatan
                                   //~ JOIN tbl_pangkat d
                                     //~ ON b.id_pangkat = d.id_pangkat
                                   //~ JOIN tbl_unit_kerja f
                                     //~ ON a.id_unit_kerja = f.id_unit_kerja
                                   //~ JOIN tbl_posisi e
                                     //~ ON f.id_posisi = e.id_posisi WHERE a.nip = :nip", ['nip' => $pegawai['nip_atasan']])->fetch();
  //~ $start_huruf = 13;
  //~ ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SURAT PENGANTAR</title>
  <style>
    body{
      font-size: 12pt;
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
  <div style="text-align: center;">
    KEMENTRIAN RISET, TEKNOLOGI PENDIDIKAN TINGGI <br/> UNIVERSITAS ANDALAS <br/> <b>-- UNIT KERJA --</b> <br/>
    <span style="font-size: 9pt">Alamat: Gedung Perpustakaan, Limau Manis Padang, Kode Pos 25163</span> <br/>
    Telp/FaxL (0751) 72725 <br/>
    http://www.unand.ac.id   e-mail: Pustaka@unand.ac.id
  </div>
  <hr/>
  <div style="float: left;">
    <table style="width: 300px;">
      <tr>
        <td>Nomor</td>
        <td>:</td>
        <td>5378/UN.16/PK/<?=date("Y")?></td>
      </tr>
      <tr>
        <td>Lamp</td>
        <td>:</td>
        <td>1 (satu) Rangkap</td>
      </tr>
      <tr>
        <td>Hal</td>
        <td>:</td>
        <td>Permohonan Kenaikan Pangkat</td>
      </tr>
    </table>
  </div>
  <div style="float: right;">
    <?=tanggal_indo(date("Y-m-d"))?>
  </div>
  <div style="clear: both;"></div>
  <div style="text-align: left;">
    Yth. Wakil Rektor II <br/>
    Universitas Andalas <br/> <br/>
    Padang <br/> <br/>
  </div>
  <div style="text-align: justify;">
    Dengan Hormat, <br/>
    Bersama ini Kami sampaikan kepada Bapak usulan kenaikan pangkat 1(satu) orang tenaga kependidikan -- Nama Jabatan -- periode April 2018 sebagai berikut:
  </div>
  <table style="border: 1px solid black; border-collapse: collapse; width: 100%;">
    <tr>
      <th style="border: 1px solid black; text-align: center;">NO</th>
      <th style="border: 1px solid black; text-align: center;">NAMA/NIP</th>
      <th style="border: 1px solid black; text-align: center;">GOL</th>
      <th style="border: 1px solid black; text-align: center;">MENJADI GOL</th>
      <th style="border: 1px solid black; text-align: center;">KETERANGAN</th>
    </tr>
    <tr>
      <th style="border: 1px solid black; text-align: center;">1</th>
      <th style="border: 1px solid black; text-align: center;">Dahliar <br/> Nip. 10302434248032304</th>
      <th style="border: 1px solid black; text-align: center;">Gol III/c</th>
      <th style="border: 1px solid black; text-align: center;">Gol III/d</th>
      <th style="border: 1px solid black; text-align: center;">Fungsional Arsiparis Penyedia</th>
    </tr>
  </table>
  <div style="text-align: justify;">
    Sebagai bahan pertimabgan bagi Bapak, bersama ini kami lampirkan foto copy :
    <ol>
      <li>SK. Pangkat terakhir.</li>
      <li>SK. Kenaikan Gaji Berkala</li>
      <li>DP3 2(dua) tahun terakhir (2015/2016)</li>
      <li>SK Fungsional Terakhir</li>
      <li>SK Konversi NIP</li>
      <li>Ijazah Terakhir</li>
      <li>Kartu Pegawai</li>
      <li>PAK Terakhir</li>
      <li>Daftar usulan penetapan angka kredit (DUPAK)</li>
    </ol>
  </div>
  <br/>
  <div style="text-align: justify;">
    Demikianlah usulan ini kami ajukan, atas bantuan Bapak diucapkan terima kasih.
  </div>
  <div style="float: right;">
    Kepala,
    <br/>
    <br/>
    <br/>
    <br/>
    Drs. Yasir, S. Sos <br/>
    NIP. 193i43239437234
  </div>
</body>
</html>
<?php
//~ $content = ob_get_clean();
//~ // instantiate and use the dompdf class
//~ $dompdf = new Dompdf();
//~ $dompdf->loadHtml($content);

//~ // (Optional) Setup the paper size and orientation
//~ $dompdf->setPaper('A4', 'portrait');

//~ // Render the HTML as PDF
//~ $dompdf->render();

//~ $dompdf->stream("surat-pernyataan-melakukan-kegiatan.pdf", array("Attachment" => false));
//~ exit(0);

?>
