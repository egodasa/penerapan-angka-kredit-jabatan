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
(1,	1,	1,	'140319185231571700.jpg'),
(2,	1,	2,	'140319185242530300.jpg'),
(3,	1,	3,	NULL),
(5,	1,	5,	NULL),
(6,	1,	6,	NULL),
(7,	1,	7,	NULL),
(11,	1,	11,	NULL),
(12,	1,	12,	NULL),
(13,	1,	13,	NULL),
(15,	2,	1,	'010319184139631500.jpg'),
(16,	2,	2,	'010319184207909500.jpg'),
(17,	2,	3,	'010319184244520900.png'),
(19,	2,	5,	'140319180039360600.jpg'),
(20,	2,	6,	'140319180056355300.jpg'),
(21,	2,	7,	'140319180115988600.png'),
(25,	2,	11,	NULL),
(26,	2,	12,	NULL),
(27,	2,	13,	NULL),
(28,	1,	1,	NULL),
(29,	1,	2,	'090319014303965600.jpg'),
(30,	1,	3,	NULL),
(32,	1,	5,	NULL),
(33,	1,	6,	NULL),
(34,	1,	7,	NULL),
(38,	1,	11,	NULL),
(39,	1,	12,	NULL),
(40,	1,	13,	NULL),
(41,	2,	1,	NULL),
(42,	2,	2,	NULL),
(43,	2,	3,	NULL),
(45,	2,	5,	NULL),
(46,	2,	6,	NULL),
(47,	2,	7,	NULL),
(51,	2,	11,	NULL),
(52,	2,	12,	NULL),
(53,	2,	13,	NULL),
(56,	3,	1,	NULL),
(57,	3,	2,	NULL),
(58,	3,	3,	NULL),
(60,	3,	5,	NULL),
(61,	3,	6,	NULL),
(62,	3,	7,	NULL),
(66,	3,	11,	NULL),
(67,	3,	12,	NULL),
(68,	3,	13,	NULL),
(69,	4,	1,	NULL),
(70,	4,	2,	NULL),
(71,	4,	3,	NULL),
(73,	4,	5,	NULL),
(74,	4,	6,	NULL),
(75,	4,	7,	NULL),
(79,	4,	11,	NULL),
(80,	4,	12,	NULL),
(81,	4,	13,	NULL),
(84,	5,	1,	'240319021628806700.jpg'),
(85,	5,	2,	'240319021650288400.jpg'),
(86,	5,	3,	'240319021716737800.jpg'),
(87,	5,	5,	'240319021948339600.jpg'),
(88,	5,	6,	'240319022315706900.png'),
(89,	5,	7,	'240319022650487800.jpg'),
(90,	5,	11,	NULL),
(91,	5,	12,	NULL),
(92,	5,	13,	NULL),
(93,	6,	1,	'250319045505763800.pdf'),
(94,	6,	2,	'250319045616919100.pdf'),
(95,	6,	3,	'250319045708929400.pdf'),
(96,	6,	5,	NULL),
(97,	6,	6,	'250319045736694900.pdf'),
(98,	6,	7,	NULL),
(99,	6,	11,	NULL),
(100,	6,	12,	NULL),
(101,	6,	13,	NULL),
(102,	7,	1,	NULL),
(103,	7,	2,	NULL),
(104,	7,	3,	NULL),
(105,	7,	5,	NULL),
(106,	7,	6,	NULL),
(107,	7,	7,	NULL),
(108,	7,	11,	NULL),
(109,	7,	12,	NULL),
(110,	7,	13,	NULL),
(117,	8,	1,	NULL),
(118,	8,	2,	NULL),
(119,	8,	3,	NULL),
(120,	8,	5,	NULL),
(121,	8,	6,	NULL),
(122,	8,	7,	NULL),
(123,	8,	11,	NULL),
(124,	8,	12,	NULL),
(125,	8,	13,	NULL);

DROP TABLE IF EXISTS `tbl_butir_kegiatan`;
CREATE TABLE `tbl_butir_kegiatan` (
  `id_butir` int(11) NOT NULL AUTO_INCREMENT,
  `id_sub_unsur` int(11) NOT NULL,
  `butir_kegiatan` text NOT NULL,
  `satuan` varchar(100) NOT NULL,
  `angka_kredit` float NOT NULL,
  PRIMARY KEY (`id_butir`),
  KEY `id_sub_unsur` (`id_sub_unsur`),
  CONSTRAINT `tbl_butir_kegiatan_ibfk_1` FOREIGN KEY (`id_sub_unsur`) REFERENCES `tbl_sub_unsur` (`id_sub_unsur`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_butir_kegiatan` (`id_butir`, `id_sub_unsur`, `butir_kegiatan`, `satuan`, `angka_kredit`) VALUES
(2,	12,	'Kegiatan',	'Eksampler',	1.2);

DROP TABLE IF EXISTS `tbl_jabatan`;
CREATE TABLE `tbl_jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `nm_jabatan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_jabatan` (`id_jabatan`, `nm_jabatan`) VALUES
(1,	'Pustakawan Terampil'),
(2,	'Pustakawan Mahir'),
(3,	' Pustakawan Penyelia'),
(4,	'Staff Kepegawaian'),
(5,	'Tim Penilai'),
(6,	'Pustakawan Ahli Pertama'),
(7,	'Pustakawan Ahli Muda'),
(8,	'Pustakawan Ahli Madya'),
(9,	'Pustakawan Ahli Utama'),
(24,	'Admin'),
(25,	'PLP Terampil'),
(26,	'PLP Mahir'),
(27,	'PLP Penyelia'),
(28,	'PLP Ahli Pertama'),
(29,	'PLP Ahli Muda'),
(30,	'PLP Ahli Madya'),
(31,	'PLP Ahli Utama'),
(32,	'Arsiparis Terampil'),
(33,	'Arsiparis Mahir'),
(34,	'Arsiparis Penyelia'),
(35,	'Arsiparis Ahli Pertama'),
(36,	'Arsiparis Ahli Muda'),
(37,	'Arsiparis Ahli Madya'),
(38,	'Arsiparis Ahli Utama'),
(39,	'Kepala UPT Perpustakaan Pusat'),
(40,	'Pustakawan Yang Bersangkutan');

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
(1,	1,	1,	30,	30),
(2,	1,	2,	40,	40),
(3,	1,	3,	60,	60),
(4,	1,	4,	80,	80),
(5,	4,	13,	0,	0),
(6,	5,	14,	0,	0),
(22,	2,	5,	100,	100),
(23,	2,	6,	150,	150),
(24,	3,	7,	200,	200),
(25,	3,	8,	300,	300),
(26,	6,	5,	100,	100),
(27,	6,	6,	150,	150),
(28,	7,	7,	200,	200),
(29,	7,	8,	300,	300),
(30,	8,	9,	400,	400),
(31,	8,	10,	550,	550),
(32,	8,	11,	700,	700),
(33,	9,	12,	850,	850),
(34,	9,	15,	1050,	1050),
(35,	39,	16,	0,	0);

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
(5,	'PAK Terakhir'),
(6,	'Ijazah Terakhir'),
(7,	'Penilaian Prestasi Kerja 2thn terakhir'),
(11,	'Surat Pernyataan Melakukan Kegiatan'),
(12,	'Surat Pengantar dari Pejabat Pengusul'),
(13,	'DUPAK');

DROP TABLE IF EXISTS `tbl_pangkat`;
CREATE TABLE `tbl_pangkat` (
  `id_pangkat` int(11) NOT NULL AUTO_INCREMENT,
  `nm_pangkat` varchar(100) NOT NULL,
  PRIMARY KEY (`id_pangkat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_pangkat` (`id_pangkat`, `nm_pangkat`) VALUES
(1,	'Pengatur Muda (II/a)'),
(2,	'Pengatur Muda Tingkat I (II/b)'),
(3,	'Pengatur (II/c)'),
(4,	'Pengatur Tingkat I (II/d)'),
(5,	'Penata Muda (III/a)'),
(6,	'Penata Muda Tingkat I (III/b)'),
(7,	'Penata (III/c)'),
(8,	'Penata Tingkat I (III/d)'),
(9,	'Pembina (IV/a)'),
(10,	'Pembina Tingkat I (IV/b)'),
(11,	'Pembina Utama Muda (IV/c)'),
(12,	'Pembina Utama Madya (IV/d)'),
(13,	'Staff Kepegawaian (IV/a)'),
(14,	'Tim Penilai (IV/a)'),
(15,	'Pembina Utama (IV/e)'),
(16,	'Pejabat pengusul');

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
  `id_unit_kerja` int(11) NOT NULL,
  `foto` text,
  `kredit_awal_utama` float NOT NULL DEFAULT '0',
  `kredit_awal_penunjang` float NOT NULL,
  `tmt_jabatan` date NOT NULL,
  PRIMARY KEY (`id_pegawai`),
  KEY `id_jabatan_pangkat` (`id_jabatan_pangkat`),
  KEY `id_unit_kerja` (`id_unit_kerja`),
  CONSTRAINT `tbl_pegawai_ibfk_1` FOREIGN KEY (`id_jabatan_pangkat`) REFERENCES `tbl_jabatan_pangkat` (`id_jabatan_pangkat`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_pegawai_ibfk_2` FOREIGN KEY (`id_unit_kerja`) REFERENCES `tbl_unit_kerja` (`id_unit_kerja`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_pegawai` (`id_pegawai`, `nip`, `password`, `no_karpeg`, `nm_lengkap`, `tempat_lahir`, `tgl_lahir`, `email`, `nohp`, `pendidikan`, `tgl_lulus`, `jk`, `id_jabatan_pangkat`, `id_unit_kerja`, `foto`, `kredit_awal_utama`, `kredit_awal_penunjang`, `tmt_jabatan`) VALUES
(4,	'12345',	'827ccb0eea8a706c4c34a16891f84e7b',	'N. 12345',	'Pejabat Pengusul',	'Padang',	'2012-10-10',	'email@mail.com',	'08123456789',	'Sarjana (S1)/Diploma IV',	'2019-02-01',	'Laki-laki',	5,	17,	'140319172209931200.png',	0,	0,	'2019-02-25'),
(5,	'11111',	'b0baee9d279d34fa1dfd71aadb908c3f',	'11111',	'Pustakawan',	'padang',	'1980-10-10',	'pustakawan@gmail.com',	'089512345',	'Sarjana (S1)/Diploma IV',	'2019-02-01',	'Perempuan',	23,	1,	'010319181639087600.jpg',	68.3443,	17.0861,	'2019-02-06'),
(7,	'98765',	'c37bf859faf392800d739a41fe5af151',	'N. 98765',	'Tim Penilai',	'Padang',	'2003-04-04',	'tim@pegawai.com',	'089876544321',	'Sarjana (S1)/Diploma IV',	'2019-02-06',	'Laki-laki',	6,	23,	'140319172258255400.png',	0,	0,	'2019-02-04'),
(8,	'77777',	'22a4d9b04fe95c9893b41e2fde83a427',	'N. 1234',	'Pejabat Pengusul',	'padang',	'1995-10-10',	'pejabatpengusul@gmail.com',	'087777777777',	'Sarjana (S1)/Diploma IV',	'2019-02-01',	'Laki-laki',	33,	1,	'010319183004572200.jpg',	0,	0,	'2019-02-07'),
(9,	'197510172001122002',	'a386c7c329ce38ff6af74159a6f23dca',	'L.043398',	'Zasmi Fitriani, A.Md',	'Padang',	'1975-10-17',	'zasmifitriani@gmail.com',	'08527412345',	'Sarjana (S1)/Diploma IV',	'1994-04-04',	'Perempuan',	3,	1,	'010319175612772500.jpg',	110,	56,	'2013-08-01'),
(10,	'123456789',	'25f9e794323b453885f5181f1b624d0b',	'N. 123456789',	'Staff Kepegawaian',	'Padang',	'1995-03-01',	'egodasa@gmail.com',	'081266838995',	'Sarjana (S1)/Diploma IV',	'2002-03-25',	'Laki-laki',	5,	17,	'140319172409695500.png',	0,	0,	'2010-10-10'),
(11,	'197811032008102001',	'308d787c529a38e53297c0a177b35cea',	'N. 541906',	'NANI, S.I.Pust',	'Padang',	'1978-11-03',	'nani78@yahoo.com',	'081274332567',	'Sarjana (S1)/Diploma IV',	'2015-04-01',	'Perempuan',	4,	1,	'220319040235347600.jpg',	68.3443,	17.0861,	'2015-04-01'),
(12,	'196408151986031004',	'fa10c081a4d9a01599098745d714fe5b',	'N. 12345',	'Drs.Yasir, S.Sos',	'Padang',	'1964-08-15',	'yasir64@gmail.com',	'081234567811',	'Sarjana (S1)/Diploma IV',	'1981-03-06',	'Laki-laki',	35,	1,	'220319071110693800.jpg',	0,	0,	'1986-03-06');

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
(5,	'Staff Kepegawaian',	'Staff Kepegawaian'),
(6,	'Tim Penilai',	'Tim Penilai'),
(7,	'admin',	''),
(8,	'Pejabat Pengusul',	'Tim Penilai');

DROP TABLE IF EXISTS `tbl_sub_unsur`;
CREATE TABLE `tbl_sub_unsur` (
  `id_sub_unsur` int(11) NOT NULL AUTO_INCREMENT,
  `nm_unsur` varchar(255) NOT NULL,
  `id_posisi` int(11) NOT NULL,
  `jenis_unsur` enum('Unsur Utama','Unsur Penunjang') NOT NULL,
  `kategori_unsur` enum('Pendidikan','Tugas Pokok','Pengembangan Profesi') NOT NULL DEFAULT 'Tugas Pokok',
  PRIMARY KEY (`id_sub_unsur`),
  KEY `id_posisi` (`id_posisi`),
  CONSTRAINT `tbl_sub_unsur_ibfk_1` FOREIGN KEY (`id_posisi`) REFERENCES `tbl_posisi` (`id_posisi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_sub_unsur` (`id_sub_unsur`, `nm_unsur`, `id_posisi`, `jenis_unsur`, `kategori_unsur`) VALUES
(2,	'Pengelolaan Perpustakaan',	4,	'Unsur Utama',	'Tugas Pokok'),
(3,	'Pelayanan Perpustakaan',	4,	'Unsur Utama',	'Tugas Pokok'),
(4,	'Pengembangan Sistem Kepustakawanan',	4,	'Unsur Utama',	'Tugas Pokok'),
(5,	'Pengembangan Profesi',	4,	'Unsur Utama',	'Pengembangan Profesi'),
(6,	'Pengajaran/pelatihan pada diklat fungsional/teknis di bidang kepustakawanan',	4,	'Unsur Penunjang',	'Pengembangan Profesi'),
(8,	'Keanggotaan dalam organisasi profesi',	4,	'Unsur Penunjang',	'Pengembangan Profesi'),
(9,	'Keanggotaan dalam tim penilai',	4,	'Unsur Penunjang',	'Tugas Pokok'),
(10,	'Perolehan penghargaan/tanda jasa ',	4,	'Unsur Penunjang',	'Pendidikan'),
(11,	'Pendidikan',	4,	'Unsur Utama',	'Pendidikan'),
(12,	'Pendidikan',	2,	'Unsur Utama',	'Pendidikan'),
(13,	'Pengelolaan Arsip',	2,	'Unsur Utama',	'Tugas Pokok'),
(14,	'Pembinaan Kearsipan',	2,	'Unsur Utama',	'Tugas Pokok'),
(15,	'Pengembangan Profesi',	2,	'Unsur Utama',	'Pengembangan Profesi'),
(16,	'Pengelolaan/pelatihan di bidang kearsipan',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(17,	'Mengikuti bimbingan di bidang kearsipan',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(18,	'Peran serta dalam seminar/lokakarya di bidang kearsipan',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(19,	'Keanggotaan dalam organisasi profesi',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(20,	'Keanggotaan dalam tim penilai',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(21,	'Perolehan gelar kesarjanaan lainnya',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(22,	'Pendidikan',	3,	'Unsur Utama',	'Pendidikan'),
(23,	'Perancangan Kegiatan Laboratorium',	3,	'Unsur Utama',	'Tugas Pokok'),
(24,	'Pengoperasian Peralatan dan Penggunaan Bahan',	3,	'Unsur Utama',	'Tugas Pokok'),
(25,	'Pengevaluasian Sistem Kerja Laboratorium',	3,	'Unsur Utama',	'Tugas Pokok'),
(26,	'Pengembangan Kegiatan Laboratorium',	3,	'Unsur Utama',	'Tugas Pokok'),
(27,	'Pengembangan Profesi',	3,	'Unsur Utama',	'Pengembangan Profesi'),
(28,	'Pengelolaan/Pelatihan di bidang laboratorium',	3,	'Unsur Penunjang',	'Tugas Pokok'),
(29,	'Mengikuti bimbingan di bidang laboratorium',	3,	'Unsur Penunjang',	'Tugas Pokok'),
(30,	'Peran serta dalam seminar/lokakarya di bidang laboratorium',	3,	'Unsur Penunjang',	'Tugas Pokok'),
(31,	'Keanggotaan dalam organisasi profesi',	3,	'Unsur Penunjang',	'Tugas Pokok'),
(32,	'Keanggotaan dalam tim penilai',	3,	'Unsur Penunjang',	'Tugas Pokok'),
(33,	'Perolehan gelar kesarjanaan lainnya',	3,	'Unsur Penunjang',	'Tugas Pokok'),
(34,	'Perolehan gelar kesarjanaan lainnya',	4,	'Unsur Penunjang',	'Pendidikan'),
(35,	'Peran serta dalam seminar/lokakarya/ konferensi di bidang kepustakawanan',	4,	'Unsur Penunjang',	'Tugas Pokok');

DROP TABLE IF EXISTS `tbl_unit_kerja`;
CREATE TABLE `tbl_unit_kerja` (
  `id_unit_kerja` int(11) NOT NULL AUTO_INCREMENT,
  `nm_unit_kerja` varchar(100) NOT NULL,
  `nip_atasan` varchar(20) NOT NULL,
  `id_posisi` int(11) NOT NULL,
  PRIMARY KEY (`id_unit_kerja`),
  KEY `id_posisi` (`id_posisi`),
  CONSTRAINT `tbl_unit_kerja_ibfk_1` FOREIGN KEY (`id_posisi`) REFERENCES `tbl_posisi` (`id_posisi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_unit_kerja` (`id_unit_kerja`, `nm_unit_kerja`, `nip_atasan`, `id_posisi`) VALUES
(1,	'UPT Perpustakaan Pusat',	'196408151986031004',	4),
(2,	'Ekonomi',	'12345',	4),
(3,	'Hukum',	'12345',	4),
(4,	'Pasca Sarjana',	'12345',	4),
(5,	'Tata Usaha',	'12345',	2),
(6,	'Kepegawaian dan HKTL',	'12345',	2),
(7,	'Farmasi',	'12345',	2),
(8,	'Ilmu Budaya',	'12345',	2),
(9,	'Kedokteran',	'12345',	2),
(10,	'Keperawatan',	'12345',	2),
(11,	'Rektorat',	'12345',	2),
(12,	'Ekonomi',	'12345',	2),
(13,	'Pasca Sarjana',	'12345',	2),
(15,	'MIPA',	'12345',	3),
(16,	'Pertanian',	'12345',	3),
(17,	'Rektorat',	'12345',	5),
(18,	'Teknik ',	'12345',	3),
(19,	'Teknologi Pertanian',	'12345',	3),
(20,	'Ekonomi',	'12345',	3),
(21,	'Farmasi',	'12345',	3),
(22,	'Kedokteran',	'12345',	3),
(23,	'Rektorat',	'98765',	6);

DROP TABLE IF EXISTS `tbl_unsur`;
CREATE TABLE `tbl_unsur` (
  `id_unsur` int(11) NOT NULL AUTO_INCREMENT,
  `nm_unsur` varchar(50) NOT NULL,
  PRIMARY KEY (`id_unsur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_unsur` (`id_unsur`, `nm_unsur`) VALUES
(1,	'Pendidikan'),
(2,	'Tugas Pokok'),
(3,	'Pengembangan Profesi'),
(4,	'Pengembangan Profesi Penunjang');

DROP TABLE IF EXISTS `tbl_usulan`;
CREATE TABLE `tbl_usulan` (
  `id_usulan` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_usulan` date NOT NULL,
  `status_proses` varchar(100) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `nip` varchar(20) NOT NULL,
  `masa_penilaian_awal` date NOT NULL,
  `masa_penilaian_akhir` date NOT NULL,
  `tgl_penyesuaian` date DEFAULT NULL,
  `tgl_pengesahan` date DEFAULT NULL,
  `id_jabatan_pangkat_selanjutnya` int(11) NOT NULL,
  `id_jabatan_pangkat_sekarang` int(11) NOT NULL,
  `masa_kerja_golongan_lama` varchar(100) NOT NULL,
  `masa_kerja_golongan_baru` varchar(100) NOT NULL,
  PRIMARY KEY (`id_usulan`),
  KEY `id_jabatan_pangkat_selanjutnya` (`id_jabatan_pangkat_selanjutnya`),
  KEY `id_jabatan_pangkat_sekarang` (`id_jabatan_pangkat_sekarang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_usulan` (`id_usulan`, `tgl_usulan`, `status_proses`, `keterangan`, `nip`, `masa_penilaian_awal`, `masa_penilaian_akhir`, `tgl_penyesuaian`, `tgl_pengesahan`, `id_jabatan_pangkat_selanjutnya`, `id_jabatan_pangkat_sekarang`, `masa_kerja_golongan_lama`, `masa_kerja_golongan_baru`) VALUES
(1,	'2019-03-01',	'Angka Kredit Diterima',	'',	'11111',	'2019-03-30',	'2019-04-30',	'2019-03-31',	'2019-05-01',	7,	2,	'2 tahun, 3 bulan',	'2 tahun'),
(2,	'2019-03-15',	'Sedang Proses Verifikasi Oleh Pejabat Pengusul',	NULL,	'11111',	'2019-04-01',	'2019-10-01',	NULL,	NULL,	10,	9,	'9 Tahun 10 Bulan',	'2 tahun 2 bulan'),
(3,	'2019-03-15',	NULL,	NULL,	'11111',	'2019-04-01',	'2019-10-01',	NULL,	NULL,	10,	9,	'9 Tahun 10 Bulan',	'2 tahun 2 bulan'),
(4,	'2019-03-22',	NULL,	NULL,	'11111',	'2018-04-01',	'2019-03-31',	NULL,	NULL,	3,	2,	'12 tahun 6 bulan',	'13 tahun 6 bulan'),
(5,	'2015-01-05',	'Sedang Proses Verifikasi Oleh Pejabat Pengusul',	NULL,	'197811032008102001',	'2015-01-05',	'2017-10-05',	NULL,	NULL,	26,	22,	'15 Tahun 11 Bulan',	'12 Tahun 10 Bulan'),
(6,	'2019-03-25',	NULL,	NULL,	'11111',	'2014-07-01',	'2019-03-31',	NULL,	NULL,	30,	29,	'8 tahun 8 bulan',	'2 tahun 5 bulan'),
(7,	'2015-01-02',	'Sedang Proses Verifikasi Oleh Pejabat Pengusul',	NULL,	'197811032008102001',	'2015-01-05',	'2017-11-05',	NULL,	NULL,	22,	4,	'15 Tahun 11 Bulan',	'2 Tahun 3 Bulan'),
(8,	'2016-01-04',	NULL,	NULL,	'197811032008102001',	'2016-01-04',	'2018-07-31',	NULL,	NULL,	26,	4,	'15 Tahun 11 Bulan',	'2 Tahun 3 Bulan');

DROP TABLE IF EXISTS `tbl_usulan_unsur`;
CREATE TABLE `tbl_usulan_unsur` (
  `id_usulan_unsur` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_mulai_kegiatan` date NOT NULL,
  `tgl_selesai_kegiatan` date NOT NULL,
  `butir_kegiatan` text NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `angka_kredit_murni` float NOT NULL,
  `angka_kredit_murni_baru` float NOT NULL DEFAULT '0',
  `angka_kredit_persentase` float NOT NULL,
  `angka_kredit_persentase_baru` float NOT NULL DEFAULT '0',
  `angka_kredit` float NOT NULL,
  `angka_kredit_baru` float NOT NULL DEFAULT '0',
  `tempat` varchar(30) NOT NULL,
  `id_usulan` int(11) NOT NULL,
  `tingkat_kesulitan` varchar(30) NOT NULL,
  `jumlah_volume_kegiatan` int(11) NOT NULL,
  `id_sub_unsur` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `bukti_kegiatan` text NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_usulan_unsur`),
  KEY `id_unsur` (`id_sub_unsur`),
  KEY `id_usulan` (`id_usulan`),
  CONSTRAINT `tbl_usulan_unsur_ibfk_1` FOREIGN KEY (`id_usulan`) REFERENCES `tbl_usulan` (`id_usulan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_usulan_unsur_ibfk_3` FOREIGN KEY (`id_sub_unsur`) REFERENCES `tbl_sub_unsur` (`id_sub_unsur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_usulan_unsur` (`id_usulan_unsur`, `tgl_mulai_kegiatan`, `tgl_selesai_kegiatan`, `butir_kegiatan`, `satuan`, `angka_kredit_murni`, `angka_kredit_murni_baru`, `angka_kredit_persentase`, `angka_kredit_persentase_baru`, `angka_kredit`, `angka_kredit_baru`, `tempat`, `id_usulan`, `tingkat_kesulitan`, `jumlah_volume_kegiatan`, `id_sub_unsur`, `status`, `bukti_kegiatan`, `keterangan`) VALUES
(1,	'2019-03-01',	'2019-03-30',	'Mengelola perpustakaan',	'Eksampler',	0.125,	0.12,	100,	30,	15,	4.32,	'Padang',	1,	'Susah',	120,	2,	'Diterima',	'140319185922454600.jpg',	''),
(2,	'2019-03-01',	'2019-03-31',	'Ikut Seminar',	'Eksampler',	0.75,	0.75,	100,	100,	0.75,	0.75,	'Padang',	1,	'Susah Sekali',	1,	6,	'Diterima',	'140319185952361600.png',	''),
(3,	'2019-01-01',	'2019-03-01',	'Mengikuti pendidikan S1',	'Ijazah yang ter akreditasi',	100,	0,	100,	0,	100,	0,	'Padang',	2,	'-',	1,	11,	'',	'140319180700144600.png',	''),
(4,	'2019-01-01',	'2019-02-01',	'mengelola buku perpustakaan',	'naskah',	0.003,	0,	100,	0,	4.5,	0,	'UPT perpustakaan',	2,	'-',	1500,	2,	NULL,	'140319180903343900.png',	''),
(5,	'2019-01-01',	'2019-02-01',	'Melakukan katalogisasi deskriptif',	'lembar',	0.125,	0,	100,	0,	18.75,	0,	'UPT perpustakaan',	2,	'-',	150,	4,	NULL,	'140319181143610700.jpg',	''),
(6,	'2019-01-01',	'2019-02-01',	'Membuat tulisan ilmiah populer di bidang kepustakawanan yang diperluaskan di media massa',	'naskah',	0.75,	0,	100,	0,	1.5,	0,	'Padang',	2,	'-',	2,	5,	NULL,	'140319181314765600.jpg',	''),
(7,	'2019-01-01',	'2019-02-01',	'Menjadi anggota dalam organiasi yang dibentuk pustakawan universitas',	'anggota',	2,	0,	15,	0,	0.3,	0,	'UPT perpustakaan',	2,	'anggota',	1,	8,	NULL,	'140319181612173400.png',	''),
(8,	'2018-09-09',	'2019-03-01',	'Pendidkan sekolah dan memperoleh ijazah Sarjana S1 Ilmu Perpustakaan',	'Ijazah yang ter akreditasi',	60,	0,	100,	0,	60,	0,	'Padang',	5,	'-',	1,	11,	NULL,	'240319023208779600.png',	''),
(9,	'2019-01-02',	'2019-01-31',	'Melakukan layanan peminjaman dan pengembalian koleksi',	'Eksampler',	0.001,	0,	100,	0,	21.38,	0,	'UPT perpustakaan',	5,	'-',	21380,	3,	NULL,	'240319023525600500.png',	''),
(10,	'2019-02-01',	'2019-01-31',	'Mengelola jajaran koleksi perpustakaan (shelving)',	'naskah',	0.003,	0,	100,	0,	19.098,	0,	'UPT perpustakaan',	5,	'-',	6366,	3,	NULL,	'240319023750665600.png',	''),
(11,	'2018-01-01',	'2019-02-01',	'Melakukan layanan peminjaman dan pengembalian koleksi',	'Eksampler',	0.001,	0,	100,	0,	27.079,	0,	'UPT perpustakaan',	5,	'-',	27079,	3,	NULL,	'240319024147403500.png',	''),
(12,	'2018-09-09',	'2018-09-12',	'Sebagai peserta dalam \"Seminar Nasional dan Grand Lounching Minangkabau Corner \" pengelolaan khazanah keminangkabaun ',	'setiap kali',	1,	0,	100,	0,	1,	0,	'UPT perpustakaan',	5,	'-',	1,	35,	NULL,	'240319041031478500.png',	''),
(13,	'2016-02-12',	'2016-02-12',	'Sebagai peserta kegiatan \" Peresmian BI Corner dan Bedah Buku\" pada tanggal 12 Februari 2016 di Gedung Perpustakaan Unand',	'Sertifikat',	1,	0,	100,	0,	1,	0,	'UPT Perpustakaan Unand',	5,	'-',	1,	8,	NULL,	'120419145649967600.pdf',	''),
(14,	'2016-04-15',	'2016-04-15',	'Sebagai peserta Seminar Nasional Perpustakaan \" Peluang dan Tantangan Karier Menghadapi Masyarakat Ekonomi Asean (MEA)\" pada tanggal 15 April 2016 di Universitas Negeri Padang',	'Sertifikat',	1,	0,	100,	0,	1,	0,	'Universitas Negeri Padang',	5,	'-',	1,	8,	NULL,	'120419150342252000.pdf',	''),
(15,	'2016-11-10',	'2016-11-10',	'Sebagai peserta Seminar Perpustakaan \" Information Literatur and Sharing of Knowledge\" pada tanggal 10 November 2016 di IAIN Imam Bonjol Padang',	'Sertifikat',	1,	0,	100,	0,	1,	0,	'IAIN Imam Bonjol Padang',	5,	'-',	1,	8,	NULL,	'120419150815114100.pdf',	''),
(16,	'1982-02-12',	'1982-02-12',	'Pendidikan sekolah dan memperoleh ijazah/gelar Sarjana S1 Ilmu Perpustakaan',	'Ijazah yang terakreditasi',	40,	0,	100,	0,	40,	0,	'Universitas Negeri Padang',	7,	'-',	1,	11,	NULL,	'120419151910192300.pdf',	''),
(17,	'2016-02-12',	'2016-03-12',	'Penyimpanan dan Perawatan Koleksi Perpustakaan',	'Judul',	0.001,	0,	100,	0,	21.38,	0,	'UPT Perpustakaan Unand',	7,	'-',	21380,	4,	NULL,	'120419164404883200.pdf',	''),
(18,	'2016-11-10',	'2017-04-15',	'Mengelola jajaran koleksi perpustakaan',	'Judul',	0.003,	0,	100,	0,	27.66,	0,	'UPT Perpustakaan Unand',	7,	'-',	9220,	2,	NULL,	'120419164854614800.pdf',	''),
(19,	'2015-11-10',	'2015-11-10',	'Sebagai peserta Seminar Nasional Perpustakaan \" Peluang dan Tantangan Karier Menghadapi Masyarakat Ekonomi Asean (MEA)\" pada tanggal 15 April 2016 di Universitas Negeri Padang',	'Sertifikat',	1,	0,	100,	0,	1,	0,	'IAIN Imam Bonjol Padang',	7,	'-',	1,	8,	NULL,	'120419165102792700.pdf',	'');

-- 2019-04-30 02:06:00
