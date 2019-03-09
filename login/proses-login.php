<?
  session_start();
  require('../pengaturan/helper.php');
  require('../vendor/autoload.php');
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('../pengaturan/medoo.php');
    
    // Cek login pengguna
    $data = $db->query("SELECT e.nm_posisi,
                                   e.jenis_posisi,
                                   a.kredit_awal_utama,
                                   a.kredit_awal_penunjang,
                                   a.nip,
                                   a.nm_lengkap,
                                   a.jk,
                                   a.foto,
                                   b.peringkat,
                                   c.nm_jabatan,
                                   d.nm_pangkat,
                                   a.id_unit_kerja,
                                   f.nm_unit_kerja,
                                   f.id_posisi
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
                                     ON f.id_posisi = e.id_posisi WHERE a.nip = :nip AND a.password = md5(:password) LIMIT 1", ['nip' => $_POST['nip'], 'password' => $_POST['password']])->fetch();
    // Cek apakah nip betul atau tidak
    if($data){
      // Cek apakah pegawai tersebut atasan disebuah unit kerja atau tidak
      $atasan = $db->query("SELECT nip_atasan FROM tbl_unit_kerja WHERE nip_atasan = :nip_atasan", ['nip_atasan' => $data['nip']])->fetch();
      // Jika pegawai tersebut atasan, maka tandai pegawai tersebut lewat session
      if($atasan)
      {
        $_SESSION['atasan'] = "1";
      }
      else
      {
        $_SESSION['atasan'] = "0";
      }
      $_SESSION['nip'] = $data['nip'];
      $_SESSION['id_posisi'] = $data['id_posisi'];
      $_SESSION['nm_lengkap'] = $data['nm_lengkap'];
      $_SESSION['nm_posisi'] = $data['nm_posisi'];
      $_SESSION['jenis_posisi'] = $data['jenis_posisi'];
      $_SESSION['jk'] = $data['jk'];
      $_SESSION['foto'] = $data['foto'];
      $_SESSION['angka_kredit'] = $data['kredit_awal_utama']+$data['kredit_awal_penunjang'];
      $_SESSION['kredit_awal_utama'] = $data['kredit_awal_utama'];
      $_SESSION['kredit_awal_penunjang'] = $data['kredit_awal_penunjang'];
      $_SESSION['jabatan'] = $data['nm_jabatan'];
      $_SESSION['pangkat'] = $data['nm_pangkat'];
      
      $data = $db->query("SELECT a.*, b.nm_jabatan, b.id_jabatan, c.nm_pangkat, c.id_pangkat, a.nilai_kredit FROM tbl_jabatan_pangkat a JOIN tbl_jabatan b ON a.id_jabatan = b.id_jabatan JOIN tbl_pangkat c ON a.id_pangkat = c.id_pangkat WHERE a.peringkat >= :peringkat ORDER BY a.peringkat ASC LIMIT 2 OFFSET 1", ['peringkat' => $data['peringkat']])->fetchAll(PDO::FETCH_ASSOC);      
      
      $_SESSION['angka_kredit_selanjutnya'] = $data[1]['nilai_kredit'];
      $_SESSION['id_jabatan_selanjutnya'] = $data[1]['id_jabatan'];
      $_SESSION['jabatan_selanjutnya'] = $data[1]['nm_jabatan'];
      $_SESSION['pangkat_selanjutnya'] = $data[1]['nm_pangkat'];
      $_SESSION['id_pangkat_selanjutnya'] = $data[1]['id_pangkat'];
      $_SESSION['id_jabatan_pangkat'] = $data[0]['id_jabatan_pangkat'];
      $_SESSION['id_jabatan_pangkat_selanjutnya'] = $data[1]['id_jabatan_pangkat'];
      
      // Cek level agar halaman di redirect sesuai aktor
      if($_SESSION['jenis_posisi'] == "Staff Kepegawaian")
      {
        if($_SESSION['atasan'] == '1')
        {
          header("Location: $alamat_web/usulan");
        }
        else
        {
          header("Location: $alamat_web/pegawai");
        }
      }
      else if($_SESSION['jenis_posisi'] == "Tenaga Kependidikan")
      {
        header("Location: $alamat_web/persyaratan");
      }
      else if($_SESSION['jenis_posisi'] == "Tim Penilai")
      {
        header("Location: $alamat_web/usulan");
      }
    }else{
      header("Location: $alamat_web/login?status=gagal");
    }
  }else{
    header("Location: $alamat_web/login");
  }
?>
