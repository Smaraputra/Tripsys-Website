-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2023 at 04:41 PM
-- Server version: 10.4.24-MariaDB-log
-- PHP Version: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

USE wisatasys;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wisatasys`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `login` (IN `tipelogin` INT(255), IN `email` VARCHAR(255), IN `inpassword` VARCHAR(255))   BEGIN
	DECLARE nama VARCHAR(255);
	DECLARE id INT;
	DECLARE jabatan VARCHAR(255);
	DECLARE cek_data INT;
	DECLARE status_login INT;
	
	IF tipelogin="1" THEN
		SET cek_data = (SELECT COUNT(pelanggan.`id_pelanggan`) FROM pelanggan WHERE pelanggan.`email` = email AND pelanggan.`password` = inpassword);
		IF cek_data = 1 THEN
			SELECT pelanggan.`nama` INTO nama FROM pelanggan  WHERE pelanggan.`email` = email AND pelanggan.`password` = inpassword;
			SELECT pelanggan.`id_pelanggan` INTO id FROM pelanggan  WHERE pelanggan.`email` = email AND pelanggan.`password` = inpassword;
			SELECT "Pengguna" INTO jabatan;
			SELECT 1 INTO status_login;
		ELSE
			SELECT 0 INTO status_login;
		END IF;
	ELSEIF tipelogin="2" THEN
		SET cek_data = (SELECT COUNT(tourguide.`id_tourguide`) FROM tourguide WHERE tourguide.`email` = email AND tourguide.`password` = inpassword);
		IF cek_data = 1 THEN
			SELECT tourguide.`nama` INTO nama FROM tourguide  WHERE tourguide.`email` = email AND tourguide.`password` = inpassword;
			SELECT tourguide.`id_tourguide` INTO id FROM tourguide  WHERE tourguide.`email` = email AND tourguide.`password` = inpassword;
			SELECT "Tour Guide" INTO jabatan;
			SELECT 1 INTO status_login;
		ELSE
			SELECT 0 INTO status_login;
		END IF;
	ELSE
		SET cek_data = (SELECT COUNT(admin.`id_admin`) FROM admin WHERE admin.`email` = email AND admin.`password` = inpassword);
		IF cek_data = 1 THEN
			SELECT admin.`nama` INTO nama FROM admin  WHERE admin.`email` = email AND admin.`password` = inpassword;
			SELECT admin.`id_admin` INTO id FROM admin  WHERE admin.`email` = email AND admin.`password` = inpassword;
			SELECT "Admin" INTO jabatan;
			SELECT 1 INTO status_login;
		ELSE
			SELECT 0 INTO status_login;
		END IF;
	END IF;
	
	SELECT id, nama, jabatan, status_login;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `signup` (IN `nama` VARCHAR(255), IN `alamat` VARCHAR(255), IN `telpon` VARCHAR(255), IN `travel` INT(11), IN `email` VARCHAR(255), IN `inpassword` VARCHAR(255), IN `tipeakun` VARCHAR(255))  NO SQL BEGIN
	DECLARE status_signup INT;
	DECLARE cek_data INT;
	
	IF tipeakun="1" THEN
		SET cek_data = (SELECT COUNT(pelanggan.`id_pelanggan`) FROM pelanggan WHERE pelanggan.`email` = email);
		IF cek_data = 1 THEN
			SELECT 0 INTO status_signup;
		ELSE
			INSERT INTO pelanggan (nama, alamat, telpon, email, `password`) VALUES (nama, alamat, telpon, email, inpassword);
			SELECT 1 INTO status_signup;
		END IF;
	ELSE
		SET cek_data = (SELECT COUNT(tourguide.`id_tourguide`) FROM tourguide WHERE tourguide.`email` = email);
		IF cek_data = 1 THEN
			SELECT 0 INTO status_signup;
		ELSE
			INSERT INTO tourguide (id_travel, nama, alamat, email, `password`) VALUES (travel, nama, alamat, email, inpassword);
			SELECT 1 INTO status_signup;
		END IF;
	END IF;
	
	SELECT status_signup;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `email`, `password`) VALUES
(1, 'Parto', 'parto@gmail.com', 'parto1'),
(2, 'Suati', 'suati@gmail.com', 'suati1'),
(3, 'Susi', 'susi@gmail.com', 'susi1'),
(4, 'Puji', 'puji@gmail.com', 'puji1'),
(5, 'Astuti', 'astuti@gmail.com', 'astuti1');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id_bank` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id_bank`, `nama`) VALUES
(1, 'BNI'),
(2, 'Bank Indonesia'),
(3, 'BCA'),
(4, 'Permata'),
(5, 'BRI');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id_fasilitas` int(11) NOT NULL,
  `id_travel` int(11) DEFAULT NULL,
  `id_nama_wisata` int(11) DEFAULT NULL,
  `nama_fasilitas` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `status` enum('Standar','Tambahan') DEFAULT NULL,
  `tuntunan` enum('Perlu','Tidak') DEFAULT NULL,
  `perpax` enum('Perorang','Kelompok') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`id_fasilitas`, `id_travel`, `id_nama_wisata`, `nama_fasilitas`, `deskripsi`, `harga`, `status`, `tuntunan`, `perpax`) VALUES
(1, 1, 1, 'Makanan', 'Nasi Kuning Ayam', 15000, 'Standar', 'Tidak', 'Perorang'),
(2, 1, 1, 'Minuman', 'Air Putih', 5000, 'Standar', 'Tidak', 'Perorang'),
(3, 1, 1, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 'Standar', 'Tidak', 'Perorang'),
(4, 1, 1, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 'Tambahan', 'Perlu', 'Kelompok'),
(5, 1, 1, 'Atraksi', 'Izin Menonton Atraksi Yang Ada', 10000, 'Tambahan', 'Tidak', 'Perorang'),
(6, 2, 1, 'Makanan', 'Nasi Kuning Ayam Soto', 15000, 'Standar', 'Tidak', 'Perorang'),
(7, 2, 1, 'Minuman', 'Air Putih', 5000, 'Standar', 'Tidak', 'Perorang'),
(8, 2, 1, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 'Standar', 'Tidak', 'Perorang'),
(9, 2, 1, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 'Tambahan', 'Perlu', 'Kelompok'),
(10, 2, 1, 'Atraksi', 'Izin Menonton Atraksi Yang Ada', 10000, 'Tambahan', 'Tidak', 'Perorang'),
(11, 2, 2, 'Makanan', 'Nasi Ayam Pedas', 10000, 'Standar', 'Tidak', 'Perorang'),
(12, 2, 2, 'Tiket Masuk', 'Tiket untuk masuk ke tempat wisata', 20000, 'Standar', 'Tidak', 'Perorang'),
(13, 2, 2, 'Tour Guide', 'Tuntunan dari tour guide', 70000, 'Tambahan', 'Perlu', 'Kelompok'),
(14, 2, 2, 'Atraksi', 'Izin menyaksikan atraksi dalam tempat', 25000, 'Tambahan', 'Tidak', 'Perorang'),
(15, 2, 2, 'Cinderamata', 'Karya seni khas daerah wisata', 15000, 'Tambahan', 'Tidak', 'Perorang'),
(16, 3, 1, 'Makanan', 'Nasi Bubur Ayam', 15000, 'Standar', 'Tidak', 'Perorang'),
(17, 3, 1, 'Tiket', 'Tiket masuk ke dalam tempat wisata', 10000, 'Standar', 'Tidak', 'Perorang'),
(18, 3, 1, 'Tour Guide', 'Tuntunan dari tour guide', 50000, 'Tambahan', 'Perlu', 'Kelompok');

-- --------------------------------------------------------

--
-- Table structure for table `kredit`
--

CREATE TABLE `kredit` (
  `id_kredit` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kredit`
--

INSERT INTO `kredit` (`id_kredit`, `nama`) VALUES
(1, 'Kredit BNI'),
(2, 'Kredit US'),
(3, 'Kredit Permata'),
(4, 'Kredit BRI'),
(5, 'Kredit Mega');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` int(11) NOT NULL,
  `nama_lokasi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `nama_lokasi`) VALUES
(1, 'Tabanan'),
(2, 'Badung'),
(3, 'Denpasar'),
(4, 'Gianyar'),
(5, 'Karangasem'),
(6, 'Klungkung'),
(7, 'Buleleng'),
(8, 'Bangli'),
(9, 'Jembrana');

-- --------------------------------------------------------

--
-- Table structure for table `nama_wisata`
--

CREATE TABLE `nama_wisata` (
  `id_nama_wisata` int(11) NOT NULL,
  `id_lokasi` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nama_wisata`
--

INSERT INTO `nama_wisata` (`id_nama_wisata`, `id_lokasi`, `nama`, `kode`, `gambar`, `deskripsi`) VALUES
(1, 9, 'Wisata Tanah Lot', 'TL', 'https://theworldtravelguy.com/wp-content/uploads/2020/11/DJI_0950.jpg', 'Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata.'),
(2, 1, 'Wisata Bedugul', 'BL', 'https://th.bing.com/th/id/OIP.OOzjlxOpw-n-P4ns9f0ETQHaFj?pid=Api&w=1600&h=1200&rs=1', 'Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata.'),
(3, 3, 'Wisata Pantai Sanur', 'PS', 'https://i.pinimg.com/736x/f4/cc/34/f4cc343b669af913ac5f064e462aa00f--hotel-stay-roatan.jpg', 'Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata.'),
(4, 5, 'Wisata Pura Besakih', 'PB', 'http://fs.genpi.co/uploads/news/2019/01/03/5071c53e9de658bc02782a8932661d08.jpg', 'Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata.'),
(5, 2, 'Wisata Pura Taman Mumbul', 'PTM', 'https://raskitatour.com/wp-content/uploads/2018/12/59.-Taman-Mumbul.jpg', 'Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata.'),
(6, 2, 'Wisata GWK', 'GWK', 'https://asset.kompas.com/data/todaysphoto/foto/73f614858444241bddf143/p_1538011931600-gwk-bali.jpg', 'Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata.'),
(7, 2, 'Wisata Pantai Kuta', 'PK', 'https://th.bing.com/th/id/OIP.LlsGCSqKGdkgqv4LhQVlEwHaE8?pid=Api&rs=1', 'Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata.'),
(8, 2, 'Wisata Pura Luhur Uluwatu', 'PLU', 'https://balicheapesttours.com/dummy/uluwatu-temple-9.jpg', 'Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata. Ini adalah kalimat penjelas wisata.');

-- --------------------------------------------------------

--
-- Table structure for table `paketwisata`
--

CREATE TABLE `paketwisata` (
  `id_paketwisata` int(11) NOT NULL,
  `id_nama_wisata` int(11) DEFAULT NULL,
  `id_travel` int(11) DEFAULT NULL,
  `id_tourguide` int(11) DEFAULT NULL,
  `id_fasilitas` int(11) DEFAULT NULL,
  `no_paketwisata` int(11) DEFAULT NULL,
  `nama_fasilitas` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `tgl_wisata` date DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `paketwisata`
--

INSERT INTO `paketwisata` (`id_paketwisata`, `id_nama_wisata`, `id_travel`, `id_tourguide`, `id_fasilitas`, `no_paketwisata`, `nama_fasilitas`, `deskripsi`, `harga`, `jumlah`, `total`, `tgl_wisata`, `total_harga`) VALUES
(1, 1, 1, 2, 1, 1, 'Makanan', 'Nasi Kuning Ayam', 20000, 2, 40000, '2020-12-29', 120000),
(2, 1, 1, 2, 2, 1, 'Minuman', 'Air Putih', 5000, 2, 10000, '2020-12-29', 120000),
(3, 1, 1, 2, 3, 1, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 2, 20000, '2020-12-29', 120000),
(4, 1, 1, 2, 4, 1, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-29', 120000),
(5, 1, 1, NULL, 1, 2, 'Makanan', 'Nasi Kuning Ayam', 15000, 2, 30000, '2020-12-31', 80000),
(6, 1, 1, NULL, 2, 2, 'Minuman', 'Air Putih', 5000, 2, 10000, '2020-12-31', 80000),
(7, 1, 1, NULL, 3, 2, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 2, 20000, '2020-12-31', 80000),
(8, 1, 1, NULL, 5, 2, 'Atraksi', 'Izin Menonton Atraksi Yang Ada', 10000, 2, 20000, '2020-12-31', 80000),
(9, 1, 1, 1, 1, 3, 'Makanan', 'Nasi Kuning Ayam', 15000, 2, 30000, '2020-12-31', 130000),
(10, 1, 1, 1, 2, 3, 'Minuman', 'Air Putih', 5000, 2, 10000, '2020-12-31', 130000),
(11, 1, 1, 1, 3, 3, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 2, 20000, '2020-12-31', 130000),
(12, 1, 1, 1, 5, 3, 'Atraksi', 'Izin Menonton Atraksi Yang Ada', 10000, 2, 20000, '2020-12-31', 130000),
(13, 1, 1, 1, 4, 3, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-31', 130000),
(14, 1, 1, NULL, 1, 4, 'Makanan', 'Nasi Kuning Ayam', 15000, 3, 45000, '2020-12-29', 90000),
(15, 1, 1, NULL, 2, 4, 'Minuman', 'Air Putih', 5000, 3, 15000, '2020-12-29', 90000),
(16, 1, 1, NULL, 3, 4, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 3, 30000, '2020-12-29', 90000),
(17, 2, 2, NULL, 11, 5, 'Makanan', 'Nasi Ayam Pedas', 10000, 1, 10000, '2020-12-29', 30000),
(18, 2, 2, NULL, 12, 5, 'Tiket Masuk', 'Tiket untuk masuk ke tempat wisata', 20000, 1, 20000, '2020-12-29', 30000),
(19, 1, 3, 9, 16, 6, 'Makanan', 'Nasi Bubur Ayam', 15000, 1, 15000, '2020-12-29', 75000),
(20, 1, 3, 9, 17, 6, 'Tiket', 'Tiket masuk ke dalam tempat wisata', 10000, 1, 10000, '2020-12-29', 75000),
(21, 1, 3, 9, 18, 6, 'Tour Guide', 'Tuntunan dari tour guide', 50000, 1, 50000, '2020-12-29', 75000),
(22, 1, 1, NULL, 1, 7, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-29', 30000),
(23, 1, 1, NULL, 2, 7, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-29', 30000),
(24, 1, 1, NULL, 3, 7, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-29', 30000),
(25, 1, 1, NULL, 1, 8, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-29', 80000),
(26, 1, 1, NULL, 2, 8, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-29', 80000),
(27, 1, 1, NULL, 3, 8, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-29', 80000),
(28, 1, 1, NULL, 4, 8, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-29', 80000),
(29, 1, 1, NULL, 1, 9, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-29', 30000),
(30, 1, 1, NULL, 2, 9, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-29', 30000),
(31, 1, 1, NULL, 3, 9, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-29', 30000),
(32, 1, 1, 1, 1, 10, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-29', 80000),
(33, 1, 1, 1, 2, 10, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-29', 80000),
(34, 1, 1, 1, 3, 10, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-29', 80000),
(35, 1, 1, 1, 4, 10, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-29', 80000),
(36, 1, 1, NULL, 1, 11, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-29', 30000),
(37, 1, 1, NULL, 2, 11, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-29', 30000),
(38, 1, 1, NULL, 3, 11, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-29', 30000),
(39, 1, 3, NULL, 16, 12, 'Makanan', 'Nasi Bubur Ayam', 15000, 3, 45000, '2020-12-30', 75000),
(40, 1, 3, NULL, 17, 12, 'Tiket', 'Tiket masuk ke dalam tempat wisata', 10000, 3, 30000, '2020-12-30', 75000),
(41, 1, 1, NULL, 1, 13, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-30', 30000),
(42, 1, 1, NULL, 2, 13, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-30', 30000),
(43, 1, 1, NULL, 3, 13, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-30', 30000),
(44, 1, 1, 1, 1, 14, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-30', 80000),
(45, 1, 1, 1, 2, 14, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-30', 80000),
(46, 1, 1, 1, 3, 14, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-30', 80000),
(47, 1, 1, 1, 4, 14, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-30', 80000),
(48, 1, 1, 1, 1, 15, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-30', 90000),
(49, 1, 1, 1, 2, 15, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-30', 90000),
(50, 1, 1, 1, 3, 15, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-30', 90000),
(51, 1, 1, 1, 5, 15, 'Atraksi', 'Izin Menonton Atraksi Yang Ada', 10000, 1, 10000, '2020-12-30', 90000),
(52, 1, 1, 1, 4, 15, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-30', 90000),
(53, 1, 1, NULL, 1, 16, 'Makanan', 'Nasi Kuning Ayam', 15000, 2, 30000, '2020-12-30', 130000),
(54, 1, 1, NULL, 2, 16, 'Minuman', 'Air Putih', 5000, 2, 10000, '2020-12-30', 130000),
(55, 1, 1, NULL, 3, 16, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 2, 20000, '2020-12-30', 130000),
(56, 1, 1, NULL, 5, 16, 'Atraksi', 'Izin Menonton Atraksi Yang Ada', 10000, 2, 20000, '2020-12-30', 130000),
(57, 1, 1, NULL, 4, 16, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-30', 130000),
(58, 1, 1, NULL, 1, 17, 'Makanan', 'Nasi Kuning Ayam', 15000, 2, 30000, '2020-12-30', 130000),
(59, 1, 1, NULL, 2, 17, 'Minuman', 'Air Putih', 5000, 2, 10000, '2020-12-30', 130000),
(60, 1, 1, NULL, 3, 17, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 2, 20000, '2020-12-30', 130000),
(61, 1, 1, NULL, 5, 17, 'Atraksi', 'Izin Menonton Atraksi Yang Ada', 10000, 2, 20000, '2020-12-30', 130000),
(62, 1, 1, NULL, 4, 17, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-30', 130000),
(63, 1, 1, NULL, 1, 18, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-30', 1030000),
(64, 1, 1, NULL, 2, 18, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-30', 1030000),
(65, 1, 1, NULL, 3, 18, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-30', 1030000),
(66, 1, 1, NULL, NULL, 18, 'tes', 'tes', 1000000, 1, 1000000, '2020-12-30', 1030000),
(67, 1, 1, NULL, 1, 19, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-30', 1030000),
(68, 1, 1, NULL, 2, 19, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-30', 1030000),
(69, 1, 1, NULL, 3, 19, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-30', 1030000),
(70, 1, 1, NULL, NULL, 19, 'tes', 'tes', 1000000, 1, 1000000, '2020-12-30', 1030000),
(71, 1, 1, NULL, 1, 20, 'Makanan', 'Nasi Kuning Ayam', 15000, 2, 30000, '2020-12-30', 2060000),
(72, 1, 1, NULL, 2, 20, 'Minuman', 'Air Putih', 5000, 2, 10000, '2020-12-30', 2060000),
(73, 1, 1, NULL, 3, 20, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 2, 20000, '2020-12-30', 2060000),
(74, 1, 1, NULL, NULL, 20, 'tes', 'tes', 1000000, 2, 2000000, '2020-12-30', 2060000),
(75, 1, 1, 1, 1, 21, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-30', 1080000),
(76, 1, 1, 1, 2, 21, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-30', 1080000),
(77, 1, 1, 1, 3, 21, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-30', 1080000),
(78, 1, 1, 1, NULL, 21, 'tes', 'tes', 1000000, 1, 1000000, '2020-12-30', 1080000),
(79, 1, 1, 1, 4, 21, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-30', 1080000),
(80, 1, 1, NULL, 1, 22, 'Makanan', 'Nasi Kuning Ayam', 15000, 3, 45000, '2020-12-30', 3090000),
(81, 1, 1, NULL, 2, 22, 'Minuman', 'Air Putih', 5000, 3, 15000, '2020-12-30', 3090000),
(82, 1, 1, NULL, 3, 22, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 3, 30000, '2020-12-30', 3090000),
(83, 1, 1, NULL, NULL, 22, 'tes', 'tes', 1000000, 3, 3000000, '2020-12-30', 3090000),
(84, 1, 1, NULL, 1, 23, 'Makanan', 'Nasi Kuning Ayam', 15000, 3, 45000, '2020-12-30', 3090000),
(85, 1, 1, NULL, 2, 23, 'Minuman', 'Air Putih', 5000, 3, 15000, '2020-12-30', 3090000),
(86, 1, 1, NULL, 3, 23, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 3, 30000, '2020-12-30', 3090000),
(87, 1, 1, NULL, NULL, 23, 'tes', 'tes', 1000000, 3, 3000000, '2020-12-30', 3090000),
(88, 1, 1, NULL, 1, 24, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-31', 1030000),
(89, 1, 1, NULL, 2, 24, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-31', 1030000),
(90, 1, 1, NULL, 3, 24, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-31', 1030000),
(91, 1, 1, NULL, NULL, 24, 'tes', 'tes', 1000000, 1, 1000000, '2020-12-31', 1030000),
(92, 1, 1, NULL, 1, 25, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-31', 1030000),
(93, 1, 1, NULL, 2, 25, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-31', 1030000),
(94, 1, 1, NULL, 3, 25, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-31', 1030000),
(95, 1, 1, NULL, NULL, 25, 'tes', 'tes', 1000000, 1, 1000000, '2020-12-31', 1030000),
(96, 1, 1, NULL, 1, 26, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-31', 1030000),
(97, 1, 1, NULL, 2, 26, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-31', 1030000),
(98, 1, 1, NULL, 3, 26, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-31', 1030000),
(99, 1, 1, NULL, NULL, 26, 'tes', 'tes', 1000000, 1, 1000000, '2020-12-31', 1030000),
(100, 1, 1, NULL, 1, 27, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-31', 1030000),
(101, 1, 1, NULL, 2, 27, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-31', 1030000),
(102, 1, 1, NULL, 3, 27, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-31', 1030000),
(103, 1, 1, NULL, NULL, 27, 'tes', 'tes', 1000000, 1, 1000000, '2020-12-31', 1030000),
(104, 1, 1, NULL, 1, 28, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-31', 1030000),
(105, 1, 1, NULL, 2, 28, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-31', 1030000),
(106, 1, 1, NULL, 3, 28, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-31', 1030000),
(107, 1, 1, NULL, NULL, 28, 'tes', 'tes', 1000000, 1, 1000000, '2020-12-31', 1030000),
(108, 1, 1, NULL, 1, 29, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-31', 1030000),
(109, 1, 1, NULL, 2, 29, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-31', 1030000),
(110, 1, 1, NULL, 3, 29, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-31', 1030000),
(111, 1, 1, NULL, NULL, 29, 'tes', 'tes', 1000000, 1, 1000000, '2020-12-31', 1030000),
(112, 1, 1, NULL, 1, 30, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-31', 90000),
(113, 1, 1, NULL, 2, 30, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-31', 90000),
(114, 1, 1, NULL, 3, 30, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-31', 90000),
(115, 1, 1, NULL, 5, 30, 'Atraksi', 'Izin Menonton Atraksi Yang Ada', 10000, 1, 10000, '2020-12-31', 90000),
(116, 1, 1, NULL, 4, 30, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-31', 90000),
(117, 1, 1, 1, 1, 31, 'Makanan', 'Nasi Kuning Ayam', 15000, 2, 30000, '2020-12-31', 110000),
(118, 1, 1, 1, 2, 31, 'Minuman', 'Air Putih', 5000, 2, 10000, '2020-12-31', 110000),
(119, 1, 1, 1, 3, 31, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 2, 20000, '2020-12-31', 110000),
(120, 1, 1, 1, 4, 31, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-31', 110000),
(121, 1, 1, NULL, 1, 32, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-29', 30000),
(122, 1, 1, NULL, 2, 32, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-29', 30000),
(123, 1, 1, NULL, 3, 32, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-29', 30000),
(124, 1, 1, 1, 1, 33, 'Makanan', 'Nasi Kuning Ayam', 15000, 4, 60000, '2020-12-31', 210000),
(125, 1, 1, 1, 2, 33, 'Minuman', 'Air Putih', 5000, 4, 20000, '2020-12-31', 210000),
(126, 1, 1, 1, 3, 33, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 4, 40000, '2020-12-31', 210000),
(127, 1, 1, 1, 5, 33, 'Atraksi', 'Izin Menonton Atraksi Yang Ada', 10000, 4, 40000, '2020-12-31', 210000),
(128, 1, 1, 1, 4, 33, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-31', 210000),
(129, 1, 1, 10, 1, 34, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-29', 90000),
(130, 1, 1, 10, 2, 34, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-29', 90000),
(131, 1, 1, 10, 3, 34, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-29', 90000),
(132, 1, 1, 10, 5, 34, 'Atraksi', 'Izin Menonton Atraksi Yang Ada', 10000, 1, 10000, '2020-12-29', 90000),
(133, 1, 1, 10, 4, 34, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-29', 90000),
(134, 1, 1, NULL, 1, 35, 'Makanan', 'Nasi Kuning Ayam', 15000, 1, 15000, '2020-12-28', 30000),
(135, 1, 1, NULL, 2, 35, 'Minuman', 'Air Putih', 5000, 1, 5000, '2020-12-28', 30000),
(136, 1, 1, NULL, 3, 35, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 1, 10000, '2020-12-28', 30000),
(137, 2, 2, NULL, 11, 36, 'Makanan', 'Nasi Ayam Pedas', 10000, 1, 10000, '2021-01-02', 30000),
(138, 2, 2, NULL, 12, 36, 'Tiket Masuk', 'Tiket untuk masuk ke tempat wisata', 20000, 1, 20000, '2021-01-02', 30000),
(139, 1, 1, 2, 1, 37, 'Makanan', 'Nasi Kuning Ayam', 15000, 3, 45000, '2020-12-31', 140000),
(140, 1, 1, 2, 2, 37, 'Minuman', 'Air Putih', 5000, 3, 15000, '2020-12-31', 140000),
(141, 1, 1, 2, 3, 37, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 3, 30000, '2020-12-31', 140000),
(142, 1, 1, 2, 4, 37, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-31', 140000),
(143, 1, 1, 1, 1, 38, 'Makanan', 'Nasi Kuning Ayam', 15000, 2, 30000, '2020-12-31', 110000),
(144, 1, 1, 1, 2, 38, 'Minuman', 'Air Putih', 5000, 2, 10000, '2020-12-31', 110000),
(145, 1, 1, 1, 3, 38, 'Tiket', 'Tiket Masuk Ke Dalam Tempat Wisata', 10000, 2, 20000, '2020-12-31', 110000),
(146, 1, 1, 1, 4, 38, 'Tour Guide', 'Tuntunan Wisata Oleh Tour Guide', 50000, 1, 50000, '2020-12-31', 110000);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telpon` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `alamat`, `telpon`, `email`, `password`) VALUES
(1, 'Smara', 'Jln. Sana', '8232312412', 'smara@gmail.com', 'smara1'),
(2, 'Dido', 'Jln. Sana', '1242412', 'dido@gmail.com', 'dido1'),
(3, 'Ata', 'Jln. Sana', '1242412', 'ata@gmail.com', 'ata1'),
(4, 'Prema', 'Jln. Sana', '1242412', 'prema@gmail.com', 'prema1'),
(5, 'Dipa', 'Jln. Sana', '1242412', 'dipa@gmail.com', 'dipa1'),
(15, 'Suparta', 'Jln. Tresna', '08214124124', 'suparta@gmail.com', 'suparta1'),
(16, 'nyoman', 'bali', '080000000000', 'nyoman@unud.ac.id', 'nyoman1'),
(17, 'premadanan', 'Jln. Ir Bagus Mantra', '08231241241', 'premadanan@gmail.com', 'prema1'),
(18, 'Diva Yani', 'Jln. Ir Bagus Mantra', '8231241241', 'diva@gmail.com', 'diva2');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pemesanan` int(11) DEFAULT NULL,
  `tgl_pembayaran` datetime DEFAULT NULL,
  `tipe_pembayaran` enum('Bank','Kredit') DEFAULT NULL,
  `status_pembayaran` enum('Pending','Success') DEFAULT NULL,
  `status_kegiatan` enum('Belum','Terlaksana') DEFAULT NULL,
  `acc_tourguide` enum('Yes','No','Pending') DEFAULT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `bukti_kegiatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pemesanan`, `tgl_pembayaran`, `tipe_pembayaran`, `status_pembayaran`, `status_kegiatan`, `acc_tourguide`, `bukti_bayar`, `bukti_kegiatan`) VALUES
(1, 1, '2020-12-26 01:39:12', 'Kredit', 'Success', 'Belum', 'Yes', NULL, 'https://cdn-image.hipwee.com/wp-content/uploads/2020/07/hipwee-page-30.jpg'),
(2, 2, '2020-12-26 01:53:44', 'Bank', 'Success', 'Belum', 'Yes', 'https://cdn-image.hipwee.com/wp-content/uploads/2020/07/hipwee-page-30.jpg', 'https://traveldigg.com/wp-content/uploads/2016/07/Tanah-Lot-Sunset.jpghttp://2.bp.blogspot.com/-T9BAY_Ct9_Q/UsGH30FNBmI/AAAAAAAABZs/OEFDV8XA7NY/s1600/lokasi++-+tanah+lot+-+bali.JPG'),
(3, 4, '2020-12-26 05:52:12', 'Bank', 'Pending', 'Belum', 'Pending', 'https://4.bp.blogspot.com/-e8BLgmh8mp4/Uv_0ShM90GI/AAAAAAAABkI/hEIgiqQeXZg/s1600/output-paper.png', NULL),
(4, 15, '2020-12-27 12:08:50', 'Kredit', 'Success', 'Belum', 'Pending', NULL, NULL),
(5, 18, '2020-12-27 12:28:08', 'Kredit', 'Success', 'Belum', 'Pending', NULL, NULL),
(6, 19, '2020-12-27 12:33:18', 'Kredit', 'Success', 'Belum', 'Yes', NULL, 'https://cdn-image.hipwee.com/wp-content/uploads/2020/07/hipwee-page-30.jpg'),
(7, 20, '2020-12-27 12:41:40', 'Kredit', 'Success', 'Belum', 'Yes', NULL, 'https://traveldigg.com/wp-content/uploads/2016/07/Tanah-Lot-Sunset.jpg'),
(8, 21, '2020-12-27 13:17:37', 'Bank', 'Pending', 'Belum', 'Pending', NULL, NULL),
(9, 23, '2020-12-28 04:30:26', 'Bank', 'Pending', 'Belum', 'Pending', 'https://assets-a1.kompasiana.com/items/album/2019/05/15/20190515-042338-5cdb370875065776065e29e6.jpg', NULL),
(10, 25, '2020-12-28 12:36:01', 'Bank', 'Success', 'Belum', 'No', 'https://4.bp.blogspot.com/-e8BLgmh8mp4/Uv_0ShM90GI/AAAAAAAABkI/hEIgiqQeXZg/s1600/output-paper.png', 'https://traveldigg.com/wp-content/uploads/2016/07/Tanah-Lot-Sunset.jpg'),
(11, 26, '2020-12-29 00:50:17', 'Bank', 'Pending', 'Belum', 'Pending', 'test', NULL),
(12, 27, '2020-12-29 01:05:23', 'Bank', 'Pending', 'Belum', 'Pending', 'https://3.bp.blogspot.com/-cLgmG0kg2a0/WqDHQEz3MQI/AAAAAAAAAL0/Gca6e219V0cianE5PYMtoq8_eLpAS_xoQCEwYBhgL/w680/bukti-kas-masuk.jpg', NULL),
(13, 28, '2020-12-29 01:47:29', 'Bank', 'Success', 'Terlaksana', 'Yes', 'http://2.bp.blogspot.com/-NE_1XZ0uZ_I/UEagjY2nkUI/AAAAAAAAAMg/tt2Wb0AA91Y/s1600/tanda+terima+pembayaran.jpg', 'http://2.bp.blogspot.com/-NE_1XZ0uZ_I/UEagjY2nkUI/AAAAAAAAAMg/tt2Wb0AA91Y/s1600/tanda+terima+pembayaran.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_bank`
--

CREATE TABLE `pembayaran_bank` (
  `id_pembayaran_bank` int(11) NOT NULL,
  `id_pembayaran` int(11) DEFAULT NULL,
  `id_bank` int(11) DEFAULT NULL,
  `no_rekening` varchar(255) DEFAULT NULL,
  `nama_pemilik` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran_bank`
--

INSERT INTO `pembayaran_bank` (`id_pembayaran_bank`, `id_pembayaran`, `id_bank`, `no_rekening`, `nama_pemilik`) VALUES
(1, 2, 1, '', 'Smara'),
(2, 3, 3, '', '15151'),
(3, 8, 2, '', 'Smara'),
(4, 9, 3, '', 'arya'),
(5, 10, 1, '', 'Smara'),
(6, 11, 1, '', 'Shimo'),
(7, 12, 1, '', 'smara'),
(8, 13, 2, '', 'Diva');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_kredit`
--

CREATE TABLE `pembayaran_kredit` (
  `id_pembayaran_kredit` int(11) NOT NULL,
  `id_pembayaran` int(11) DEFAULT NULL,
  `id_kredit` int(11) DEFAULT NULL,
  `no_kartu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran_kredit`
--

INSERT INTO `pembayaran_kredit` (`id_pembayaran_kredit`, `id_pembayaran`, `id_kredit`, `no_kartu`) VALUES
(1, 1, 4, '112412-124124-1224'),
(2, 4, 1, '124124151'),
(3, 5, 4, '1214124'),
(4, 6, 3, '12535241'),
(5, 7, 4, '1252');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `no_paketwisata` int(11) DEFAULT NULL,
  `tgl_pemesanan` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `id_pelanggan`, `no_paketwisata`, `tgl_pemesanan`) VALUES
(1, 1, 1, '2020-12-26 01:39:05'),
(2, 1, 3, '2020-12-26 01:53:32'),
(3, 1, 8, '2020-12-26 05:44:35'),
(4, 1, 9, '2020-12-26 05:47:08'),
(5, 1, 10, '2020-12-26 05:59:10'),
(6, 1, 16, '2020-12-27 07:43:18'),
(7, 1, 17, '2020-12-27 07:44:24'),
(8, 1, 17, '2020-12-27 07:48:12'),
(9, 1, 17, '2020-12-27 07:48:21'),
(10, 1, 17, '2020-12-27 07:49:15'),
(11, 1, 17, '2020-12-27 07:49:17'),
(12, 1, 17, '2020-12-27 07:49:19'),
(13, 1, 17, '2020-12-27 07:49:20'),
(14, 1, 17, '2020-12-27 07:50:15'),
(15, 2, 18, '2020-12-27 12:08:42'),
(16, 1, 19, '2020-12-27 12:15:16'),
(17, 1, 19, '2020-12-27 12:15:37'),
(18, 2, 20, '2020-12-27 12:28:03'),
(19, 1, 21, '2020-12-27 12:33:08'),
(20, 1, 22, '2020-12-27 12:41:35'),
(21, 1, 23, '2020-12-27 13:16:34'),
(22, 16, 28, '2020-12-28 03:09:37'),
(23, 1, 29, '2020-12-28 04:29:50'),
(24, 1, 30, '2020-12-28 10:39:28'),
(25, 1, 31, '2020-12-28 12:35:38'),
(26, 1, 34, '2020-12-29 00:48:26'),
(27, 1, 36, '2020-12-29 01:00:24'),
(28, 18, 38, '2020-12-29 01:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `tourguide`
--

CREATE TABLE `tourguide` (
  `id_tourguide` int(11) NOT NULL,
  `id_travel` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tourguide`
--

INSERT INTO `tourguide` (`id_tourguide`, `id_travel`, `nama`, `alamat`, `email`, `password`) VALUES
(1, 1, 'Ryan', 'Jalan-Jalan', 'ryan@gmail.com', 'ryan1'),
(2, 1, 'Prasetyo', 'Jalan-Jalan', 'prasetyo@gmail.com', 'prasetyo1'),
(3, 2, 'Sintya', 'Jalan-Jalan', 'sintya@gmail.com', 'sintya1'),
(4, 2, 'Dekpas', 'Jalan-Jalan', 'dekpas@gmail.com', 'dekpas1'),
(5, 2, 'Jyo', 'Jalan-Jalan', 'jyo@gmail.com', 'jyo1'),
(9, 3, 'Dina', 'Jalan Indonesia 3', 'dina@gmail.com', 'dina1'),
(10, 1, 'Suryadi', 'Jln. Kerobokan', 'suryadi@gmail.com', 'suryadi1');

-- --------------------------------------------------------

--
-- Table structure for table `travel`
--

CREATE TABLE `travel` (
  `id_travel` int(11) NOT NULL,
  `nama_travel` varchar(255) DEFAULT NULL,
  `telpon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `travel`
--

INSERT INTO `travel` (`id_travel`, `nama_travel`, `telpon`) VALUES
(1, 'Bermuda Travel', '124124'),
(2, 'Dipani Travel', '121244'),
(3, 'Sekuy Travel', '352513'),
(4, 'Ajax Travel', '634523'),
(5, 'Serialize Travel', '345212'),
(6, 'Ryan Travel', '123459');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id_fasilitas`);

--
-- Indexes for table `kredit`
--
ALTER TABLE `kredit`
  ADD PRIMARY KEY (`id_kredit`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `nama_wisata`
--
ALTER TABLE `nama_wisata`
  ADD PRIMARY KEY (`id_nama_wisata`),
  ADD KEY `id_lokasi` (`id_lokasi`);

--
-- Indexes for table `paketwisata`
--
ALTER TABLE `paketwisata`
  ADD PRIMARY KEY (`id_paketwisata`),
  ADD KEY `id_tourguide` (`id_tourguide`),
  ADD KEY `id_nama_wisata` (`id_nama_wisata`),
  ADD KEY `id_travel` (`id_travel`),
  ADD KEY `paketwisata_ibfk_2` (`id_fasilitas`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indexes for table `pembayaran_bank`
--
ALTER TABLE `pembayaran_bank`
  ADD PRIMARY KEY (`id_pembayaran_bank`);

--
-- Indexes for table `pembayaran_kredit`
--
ALTER TABLE `pembayaran_kredit`
  ADD PRIMARY KEY (`id_pembayaran_kredit`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_paketwisata` (`no_paketwisata`);

--
-- Indexes for table `tourguide`
--
ALTER TABLE `tourguide`
  ADD PRIMARY KEY (`id_tourguide`),
  ADD KEY `id_travel` (`id_travel`);

--
-- Indexes for table `travel`
--
ALTER TABLE `travel`
  ADD PRIMARY KEY (`id_travel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id_fasilitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `kredit`
--
ALTER TABLE `kredit`
  MODIFY `id_kredit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id_lokasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `nama_wisata`
--
ALTER TABLE `nama_wisata`
  MODIFY `id_nama_wisata` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `paketwisata`
--
ALTER TABLE `paketwisata`
  MODIFY `id_paketwisata` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pembayaran_bank`
--
ALTER TABLE `pembayaran_bank`
  MODIFY `id_pembayaran_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pembayaran_kredit`
--
ALTER TABLE `pembayaran_kredit`
  MODIFY `id_pembayaran_kredit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tourguide`
--
ALTER TABLE `tourguide`
  MODIFY `id_tourguide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `travel`
--
ALTER TABLE `travel`
  MODIFY `id_travel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nama_wisata`
--
ALTER TABLE `nama_wisata`
  ADD CONSTRAINT `nama_wisata_ibfk_1` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`);

--
-- Constraints for table `paketwisata`
--
ALTER TABLE `paketwisata`
  ADD CONSTRAINT `paketwisata_ibfk_1` FOREIGN KEY (`id_tourguide`) REFERENCES `tourguide` (`id_tourguide`),
  ADD CONSTRAINT `paketwisata_ibfk_2` FOREIGN KEY (`id_fasilitas`) REFERENCES `fasilitas` (`id_fasilitas`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `paketwisata_ibfk_3` FOREIGN KEY (`id_nama_wisata`) REFERENCES `nama_wisata` (`id_nama_wisata`),
  ADD CONSTRAINT `paketwisata_ibfk_4` FOREIGN KEY (`id_travel`) REFERENCES `travel` (`id_travel`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`);

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);

--
-- Constraints for table `tourguide`
--
ALTER TABLE `tourguide`
  ADD CONSTRAINT `tourguide_ibfk_1` FOREIGN KEY (`id_travel`) REFERENCES `travel` (`id_travel`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
