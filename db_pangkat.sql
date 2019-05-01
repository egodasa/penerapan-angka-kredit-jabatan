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


DROP TABLE IF EXISTS `tbl_jabatan`;
CREATE TABLE `tbl_jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `id_posisi` int(11) NOT NULL,
  `nm_jabatan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_jabatan`),
  KEY `id_posisi` (`id_posisi`),
  CONSTRAINT `tbl_jabatan_ibfk_1` FOREIGN KEY (`id_posisi`) REFERENCES `tbl_posisi` (`id_posisi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_jabatan` (`id_jabatan`, `id_posisi`, `nm_jabatan`) VALUES
(2,	1,	'Terampil'),
(3,	2,	'Terampil'),
(4,	2,	'Ahli'),
(5,	1,	'Ahli');

DROP TABLE IF EXISTS `tbl_jabatan_pangkat`;
CREATE TABLE `tbl_jabatan_pangkat` (
  `id_jabatan_pangkat` int(11) NOT NULL AUTO_INCREMENT,
  `id_jabatan` int(11) NOT NULL,
  `id_pangkat` int(11) NOT NULL,
  `nilai_kredit` float NOT NULL,
  `peringkat` int(11) NOT NULL,
  PRIMARY KEY (`id_jabatan_pangkat`),
  KEY `id_jabatan` (`id_jabatan`),
  KEY `id_pangkat` (`id_pangkat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_jenis_berkas`;
CREATE TABLE `tbl_jenis_berkas` (
  `id_berkas` int(11) NOT NULL AUTO_INCREMENT,
  `nm_berkas` varchar(255) NOT NULL,
  PRIMARY KEY (`id_berkas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_pangkat`;
CREATE TABLE `tbl_pangkat` (
  `id_pangkat` int(11) NOT NULL AUTO_INCREMENT,
  `id_jabatan` int(11) NOT NULL,
  `nm_pangkat` varchar(100) NOT NULL,
  PRIMARY KEY (`id_pangkat`),
  KEY `id_jabatan` (`id_jabatan`),
  CONSTRAINT `tbl_pangkat_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `tbl_jabatan` (`id_jabatan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
(1,	'Arsiparis',	'Tenaga Kependidikan'),
(2,	'Pustakawan',	'Tenaga Kependidikan');

DROP TABLE IF EXISTS `tbl_sub_unsur`;
CREATE TABLE `tbl_sub_unsur` (
  `id_sub_unsur` int(11) NOT NULL AUTO_INCREMENT,
  `nm_unsur` varchar(255) NOT NULL,
  `id_unsur` int(11) NOT NULL,
  `jenis_unsur` enum('Unsur Utama','Unsur Penunjang') NOT NULL,
  PRIMARY KEY (`id_sub_unsur`),
  KEY `id_posisi` (`id_unsur`),
  CONSTRAINT `tbl_sub_unsur_ibfk_1` FOREIGN KEY (`id_unsur`) REFERENCES `tbl_unsur` (`id_unsur`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
  `id_jabatan` int(11) NOT NULL,
  PRIMARY KEY (`id_unsur`),
  KEY `id_jabatan` (`id_jabatan`),
  CONSTRAINT `tbl_unsur_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `tbl_jabatan` (`id_jabatan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_unsur` (`id_unsur`, `nm_unsur`, `id_jabatan`) VALUES
(2,	'Kegiatan Pengelolaan Arsip',	2),
(3,	'Pendidikan',	2),
(4,	'Pendidikan',	5);

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


DROP TABLE IF EXISTS `tbl_usulan_unsur`;
CREATE TABLE `tbl_usulan_unsur` (
  `id_usulan_unsur` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_mulai_kegiatan` date NOT NULL,
  `tgl_selesai_kegiatan` date NOT NULL,
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
  `id_butir` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `bukti_kegiatan` text NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id_usulan_unsur`),
  KEY `id_unsur` (`id_butir`),
  KEY `id_usulan` (`id_usulan`),
  CONSTRAINT `tbl_usulan_unsur_ibfk_1` FOREIGN KEY (`id_butir`) REFERENCES `tbl_butir_kegiatan` (`id_butir`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2019-05-01 06:12:19
