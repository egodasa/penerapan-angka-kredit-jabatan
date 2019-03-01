-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `tbl_berkas_penilaian`;
CREATE TABLE `tbl_berkas_penilaian` (
  `id_berkas_penilaian` int(11) NOT NULL AUTO_INCREMENT,
  `id_usulan` int(11) NOT NULL,
  `id_berkas` int(11) NOT NULL,
  `file` text,
  PRIMARY KEY (`id_berkas_penilaian`),
  KEY `id_usulan` (`id_usulan`),
  KEY `id_berkas` (`id_berkas`),
  CONSTRAINT `tbl_berkas_penilaian_ibfk_1` FOREIGN KEY (`id_usulan`) REFERENCES `tbl_usulan` (`id_usulan`) ON DELETE CASCADE,
  CONSTRAINT `tbl_berkas_penilaian_ibfk_2` FOREIGN KEY (`id_berkas`) REFERENCES `tbl_jenis_berkas` (`id_berkas`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_berkas_penilaian` (`id_berkas_penilaian`, `id_usulan`, `id_berkas`, `file`) VALUES
(1,	1,	1,	'270219072737004400.jpeg'),
(2,	1,	2,	'270219072742220500.jpeg'),
(3,	1,	3,	NULL),
(4,	1,	4,	NULL),
(5,	1,	5,	NULL),
(6,	1,	6,	NULL),
(7,	1,	7,	NULL),
(8,	1,	8,	NULL),
(9,	1,	9,	NULL),
(10,	1,	10,	NULL),
(11,	1,	11,	NULL),
(12,	1,	12,	NULL),
(13,	1,	13,	NULL),
(14,	1,	14,	NULL);

DROP TABLE IF EXISTS `tbl_detail_pesan`;
CREATE TABLE `tbl_detail_pesan` (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_pesan` varchar(50) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id_detail`),
  KEY `id_pesan` (`id_pesan`),
  KEY `id_menu` (`id_menu`),
  CONSTRAINT `tbl_detail_pesan_ibfk_1` FOREIGN KEY (`id_pesan`) REFERENCES `tbl_pesan` (`id_pesan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_detail_pesan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `tbl_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_detail_pesan` (`id_detail`, `id_pesan`, `id_menu`, `jumlah`) VALUES
(1,	'261218143618416800',	25,	1),
(2,	'030119091426062000',	17,	1),
(3,	'030119094431889500',	17,	1),
(4,	'030119094431889500',	18,	1),
(5,	'030119094431889500',	19,	1),
(6,	'030119214824000000',	2,	1);

DROP TABLE IF EXISTS `tbl_detail_pesan_tmp`;
CREATE TABLE `tbl_detail_pesan_tmp` (
  `id_tmp` int(11) NOT NULL AUTO_INCREMENT,
  `id_pesan` varchar(100) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id_tmp`),
  KEY `id_pesan` (`id_pesan`),
  KEY `id_menu` (`id_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_detail_pesan_tmp` (`id_tmp`, `id_pesan`, `id_menu`, `jumlah`) VALUES
(7,	'030119094543434600',	17,	1),
(14,	'030119152609660200',	2,	1);

DROP TABLE IF EXISTS `tbl_hasil_penilaian`;
CREATE TABLE `tbl_hasil_penilaian` (
  `id_hasil` int(11) NOT NULL AUTO_INCREMENT,
  `id_usulan` int(11) NOT NULL,
  `id_unsur` int(11) NOT NULL,
  `kredit` float NOT NULL,
  PRIMARY KEY (`id_hasil`),
  KEY `id_usulan` (`id_usulan`),
  CONSTRAINT `tbl_hasil_penilaian_ibfk_1` FOREIGN KEY (`id_usulan`) REFERENCES `tbl_usulan` (`id_usulan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_jabatan`;
CREATE TABLE `tbl_jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `nm_jabatan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_jabatan` (`id_jabatan`, `nm_jabatan`) VALUES
(1,	'Pustakawan Pelaksana'),
(2,	'Pustakawan Pelaksana Lanjutan'),
(3,	'Pustakawan Penyelia'),
(4,	'Staff Kepegawaian'),
(5,	'Tim Penilai');

DROP TABLE IF EXISTS `tbl_jabatan_pangkat`;
CREATE TABLE `tbl_jabatan_pangkat` (
  `id_jabatan_pangkat` int(11) NOT NULL AUTO_INCREMENT,
  `id_jabatan` int(11) NOT NULL,
  `id_pangkat` int(11) NOT NULL,
  `nilai_kredit` float NOT NULL,
  `peringkat` int(11) NOT NULL,
  PRIMARY KEY (`id_jabatan_pangkat`),
  KEY `id_jabatan` (`id_jabatan`),
  KEY `id_pangkat` (`id_pangkat`),
  CONSTRAINT `tbl_jabatan_pangkat_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `tbl_jabatan` (`id_jabatan`) ON DELETE CASCADE,
  CONSTRAINT `tbl_jabatan_pangkat_ibfk_2` FOREIGN KEY (`id_pangkat`) REFERENCES `tbl_pangkat` (`id_pangkat`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_jabatan_pangkat` (`id_jabatan_pangkat`, `id_jabatan`, `id_pangkat`, `nilai_kredit`, `peringkat`) VALUES
(1,	1,	1,	10,	10),
(2,	1,	2,	20,	20),
(3,	1,	3,	30,	30),
(4,	1,	4,	40,	40),
(5,	4,	13,	0,	0),
(6,	5,	14,	0,	0);

DROP TABLE IF EXISTS `tbl_jenis_berkas`;
CREATE TABLE `tbl_jenis_berkas` (
  `id_berkas` int(11) NOT NULL AUTO_INCREMENT,
  `nm_berkas` varchar(255) NOT NULL,
  PRIMARY KEY (`id_berkas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_jenis_berkas` (`id_berkas`, `nm_berkas`) VALUES
(1,	'KARPEG'),
(2,	'Pangkat Terakhir'),
(3,	'SK Jabatan Terakhir'),
(4,	'STTPP Diklat Fungsional'),
(5,	'PAK Terakhir'),
(6,	'Ijazah Terakhir'),
(7,	'Penilaian Prestasi Kerja 2thn terakhir'),
(8,	'SK Pegawai CPNS & PNS'),
(9,	'Surat Tugas'),
(10,	'Bukti Fisik Hasil Kegiatan'),
(11,	'Surat Pernyataan Melakukan Kegiatan'),
(12,	'Surat Pengantar dari Pejabat Pengusul'),
(13,	'DUPAK'),
(14,	'SPMK');

DROP TABLE IF EXISTS `tbl_kategori`;
CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nm_kategori` varchar(50) NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_kategori` (`id_kategori`, `nm_kategori`) VALUES
(1,	'Minuman'),
(2,	'Makanan');

DROP TABLE IF EXISTS `tbl_meja`;
CREATE TABLE `tbl_meja` (
  `id_meja` int(11) NOT NULL AUTO_INCREMENT,
  `nm_meja` varchar(10) NOT NULL,
  `kd_meja` varchar(10) NOT NULL,
  PRIMARY KEY (`id_meja`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_meja` (`id_meja`, `nm_meja`, `kd_meja`) VALUES
(2,	'Meja 1',	'12345'),
(3,	'Meja 2',	'43214'),
(4,	'Meja 3',	'02881'),
(5,	'Meja 4',	'00001'),
(6,	'Meja 5',	'27171'),
(7,	'Meja 6',	'38274'),
(8,	'Meja 7',	'31890'),
(9,	'Meja 8',	'48991'),
(10,	'Meja 9',	'49911'),
(11,	'Meja 10',	'48992'),
(12,	'Meja 11',	'31412'),
(13,	'Meja 12',	'129431'),
(14,	'Meja 13',	'83012'),
(15,	'Meja 14',	'12392'),
(16,	'Meja 15',	'M10A3'),
(17,	'Meja 16',	'KFC71'),
(18,	'Meja 17',	'F14A3'),
(19,	'Meja 18',	'A10F1'),
(20,	'Meja 19',	'19MJA'),
(21,	'Meja 20',	'MJA20');

DROP TABLE IF EXISTS `tbl_menu`;
CREATE TABLE `tbl_menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` int(11) NOT NULL,
  `gambar` text NOT NULL,
  PRIMARY KEY (`id_menu`),
  KEY `id_kategori` (`id_kategori`),
  CONSTRAINT `tbl_menu_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_menu` (`id_menu`, `nama`, `id_kategori`, `deskripsi`, `harga`, `gambar`) VALUES
(2,	'Ayam Bakar Paha',	2,	'Ayam Bakar Paha',	12000,	'261218133248164100.jpg'),
(3,	'Ayam Bakar Paha + Nasi',	2,	'Ayam Bakar Paha + Nasi',	18000,	'261218133321640800.jpg'),
(4,	'Ayam Bakar Dada',	2,	'Ayam Bakar Dada',	14000,	'261218133452780400.jpg'),
(5,	'Ayam Bakar Dada + Nasi',	2,	'Ayam Bakar Dada + Nasi',	20000,	'261218133554922700.jpg'),
(6,	'Ayam Penyet Dada',	2,	'Ayam Penyet Dada',	13000,	'261218133719425800.jpg'),
(7,	'Ayam Penyet Dada + Nasi',	2,	'Ayam Penyet Dada + Nasi',	18000,	'261218133810417600.jpg'),
(8,	'Ayam Penyet Paha',	2,	'Ayam Penyet Paha',	12000,	'261218134045165500.jpg'),
(9,	'Ayam Penyet Paha + Nasi',	2,	'Ayam Penyet Paha + Nasi',	18000,	'261218134107521100.jpg'),
(10,	'Ikan Bakar',	2,	'Ikan bakar',	13000,	'261218134927690600.jpg'),
(11,	'Ikan Bakar + Nasi',	2,	'Ikan bakar + nasi',	18000,	'261218134956037400.jpg'),
(12,	'Pecel Lele',	2,	'Pecel lele',	14000,	'261218135014643800.jpg'),
(13,	'Pecel Lele + Nasi',	2,	'Pecel lele + nasi',	20000,	'261218135039819600.jpg'),
(14,	'Cah Kangkung',	2,	'Cah kangkung',	6000,	'261218135108255000.jpg'),
(15,	'Soto',	2,	'Soto',	15000,	'261218135129908800.jpg'),
(16,	'Soto Nasi',	2,	'Soto nasi',	18000,	'261218135148928400.jpg'),
(17,	'Teh Tarik Es',	1,	'Teh Tarik Es',	7000,	'261218140206423200.jpg'),
(18,	'Teh Tarik Panas',	1,	'Teh Tarik Panas',	7000,	'261218140229338000.jpg'),
(19,	'Teh Telur',	1,	'Teh Telur',	10000,	'261218140251429900.jpg'),
(20,	'Jus Pokat',	1,	'Jus pokat',	10000,	'261218140313996200.jpg'),
(21,	'Jus Mangga',	1,	'Jus mangga',	12000,	'261218140335227600.jpg'),
(22,	'Jus Tomat',	1,	'Jus Tomat',	7000,	'261218140401818600.jpg'),
(23,	'Jus Timun',	1,	'Jus Timun',	7000,	'261218140457541300.jpg'),
(24,	'Jus Jeruk',	1,	'Jus Jeruk',	10000,	'261218140523228000.jpg'),
(25,	'Teh Es',	1,	'Teh es',	5000,	'261218140548237500.jpg'),
(26,	'Kopi Es',	1,	'Kopi Es',	6000,	'261218140618621800.jpg'),
(27,	'Kopi Panas',	1,	'Kopi Panas',	5000,	'261218140640904300.jpg'),
(28,	'Kopi Susu',	1,	'Kopi Susu',	6000,	'261218140701948800.jpg'),
(29,	'Kopi Susu Es',	1,	'Kopi Susu Es',	7000,	'261218140731522100.jpg'),
(30,	'Teh Susu',	1,	'Teh Susu',	6000,	'261218142046035900.jpg'),
(31,	'Teh Susu Es',	1,	'Teh Susu Es',	7000,	'261218142134178000.jpg'),
(32,	'Susu Panas',	1,	'Susu Panas',	5000,	'261218142157815600.jpg'),
(33,	'Susu Es',	1,	'Susu Es',	7000,	'261218142221418500.jpg'),
(34,	'Jeruk Panas',	1,	'Jeruk Panas',	10000,	'261218142247016300.jpg'),
(35,	'Cappucino Es',	1,	'Cappucino Es',	7000,	'261218142308960700.jpg'),
(36,	'Cappucino Panas',	1,	'Cappucino Panas',	6000,	'261218142331682000.jpg'),
(37,	'Es Lemon Tea',	1,	'Es Lemon Tea',	7000,	'261218142357524400.jpg'),
(38,	'Susu Extra Joss',	1,	'Susu Extra Joss',	7000,	'261218142416654300.jpg'),
(39,	'Jus Naga',	1,	'Jus Naga',	10000,	'261218142440188200.jpg'),
(40,	'Jus Terong Pirus',	1,	'Jus Terong Pirus',	10000,	'261218142500222500.jpg'),
(41,	'Jeruk Nipis Es',	1,	'Jeruk Nipis Es',	7000,	'261218142517672900.jpg'),
(42,	'Jus Sirsak',	1,	'Jus Sirsak',	10000,	'261218142539952800.jpg'),
(43,	'Jus Melon',	1,	'Jus Melon',	100000,	'261218142600847000.jpg'),
(44,	'Jus Nenas',	1,	'Jus Nenas',	10000,	'261218142622119300.jpg'),
(45,	'Jus Apel',	1,	'Jus Apel',	12000,	'261218142643529100.jpg'),
(46,	'Jus Pepaya',	1,	'Jus Pepaya',	10000,	'261218142702793900.jpg'),
(47,	'Jus Bengkuang',	1,	'Jus Bengkuang',	100000,	'261218142721594700.jpg');

DROP TABLE IF EXISTS `tbl_pangkat`;
CREATE TABLE `tbl_pangkat` (
  `id_pangkat` int(11) NOT NULL AUTO_INCREMENT,
  `nm_pangkat` varchar(100) NOT NULL,
  PRIMARY KEY (`id_pangkat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_pangkat` (`id_pangkat`, `nm_pangkat`) VALUES
(1,	'II/a'),
(2,	'Pengatur Muda Tingkat I (II/b)'),
(3,	'Pengatur (II/c)'),
(4,	'II/d'),
(5,	'III/a'),
(6,	'III/b'),
(7,	'III/c'),
(8,	'III/d'),
(9,	'IV/a'),
(10,	'IV/b'),
(11,	'IV/c'),
(12,	'IV/d'),
(13,	'Staff Kepegawaian IV/a'),
(14,	'Tim Penilai IV/a');

DROP TABLE IF EXISTS `tbl_pegawai`;
CREATE TABLE `tbl_pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `no_karpeg` varchar(50) NOT NULL,
  `nm_lengkap` varchar(100) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `pendidikan` varchar(50) NOT NULL,
  `tgl_lulus` date NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `id_jabatan_pangkat` int(11) NOT NULL,
  `id_posisi` int(11) NOT NULL,
  `foto` text,
  `kredit_awal` float NOT NULL DEFAULT '0',
  `tmt_jabatan` date NOT NULL,
  PRIMARY KEY (`id_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_pegawai` (`id_pegawai`, `nip`, `password`, `no_karpeg`, `nm_lengkap`, `tempat_lahir`, `tgl_lahir`, `email`, `nohp`, `pendidikan`, `tgl_lulus`, `jk`, `id_jabatan_pangkat`, `id_posisi`, `foto`, `kredit_awal`, `tmt_jabatan`) VALUES
(4,	'12345',	'827ccb0eea8a706c4c34a16891f84e7b',	'12345',	'Saya',	'Padang',	'2012-10-10',	'email@mail.com',	'08123456789',	'Sarjana (S1)/Diploma IV',	'2019-02-01',	'Laki-laki',	5,	5,	'240219125752884600.png',	0,	'2019-02-25'),
(5,	'11111',	'b0baee9d279d34fa1dfd71aadb908c3f',	'11111',	'11111',	'padang',	'2010-10-10',	'siswa@mail.com',	'12345',	'Sarjana (S1)/Diploma IV',	'2019-02-01',	'Laki-laki',	1,	4,	'240219124048061500.png',	20,	'2019-02-06'),
(6,	'22222',	'3d2172418ce305c7d16d4b05597c6a59',	'22222',	'22222',	'padang',	'2019-10-10',	'duqe@mailinator.com',	'1213212321',	'Sarjana (S1)/Diploma IV',	'0000-00-00',	'Laki-laki',	4,	0,	'240219123955716800.png',	0,	'0000-00-00'),
(7,	'98765',	'c37bf859faf392800d739a41fe5af151',	'N. 98765',	'Tim Penilai',	'Padang',	'2003-04-04',	'tim@pegawai.com',	'089876544321',	'Sarjana (S1)/Diploma IV',	'2019-02-06',	'Laki-laki',	6,	6,	'270219091105546300.jpeg',	0,	'2019-02-04');

DROP TABLE IF EXISTS `tbl_pesan`;
CREATE TABLE `tbl_pesan` (
  `id_pesan` varchar(50) NOT NULL,
  `tanggal_pesan` datetime NOT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `status_pesanan` enum('Belum Dibayar','Sudah Dibayar','Hidangan Sedang Disiapkan','Hidangan Sudah Siap') NOT NULL DEFAULT 'Belum Dibayar',
  `id_meja` int(11) NOT NULL,
  `dibayar` int(11) NOT NULL DEFAULT '0',
  `kembalian` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pesan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_pesan` (`id_pesan`, `tanggal_pesan`, `nama_pemesan`, `status_pesanan`, `id_meja`, `dibayar`, `kembalian`) VALUES
('030119091426062000',	'2019-01-03 16:22:23',	'Mai',	'Sudah Dibayar',	5,	50000,	43000),
('030119094431889500',	'2019-01-03 16:45:43',	'ajo',	'Hidangan Sudah Siap',	2,	120000,	96000),
('030119214824000000',	'2019-01-03 21:50:40',	'Budiman',	'Belum Dibayar',	2,	0,	0),
('261218143618416800',	'2018-12-26 21:42:51',	'Mai',	'',	2,	6000,	1000);

DROP TABLE IF EXISTS `tbl_posisi`;
CREATE TABLE `tbl_posisi` (
  `id_posisi` int(11) NOT NULL AUTO_INCREMENT,
  `nm_posisi` varchar(255) NOT NULL,
  `jenis_posisi` enum('Tenaga Kependidikan','Staff Kepegawaian','Tim Penilai') NOT NULL,
  PRIMARY KEY (`id_posisi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_posisi` (`id_posisi`, `nm_posisi`, `jenis_posisi`) VALUES
(2,	'Arsiparis',	'Tenaga Kependidikan'),
(3,	'Pranata Laboratorium Pendidikan',	'Tenaga Kependidikan'),
(4,	'Pustakawan',	'Tenaga Kependidikan'),
(5,	'Admin',	'Staff Kepegawaian'),
(6,	'Tim Penilai',	'Tim Penilai');

DROP TABLE IF EXISTS `tbl_unsur`;
CREATE TABLE `tbl_unsur` (
  `id_unsur` int(11) NOT NULL AUTO_INCREMENT,
  `nm_unsur` varchar(255) NOT NULL,
  `id_posisi` int(11) NOT NULL,
  `jenis_unsur` enum('Unsur Utama','Unsur Penunjang') NOT NULL,
  `kategori_unsur` enum('Pendidikan','Tugas Pokok','Pengembangan Profesi') NOT NULL DEFAULT 'Tugas Pokok',
  PRIMARY KEY (`id_unsur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_unsur` (`id_unsur`, `nm_unsur`, `id_posisi`, `jenis_unsur`, `kategori_unsur`) VALUES
(2,	'Pengelolaan Perpustakaan',	4,	'Unsur Utama',	'Tugas Pokok'),
(3,	'Pelayanan Perpustakaan',	4,	'Unsur Utama',	'Tugas Pokok'),
(4,	'Pengembangan Sistem Kepustakawanan',	4,	'Unsur Utama',	'Tugas Pokok'),
(5,	'Pengembangan Profesi',	4,	'Unsur Utama',	'Pengembangan Profesi'),
(6,	'Pengajaran/pelatihan pada diklat fungsional/teknis di bidang kepustakawanan',	4,	'Unsur Penunjang',	'Pengembangan Profesi'),
(8,	'Keanggotaan dalam organisasi profesi',	4,	'Unsur Penunjang',	'Pengembangan Profesi'),
(9,	'Keanggotaan dalam tim penilai',	4,	'Unsur Penunjang',	'Tugas Pokok'),
(10,	'Perolehan penghargaan/tanda jasa dan perolehan gelar kesarjanaan lainnya',	4,	'Unsur Penunjang',	'Pendidikan'),
(11,	'Pendidikan',	4,	'Unsur Utama',	'Pendidikan'),
(12,	'Pendidikan',	2,	'Unsur Utama',	'Pendidikan'),
(13,	'Pengelolaan Arsip',	2,	'Unsur Utama',	'Tugas Pokok'),
(14,	'Pembinaan Kearsipan',	2,	'Unsur Utama',	'Tugas Pokok'),
(15,	'Pengembangan Profesi',	2,	'Unsur Utama',	'Tugas Pokok'),
(16,	'Pengelolaan/pelatihan di bidang kearsipan',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(17,	'Mengikuti bimbingan di bidang kearsipan',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(18,	'Peran serta dalam seminar/lokakarya di bidang kearsipan',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(19,	'Keanggotaan dalam organisasi profesi',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(20,	'Keanggotaan dalam tim penilai',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(21,	'Perolehan gelar kesarjanaan lainnya',	2,	'Unsur Penunjang',	'Tugas Pokok');

DROP TABLE IF EXISTS `tbl_usulan`;
CREATE TABLE `tbl_usulan` (
  `id_usulan` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_usulan` date NOT NULL,
  `status_proses` varchar(30) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `nip` varchar(20) NOT NULL,
  `masa_penilaian_awal` date NOT NULL,
  `masa_penilaian_akhir` date NOT NULL,
  `tgl_penyesuaian` date DEFAULT NULL,
  `id_jabatan_pangkat_selanjutnya` int(11) NOT NULL,
  `id_jabatan_pangkat_sekarang` int(11) NOT NULL,
  `masa_kerja_golongan_lama` varchar(100) NOT NULL,
  `masa_kerja_golongan_baru` varchar(100) NOT NULL,
  PRIMARY KEY (`id_usulan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_usulan` (`id_usulan`, `tgl_usulan`, `status_proses`, `keterangan`, `nip`, `masa_penilaian_awal`, `masa_penilaian_akhir`, `tgl_penyesuaian`, `id_jabatan_pangkat_selanjutnya`, `id_jabatan_pangkat_sekarang`, `masa_kerja_golongan_lama`, `masa_kerja_golongan_baru`) VALUES
(1,	'2019-02-02',	'Angka Kredit Ditolak',	'Data tidak sesuai',	'11111',	'2019-03-02',	'2019-07-02',	NULL,	3,	2,	'1 tahun',	'2 tahun');

DROP TABLE IF EXISTS `tbl_usulan_unsur`;
CREATE TABLE `tbl_usulan_unsur` (
  `id_usulan_unsur` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_mulai_kegiatan` date NOT NULL,
  `tgl_selesai_kegiatan` date NOT NULL,
  `butir_kegiatan` text NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `angka_kredit` float NOT NULL,
  `angka_kredit_baru` float NOT NULL DEFAULT '0',
  `tempat` varchar(30) NOT NULL,
  `id_usulan` int(11) NOT NULL,
  `tingkat_kesulitan` varchar(30) NOT NULL,
  `jumlah_volume_kegiatan` int(11) NOT NULL,
  `id_unsur` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `bukti_kegiatan` text NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_usulan_unsur`),
  KEY `id_usulan` (`id_usulan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_usulan_unsur` (`id_usulan_unsur`, `tgl_mulai_kegiatan`, `tgl_selesai_kegiatan`, `butir_kegiatan`, `satuan`, `angka_kredit`, `angka_kredit_baru`, `tempat`, `id_usulan`, `tingkat_kesulitan`, `jumlah_volume_kegiatan`, `id_unsur`, `status`, `bukti_kegiatan`, `keterangan`) VALUES
(3,	'2018-07-01',	'2019-02-01',	'Mengelola perpustakaan Besar',	'Hari',	10,	0,	'Perpustakaan',	1,	'Susah',	130,	2,	NULL,	'270219020746080800.jpeg',	''),
(4,	'2019-02-02',	'2019-02-04',	'Mengikuti seminar kepustakawan',	'hari',	0.5,	0,	'Padang Panjang',	1,	'Lumayan',	24,	6,	NULL,	'270219021008729000.jpg',	''),
(5,	'2014-02-01',	'2017-02-01',	'Mengikuti pendidikan S1',	'Hari',	15,	0,	'Surabaya',	1,	'Susah',	768,	10,	NULL,	'270219021121265200.jpeg',	'');

-- 2019-02-27 09:22:25
