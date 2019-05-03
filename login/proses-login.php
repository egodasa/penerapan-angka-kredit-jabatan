<?
  session_start();
  require('../pengaturan/helper.php');
  require('../vendor/autoload.php');
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('../pengaturan/medoo.php');
    
    // Cek login pengguna
    $data = $db->query("SELECT 
                              a.*,
                              b.*,
                              c.*,
                              d.* 
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
      
      // Ambil data pangkat selanjutnya jika yang login tenaga kependidikan
      if($_SESSION['jenis_posisi'] == "Tenaga Kependidikan")
      {
        $sql = "SELECT
                  a.*,
                  b.*,
                  c.* 
                  FROM tbl_pangkat a 
                  JOIN tbl_jabatan b ON a.id_jabatan = b.id_jabatan 
                  JOIN tbl_posisi c ON b.id_jabatan = c.id_posisi WHERE a.peringkat > :peringkat LIMIT 1";
        $pangkat_selanjutnya = $db->query($sql, ['peringkat' => $_SESSION['peringkat']])->fetch();
        
        $_SESSION['peringkat_jabatan_sekarang'] = $_SESSION['peringkat'];
        $_SESSION['peringkat_jabatan_selanjutnya'] = $pangkat_selanjutnya['peringkat'];
        
        $_SESSION['id_pangkat_sekarang'] = $_SESSION['id_pangkat'];
        $_SESSION['id_pangkat_selanjutnya'] = $pangkat_selanjutnya['id_pangkat'];
        
        $_SESSION['angka_kredit_sekarang'] = $_SESSION['angka_kredit_minimal'];
        $_SESSION['angka_kredit_selanjutnya'] = $pangkat_selanjutnya['angka_kredit_minimal'];
        
        $_SESSION['nm_jabatan_sekarang'] = $_SESSION['nm_jabatan'];
        $_SESSION['nm_jabatan_selanjutnya'] = $pangkat_selanjutnya['nm_jabatan'];
        
        $_SESSION['nm_posisi_sekarang'] = $_SESSION['nm_posisi'];
        
        $_SESSION['nm_pangkat_sekarang'] = $_SESSION['nm_pangkat'];
        $_SESSION['nm_pangkat_selanjutnya'] = $pangkat_selanjutnya['nm_pangkat'];
        
      }
      
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
