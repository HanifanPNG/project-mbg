-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 09, 2025 at 11:46 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project-mbg`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu_sppg`
--

CREATE TABLE `menu_sppg` (
  `id` int NOT NULL,
  `sppg_id` int NOT NULL,
  `hari` int NOT NULL,
  `nama_menu` varchar(255) COLLATE macce_bin NOT NULL,
  `image` varchar(255) CHARACTER SET macce COLLATE macce_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=macce COLLATE=macce_bin;

--
-- Dumping data for table `menu_sppg`
--

INSERT INTO `menu_sppg` (`id`, `sppg_id`, `hari`, `nama_menu`, `image`) VALUES
(1, 4, 1, 'sayur ayam pop', 'mbg.jpg'),
(2, 4, 2, 'soto ayam bu nur', 'mbg.jpg'),
(3, 4, 3, 'mie ayam pakde joyo', 'mbg.jpg'),
(4, 4, 4, 'bakso pak somat', 'mbg.jpg'),
(5, 4, 5, 'ayam krispi pa edi', 'mbg.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sekolah`
--

CREATE TABLE `sekolah` (
  `id` int NOT NULL,
  `sppg_id` int NOT NULL,
  `nama_sekolah` varchar(255) COLLATE macce_bin NOT NULL,
  `jenjang` enum('SD','SMP','SMA','PAUD') CHARACTER SET macce COLLATE macce_bin DEFAULT NULL,
  `alamat` text COLLATE macce_bin
) ENGINE=InnoDB DEFAULT CHARSET=macce COLLATE=macce_bin;

--
-- Dumping data for table `sekolah`
--

INSERT INTO `sekolah` (`id`, `sppg_id`, `nama_sekolah`, `jenjang`, `alamat`) VALUES
(2, 4, 'SMP N 1 Purbalingga', 'SMP', 'purbalingga'),
(3, 4, 'SD N 1 purbalingga', 'SD', 'asaassa');

-- --------------------------------------------------------

--
-- Table structure for table `sppg`
--

CREATE TABLE `sppg` (
  `id` int NOT NULL,
  `nama_sppg` varchar(255) COLLATE macce_bin NOT NULL,
  `alamat` text COLLATE macce_bin NOT NULL,
  `kota` varchar(100) COLLATE macce_bin NOT NULL,
  `jam_buka` time DEFAULT NULL,
  `jam_tutup` time DEFAULT NULL,
  `waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=macce COLLATE=macce_bin;

--
-- Dumping data for table `sppg`
--

INSERT INTO `sppg` (`id`, `nama_sppg`, `alamat`, `kota`, `jam_buka`, `jam_tutup`, `waktu`) VALUES
(4, 'SPPG Purbalingga Wetan 01', 'J979+28G, Purbalingga Wetan, Kec. Purbalingga, Kabupaten Purbalingga, Jawa Tengah', 'Purbalingga', '07:30:00', '16:30:00', '2025-12-05 14:24:35'),
(5, 'SPPG Purbalingga Wetan 02', 'J979+569, Purbalingga Wetan, Kec. Purbalingga, Kabupaten Purbalingga, Jawa Tengah', 'Purbalingga', '08:00:00', '17:00:00', '2025-12-05 16:27:21'),
(7, 'sppg TNI AD kemangkon', ' di Dusun III, Toyareka, Kec. Kemangkon, Kabupaten Purbalingga, Jawa Tengah 53381', 'Purbalingga', '07:00:00', '17:00:00', '2025-12-06 14:17:22'),
(8, 'sppg yayasan kemala bhayangkari polri', 'J955+2P4, Purbalingga kidul, kec. purbalingga, kab. purbalingga, jawa tengah 53313', 'Purbalingga', '06:30:00', '17:00:00', '2025-12-06 14:28:52'),
(9, 'SPPG Purbalingga Galuh', 'J9PC+FPH, Jl. Gerilya, Dusun 1, Galuh, Kec. Bojongsari, Kabupaten Purbalingga, Jawa Tengah 53362', 'Purbalingga', '06:00:00', '16:00:00', '2025-12-06 14:31:13'),
(10, 'SPPG Bojongsari', 'J8XX+9MF, Dusun 5, Kajongan, Kec. Bojongsari, Kabupaten Purbalingga, Jawa Tengah 53362', 'Purbalingga', '09:00:00', '17:30:00', '2025-12-06 14:34:01'),
(11, 'SPPG Kajongan Bojongsari', 'J8XX+8P9, Dusun 5, Kajongan, Kec. Bojongsari, Kabupaten Purbalingga, Jawa Tengah', 'Purbalingga', '09:00:00', '16:30:00', '2025-12-06 14:35:21'),
(12, 'sppg blater', 'H89P+P7C, Dusun 1, Blater, Kec. Kalimanah, Kabupaten Purbalingga, Jawa Tengah', 'Purbalingga', '07:00:00', '16:30:00', '2025-12-06 14:36:53'),
(13, 'SPPG DIPOKUSUMO KOTA', 'Jl. Dipokusumo No.1, Purbalingga, Purbalingga Lor, Kec. Purbalingga, Kabupaten Purbalingga, Jawa Tengah 53311', 'Purbalingga', '08:00:00', '16:00:00', '2025-12-07 10:03:46');

-- --------------------------------------------------------

--
-- Table structure for table `sppg_rating`
--

CREATE TABLE `sppg_rating` (
  `id` int NOT NULL,
  `sppg_id` int NOT NULL,
  `nama` varchar(255) COLLATE macce_bin NOT NULL,
  `komentar` text COLLATE macce_bin NOT NULL,
  `rating` int NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `sppg_rating`
--

INSERT INTO `sppg_rating` (`id`, `sppg_id`, `nama`, `komentar`, `rating`, `tanggal`) VALUES
(3, 4, 'Hanifan Pangabekti', 'yayaya lumayan enak si kalo buat gratisan mah', 4, '2025-12-07 13:41:21'),
(4, 4, 'Agus Nur Rohman', 'sayur nya kadang kurang banyak, tpi overall its so good', 3, '2025-12-07 13:42:10'),
(22, 4, 'Muhammad Nur Rohman', 'sama kaya komen nya agus ', 3, '2025-12-07 14:14:00'),
(33, 4, 'Muhammad Atoillah', 'sama kaya komen nya rohmen', 1, '2025-12-07 14:29:45'),
(34, 4, 'Alifian deas Isworo', 'sama kaya komen nya toil', 2, '2025-12-07 14:31:44'),
(35, 4, 'Muhammad haikal', 'sama kaya komen nya alipian', 2, '2025-12-07 14:54:12'),
(36, 5, 'Lee rakem', 'wuuu', 2, '2025-12-07 14:55:34'),
(37, 4, 'Toil', 'skfkfaskfsfk', 2, '2025-12-09 06:06:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(200) COLLATE macce_bin NOT NULL,
  `password` varchar(200) COLLATE macce_bin NOT NULL,
  `level` enum('admin','user') COLLATE macce_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=macce COLLATE=macce_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(2, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu_sppg`
--
ALTER TABLE `menu_sppg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sppg_id` (`sppg_id`);

--
-- Indexes for table `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sppg_id` (`sppg_id`);

--
-- Indexes for table `sppg`
--
ALTER TABLE `sppg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sppg_rating`
--
ALTER TABLE `sppg_rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sppg_id` (`sppg_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu_sppg`
--
ALTER TABLE `menu_sppg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sppg`
--
ALTER TABLE `sppg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sppg_rating`
--
ALTER TABLE `sppg_rating`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_sppg`
--
ALTER TABLE `menu_sppg`
  ADD CONSTRAINT `menu_sppg_ibfk_1` FOREIGN KEY (`sppg_id`) REFERENCES `sppg` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sekolah`
--
ALTER TABLE `sekolah`
  ADD CONSTRAINT `sekolah_ibfk_1` FOREIGN KEY (`sppg_id`) REFERENCES `sppg` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sppg_rating`
--
ALTER TABLE `sppg_rating`
  ADD CONSTRAINT `sppg_rating_ibfk_1` FOREIGN KEY (`sppg_id`) REFERENCES `sppg` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
