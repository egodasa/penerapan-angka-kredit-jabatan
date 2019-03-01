<?php
require("pengaturan.php");
// level_array : daftar level yang bisa mengakses halaman
// halaman_login : apakah halaman yang dicek login atau tidak
function cekIzinAksesHalaman($level_array, $base_url = "http://localhost/cafe", $halaman_login = false)
{
  // Jika posisi sekarang halaman login, maka lempar ke halaman level jika sudah login
  if($halaman_login == true){
    if(isset($_SESSION['level'])){
      if($_SESSION['level'] == 'Kasir'){
        header("Location: $base_url/pembayaran");
      }
      else if($_SESSION['level'] == 'Dapur'){
        header("Location: $base_url/dapur");
      }
    }
  }else{
    // Jika belum login, maka redirect ke login
    if(!isset($_SESSION['level'])){
      header("Location: $base_url/login");
    }else{
      
      // Jika level tidak sesuai dengan level_array, maka redirect ke halaman levelnya
      if(!in_array($_SESSION['level'], $level_array)){
        if($_SESSION['level'] == 'Kasir'){
          header("Location: $base_url/pembayaran");
        }
        else if($_SESSION['level'] == 'Dapur'){
          header("Location: $base_url/dapur");
        }
      }
    }
  }
}
function tanggal_indo($tanggal, $cetak_hari = false)
{
	$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
	if ($cetak_hari) {
		$num = date('N', strtotime($tanggal));
		return $hari[$num] . ', ' . $tgl_indo;
	}
	return $tgl_indo;
}
function rupiah($nilai, $simbol = "Rp", $spasi_rupiah = "", $dibelakang_koma = 0, $penutup = "")
{
   // $penutup = ,-
   // $dibelakang_koma = 2 -> ,00
  return $simbol.$spasi_rupiah.number_format($nilai,$dibelakang_koma,',','.').$penutup;
}
function generateNumber()
{
  $now = DateTime::createFromFormat('U.u', microtime(true));
  return $now->format("dmyHisu");
}
function tanggal_indo_waktu($waktu, $hari = false){
  $bagian = explode(" ", $waktu);
  $tanggal = tanggal_indo($bagian[0], $hari);
  return $tanggal." ".$bagian[1];
}
function namaBulan($angka_bulan){
  $bulan = array(
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember',
    '1' => 'Januari',
    '2' => 'Februari',
    '3' => 'Maret',
    '4' => 'April',
    '5' => 'Mei',
    '6' => 'Juni',
    '7' => 'Juli'
  );
  return $bulan[$angka_bulan];
}
function fileUpload($files, $lokasi){
  $file_tmp = $files['tmp_name'];
  $file_ext=strtolower(end(explode('.', $files['name'])));
  $nama_file = generateNumber().".".$file_ext;
  $lokasi_file = $lokasi.$nama_file;
  move_uploaded_file($file_tmp, $lokasi_file);
  return $nama_file;
}
function angkaHuruf($angka){
    $huruf = [
       "A",
       "B",
       "C",
       "D",
       "E",
       "F",
       "G",
       "H",
       "I",
       "J",
       "K",
       "L",
       "M",
       "N",
       "O",
       "P",
       "Q",
       "R",
       "S",
       "T",
       "U",
       "V",
       "W",
       "X",
       "Y",
       "Z"];
   return $huruf[$angka];
}
?>
