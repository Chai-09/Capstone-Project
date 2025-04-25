-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 04:16 AM
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
  `role` enum('applicant','admission','accounting','administrator') NOT NULL DEFAULT 'applicant'
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
(6, 'GABE M. BARCENAS', 'gabebarcenas01@gmail.com', '$2y$12$rMCSi4TTUaD62zdXQ6q1J.C/GeWyOn0FdexftiFEcRHB0/Y/YwAOW', 'applicant'),
(7, 'SADSAAD ASDASDA. DAS', 'innovision@gmail.com', '$2y$12$ypYrVsuhjRhI4MMcj/jDY.z6/oyEQGf4lf9ncnwiYanbaQtCGXF1O', 'applicant'),
(8, 'JHGJGGHJGHJ JHJGHJGH. JGHJGH', 'innovision2026@gmail.com', '$2y$12$Bcbkl1vpFuFb0zYfCIFieuEU8/xUqZM9E.mSKPVrUflDNUJ7G4Nfy', 'applicant'),
(9, 'PEDRO P. PEDRO', 'gabebarcenas02@gmail.com', '$2y$12$OZu6ar9GSPvKpU3PlD7ab.986jrzu0hLEqBYjmcpd0W5pOgycvX1K', 'applicant'),
(10, 'HDI ADS. ADS', 'wsaxd@gmail.com', '$2y$12$rDSx5IUIKqVsax6SN8vZnOYnauxO8MiUnnL9/5azHYgJZj10p/t8m', 'applicant'),
(11, 'JEDI J. JEDI', 'jedi@gmail.com', '$2y$12$r6I2nzpYAiDqyVQZnBz9F.sit5rpHdAjRcOQdNyuA3i8tp5jVaXKK', 'applicant'),
(12, 'FGH FGH. FGH', 'fgh@gmail.com', '$2y$12$Bv3TKW2OJTyXxDTdVdx0oekAlpNMRrXEzwTTpdL.taqfyYgMZOEIy', 'applicant'),
(13, 'DASDAS ADAS. DAS', 'adas@gmail.com', '$2y$12$uyKvstwQoBt.o0wPi8dFWuc3E1lPxENEyb/e8k5bdCmB8STt2vSpG', 'applicant'),
(14, 'SDSAD DASSAD. ASDAS', 'asdas@gmail.com', '$2y$12$zrNeigHtflbe9IvXTPdTdeQpkkuMkCrM8YUwHeQHOuhRb105SuJ7u', 'applicant'),
(15, 'JEDI J. JEDI', 'jacob@gmail.com', '$2y$12$rREe5jPuU50y4D5/hv.NVe7uilRjjsRSberwPRTvuxcKbwAo6gHbK', 'applicant'),
(27, 'ANDREW O. GUILLERMO', 'paulaeronguillermo2@gmail.com', '$2y$12$Tlg4teSmSyK0rzGRmrUqqu.D5Fu2ecamcDyPTanWu5ULvL2UbcyiS', 'applicant'),
(38, 'MEH . MEH', 'meh@gmail.com', '$2y$12$T1K02sY482e3/M8x02PF9eH0lW90nT//LeSkpNztNgWlC4S9v.FLu', 'administrator');

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
(9, 9, 'PEDRO', 'P.', 'PEDRO', 'RED', 'R.', 'RED', 'FEU', 'GRADE 10'),
(10, 10, 'HDI', 'ADS.', 'ADS', 'AWDAS', 'ADAS.', 'ADS', 'ASDAA', 'GRADE 10'),
(11, 11, 'JEDI', 'J.', 'JEDI', 'BARA', 'J.', 'BARA', 'SDA', 'GRADE 10'),
(12, 12, 'FGH', 'FGH.', 'FGH', 'FGH', 'FGH.', 'FGH', 'FGH', 'GRADE 11'),
(13, 13, 'DASDAS', 'ADAS.', 'DAS', 'JFGHFG', 'FHFGH.', 'FGHFG', 'FGHGF', 'GRADE 12'),
(14, 14, 'SDSAD', 'DASSAD.', 'ASDAS', 'SDSAD', 'ASDA.', 'ASDAS', 'ADSA', 'GRADE 8'),
(15, 15, 'JEDI', 'J.', 'JEDI', 'JACOB', 'J.', 'JEDI', 'PASIG GREEN PASTURES', 'GRADE 11'),
(27, 27, 'ANDREW', 'O.', 'GUILLERMO', 'ANDREI', 'O.', 'GUILLERMO', 'VIRGEN DEL PILAR SCHOOL', 'GRADE 11');

-- --------------------------------------------------------

--
-- Table structure for table `form_submissions`
--

CREATE TABLE `form_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `applicant_id` int(10) UNSIGNED DEFAULT NULL,
  `applicant_fname` varchar(255) NOT NULL,
  `applicant_mname` varchar(255) DEFAULT NULL,
  `applicant_lname` varchar(255) NOT NULL,
  `applicant_contact_number` varchar(255) NOT NULL,
  `applicant_email` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `numstreet` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `guardian_fname` varchar(255) NOT NULL,
  `guardian_mname` varchar(255) DEFAULT NULL,
  `guardian_lname` varchar(255) NOT NULL,
  `guardian_contact_number` varchar(255) NOT NULL,
  `guardian_email` varchar(255) NOT NULL,
  `relation` varchar(255) NOT NULL,
  `current_school` varchar(255) NOT NULL,
  `current_school_city` varchar(255) NOT NULL,
  `school_type` varchar(255) NOT NULL,
  `educational_level` varchar(255) NOT NULL,
  `incoming_grlvl` varchar(255) NOT NULL,
  `applicant_bday` varchar(255) DEFAULT NULL,
  `lrn_no` varchar(255) DEFAULT NULL,
  `strand` varchar(255) DEFAULT NULL,
  `source` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(4, '2025_04_16_091659_create_password_resets_table', 1),
(5, '2025_04_20_074003_create_signup_otps_table', 1),
(6, '2025_04_22_051242_create_form_submissions_table', 2),
(8, '2025_04_23_012752_add_applicant_id_to_form_submissions', 3);

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
('La39yQqSjfqy1886POZezSQEWiAFcSpG7uMheZor', 38, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTo2OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiT3Zac1dEaGxNbXNnSHc0UmVGRU52cnEwR25JeHpvVWxSMjZhemVaViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbmlzdHJhdG9yL2Rhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM4O3M6NDoibmFtZSI7czo5OiJNRUggLiBNRUgiO3M6NToiZW1haWwiO3M6MTM6Im1laEBnbWFpbC5jb20iO30=', 1745547139);

-- --------------------------------------------------------

--
-- Table structure for table `signup_otps`
--

CREATE TABLE `signup_otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `form_submissions`
--
ALTER TABLE `form_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_submissions_applicant_id_foreign` (`applicant_id`);

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
-- Indexes for table `signup_otps`
--
ALTER TABLE `signup_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `signup_otps_email_index` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `form_submissions`
--
ALTER TABLE `form_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `signup_otps`
--
ALTER TABLE `signup_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `applicants_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `form_submissions`
--
ALTER TABLE `form_submissions`
  ADD CONSTRAINT `form_submissions_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
