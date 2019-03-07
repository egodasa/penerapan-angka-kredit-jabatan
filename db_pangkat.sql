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
(15,	2,	1,	'010319184139631500.jpg'),
(16,	2,	2,	'010319184207909500.jpg'),
(17,	2,	3,	'010319184244520900.png'),
(18,	2,	4,	'010319184259217400.jpg'),
(19,	2,	5,	NULL),
(20,	2,	6,	NULL),
(21,	2,	7,	NULL),
(22,	2,	8,	NULL),
(23,	2,	9,	NULL),
(24,	2,	10,	NULL),
(25,	2,	11,	NULL),
(26,	2,	12,	NULL),
(27,	2,	13,	NULL),
(60,	5,	1,	NULL),
(61,	5,	2,	NULL),
(62,	5,	3,	NULL),
(63,	5,	4,	NULL),
(64,	5,	5,	NULL),
(65,	5,	6,	NULL),
(66,	5,	7,	NULL),
(67,	5,	8,	NULL),
(68,	5,	9,	NULL),
(69,	5,	10,	NULL),
(70,	5,	11,	NULL),
(71,	5,	12,	NULL),
(72,	5,	13,	NULL);

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
(5,	'Tim Penilai'),
(6,	'Pustakawan Pertama'),
(7,	'Pustakawan Muda'),
(8,	'Pustakawan Madya'),
(9,	'Pustakawan Utama'),
(10,	'Arsiparis Pelaksana'),
(11,	'Arsiparis Pelaksana Lanjutan'),
(12,	'Arsiparis Penyelia'),
(13,	'Arsiparis Pertama'),
(14,	'Arsiparis Muda'),
(15,	'Arsiparis Madya'),
(16,	'Arsiparis Utama'),
(17,	'PLP Pelaksana'),
(18,	'PLP Pelaksana Lanjutan'),
(19,	'PLP Penyelia'),
(20,	'PLP Pertama'),
(21,	'PLP Muda'),
(22,	'PLP Madya'),
(23,	'PLP Utama'),
(24,	'Admin');

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
(1,	1,	1,	50,	50),
(2,	1,	2,	60,	60),
(3,	1,	3,	60,	60),
(4,	1,	4,	80,	80),
(5,	4,	13,	0,	0),
(6,	5,	14,	0,	0),
(7,	10,	3,	60,	60),
(8,	10,	4,	80,	80),
(9,	11,	5,	100,	100),
(10,	11,	6,	150,	150),
(11,	12,	7,	200,	200),
(12,	12,	8,	300,	300),
(13,	13,	5,	100,	100),
(14,	13,	6,	150,	150),
(15,	14,	7,	200,	200),
(16,	14,	8,	300,	300),
(17,	15,	9,	400,	400),
(18,	15,	10,	550,	550),
(19,	15,	11,	700,	700),
(20,	16,	12,	850,	850),
(21,	16,	15,	1050,	1050);

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
(4,	'Pengatur Tngkat I (II/d)'),
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
(15,	'Pembina Utama (IV/e)');

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
(4,	'12345',	'827ccb0eea8a706c4c34a16891f84e7b',	'12345',	'Saya (Admin)',	'Padang',	'2012-10-10',	'email@mail.com',	'08123456789',	'Sarjana (S1)/Diploma IV',	'2019-02-01',	'Laki-laki',	5,	17,	'010319182359033700.png',	0,	0,	'2019-02-25'),
(5,	'11111',	'b0baee9d279d34fa1dfd71aadb908c3f',	'11111',	'Pustakawan',	'padang',	'1980-10-10',	'pustakawan@gmail.com',	'089512345',	'Sarjana (S1)/Diploma IV',	'2019-02-01',	'Perempuan',	1,	1,	'010319181639087600.jpg',	20,	0,	'2019-02-06'),
(6,	'22222',	'3d2172418ce305c7d16d4b05597c6a59',	'22222',	'Arsiparis',	'padang',	'2019-10-10',	'arsiparis@yahoo.com',	'081213212321',	'Sarjana (S1)/Diploma IV',	'2019-02-01',	'Perempuan',	4,	14,	'010319182016224600.jpeg',	0,	0,	'2019-02-06'),
(7,	'98765',	'c37bf859faf392800d739a41fe5af151',	'N. 98765',	'Tim Penilai',	'Padang',	'2003-04-04',	'tim@pegawai.com',	'089876544321',	'Sarjana (S1)/Diploma IV',	'2019-02-06',	'Laki-laki',	6,	4,	'010319182726025600.png',	0,	0,	'2019-02-04'),
(8,	'77777',	'22a4d9b04fe95c9893b41e2fde83a427',	'N. 77777',	'Atasan Pustakawan',	'padang',	'1995-10-10',	'plp@gmail.com',	'087777777777',	'Sarjana (S1)/Diploma IV',	'2019-02-01',	'Laki-laki',	1,	15,	'010319183004572200.jpg',	0,	0,	'2019-02-07'),
(9,	'197510172001122002',	'03eb836763032db02255eb22ba9f979c',	'L.043398',	'Zasmi Fitriani, A.Md',	'Padang',	'1975-10-17',	'zasmifitriani@gmail.com',	'08527412345',	'Sarjana (S1)/Diploma IV',	'1994-04-04',	'Perempuan',	1,	1,	'010319175612772500.jpg',	110,	0,	'2013-08-01');

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
(7,	'admin',	'');

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
(1,	'UPT Perpustakaan Pusat',	'77777',	4),
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
(14,	'UPT Perpustakaan Pusat',	'12345',	2),
(15,	'MIPA',	'12345',	3),
(16,	'Pertanian',	'12345',	3),
(17,	'Rektorat',	'12345',	5),
(18,	'Teknik ',	'12345',	3),
(19,	'Teknologi Pertanian',	'12345',	3),
(20,	'Ekonomi',	'12345',	3),
(21,	'Farmasi',	'12345',	3),
(22,	'Kedokteran',	'12345',	3);

DROP TABLE IF EXISTS `tbl_unsur`;
CREATE TABLE `tbl_unsur` (
  `id_unsur` int(11) NOT NULL AUTO_INCREMENT,
  `nm_unsur` varchar(255) NOT NULL,
  `id_posisi` int(11) NOT NULL,
  `jenis_unsur` enum('Unsur Utama','Unsur Penunjang') NOT NULL,
  `kategori_unsur` enum('Pendidikan','Tugas Pokok','Pengembangan Profesi') NOT NULL DEFAULT 'Tugas Pokok',
  PRIMARY KEY (`id_unsur`),
  KEY `id_posisi` (`id_posisi`),
  CONSTRAINT `tbl_unsur_ibfk_1` FOREIGN KEY (`id_posisi`) REFERENCES `tbl_posisi` (`id_posisi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_unsur` (`id_unsur`, `nm_unsur`, `id_posisi`, `jenis_unsur`, `kategori_unsur`) VALUES
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
(1,	'2019-02-02',	'Angka Kredit Diterima',	'',	'11111',	'2019-03-02',	'2019-07-02',	'2019-02-21',	'2019-02-01',	3,	2,	'1 tahun',	'2 tahun'),
(2,	'2019-03-02',	'Verifikasi Gagal',	'bukti tidak sesuai',	'11111',	'2013-01-02',	'2015-12-02',	NULL,	NULL,	4,	3,	'9 Tahun 10 Bulan',	'12 Tahun 10 Bulan'),
(5,	'0000-00-00',	NULL,	NULL,	'11111',	'0000-00-00',	'0000-00-00',	NULL,	NULL,	4,	3,	'9 Tahun 10 Bulan',	'12 Tahun 10 Bulan');

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
  `id_unsur` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `bukti_kegiatan` text NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_usulan_unsur`),
  KEY `id_unsur` (`id_unsur`),
  KEY `id_usulan` (`id_usulan`),
  CONSTRAINT `tbl_usulan_unsur_ibfk_1` FOREIGN KEY (`id_usulan`) REFERENCES `tbl_usulan` (`id_usulan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_usulan_unsur_ibfk_2` FOREIGN KEY (`id_unsur`) REFERENCES `tbl_unsur` (`id_unsur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_usulan_unsur` (`id_usulan_unsur`, `tgl_mulai_kegiatan`, `tgl_selesai_kegiatan`, `butir_kegiatan`, `satuan`, `angka_kredit_murni`, `angka_kredit_murni_baru`, `angka_kredit_persentase`, `angka_kredit_persentase_baru`, `angka_kredit`, `angka_kredit_baru`, `tempat`, `id_usulan`, `tingkat_kesulitan`, `jumlah_volume_kegiatan`, `id_unsur`, `status`, `bukti_kegiatan`, `keterangan`) VALUES
(3,	'2018-07-01',	'2019-02-01',	'Mengelola perpustakaan Besar',	'Hari',	0,	1,	0,	20,	10,	26,	'Perpustakaan',	1,	'Susah',	130,	2,	NULL,	'270219020746080800.jpeg',	''),
(4,	'2019-02-02',	'2019-02-04',	'Mengikuti seminar kepustakawan',	'hari',	0,	0.12,	0,	20,	0.5,	0.576,	'Padang Panjang',	1,	'Lumayan',	24,	6,	NULL,	'270219021008729000.jpg',	''),
(5,	'2014-02-01',	'2017-02-01',	'Mengikuti pendidikan S1',	'Hari',	0,	0,	0,	0,	15,	0,	'Surabaya',	1,	'Susah',	768,	10,	NULL,	'270219021121265200.jpeg',	''),
(6,	'2019-02-08',	'2019-02-08',	'dfsdfs',	'sdf',	1,	0,	10,	0,	1.2,	0,	'asdsd',	1,	'eere',	12,	4,	NULL,	'270219154855768000.jpg',	''),
(7,	'2018-01-01',	'2018-02-01',	'Mengikuti Pendidikan Sekolah dan Memperoleh Ijazah/Gelar Sarjana (S1)',	'Ijazah yang ter akreditasi',	100,	0,	100,	0,	100,	0,	'Padang',	2,	'-',	1,	11,	NULL,	'020319041158378200.jpg',	''),
(8,	'2018-07-03',	'2018-08-11',	'Melakukan katalogisasi deskriptif (tingkat satu)',	'Judul',	0.003,	0,	100,	0,	2.1,	0,	'UPT perpustakaan',	2,	'tingkat 1',	700,	3,	NULL,	'020319041828746200.png',	''),
(9,	'2018-01-01',	'2018-12-31',	'Menyusun rencana kerja operasional (peserta)',	'naskah',	0.22,	0,	100,	0,	2.2,	0,	'UPT perpustakaan',	2,	'-',	10,	2,	NULL,	'020319042935697500.jpg',	''),
(10,	'2018-05-08',	'2018-06-05',	'Menyelenggarakan pameran sebagai pemandu pameran di dalam negeri',	'kali',	0.125,	0,	100,	0,	1.25,	0,	'universitas andalas',	2,	'-',	10,	4,	NULL,	'020319043846920000.jpg',	''),
(11,	'2018-07-02',	'2018-07-12',	'Membuat tulisan ilmiah populer di bidang kepustakawanan yang diperluaskan di media massa',	'karya',	2,	0,	100,	0,	4,	0,	'Padang',	2,	'-',	2,	5,	NULL,	'020319044230980400.jpg',	''),
(12,	'2018-12-12',	'2019-03-11',	'Keanggotaan dalam tim penilai, sebagai anggota',	'Setiap tahun',	0.75,	0,	100,	0,	0.75,	0,	'universitas andalas',	2,	'-',	1,	9,	NULL,	'020319044531327300.jpg',	'');

-- 2019-03-07 05:02:42
