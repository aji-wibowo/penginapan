-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 17, 2020 at 05:13 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `kd_admin` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `domain_kantor` varchar(50) NOT NULL,
  `kd_lokasi` int(11) NOT NULL,
  PRIMARY KEY (`kd_admin`),
  KEY `kd_lokasi` (`kd_lokasi`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`kd_admin`, `username`, `password`, `nama`, `email`, `domain_kantor`, `kd_lokasi`) VALUES
(1, 'admin_pemalang', '$2y$10$GlaJy1BscESy2Ezj9F72KOjaRyNfYkS4VLLFFfb4MR7Gm4bsL73wm', 'admin pemalang', 'admin@admin.com', 'Pemalang', 2);

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

DROP TABLE IF EXISTS `kamar`;
CREATE TABLE IF NOT EXISTS `kamar` (
  `kd_kamar` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kamar` varchar(30) NOT NULL,
  `tipe_kamar` varchar(25) NOT NULL,
  `deskripsi_kamar` text NOT NULL,
  `alamat_kamar` varchar(200) NOT NULL,
  `harga_kamar` double NOT NULL,
  `kd_lokasi` int(11) NOT NULL,
  PRIMARY KEY (`kd_kamar`),
  KEY `kd_lokasi` (`kd_lokasi`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`kd_kamar`, `nama_kamar`, `tipe_kamar`, `deskripsi_kamar`, `alamat_kamar`, `harga_kamar`, `kd_lokasi`) VALUES
(1, '101', 'Double Bed', '', 'Hotel Wikwik, Jl. Kelapa Gading Gajah, No. 56, Jakarta Tengah, Jakarta, Amerika', 5000000, 1),
(2, '102', 'Single Bed', '', 'Hotel Wikwik, Jl. Kelapa Gading Gajah, No. 56, Jakarta Tengah, Jakarta, Amerika', 200000, 1),
(6, '123', 'Single Bed', 'Wah lezat', 'Jl. Cintakuh Padamuh', 100000, 2),
(7, 'Melati', 'Double Bed', 'Kasurnya dua cuy\r\nBisa wat wikuwik', 'Jl. Cintakuh Padamuh gang 69', 150000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

DROP TABLE IF EXISTS `lokasi`;
CREATE TABLE IF NOT EXISTS `lokasi` (
  `kd_lokasi` int(11) NOT NULL AUTO_INCREMENT,
  `kota` varchar(20) NOT NULL,
  PRIMARY KEY (`kd_lokasi`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`kd_lokasi`, `kota`) VALUES
(1, 'Jakarta'),
(2, 'Pemalang');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

DROP TABLE IF EXISTS `pembayaran`;
CREATE TABLE IF NOT EXISTS `pembayaran` (
  `kd_bayar` varchar(15) NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `kd_reservasi` varchar(15) NOT NULL,
  `status` enum('pending','expired','lunas') NOT NULL,
  PRIMARY KEY (`kd_bayar`),
  KEY `kd_reservasi` (`kd_reservasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`kd_bayar`, `tgl_bayar`, `kd_reservasi`, `status`) VALUES
('BYR002', '0000-00-00 00:00:00', 'RV001', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

DROP TABLE IF EXISTS `penilaian`;
CREATE TABLE IF NOT EXISTS `penilaian` (
  `kd_penilaian` int(11) NOT NULL AUTO_INCREMENT,
  `nilai` enum('1','2','3','4','5') NOT NULL,
  `ulasan` text NOT NULL,
  PRIMARY KEY (`kd_penilaian`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`kd_penilaian`, `nilai`, `ulasan`) VALUES
(1, '3', 'Mantap');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

DROP TABLE IF EXISTS `reservasi`;
CREATE TABLE IF NOT EXISTS `reservasi` (
  `kd_reservasi` varchar(15) NOT NULL,
  `kd_tamu` int(11) NOT NULL,
  `kd_kamar` int(11) NOT NULL,
  `cekin` date NOT NULL,
  `cekout` date NOT NULL,
  `total_bayar` double NOT NULL,
  `kd_admin` int(11) NOT NULL,
  PRIMARY KEY (`kd_reservasi`),
  KEY `kd_tamu` (`kd_tamu`),
  KEY `kd_kamar` (`kd_kamar`),
  KEY `kd_admin` (`kd_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservasi`
--

INSERT INTO `reservasi` (`kd_reservasi`, `kd_tamu`, `kd_kamar`, `cekin`, `cekout`, `total_bayar`, `kd_admin`) VALUES
('RV001', 1, 7, '2020-04-15', '2020-04-16', 150000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tamu`
--

DROP TABLE IF EXISTS `tamu`;
CREATE TABLE IF NOT EXISTS `tamu` (
  `kd_tamu` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(16) NOT NULL,
  `nama_t` varchar(128) NOT NULL,
  `alamat` text NOT NULL,
  `asal_kantor` varchar(128) NOT NULL,
  `no_tlp` varchar(16) NOT NULL,
  `email_t` varchar(128) NOT NULL,
  `username_t` varchar(128) NOT NULL,
  `password_t` varchar(128) NOT NULL,
  PRIMARY KEY (`kd_tamu`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tamu`
--

INSERT INTO `tamu` (`kd_tamu`, `nik`, `nama_t`, `alamat`, `asal_kantor`, `no_tlp`, `email_t`, `username_t`, `password_t`) VALUES
(1, '1234', 'Bejo', 'Jl. Ku mencintaymuh, Rt6,Rw9', 'Sulawesi', '08123232323', 'guest0@guest.com', 'guest', '$2y$10$354I9IH1p9HHgLBrie/HT.7Zwbxhi4ySHESe3AYFO35VLOJwUwvJC');

-- --------------------------------------------------------

--
-- Table structure for table `web_settings`
--

DROP TABLE IF EXISTS `web_settings`;
CREATE TABLE IF NOT EXISTS `web_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `web_name` varchar(128) NOT NULL,
  `web_title` varchar(128) NOT NULL,
  `web_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `web_settings`
--

INSERT INTO `web_settings` (`id`, `web_name`, `web_title`, `web_description`) VALUES
(1, 'Kehotel Kuy', 'Kehotel Kuy - hotel ya disini', 'Ini deskripsinya kuy');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`kd_lokasi`) REFERENCES `lokasi` (`kd_lokasi`);

--
-- Constraints for table `kamar`
--
ALTER TABLE `kamar`
  ADD CONSTRAINT `kamar_ibfk_1` FOREIGN KEY (`kd_lokasi`) REFERENCES `lokasi` (`kd_lokasi`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`kd_reservasi`) REFERENCES `reservasi` (`kd_reservasi`);

--
-- Constraints for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`kd_admin`) REFERENCES `admin` (`kd_admin`),
  ADD CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`kd_kamar`) REFERENCES `kamar` (`kd_kamar`),
  ADD CONSTRAINT `reservasi_ibfk_3` FOREIGN KEY (`kd_tamu`) REFERENCES `tamu` (`kd_tamu`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
