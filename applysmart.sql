-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2025 at 05:13 PM
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
  `role` enum('applicant','admission','accounting','administrator') NOT NULL DEFAULT 'applicant',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(2, 'APPLICANT APPLICANT APPLICANT', 'applicant@gmail.com', '$2y$12$eCUALXhMNVKpLnn71JpC3.e14dlNpXtJw5vbAD0UeZsnuS/G2L9Wy', 'applicant', NULL, NULL),
(4, 'TEST T. TEST', 'test@gmail.com', '$2y$12$tKdzVO9.2FQ/SrmJbtHbXu35Whm9.yqA7qC.fYeIP2.NvULy06kwy', 'applicant', NULL, NULL),
(5, 'REST REST. TEST', 'rest@gmail.com', '$2y$12$Ernk7O1wwIX0abAhA2KtBegWKQtbDN420ej.wr48gqLgllJA0JnP6', 'applicant', NULL, NULL),
(7, 'SADSAAD ASDASDA. DAS', 'innovision@gmail.com', '$2y$12$ypYrVsuhjRhI4MMcj/jDY.z6/oyEQGf4lf9ncnwiYanbaQtCGXF1O', 'applicant', NULL, NULL),
(8, 'JHGJGGHJGHJ JHJGHJGH. JGHJGH', 'innovision2026@gmail.com', '$2y$12$Bcbkl1vpFuFb0zYfCIFieuEU8/xUqZM9E.mSKPVrUflDNUJ7G4Nfy', 'applicant', NULL, NULL),
(10, 'HDI ADS. ADS', 'wsaxd@gmail.com', '$2y$12$rDSx5IUIKqVsax6SN8vZnOYnauxO8MiUnnL9/5azHYgJZj10p/t8m', 'applicant', NULL, NULL),
(11, 'JEDI J. JEDI', 'jedi@gmail.com', '$2y$12$r6I2nzpYAiDqyVQZnBz9F.sit5rpHdAjRcOQdNyuA3i8tp5jVaXKK', 'applicant', NULL, NULL),
(12, 'FGH FGH. FGH', 'fgh@gmail.com', '$2y$12$Bv3TKW2OJTyXxDTdVdx0oekAlpNMRrXEzwTTpdL.taqfyYgMZOEIy', 'applicant', NULL, NULL),
(13, 'DASDAS ADAS. DAS', 'adas@gmail.com', '$2y$12$uyKvstwQoBt.o0wPi8dFWuc3E1lPxENEyb/e8k5bdCmB8STt2vSpG', 'applicant', NULL, NULL),
(14, 'SDSAD DASSAD. ASDAS', 'asdas@gmail.com', '$2y$12$zrNeigHtflbe9IvXTPdTdeQpkkuMkCrM8YUwHeQHOuhRb105SuJ7u', 'applicant', NULL, NULL),
(15, 'JEDI J. JEDI', 'jacob@gmail.com', '$2y$12$rREe5jPuU50y4D5/hv.NVe7uilRjjsRSberwPRTvuxcKbwAo6gHbK', 'applicant', NULL, NULL),
(27, 'ANDREW O. GUILLERMO', 'paulaeronguillermo2@gmail.com', '$2y$12$Tlg4teSmSyK0rzGRmrUqqu.D5Fu2ecamcDyPTanWu5ULvL2UbcyiS', 'applicant', NULL, NULL),
(38, 'MEH . MEH', 'meh@gmail.com', '$2y$12$T1K02sY482e3/M8x02PF9eH0lW90nT//LeSkpNztNgWlC4S9v.FLu', 'administrator', NULL, NULL),
(54, 'ACCOUNTANT . ACCOUNTANT', 'accountant@gmail.com', '$2y$12$gyjTmD66YVOl14d6RKoO0.I91hFE5trOw2ZIv6CzbU2u2s9Pn42TS', 'accounting', NULL, NULL),
(61, 'AERO  AERO', 'aero@gmail.com', '$2y$12$cT4wNzWqdd82/AO88DEylO39n36rkm/AsaZmVnyJrA11jbGUo/uL6', 'admission', NULL, NULL),
(71, 'ERNESTO M. BARCENAS', 'gaberanx@gmail.com', '$2y$12$e5iorgL8EzjxcOJ5Zx/EXOk3QXOGW3lfkPfJs1WSC.r0c6TyVWORa', 'applicant', NULL, NULL),
(74, 'ERNESTO  BARCENAS III', 'jayanthonysp@gmail.com', '$2y$12$6btujZvmYot23ta67KGlb.75GkHZqLNP1eiPIazKMAU88FImedKbm', 'applicant', NULL, NULL),
(96, 'GFIRST  GLAST', 'eiryksardalla696@gmail.com', '$2y$12$epxiLo3AAsVosX6EjM.iHuxtb6UxXdXPwAQSeUYzf/e78dPE7Bi3K', 'applicant', NULL, NULL),
(99, 'SHYLLA  LOVELOVE', 'eiryk.sardalla30@gmail.com', '$2y$12$0evNJ/hic/D2neG9eW0p/eASZC7.W6enJd7mp.s43pf5BqMjJpmEe', 'applicant', NULL, NULL),
(100, 'ERNESTO M. BARCENAS', 'gabebarcenas08@gmail.com', '$2y$12$0oi3G9NM7/MplQgGAi8vIuh/QCv6JZIDzPTfpwdNmkjefw0xV9Ska', 'applicant', '2025-05-14 07:06:18', '2025-05-14 07:06:18'),
(101, 'DEBIE J. GRAYSON', 'gabebarcenas02@gmail.com', '$2y$12$BeaFxega9oZcempZ9njVruH2GSeNv1Jo.vOx0sQ.mybZ64r8J2.fG', 'applicant', '2025-05-14 07:13:37', '2025-05-14 07:13:37'),
(103, 'GUSTAVE M. OBSCUR', 'gabebarcenas01@gmail.com', '$2y$12$V1/UqUiO6AxH0jdo/obDSutenDs1DdgRedZQcLdYBICRlf8Mbm8pG', 'applicant', '2025-05-15 05:08:02', '2025-05-15 05:08:02'),
(105, 'PAUL AERON  GUILLERMO', 'paulaeronguillermo@gmail.com', '$2y$12$0Fd9n49c2yXT7iEXon4xJ.a7fKlokxI48ohJSpj8eaPEqfjrfIY0u', 'applicant', '2025-05-19 14:11:49', '2025-05-19 14:11:49');

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
  `incoming_grlvl` varchar(32) NOT NULL,
  `recommended_strand` varchar(255) DEFAULT NULL,
  `current_step` int(11) NOT NULL DEFAULT 1,
  `strand_breakdown` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`strand_breakdown`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `account_id`, `guardian_fname`, `guardian_mname`, `guardian_lname`, `applicant_fname`, `applicant_mname`, `applicant_lname`, `current_school`, `incoming_grlvl`, `recommended_strand`, `current_step`, `strand_breakdown`) VALUES
(8, 8, 'JHGJGGHJGHJ', 'JHJGHJGH.', 'JGHJGH', 'NMBNMBN', 'BMBN.', 'BMBN', 'BNMBN', 'GRADE 9', NULL, 1, NULL),
(10, 10, 'HDI', 'ADS.', 'ADS', 'AWDAS', 'ADAS.', 'ADS', 'ASDAA', 'GRADE 10', NULL, 1, NULL),
(11, 11, 'JEDI', 'J.', 'JEDI', 'BARA', 'J.', 'BARA', 'SDA', 'GRADE 10', NULL, 1, NULL),
(12, 12, 'FGH', 'FGH.', 'FGH', 'FGH', 'FGH.', 'FGH', 'FGH', 'GRADE 11', NULL, 1, NULL),
(13, 13, 'DASDAS', 'ADAS.', 'DAS', 'JFGHFG', 'FHFGH.', 'FGHFG', 'FGHGF', 'GRADE 12', NULL, 1, NULL),
(15, 15, 'JEDI', 'J.', 'JEDI', 'JACOB', 'J.', 'JEDI', 'PASIG GREEN PASTURES', 'GRADE 11', NULL, 1, NULL),
(27, 27, 'ANDREW', 'O.', 'GUILLERMO', 'ANDREI', 'O.', 'GUILLERMO', 'VIRGEN DEL PILAR SCHOOL', 'GRADE 11', NULL, 3, NULL),
(68, 71, 'ERNESTO', 'M.', 'BARCENAS', 'GABE', 'M.', 'BARCENAS', 'UST', 'GRADE 1', NULL, 3, NULL),
(71, 74, 'ERNESTO', '', 'BARCENAS III', 'J. ANTHONY', 'BAUTISTA.', 'SAN PASCUAL', 'FEU DILIMAN', 'GRADE 11', NULL, 4, NULL),
(93, 96, 'GFIRST', '', 'GLAST', 'AFIRST', '', 'ALAST', 'TESTING', 'GRADE 7', NULL, 4, NULL),
(96, 99, 'SHYLLA', '', 'LOVELOVE', 'EIRYK', '', 'SARDALLA', 'FEU DILIMAN', 'GRADE 11', NULL, 2, NULL),
(97, 100, 'ERNESTO', 'M.', 'BARCENAS', 'MARK', 'M.', 'GRAYSON', 'URATH HIGH', 'GRADE 11', NULL, 4, NULL),
(98, 101, 'DEBIE', 'J.', 'GRAYSON', 'OLIVER', 'J.', 'GRAYSON', 'RON KINDER LAND', 'GRADE 1', NULL, 1, NULL),
(100, 103, 'GUSTAVE', 'M.', 'OBSCUR', 'CLAIRE', 'M.', 'OBSCUR', 'UST', 'GRADE 11', NULL, 1, NULL),
(102, 105, 'PAUL AERON', '', 'GUILLERMO', 'ANDREW', '', 'GUILLERMO', 'VIRGEN DEL PILAR SCHOOL', 'GRADE 10', NULL, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applicant_schedules`
--

CREATE TABLE `applicant_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `applicant_id` int(10) UNSIGNED NOT NULL,
  `admission_number` varchar(255) DEFAULT NULL,
  `applicant_name` varchar(255) NOT NULL,
  `applicant_contact_number` varchar(255) NOT NULL,
  `incoming_grade_level` varchar(255) NOT NULL,
  `exam_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicant_schedules`
--

INSERT INTO `applicant_schedules` (`id`, `applicant_id`, `admission_number`, `applicant_name`, `applicant_contact_number`, `incoming_grade_level`, `exam_date`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(54, 93, '2025-00002', 'AFIRST  ALAST', '09999999999', 'GRADE 7', '2025-05-13', '09:00:00', '10:00:00', '2025-05-10 02:33:58', '2025-05-10 02:33:58'),
(56, 68, '2025-00003', 'GABE M. BARCENAS', '09234567891', 'GRADE 1', '2025-05-31', '07:00:00', '08:00:00', '2025-05-19 13:21:24', '2025-05-19 13:21:24'),
(58, 27, '2025-00005', 'ANDREI O. GUILLERMO', '09985504802', 'GRADE 11', '2025-05-30', '07:00:00', '08:00:00', '2025-05-19 13:52:18', '2025-05-19 13:52:18'),
(59, 102, '2025-00006', 'ANDREW  GUILLERMO', '09985504802', 'GRADE 10', '2025-05-31', '07:00:00', '08:00:00', '2025-05-19 14:16:42', '2025-05-19 14:16:42'),
(62, 102, '2025-00007', 'ANDREW  GUILLERMO', '09985504802', 'GRADE 10', '2025-05-31', '07:00:00', '08:00:00', '2025-05-19 15:11:22', '2025-05-19 15:11:22');

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `applicant_id` int(10) UNSIGNED NOT NULL,
  `admission_number` varchar(255) DEFAULT NULL,
  `applicant_name` varchar(255) NOT NULL,
  `incoming_grade_level` varchar(255) NOT NULL,
  `exam_date` date NOT NULL,
  `exam_status` enum('done','no show') NOT NULL,
  `exam_result` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_results`
--

INSERT INTO `exam_results` (`id`, `applicant_id`, `admission_number`, `applicant_name`, `incoming_grade_level`, `exam_date`, `exam_status`, `exam_result`, `created_at`, `updated_at`) VALUES
(12, 93, '2025-00002', 'AFIRST ALAST', 'GRADE 7', '2025-05-13', 'done', 'passed', '2025-05-10 02:34:25', '2025-05-10 02:34:37'),
(14, 68, '2025-00003', 'GABE BARCENAS', 'GRADE 1', '2025-05-31', 'no show', 'no_show', '2025-05-19 13:22:57', '2025-05-19 13:22:57'),
(15, 27, '2025-00005', 'ANDREI GUILLERMO', 'GRADE 11', '2025-05-30', 'no show', 'no_show', '2025-05-19 13:53:18', '2025-05-19 13:53:32'),
(16, 102, '2025-00007', 'ANDREW GUILLERMO', 'GRADE 10', '2025-05-31', 'done', 'passed', '2025-05-19 14:17:42', '2025-05-19 15:12:44');

-- --------------------------------------------------------

--
-- Table structure for table `exam_schedules`
--

CREATE TABLE `exam_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `max_participants` int(11) NOT NULL,
  `educational_level` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_schedules`
--

INSERT INTO `exam_schedules` (`id`, `exam_date`, `start_time`, `end_time`, `max_participants`, `educational_level`, `created_at`, `updated_at`) VALUES
(22, '2025-05-10', '08:00:00', '09:00:00', 30, 'Grade School and Junior High School', '2025-05-08 03:19:18', '2025-05-08 03:19:18'),
(23, '2025-05-10', '08:00:00', '09:00:00', 30, 'Senior High School', '2025-05-08 03:56:12', '2025-05-08 03:56:12'),
(24, '2025-05-13', '09:00:00', '10:00:00', 30, 'Grade School and Junior High School', '2025-05-10 02:30:41', '2025-05-10 02:30:41'),
(25, '2025-05-17', '09:00:00', '10:00:00', 30, 'Senior High School', '2025-05-11 03:51:53', '2025-05-11 03:51:53'),
(26, '2025-05-31', '07:00:00', '08:00:00', 30, 'Grade School and Junior High School', '2025-05-18 22:49:16', '2025-05-18 22:49:16'),
(27, '2025-05-30', '07:00:00', '08:00:00', 30, 'Senior High School', '2025-05-18 22:49:40', '2025-05-18 22:49:40');

-- --------------------------------------------------------

--
-- Table structure for table `form_change_logs`
--

CREATE TABLE `form_change_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `changed_by` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `field_name` varchar(255) NOT NULL,
  `form_submission_id` bigint(20) UNSIGNED NOT NULL,
  `new_value` varchar(255) DEFAULT NULL,
  `old_value` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_change_logs`
--

INSERT INTO `form_change_logs` (`id`, `changed_by`, `created_at`, `field_name`, `form_submission_id`, `new_value`, `old_value`, `updated_at`) VALUES
(12, 'aero@gmail.com', '2025-05-19 10:50:00', 'gender', 37, 'Female', 'Male', '2025-05-19 10:50:00'),
(13, 'aero@gmail.com', '2025-05-19 10:50:37', 'guardian_fname', 37, 'Paul', 'ERNESTO', '2025-05-19 10:50:37');

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
  `source` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_submissions`
--

INSERT INTO `form_submissions` (`id`, `applicant_id`, `applicant_fname`, `applicant_mname`, `applicant_lname`, `applicant_contact_number`, `applicant_email`, `region`, `province`, `city`, `barangay`, `numstreet`, `postal_code`, `age`, `gender`, `nationality`, `guardian_fname`, `guardian_mname`, `guardian_lname`, `guardian_contact_number`, `guardian_email`, `relation`, `current_school`, `current_school_city`, `school_type`, `educational_level`, `incoming_grlvl`, `applicant_bday`, `lrn_no`, `strand`, `source`, `created_at`, `updated_at`) VALUES
(35, 68, 'GABE', 'M.', 'BARCENAS', '09234567891', 'gaberanx@gmail.com', 'NCR', 'Metro Manila (NCR)', 'Quezon City', 'Pasong Tamo', '12 C', '123', 6, 'Male', 'Filipino', 'ERNESTO', 'M.', 'BARCENAS', '09876543212', 'gaberanx@gmail.com', 'Parents', 'UST', 'Quezon City, Metro Manila', 'Private Sectarian', 'Grade School', 'GRADE 1', '2019-06-04', '202210123', NULL, 'Billboard', NULL, NULL),
(37, 71, 'J. ANTHONY', 'BAUTISTA.', 'SAN PASCUAL', '09672980038', 'jayanthonysp@gmail.com', 'CALABARZON', 'Rizal', 'Rodriguez', 'San Rafael', 'Blk 12 Lot 2 San Antonio St.', '0618', 22, 'Female', 'Doctor', 'Paul', NULL, 'BARCENAS III', '09876543210', 'jayanthonysp@gmail.com', 'Grandparents', 'FEU DILIMAN', 'Quezon, Quezon', 'Public', 'Senior High School', 'GRADE 11', NULL, '097876548872', 'STEM Engineering', 'Social Media (Facebook, TikTok, Instagram, Youtube, etc)', NULL, '2025-05-19 10:50:37'),
(57, 93, 'AFIRST', NULL, 'ALAST', '09999999999', 'eiryksardalla696@gmail.com', 'NCR', 'Metro Manila (NCR)', 'Quezon City', 'Pasong Tamo', 'fds232', '1231', 13, 'Male', 'filipino', 'GFIRST', NULL, 'GLAST', '09999999999', 'eiryksardalla696@gmail.com', 'Parents', 'TESTING', 'Quezon City, Metro Manila', 'Public', 'Junior High School', 'GRADE 7', NULL, '1234', NULL, 'Social Media (Facebook, TikTok, Instagram, Youtube, etc)', NULL, NULL),
(60, 96, 'EIRYK', NULL, 'SARDALLA', '09999999999', 'eiryk.sardalla30@gmail.com', 'NCR', 'Metro Manila (NCR)', 'Quezon City', 'Batasan Hills', 'fds232', '1231', 13, 'Male', 'filipino', 'SHYLLA', NULL, 'LOVELOVE', '09999999999', 'eiryk.sardalla30@gmail.com', 'Parents', 'FEU DILIMAN', 'Quezon City, Metro Manila', 'Public', 'Senior High School', 'GRADE 11', NULL, '21412123', 'STEM Information Technology', 'Friends/Family/Relatives', NULL, NULL),
(61, 97, 'MARK', 'M.', 'GRAYSON', '09111111111', 'gabebarcenas02@gmail.com', 'NCR', 'Metro Manila (NCR)', 'Quezon City', 'Damayan', '16T', '1222', 14, 'Male', 'Viltrumite', 'ERNESTO', 'M.', 'BARCENAS', '09666666666', 'gabebarcenas08@gmail.com', 'Cousin', 'URATH HIGH', 'Quezon, Quezon', 'Private Non-Sectarian', 'Senior High School', 'GRADE 11', NULL, '209910123', 'STEM Information Technology', 'Friends/Family/Relatives', NULL, NULL),
(64, 27, 'ANDREI', 'O.', 'GUILLERMO', '09985504802', 'paulaeronguillermo@gmail.com', 'CALABARZON', 'Rizal', 'Rodriguez', 'San Jose', '393 G. Bautista Street', '1860', 22, 'Male', 'Filipino', 'ANDREW', 'O.', 'GUILLERMO', '09985504802', 'paulaeronguillermo2@gmail.com', 'Parents', 'VIRGEN DEL PILAR SCHOOL', 'Rodriguez, Rizal', 'Public', 'Senior High School', 'GRADE 11', NULL, '2123', 'STEM Engineering', 'Friends/Family/Relatives', '2025-05-19 13:51:33', '2025-05-19 13:51:33'),
(65, 102, 'ANDREW', NULL, 'GUILLERMO', '09985504802', 'paulaeronguillermo2@gmail.com', 'Cagayan Valley', 'Cagayan', 'Piat', 'Baung', '393 G. Bautista Street', '123', 22, 'Female', 'Filipino', 'PAUL AERON', NULL, 'GUILLERMO', '09888888888', 'paulaeronguillermo@gmail.com', 'Uncle/Aunt', 'VIRGEN DEL PILAR SCHOOL', 'Rodriguez, Rizal', 'Private Sectarian', 'Junior High School', 'GRADE 10', NULL, '2123', NULL, 'Friends/Family/Relatives', '2025-05-19 14:14:27', '2025-05-19 14:14:27');

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
(8, '2025_04_23_012752_add_applicant_id_to_form_submissions', 3),
(9, '2025_04_25_084546_create_payment_information', 4),
(10, '2025_04_25_085805_create_payment_information', 5),
(13, '2025_04_26_074855_create_payment', 6),
(14, '2025_04_26_092949_add_applicant_fields_to_payment', 6),
(15, '2025_04_26_094725_create_payment', 7),
(16, '2025_04_26_113802_create_payment', 8),
(17, '2025_04_26_121702_create_payment', 9),
(18, '2025_04_26_124910_create_payment', 10),
(19, '2025_04_26_140637_add_payment_status_to_payment', 11),
(20, '2025_04_28_064645_create_exam_schedules', 12),
(21, '2025_04_29_030150_create_applicant_schedules_table', 13),
(22, '2025_04_29_053724_create_applicant_schedules', 14),
(23, '2025_04_27_175754_add_current_step_to_applicants_table', 15),
(24, '2025_04_30_154729_add_remarks_to_payment_table', 16),
(26, '2025_05_03_055832_add_ocr_number_to_payment', 17),
(27, '2025_05_04_080706_create_exam_results', 18),
(28, '2025_05_04_090025_create_exam_results', 19),
(29, '2025_05_04_110813_add_receipt_to_payment_table', 20),
(30, '2025_05_06_104316_create_exam_results', 21),
(31, '2025_05_08_052159_create_exam_results', 22),
(32, '2025_05_08_055849_rename_user_id_to_applicant_id_in_applicant_schedules', 23),
(33, '2025_05_08_060449_add_applicant_id_to_applicant_schedules', 24),
(34, '2025_05_08_060625_drop_applicant_id_from_applicant_schedules', 24),
(35, '2025_05_08_061531_add_applicant_id_to_applicant_schedules', 25),
(36, '2025_05_08_062839_create_applicant_schedules', 26),
(39, '2025_05_09_072638_add_admission_number_to_applicant_schedules', 27),
(40, '2025_05_10_005323_add_admission_number_to_exam_results', 28),
(42, '2025_05_12_073509_create_form_change_logs', 29),
(43, '2025_05_13_094712_add_guardian_name_to_payment', 30),
(44, '2025_05_13_105352_add_timestamps_to_accounts', 31),
(45, '2025_05_15_071759_add_recommended_strand_to_applicants_table', 32),
(46, '2025_05_17_031034_add_timestamps_to_form_submissions', 33),
(47, '2025_05_17_035621_add_unique_to_admission_number_in_applicant_schedules', 33),
(48, '2025_05_17_115442_add_strand_breakdown_to_applicants_table', 34),
(49, '2025_05_19_205158_add_payment_for_to_payment_table', 34),
(50, '2025_05_19_230704_add_payment_for_to_payment_table', 35);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('jayanthonysp@gmail.com', 'dU7cdHMCP8F9IQOeVTNT6XX43knkIfFGPdCV01rZNcxiapTnU7uK2knvgFzhCF5D', '2025-05-04 17:22:13');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `applicant_id` int(10) UNSIGNED NOT NULL,
  `applicant_fname` varchar(255) NOT NULL,
  `applicant_mname` varchar(255) DEFAULT NULL,
  `applicant_lname` varchar(255) NOT NULL,
  `applicant_email` varchar(255) NOT NULL,
  `applicant_contact_number` varchar(255) NOT NULL,
  `guardian_fname` varchar(255) DEFAULT NULL,
  `guardian_mname` varchar(255) DEFAULT NULL,
  `guardian_lname` varchar(255) DEFAULT NULL,
  `incoming_grlvl` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `proof_of_payment` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `ocr_number` varchar(255) DEFAULT NULL,
  `payment_date` date NOT NULL,
  `payment_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `payment_for` varchar(255) NOT NULL DEFAULT 'first-time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `applicant_id`, `applicant_fname`, `applicant_mname`, `applicant_lname`, `applicant_email`, `applicant_contact_number`, `guardian_fname`, `guardian_mname`, `guardian_lname`, `incoming_grlvl`, `payment_method`, `proof_of_payment`, `payment_status`, `remarks`, `ocr_number`, `payment_date`, `payment_time`, `created_at`, `updated_at`, `receipt`, `payment_for`) VALUES
(31, 71, 'J. ANTHONY', 'BAUTISTA.', 'SAN PASCUAL', 'jayanthonysp@gmail.com', '09672980038', NULL, NULL, NULL, 'GRADE 11', 'BDO', 'payment_proofs/proof_68180d3ae76743.87459667.jpg', 'approved', 'bobo ka kys', '0987654321', '2025-05-05', '08:58:35', '2025-05-04 16:58:35', '2025-05-04 17:01:26', 'payment_receipts/O3aS6d7gP0GEnSDgFmLzeGf2A0VdkbsJmH9EZARS.jpg', 'first-time'),
(52, 93, 'AFIRST', '', 'ALAST', 'eiryksardalla696@gmail.com', '09999999999', NULL, NULL, NULL, 'GRADE 7', 'Metrobank', 'payment_proofs/proof_681f2b7d717509.59037391.png', 'approved', NULL, NULL, '2025-05-10', '18:33:33', '2025-05-10 02:33:33', '2025-05-10 02:33:41', NULL, 'first-time'),
(55, 96, 'EIRYK', '', 'SARDALLA', 'eiryk.sardalla30@gmail.com', '09999999999', 'SHYLLA', '', 'LOVELOVE', 'GRADE 11', 'BDO', 'payment_proofs/proof_68231e93c45f52.88752964.png', 'approved', NULL, NULL, '2025-05-13', '18:27:31', '2025-05-13 02:27:31', '2025-05-13 02:28:33', NULL, 'first-time'),
(56, 97, 'MARK', 'M.', 'GRAYSON', 'gabebarcenas02@gmail.com', '09111111111', 'ERNESTO', 'M.', 'BARCENAS', 'GRADE 11', 'LandBank', 'payment_proofs/proof_6824b253597d01.94511524.png', 'approved', 'Whats Up', '123456', '2025-05-14', '23:10:12', '2025-05-14 07:10:12', '2025-05-14 07:10:48', 'payment_receipts/HIrXf6JGW96C61ouoE2jxNrSqSloG5P43zeZZJeB.png', 'first-time'),
(60, 68, 'GABE', 'M.', 'BARCENAS', 'gaberanx@gmail.com', '09234567891', 'ERNESTO', 'M.', 'BARCENAS', 'GRADE 1', 'BDO', 'payment_proofs/proof_682b370f82e435.50542032.jpg', 'pending', NULL, NULL, '2025-05-19', '21:50:07', '2025-05-19 13:50:07', '2025-05-19 13:50:07', NULL, 'first-time'),
(61, 27, 'ANDREI', 'O.', 'GUILLERMO', 'paulaeronguillermo@gmail.com', '09985504802', 'ANDREW', 'O.', 'GUILLERMO', 'GRADE 11', 'BDO', 'payment_proofs/proof_682b376c5927d9.68837926.png', 'approved', NULL, NULL, '2025-05-19', '21:51:40', '2025-05-19 13:51:40', '2025-05-19 13:52:03', NULL, 'first-time'),
(63, 27, 'ANDREI', 'O.', 'GUILLERMO', 'paulaeronguillermo@gmail.com', '09985504802', 'ANDREW', 'O.', 'GUILLERMO', 'GRADE 11', 'LandBank', 'payment_proofs/proof_682b39faccdbd8.55002528.png', 'pending', NULL, NULL, '2025-05-19', '22:02:34', '2025-05-19 14:02:34', '2025-05-19 14:02:34', NULL, 'first-time'),
(66, 102, 'ANDREW', '', 'GUILLERMO', 'paulaeronguillermo2@gmail.com', '09985504802', 'PAUL AERON', '', 'GUILLERMO', 'GRADE 10', 'Robinsons_Bank', 'payment_proofs/proof_682b4362614402.51303842.png', 'pending', NULL, NULL, '2025-05-19', '22:42:42', '2025-05-19 14:42:42', '2025-05-19 14:42:42', NULL, 'first-time'),
(68, 102, 'ANDREW', '', 'GUILLERMO', 'paulaeronguillermo2@gmail.com', '09985504802', 'PAUL AERON', '', 'GUILLERMO', 'GRADE 10', 'Robinsons_Bank', 'payment_proofs/proof_682b49af237af5.38642761.png', 'approved', NULL, NULL, '2025-05-19', '23:09:35', '2025-05-19 15:09:35', '2025-05-19 15:11:02', NULL, 'resched');

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
('d87QZZqzTDccs2pNlAI4rplhN3v0MQl0KNV5KPWr', 105, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiN1U5NmlNQWJLb2FlVHQydkVjWHI1eWFiZE4yRUVGaE9KWVBucnBQZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdGVwLTYiO31zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjI4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvc3RlcC0yIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA1O3M6NDoibmFtZSI7czoyMToiUEFVTCBBRVJPTiAgR1VJTExFUk1PIjtzOjU6ImVtYWlsIjtzOjI4OiJwYXVsYWVyb25ndWlsbGVybW9AZ21haWwuY29tIjtzOjQ6InJvbGUiO3M6OToiYXBwbGljYW50Ijt9', 1747667568),
('g3fiWIQHp1cCk6X4hr9EXVKT4mbuAEX3T6wWiMUc', 61, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo3OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiYVB0UUFnazVVZXYxYXVTZjlIOGY1alNmbWZaOXVvV2tOeXFxUjlmTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pc3Npb24vZXhhbS9leGFtLXJlc3VsdCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjYxO3M6NDoibmFtZSI7czoxMDoiQUVSTyAgQUVSTyI7czo1OiJlbWFpbCI7czoxNDoiYWVyb0BnbWFpbC5jb20iO3M6NDoicm9sZSI7czo5OiJhZG1pc3Npb24iO30=', 1747667565);

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
-- Indexes for table `applicant_schedules`
--
ALTER TABLE `applicant_schedules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `applicant_schedules_admission_number_unique` (`admission_number`),
  ADD KEY `applicant_schedules_applicant_id_foreign` (`applicant_id`);

--
-- Indexes for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_results_applicant_id_foreign` (`applicant_id`);

--
-- Indexes for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_change_logs`
--
ALTER TABLE `form_change_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_change_logs_form_submission_id_foreign` (`form_submission_id`);

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
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_applicant_id_foreign` (`applicant_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `applicant_schedules`
--
ALTER TABLE `applicant_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `form_change_logs`
--
ALTER TABLE `form_change_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `form_submissions`
--
ALTER TABLE `form_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `signup_otps`
--
ALTER TABLE `signup_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `applicants_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `applicant_schedules`
--
ALTER TABLE `applicant_schedules`
  ADD CONSTRAINT `applicant_schedules_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD CONSTRAINT `exam_results_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form_change_logs`
--
ALTER TABLE `form_change_logs`
  ADD CONSTRAINT `form_change_logs_form_submission_id_foreign` FOREIGN KEY (`form_submission_id`) REFERENCES `form_submissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form_submissions`
--
ALTER TABLE `form_submissions`
  ADD CONSTRAINT `form_submissions_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
