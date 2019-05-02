<?
  session_start();
  require('../pengaturan/helper.php');
  require('../vendor/autoload.php');
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('../pengaturan/medoo.php');
    
    // Cek login pengguna
    $data = $db->query("SELECT a.*,
                             b.id_pangkat,
                             b.nm_pangkat,
                             c.id_jabatan,
                             c.nm_jabatan,
                             e.nm_unit_kerja,
                             d.id_posisi,
                             d.nm_posisi,
                             d.jenis_posisi 
                      FROM   tbl_pegawai a
                             LEFT JOIN tbl_pangkat b
                                    ON a.id_pangkat = b.id_pangkat
                             LEFT JOIN tbl_jabatan c
                                    ON b.id_jabatan = c.id_jabatan
                             LEFT JOIN tbl_posisi d
                                    ON c.id_posisi = d.id_posisi 
                      LEFT JOIN tbl_unit_kerja e ON a.id_unit_kerja = e.id_unit_kerja WHERE a.nip = :nip AND a.password = md5(:password) LIMIT 1", ['nip' => $_POST['nip'], 'password' => $_POST['password']])->fetch(); 
                      
    // Cek apakah nip betul atau tidak
    if($data)
    {
      $_SESSION = $data;
      
      //~ $data = $db->query("SELECT a.*, b.nm_jabatan, b.id_jabatan, c.nm_pangkat, c.id_pangkat, a.nilai_kredit, a.peringkat FROM tbl_jabatan_pangkat a JOIN tbl_jabatan b ON a.id_jabatan = b.id_jabatan JOIN tbl_pangkat c ON a.id_pangkat = c.id_pangkat WHERE a.peringkat >= :peringkat ORDER BY a.peringkat ASC LIMIT 2 OFFSET 1", ['peringkat' => $data['peringkat']])->fetchAll(PDO::FETCH_ASSOC);      
      
      //~ $_SESSION['peringkat_jabatan_sekarang'] = $data[1]['peringkat'];
      //~ $_SESSION['angka_kredit_selanjutnya'] = $data[1]['nilai_kredit'];
      //~ $_SESSION['id_jabatan_selanjutnya'] = $data[1]['id_jabatan'];
      //~ $_SESSION['jabatan_selanjutnya'] = $data[1]['nm_jabatan'];
      //~ $_SESSION['pangkat_selanjutnya'] = $data[1]['nm_pangkat'];
      //~ $_SESSION['id_pangkat_selanjutnya'] = $data[1]['id_pangkat'];
      //~ $_SESSION['id_jabatan_pangkat'] = $data[0]['id_jabatan_pangkat'];
      //~ $_SESSION['id_jabatan_pangkat_selanjutnya'] = $data[1]['id_jabatan_pangkat'];
      
      if($_SESSION['is_atasan'] == '1')
      {
        header("Location: $alamat_web/usulan");
      }
      
      // Cek level agar halaman di redirect sesuai aktor
      if($_SESSION['jenis_posisi'] == "Staff Kepegawaian" || $_SESSION['jenis_posisi'] == "Tim Penilai" || $_SESSION['jenis_posisi'] == "Pejabat Pengusul")
      {
        header("Location: $alamat_web/usulan");
      }
      else if($_SESSION['jenis_posisi'] == "Tenaga Kependidikan")
      {
        header("Location: $alamat_web/persyaratan");
      }
    }else{
      header("Location: $alamat_web/login?status=gagal");
    }
  }else{
    header("Location: $alamat_web/login");
  }
?>
