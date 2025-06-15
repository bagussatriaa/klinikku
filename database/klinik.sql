-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2025 at 11:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik`
--

-- --------------------------------------------------------

--
-- Table structure for table `daftar_ruang`
--

CREATE TABLE `daftar_ruang` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daftar_ruang`
--

INSERT INTO `daftar_ruang` (`id`, `nama`) VALUES
(1, '01 - Ruang Periksa Umum'),
(2, '02 - Ruang Gigi'),
(3, '03 - Ruang Anak'),
(4, '04 - Ruang Kebidanan'),
(5, '05 - Ruang Laboratorium'),
(6, '06 - Ruang IGD'),
(7, '07 - Ruang Konsultasi'),
(8, '08 - Ruang Rawat Inap A'),
(9, '09 - Ruang Rawat Inap B'),
(10, '10 - Ruang Tindakan'),
(11, '11 - Ruang Farmasi'),
(12, '12 - Ruang Vaksinasi'),
(13, '13 - Ruang Radiologi'),
(14, '14 - Ruang USG'),
(15, '15 - Ruang Administrasi');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id` int(11) NOT NULL,
  `id_nama_ruang` int(11) NOT NULL,
  `status` enum('kosong','dipakai','maintenance') NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id`, `id_nama_ruang`, `status`, `keterangan`) VALUES
(1, 1, 'kosong', 'TIDAK ADA BATASAN ORANG UNTUK PERIKSA. TAPI DIHARAPKAN MENGANTRI'),
(2, 6, 'dipakai', 'Lagi ada pemeriksaan terhadap pasien. Nanti dikabarin info selanjutnya untuk pergantian pasiennya jika sudah selesai');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','dokter','pasien') NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `nama_lengkap`, `email`) VALUES
(1, 'admin1', 'hashadmin', 'admin', 'Admin Satu', 'admin@klinik.com'),
(2, 'dokter1', 'hashdokter', 'dokter', 'Dokter Andi', 'dokter@klinik.com'),
(3, 'pasien1', 'hashpasien', 'pasien', 'Pasien Budi', 'pasien@klinik.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_ruang`
--
ALTER TABLE `daftar_ruang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nama_ruang` (`id_nama_ruang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_ruang`
--
ALTER TABLE `daftar_ruang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD CONSTRAINT `ruangan_ibfk_1` FOREIGN KEY (`id_nama_ruang`) REFERENCES `daftar_ruang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
