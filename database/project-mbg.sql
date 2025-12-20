-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 18, 2025 at 02:14 AM
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
-- Table structure for table `balita`
--

CREATE TABLE `balita` (
  `id` int NOT NULL,
  `sppg_id` int NOT NULL,
  `nama_balita` varchar(255) CHARACTER SET macce COLLATE macce_bin NOT NULL,
  `usia_balita` float DEFAULT NULL,
  `alamat` text CHARACTER SET macce COLLATE macce_bin
) ENGINE=InnoDB DEFAULT CHARSET=macce COLLATE=macce_bin;

-- --------------------------------------------------------

--
-- Table structure for table `ibu_hamil`
--

CREATE TABLE `ibu_hamil` (
  `id` int NOT NULL,
  `sppg_id` int NOT NULL,
  `nama_ibu` varchar(255) CHARACTER SET macce COLLATE macce_bin NOT NULL,
  `klaster` int DEFAULT NULL,
  `alamat` text CHARACTER SET macce COLLATE macce_bin
) ENGINE=InnoDB DEFAULT CHARSET=macce COLLATE=macce_bin;

--
-- Dumping data for table `ibu_hamil`
--

INSERT INTO `ibu_hamil` (`id`, `sppg_id`, `nama_ibu`, `klaster`, `alamat`) VALUES
(1, 4, 'Clara putri', 3, 'purbalingga'),
(2, 5, 'siti', 2, 'purbalingga');

-- --------------------------------------------------------

--
-- Table structure for table `menu_sppg`
--

CREATE TABLE `menu_sppg` (
  `id` int NOT NULL,
  `sppg_id` int NOT NULL,
  `hari` int NOT NULL,
  `nama_menu` varchar(255) COLLATE macce_bin NOT NULL,
  `deskripsi_menu` text COLLATE macce_bin NOT NULL,
  `image` varchar(255) CHARACTER SET macce COLLATE macce_bin DEFAULT NULL,
  `waktu` datetime DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=macce COLLATE=macce_bin;

--
-- Dumping data for table `menu_sppg`
--

INSERT INTO `menu_sppg` (`id`, `sppg_id`, `hari`, `nama_menu`, `deskripsi_menu`, `image`, `waktu`, `tanggal`, `updated_at`) VALUES
(30, 4, 1, 'ayam betutu', 'Kandungan Gizi: Protein Hewani: Berfungsi untuk membangun dan memperbaiki jaringan tubuh, meningkatkan imunitas, dan mendukung tumbuh kembang anak. Protein hewani kaya asam amino esensial. Sayur: Kaya vitamin, mineral, dan serat.', 'mbg1.jpg', '2025-12-17 06:59:10', '2025-12-17', '2025-12-17 07:04:02'),
(31, 4, 2, 'susu telur', 'Kandungan Gizi: Protein Hewani: Berfungsi untuk membangun dan memperbaiki jaringan tubuh, meningkatkan imunitas, dan mendukung tumbuh kembang anak. Protein hewani kaya asam amino esensial. Sayur: Kaya vitamin, mineral, dan serat.', 'mbg1.jpg', '2025-12-17 06:59:34', '2025-12-17', '2025-12-17 07:04:02'),
(32, 4, 3, 'nasi padang', 'Kandungan Gizi: Protein Hewani: Berfungsi untuk membangun dan memperbaiki jaringan tubuh, meningkatkan imunitas, dan mendukung tumbuh kembang anak. Protein hewani kaya asam amino esensial. Sayur: Kaya vitamin, mineral, dan serat.', 'mbg1.jpg', '2025-12-17 06:59:57', '2025-12-17', '2025-12-17 07:04:02'),
(33, 4, 4, 'ayam bakar rica rica', 'Kandungan Gizi: Protein Hewani: Berfungsi untuk membangun dan memperbaiki jaringan tubuh, meningkatkan imunitas, dan mendukung tumbuh kembang anak. Protein hewani kaya asam amino esensial. Sayur: Kaya vitamin, mineral, dan serat.', 'mbg1.jpg', '2025-12-17 07:00:15', '2025-12-17', '2025-12-17 07:04:02'),
(34, 4, 5, 'bakso urat', 'Kandungan Gizi: Protein Hewani: Berfungsi untuk membangun dan memperbaiki jaringan tubuh, meningkatkan imunitas, dan mendukung tumbuh kembang anak. Protein hewani kaya asam amino esensial. Sayur: Kaya vitamin, mineral, dan serat.', 'mbg1.jpg', '2025-12-17 07:00:32', '2025-12-17', '2025-12-17 07:04:02'),
(40, 4, 1, 'bakwan jagung', 'ytyyty', 'mbg1.jpg', '2025-12-24 08:23:39', '2025-12-24', '2025-12-24 08:23:39'),
(41, 4, 2, 'Ayam Goreng', 'hihiihih', 'mbg1.jpg', '2025-12-24 08:25:17', '2025-12-24', '2025-12-24 08:29:26'),
(42, 5, 1, 'susu + nasi rames', 'yayayaya', 'mbg1.jpg', '2025-12-17 10:04:01', '2025-12-17', '2025-12-17 10:04:01');

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
(2, 4, 'SMA N 2 purbalingga', 'SMA', 'purbalingga'),
(4, 4, 'SMP N 1 purbalingga', 'SMP', 'purbalingga'),
(5, 4, 'SMP N 2 purbalingga', 'SMP', 'purbalingga'),
(7, 5, 'SMP N 1 kemangkon', 'SMP', 'kemangkon');

-- --------------------------------------------------------

--
-- Table structure for table `sppg`
--

CREATE TABLE `sppg` (
  `id` int NOT NULL,
  `nama_sppg` varchar(255) COLLATE macce_bin NOT NULL,
  `alamat` text COLLATE macce_bin NOT NULL,
  `gmaps` text COLLATE macce_bin NOT NULL,
  `kota` varchar(100) COLLATE macce_bin NOT NULL,
  `jam_buka` time DEFAULT NULL,
  `jam_tutup` time DEFAULT NULL,
  `waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=macce COLLATE=macce_bin;

--
-- Dumping data for table `sppg`
--

INSERT INTO `sppg` (`id`, `nama_sppg`, `alamat`, `gmaps`, `kota`, `jam_buka`, `jam_tutup`, `waktu`) VALUES
(4, 'SPPG Purbalingga Wetan 01', 'J979+28G, Purbalingga Wetan, Kec. Purbalingga, Kabupaten Purbalingga, Jawa Tengah', 'https://maps.app.goo.gl/4jvYBoZB1WJvNSrU6', 'Purbalingga', '07:30:00', '16:30:00', '2025-12-05 14:24:35'),
(5, 'SPPG Purbalingga Wetan 02', 'J979+569, Purbalingga Wetan, Kec. Purbalingga, Kabupaten Purbalingga, Jawa Tengah', 'https://maps.app.goo.gl/NCMwVWRw1o3qjQLw7', 'Purbalingga', '08:00:00', '17:00:00', '2025-12-05 16:27:21'),
(7, 'sppg TNI AD kemangkon', ' di Dusun III, Toyareka, Kec. Kemangkon, Kabupaten Purbalingga, Jawa Tengah 53381', 'https://maps.app.goo.gl/5xR6c8DXThUdrA2q8', 'Purbalingga', '07:00:00', '17:00:00', '2025-12-06 14:17:22'),
(8, 'sppg yayasan kemala bhayangkari polri', 'J955+2P4, Purbalingga kidul, kec. purbalingga, kab. purbalingga, jawa tengah 53313', '', 'Purbalingga', '06:30:00', '17:00:00', '2025-12-06 14:28:52'),
(9, 'SPPG Purbalingga Galuh', 'J9PC+FPH, Jl. Gerilya, Dusun 1, Galuh, Kec. Bojongsari, Kabupaten Purbalingga, Jawa Tengah 53362', '', 'Purbalingga', '06:00:00', '16:00:00', '2025-12-06 14:31:13'),
(10, 'SPPG Bojongsari', 'J8XX+9MF, Dusun 5, Kajongan, Kec. Bojongsari, Kabupaten Purbalingga, Jawa Tengah 53362', '', 'Purbalingga', '09:00:00', '17:30:00', '2025-12-06 14:34:01'),
(11, 'SPPG Kajongan Bojongsari', 'J8XX+8P9, Dusun 5, Kajongan, Kec. Bojongsari, Kabupaten Purbalingga, Jawa Tengah', '', 'Purbalingga', '09:00:00', '16:30:00', '2025-12-06 14:35:21'),
(12, 'sppg blater', 'H89P+P7C, Dusun 1, Blater, Kec. Kalimanah, Kabupaten Purbalingga, Jawa Tengah', '', 'Purbalingga', '07:00:00', '16:30:00', '2025-12-06 00:00:00'),
(17, 'SPPG Sumingkir Kutasari, Purbalingga', 'M84G+MR8, Sumingkir, Kec. Kutasari, Kabupaten Purbalingga, Jawa Tengah 53361', 'https://maps.app.goo.gl/aYFqAxqEvKiwysw88', 'Purbalingga', '07:07:00', '00:12:00', '2025-12-13 09:16:26');

-- --------------------------------------------------------

--
-- Table structure for table `sppg_rating`
--

CREATE TABLE `sppg_rating` (
  `id` int NOT NULL,
  `sppg_id` int NOT NULL,
  `user_id` int NOT NULL,
  `komentar` text COLLATE macce_bin NOT NULL,
  `rating` int NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `sppg_rating`
--

INSERT INTO `sppg_rating` (`id`, `sppg_id`, `user_id`, `komentar`, `rating`, `tanggal`) VALUES
(46, 4, 1, 'enak banget MBG nya makasi bapa presiden', 4, '2025-12-13 01:36:18'),
(50, 5, 5, 'makasi pa mbg nya mantap', 5, '2025-12-13 03:39:25'),
(51, 4, 1, 'enak sebetulnya tapi bosen pa', 3, '2025-12-14 07:13:51'),
(52, 5, 5, 'makasi pa mbg nya mantap', 3, '2025-12-14 07:15:42'),
(55, 7, 6, 'hahaha', 5, '2025-12-15 06:10:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE macce_bin DEFAULT NULL,
  `password` varchar(255) COLLATE macce_bin DEFAULT NULL,
  `level` enum('admin','user','sppg') CHARACTER SET macce COLLATE macce_bin DEFAULT 'user',
  `sppg_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=macce COLLATE=macce_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level`, `sppg_id`) VALUES
(1, 'clara', '$2y$10$LjIXDUMuUlgWSoRPN2cOL.8QlkqbvPiNAIQkqf8Glh4e6KSsUopaK', 'user', 4),
(4, 'admin', '$2y$10$EWemSnfkum2fmZ41f94SButz8krZC1B1DfyDpF25GNkXj7rDxnVzq', 'admin', 4),
(5, 'siti', '$2y$10$O4cwQpHvzXegZ0kuGKfkE.ibmNeeyRV/lreQrB6wuopCUw3FHCcCS', 'user', 5),
(6, 'hanipan', '$2y$10$gBTuUmGScohg6zqqYfBgEOFeZfm.IKqM5zA78hc1lvU03Sn9eFGMa', 'user', 7),
(7, 'SMA N 1 Purbalingga', '$2y$10$gUBbE/yq9YF0WpTJq8zWI.g1div5gfYc/Jc7rCWR1pBS7OXSp4r.q', 'user', 4),
(8, 'SPPG Purbalingga Wetan 01', '$2y$10$VUCs43i4IubLEK/ShKMviOMN9Io/.Xt0Snt3xdqJwnX4TZoOxUpr.', 'sppg', 4),
(10, 'SPPG Purbalingga Wetan 02', '$2y$10$fNnYMCSAWO7bFI9m6PtVhembb.OMhAxSrc5lu7QwgJw9ykltUlgZK', 'sppg', 5),
(11, 'SMA N 2 purbalingga', '$2y$10$Gp6DLm4ZOesNZaVmeu1N1eqPD1usG5hdUuXRhPPl8ldflw76wR3i.', 'user', 4),
(12, 'user', '$2y$10$MK5VySIm0AHtyUkweEMoXuJ3hGzdcWYAYNMKtKOvnQZCk8SfbVIQW', 'user', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balita`
--
ALTER TABLE `balita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sppg_id` (`sppg_id`);

--
-- Indexes for table `ibu_hamil`
--
ALTER TABLE `ibu_hamil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sppg_id` (`sppg_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balita`
--
ALTER TABLE `balita`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ibu_hamil`
--
ALTER TABLE `ibu_hamil`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu_sppg`
--
ALTER TABLE `menu_sppg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sppg`
--
ALTER TABLE `sppg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sppg_rating`
--
ALTER TABLE `sppg_rating`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
