-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 04:53 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinikku_ruangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `dokter_id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu_slot` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `dokter_id`, `tanggal`, `waktu_slot`) VALUES
(1, 2, '2025-07-16', '11:02:00');

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
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `spesialis_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `spesialis_id`) VALUES
(2, 'Dr. Budi Santoso - Spesialis Gigi', NULL),
(15, 'Dr. Budi Setiawan', 1),
(16, 'Dr. Citra Ayu', 2),
(17, 'Mr Talk the talk', 3),
(18, 'satu', 4),
(19, 'satu', 4),
(20, 'satu', 4);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `dokter_id` int(11) NOT NULL,
  `hari` varchar(10) DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(0, 7, 'dipakai', 'ij9u'),
(0, 11, 'maintenance', 'Cuba Kembalu');

-- --------------------------------------------------------

--
-- Table structure for table `spesialis`
--

CREATE TABLE `spesialis` (
  `id` int(11) NOT NULL,
  `nama_spesialis` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spesialis`
--

INSERT INTO `spesialis` (`id`, `nama_spesialis`) VALUES
(1, 'Umum'),
(2, 'Spesialis Anak'),
(3, 'Spesialis Gigi'),
(4, 'Spesialis Kebidanan');

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
(4, 'admin1', '$2y$10$U7U2rXlghu2VUn9ozshakODkFIqdiPQuhF8kzA4zBPoIDdfxN4Yf6\r\n', 'admin', 'Admin Satu', 'admin@klinik.com'),
(5, 'dokter1', 'hashdokter', 'dokter', 'Dokter Andi', 'dokter@klinik.com'),
(6, 'pasien1', 'hashpasien', 'pasien', 'Pasien Budi', 'pasien@klinik.com'),
(7, 'test1', '$2y$10$WbdQNaNn0ydMwWbT5Dc6Y.8OruUvoa325yQc73ofBcc7PUhFHrUR6', 'pasien', 'test name', 'test1@mail.com'),
(8, 'sayangs', '$2y$10$FizbYFnN9oHOgp8RCRKia.Z/tr/m/Tcztn2EoWVJNdZwI3wsCF6xC', 'pasien', 'sayang', 'sayang@mail.com'),
(9, 'isans', '$2y$10$8uqThNFpE0WOe0FEZwQRFeKPaRISUA2Ifz4qtQWcphxCLunYIc/te', 'pasien', 'isans', 'isanz@mail.com'),
(10, 'admin_web', '$2y$10$u.Rjr826bojygRd6whVxX.HqFZW6i9ITrJe4S9hPLpqjicuUwnylq', 'admin', 'admin web', 'adminweb@klinik.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokter_id` (`dokter_id`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_spesialis` (`spesialis_id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokter_id` (`dokter_id`);

--
-- Indexes for table `spesialis`
--
ALTER TABLE `spesialis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spesialis`
--
ALTER TABLE `spesialis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id`);

--
-- Constraints for table `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `fk_spesialis` FOREIGN KEY (`spesialis_id`) REFERENCES `spesialis` (`id`);

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
