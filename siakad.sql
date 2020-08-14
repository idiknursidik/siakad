/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : siakad

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-08-14 22:13:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for feeder_akm
-- ----------------------------
DROP TABLE IF EXISTS `feeder_akm`;
CREATE TABLE `feeder_akm` (
  `angkatan` varchar(10) DEFAULT NULL,
  `biaya_kuliah_smt` varchar(20) DEFAULT NULL,
  `id_mahasiswa` varchar(50) DEFAULT NULL,
  `id_perguruan_tinggi` varchar(50) DEFAULT NULL,
  `kode_perguruan_tinggi` varchar(10) DEFAULT NULL,
  `id_prodi` varchar(50) DEFAULT NULL,
  `id_registrasi_mahasiswa` varchar(50) DEFAULT NULL,
  `id_semester` varchar(10) DEFAULT NULL,
  `id_status_mahasiswa` varchar(10) DEFAULT NULL,
  `ipk` varchar(10) DEFAULT NULL,
  `ips` varchar(10) DEFAULT NULL,
  `nama_mahasiswa` varchar(100) DEFAULT NULL,
  `nama_program_studi` varchar(200) DEFAULT NULL,
  `nama_semester` varchar(200) DEFAULT NULL,
  `nama_status_mahasiswa` varchar(100) DEFAULT NULL,
  `nim` varchar(100) DEFAULT NULL,
  `sks_semester` varchar(10) DEFAULT NULL,
  `sks_total` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for feeder_biodatamahasiswa
-- ----------------------------
DROP TABLE IF EXISTS `feeder_biodatamahasiswa`;
CREATE TABLE `feeder_biodatamahasiswa` (
  `nama_mahasiswa` varchar(200) DEFAULT NULL,
  `jenis_kelamin` varchar(5) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `id_mahasiswa` varchar(100) DEFAULT NULL,
  `kode_perguruan_tinggi` varchar(10) DEFAULT NULL,
  `id_perguruan_tinggi` varchar(100) DEFAULT NULL,
  `id_agama` varchar(5) DEFAULT NULL,
  `nama_agama` varchar(100) DEFAULT NULL,
  `nik` varchar(100) DEFAULT NULL,
  `nisn` varchar(100) DEFAULT NULL,
  `npwp` varchar(100) DEFAULT NULL,
  `id_negara` varchar(5) DEFAULT NULL,
  `kewarganegaraan` varchar(100) DEFAULT NULL,
  `jalan` varchar(200) DEFAULT NULL,
  `dusun` varchar(100) DEFAULT NULL,
  `rt` varchar(5) DEFAULT NULL,
  `rw` varchar(5) DEFAULT NULL,
  `kelurahan` varchar(100) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `id_wilayah` varchar(10) DEFAULT NULL,
  `nama_wilayah` varchar(100) DEFAULT NULL,
  `id_jenis_tinggal` varchar(100) DEFAULT NULL,
  `nama_jenis_tinggal` varchar(100) DEFAULT NULL,
  `id_alat_transportasi` varchar(100) DEFAULT NULL,
  `nama_alat_transportasi` varchar(100) DEFAULT NULL,
  `telepon` varchar(100) DEFAULT NULL,
  `handphone` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `penerima_kps` varchar(200) DEFAULT NULL,
  `nomor_kps` varchar(100) DEFAULT NULL,
  `nik_ayah` varchar(100) DEFAULT NULL,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `tanggal_lahir_ayah` date DEFAULT NULL,
  `id_pendidikan_ayah` varchar(10) DEFAULT NULL,
  `nama_pendidikan_ayah` varchar(200) DEFAULT NULL,
  `id_pekerjaan_ayah` varchar(10) DEFAULT NULL,
  `nama_pekerjaan_ayah` varchar(100) DEFAULT NULL,
  `id_penghasilan_ayah` varchar(10) DEFAULT NULL,
  `nama_penghasilan_ayah` varchar(100) DEFAULT NULL,
  `nik_ibu` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(200) DEFAULT NULL,
  `tanggal_lahir_ibu` date DEFAULT NULL,
  `id_pendidikan_ibu` varchar(10) DEFAULT NULL,
  `nama_pendidikan_ibu` varchar(100) DEFAULT NULL,
  `id_pekerjaan_ibu` varchar(10) DEFAULT NULL,
  `nama_pekerjaan_ibu` varchar(100) DEFAULT NULL,
  `id_penghasilan_ibu` varchar(10) DEFAULT NULL,
  `nama_penghasilan_ibu` varchar(100) DEFAULT NULL,
  `nama_wali` varchar(200) DEFAULT NULL,
  `tanggal_lahir_wali` date DEFAULT NULL,
  `id_pendidikan_wali` varchar(10) DEFAULT NULL,
  `nama_pendidikan_wali` varchar(100) DEFAULT NULL,
  `id_pekerjaan_wali` varchar(10) DEFAULT NULL,
  `nama_pekerjaan_wali` varchar(100) DEFAULT NULL,
  `id_penghasilan_wali` varchar(10) DEFAULT NULL,
  `nama_penghasilan_wali` varchar(200) DEFAULT NULL,
  `id_kebutuhan_khusus_mahasiswa` varchar(10) DEFAULT NULL,
  `nama_kebutuhan_khusus_mahasiswa` varchar(200) DEFAULT NULL,
  `id_kebutuhan_khusus_ayah` varchar(10) DEFAULT NULL,
  `nama_kebutuhan_khusus_ayah` varchar(200) DEFAULT NULL,
  `id_kebutuhan_khusus_ibu` varchar(10) DEFAULT NULL,
  `nama_kebutuhan_khusus_ibu` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for feeder_dataprodi
-- ----------------------------
DROP TABLE IF EXISTS `feeder_dataprodi`;
CREATE TABLE `feeder_dataprodi` (
  `id_perguruan_tinggi` varchar(200) DEFAULT NULL,
  `kode_perguruan_tinggi` varchar(10) DEFAULT NULL,
  `id_prodi` varchar(200) DEFAULT NULL,
  `kode_program_studi` varchar(10) DEFAULT NULL,
  `nama_program_studi` varchar(255) DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL,
  `id_jenjang_pendidikan` varchar(5) DEFAULT NULL,
  `nama_jenjang_pendidikan` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for feeder_kelas
-- ----------------------------
DROP TABLE IF EXISTS `feeder_kelas`;
CREATE TABLE `feeder_kelas` (
  `id_perguruan_tinggi` varchar(50) DEFAULT NULL,
  `kode_perguruan_tinggi` varchar(10) DEFAULT NULL,
  `bahasan` varchar(50) DEFAULT '',
  `id_kelas_kuliah` varchar(50) DEFAULT NULL,
  `id_matkul` varchar(50) DEFAULT NULL,
  `id_prodi` varchar(50) DEFAULT NULL,
  `id_semester` varchar(10) DEFAULT NULL,
  `kode_mata_kuliah` varchar(100) DEFAULT NULL,
  `nama_mata_kuliah` varchar(200) DEFAULT NULL,
  `nama_kelas_kuliah` varchar(100) DEFAULT NULL,
  `nama_program_studi` varchar(200) DEFAULT NULL,
  `nama_semester` varchar(10) DEFAULT NULL,
  `tanggal_akhir_efektif` date DEFAULT NULL,
  `tanggal_mulai_efektif` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for feeder_krs
-- ----------------------------
DROP TABLE IF EXISTS `feeder_krs`;
CREATE TABLE `feeder_krs` (
  `angkatan` varchar(10) DEFAULT NULL,
  `id_perguruan_tinggi` varchar(50) DEFAULT NULL,
  `kode_perguruan_tinggi` varchar(10) DEFAULT NULL,
  `id_kelas` varchar(50) DEFAULT NULL,
  `id_matkul` varchar(50) DEFAULT NULL,
  `id_periode` varchar(10) DEFAULT NULL,
  `id_prodi` varchar(50) DEFAULT NULL,
  `id_registrasi_mahasiswa` varchar(50) DEFAULT NULL,
  `kode_mata_kuliah` varchar(20) DEFAULT NULL,
  `nama_kelas_kuliah` varchar(20) DEFAULT NULL,
  `nama_mahasiswa` varchar(200) DEFAULT NULL,
  `nama_mata_kuliah` varchar(200) DEFAULT NULL,
  `nama_program_studi` varchar(200) DEFAULT NULL,
  `nim` varchar(100) DEFAULT NULL,
  `sks_mata_kuliah` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for feeder_kurikulum
-- ----------------------------
DROP TABLE IF EXISTS `feeder_kurikulum`;
CREATE TABLE `feeder_kurikulum` (
  `id_perguruan_tinggi` varchar(50) DEFAULT NULL,
  `kode_perguruan_tinggi` varchar(10) DEFAULT NULL,
  `id_kurikulum` varchar(50) DEFAULT NULL,
  `id_prodi` varchar(50) DEFAULT NULL,
  `id_semester` varchar(10) DEFAULT NULL,
  `jumlah_sks_lulus` varchar(10) DEFAULT NULL,
  `jumlah_sks_mata_kuliah_pilihan` varchar(10) DEFAULT NULL,
  `jumlah_sks_mata_kuliah_wajib` varchar(10) DEFAULT NULL,
  `jumlah_sks_pilihan` varchar(10) DEFAULT NULL,
  `jumlah_sks_wajib` varchar(10) DEFAULT NULL,
  `nama_kurikulum` varchar(100) DEFAULT NULL,
  `nama_program_studi` varchar(200) DEFAULT NULL,
  `semester_mulai_berlaku` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for feeder_kurikulummatakuliah
-- ----------------------------
DROP TABLE IF EXISTS `feeder_kurikulummatakuliah`;
CREATE TABLE `feeder_kurikulummatakuliah` (
  `id_perguruan_tinggi` varchar(50) DEFAULT NULL,
  `kode_perguruan_tinggi` varchar(10) DEFAULT NULL,
  `id_prodi` varchar(50) DEFAULT NULL,
  `nama_program_studi` varchar(200) DEFAULT NULL,
  `id_kurikulum` varchar(50) DEFAULT '',
  `id_matkul` varchar(50) DEFAULT '',
  `id_semester` varchar(50) DEFAULT '',
  `apakah_wajib` varchar(50) DEFAULT '',
  `nama_kurikulum` varchar(200) DEFAULT '',
  `kode_mata_kuliah` varchar(50) DEFAULT NULL,
  `nama_mata_kuliah` varchar(200) DEFAULT '',
  `semester` varchar(50) DEFAULT '',
  `semester_mulai_berlaku` varchar(50) DEFAULT '',
  `sks_mata_kuliah` varchar(10) DEFAULT '',
  `sks_praktek` varchar(10) DEFAULT '',
  `sks_praktek_lapangan` varchar(10) DEFAULT '',
  `sks_simulasi` varchar(10) DEFAULT '',
  `sks_tatap_muka` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for feeder_mahasiswa
-- ----------------------------
DROP TABLE IF EXISTS `feeder_mahasiswa`;
CREATE TABLE `feeder_mahasiswa` (
  `nama_mahasiswa` varchar(200) DEFAULT NULL,
  `jenis_kelamin` varchar(5) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `id_perguruan_tinggi` varchar(100) DEFAULT NULL,
  `kode_perguruan_tinggi` varchar(10) DEFAULT NULL,
  `id_mahasiswa` varchar(100) DEFAULT NULL,
  `id_agama` varchar(5) DEFAULT NULL,
  `nama_agama` varchar(100) DEFAULT NULL,
  `id_prodi` varchar(100) DEFAULT NULL,
  `nama_program_studi` varchar(200) DEFAULT NULL,
  `nama_status_mahasiswa` varchar(20) DEFAULT NULL,
  `nim` varchar(50) DEFAULT NULL,
  `id_periode` varchar(10) DEFAULT NULL,
  `nama_periode_masuk` varchar(100) DEFAULT NULL,
  `id_registrasi_mahasiswa` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for feeder_matakuliah
-- ----------------------------
DROP TABLE IF EXISTS `feeder_matakuliah`;
CREATE TABLE `feeder_matakuliah` (
  `ada_acara_praktek` varchar(10) DEFAULT NULL,
  `ada_bahan_ajar` varchar(10) DEFAULT NULL,
  `ada_diktat` varchar(10) DEFAULT NULL,
  `ada_sap` varchar(10) DEFAULT NULL,
  `ada_silabus` varchar(10) DEFAULT NULL,
  `id_jenis_mata_kuliah` varchar(10) DEFAULT NULL,
  `id_kelompok_mata_kuliah` varchar(10) DEFAULT NULL,
  `id_perguruan_tinggi` varchar(50) DEFAULT NULL,
  `kode_perguruan_tinggi` varchar(10) DEFAULT NULL,
  `id_matkul` varchar(50) DEFAULT NULL,
  `id_prodi` varchar(50) DEFAULT NULL,
  `kode_mata_kuliah` varchar(20) DEFAULT NULL,
  `metode_kuliah` varchar(50) DEFAULT NULL,
  `nama_mata_kuliah` varchar(200) DEFAULT NULL,
  `nama_program_studi` varchar(200) DEFAULT NULL,
  `sks_mata_kuliah` varchar(5) DEFAULT NULL,
  `sks_praktek` varchar(5) DEFAULT NULL,
  `sks_praktek_lapangan` varchar(5) DEFAULT NULL,
  `sks_simulasi` varchar(5) DEFAULT NULL,
  `sks_tatap_muka` varchar(5) DEFAULT NULL,
  `tanggal_mulai_efektif` date DEFAULT NULL,
  `tanggal_selesai_efektif` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for feeder_nilai
-- ----------------------------
DROP TABLE IF EXISTS `feeder_nilai`;
CREATE TABLE `feeder_nilai` (
  `angkatan` varchar(10) DEFAULT NULL,
  `id_perguruan_tinggi` varchar(50) DEFAULT NULL,
  `kode_perguruan_tinggi` varchar(10) DEFAULT NULL,
  `id_kelas` varchar(50) DEFAULT NULL,
  `id_matkul` varchar(50) DEFAULT NULL,
  `id_periode` varchar(10) DEFAULT NULL,
  `id_prodi` varchar(50) DEFAULT NULL,
  `id_registrasi_mahasiswa` varchar(50) DEFAULT NULL,
  `nama_kelas_kuliah` varchar(10) DEFAULT NULL,
  `nama_mahasiswa` varchar(200) DEFAULT NULL,
  `nama_mata_kuliah` varchar(200) DEFAULT NULL,
  `nama_program_studi` varchar(200) DEFAULT NULL,
  `nilai_angka` varchar(10) DEFAULT NULL,
  `nilai_huruf` varchar(10) DEFAULT NULL,
  `nilai_indeks` varchar(10) DEFAULT NULL,
  `nim` varchar(100) DEFAULT NULL,
  `sks_mata_kuliah` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for feeder_nilaitransfer
-- ----------------------------
DROP TABLE IF EXISTS `feeder_nilaitransfer`;
CREATE TABLE `feeder_nilaitransfer` (
  `id_matkul` varchar(100) DEFAULT NULL,
  `id_periode_masuk` varchar(10) DEFAULT NULL,
  `id_perguruan_tinggi` varchar(50) DEFAULT NULL,
  `kode_perguruan_tinggi` varchar(10) DEFAULT NULL,
  `id_prodi` varchar(50) DEFAULT NULL,
  `id_registrasi_mahasiswa` varchar(50) DEFAULT NULL,
  `id_transfer` varchar(50) DEFAULT NULL,
  `kode_mata_kuliah_asal` varchar(100) DEFAULT NULL,
  `kode_matkul_diakui` varchar(100) DEFAULT NULL,
  `nama_mahasiswa` varchar(100) DEFAULT NULL,
  `nama_mata_kuliah_asal` varchar(200) DEFAULT NULL,
  `nama_mata_kuliah_diakui` varchar(200) DEFAULT NULL,
  `nama_program_studi` varchar(200) DEFAULT NULL,
  `nilai_angka_diakui` varchar(5) DEFAULT NULL,
  `nilai_huruf_asal` varchar(5) DEFAULT NULL,
  `nilai_huruf_diakui` varchar(5) DEFAULT NULL,
  `nim` varchar(100) DEFAULT NULL,
  `sks_mata_kuliah_asal` varchar(50) DEFAULT NULL,
  `sks_mata_kuliah_diakui` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for feeder_profilpt
-- ----------------------------
DROP TABLE IF EXISTS `feeder_profilpt`;
CREATE TABLE `feeder_profilpt` (
  `id_perguruan_tinggi` varchar(200) NOT NULL,
  `kode_perguruan_tinggi` varchar(7) DEFAULT NULL,
  `nama_perguruan_tinggi` varchar(255) DEFAULT NULL,
  `telepon` varchar(100) DEFAULT NULL,
  `faximile` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `jalan` text DEFAULT NULL,
  `dusun` varchar(100) DEFAULT NULL,
  `rt_rw` varchar(100) DEFAULT NULL,
  `kelurahan` varchar(100) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `id_wilayah` varchar(10) DEFAULT NULL,
  `nama_wilayah` varchar(255) DEFAULT NULL,
  `lintang_bujur` varchar(255) DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `unit_cabang` varchar(255) DEFAULT NULL,
  `nomor_rekening` varchar(200) DEFAULT NULL,
  `mbs` varchar(100) DEFAULT NULL,
  `luas_tanah_milik` varchar(100) DEFAULT NULL,
  `luas_tanah_bukan_milik` varchar(100) DEFAULT NULL,
  `sk_pendirian` varchar(100) DEFAULT NULL,
  `tanggal_sk_pendirian` date DEFAULT NULL,
  `id_status_milik` varchar(5) DEFAULT NULL,
  `nama_status_milik` varchar(100) DEFAULT NULL,
  `status_perguruan_tinggi` varchar(100) DEFAULT NULL,
  `sk_izin_operasional` varchar(255) DEFAULT NULL,
  `tanggal_izin_operasional` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for feeder_riwayatpendidikan
-- ----------------------------
DROP TABLE IF EXISTS `feeder_riwayatpendidikan`;
CREATE TABLE `feeder_riwayatpendidikan` (
  `kode_perguruan_tinggi` varchar(10) DEFAULT NULL,
  `biaya_masuk` varchar(100) DEFAULT NULL,
  `id_bidang_minat` varchar(100) DEFAULT NULL,
  `id_jalur_daftar` varchar(200) DEFAULT NULL,
  `id_jenis_daftar` varchar(5) DEFAULT NULL,
  `id_jenis_keluar` varchar(5) DEFAULT NULL,
  `id_mahasiswa` varchar(50) DEFAULT NULL,
  `id_pembiayaan` varchar(100) DEFAULT NULL,
  `id_perguruan_tinggi` varchar(50) DEFAULT NULL,
  `id_perguruan_tinggi_asal` varchar(100) DEFAULT NULL,
  `id_periode_masuk` varchar(10) DEFAULT NULL,
  `id_prodi` varchar(50) DEFAULT NULL,
  `id_prodi_asal` varchar(50) DEFAULT NULL,
  `id_registrasi_mahasiswa` varchar(50) DEFAULT NULL,
  `jenis_kelamin` varchar(10) DEFAULT NULL,
  `keterangan_keluar` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(200) DEFAULT NULL,
  `nama_jenis_daftar` varchar(100) DEFAULT NULL,
  `nama_mahasiswa` varchar(150) DEFAULT NULL,
  `nama_pembiayaan_awal` varchar(100) DEFAULT NULL,
  `nama_perguruan_tinggi` varchar(200) DEFAULT NULL,
  `nama_perguruan_tinggi_asal` varchar(200) DEFAULT NULL,
  `nama_periode_masuk` varchar(100) DEFAULT NULL,
  `nama_program_studi` varchar(100) DEFAULT NULL,
  `nama_program_studi_asal` varchar(100) DEFAULT NULL,
  `nim` varchar(100) DEFAULT NULL,
  `nm_bidang_minat` varchar(100) DEFAULT NULL,
  `sks_diakui` varchar(100) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for ref_getagama
-- ----------------------------
DROP TABLE IF EXISTS `ref_getagama`;
CREATE TABLE `ref_getagama` (
  `id_agama` varchar(10) NOT NULL DEFAULT '',
  `nama_agama` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_agama`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for ref_getalattransportasi
-- ----------------------------
DROP TABLE IF EXISTS `ref_getalattransportasi`;
CREATE TABLE `ref_getalattransportasi` (
  `id_alat_transportasi` varchar(10) NOT NULL DEFAULT '',
  `nama_alat_transportasi` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_alat_transportasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for ref_getjenjangpendidikan
-- ----------------------------
DROP TABLE IF EXISTS `ref_getjenjangpendidikan`;
CREATE TABLE `ref_getjenjangpendidikan` (
  `id_jenjang_didik` varchar(5) NOT NULL,
  `nama_jenjang_didik` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_jenjang_didik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for ref_getnegara
-- ----------------------------
DROP TABLE IF EXISTS `ref_getnegara`;
CREATE TABLE `ref_getnegara` (
  `id_negara` varchar(10) NOT NULL DEFAULT '',
  `nama_negara` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_negara`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for ref_getpekerjaan
-- ----------------------------
DROP TABLE IF EXISTS `ref_getpekerjaan`;
CREATE TABLE `ref_getpekerjaan` (
  `id_pekerjaan` varchar(10) NOT NULL DEFAULT '',
  `nama_pekerjaan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_pekerjaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for ref_getpenghasilan
-- ----------------------------
DROP TABLE IF EXISTS `ref_getpenghasilan`;
CREATE TABLE `ref_getpenghasilan` (
  `id_penghasilan` varchar(10) NOT NULL DEFAULT '',
  `nama_penghasilan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_penghasilan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for ref_getsemester
-- ----------------------------
DROP TABLE IF EXISTS `ref_getsemester`;
CREATE TABLE `ref_getsemester` (
  `a_periode_aktif` varchar(50) DEFAULT NULL,
  `id_semester` varchar(50) DEFAULT NULL,
  `id_tahun_ajaran` varchar(100) DEFAULT NULL,
  `nama_semester` varchar(100) DEFAULT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for ref_getwilayah
-- ----------------------------
DROP TABLE IF EXISTS `ref_getwilayah`;
CREATE TABLE `ref_getwilayah` (
  `id_wilayah` varchar(10) NOT NULL DEFAULT '',
  `id_negara` varchar(10) DEFAULT '',
  `nama_wilayah` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_wilayah`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for siakad_akm
-- ----------------------------
DROP TABLE IF EXISTS `siakad_akm`;
CREATE TABLE `siakad_akm` (
  `id_akm` int(11) NOT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `nim` varchar(50) DEFAULT NULL,
  `status_mahasiswa` varchar(10) DEFAULT NULL,
  `ips` varchar(10) DEFAULT NULL,
  `sks` varchar(10) DEFAULT NULL,
  `ipk` varchar(10) DEFAULT NULL,
  `sks_total` varchar(10) DEFAULT NULL,
  `status_error` varchar(10) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id_akm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for siakad_akun
-- ----------------------------
DROP TABLE IF EXISTS `siakad_akun`;
CREATE TABLE `siakad_akun` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kodept` varchar(10) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT '',
  `email` varchar(200) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `userlevel` varchar(5) DEFAULT '',
  `akses` varchar(100) DEFAULT NULL,
  `date_create` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for siakad_kelas
-- ----------------------------
DROP TABLE IF EXISTS `siakad_kelas`;
CREATE TABLE `siakad_kelas` (
  `id_kelas` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kodept` varchar(10) DEFAULT '',
  `kode_prodi` varchar(10) DEFAULT NULL,
  `id_prodi` varchar(5) DEFAULT NULL,
  `bahasan` varchar(100) DEFAULT NULL,
  `id_kelas_kuliah_ws` varchar(50) DEFAULT NULL,
  `id_matkul_ws` varchar(50) DEFAULT NULL,
  `id_prodi_ws` varchar(50) DEFAULT NULL,
  `id_semester` varchar(50) DEFAULT '',
  `kode_mata_kuliah` varchar(50) DEFAULT NULL,
  `nama_mata_kuliah` varchar(200) DEFAULT NULL,
  `nama_kelas_kuliah` varchar(5) DEFAULT NULL,
  `nama_program_studi` varchar(200) DEFAULT '',
  `nama_semester` varchar(10) DEFAULT '',
  `tanggal_akhir_efektif` date DEFAULT NULL,
  `tanggal_mulai_efektif` date DEFAULT NULL,
  PRIMARY KEY (`id_kelas`),
  UNIQUE KEY `id_kelas_kuliah_ws` (`id_kelas_kuliah_ws`)
) ENGINE=InnoDB AUTO_INCREMENT=1864 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for siakad_kurikulum
-- ----------------------------
DROP TABLE IF EXISTS `siakad_kurikulum`;
CREATE TABLE `siakad_kurikulum` (
  `id_kurikulum` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_kurikulum_ws` varchar(50) DEFAULT NULL,
  `kodept` varchar(10) DEFAULT NULL,
  `id_prodi` varchar(10) DEFAULT NULL,
  `kode_prodi` varchar(10) DEFAULT NULL,
  `id_prodi_ws` varchar(50) DEFAULT NULL,
  `id_semester` varchar(50) DEFAULT NULL,
  `jumlah_sks_lulus` varchar(10) DEFAULT NULL,
  `jumlah_sks_pilihan` varchar(10) DEFAULT NULL,
  `jumlah_sks_wajib` varchar(10) DEFAULT NULL,
  `nama_kurikulum` varchar(200) DEFAULT NULL,
  `semester_mulai_berlaku` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_kurikulum`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for siakad_kurikulummatakuliah
-- ----------------------------
DROP TABLE IF EXISTS `siakad_kurikulummatakuliah`;
CREATE TABLE `siakad_kurikulummatakuliah` (
  `id_kurikulummatakuliah` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kodept` varchar(10) DEFAULT NULL,
  `id_kurikulum` int(11) DEFAULT NULL,
  `id_perguruan_tinggi_ws` varchar(50) DEFAULT '',
  `id_kurikulum_ws` varchar(50) DEFAULT '',
  `id_prodi_ws` varchar(50) DEFAULT '',
  `id_matkul_ws` varchar(50) DEFAULT '',
  `id_semester` varchar(50) DEFAULT '',
  `kode_prodi` varchar(200) DEFAULT '',
  `kode_mata_kuliah` varchar(50) DEFAULT NULL,
  `semester` varchar(50) DEFAULT '',
  PRIMARY KEY (`id_kurikulummatakuliah`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for siakad_mahasiswa
-- ----------------------------
DROP TABLE IF EXISTS `siakad_mahasiswa`;
CREATE TABLE `siakad_mahasiswa` (
  `id_mahasiswa` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kodept` varchar(10) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `id_mahasiswa_ws` varchar(100) NOT NULL DEFAULT '',
  `nama_mahasiswa` varchar(100) NOT NULL DEFAULT '',
  `jenis_kelamin` varchar(5) NOT NULL,
  `jalan` varchar(100) DEFAULT NULL,
  `rt` varchar(5) DEFAULT NULL,
  `rw` varchar(5) DEFAULT NULL,
  `dusun` varchar(100) DEFAULT NULL,
  `kelurahan` varchar(100) NOT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `tanggal_lahir_ayah` date DEFAULT NULL,
  `nik_ayah` varchar(20) DEFAULT NULL,
  `id_pendidikan_ayah` varchar(2) DEFAULT '',
  `id_pekerjaan_ayah` varchar(5) DEFAULT '',
  `id_penghasilan_ayah` varchar(5) DEFAULT '',
  `id_kebutuhan_khusus_ayah` varchar(2) NOT NULL DEFAULT '0',
  `nama_ibu_kandung` varchar(100) NOT NULL,
  `tanggal_lahir_ibu` date DEFAULT NULL,
  `nik_ibu` varchar(20) DEFAULT NULL,
  `id_pendidikan_ibu` varchar(5) DEFAULT '',
  `id_pekerjaan_ibu` varchar(2) DEFAULT NULL,
  `id_penghasilan_ibu` varchar(2) DEFAULT NULL,
  `id_kebutuhan_khusus_ibu` varchar(2) NOT NULL DEFAULT '0',
  `nama_wali` varchar(100) DEFAULT NULL,
  `tanggal_lahir_wali` date DEFAULT NULL,
  `id_pendidikan_wali` varchar(2) DEFAULT '',
  `id_pekerjaan_wali` varchar(2) DEFAULT NULL,
  `id_penghasilan_wali` varchar(2) DEFAULT NULL,
  `id_kebutuhan_khusus_mahasiswa` varchar(2) DEFAULT '0',
  `telepon` varchar(20) DEFAULT NULL,
  `handphone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `penerima_kps` enum('1','0') NOT NULL DEFAULT '0',
  `nomor_kps` varchar(100) DEFAULT '',
  `npwp` varchar(20) DEFAULT NULL,
  `id_wilayah` varchar(10) NOT NULL,
  `id_jenis_tinggal` varchar(2) DEFAULT NULL,
  `id_agama` varchar(5) NOT NULL,
  `id_alat_transportasi` varchar(5) DEFAULT NULL,
  `kewarganegaraan` varchar(5) NOT NULL,
  `datecreated` datetime DEFAULT NULL,
  `usercreated` varchar(100) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_mahasiswa`)
) ENGINE=InnoDB AUTO_INCREMENT=1817 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for siakad_mahasiswa_mendaftar
-- ----------------------------
DROP TABLE IF EXISTS `siakad_mahasiswa_mendaftar`;
CREATE TABLE `siakad_mahasiswa_mendaftar` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `kodept` varchar(6) NOT NULL DEFAULT '',
  `semester` varchar(5) NOT NULL DEFAULT '',
  `jenis_pendaftaran` varchar(200) DEFAULT NULL,
  `jalur_pendaftaran` varchar(200) DEFAULT NULL,
  `kelas_pendaftaran` varchar(100) DEFAULT NULL,
  `prodi` varchar(100) DEFAULT NULL,
  `id_prodi` varchar(100) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `jenis_kelamin` varchar(100) DEFAULT NULL,
  `nik` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `agama` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `rt` varchar(30) DEFAULT NULL,
  `rw` varchar(30) DEFAULT NULL,
  `dusun` varchar(100) DEFAULT NULL,
  `kelurahan` varchar(100) DEFAULT NULL,
  `kecamatan` varchar(200) DEFAULT NULL,
  `kota_kabupaten` varchar(200) DEFAULT NULL,
  `kodepos` varchar(10) DEFAULT NULL,
  `jenis_tinggal` varchar(200) DEFAULT '',
  `hp` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `no_kis` varchar(200) DEFAULT NULL,
  `no_kip` varchar(200) DEFAULT NULL,
  `no_kps` varchar(200) DEFAULT NULL,
  `no_kks` varchar(200) DEFAULT NULL,
  `kewarganegaraan` varchar(30) DEFAULT NULL,
  `pend_terakhir` varchar(100) DEFAULT NULL,
  `sekolah_asal` varchar(200) DEFAULT NULL,
  `tahun_lulus` year(4) DEFAULT NULL,
  `prestasi` text DEFAULT NULL,
  `wali_nama` varchar(100) DEFAULT NULL,
  `wali_ktp` varchar(100) DEFAULT NULL,
  `wali_tempat_lahir` varchar(200) DEFAULT NULL,
  `wali_tanggal_lahir` date DEFAULT NULL,
  `wali_agama` varchar(100) DEFAULT NULL,
  `wali_alamat` text DEFAULT NULL,
  `wali_rt` varchar(10) DEFAULT NULL,
  `wali_rw` varchar(10) DEFAULT NULL,
  `wali_dusun` varchar(100) DEFAULT NULL,
  `wali_kelurahan` varchar(100) DEFAULT NULL,
  `wali_kecamatan` varchar(100) DEFAULT NULL,
  `wali_kota_kabupaten` varchar(100) DEFAULT NULL,
  `wali_kodepos` varchar(10) DEFAULT NULL,
  `wali_hp` varchar(100) DEFAULT NULL,
  `wali_pendidikan` varchar(100) DEFAULT NULL,
  `wali_pekerjaan` varchar(100) DEFAULT NULL,
  `pekerjaan_perusahaan` varchar(200) DEFAULT NULL,
  `pekerjaan_alamat` text DEFAULT NULL,
  `pekerjaan_rt` varchar(10) DEFAULT NULL,
  `pekerjaan_rw` varchar(10) DEFAULT NULL,
  `pekerjaan_dusun` varchar(100) DEFAULT NULL,
  `pekerjaan_kelurahan` varchar(100) DEFAULT NULL,
  `pekerjaan_kecamatan` varchar(100) DEFAULT NULL,
  `pekerjaan_kabupaten` varchar(100) DEFAULT NULL,
  `pekerjaan_kodepos` varchar(10) DEFAULT NULL,
  `pekerjaan_telepon` varchar(100) DEFAULT NULL,
  `pindahan_pt` varchar(200) DEFAULT NULL,
  `pindahan_fakultas` varchar(100) DEFAULT NULL,
  `pindahan_prodi` varchar(200) DEFAULT NULL,
  `pindahan_akreditasi` varchar(10) DEFAULT NULL,
  `pindahan_jenjang` varchar(20) DEFAULT NULL,
  `pindahan_semester` varchar(10) DEFAULT NULL,
  `pindahan_sks` varchar(10) DEFAULT NULL,
  `status_terima` varchar(100) DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `usercreated` varchar(100) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdated` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for siakad_matakuliah
-- ----------------------------
DROP TABLE IF EXISTS `siakad_matakuliah`;
CREATE TABLE `siakad_matakuliah` (
  `id_matakuliah` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_matkul_ws` varchar(50) DEFAULT NULL,
  `kodept` varchar(10) DEFAULT NULL,
  `kode_prodi` varchar(10) DEFAULT '',
  `id_prodi_ws` varchar(50) DEFAULT '',
  `ada_acara_praktek` varchar(50) DEFAULT NULL,
  `ada_bahan_ajar` varchar(50) DEFAULT NULL,
  `ada_diktat` varchar(50) DEFAULT NULL,
  `ada_sap` varchar(50) DEFAULT NULL,
  `ada_silabus` varchar(50) DEFAULT NULL,
  `id_jenis_matakuliah` enum('S','D','C','B','A') DEFAULT NULL,
  `id_kelompok_matakuliah` enum('H','G','F','E','D','C','B','A') DEFAULT NULL,
  `kode_matakuliah` varchar(50) DEFAULT NULL,
  `metode_kuliah` varchar(50) DEFAULT NULL,
  `nama_matakuliah` varchar(200) DEFAULT NULL,
  `sks_matakuliah` varchar(10) DEFAULT NULL,
  `sks_praktek` varchar(10) DEFAULT NULL,
  `sks_praktek_lapangan` varchar(10) DEFAULT NULL,
  `sks_simulasi` varchar(10) DEFAULT NULL,
  `sks_tatapmuka` varchar(10) DEFAULT NULL,
  `tanggal_mulai_efektif` date DEFAULT NULL,
  `tanggal_akhir_efektif` date DEFAULT NULL,
  PRIMARY KEY (`id_matakuliah`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for siakad_nilai
-- ----------------------------
DROP TABLE IF EXISTS `siakad_nilai`;
CREATE TABLE `siakad_nilai` (
  `id_nilai` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kodept` varchar(10) DEFAULT NULL,
  `nim` varchar(50) DEFAULT NULL,
  `kode_matakuliah` varchar(20) DEFAULT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `kode_prodi` varchar(10) DEFAULT NULL,
  `nilai_huruf` varchar(10) DEFAULT NULL,
  `nilai_indeks` varchar(255) DEFAULT NULL,
  `id_prodi` varchar(50) DEFAULT NULL,
  `id_kelas_ws` varchar(50) DEFAULT NULL,
  `id_matkul_ws` varchar(50) DEFAULT NULL,
  `id_periode_ws` varchar(50) DEFAULT NULL,
  `id_registrasi_mahasiswa` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_nilai`)
) ENGINE=InnoDB AUTO_INCREMENT=2480 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for siakad_prodi
-- ----------------------------
DROP TABLE IF EXISTS `siakad_prodi`;
CREATE TABLE `siakad_prodi` (
  `id_prodi` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_prodi_ws` varchar(50) DEFAULT NULL,
  `kodept` varchar(10) DEFAULT NULL,
  `kode_prodi` varchar(10) DEFAULT NULL,
  `nama_prodi` varchar(200) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `id_jenjang` varchar(10) DEFAULT NULL,
  `softdelete` enum('N','Y') DEFAULT 'N',
  PRIMARY KEY (`id_prodi`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for siakad_profil
-- ----------------------------
DROP TABLE IF EXISTS `siakad_profil`;
CREATE TABLE `siakad_profil` (
  `kodept` varchar(20) NOT NULL,
  `logopt` varchar(255) DEFAULT '',
  PRIMARY KEY (`kodept`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for siakad_riwayatpendidikan
-- ----------------------------
DROP TABLE IF EXISTS `siakad_riwayatpendidikan`;
CREATE TABLE `siakad_riwayatpendidikan` (
  `id_riwayatpendidikan` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_prodi` int(11) DEFAULT NULL,
  `id_mahasiswa` int(11) DEFAULT NULL,
  `kodept` varchar(10) DEFAULT '',
  `kode_prodi` varchar(10) DEFAULT '',
  `biaya_masuk` varchar(100) DEFAULT '',
  `id_bidang_minat` varchar(100) DEFAULT '',
  `id_jalur_daftar` varchar(200) DEFAULT '',
  `id_jenis_daftar` varchar(5) DEFAULT '',
  `id_jenis_keluar` varchar(5) DEFAULT '',
  `id_mahasiswa_ws` varchar(50) DEFAULT '',
  `id_pembiayaan` varchar(100) DEFAULT '',
  `id_perguruan_tinggi` varchar(50) DEFAULT '',
  `id_perguruan_tinggi_asal` varchar(100) DEFAULT '',
  `id_periode_masuk` varchar(10) DEFAULT '',
  `id_prodi_ws` varchar(50) DEFAULT '',
  `id_prodi_asal` varchar(50) DEFAULT NULL,
  `id_registrasi_mahasiswa` varchar(50) DEFAULT NULL,
  `keterangan_keluar` varchar(100) DEFAULT NULL,
  `nama_jenis_daftar` varchar(100) DEFAULT NULL,
  `nama_pembiayaan_awal` varchar(100) DEFAULT NULL,
  `nama_perguruan_tinggi` varchar(200) DEFAULT NULL,
  `nama_perguruan_tinggi_asal` varchar(200) DEFAULT NULL,
  `nama_periode_masuk` varchar(100) DEFAULT NULL,
  `nama_program_studi` varchar(100) DEFAULT NULL,
  `nama_program_studi_asal` varchar(100) DEFAULT NULL,
  `nim` varchar(100) DEFAULT NULL,
  `nm_bidang_minat` varchar(100) DEFAULT NULL,
  `sks_diakui` varchar(100) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  PRIMARY KEY (`id_riwayatpendidikan`)
) ENGINE=InnoDB AUTO_INCREMENT=3629 DEFAULT CHARSET=utf8mb4;
