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
  `angka_kredit_minimal` float NOT NULL,
  `peringkat` int(11) NOT NULL,
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
  `id_pangkat` int(11) NOT NULL,
  `id_unit_kerja` int(11) NOT NULL,
  `foto` text,
  `kredit_awal_utama` float NOT NULL DEFAULT '0',
  `kredit_awal_penunjang` float NOT NULL,
  `tmt_jabatan` date NOT NULL,
  PRIMARY KEY (`id_pegawai`),
  KEY `id_jabatan_pangkat` (`id_pangkat`),
  KEY `id_unit_kerja` (`id_unit_kerja`),
  CONSTRAINT `tbl_pegawai_ibfk_2` FOREIGN KEY (`id_unit_kerja`) REFERENCES `tbl_unit_kerja` (`id_unit_kerja`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_pegawai_ibfk_3` FOREIGN KEY (`id_pangkat`) REFERENCES `tbl_pangkat` (`id_pangkat`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_pelaksana_butir_kegiatan`;
CREATE TABLE `tbl_pelaksana_butir_kegiatan` (
  `id_pelaksana` int(11) NOT NULL AUTO_INCREMENT,
  `id_butir` int(11) NOT NULL,
  `id_pangkat` int(11) NOT NULL,
  PRIMARY KEY (`id_pelaksana`),
  KEY `id_butir` (`id_butir`),
  KEY `id_pangkat` (`id_pangkat`),
  CONSTRAINT `tbl_pelaksana_butir_kegiatan_ibfk_1` FOREIGN KEY (`id_butir`) REFERENCES `tbl_butir_kegiatan` (`id_butir`) ON DELETE CASCADE,
  CONSTRAINT `tbl_pelaksana_butir_kegiatan_ibfk_2` FOREIGN KEY (`id_pangkat`) REFERENCES `tbl_pangkat` (`id_pangkat`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_posisi`;
CREATE TABLE `tbl_posisi` (
  `id_posisi` int(11) NOT NULL AUTO_INCREMENT,
  `nm_posisi` varchar(255) NOT NULL,
  `jenis_posisi` enum('Tenaga Kependidikan','Staff Kepegawaian','Tim Penilai') NOT NULL,
  PRIMARY KEY (`id_posisi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_sub_unsur`;
CREATE TABLE `tbl_sub_unsur` (
  `id_sub_unsur` int(11) NOT NULL AUTO_INCREMENT,
  `nm_sub_unsur` varchar(255) NOT NULL,
  `id_unsur` int(11) NOT NULL,
  PRIMARY KEY (`id_sub_unsur`),
  KEY `id_posisi` (`id_unsur`),
  CONSTRAINT `tbl_sub_unsur_ibfk_2` FOREIGN KEY (`id_unsur`) REFERENCES `tbl_unsur` (`id_unsur`) ON DELETE CASCADE
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


DROP TABLE IF EXISTS `tbl_unsur`;
CREATE TABLE `tbl_unsur` (
  `id_unsur` int(11) NOT NULL AUTO_INCREMENT,
  `nm_unsur` varchar(50) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `kategori` enum('Unsur Utama','Unsur Penunjang') NOT NULL,
  PRIMARY KEY (`id_unsur`),
  KEY `id_jabatan` (`id_jabatan`),
  CONSTRAINT `tbl_unsur_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `tbl_jabatan` (`id_jabatan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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


-- 2019-05-02 03:16:01
