-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2025 at 12:34 PM
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
-- Database: `klinikku_db`
--

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
(1, 'admin1', '$2y$10$U7U2rXlghu2VUn9ozshakODkFIqdiPQuhF8kzA4zBPoIDdfxN4Yf6\n', 'admin', 'Admin Satu', 'admin@klinik.com'),
(2, 'dokter1', 'hashdokter', 'dokter', 'Dokter Andi', 'dokter@klinik.com'),
(3, 'pasien1', 'hashpasien', 'pasien', 'Pasien Budi', 'pasien@klinik.com'),
(4, 'test1', '$2y$10$WbdQNaNn0ydMwWbT5Dc6Y.8OruUvoa325yQc73ofBcc7PUhFHrUR6', 'pasien', 'test name', 'test1@mail.com'),
(5, 'sayangs', '$2y$10$FizbYFnN9oHOgp8RCRKia.Z/tr/m/Tcztn2EoWVJNdZwI3wsCF6xC', 'pasien', 'sayang', 'sayang@mail.com'),
(6, 'isans', '$2y$10$8uqThNFpE0WOe0FEZwQRFeKPaRISUA2Ifz4qtQWcphxCLunYIc/te', 'pasien', 'isans', 'isanz@mail.com'),
(999, 'admin_web', '$2y$10$u.Rjr826bojygRd6whVxX.HqFZW6i9ITrJe4S9hPLpqjicuUwnylq', 'admin', 'admin web', 'adminweb@klinik.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
