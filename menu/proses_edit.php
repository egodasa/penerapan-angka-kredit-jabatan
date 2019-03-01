<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_menu'])){
    // Gambar hanya diupdate jika terisi
    if(isset($_FILES['gambar'])){
        // Ambil nama gambar lama untuk dihapus dari disk
        $query = $db->prepare("SELECT gambar FROM tbl_menu WHERE id_menu = :id_menu LIMIT 1");
        $query->bindParam("id_menu", $_POST['id_menu'], PDO::PARAM_INT);
        $query->execute();
        $gambar_lama = $query->fetch();
        unlink("../assets/img/produk/".$gambar_lama['gambar']);

        $file_tmp = $_FILES['gambar']['tmp_name'];
        $file_ext=strtolower(end(explode('.',$_FILES['gambar']['name'])));
        $nama_file = generateNumber().".".$file_ext;
        $lokasi_file = "../assets/img/produk/".$nama_file;
        move_uploaded_file($file_tmp, $lokasi_file);

        $query = $db->prepare("UPDATE tbl_menu SET gambar = :gambar WHERE id_menu = :id_menu");
        $query->bindParam("id_menu", $_POST['id_menu'], PDO::PARAM_INT);
        $query->bindParam("gambar", $nama_file);
        $query->execute();
    }
    $query = $db->prepare("UPDATE tbl_menu SET nama = :nama, id_kategori = :id_kategori, deskripsi = :deskripsi, harga = :harga WHERE id_menu = :id_menu");
    $query->bindParam("id_menu", $_POST['id_menu'], PDO::PARAM_INT);
    $query->bindParam("id_kategori", $_POST['id_kategori'], PDO::PARAM_INT);
    $query->bindParam("nama", $_POST['nama']);
    $query->bindParam("deskripsi", $_POST['deskripsi']);
    $query->bindParam("harga", $_POST['harga'], PDO::PARAM_INT);
    $query->execute();
}

// Arahkan menu ke halaman menu kembali
header("Location: $alamat_web/menu");
?>

