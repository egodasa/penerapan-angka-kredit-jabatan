<?
  session_start();
  require('../pengaturan/helper.php');
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('../pengaturan/database.php');
    $query = $db->prepare("SELECT e.nm_posisi,
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
                                     ON f.id_posisi = e.id_posisi WHERE a.nip = :nip AND a.password = md5(:password) LIMIT 1");
    $query->bindParam('nip', $_POST['nip']); 
    $query->bindParam('password', $_POST['password']); 
    $query->execute();
    $data = $query->fetch();
    // Cek apakah nip betul atau tidak
    if($data){
      $_SESSION['nip'] = $data['nip'];
      $_SESSION['id_posisi'] = $data['id_posisi'];
      $_SESSION['nm_lengkap'] = $data['nm_lengkap'];
      $_SESSION['nm_posisi'] = $data['nm_posisi'];
      $_SESSION['jenis_posisi'] = $data['jenis_posisi'];
      $_SESSION['jk'] = $data['jk'];
      $_SESSION['foto'] = $data['foto'];
      $_SESSION['angka_kredit'] = $data['kredit_awal'];
      $_SESSION['jabatan'] = $data['nm_jabatan'];
      $_SESSION['pangkat'] = $data['nm_pangkat'];
      
      $query = $db->prepare("SELECT a.*, b.nm_jabatan, b.id_jabatan, c.nm_pangkat, c.id_pangkat, a.nilai_kredit FROM tbl_jabatan_pangkat a JOIN tbl_jabatan b ON a.id_jabatan = b.id_jabatan JOIN tbl_pangkat c ON a.id_pangkat = c.id_pangkat WHERE a.peringkat >= :peringkat ORDER BY a.peringkat ASC LIMIT 2 OFFSET 1");
      $query->bindParam('peringkat', $data['peringkat']);
      $query->execute();
      $data = $query->fetchAll();
      
      
      $_SESSION['angka_kredit_selanjutnya'] = $data[1]['nilai_kredit'];
      $_SESSION['id_jabatan_selanjutnya'] = $data[1]['id_jabatan'];
      $_SESSION['jabatan_selanjutnya'] = $data[1]['nm_jabatan'];
      $_SESSION['pangkat_selanjutnya'] = $data[1]['nm_pangkat'];
      $_SESSION['id_pangkat_selanjutnya'] = $data[1]['id_pangkat'];
      $_SESSION['id_jabatan_pangkat'] = $data[0]['id_jabatan_pangkat'];
      $_SESSION['id_jabatan_pangkat_selanjutnya'] = $data[1]['id_jabatan_pangkat'];
      
      // Cek level agar halaman di redirect sesuai aktor
      if($_SESSION['jenis_posisi'] == "Staff Kepegawaian"){
        header("Location: $alamat_web/pegawai");
      }else if($_SESSION['jenis_posisi'] == "Tenaga Kependidikan"){
        header("Location: $alamat_web/persyaratan");
      }else if($_SESSION['jenis_posisi'] == "Tim Penilai"){
        header("Location: $alamat_web/usulan");
      }
    }else{
      header("Location: $alamat_web/login?status=gagal");
    }
  }else{
    header("Location: $alamat_web/login");
  }
?>
