-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2025 at 06:28 PM
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
(3, 'Ernesto M. Barcenas', 'gabe@gmail.com', '$2y$12$sXaqNol4PjZEJdVIcExJjOO761sKELuppsZBOThhiC41/XhThM3y6', 'applicant', NULL, NULL),
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
(38, 'PAUL D. GUILLERMO', 'meh@gmail.com', '$2y$12$HQW9yyJQPgzwzCE8.hlpyuxau/ufSR6D.0r6Hl5rzSGRttCf.jGu6', 'administrator', NULL, '2025-06-04 06:55:13'),
(54, 'JESSICA D. ACCOUNTANT', 'accountant@gmail.com', '$2y$12$Fn5umgeW/9ayyUM6iA7OUeXj5JPp6oSHFzkV24j3CNMwcHX3vgISO', 'accounting', NULL, '2025-06-04 06:58:10'),
(61, 'REA DJ. JAMES', 'aero@gmail.com', '$2y$12$cT4wNzWqdd82/AO88DEylO39n36rkm/AsaZmVnyJrA11jbGUo/uL6', 'admission', NULL, '2025-06-04 06:54:02'),
(74, 'ERNESTO  BARCENAS III', 'jayanthonysp@gmail.com', '$2y$12$6btujZvmYot23ta67KGlb.75GkHZqLNP1eiPIazKMAU88FImedKbm', 'applicant', NULL, NULL),
(96, 'GFIRST  GLAST', 'eiryksardalla696@gmail.com', '$2y$12$epxiLo3AAsVosX6EjM.iHuxtb6UxXdXPwAQSeUYzf/e78dPE7Bi3K', 'applicant', NULL, NULL),
(101, 'DEBIE J. GRAYSON', 'gabebarcenas02@gmail.com', '$2y$12$BeaFxega9oZcempZ9njVruH2GSeNv1Jo.vOx0sQ.mybZ64r8J2.fG', 'applicant', '2025-05-14 07:13:37', '2025-05-14 07:13:37'),
(103, 'GUSTAVE M. OBSCUR', 'gabebarcenas01@gmail.com', '$2y$12$V1/UqUiO6AxH0jdo/obDSutenDs1DdgRedZQcLdYBICRlf8Mbm8pG', 'applicant', '2025-05-15 05:08:02', '2025-05-15 05:08:02'),
(106, 'SHYLLA MAE  LOVELOVE', 'eiryk.sardalla30@gmail.com', '$2y$12$AH2lk0FkHoahMySXzVdIx..IniS1uvvp2apWLiZ/5pSDOsAxLBznu', 'applicant', '2025-05-16 23:17:51', '2025-05-16 23:17:51'),
(108, 'TOJI M. FUSHIGURO', 'gaberanx@gmail.com', '$2y$12$NwIV9xIYnm07ykjeJMq7Luw2qKZJAB.fM8bSL9ujTQ2zT41ypbKfG', 'applicant', '2025-05-19 10:59:42', '2025-05-19 10:59:42'),
(111, 'SHYLLA  GANDA', 'kyrie.sardalla@gmail.com', '$2y$12$Y10tN77UElekq6ZqT9yMcugKJMw4mCcdtwdfuTjm239A2oL/GbQfS', 'applicant', '2025-05-19 15:29:06', '2025-05-19 15:29:06'),
(140, 'CORNY M. CORN', 'gabebarcenas08@gmail.com', '$2y$12$37hg.7wx7brN3WOuS/xH8.QCsDS54SnPhQorauWHnJZUJJnbfc3uO', 'applicant', '2025-06-02 06:12:51', '2025-06-02 06:12:51'),
(141, 'SARAH  PANGILINAN', 'paulaeronguillermo@gmail.com', '$2y$12$2Kn5OeW0O9U3v.klMHvvYuGWuiiXthuPmA9z35c0ZL6pcXr4MjjQe', 'applicant', '2025-06-02 14:01:00', '2025-06-02 14:01:00'),
(143, 'LOUIS P. DINO', 'ishie@gmail.com', '$2y$12$UVQU87nQDX34s9KYEAQ2eOct7pxUdNJIdn/Ls41pUh9l8JGn5s6ZK', 'admission', '2025-06-05 02:33:08', '2025-06-05 02:33:08'),
(144, 'MACKY C. PONGPONG', 'mackypongpong@yahoo.com', '$2y$12$XU0GkUpX8U7Z0lPb0Gy7JeMtTCTpQnO7HAaQ/.Qy5VT0ioyJC0UUa', 'applicant', '2025-06-05 02:45:10', '2025-06-05 02:45:10'),
(145, 'LOUIS  RABARA', 'louisrabara@gmail.com', '$2y$12$HJmkH3k4yzEI3UF6RJyKDuaHHo8ipWt9GeZ6CrNysdV5bY4q63SzG', 'applicant', '2025-06-05 09:13:47', '2025-06-05 09:13:47'),
(146, 'ARNOLD N. GUILLERMO', 'paulaeronguillermo2@gmail.com', '$2y$12$4dz25zyFBJATtOKr3FX4C.5ImTzyhnLJkDraaJKjReWmYJmK9Kx72', 'applicant', '2025-06-05 09:31:13', '2025-06-05 09:31:13'),
(148, 'MARIA E. DELA CRUZ', 'trojan1403@gmail.com', '$2y$12$v2hyuA.qBKg8n8EkEF7xQ.e5HhDgBTSOHPjiqJx.B5OwNxBzSaaa2', 'applicant', '2025-06-06 14:18:36', '2025-06-06 14:18:36');

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
  `strand_breakdown` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`strand_breakdown`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_reschedule_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `account_id`, `guardian_fname`, `guardian_mname`, `guardian_lname`, `applicant_fname`, `applicant_mname`, `applicant_lname`, `current_school`, `incoming_grlvl`, `recommended_strand`, `current_step`, `strand_breakdown`, `created_at`, `updated_at`, `is_reschedule_active`) VALUES
(3, 3, 'Ernesto', 'M.', 'Barcenas', 'Kyrie', 'S.', 'Sardalla', 'FEU', 'Grade 8', NULL, 1, NULL, NULL, NULL, 0),
(8, 8, 'JHGJGGHJGHJ', 'JHJGHJGH.', 'JGHJGH', 'NMBNMBN', 'BMBN.', 'BMBN', 'BNMBN', 'GRADE 9', NULL, 1, NULL, NULL, NULL, 0),
(10, 10, 'HDI', 'ADS.', 'ADS', 'AWDAS', 'ADAS.', 'ADS', 'ASDAA', 'GRADE 10', NULL, 1, NULL, NULL, NULL, 0),
(11, 11, 'JEDI', 'J.', 'JEDI', 'BARA', 'J.', 'BARA', 'SDA', 'GRADE 10', NULL, 1, NULL, NULL, NULL, 0),
(12, 12, 'FGH', 'FGH.', 'FGH', 'FGH', 'FGH.', 'FGH', 'FGH', 'GRADE 11', NULL, 1, NULL, NULL, NULL, 0),
(13, 13, 'DASDAS', 'ADAS.', 'DAS', 'JFGHFG', 'FHFGH.', 'FGHFG', 'FGHGF', 'GRADE 12', NULL, 1, NULL, NULL, NULL, 0),
(15, 15, 'JEDI', 'J.', 'JEDI', 'JACOB', 'J.', 'JEDI', 'PASIG GREEN PASTURES', 'GRADE 11', NULL, 1, NULL, NULL, NULL, 0),
(71, 74, 'ERNESTO', '', 'BARCENAS III', 'J. ANTHONY', 'BAUTISTA.', 'SAN PASCUAL', 'FEU DILIMAN', 'GRADE 11', NULL, 4, NULL, NULL, '2025-05-24 00:24:28', 0),
(93, 96, 'GFIRST', '', 'GLAST', 'PAUL', '', 'ALAST', 'TESTING', 'GRADE 7', NULL, 7, NULL, NULL, '2025-06-05 09:19:58', 0),
(98, 101, 'DEBIE', 'J.', 'GRAYSON', 'OLIVER', 'J.', 'GRAYSON', 'RON KINDER LAND', 'GRADE 1', NULL, 1, NULL, NULL, NULL, 0),
(100, 103, 'GUSTAVE', 'M.', 'OBSCUR', 'CLAIRE', 'M.', 'OBSCUR', 'UST', 'GRADE 11', 'STEM Engineering', 1, '{\"stem\":27.4,\"abm\":23.29,\"humss\":23.29,\"sports\":19.18,\"gas\":6.85}', NULL, NULL, 0),
(103, 106, 'SHYLLA MAE', '', 'LOVELOVE', 'EIRYK', 'B.', 'SARDALLA', 'FEU DILIMAN', 'GRADE 11', NULL, 7, NULL, NULL, '2025-06-05 09:21:22', 0),
(105, 108, 'TOJI', 'M.', 'FUSHIGURO', 'MEGUMI', 'M.', 'FUSHIGURO', 'JUJUTSU HIGH', 'GRADE 11', 'STEM Health Allied', 1, '{\"stem\":29.73,\"abm\":29.73,\"sports\":17.57,\"humss\":13.51,\"gas\":9.46}', NULL, NULL, 0),
(108, 111, 'SHYLLA', '', 'GANDA', 'EYREK', '', 'SARDINAS', 'FEU DILIMAN', 'GRADE 11', 'GAS', 7, '{\"gas\":35.37,\"stem\":17.07,\"abm\":17.07,\"humss\":17.07,\"sports\":13.41}', '2025-05-19 15:29:06', '2025-05-19 15:38:37', 0),
(137, 140, 'CORNY', 'M.', 'CORN', 'BACON', 'M.', 'BACONATOR', 'UP', 'GRADE 11', NULL, 7, NULL, '2025-06-02 06:12:51', '2025-06-02 06:51:17', 0),
(138, 141, 'SARAH', '', 'PANGILINAN', 'JOSHUA', '', 'PANGILINAN', 'MARY THE QUEEN SCHOOL', 'GRADE 11', NULL, 7, NULL, '2025-06-02 14:01:00', '2025-06-06 07:28:48', 0),
(140, 144, 'MACKY', 'C.', 'PONGPONG', 'AILENE', 'C.', 'PONGPONG', 'QUEZON CITY ACADEMY', 'GRADE 11', 'ABM Business Management', 5, '{\"abm\":36.76,\"humss\":23.53,\"sports\":23.53,\"stem\":10.29,\"gas\":5.88}', '2025-06-05 02:45:10', '2025-06-05 04:06:10', 0),
(141, 145, 'LOUIS', '', 'RABARA', 'AMIEL', '', 'BICALDO', 'FEU DILIMAN', 'KINDER', NULL, 5, NULL, '2025-06-05 09:13:47', '2025-06-05 10:18:05', 0),
(142, 146, 'ARNOLD', 'N.', 'GUILLERMO', 'PAUL AERON', 'A.', 'GUILLERMO', 'FEU RODRIGUEZ ROOSEVELT', 'GRADE 7', NULL, 7, NULL, '2025-06-05 09:31:13', '2025-06-06 09:08:29', 0),
(144, 148, 'MARIA', 'E.', 'DELA CRUZ', 'JUAN', 'R.', 'DELA CRUZ', 'XYZ ELEMENTARY', 'GRADE 1', NULL, 1, NULL, '2025-06-06 14:18:36', '2025-06-06 14:18:36', 0);

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
  `venue` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicant_schedules`
--

INSERT INTO `applicant_schedules` (`id`, `applicant_id`, `admission_number`, `applicant_name`, `applicant_contact_number`, `incoming_grade_level`, `exam_date`, `start_time`, `end_time`, `venue`, `created_at`, `updated_at`) VALUES
(54, 93, '2025-00002', 'PAUL ALAST', '09999999999', 'GRADE 7', '2025-06-28', '07:00:00', '08:00:00', NULL, '2025-05-10 02:33:58', '2025-06-05 09:19:58'),
(58, 103, '2025-00004', 'EIRYK SARDALLA', '09999999999', 'GRADE 11', '2025-06-23', '09:00:00', '10:00:00', NULL, '2025-05-19 13:13:55', '2025-06-05 09:21:22'),
(61, 108, '2025-00005', 'EYREK  SARDINAS', '09999999999', 'GRADE 11', '2025-05-24', '09:00:00', '10:00:00', 'MPR Annex', '2025-05-19 15:35:27', '2025-05-19 15:35:27'),
(62, 108, '2025-00006', 'EYREK  SARDINAS', '09999999999', 'GRADE 11', '2025-05-24', '08:00:00', '09:00:00', 'MPR Annex', '2025-05-19 15:37:33', '2025-05-19 15:37:33'),
(116, 137, '2025-00008', 'BACON M. BACONATOR', '09444444444', 'GRADE 11', '2025-07-23', '06:00:00', '08:00:00', 'MPR Annex', '2025-06-02 06:43:22', '2025-06-02 06:43:22'),
(121, 138, '2025-00011', 'JOSHUA PANGILINAN', '09985504802', 'GRADE 11', '2025-06-18', '13:00:00', '16:00:00', 'MPR Annex', '2025-06-02 14:07:11', '2025-06-06 07:28:48'),
(124, 140, '2025-00013', 'AILENE C. PONGPONG', '09985504802', 'GRADE 11', '2025-06-28', '13:00:00', '16:00:00', 'MPR Annex', '2025-06-05 04:06:10', '2025-06-05 04:06:10'),
(126, 141, '2025-00015', 'AMIEL  BICALDO', '09985504802', 'KINDER', '2025-06-28', '07:00:00', '08:00:00', 'MPR Annex', '2025-06-05 10:18:05', '2025-06-05 10:18:05'),
(127, 142, '2025-00016', 'PAUL AERON GUILLERMO', '09985504802', 'GRADE 7', '2025-06-06', '07:00:00', '08:00:00', 'MPR Annex', '2025-06-06 07:31:43', '2025-06-06 09:08:25');

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
  `exam_status` enum('done','no show') DEFAULT NULL,
  `exam_result` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_results`
--

INSERT INTO `exam_results` (`id`, `applicant_id`, `admission_number`, `applicant_name`, `incoming_grade_level`, `exam_date`, `exam_status`, `exam_result`, `created_at`, `updated_at`) VALUES
(12, 93, '2025-00002', 'PAUL ALAST', 'GRADE 7', '2025-06-28', 'no show', 'no show', '2025-06-05 09:19:58', '2025-06-05 09:19:58'),
(15, 103, '2025-00004', 'EIRYK SARDALLA', 'GRADE 11', '2025-06-23', 'no show', 'no show', '2025-06-05 09:21:22', '2025-06-05 09:21:22'),
(18, 108, '2025-00005', 'EYREK SARDINAS', 'GRADE 11', '2025-05-24', 'done', 'passed', '2025-05-19 15:37:47', '2025-05-19 15:38:37'),
(43, 137, '2025-00008', 'BACON BACONATOR', 'GRADE 11', '2025-07-23', 'done', 'passed', '2025-06-02 06:16:51', '2025-06-04 04:25:42'),
(45, 138, '2025-00011', 'JOSHUA PANGILINAN', 'GRADE 11', '2025-06-18', 'done', 'interview', '2025-06-06 07:28:48', '2025-06-06 07:28:48'),
(47, 140, '2025-00013', 'AILENE C. PONGPONG', 'GRADE 11', '2025-06-28', NULL, NULL, '2025-06-05 04:06:10', '2025-06-05 04:06:10'),
(48, 142, '2025-00016', 'PAUL AERON GUILLERMO', 'GRADE 7', '2025-06-06', 'done', 'interview', '2025-06-06 09:08:25', '2025-06-06 09:08:25'),
(49, 141, '2025-00015', 'AMIEL  BICALDO', 'KINDER', '2025-06-28', NULL, NULL, '2025-06-05 10:18:05', '2025-06-05 10:18:05');

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
(34, '2025-06-23', '11:00:00', '00:00:00', 1, 'Grade School and Junior High School', '2025-06-02 13:37:08', '2025-06-02 13:37:08'),
(35, '2025-06-23', '13:00:00', '16:00:00', 1, 'Senior High School', '2025-06-02 13:38:46', '2025-06-02 13:38:46'),
(42, '2025-07-23', '08:00:00', '09:00:00', 30, 'Senior High School', '2025-06-03 06:07:34', '2025-06-03 06:07:34'),
(51, '2025-06-28', '07:00:00', '08:00:00', 2, 'Grade School and Junior High School', '2025-06-03 09:27:59', '2025-06-03 09:27:59'),
(52, '2025-06-28', '13:00:00', '16:00:00', 2, 'Senior High School', '2025-06-03 09:27:59', '2025-06-03 09:27:59'),
(53, '2025-06-18', '07:00:00', '08:00:00', 30, 'Grade School and Junior High School', '2025-06-03 14:10:00', '2025-06-03 14:10:00'),
(54, '2025-06-18', '09:00:00', '10:00:00', 30, 'Grade School and Junior High School', '2025-06-03 14:10:00', '2025-06-03 14:10:00'),
(56, '2025-06-18', '08:00:00', '11:00:00', 30, 'Senior High School', '2025-06-03 14:10:00', '2025-06-03 14:10:00'),
(57, '2025-06-18', '13:00:00', '16:00:00', 30, 'Senior High School', '2025-06-03 14:10:00', '2025-06-03 14:10:00'),
(58, '2025-06-22', '08:00:00', '09:00:00', 23, 'Grade School and Junior High School', '2025-06-03 14:37:08', '2025-06-03 14:37:08'),
(59, '2025-06-07', '08:00:00', '09:00:00', 1, 'Senior High School', '2025-06-04 00:36:29', '2025-06-04 00:36:29'),
(60, '2025-07-08', '08:00:00', '09:00:00', 1, 'Grade School and Junior High School', '2025-06-05 09:52:19', '2025-06-05 09:52:19'),
(61, '2025-06-06', '07:00:00', '08:00:00', 1, 'Grade School and Junior High School', '2025-06-05 11:20:38', '2025-06-05 11:20:38');

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
(12, 'aero@gmail.com', '2025-05-17 00:33:25', 'applicant_lname', 65, 'SARDALLAAA', 'SARDALLA', '2025-05-17 00:33:25'),
(13, 'aero@gmail.com', '2025-05-17 00:41:28', 'applicant_lname', 65, 'SARDALLA', 'SARDALLAAA', '2025-05-17 00:41:28'),
(14, 'aero@gmail.com', '2025-05-17 00:52:54', 'applicant_lname', 65, 'SARDALLAAAA', 'SARDALLA', '2025-05-17 00:52:54'),
(15, 'aero@gmail.com', '2025-05-17 00:56:25', 'applicant_lname', 65, 'SARDALLAA', 'SARDALLAAAA', '2025-05-17 00:56:25'),
(16, 'aero@gmail.com', '2025-05-17 00:58:31', 'applicant_lname', 65, 'SARDALLA', 'SARDALLAA', '2025-05-17 00:58:31'),
(17, 'aero@gmail.com', '2025-05-17 01:02:34', 'source', 65, 'Billboard', 'Friends/Family/Relatives', '2025-05-17 01:02:34'),
(18, 'aero@gmail.com', '2025-05-17 01:06:49', 'source', 65, 'Friends/Family/Relatives', 'Billboard', '2025-05-17 01:06:49'),
(19, 'aero@gmail.com', '2025-05-17 01:09:49', 'source', 65, 'Website', 'Friends/Family/Relatives', '2025-05-17 01:09:49'),
(20, 'aero@gmail.com', '2025-05-17 01:13:17', 'source', 65, 'Billboard', 'Website', '2025-05-17 01:13:17'),
(21, 'aero@gmail.com', '2025-05-17 01:15:34', 'relation', 65, 'Brother/Sister', 'Parents', '2025-05-17 01:15:34'),
(22, 'aero@gmail.com', '2025-05-17 01:15:52', 'source', 65, 'Website', 'Billboard', '2025-05-17 01:15:52'),
(23, 'aero@gmail.com', '2025-05-17 01:20:23', 'age', 65, '14', '13', '2025-05-17 01:20:23'),
(24, 'aero@gmail.com', '2025-05-17 01:29:03', 'source', 65, 'Billboard', 'Website', '2025-05-17 01:29:03'),
(25, 'aero@gmail.com', '2025-05-19 11:14:19', 'lrn_no', 57, '123', '1234', '2025-05-19 11:14:19'),
(28, 'aero@gmail.com', '2025-05-24 00:28:39', 'current_school', 65, 'FEU DILIMAN 123', 'FEU DILIMAN', '2025-05-24 00:28:39'),
(32, 'aero@gmail.com', '2025-06-05 09:19:25', 'applicant_fname', 57, 'PAUL', 'AFIRST', '2025-06-05 09:19:25'),
(33, 'aero@gmail.com', '2025-06-05 09:19:25', 'exam_result', 57, 'no show', 'passed', '2025-06-05 09:19:25'),
(34, 'aero@gmail.com', '2025-06-05 09:19:33', 'lrn_no', 57, '312312313', '123', '2025-06-05 09:19:33'),
(35, 'aero@gmail.com', '2025-06-05 09:19:57', 'exam_date', 57, 'June 28, 2025', 'June 23, 2025', '2025-06-05 09:19:57'),
(36, 'aero@gmail.com', '2025-06-05 09:19:57', 'start_time', 57, '07:00 AM', '09:00 AM', '2025-06-05 09:19:57'),
(37, 'aero@gmail.com', '2025-06-05 09:19:57', 'end_time', 57, '08:00 AM', '10:00 AM', '2025-06-05 09:19:57'),
(38, 'ishie@gmail.com', '2025-06-05 09:20:41', 'current_school', 65, 'FEU DILIMAN', 'FEU DILIMAN 123', '2025-06-05 09:20:41'),
(39, 'ishie@gmail.com', '2025-06-05 09:20:41', 'exam_date', 65, 'June 23, 2025', 'May 24, 2025', '2025-06-05 09:20:41'),
(40, 'ishie@gmail.com', '2025-06-05 09:20:55', 'exam_status', 65, 'no show', 'done', '2025-06-05 09:20:55'),
(41, 'ishie@gmail.com', '2025-06-05 09:20:55', 'exam_result', 65, 'no show', 'scholarship', '2025-06-05 09:20:55'),
(42, 'ishie@gmail.com', '2025-06-05 09:21:22', 'applicant_mname', 65, 'B.', '', '2025-06-05 09:21:22'),
(43, 'meh@gmail.com', '2025-06-05 10:19:36', 'exam_date', 109, 'June 22, 2025', 'July 08, 2025', '2025-06-05 10:19:36'),
(44, 'meh@gmail.com', '2025-06-05 10:51:20', 'exam_result', 109, 'passed', 'pending', '2025-06-05 10:51:20'),
(45, 'meh@gmail.com', '2025-06-05 10:53:21', 'exam_status', 109, 'no show', 'done', '2025-06-05 10:53:21'),
(46, 'meh@gmail.com', '2025-06-05 10:53:21', 'exam_result', 109, 'no show', 'passed', '2025-06-05 10:53:21'),
(47, 'meh@gmail.com', '2025-06-06 05:54:03', 'exam_status', 105, 'no show', 'done', '2025-06-06 05:54:03'),
(48, 'meh@gmail.com', '2025-06-06 05:54:03', 'exam_result', 105, 'no show', 'failed', '2025-06-06 05:54:03'),
(49, 'meh@gmail.com', '2025-06-06 06:15:22', 'exam_status', 105, 'done', 'no show', '2025-06-06 06:15:22'),
(50, 'meh@gmail.com', '2025-06-06 06:20:37', 'exam_status', 105, 'no show', 'done', '2025-06-06 06:20:37'),
(51, 'meh@gmail.com', '2025-06-06 06:20:37', 'exam_result', 105, 'no show', 'pending', '2025-06-06 06:20:37'),
(52, 'meh@gmail.com', '2025-06-06 06:23:25', 'exam_status', 105, 'done', 'no show', '2025-06-06 06:23:25'),
(53, 'meh@gmail.com', '2025-06-06 06:25:19', 'exam_status', 105, 'no show', 'done', '2025-06-06 06:25:19'),
(54, 'meh@gmail.com', '2025-06-06 06:25:19', 'exam_result', 105, 'no show', 'pending', '2025-06-06 06:25:19'),
(55, 'meh@gmail.com', '2025-06-06 06:26:15', 'exam_status', 105, 'done', 'no show', '2025-06-06 06:26:15'),
(56, 'meh@gmail.com', '2025-06-06 06:26:30', 'exam_status', 105, 'no show', 'done', '2025-06-06 06:26:30'),
(57, 'meh@gmail.com', '2025-06-06 06:26:30', 'exam_result', 105, 'no show', 'pending', '2025-06-06 06:26:30'),
(58, 'meh@gmail.com', '2025-06-06 06:41:41', 'exam_result', 105, 'passed', 'no_show', '2025-06-06 06:41:41'),
(59, 'meh@gmail.com', '2025-06-06 06:42:16', 'exam_status', 105, 'done', 'no show', '2025-06-06 06:42:16'),
(60, 'meh@gmail.com', '2025-06-06 06:42:16', 'exam_result', 105, 'passed', 'no_show', '2025-06-06 06:42:16'),
(61, 'meh@gmail.com', '2025-06-06 06:44:26', 'exam_result', 105, 'interview', 'passed', '2025-06-06 06:44:26'),
(62, 'meh@gmail.com', '2025-06-06 07:28:48', 'exam_date', 105, 'June 18, 2025', 'July 23, 2025', '2025-06-06 07:28:48'),
(63, 'meh@gmail.com', '2025-06-06 07:28:48', 'start_time', 105, '01:00 PM', '06:00 AM', '2025-06-06 07:28:48'),
(64, 'meh@gmail.com', '2025-06-06 07:28:48', 'end_time', 105, '04:00 PM', '08:00 AM', '2025-06-06 07:28:48'),
(65, 'meh@gmail.com', '2025-06-06 07:55:06', 'exam_date', 109, 'June 28, 2025', 'June 06, 2025', '2025-06-06 07:55:06'),
(66, 'meh@gmail.com', '2025-06-06 07:56:12', 'exam_date', 109, 'July 08, 2025', 'June 28, 2025', '2025-06-06 07:56:12'),
(67, 'meh@gmail.com', '2025-06-06 07:56:12', 'start_time', 109, '08:00 AM', '07:00 AM', '2025-06-06 07:56:12'),
(68, 'meh@gmail.com', '2025-06-06 07:56:12', 'end_time', 109, '09:00 AM', '08:00 AM', '2025-06-06 07:56:12'),
(69, 'meh@gmail.com', '2025-06-06 08:19:48', 'exam_date', 109, 'June 18, 2025', 'July 08, 2025', '2025-06-06 08:19:48'),
(70, 'meh@gmail.com', '2025-06-06 08:19:48', 'start_time', 109, '09:00 AM', '08:00 AM', '2025-06-06 08:19:48'),
(71, 'meh@gmail.com', '2025-06-06 08:19:48', 'end_time', 109, '10:00 AM', '09:00 AM', '2025-06-06 08:19:48'),
(72, 'meh@gmail.com', '2025-06-06 08:26:12', 'exam_date', 109, 'June 22, 2025', 'June 18, 2025', '2025-06-06 08:26:12'),
(73, 'meh@gmail.com', '2025-06-06 08:26:12', 'start_time', 109, '08:00 AM', '09:00 AM', '2025-06-06 08:26:12'),
(74, 'meh@gmail.com', '2025-06-06 08:26:12', 'end_time', 109, '09:00 AM', '10:00 AM', '2025-06-06 08:26:12'),
(75, 'meh@gmail.com', '2025-06-06 08:27:33', 'exam_date', 109, 'June 28, 2025', 'June 22, 2025', '2025-06-06 08:27:33'),
(76, 'meh@gmail.com', '2025-06-06 08:27:33', 'start_time', 109, '07:00 AM', '08:00 AM', '2025-06-06 08:27:33'),
(77, 'meh@gmail.com', '2025-06-06 08:27:33', 'end_time', 109, '08:00 AM', '09:00 AM', '2025-06-06 08:27:33'),
(78, 'meh@gmail.com', '2025-06-06 08:28:18', 'exam_date', 109, 'June 18, 2025', 'June 28, 2025', '2025-06-06 08:28:18'),
(79, 'meh@gmail.com', '2025-06-06 08:28:18', 'start_time', 109, '09:00 AM', '07:00 AM', '2025-06-06 08:28:18'),
(80, 'meh@gmail.com', '2025-06-06 08:28:18', 'end_time', 109, '10:00 AM', '08:00 AM', '2025-06-06 08:28:18'),
(81, 'meh@gmail.com', '2025-06-06 08:29:38', 'exam_date', 109, 'July 08, 2025', 'June 18, 2025', '2025-06-06 08:29:38'),
(82, 'meh@gmail.com', '2025-06-06 08:29:38', 'start_time', 109, '08:00 AM', '09:00 AM', '2025-06-06 08:29:38'),
(83, 'meh@gmail.com', '2025-06-06 08:29:38', 'end_time', 109, '09:00 AM', '10:00 AM', '2025-06-06 08:29:38'),
(84, 'meh@gmail.com', '2025-06-06 08:41:08', 'exam_date', 109, 'June 28, 2025', 'July 08, 2025', '2025-06-06 08:41:08'),
(85, 'meh@gmail.com', '2025-06-06 08:41:08', 'start_time', 109, '07:00 AM', '08:00 AM', '2025-06-06 08:41:08'),
(86, 'meh@gmail.com', '2025-06-06 08:41:08', 'end_time', 109, '08:00 AM', '09:00 AM', '2025-06-06 08:41:08'),
(87, 'meh@gmail.com', '2025-06-06 08:42:17', 'exam_date', 109, 'July 08, 2025', 'June 28, 2025', '2025-06-06 08:42:17'),
(88, 'meh@gmail.com', '2025-06-06 08:42:17', 'start_time', 109, '08:00 AM', '07:00 AM', '2025-06-06 08:42:17'),
(89, 'meh@gmail.com', '2025-06-06 08:42:17', 'end_time', 109, '09:00 AM', '08:00 AM', '2025-06-06 08:42:17'),
(90, 'meh@gmail.com', '2025-06-06 08:43:27', 'exam_date', 109, 'June 18, 2025', 'July 08, 2025', '2025-06-06 08:43:27'),
(91, 'meh@gmail.com', '2025-06-06 08:43:27', 'start_time', 109, '07:00 AM', '08:00 AM', '2025-06-06 08:43:27'),
(92, 'meh@gmail.com', '2025-06-06 08:43:27', 'end_time', 109, '08:00 AM', '09:00 AM', '2025-06-06 08:43:27'),
(93, 'meh@gmail.com', '2025-06-06 08:46:22', 'exam_date', 109, 'June 06, 2025', 'June 18, 2025', '2025-06-06 08:46:22'),
(94, 'meh@gmail.com', '2025-06-06 08:51:24', 'exam_status', 109, 'done', NULL, '2025-06-06 08:51:24'),
(95, 'meh@gmail.com', '2025-06-06 08:56:16', 'exam_status', 109, 'no show', 'done', '2025-06-06 08:56:16'),
(96, 'meh@gmail.com', '2025-06-06 08:56:16', 'exam_result', 109, 'no show', 'pending', '2025-06-06 08:56:16'),
(97, 'meh@gmail.com', '2025-06-06 08:58:08', 'exam_status', 109, 'done', 'no show', '2025-06-06 08:58:08'),
(98, 'meh@gmail.com', '2025-06-06 09:00:07', 'exam_status', 109, 'no show', 'done', '2025-06-06 09:00:07'),
(99, 'meh@gmail.com', '2025-06-06 09:00:07', 'exam_result', 109, 'no show', 'pending', '2025-06-06 09:00:07'),
(100, 'meh@gmail.com', '2025-06-06 09:01:33', 'exam_status', 109, 'done', 'no show', '2025-06-06 09:01:33'),
(101, 'meh@gmail.com', '2025-06-06 09:03:20', 'exam_result', 109, 'passed', 'pending', '2025-06-06 09:03:20'),
(102, 'meh@gmail.com', '2025-06-06 09:04:59', 'exam_result', 109, 'failed', 'passed', '2025-06-06 09:04:59'),
(103, 'meh@gmail.com', '2025-06-06 09:06:47', 'exam_result', 109, 'scholarship', 'failed', '2025-06-06 09:06:47'),
(104, 'meh@gmail.com', '2025-06-06 09:08:29', 'exam_result', 109, 'interview', 'scholarship', '2025-06-06 09:08:29');

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
(37, 71, 'J. ANTHONY', 'BAUTISTA.', 'SAN PASCUAL', '09672980038', 'jayanthonysp@gmail.com', 'CALABARZON', 'Rizal', 'Rodriguez', 'San Rafael', 'Blk 12 Lot 2 San Antonio St.', '0618', 22, 'Male', 'Doctor', 'ERNESTO', NULL, 'BARCENAS III', '09876543210', 'jayanthonysp@gmail.com', 'Grandparents', 'FEU DILIMAN', 'Quezon, Quezon', 'Public', 'Senior High School', 'GRADE 11', NULL, '097876548872', 'STEM Engineering', 'Social Media (Facebook, TikTok, Instagram, Youtube, etc)', NULL, NULL),
(57, 93, 'PAUL', '', 'ALAST', '09999999999', 'eiryksardalla696@gmail.com', 'NCR', 'Metro Manila (NCR)', 'Quezon City', 'Pasong Tamo', 'fds232', '1231', 13, 'Male', 'filipino', 'GFIRST', '', 'GLAST', '09999999999', 'eiryksardalla696@gmail.com', 'Parents', 'TESTING', 'Quezon City, Metro Manila', 'Public', 'Junior High School', 'GRADE 7', NULL, '312312313', NULL, 'Social Media (Facebook, TikTok, Instagram, Youtube, etc)', NULL, '2025-06-05 09:19:33'),
(65, 103, 'EIRYK', 'B.', 'SARDALLA', '09999999999', 'kyrie.sardalla@gmail.com', 'NCR', 'Metro Manila (NCR)', 'Quezon City', 'Batasan Hills', 'fds232', '1231', 14, 'Male', 'filipino', 'SHYLLA MAE', '', 'LOVELOVE', '09999999999', 'eiryk.sardalla30@gmail.com', 'Brother/Sister', 'FEU DILIMAN', 'Quezon City, Metro Manila', 'Private Non-Sectarian', 'Senior High School', 'GRADE 11', NULL, '21412123', 'STEM Information Technology', 'Billboard', '2025-05-16 23:18:57', '2025-06-05 09:21:22'),
(68, 108, 'EYREK', NULL, 'SARDINAS', '09999999999', 'kyrie.sardalla@gmail.com', 'NCR', 'Metro Manila (NCR)', 'Quezon City', 'Batasan Hills', 'fds232', '1231', 15, 'Male', 'filipino', 'SHYLLA', NULL, 'GANDA', '09999999999', 'kyrie.sardalla@gmail.com', 'Parents', 'FEU DILIMAN', 'Quezon City, Metro Manila', 'Private Non-Sectarian', 'Senior High School', 'GRADE 11', NULL, '123', 'GAS', 'Billboard', '2025-05-19 15:34:35', '2025-05-19 15:34:35'),
(103, 137, 'BACON', 'M.', 'BACONATOR', '09444444444', 'gabebarcenas02@gmail.com', 'NCR', 'Metro Manila (NCR)', 'Quezon City', 'Bagumbayan', '16Y', '84933', 18, 'Female', 'Amercican', 'CORNY', 'M.', 'CORN', '09333333333', 'gabebarcenas08@gmail.com', 'Uncle/Aunt', 'UP', 'Quezon, Bukidnon', 'Private Non-Sectarian', 'Senior High School', 'GRADE 11', NULL, '202210189', 'GAS', 'Social Media (Facebook, TikTok, Instagram, Youtube, etc)', '2025-06-02 06:14:55', '2025-06-02 06:14:55'),
(105, 138, 'JOSHUA', '', 'PANGILINAN', '09985504802', 'lorraine@gmail.com', 'CALABARZON', 'Rizal', 'Rodriguez', 'San Jose', '391 G.', '1860', 17, 'Female', 'Filipino', 'SARAH', '', 'PANGILINAN', '09985504802', 'paulaeronguillermo@gmail.com', 'Parents', 'MARY THE QUEEN SCHOOL', 'Rodriguez, Rizal', 'Public', 'Senior High School', 'GRADE 11', NULL, '21123', 'STEM Information Technology', 'Social Media (Facebook, TikTok, Instagram, Youtube, etc)', '2025-06-02 14:02:16', '2025-06-02 14:06:01'),
(108, 140, 'AILENE', 'C.', 'PONGPONG', '09985504802', 'trojan1403@gmail.com', 'NCR', 'Metro Manila (NCR)', 'Quezon City', 'Bagumbuhay', 'Blk 12 Lot 2 San Antonio St.', '1442', 22, 'Male', 'FILIPINO', 'MACKY', 'C.', 'PONGPONG', '09985504802', 'mackypongpong@yahoo.com', 'Parents', 'QUEZON CITY ACADEMY', 'Quezon City, Metro Manila', 'Private Sectarian', 'Senior High School', 'GRADE 11', NULL, NULL, 'ABM Business Management', 'Billboard', '2025-06-05 03:33:54', '2025-06-05 03:33:54'),
(109, 142, 'PAUL AERON', 'A.', 'GUILLERMO', '09985504802', 'paulaeronguillermo2@gmail.com', 'CALABARZON', 'Rizal', 'Rodriguez', 'San Jose', '393 G. Bautista Street', '1860', 4, 'Male', 'FILIPINO', 'ARNOLD', 'N.', 'GUILLERMO', '09985504802', 'paulaeronguillermo2@gmail.com', 'Parents', 'FEU RODRIGUEZ ROOSEVELT', 'Rodriguez, Rizal', 'Private Non-Sectarian', 'Junior High School', 'GRADE 7', NULL, NULL, NULL, 'Billboard', '2025-06-05 09:32:46', '2025-06-05 09:32:46'),
(110, 141, 'AMIEL', NULL, 'BICALDO', '09985504802', 'amielryanbicaldo@gmail.com', 'NCR', 'Metro Manila (NCR)', 'Quezon City', 'Mariblo', '12 Mapayapa', '4232', 4, 'Male', 'FILIPINO', 'LOUIS', NULL, 'RABARA', '09985504802', 'louisrabara@gmail.com', 'Brother/Sister', 'FEU DILIMAN', 'Quezon City, Metro Manila', 'Private Non-Sectarian', 'Grade School', 'KINDER', '2020-09-17', NULL, NULL, 'Events', '2025-06-05 09:46:41', '2025-06-05 09:46:41');

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
(49, '2025_05_19_190953_add_timestamps_to_applicants_table', 35),
(50, '2025_05_19_230704_add_payment_for_to_payment_table', 36),
(51, '2025_05_19_231812_add_venue_to_applicant_schedules', 36),
(52, '2025_05_22_195128_add_is_reschedule_active_to_applicants_table', 37),
(53, '2025_06_06_203742_create_personal_access_tokens_table', 38);

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
(52, 93, 'PAUL', '', 'ALAST', 'eiryksardalla696@gmail.com', '09999999999', NULL, NULL, NULL, 'GRADE 7', 'Metrobank', 'payment_proofs/proof_681f2b7d717509.59037391.png', 'approved', NULL, NULL, '2025-05-10', '18:33:33', '2025-05-10 02:33:33', '2025-05-10 02:33:41', NULL, 'first-time'),
(59, 103, 'EIRYK', 'B.', 'SARDALLA', 'kyrie.sardalla@gmail.com', '09999999999', 'SHYLLA MAE', '', 'LOVELOVE', 'GRADE 11', 'BDO', 'payment_proofs/proof_68283879411d15.28943068.png', 'approved', NULL, NULL, '2025-05-17', '15:19:21', '2025-05-16 23:19:21', '2025-05-16 23:19:53', NULL, 'first-time'),
(62, 108, 'EYREK', '', 'SARDINAS', 'kyrie.sardalla@gmail.com', '09999999999', 'SHYLLA', '', 'GANDA', 'GRADE 11', 'BDO', 'payment_proofs/proof_682b4f92e48a86.24444093.png', 'approved', NULL, NULL, '2025-05-19', '23:34:42', '2025-05-19 15:34:42', '2025-05-19 15:34:57', NULL, 'first-time'),
(63, 108, 'EYREK', '', 'SARDINAS', 'kyrie.sardalla@gmail.com', '09999999999', 'SHYLLA', '', 'GANDA', 'GRADE 11', 'BDO', 'payment_proofs/proof_682b501b04a405.38217348.png', 'pending', NULL, NULL, '2025-05-19', '23:36:59', '2025-05-19 15:36:59', '2025-05-19 15:36:59', NULL, 'resched'),
(119, 137, 'BACON', 'M.', 'BACONATOR', 'gabebarcenas02@gmail.com', '09444444444', 'CORNY', 'M.', 'CORN', 'GRADE 11', 'BDO', 'payment_proofs/proof_683d417ab03241.40641969.png', 'approved', 'Ok na yan', '34321431', '2025-06-02', '14:15:23', '2025-06-02 06:15:23', '2025-06-02 06:16:27', 'payment_receipts/rD17uAjWSIMZDZbdifyiXgOJMrLfev00cnDT8bkm.jpg', 'first-time'),
(120, 137, 'BACON', 'M.', 'BACONATOR', 'gabebarcenas02@gmail.com', '09444444444', 'CORNY', 'M.', 'CORN', 'GRADE 11', 'BDO', 'payment_proofs/proof_683d47bdeebe49.33158009.jpg', 'approved', 'ok na!!', '34332342', '2025-06-02', '14:42:05', '2025-06-02 06:42:05', '2025-06-02 06:42:31', 'payment_receipts/TJWLxxtQqRqMViMfhmZz3ni1ITD84lY7M7qf1rmH.png', 'resched'),
(123, 138, 'JOSHUA', '', 'PANGILINAN', 'lorraine@gmail.com', '09985504802', 'SARAH', '', 'PANGILINAN', 'GRADE 11', 'LandBank', 'payment_proofs/proof_683daef138ead9.38717588.png', 'approved', 'dasdsad', '121212', '2025-06-02', '22:02:25', '2025-06-02 14:02:25', '2025-06-02 14:02:47', 'payment_receipts/yI0Pip8yVg0UXYRpwicepVIngNiZv7SYUCWksUBI.jpg', 'first-time'),
(124, 138, 'JOSHUA', '', 'PANGILINAN', 'lorraine@gmail.com', '09985504802', 'SARAH', '', 'PANGILINAN', 'GRADE 11', 'LandBank', 'payment_proofs/proof_683dafdd090555.83313600.png', 'approved', 'sada', '22', '2025-06-02', '22:06:21', '2025-06-02 14:06:21', '2025-06-02 14:06:34', 'payment_receipts/Jf6xUW2ppzBFtc1pxDxx6RbMl6zFXWzBOkhctdeI.png', 'resched'),
(127, 140, 'AILENE', 'C.', 'PONGPONG', 'trojan1403@gmail.com', '09985504802', 'MACKY', 'C.', 'PONGPONG', 'GRADE 11', 'LandBank', 'payment_proofs/proof_684117663c2067.64195051.jpg', 'approved', 'Good Job!', '8292', '2025-06-05', '12:04:54', '2025-06-05 04:04:54', '2025-06-05 04:05:34', 'payment_receipts/yaW41IImoZi2b1vze2I72wQEkMbBYAlcUmA3FfD2.jpg', 'first-time'),
(128, 142, 'PAUL AERON', 'A.', 'GUILLERMO', 'paulaeronguillermo2@gmail.com', '09985504802', 'ARNOLD', 'N.', 'GUILLERMO', 'GRADE 7', 'BDO', 'payment_proofs/proof_68416538555745.40640958.PNG', 'approved', 'Nice one', '12345678', '2025-06-05', '17:36:56', '2025-06-05 09:36:56', '2025-06-05 09:47:39', 'payment_receipts/GQRA8jKYppsa3113pibA0RhUhiI2jOsAQqgNQorj.png', 'first-time'),
(129, 141, 'AMIEL', '', 'BICALDO', 'amielryanbicaldo@gmail.com', '09985504802', 'LOUIS', '', 'RABARA', 'KINDER', 'BDO', 'payment_proofs/proof_6841678dc43298.12112819.jpg', 'approved', 'nice', '3232', '2025-06-05', '17:46:53', '2025-06-05 09:46:53', '2025-06-05 10:16:48', 'payment_receipts/wLJO4Wk6wRUimBgbyozS87Lz9X501tpfTuKiXWZ0.jpg', 'first-time'),
(130, 142, 'PAUL AERON', 'A.', 'GUILLERMO', 'paulaeronguillermo2@gmail.com', '09985504802', 'ARNOLD', 'N.', 'GUILLERMO', 'GRADE 7', 'Robinsons_Bank', 'payment_proofs/proof_6841931aaf2041.67901207.jpg', 'approved', 'Joshua', '321307', '2025-06-05', '20:52:42', '2025-06-05 12:52:42', '2025-06-06 07:31:06', 'payment_receipts/SUs1SJD6e23h3Tm0GXGZCzDppTSvZrKwRA0D1u69.jpg', 'resched');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(3, 'App\\Models\\Accounts', 148, 'mobile-token', '506afeda894e0baec66d36b67ed987a602713197af33d7dbe4d33bbe8e993b49', '[\"*\"]', '2025-06-06 14:58:35', NULL, '2025-06-06 14:58:23', '2025-06-06 14:58:35');

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
('bROqCDSXBPaeDLXYSddxgbBA87A5NNuyYRMVMvjj', NULL, '192.168.100.141', 'PostmanRuntime/7.44.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNm9ZdXZvdjkwdE5vcjRHcDY0cVB1VXoyMERhdnJWR3VtWFh5ZkduMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xOTIuMTY4LjEwMC4xNDE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTg6InNob3dfY29sbGVnZV9tb2RhbCI7YjoxO30=', 1749218960),
('Ci3vNK4WrerBIJy1M836xCWy5HNbgt3xOxbHKhFx', 38, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiWHZ2cVlyRFZLRDB5NllXUGVSUm11RkxMMHVWZTJ3bFBHVWhIZGsweSI7czoxODoic2hvd19jb2xsZWdlX21vZGFsIjtiOjE7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pc3Npb24vZWRpdC1hcHBsaWNhbnQvMTQyIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzg7czo0OiJuYW1lIjtzOjE3OiJQQVVMIEQuIEdVSUxMRVJNTyI7czo1OiJlbWFpbCI7czoxMzoibWVoQGdtYWlsLmNvbSI7czo0OiJyb2xlIjtzOjEzOiJhZG1pbmlzdHJhdG9yIjt9', 1749202244),
('iFuSxvdKVqH9kqBRKvAYmXza9kUD6NcAkrrLnPIt', NULL, '192.168.100.141', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiRmhkd3F5SUpOb2FvYVpubjhNa0hxN1NMc3pnRVZDQ0RKajlPdUpUcCI7czoxODoic2hvd19jb2xsZWdlX21vZGFsIjtiOjE7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xOTIuMTY4LjEwMC4xNDE6ODAwMC9sb2dpbiI7fX0=', 1749218418),
('kr7xd4UKBuYtrnJAG6Sa3ZHBbb0cxoIFLmT2Ly2k', 38, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiRGEwWlVLbGpmSDlLOVBLM2V0dWgzQVk5THVvdkR0cWcwb054TnpGSyI7czoxODoic2hvd19jb2xsZWdlX21vZGFsIjtiOjE7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbmlzdHJhdG9yL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM4O3M6NDoibmFtZSI7czoxNzoiUEFVTCBELiBHVUlMTEVSTU8iO3M6NToiZW1haWwiO3M6MTM6Im1laEBnbWFpbC5jb20iO3M6NDoicm9sZSI7czoxMzoiYWRtaW5pc3RyYXRvciI7fQ==', 1749220033),
('Mc3gavxINcyrPP5USBBylRAfdTcN9UwLgzAZqqSF', NULL, '127.0.0.1', 'PostmanRuntime/7.44.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQmoxbjF1cXA4eFdINjkxNjZNajlBWFRwVldwWmVPZTZBWDVHQXFRNyI7czoxODoic2hvd19jb2xsZWdlX21vZGFsIjtiOjE7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749221680),
('XWwNaX5jAAvyQCh67zlHd1mP7BUIaene3bewIIxI', 38, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoidThEbWpyT0ZoajVub0sxbWx5ZVZVVDRvejRTYU9jSHN2cmNZUE1nYiI7czoxODoic2hvd19jb2xsZWdlX21vZGFsIjtiOjE7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM4O3M6NDoibmFtZSI7czoxNzoiUEFVTCBELiBHVUlMTEVSTU8iO3M6NToiZW1haWwiO3M6MTM6Im1laEBnbWFpbC5jb20iO3M6NDoicm9sZSI7czoxMzoiYWRtaW5pc3RyYXRvciI7fQ==', 1749221858),
('YmBOGENDvSZQGEjPy6QVnda75PyWX7cmGHKiQvTb', 146, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiN01QazFWb3ZlckNFVDJOa0Q3d1RuWU5Wbm5FVlZGRlJid3loZUZodiI7czoxODoic2hvd19jb2xsZWdlX21vZGFsIjtiOjE7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdGVwLTUiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNDY7czo0OiJuYW1lIjtzOjE5OiJBUk5PTEQgTi4gR1VJTExFUk1PIjtzOjU6ImVtYWlsIjtzOjI5OiJwYXVsYWVyb25ndWlsbGVybW8yQGdtYWlsLmNvbSI7czo0OiJyb2xlIjtzOjk6ImFwcGxpY2FudCI7fQ==', 1749200844);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `applicant_schedules`
--
ALTER TABLE `applicant_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `form_change_logs`
--
ALTER TABLE `form_change_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `form_submissions`
--
ALTER TABLE `form_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `signup_otps`
--
ALTER TABLE `signup_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

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
