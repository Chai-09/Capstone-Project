-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2025 at 06:53 AM
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
-- Database: `applysmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('applicant','admission','accounting') NOT NULL DEFAULT 'applicant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'PAUL AERON A. GUILLERMO', 'paulaeronguillermo@gmail.com', '$2y$12$vhx0TD5UjY6i0jwe0nKfV.Zrs/v97idqmpIUYA0TobJfZjZLAbZHC', 'applicant'),
(2, 'APPLICANT APPLICANT APPLICANT', 'applicant@gmail.com', '$2y$12$eCUALXhMNVKpLnn71JpC3.e14dlNpXtJw5vbAD0UeZsnuS/G2L9Wy', 'applicant'),
(3, 'Ernesto M. Barcenas', 'gabe@gmail.com', '$2y$12$sXaqNol4PjZEJdVIcExJjOO761sKELuppsZBOThhiC41/XhThM3y6', 'applicant'),
(4, 'TEST T. TEST', 'test@gmail.com', '$2y$12$tKdzVO9.2FQ/SrmJbtHbXu35Whm9.yqA7qC.fYeIP2.NvULy06kwy', 'applicant'),
(5, 'REST REST. TEST', 'rest@gmail.com', '$2y$12$Ernk7O1wwIX0abAhA2KtBegWKQtbDN420ej.wr48gqLgllJA0JnP6', 'applicant'),
(6, 'GABE M. BARCENAS', 'gabebarcenas01@gmail.com', '$2y$12$lN9yrH6GQqyQduNtN4qVUuHIgFV1H43aNRlsy9UjLxRnZJ0A8V6cG', 'applicant'),
(7, 'SADSAAD ASDASDA. DAS', 'innovision@gmail.com', '$2y$12$ypYrVsuhjRhI4MMcj/jDY.z6/oyEQGf4lf9ncnwiYanbaQtCGXF1O', 'applicant'),
(8, 'JHGJGGHJGHJ JHJGHJGH. JGHJGH', 'innovision2026@gmail.com', '$2y$12$Bcbkl1vpFuFb0zYfCIFieuEU8/xUqZM9E.mSKPVrUflDNUJ7G4Nfy', 'applicant'),
(9, 'PEDRO P. PEDRO', 'gabebarcenas02@gmail.com', '$2y$12$NXNSYhqBxu1A1SNrX4PXculsGPtO7Y7oSez3.Wgx6sdXU/eFQ1y7m', 'applicant');

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` int(10) UNSIGNED NOT NULL,
  `account_id` int(10) UNSIGNED NOT NULL,
  `guardian_fname` varchar(64) NOT NULL,
  `guardian_mname` varchar(64) DEFAULT NULL,
  `guardian_lname` varchar(64) NOT NULL,
  `applicant_fname` varchar(64) NOT NULL,
  `applicant_mname` varchar(64) DEFAULT NULL,
  `applicant_lname` varchar(64) NOT NULL,
  `current_school` varchar(255) NOT NULL,
  `incoming_grlvl` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `account_id`, `guardian_fname`, `guardian_mname`, `guardian_lname`, `applicant_fname`, `applicant_mname`, `applicant_lname`, `current_school`, `incoming_grlvl`) VALUES
(1, 1, 'PAUL AERON', 'A.', 'GUILLERMO', 'PAUL AERON', 'O.', 'GUILLERMO', 'Virgen Del Pilar School', 'Grade 9'),
(2, 2, 'APPLICANT', 'APPLICANT', 'APPLICANT', 'APPLICANT', 'APPLICANT', 'APPLICANT', 'APPLICANT', 'Grade 10'),
(3, 3, 'Ernesto', 'M.', 'Barcenas', 'Kyrie', 'S.', 'Sardalla', 'FEU', 'Grade 8'),
(4, 4, 'TEST', 'T.', 'TEST', 'TEST', 'T.', 'TEST', 'TEST', 'GRADE 12'),
(5, 5, 'REST', 'REST.', 'TEST', 'SEWST', 'ESTSE.', 'SETSE', 'TSE', 'GRADE 11'),
(6, 6, 'GABE', 'M.', 'BARCENAS', 'MARCUS', 'M.', 'BARCENAS', 'FEU', 'GRADE 10'),
(7, 7, 'SADSAAD', 'ASDASDA.', 'DAS', 'FDSFSD', 'SFSD.', 'SDFSD', 'FD', 'GRADE 10'),
(8, 8, 'JHGJGGHJGHJ', 'JHJGHJGH.', 'JGHJGH', 'NMBNMBN', 'BMBN.', 'BMBN', 'BNMBN', 'GRADE 9'),
(9, 9, 'PEDRO', 'P.', 'PEDRO', 'RED', 'R.', 'RED', 'FEU', 'GRADE 10');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_04_16_091659_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4p06tvTgrsZtkeBFC582Rtdu6MId840xDDmv8Ysk', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiR0xvejJMMTJUTXZ1THlMRmlVaU1RalVsZ1FrNDZEWHdpaHhZc054VCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mb3Jnb3QtcGFzc3dvcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjEwOiJhY2NvdW50X2lkIjtpOjk7czo0OiJyb2xlIjtzOjk6ImFwcGxpY2FudCI7fQ==', 1744858921),
('GskM1EmA0GXIuhdYC1uapJrEIi18gPK0hDrg9aiX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSlhMMjRVdVJKM29BekptVlU3NzVUdG9YZ2VxM3pmUzY0aTR6QjluOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTA6ImFjY291bnRfaWQiO2k6NjtzOjQ6InJvbGUiO3M6OToiYXBwbGljYW50Ijt9', 1744865351),
('K8PK6Bvi3TM6aHcB5E5SpVe0o2bxYF28F8vd50Xu', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSE54N3RpWE1leFo3eTFSWkFtMGNNdWFSZWtSNXFmRUM0SzNvdkNBZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1744858881);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `applicants_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
