-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 05:36 AM
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
(38, 'ADMIN . ADMIN', 'admin@gmail.com', '$2y$12$T1K02sY482e3/M8x02PF9eH0lW90nT//LeSkpNztNgWlC4S9v.FLu', 'administrator', NULL, '2025-06-17 02:42:39'),
(54, 'ACCOUNTANT . ACCOUNTANT', 'accountant@gmail.com', '$2y$12$gyjTmD66YVOl14d6RKoO0.I91hFE5trOw2ZIv6CzbU2u2s9Pn42TS', 'accounting', NULL, NULL),
(61, 'AERO  AERO', 'aero@gmail.com', '$2y$12$cT4wNzWqdd82/AO88DEylO39n36rkm/AsaZmVnyJrA11jbGUo/uL6', 'admission', NULL, NULL),
(167, 'USER  USER', 'innovision2026@gmail.com', '$2y$12$vvZa16nFY99lUmqq6h.x6O48ifzasto57X8fmggPX1r4M.eGq4dAW', 'applicant', '2025-06-17 02:54:41', '2025-06-17 02:55:43');

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
(164, 167, 'USER', '', 'USER', 'USER', '', 'USER', 'USER', 'KINDER', NULL, 1, NULL, '2025-06-17 02:54:41', '2025-06-17 02:54:41', 0);

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

-- --------------------------------------------------------

--
-- Table structure for table `exam_schedules`
--

CREATE TABLE `exam_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `venue` varchar(255) NOT NULL,
  `max_participants` int(11) NOT NULL,
  `educational_level` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(53, '2025_06_05_153337_create_personal_access_tokens_table', 38),
(54, '2025_06_16_171413_add_venue_to_exam_schedules', 39);

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
(1, 'App\\Models\\Accounts', 106, 'mobile-token', '113480eebb7241caa7439e7bc30b9cf7fa8714b27425bd133c9d602578903d3f', '[\"*\"]', NULL, NULL, '2025-06-06 18:01:40', '2025-06-06 18:01:40'),
(2, 'App\\Models\\Accounts', 106, 'mobile-token', 'ae750f9d0bc1b2196d474aa2e7416d4ef54b2a16e2b876cdb7cd1f5d1b842d0d', '[\"*\"]', NULL, NULL, '2025-06-06 18:02:41', '2025-06-06 18:02:41'),
(3, 'App\\Models\\Accounts', 106, 'mobile-token', '067099ade558280fa27282ab6e0005d55a8bfa311cc1d8a13a6a8099cb8c8303', '[\"*\"]', NULL, NULL, '2025-06-06 18:13:23', '2025-06-06 18:13:23'),
(4, 'App\\Models\\Accounts', 106, 'mobile-token', 'fc00f19803df630894ad7391914c711e9413d2064ceeb0c0bad0baecc177d06b', '[\"*\"]', NULL, NULL, '2025-06-06 18:23:55', '2025-06-06 18:23:55'),
(5, 'App\\Models\\Accounts', 106, 'mobile-token', 'f3737912bc606288cea5fe7e69491da734221a1f31a1d305982446e473af8633', '[\"*\"]', NULL, NULL, '2025-06-06 18:26:22', '2025-06-06 18:26:22'),
(6, 'App\\Models\\Accounts', 106, 'mobile-token', '2212fa66e13f324e4350a08a90b8281c64502729c006be8609d35c6fb3ace135', '[\"*\"]', NULL, NULL, '2025-06-06 18:26:31', '2025-06-06 18:26:31'),
(7, 'App\\Models\\Accounts', 106, 'mobile-token', '8fffb331a7521656bb74db21e7ec93fa692bd223d0b727bbc010140e6aa1a635', '[\"*\"]', NULL, NULL, '2025-06-06 18:32:49', '2025-06-06 18:32:49'),
(8, 'App\\Models\\Accounts', 106, 'mobile-token', '29f95e2db8f8bc4b5b038c1198becea09cf5592275e9e50233276a45d96fcd11', '[\"*\"]', NULL, NULL, '2025-06-06 18:36:01', '2025-06-06 18:36:01'),
(9, 'App\\Models\\Accounts', 106, 'mobile-token', '2281c889b17cb6fec3cbb7ee1f218a461ce8e30e3430e06892399aac5670b36f', '[\"*\"]', NULL, NULL, '2025-06-07 01:46:59', '2025-06-07 01:46:59'),
(10, 'App\\Models\\Accounts', 141, 'mobile-token', '93ec41a8d6c253d04fcc130b73d33e318808973da1268b533a608c28bad1bb87', '[\"*\"]', NULL, NULL, '2025-06-07 02:20:48', '2025-06-07 02:20:48'),
(11, 'App\\Models\\Accounts', 106, 'mobile-token', '04ffb0ff209dbb7c21a879203767a47795a526e7d07cb3a3ee34397d0c54cb08', '[\"*\"]', NULL, NULL, '2025-06-07 03:47:32', '2025-06-07 03:47:32'),
(12, 'App\\Models\\Accounts', 106, 'mobile-token', '3e911aa3db130b3d70cb13cdd46a6f24f5480748743ed334df7588fbcf48c0c3', '[\"*\"]', NULL, NULL, '2025-06-07 03:56:23', '2025-06-07 03:56:23'),
(13, 'App\\Models\\Accounts', 141, 'mobile-token', '11578f2b17d09e815a526858c4a8df8b57651c93996b1265dc41516d11a73a2f', '[\"*\"]', NULL, NULL, '2025-06-07 04:17:41', '2025-06-07 04:17:41'),
(14, 'App\\Models\\Accounts', 142, 'mobile-token', '244a000fb27f353e267ad9da1125b190b7634848501396b5b900868b0fbf43dd', '[\"*\"]', NULL, NULL, '2025-06-07 04:22:11', '2025-06-07 04:22:11'),
(15, 'App\\Models\\Accounts', 143, 'mobile-token', '984be6c8f67edcc9edf23a8b8af3b7abb4f5004e5b32237d0508dd47ffa93b6c', '[\"*\"]', NULL, NULL, '2025-06-07 04:31:19', '2025-06-07 04:31:19'),
(16, 'App\\Models\\Accounts', 106, 'mobile-token', 'b8083a9b669cc2beee9f4fc9ce6da278fcdfb2d979fdcc0b1c5992dd47115bf8', '[\"*\"]', NULL, NULL, '2025-06-07 10:40:58', '2025-06-07 10:40:58'),
(17, 'App\\Models\\Accounts', 106, 'mobile-token', 'bacfacbaddada9c448b5f6a99c6b9c2f6e98cd24f5b41039c250926d87095c54', '[\"*\"]', NULL, NULL, '2025-06-07 11:41:36', '2025-06-07 11:41:36'),
(18, 'App\\Models\\Accounts', 106, 'mobile-token', '6d52fbb6021d3ee5b7bdd51da42e0655a910f1a6f1f5a4eba617d40de7617523', '[\"*\"]', NULL, NULL, '2025-06-08 08:31:59', '2025-06-08 08:31:59'),
(19, 'App\\Models\\Accounts', 106, 'mobile-token', '8d2754f257dad5f77479279f3d20ab09091859ede6dd225b915e74574e12e9d4', '[\"*\"]', NULL, NULL, '2025-06-08 14:27:19', '2025-06-08 14:27:19'),
(20, 'App\\Models\\Accounts', 106, 'mobile-token', '1679a640701c16186ef398b538755c15f3812c3d2a3ebdbb066b5b3f541cfc4b', '[\"*\"]', NULL, NULL, '2025-06-09 08:49:32', '2025-06-09 08:49:32'),
(21, 'App\\Models\\Accounts', 106, 'mobile-token', 'fa5efc24cacf0e2e362c7ea4232f117504cac4ee91beae2e92430cb6fcc1e7a4', '[\"*\"]', NULL, NULL, '2025-06-09 11:35:58', '2025-06-09 11:35:58'),
(22, 'App\\Models\\Accounts', 143, 'mobile-token', 'f8c1dd648d13102b21fdd28d57cb8873e672a988a2a31fdca3a606f73ca59763', '[\"*\"]', NULL, NULL, '2025-06-09 12:55:46', '2025-06-09 12:55:46'),
(23, 'App\\Models\\Accounts', 106, 'mobile-token', '0c929ae473e679ab75f4be0d087b3fd8b7c7673f60d660f67ac10608e06218fa', '[\"*\"]', NULL, NULL, '2025-06-09 12:59:12', '2025-06-09 12:59:12'),
(24, 'App\\Models\\Accounts', 106, 'mobile-token', 'f42b0b16666101439db8f763a1feeee19bfd11fff30e1e3e0b8e22e26aaa6a9e', '[\"*\"]', NULL, NULL, '2025-06-09 13:03:09', '2025-06-09 13:03:09'),
(25, 'App\\Models\\Accounts', 106, 'mobile-token', '6c773a6a7a3bfff5673f717942915002a1666abdeee8765caae7cc234dbb88c4', '[\"*\"]', NULL, NULL, '2025-06-09 13:12:25', '2025-06-09 13:12:25'),
(26, 'App\\Models\\Accounts', 106, 'mobile-token', '5f49cfce797eac6f0d6577e926d631464e55759902285b44e259f396a9398409', '[\"*\"]', NULL, NULL, '2025-06-09 13:15:36', '2025-06-09 13:15:36'),
(27, 'App\\Models\\Accounts', 106, 'mobile-token', 'd2ce8573559f1eed012e1e92f154e754dfa1bf48b9566e3633d98b507e33eb77', '[\"*\"]', NULL, NULL, '2025-06-09 13:30:55', '2025-06-09 13:30:55'),
(28, 'App\\Models\\Accounts', 106, 'mobile-token', 'b1b548527fd2edd020591b87806df7d4a205dc3eafa40ad8615808b6df4ce9ac', '[\"*\"]', NULL, NULL, '2025-06-09 13:31:23', '2025-06-09 13:31:23'),
(29, 'App\\Models\\Accounts', 106, 'mobile-token', '467e5efa42faa9309996286a4f2317d922cb001340c0696c678138bb1b0a2e56', '[\"*\"]', NULL, NULL, '2025-06-09 13:32:41', '2025-06-09 13:32:41'),
(30, 'App\\Models\\Accounts', 106, 'mobile-token', 'eb9b052dd091f7725a4b45a330eee28324bf56de78d8c34df2da5eccb2e82c16', '[\"*\"]', NULL, NULL, '2025-06-09 13:33:43', '2025-06-09 13:33:43'),
(31, 'App\\Models\\Accounts', 106, 'mobile-token', '1fc1d6e47b3b71cff29965441fefe37571a87108e5f246dfbc7d140123401068', '[\"*\"]', NULL, NULL, '2025-06-10 06:01:06', '2025-06-10 06:01:06'),
(32, 'App\\Models\\Accounts', 106, 'mobile-token', 'fac5970f04266974555b93ab81401d7b092afd5ef24c1e073868de4951c0fe99', '[\"*\"]', NULL, NULL, '2025-06-10 06:35:35', '2025-06-10 06:35:35'),
(33, 'App\\Models\\Accounts', 111, 'mobile-token', 'd2646fc05bc14d343fa7d7dd6b41ffcfabfd34711f7f641d6ff23ed83254763c', '[\"*\"]', NULL, NULL, '2025-06-10 06:35:44', '2025-06-10 06:35:44'),
(34, 'App\\Models\\Accounts', 144, 'mobile-token', '2225929aa8e60765b71ee966bc49686071615aea455a4f153beb3ce8547baee2', '[\"*\"]', NULL, NULL, '2025-06-10 06:38:35', '2025-06-10 06:38:35'),
(35, 'App\\Models\\Accounts', 144, 'mobile-token', 'bda625daebd66f28598eb87b7d10ebeec3a72b416cf9fb43bb4cc68b773c8b42', '[\"*\"]', NULL, NULL, '2025-06-10 07:02:56', '2025-06-10 07:02:56'),
(36, 'App\\Models\\Accounts', 144, 'mobile-token', '212050bea0f8bd25a74199dae9d609a71bbfbc70a95185138bd5640838d57015', '[\"*\"]', NULL, NULL, '2025-06-10 07:14:47', '2025-06-10 07:14:47'),
(37, 'App\\Models\\Accounts', 144, 'mobile-token', '7d90dbf81ce48764743770893582dfead4064a1378230d864db0009a0b53b236', '[\"*\"]', NULL, NULL, '2025-06-10 07:17:09', '2025-06-10 07:17:09'),
(38, 'App\\Models\\Accounts', 144, 'mobile-token', 'ca49079cdb74b6e8d9c150ab0bc8f3ed6617b20cd07990d871d6df97ebb8084d', '[\"*\"]', NULL, NULL, '2025-06-10 07:18:27', '2025-06-10 07:18:27'),
(39, 'App\\Models\\Accounts', 144, 'mobile-token', 'ed4f9f89314b57c9b1e35607901043ad8cee4c427ea131e8e7ffab5e8e306701', '[\"*\"]', NULL, NULL, '2025-06-10 07:18:30', '2025-06-10 07:18:30'),
(40, 'App\\Models\\Accounts', 144, 'mobile-token', '72f31441f29ad87aa5e5aecfbeb025050e60d82655aee765a2e40642cebdf052', '[\"*\"]', NULL, NULL, '2025-06-10 07:28:15', '2025-06-10 07:28:15'),
(41, 'App\\Models\\Accounts', 144, 'mobile-token', 'ef7b70aa6681c7ab6d73f7d8836de8d9d923c4a1455d9c13d799c5b0dcd87b8b', '[\"*\"]', NULL, NULL, '2025-06-10 07:28:28', '2025-06-10 07:28:28'),
(42, 'App\\Models\\Accounts', 144, 'mobile-token', '3a8f211c4c1afad215745abced165fa30401941034170331b7083b8154179248', '[\"*\"]', NULL, NULL, '2025-06-10 07:39:48', '2025-06-10 07:39:48'),
(43, 'App\\Models\\Accounts', 144, 'mobile-token', '7c252598dee3276167dafe3d3dc304396a7c8e70fb68229b60a60597b760ba7b', '[\"*\"]', NULL, NULL, '2025-06-10 07:44:33', '2025-06-10 07:44:33'),
(44, 'App\\Models\\Accounts', 144, 'mobile-token', 'be3de58fd14adc52f4bc448c0e5927a76f2923a3315202882eaae60348af272c', '[\"*\"]', NULL, NULL, '2025-06-10 07:44:51', '2025-06-10 07:44:51'),
(45, 'App\\Models\\Accounts', 144, 'mobile-token', '4307cbf08bb114c10c588be3f48ae89d0ea37149a5812c2e053dc1c512c93eb3', '[\"*\"]', NULL, NULL, '2025-06-10 08:19:08', '2025-06-10 08:19:08'),
(46, 'App\\Models\\Accounts', 144, 'mobile-token', 'f6e9e37651a89dc4b6aef2e456a81d6f8a5d154b2dc52ac502ef6ff8e5c51b4a', '[\"*\"]', NULL, NULL, '2025-06-10 08:28:07', '2025-06-10 08:28:07'),
(48, 'App\\Models\\Accounts', 144, 'mobile-token', '4590128478c7cce16f889ab02751147d8a743ea5461c6a47edee5b866d599f4b', '[\"*\"]', '2025-06-11 07:02:43', NULL, '2025-06-11 07:02:40', '2025-06-11 07:02:43'),
(49, 'App\\Models\\Accounts', 144, 'mobile-token', '4c035332b065221c06791d4600da001fa9ee63a07582ec50231bfea4d6328bb9', '[\"*\"]', '2025-06-11 07:54:55', NULL, '2025-06-11 07:53:58', '2025-06-11 07:54:55'),
(50, 'App\\Models\\Accounts', 144, 'mobile-token', 'fff65f9e95a59deb57f79af0ce19b2cb0a542a4bf1e679c1003530444d50b014', '[\"*\"]', '2025-06-11 07:55:27', NULL, '2025-06-11 07:55:27', '2025-06-11 07:55:27'),
(51, 'App\\Models\\Accounts', 144, 'mobile-token', '4410feb4f7574c6442482a247b684d55da8c6fdce0049cdbfbb642f43cf7f7aa', '[\"*\"]', '2025-06-11 07:55:54', NULL, '2025-06-11 07:55:54', '2025-06-11 07:55:54'),
(52, 'App\\Models\\Accounts', 144, 'mobile-token', '245939d0583bd18c89dd93338fee54c47cd8e57c072ac67d7b7df3dd7d2e5bcb', '[\"*\"]', '2025-06-11 07:57:04', NULL, '2025-06-11 07:57:04', '2025-06-11 07:57:04'),
(53, 'App\\Models\\Accounts', 144, 'mobile-token', '8d77006a0560e93d11f9ec21b54a015c7f765d46151381230783150669b3c46b', '[\"*\"]', '2025-06-11 08:14:49', NULL, '2025-06-11 08:12:38', '2025-06-11 08:14:49'),
(54, 'App\\Models\\Accounts', 144, 'mobile-token', '28130faf0f9e6569abe7a2f338d3f81c43ffac968bc6d8586c438fa6aff6f6f0', '[\"*\"]', '2025-06-11 08:15:26', NULL, '2025-06-11 08:14:51', '2025-06-11 08:15:26'),
(55, 'App\\Models\\Accounts', 144, 'mobile-token', '2ed967d48be939e8c5019e69a691a268c4012ce919747c64b8870802a815badf', '[\"*\"]', '2025-06-11 08:23:58', NULL, '2025-06-11 08:23:57', '2025-06-11 08:23:58'),
(56, 'App\\Models\\Accounts', 144, 'mobile-token', 'a2d5a500191dc3283574666d69d772a739f6db4fb56c51e842641357dbb7b677', '[\"*\"]', '2025-06-11 08:25:21', NULL, '2025-06-11 08:25:20', '2025-06-11 08:25:21'),
(57, 'App\\Models\\Accounts', 145, 'mobile-token', '1ccdd64497af3a1d16b9f847a0ff56126c68c2b6ac00e01bcf65561656e48705', '[\"*\"]', NULL, NULL, '2025-06-11 08:38:56', '2025-06-11 08:38:56'),
(58, 'App\\Models\\Accounts', 145, 'mobile-token', 'fe413a6d380335080b97c90850fe7e0db06557900afc5c8858cecb03041e5886', '[\"*\"]', '2025-06-11 09:11:39', NULL, '2025-06-11 08:44:14', '2025-06-11 09:11:39'),
(59, 'App\\Models\\Accounts', 146, 'mobile-token', 'be5c1ff111784a6086898bde376fcbd49d5cf37236ae39e8bc5295301178e72a', '[\"*\"]', NULL, NULL, '2025-06-11 09:13:07', '2025-06-11 09:13:07'),
(60, 'App\\Models\\Accounts', 146, 'mobile-token', '9493ad94534e5016200b59286ee9fb0e85dcbe142b6c9f3d4988e0c1ce15a03c', '[\"*\"]', '2025-06-11 09:14:07', NULL, '2025-06-11 09:13:26', '2025-06-11 09:14:07'),
(61, 'App\\Models\\Accounts', 146, 'mobile-token', 'dee416d6b17e9bf29e644b089b582c5895275764762e176f3440afc19db643e3', '[\"*\"]', '2025-06-11 09:48:05', NULL, '2025-06-11 09:38:32', '2025-06-11 09:48:05'),
(62, 'App\\Models\\Accounts', 147, 'mobile-token', 'ab975e7ddf71d2dc2bc87ede981afeb8ca6b4e3928718df03155eb6a2aa2d4c5', '[\"*\"]', NULL, NULL, '2025-06-11 09:53:41', '2025-06-11 09:53:41'),
(63, 'App\\Models\\Accounts', 147, 'mobile-token', '7d4fe1b60a28ae8a9fffc7c25546e86cd344be0ff4866f19423c76ee050e99d4', '[\"*\"]', '2025-06-11 10:03:42', NULL, '2025-06-11 09:59:31', '2025-06-11 10:03:42'),
(64, 'App\\Models\\Accounts', 147, 'mobile-token', 'e89e235f683a1a69d2b640fa69bf84461421049956734b1282aa648b85c1601c', '[\"*\"]', '2025-06-11 10:29:23', NULL, '2025-06-11 10:11:15', '2025-06-11 10:29:23'),
(65, 'App\\Models\\Accounts', 147, 'mobile-token', 'f8da55ee1e82752f819dcac632186344937b025247398f185b9c8c838f9130d7', '[\"*\"]', '2025-06-11 10:56:04', NULL, '2025-06-11 10:56:03', '2025-06-11 10:56:04'),
(66, 'App\\Models\\Accounts', 147, 'mobile-token', '94839e57e17e4d02057648f76f6c4558e3564f798783f469363ca5db2f7c9f64', '[\"*\"]', '2025-06-11 11:08:52', NULL, '2025-06-11 11:08:51', '2025-06-11 11:08:52'),
(67, 'App\\Models\\Accounts', 147, 'mobile-token', '3b04126994e1efff86b15ae97aebe9153b3dc20a84a2f29d0e2fdf1a3b67a8ab', '[\"*\"]', '2025-06-11 11:27:26', NULL, '2025-06-11 11:27:25', '2025-06-11 11:27:26'),
(68, 'App\\Models\\Accounts', 147, 'mobile-token', '1b33d043640431f52e6a8c4f08d0d30cc54b13ce2a5dd6d4d9bb287fa6ad69c1', '[\"*\"]', '2025-06-11 11:37:59', NULL, '2025-06-11 11:30:52', '2025-06-11 11:37:59'),
(69, 'App\\Models\\Accounts', 147, 'mobile-token', '0444f9ff5703bbe87960afac4b5cbc96530795d55323448bedccef4f5ef0f6f1', '[\"*\"]', '2025-06-11 11:49:17', NULL, '2025-06-11 11:47:02', '2025-06-11 11:49:17'),
(70, 'App\\Models\\Accounts', 147, 'mobile-token', 'bbbdf0f5cb7263106eeda5ee96dfbc5dca9361b213fd98f7c24a49abec00257e', '[\"*\"]', '2025-06-11 11:56:08', NULL, '2025-06-11 11:51:47', '2025-06-11 11:56:08'),
(71, 'App\\Models\\Accounts', 148, 'mobile-token', '5916c4ee5d6daf9b6664ca57809bc8633154388196450872bdb5688fe931bdfc', '[\"*\"]', NULL, NULL, '2025-06-11 14:24:55', '2025-06-11 14:24:55'),
(72, 'App\\Models\\Accounts', 149, 'mobile-token', '711cd7191f477edc18122b7fd8f3c19ef376fb6a660475a6d42f08a75091272f', '[\"*\"]', NULL, NULL, '2025-06-11 14:28:27', '2025-06-11 14:28:27'),
(73, 'App\\Models\\Accounts', 149, 'mobile-token', 'a82f883c9a617a92ddcd4c850b5fad393e9e7ee5bcbdc0fc4489f0ea76e23e18', '[\"*\"]', '2025-06-11 14:29:57', NULL, '2025-06-11 14:28:40', '2025-06-11 14:29:57'),
(74, 'App\\Models\\Accounts', 150, 'mobile-token', '3ab7b65af6146cbe63fd59c6765ea828bad27faa4d22729bd5c180d69d8b7560', '[\"*\"]', NULL, NULL, '2025-06-11 14:30:41', '2025-06-11 14:30:41'),
(75, 'App\\Models\\Accounts', 150, 'mobile-token', 'b469d02156293446de557ac89e99443a86e3830234bd91e1127d881ce082b66c', '[\"*\"]', '2025-06-11 14:43:20', NULL, '2025-06-11 14:30:51', '2025-06-11 14:43:20'),
(76, 'App\\Models\\Accounts', 150, 'mobile-token', '1c64661fc4d3ec98c2d5e1866287bc84eedd29c50b0219535b5236a46ba84c75', '[\"*\"]', '2025-06-11 14:57:56', NULL, '2025-06-11 14:44:06', '2025-06-11 14:57:56'),
(77, 'App\\Models\\Accounts', 150, 'mobile-token', '7663f247dd677c591e4826dbbe24b3356654f6b96467995032b8beaa98956052', '[\"*\"]', '2025-06-11 23:47:57', NULL, '2025-06-11 23:46:09', '2025-06-11 23:47:57'),
(78, 'App\\Models\\Accounts', 151, 'mobile-token', '20b45d101a89f6b61f8c9789df69fe95fa4833695c6ba6f030b3b91d018443f9', '[\"*\"]', NULL, NULL, '2025-06-11 23:49:49', '2025-06-11 23:49:49'),
(79, 'App\\Models\\Accounts', 151, 'mobile-token', 'a861b8639731571df5a3ffa29f9edf04feb74d1914d7cb1ca00028b78f6c18bb', '[\"*\"]', '2025-06-12 00:01:44', NULL, '2025-06-11 23:49:57', '2025-06-12 00:01:44'),
(80, 'App\\Models\\Accounts', 151, 'mobile-token', 'b74cadd17808f9ae1ee949277e0dd5db35321d924c5fa1887b36283779ce9982', '[\"*\"]', '2025-06-12 00:01:32', NULL, '2025-06-11 23:53:36', '2025-06-12 00:01:32'),
(81, 'App\\Models\\Accounts', 152, 'mobile-token', '24ea531b14c01e43a9144852ad39179004f6e9f5014970b0b278fc1fe1805fba', '[\"*\"]', NULL, NULL, '2025-06-12 00:06:16', '2025-06-12 00:06:16'),
(82, 'App\\Models\\Accounts', 152, 'mobile-token', '621b9aa10191115e509e9554c19f9f3f2cf5ffbc7a9a2cf39dead5dbe42c0728', '[\"*\"]', '2025-06-12 00:10:50', NULL, '2025-06-12 00:06:27', '2025-06-12 00:10:50'),
(83, 'App\\Models\\Accounts', 152, 'mobile-token', '19667e78868dc86a6d6ef85e6edbecf4952318cd0c3d731dc1de16344bd8927e', '[\"*\"]', '2025-06-12 00:11:33', NULL, '2025-06-12 00:11:19', '2025-06-12 00:11:33'),
(84, 'App\\Models\\Accounts', 153, 'mobile-token', 'e66a7b7a8c186fc61fa91efd574a34ca12e68ce9a5dc54374e1297da48a8dfea', '[\"*\"]', NULL, NULL, '2025-06-12 00:14:08', '2025-06-12 00:14:08'),
(85, 'App\\Models\\Accounts', 153, 'mobile-token', '12f0a77beef810b2d96fef5ff4df8f454fbcc1dd4a5377a2d65813b6a2d5f01f', '[\"*\"]', '2025-06-12 00:17:34', NULL, '2025-06-12 00:14:13', '2025-06-12 00:17:34'),
(86, 'App\\Models\\Accounts', 153, 'mobile-token', 'cfea1e63f824de1dddba2c18a89ea4202309eb547d82c7fb194034e9cd02aba2', '[\"*\"]', '2025-06-12 00:15:33', NULL, '2025-06-12 00:14:24', '2025-06-12 00:15:33'),
(87, 'App\\Models\\Accounts', 153, 'mobile-token', 'd0af35d6aec4c38c5a4c74779486f0601ab14e18a0d926ea446be56c98b549f8', '[\"*\"]', '2025-06-12 01:25:40', NULL, '2025-06-12 00:29:05', '2025-06-12 01:25:40'),
(88, 'App\\Models\\Accounts', 153, 'mobile-token', '47109f9a99f1a02ee3a0f98857eef6faf466d87d75b80cc41e8d6431b0825617', '[\"*\"]', '2025-06-12 01:45:23', NULL, '2025-06-12 01:33:16', '2025-06-12 01:45:23'),
(89, 'App\\Models\\Accounts', 153, 'mobile-token', '7ad5167242aeb91ac9f6394eddbbb9fcbb2ebe1c916153dbe0f4847a6468b64f', '[\"*\"]', '2025-06-12 02:19:39', NULL, '2025-06-12 01:46:45', '2025-06-12 02:19:39'),
(90, 'App\\Models\\Accounts', 153, 'mobile-token', '997199edc5a194b4b3806b9cba022f6f8744d69b424c0abe953683c92091eb21', '[\"*\"]', '2025-06-12 02:21:31', NULL, '2025-06-12 02:21:25', '2025-06-12 02:21:31'),
(91, 'App\\Models\\Accounts', 153, 'mobile-token', '75497790ed2fe1e2c301ca6b27b162da2a75b669a67b8950d566b935701e8ec5', '[\"*\"]', '2025-06-12 03:08:41', NULL, '2025-06-12 02:21:51', '2025-06-12 03:08:41'),
(92, 'App\\Models\\Accounts', 153, 'mobile-token', 'e23324d91e25fbee75e8965c8eae09da9b2ebb7cf7a3605322b499f46733ae8c', '[\"*\"]', '2025-06-12 03:12:44', NULL, '2025-06-12 03:09:01', '2025-06-12 03:12:44'),
(93, 'App\\Models\\Accounts', 153, 'mobile-token', '5d56e0cc048853c11aa153e372f8dd4c0ec76f50871e04509119a6d3a80ba129', '[\"*\"]', '2025-06-12 03:13:05', NULL, '2025-06-12 03:13:02', '2025-06-12 03:13:05'),
(94, 'App\\Models\\Accounts', 153, 'mobile-token', '8f17881c40729666d8912ba5c1affbecc36c1cae68547592e84ed0a353cb5dce', '[\"*\"]', '2025-06-12 03:20:59', NULL, '2025-06-12 03:20:58', '2025-06-12 03:20:59'),
(95, 'App\\Models\\Accounts', 153, 'mobile-token', '51051271cddb99f590bc96897512a3df3e68344166e7247c9b40cca6259ead10', '[\"*\"]', '2025-06-12 03:26:11', NULL, '2025-06-12 03:26:10', '2025-06-12 03:26:11'),
(96, 'App\\Models\\Accounts', 153, 'mobile-token', 'e2dd67d74e704cff4c719ac69b480ef07955b8f6347d1a53a736123b31795e05', '[\"*\"]', '2025-06-12 03:42:42', NULL, '2025-06-12 03:38:50', '2025-06-12 03:42:42'),
(97, 'App\\Models\\Accounts', 153, 'mobile-token', '9c231667a0c8c8a4e8600d15b148da609d24935dc174446905e656bc21ede74d', '[\"*\"]', '2025-06-12 03:43:05', NULL, '2025-06-12 03:43:02', '2025-06-12 03:43:05'),
(98, 'App\\Models\\Accounts', 153, 'mobile-token', 'd6bf6753bbace047fea368d8329d5053728bb97bdad182b824ee4690dc2d6935', '[\"*\"]', '2025-06-12 03:44:30', NULL, '2025-06-12 03:44:05', '2025-06-12 03:44:30'),
(99, 'App\\Models\\Accounts', 153, 'mobile-token', 'f405864a5ed85814bb35aa35f4fef76442bbba4eda06f9be5c0110949097a293', '[\"*\"]', '2025-06-12 03:45:45', NULL, '2025-06-12 03:45:45', '2025-06-12 03:45:45'),
(100, 'App\\Models\\Accounts', 153, 'mobile-token', 'e99d93cd2c8111e7a4531fd895621b5c27fa02dea86671a18b65641e78b6d6d5', '[\"*\"]', '2025-06-12 04:18:37', NULL, '2025-06-12 04:18:36', '2025-06-12 04:18:37'),
(101, 'App\\Models\\Accounts', 153, 'mobile-token', '0187c7bd03afcd0647298600699de1393bc7c479c9da1b826b08ac3775b6b74e', '[\"*\"]', '2025-06-12 04:22:04', NULL, '2025-06-12 04:22:04', '2025-06-12 04:22:04'),
(102, 'App\\Models\\Accounts', 153, 'mobile-token', '287fca1e09d5ca7243d77c14dac074cca356aa741b011738a12d313c40927dcd', '[\"*\"]', '2025-06-12 04:26:03', NULL, '2025-06-12 04:26:03', '2025-06-12 04:26:03'),
(103, 'App\\Models\\Accounts', 153, 'mobile-token', '0a7022364a1d9e7c10f5e05761677162d4fa2ee24a3022019f372e53ce6ec7d9', '[\"*\"]', '2025-06-12 04:27:46', NULL, '2025-06-12 04:27:46', '2025-06-12 04:27:46'),
(104, 'App\\Models\\Accounts', 153, 'mobile-token', '63e5c5773081e268e3aae48b1af65ae5e6ef35c0cf278050d367f58fed7472f8', '[\"*\"]', '2025-06-12 04:31:48', NULL, '2025-06-12 04:31:47', '2025-06-12 04:31:48'),
(105, 'App\\Models\\Accounts', 153, 'mobile-token', 'fff8d5ecdf2350139afa919a085b0ab79cb373319a6669d32e2d202057c21451', '[\"*\"]', '2025-06-12 04:43:30', NULL, '2025-06-12 04:35:21', '2025-06-12 04:43:30'),
(106, 'App\\Models\\Accounts', 153, 'mobile-token', '034297e0511b6e26fc0a82626d7b8a3421bfb7743b4e3d0a94a9c2e51339681f', '[\"*\"]', '2025-06-12 04:49:47', NULL, '2025-06-12 04:43:58', '2025-06-12 04:49:47'),
(107, 'App\\Models\\Accounts', 153, 'mobile-token', '8f5f4d5074cddf762305c7f1f6e1988badc1ca2602430411bd74ea3f4236f71e', '[\"*\"]', '2025-06-12 06:22:06', NULL, '2025-06-12 04:45:33', '2025-06-12 06:22:06'),
(108, 'App\\Models\\Accounts', 153, 'mobile-token', 'e7f8a2df9f42e864db56a28dab0792509b09cabb496bff192db501105eb3e5b7', '[\"*\"]', '2025-06-12 04:52:01', NULL, '2025-06-12 04:50:17', '2025-06-12 04:52:01'),
(109, 'App\\Models\\Accounts', 153, 'mobile-token', 'd9474d0127d8785e9f73902da4d5141fffa80e0e3299d3249410a49100e262b0', '[\"*\"]', '2025-06-12 04:55:25', NULL, '2025-06-12 04:54:36', '2025-06-12 04:55:25'),
(110, 'App\\Models\\Accounts', 153, 'mobile-token', '6d30199b96147afaa6972f19d40a9997534433e4f9206ce7e7ed136896c998f2', '[\"*\"]', '2025-06-12 04:57:51', NULL, '2025-06-12 04:55:34', '2025-06-12 04:57:51'),
(111, 'App\\Models\\Accounts', 153, 'mobile-token', '70cccdc19dccc0148275cad3899b2b416c58e63929213efda82ad701e0be303e', '[\"*\"]', '2025-06-12 06:21:31', NULL, '2025-06-12 06:21:27', '2025-06-12 06:21:31'),
(112, 'App\\Models\\Accounts', 154, 'mobile-token', 'd95e827f08bc57529f0e2423b940a4f74a17ba41e2b64213cdbe1d997605eb56', '[\"*\"]', NULL, NULL, '2025-06-12 06:25:45', '2025-06-12 06:25:45'),
(113, 'App\\Models\\Accounts', 154, 'mobile-token', 'cbc2fe33a106bf07430e4ea192d8b2dddf2b1f82ec6df4135d773910d209c588', '[\"*\"]', '2025-06-12 06:54:53', NULL, '2025-06-12 06:26:00', '2025-06-12 06:54:53'),
(114, 'App\\Models\\Accounts', 154, 'mobile-token', '2e096729e6942a663161d780a8c8307b9cc3d2f1e91e2013a3358b972debcf90', '[\"*\"]', '2025-06-12 07:00:26', NULL, '2025-06-12 06:56:46', '2025-06-12 07:00:26'),
(115, 'App\\Models\\Accounts', 154, 'mobile-token', 'cac556556d62da57bba6650fb1fce0f3baca3e4b1b758f362e08d3334283887c', '[\"*\"]', '2025-06-12 07:05:10', NULL, '2025-06-12 07:02:58', '2025-06-12 07:05:10'),
(116, 'App\\Models\\Accounts', 154, 'mobile-token', '2856806d4c5e2bd0fefd82db103fd1b575fcfbba24e48506755e8ef9f00f4179', '[\"*\"]', '2025-06-12 07:05:40', NULL, '2025-06-12 07:05:36', '2025-06-12 07:05:40'),
(117, 'App\\Models\\Accounts', 154, 'mobile-token', 'bcb632527f30335cba7c620c921fbb0f2d9704043df338c8464f3fe1d63e8bf4', '[\"*\"]', '2025-06-12 07:17:31', NULL, '2025-06-12 07:10:55', '2025-06-12 07:17:31'),
(118, 'App\\Models\\Accounts', 154, 'mobile-token', '56a79e8c7a963a4e8109eaa2bf313ff79011f598bdb6a4520c583205dc696063', '[\"*\"]', '2025-06-12 07:17:49', NULL, '2025-06-12 07:17:41', '2025-06-12 07:17:49'),
(119, 'App\\Models\\Accounts', 154, 'mobile-token', '55a8cba942d60d6738512cd99b2bbb8b8e190d296f73ddd40544e05916cca7e3', '[\"*\"]', '2025-06-12 07:24:40', NULL, '2025-06-12 07:21:06', '2025-06-12 07:24:40'),
(120, 'App\\Models\\Accounts', 154, 'mobile-token', 'dccc09c01efe22e9c1c86680a41414331080e6b64ef8aa27d58f051fc49df249', '[\"*\"]', '2025-06-12 07:30:38', NULL, '2025-06-12 07:26:35', '2025-06-12 07:30:38'),
(121, 'App\\Models\\Accounts', 154, 'mobile-token', 'a221ae7898b3b1c237d19b6e7b913ea5703dac7f3686a861605436dbd42ad398', '[\"*\"]', '2025-06-12 07:35:23', NULL, '2025-06-12 07:35:09', '2025-06-12 07:35:23'),
(122, 'App\\Models\\Accounts', 155, 'mobile-token', 'd11abeee8111af9df43fc9f9bbdd024d6353fabc41af1a4a112e51e1b2a1a262', '[\"*\"]', NULL, NULL, '2025-06-12 07:40:12', '2025-06-12 07:40:12'),
(123, 'App\\Models\\Accounts', 155, 'mobile-token', '7735cd7a25b5aaba5b0c96fd46120eb3e2491e0729cfd7eb2d13f5236480eaa0', '[\"*\"]', '2025-06-12 07:56:32', NULL, '2025-06-12 07:40:15', '2025-06-12 07:56:32'),
(124, 'App\\Models\\Accounts', 155, 'mobile-token', 'eaa01305edbb62ca8dbeb81cf2571fce29133ef6ba2f93c1324294b99a64e694', '[\"*\"]', '2025-06-12 10:10:30', NULL, '2025-06-12 10:09:06', '2025-06-12 10:10:30'),
(125, 'App\\Models\\Accounts', 155, 'mobile-token', '1d77fefad1cbaabec6d3341ac70a653e323548f28b8d4c9bdf36a035857c55be', '[\"*\"]', '2025-06-12 10:17:54', NULL, '2025-06-12 10:12:38', '2025-06-12 10:17:54'),
(126, 'App\\Models\\Accounts', 155, 'mobile-token', 'ea5d2f21592c656d0e095550ae5033bbed61c7543ef7eb731f2f49108de51e36', '[\"*\"]', '2025-06-12 16:07:35', NULL, '2025-06-12 10:22:13', '2025-06-12 16:07:35'),
(127, 'App\\Models\\Accounts', 155, 'mobile-token', '1ad0cd3da962356cd2b6d803f0ec3b48493eadb127af793772f588f09e40aacd', '[\"*\"]', '2025-06-12 16:17:32', NULL, '2025-06-12 16:07:53', '2025-06-12 16:17:32'),
(128, 'App\\Models\\Accounts', 155, 'mobile-token', '90d2d0923aa2c1efe1ebc07d90c016bc3d349f82795fa81d186a544c78a11e46', '[\"*\"]', '2025-06-12 16:27:29', NULL, '2025-06-12 16:23:03', '2025-06-12 16:27:29'),
(129, 'App\\Models\\Accounts', 155, 'mobile-token', 'dee159e44e3ea5838627de68a26cff495ce706d5dfbf3c832179cc9315c642c7', '[\"*\"]', '2025-06-12 16:32:35', NULL, '2025-06-12 16:30:06', '2025-06-12 16:32:35'),
(130, 'App\\Models\\Accounts', 155, 'mobile-token', 'f1c49e2da07c426c89aa336c5c22119a46d72950397aa337bb0e211503b7f7e7', '[\"*\"]', '2025-06-12 16:34:20', NULL, '2025-06-12 16:32:59', '2025-06-12 16:34:20'),
(131, 'App\\Models\\Accounts', 155, 'mobile-token', '916fb63fc7e1120c181dbc6894cf14d97dd8d05a3b20ca341611ca9b9b935c0b', '[\"*\"]', '2025-06-12 16:38:37', NULL, '2025-06-12 16:34:45', '2025-06-12 16:38:37'),
(132, 'App\\Models\\Accounts', 155, 'mobile-token', 'f5aa096b918c07cc0f6c0a1a720f5970f7a02483a465041e41209cca9531c989', '[\"*\"]', '2025-06-12 16:40:44', NULL, '2025-06-12 16:38:45', '2025-06-12 16:40:44'),
(133, 'App\\Models\\Accounts', 155, 'mobile-token', '434c273885f92c262f80ac6556f0f36033454a548df73e7830109a17c4f2e6bc', '[\"*\"]', '2025-06-12 16:43:59', NULL, '2025-06-12 16:40:53', '2025-06-12 16:43:59'),
(134, 'App\\Models\\Accounts', 155, 'mobile-token', 'f0e9e3d603bae7358dd2991072ad7a3352b33c347b518be52b88c31927187a42', '[\"*\"]', '2025-06-12 23:35:29', NULL, '2025-06-12 16:44:27', '2025-06-12 23:35:29'),
(135, 'App\\Models\\Accounts', 155, 'mobile-token', 'a5e1f4011d437506b4fe0989f9950894e10c7c9ae318bc267c510be861b0f50c', '[\"*\"]', '2025-06-12 23:37:00', NULL, '2025-06-12 23:35:59', '2025-06-12 23:37:00'),
(136, 'App\\Models\\Accounts', 156, 'mobile-token', '280512365a32862adc2058d4ce1d95bd5123a187b5cbfe10ac3d511254f2c089', '[\"*\"]', '2025-06-12 23:55:22', NULL, '2025-06-12 23:39:44', '2025-06-12 23:55:22'),
(137, 'App\\Models\\Accounts', 157, 'mobile-token', 'e7ade4e97abefb3b6d49832574604c1e4166e400348ac0c5bdf635a05168e038', '[\"*\"]', '2025-06-12 23:58:33', NULL, '2025-06-12 23:56:52', '2025-06-12 23:58:33'),
(138, 'App\\Models\\Accounts', 157, 'mobile-token', '2cba09bc990cc85e0c28c5596bfd9ea7969b05527290af1e9771cf130117b0cb', '[\"*\"]', '2025-06-13 01:03:37', NULL, '2025-06-12 23:58:49', '2025-06-13 01:03:37'),
(139, 'App\\Models\\Accounts', 157, 'mobile-token', 'bd0fcd151fa2e92fb3ad06f139424d2377e73994f0f4c967f19df208a4151226', '[\"*\"]', '2025-06-13 02:10:04', NULL, '2025-06-13 02:09:59', '2025-06-13 02:10:04'),
(140, 'App\\Models\\Accounts', 158, 'mobile-token', '43074bcb4809ef21e1e6954e871b1df06f11824dc729e1b47bb31473cba06e90', '[\"*\"]', '2025-06-13 02:12:01', NULL, '2025-06-13 02:12:00', '2025-06-13 02:12:01'),
(141, 'App\\Models\\Accounts', 158, 'mobile-token', '4b4fb4f3eaef9cf7a44448fa22e51a35af0b7b1938bb7e062134823e03796cc5', '[\"*\"]', '2025-06-13 02:13:40', NULL, '2025-06-13 02:12:43', '2025-06-13 02:13:40'),
(142, 'App\\Models\\Accounts', 158, 'mobile-token', '51c2e9ae69db834d11ab6843ac4a5c430601c0e2d89681490bbfbebe4124dea2', '[\"*\"]', NULL, NULL, '2025-06-13 02:13:55', '2025-06-13 02:13:55'),
(143, 'App\\Models\\Accounts', 158, 'mobile-token', 'ef18fb1bc4e17e67d810d1d557a7114056a43e2bb8110175738f6ddc44cedbd1', '[\"*\"]', '2025-06-14 04:14:44', NULL, '2025-06-13 03:22:49', '2025-06-14 04:14:44'),
(144, 'App\\Models\\Accounts', 158, 'mobile-token', '1adf036a34ebd78489a8db65eb66575c47bceb2b9320bd76cae46d2cd23a6c37', '[\"*\"]', NULL, NULL, '2025-06-14 04:16:49', '2025-06-14 04:16:49'),
(145, 'App\\Models\\Accounts', 158, 'mobile-token', 'f2f74cd70bac04364e87315e7d001c1ab949938dead86bbb481fe9bd7ea94b1b', '[\"*\"]', '2025-06-14 04:17:48', NULL, '2025-06-14 04:17:09', '2025-06-14 04:17:48'),
(146, 'App\\Models\\Accounts', 158, 'mobile-token', '4bbb0116446c4bff5a0d0ff215e41d808f4d789576db8b0c1e33670ed338956e', '[\"*\"]', '2025-06-14 04:41:04', NULL, '2025-06-14 04:17:51', '2025-06-14 04:41:04'),
(147, 'App\\Models\\Accounts', 158, 'mobile-token', '0478a3c293140c0f038261f6aaaa36c805aaad7fe4f3545da2e9d7686ec2ecec', '[\"*\"]', '2025-06-14 04:41:32', NULL, '2025-06-14 04:41:31', '2025-06-14 04:41:32'),
(148, 'App\\Models\\Accounts', 158, 'mobile-token', 'd61ba2ed5564fcb37912faa27eb0604e4ee7ab7432d137dc00cbb0bca17d8bed', '[\"*\"]', '2025-06-14 16:53:11', NULL, '2025-06-14 16:47:53', '2025-06-14 16:53:11'),
(149, 'App\\Models\\Accounts', 159, 'mobile-token', 'f45339adcdf28ab4a579249f4194f2bff50ea0649cb83b0121868b037dd9cc59', '[\"*\"]', '2025-06-15 00:11:31', NULL, '2025-06-15 00:04:58', '2025-06-15 00:11:31'),
(150, 'App\\Models\\Accounts', 159, 'mobile-token', '7fc27ae9ad50e4fff608965c8c4db31d977c801a3e8c04f3b2cd4b06cd529393', '[\"*\"]', '2025-06-15 00:20:25', NULL, '2025-06-15 00:11:52', '2025-06-15 00:20:25'),
(151, 'App\\Models\\Accounts', 160, 'mobile-token', 'e52a9b98290aab170c1f43039f1d8e8745f9c8cda37ab3cdcdef5eac0b4eec34', '[\"*\"]', '2025-06-15 00:38:45', NULL, '2025-06-15 00:22:05', '2025-06-15 00:38:45'),
(152, 'App\\Models\\Accounts', 160, 'mobile-token', '71b884d5aa4b267715c8365250b1a32b79962c1030e771cbcc5e1907d62ee52f', '[\"*\"]', '2025-06-15 11:07:36', NULL, '2025-06-15 11:04:01', '2025-06-15 11:07:36'),
(153, 'App\\Models\\Accounts', 160, 'mobile-token', 'b40a08c67b85895139734c505081ec8444358b1279de223a7f1049b9bb2f4f89', '[\"*\"]', '2025-06-15 11:11:10', NULL, '2025-06-15 11:11:05', '2025-06-15 11:11:10'),
(154, 'App\\Models\\Accounts', 161, 'mobile-token', '0d9de9253efac32b97b47761dbb7f5f518fc6e6e5c7fdfd62615a5d0781531f8', '[\"*\"]', '2025-06-15 11:17:37', NULL, '2025-06-15 11:14:03', '2025-06-15 11:17:37'),
(155, 'App\\Models\\Accounts', 161, 'mobile-token', 'd77454a5ef5c64714d1d2d6fb13fa66af31e56c780be5ed9caf03913a1823781', '[\"*\"]', '2025-06-15 11:18:23', NULL, '2025-06-15 11:18:18', '2025-06-15 11:18:23'),
(156, 'App\\Models\\Accounts', 162, 'mobile-token', 'd3795ec1d84d6e511b020d6fc6bc65fc0a1ec0190dc8e836e086660b78127dff', '[\"*\"]', '2025-06-15 11:47:06', NULL, '2025-06-15 11:21:34', '2025-06-15 11:47:06'),
(157, 'App\\Models\\Accounts', 162, 'mobile-token', 'ca681494ba0b065743f3a2d8e89e42330e404d21a29cbc2e64442247dae0e572', '[\"*\"]', '2025-06-15 11:48:15', NULL, '2025-06-15 11:47:25', '2025-06-15 11:48:15'),
(158, 'App\\Models\\Accounts', 162, 'mobile-token', '5054eb22fd229c1b4ed84c94f582f89cbfb9b44e0bc0b43b73b2e26998a16dcf', '[\"*\"]', '2025-06-15 14:15:20', NULL, '2025-06-15 14:14:59', '2025-06-15 14:15:20'),
(159, 'App\\Models\\Accounts', 163, 'mobile-token', '4122c3bd1302c4c8d6e702203c3627fbf831e5f31f043822492616b5376810ac', '[\"*\"]', '2025-06-15 14:18:39', NULL, '2025-06-15 14:17:22', '2025-06-15 14:18:39'),
(160, 'App\\Models\\Accounts', 166, 'mobile-token', '1ed3ba84d3dda5b22bd62f02762df7e923b51333854ffd2fb017a878a5f98170', '[\"*\"]', '2025-06-16 10:28:22', NULL, '2025-06-16 10:25:58', '2025-06-16 10:28:22');

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
('kxNcK4WpL27bSTyiIcx5SvxTCqB4qvgifbe9Tb8a', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 'YTo0OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiQzQyZ2hWTnBzcENJdnFsQk5qSWJFRjEwSGlmZldYV25CVE9pVmZQUiI7czoxODoic2hvd19jb2xsZWdlX21vZGFsIjtiOjE7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1750129189),
('X4lpF25n2ykk4aFtUMNky3KumIHVZBrPY7lTTST2', 38, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoidzVGMllnSzhkZXVqRnVsUHg1dTNKbkc5eW94aFFuQlFnOVZOR2hUTyI7czoxODoic2hvd19jb2xsZWdlX21vZGFsIjtiOjE7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbmlzdHJhdG9yL2Rhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM4O3M6NDoibmFtZSI7czoxMzoiQURNSU4gLiBBRE1JTiI7czo1OiJlbWFpbCI7czoxNToiYWRtaW5AZ21haWwuY29tIjtzOjQ6InJvbGUiO3M6MTM6ImFkbWluaXN0cmF0b3IiO30=', 1750131184);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `applicant_schedules`
--
ALTER TABLE `applicant_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `form_change_logs`
--
ALTER TABLE `form_change_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `form_submissions`
--
ALTER TABLE `form_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `signup_otps`
--
ALTER TABLE `signup_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

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
