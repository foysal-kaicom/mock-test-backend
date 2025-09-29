-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql-db:3306
-- Generation Time: Sep 24, 2025 at 06:09 AM
-- Server version: 8.4.5
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jptbd`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `commission_percentage` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `name`, `business_name`, `photo`, `email`, `phone`, `location`, `status`, `created_at`, `updated_at`, `commission_percentage`) VALUES
(1, 'paule henry', 'DeepWhuite', 'https://media.kaicombd.com/uploads/agents/7a8b5645-97c6-43ea-bc22-086f37e72e57.jpeg', 'paulehenry@gmail.com', '+88017499400744', 'Paris', 1, '2025-09-09 15:54:56', '2025-09-09 15:54:56', 12.00),
(2, 'Nahid hassan', 'JLPT premimum', NULL, 'tahilu@mailinator.com', '0174516-2583', 'Eu voluptas officia', 1, '2025-09-10 10:42:11', '2025-09-10 10:42:11', 25.00);

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci COMMENT 'store in json format',
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `candidate_id` bigint UNSIGNED NOT NULL,
  `exam_id` bigint UNSIGNED NOT NULL,
  `center_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','confirmed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','success','failed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_payable` double NOT NULL DEFAULT '0',
  `result_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'score',
  `admit_card_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificate_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_certificate_claimed` tinyint(1) NOT NULL DEFAULT '0',
  `certificate_claimed_at` timestamp NULL DEFAULT NULL,
  `booking_note` text COLLATE utf8mb4_unicode_ci,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `center_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `examinee_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `listening_score` int NOT NULL DEFAULT '0',
  `reading_score` int NOT NULL DEFAULT '0',
  `agent_id` bigint UNSIGNED DEFAULT NULL,
  `commission_percentage` decimal(5,2) DEFAULT NULL,
  `commission_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `candidate_id`, `exam_id`, `center_id`, `status`, `payment_status`, `total_payable`, `result_file`, `result`, `admit_card_file`, `certificate_file`, `is_certificate_claimed`, `certificate_claimed_at`, `booking_note`, `updated_by`, `deleted_at`, `created_at`, `updated_at`, `country_code`, `center_code`, `examinee_number`, `listening_score`, `reading_score`, `agent_id`, `commission_percentage`, `commission_amount`) VALUES
(1, 2, 3, 1, 'confirmed', 'success', 3500, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2025-09-09 15:55:13', '2025-09-09 15:55:13', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(2, 3, 3, 1, 'confirmed', 'success', 3500, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2025-09-09 15:55:13', '2025-09-09 15:55:13', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(3, 4, 3, 1, 'confirmed', 'success', 3500, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2025-09-09 15:55:13', '2025-09-09 15:55:13', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(4, 5, 3, 1, 'confirmed', 'success', 3500, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2025-09-09 15:55:13', '2025-09-09 15:55:13', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(5, 6, 3, 1, 'confirmed', 'success', 3500, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2025-09-09 15:55:13', '2025-09-09 15:55:13', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(6, 7, 3, 1, 'confirmed', 'success', 3500, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2025-09-09 15:55:14', '2025-09-09 15:55:14', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(7, 8, 2, 1, 'confirmed', 'success', 3500, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2025-09-09 15:55:31', '2025-09-09 15:55:31', NULL, NULL, NULL, 0, 0, 1, 12.00, 96.00),
(8, 9, 2, 1, 'cancelled', 'success', 3500, NULL, '0', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2025-09-09 15:55:31', '2025-09-17 15:39:31', NULL, NULL, NULL, 0, 0, 1, 12.00, 96.00),
(9, 10, 2, 1, 'confirmed', 'success', 3500, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2025-09-09 15:55:32', '2025-09-09 15:55:32', NULL, NULL, NULL, 0, 0, 1, 12.00, 96.00),
(10, 11, 2, 1, 'confirmed', 'success', 3500, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2025-09-09 15:55:32', '2025-09-09 15:55:32', NULL, NULL, NULL, 0, 0, 1, 12.00, 96.00),
(11, 12, 2, 1, 'confirmed', 'success', 3500, NULL, '0', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2025-09-09 15:55:32', '2025-09-24 11:54:29', NULL, NULL, '050-001-00543', 0, 0, 1, 12.00, 96.00),
(12, 13, 2, 1, 'confirmed', 'success', 3500, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2025-09-09 15:55:32', '2025-09-09 15:55:32', NULL, NULL, NULL, 0, 0, 1, 12.00, 96.00),
(13, 14, 2, 1, 'confirmed', 'success', 3500, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2025-09-09 15:55:32', '2025-09-09 15:55:32', NULL, NULL, NULL, 0, 0, 1, 12.00, 96.00),
(14, 15, 2, 1, 'confirmed', 'success', 3500, NULL, '0', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2025-09-09 15:55:33', '2025-09-24 11:54:08', NULL, NULL, '050-001-00539', 0, 0, 1, 12.00, 96.00);

-- --------------------------------------------------------

--
-- Table structure for table `business_settings`
--

CREATE TABLE `business_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bkash_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificate_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `bin_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tin_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trade_license` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `legal_docs` text COLLATE utf8mb4_unicode_ci,
  `certification_docs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorized_docs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privacy_policy` longtext COLLATE utf8mb4_unicode_ci,
  `terms_and_conditions` longtext COLLATE utf8mb4_unicode_ci,
  `return_policy` longtext COLLATE utf8mb4_unicode_ci,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_settings`
--

INSERT INTO `business_settings` (`id`, `business_name`, `business_email`, `business_phone`, `bkash_number`, `website_url`, `certificate_amount`, `address`, `bin_number`, `tin_number`, `trade_license`, `legal_docs`, `certification_docs`, `authorized_docs`, `logo`, `favicon_icon`, `privacy_policy`, `terms_and_conditions`, `return_policy`, `facebook_url`, `twitter_url`, `linkedin_url`, `youtube_url`, `instagram_url`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'JPTBD', 'xyz@jptbd.com', '1234567890', '01778899955', 'https://www.yourwebsite.com', '510.00', 'BNS Center, Uttara, Dhaka', '1234567890', '9876543210', 'TL-12345', 'Path/To/LegalDocs.pdf', 'Path/To/CertificationDocs.pdf', 'Path/To/AuthorizedDocs.pdf', 'Path/To/Logo.png', 'Path/To/Favicon.ico', 'Privacy Policy content goes here...', 'Terms and conditions content goes here...', 'Return policy content goes here...', 'https://www.facebook.com/yourbusiness', 'https://www.twitter.com/yourbusiness', 'https://www.linkedin.com/company/yourbusiness', 'https://www.youtube.com/c/yourbusiness', 'https://www.instagram.com/yourbusiness', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` bigint UNSIGNED NOT NULL,
  `prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `national_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci,
  `social_facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_email_verified` tinyint(1) NOT NULL DEFAULT '1',
  `is_phone_verified` tinyint(1) NOT NULL DEFAULT '0',
  `otp` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_expired_at` datetime DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_expired_at` datetime DEFAULT NULL,
  `otp_reset_attempts` int DEFAULT NULL,
  `status` enum('active','frozen') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `address` text COLLATE utf8mb4_unicode_ci,
  `currently_living_country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Bangladesh',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `prefix`, `first_name`, `last_name`, `surname`, `email`, `password`, `date_of_birth`, `phone_number`, `nationality`, `national_id`, `gender`, `photo`, `social_facebook`, `social_linkedin`, `is_email_verified`, `is_phone_verified`, `otp`, `otp_expired_at`, `token`, `token_expired_at`, `otp_reset_attempts`, `status`, `address`, `currently_living_country`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Mr.', 'Foysal', 'Ahmed', 'Smith', 'john.doe@example.com', '$2y$12$Abb1x4MoYo3dAijKcziT2ew2eJ0BXyo1N.MU0MrkkHSG/x9b1zAJa', '1995-05-13', '01700000000', 'Bangladeshi', '1995123456789', 'male', NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 0, 'active', 'dhaka', 'Bangladesh', NULL, '2025-09-09 15:53:32', '2025-09-24 10:56:23'),
(2, 'Mr.', 'POLASH CHONDRA', 'DAS', '', 'm.r.rownak@kaicomsol.com', '$2y$12$xsU89Ej2HaUlYWGtEOnC/.Act8cHS/YXWo.o2mTgWDeZTqjmmbisO', '2007-08-18', '1701576902', 'Bangladeshi', 'A01633773', 'male', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 'active', 'Jugia 12, Palpara By Lane, Kushtia Model, Jugia-7000, Kushtia', 'Bangladesh', NULL, '2025-09-09 15:55:13', '2025-09-22 16:56:29'),
(3, 'Mr.', 'KAZI JUBAYER', 'HOSSAIN', '', 'rownakabin@gmail.com', '$2y$12$o4KObjhrTb7Z53i.0gRvK.u0OcTsxciE4VQAhDYtoC6UT1NtZjxUq', '2007-07-17', '1982452821', 'Bangladeshi', 'A15596492', 'male', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 'active', 'Uttar Chapain, Savar, CRP Chapain - 1343, Dhaka', 'Bangladesh', NULL, '2025-09-09 15:55:13', '2025-09-09 15:55:13'),
(4, 'Mr.', 'NAHID', 'HASSAN', '', 'arifrabbaniakib@kaicomsol.com', '$2y$12$ksnAndZ0NJj3TCQAZvceDee7BY2oyf.JqTcD19/G7dNR4.sdwI75W', '2005-08-02', '8801865033323', 'Bangladeshi', '3764860288', 'male', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 'active', 'H-F#41,PL-84, FAIDABAD, DAKSHIN KHAN, DHAKA-1230', 'Bangladesh', NULL, '2025-09-09 15:55:13', '2025-09-09 15:55:13'),
(5, 'Mr.', 'MD. SHIPON', '', '', 'md.tohidulislam@kaicomsol.com', '$2y$12$x04SaN205Qa.t7DmcGhdgOHKEp7cM0uktwshUM.R9wZTyZ7mSsZC.', '2001-09-04', '1602627197', 'Bangladeshi', '5115035924', 'male', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 'active', 'Matiara, Amratali, Barura, Cumilla', 'Bangladesh', NULL, '2025-09-09 15:55:13', '2025-09-09 15:55:13'),
(6, 'Mr.', 'ANONTO KUMAR', 'SAHA', '', 'rythmicrownak@gmail.com', '$2y$12$zzbPamPYUIt0n.1fEisCGej9B3MzfLrjZ3u9kyocpxzq65DDo444y', '2003-06-24', '1866949750', 'BANGLADESH', '9590544715', 'male', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 'active', 'Adarsha para ,Jhenaidah Sadar, Jhenaidah', 'Bangladesh', NULL, '2025-09-09 15:55:13', '2025-09-09 15:55:13'),
(7, 'Mrs.', 'MD. NADIM HASAN', 'SIYAM', '', 'foysal11203004@gmail.com', '$2y$12$u9iM30hGG/.nHOXZ.jfA3.cl8lvZGS7bxRn2jv//m0WWF5EZTotZm', '2005-06-30', '1631170141', 'BANGLADESHI', 'A13151168', 'female', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 'active', 'HOUSE-15, ROAD-14, BLOCK-E, BAUNIABANDH, SECTION-11, PALLABI, MIRPUR-1216, DHAKA', 'Bangladesh', NULL, '2025-09-09 15:55:14', '2025-09-09 15:55:14'),
(8, 'Mr.', 'MD', 'PARVEJ', 'MOSHAROF', 'mdparvejmosharof42500@gmail.com', '$2y$12$/X40dFYuydfYp5PqZMq99ePG1i5VRA.2facdZj42d4k2MYpA7Kiy.', '2004-12-25', '1304263173', 'Bangladeshi', '9592036652', 'male', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 'active', 'Village- Sreedharpur, Post Office- Baroikhali-1544, Upazila- Sreenagar, District- Munshiganj', 'Bangladesh', NULL, '2025-09-09 15:55:31', '2025-09-09 15:55:31'),
(9, 'Mr.', 'MD.MINHAZUL', 'ISLAM', 'MINHAZUL', 'minhazul736star@gmail.com', '$2y$12$xIEihz90nmyOenRgz5JjGO0NnYt3eDFCQWEDTZ25X73hE7CU3qlce', '2004-10-02', '1537563279', 'Bangladeshi', '6022457318', 'male', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 'active', '1131 east monipur,mirpur-2,Dhaka-1216', 'Bangladesh', NULL, '2025-09-09 15:55:31', '2025-09-09 15:55:31'),
(10, 'Mr.', 'MD ASRAFUL ISLAM', 'CHOWDURY', '', 'ashrafulislamchowdhury106@gmail.com', '$2y$12$n676kMyM7uUkI/NGWN0ItO8yGv5iSd6hDSgNQaKVIlszsFrPuFA8a', '2006-06-29', '1854289564', 'Bangladeshi', 'A13274849', 'male', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 'active', '423. BORABO, KOBORSTHAN ROAD, RUPGANJ, JATRAMURA-1360, NARAYANGANJ', 'Bangladesh', NULL, '2025-09-09 15:55:31', '2025-09-09 15:55:31'),
(11, 'Mr.', 'MOHAMMAD', 'SAYEM SOYEB', 'SAYEM', 'sayemsoyeb24@gmail.com', '$2y$12$9s8eIoB8jkUsqT4.tz276OtrQ.7xe5t/Or9gaSIoS3bT6edfgZ72C', '2004-12-29', '1304571884', 'Bangladeshi', '4672612043', 'male', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 'active', 'Pacific Academy, Azgor Ali Bhaban, Access Road, Bakalia, Chattogram.', 'Bangladesh', NULL, '2025-09-09 15:55:32', '2025-09-09 15:55:32'),
(12, 'Mr.', 'Md. Al Amin', 'Chowdhury', 'Chowdhury', 'alaminchowdhury8920@gmail.com', '$2y$12$9fvDNqHgEnarfMVQjZHIjOj93EFaY3tSZ5fmPBgJ5ETafn8BiPXJy', '2001-12-31', '1861407069', 'Bangladeshi', 'A14433358', 'male', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 'active', 'Dhampti, Debidwar, Dhampti - 3533, Cumilla', 'Bangladesh', NULL, '2025-09-09 15:55:32', '2025-09-09 15:55:32'),
(13, 'Mr.', 'MIRZA AANAS', 'ABDUN NAFEE', '', 'maanasmirza@gmail.com', '$2y$12$H1R7fStUEgI5uTPkP4u9T.joCNzi9EG.iLZayZcFEQnmqidMH8Rqu', '1999-09-10', '8800000000000', 'Bangladeshi', 'A00980913', 'male', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 'active', 'DCC 156, East Kafrul, Dhaka Cantonment, Dhaka-1206, Dhaka', 'Bangladesh', NULL, '2025-09-09 15:55:32', '2025-09-09 15:55:32'),
(14, 'Mr.', 'Md', 'Sazzad Hasan', 'Mahin', 'mdmahin1203@gmail.com', '$2y$12$hwbsGfv0TsFmiYTMnaB50O8/LHQCZBAoDUoGrE6CVifsXEswcpMRi', '2004-01-09', '1751167412', 'Bangladeshi', '3322352745', 'male', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 'active', 'Shologhar, Sreenagar, Munshigonj', 'Bangladesh', NULL, '2025-09-09 15:55:32', '2025-09-09 15:55:32'),
(15, 'Mr.', 'Tonmoy', 'Chandra Sarkar', 'TONMOY', 'tonmoysarkar3400@gmail.com', '$2y$12$MTYLmLqN6mZ0wTCL5/CRAe6UOedh145HoXSynwxLPNWS88a/7J/NG', '2004-01-30', '1793080193', 'Bangladeshi', '7374493620', 'male', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 'active', 'District: Munshiganj Vill:Sreenagar, Thana: Sreenagar post:Sreenagar.', 'Bangladesh', NULL, '2025-09-09 15:55:33', '2025-09-09 15:55:33');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_promotions`
--

CREATE TABLE `candidate_promotions` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `exam_id` bigint UNSIGNED NOT NULL,
  `broadcast_type` enum('email','sms') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `centers`
--

CREATE TABLE `centers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seat_capacity` int DEFAULT NULL,
  `location` longtext COLLATE utf8mb4_unicode_ci,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `centers`
--

INSERT INTO `centers` (`id`, `name`, `seat_capacity`, `location`, `address`, `image`, `contact_phone`, `contact_email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Dhaka Exam Center', 100, 'Dhaka', '123/A, Gulshan-1, Dhaka 1212', NULL, '01712345678', 'dhaka.center@example.com', 1, '2025-09-09 15:53:33', '2025-09-09 15:53:33'),
(2, 'Chattogram Exam Center', 80, 'Chattogram', '456/B, Agrabad, Chattogram 4100', NULL, '01876543210', 'ctg.center@example.com', 1, '2025-09-09 15:53:33', '2025-09-09 15:53:33');

-- --------------------------------------------------------

--
-- Table structure for table `certificate_claims`
--

CREATE TABLE `certificate_claims` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `receiver_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `received_amount` decimal(15,2) DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','confirmed','rejected','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `delivery_status` enum('pending','delivered') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `delivery_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `claimed_format` enum('hard-copy','soft-copy','both') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'soft-copy',
  `delivery_date` datetime DEFAULT NULL,
  `confirmed_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','in_progress','resolved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `admin_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint UNSIGNED NOT NULL,
  `candidate_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` datetime DEFAULT NULL,
  `attachment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demo_questions`
--

CREATE TABLE `demo_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('pdf','audio') COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploaded_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `exam_date` date DEFAULT NULL,
  `application_deadline` date DEFAULT NULL,
  `fee` double NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result_publish_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `title`, `slug`, `description`, `exam_date`, `application_deadline`, `fee`, `image`, `result_publish_date`, `status`, `start_time`, `end_time`, `created_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Japan Yunus Test', 'general-knowledge-test', 'This exam tests general knowledge skills including current affairs, history, and reasoning.', '2025-08-10', '2025-08-01', 500, NULL, '2025-08-20', 1, '10:00:00', '12:00:00', 1, NULL, '2025-09-09 15:53:33', '2025-09-09 15:53:33'),
(2, 'Arigana Proficiency Exam', 'arigana-proficiency-exam', 'Assessment of grammar, vocabulary, comprehension and writing skills.', '2025-09-19', '2025-09-12', 800, NULL, '2025-10-11', 1, '14:00:00', '16:00:00', 1, NULL, '2025-09-09 15:53:33', '2025-09-09 15:54:22'),
(3, 'JPT Exam – February 22, 2025', 'jpt-exam-february-22-2025', 'JPT Exam – February 22, 2025 Description', '2025-09-16', '2025-09-09', 3500, NULL, NULL, 1, '09:00:00', '12:00:00', 1, NULL, '2025-09-09 15:55:12', '2025-09-09 15:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `position` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_processes`
--

CREATE TABLE `file_processes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `process_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','processing','success','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_processes`
--

INSERT INTO `file_processes` (`id`, `user_id`, `process_name`, `file_name`, `status`, `error_message`, `created_at`, `updated_at`) VALUES
(1, 1, 'booking_csv_import', 'candidate_list.csv', 'success', NULL, '2025-09-09 15:55:12', '2025-09-09 15:55:14'),
(2, 1, 'booking_csv_import', 'agent-data.csv', 'success', NULL, '2025-09-09 15:55:31', '2025-09-09 15:55:33');

-- --------------------------------------------------------

--
-- Table structure for table `integrations`
--

CREATE TABLE `integrations` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('sms','smtp','payment_gateway','storage','google','facebook','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `credentials` json DEFAULT NULL COMMENT 'store API keys, secrets, etc.',
  `options` json DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jpt_acceptors`
--

CREATE TABLE `jpt_acceptors` (
  `id` bigint UNSIGNED NOT NULL,
  `institute_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `institute_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'story -when and how jpt get accreditation from this institute',
  `address` text COLLATE utf8mb4_unicode_ci,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `accreditation_certificate` text COLLATE utf8mb4_unicode_ci COMMENT 'that can be image or pdf',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0000_0_01_000000_create_roles_table', 1),
(2, '0001_01_01_0000011_create_users_table', 1),
(3, '0001_01_01_000001_create_cache_table', 1),
(4, '0001_01_01_000002_create_jobs_table', 1),
(5, '2025_06_18_074055_create_modules_table', 1),
(6, '2025_06_18_074059_create_permission_table', 1),
(7, '2025_06_18_074139_create_role_permissions_table', 1),
(8, '2025_06_25_071703_create_candidates_table', 1),
(9, '2025_06_25_073723_create_personal_access_tokens_table', 1),
(10, '2025_07_01_041544_create_exams_table', 1),
(11, '2025_07_01_050811_create_sliders_table', 1),
(12, '2025_07_01_051418_create_centers_table', 1),
(13, '2025_07_01_051426_create_testimonials_table', 1),
(14, '2025_07_01_051723_create_faqs_table', 1),
(15, '2025_07_01_052845_create_bookings_table', 1),
(16, '2025_07_01_052852_create_payments_table', 1),
(17, '2025_07_01_061953_create_business_settings_table', 1),
(18, '2025_07_01_070948_create_blogs_table', 1),
(19, '2025_07_01_071611_create_jpt_acceptors_table', 1),
(20, '2025_07_01_073737_create_promotions_table', 1),
(21, '2025_07_01_112355_create_integrations_table', 1),
(22, '2025_07_01_114201_create_contact_us_table', 1),
(23, '2025_07_01_114358_create_newsletters_table', 1),
(24, '2025_07_21_120020_create_certificate_payments_table', 1),
(25, '2025_08_13_104211_create_news_table', 1),
(26, '2025_08_18_163950_create_notifications_table', 1),
(27, '2025_08_19_105911_create_conversations_table', 1),
(28, '2025_08_21_105331_create_demo_questions_table', 1),
(29, '2025_08_21_120340_add_column_to_bookings_table', 1),
(30, '2025_08_24_160702_create_candidate_promotions_table', 1),
(31, '2025_08_24_171405_create_file_processes_table', 1),
(32, '2025_08_26_174309_add_score_to_bookings_table', 1),
(33, '2025_09_02_105231_create_agents_table', 1),
(34, '2025_09_03_104410_create_mock_test_modules_table', 1),
(35, '2025_09_03_104555_create_mock_test_sections_table', 1),
(36, '2025_09_03_120240_create_mock_test_question_groups_table', 1),
(37, '2025_09_03_130830_create_mock_test_questions_table', 1),
(38, '2025_09_03_153752_create_mock_test_question_options_table', 1),
(39, '2025_09_09_112613_add_agent_id_and_commission_info_to_bookings_table', 1),
(40, '2025_09_09_112859_add_commission_percentage_to_agents_table', 1),
(42, '2025_09_15_131846_create_mock_test_records_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `mock_test_modules`
--

CREATE TABLE `mock_test_modules` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','disabled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mock_test_modules`
--

INSERT INTO `mock_test_modules` (`id`, `slug`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'listening', 'Listening', 'active', '2025-09-09 15:53:33', '2025-09-09 15:53:33'),
(2, 'reading', 'Reading', 'active', '2025-09-09 15:53:33', '2025-09-09 15:53:33');

-- --------------------------------------------------------

--
-- Table structure for table `mock_test_questions`
--

CREATE TABLE `mock_test_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'It can be text or image path.',
  `proficiency_level` enum('N4','N5') COLLATE utf8mb4_unicode_ci NOT NULL,
  `mock_test_section_id` bigint UNSIGNED NOT NULL,
  `mock_test_question_group_id` bigint UNSIGNED DEFAULT NULL,
  `type` enum('text','image') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mock_test_questions`
--

INSERT INTO `mock_test_questions` (`id`, `title`, `proficiency_level`, `mock_test_section_id`, `mock_test_question_group_id`, `type`, `created_at`, `updated_at`) VALUES
(15, 'https://media.kaicombd.com/uploads/questions/82adaf13-bb3f-4307-b913-678ae4181d02.png', 'N4', 1, 11, 'image', '2025-09-18 11:32:14', '2025-09-22 12:09:53'),
(16, 'dcdfcsdfcsdc', 'N4', 2, 12, 'text', '2025-09-18 11:33:46', '2025-09-22 11:38:24'),
(18, 'Magna voluptatem hic', 'N4', 1, 14, 'text', '2025-09-22 12:24:29', '2025-09-22 12:24:29'),
(19, 'Eveniet dolorum cup', 'N4', 1, 14, 'text', '2025-09-22 12:24:29', '2025-09-22 12:24:29'),
(20, 'https://media.kaicombd.com/uploads/questions/ce492d12-90d5-4aee-bad1-953b3823b580.png', 'N4', 6, 15, 'image', '2025-09-22 13:13:00', '2025-09-22 13:31:14'),
(21, 'Qui in anim consecte', 'N4', 6, 16, 'text', '2025-09-22 13:13:34', '2025-09-22 13:13:34'),
(22, 'Voluptate iusto cons', 'N4', 1, 17, 'text', '2025-09-22 13:20:54', '2025-09-22 13:20:54'),
(23, 'jigl voluptatem hic', 'N4', 1, 18, 'text', '2025-09-22 13:22:19', '2025-09-22 13:22:19'),
(24, '<p>vftgv <strong>erfd3</strong> erfce3rdf&nbsp; &nbsp;</p>', 'N4', 1, 18, 'text', '2025-09-22 13:22:20', '2025-09-22 13:29:24'),
(25, 'sadasdasd', 'N4', 1, 18, 'text', '2025-09-22 13:22:20', '2025-09-22 13:22:20'),
(26, 'dfgsdfg', 'N4', 1, 19, 'text', '2025-09-22 13:22:52', '2025-09-22 13:22:52'),
(27, 'https://media.kaicombd.com/uploads/questons/06232ad0-8d22-492e-936d-db81019e7041.jpeg', 'N4', 1, 19, 'image', '2025-09-22 13:22:53', '2025-09-22 13:22:53');

-- --------------------------------------------------------

--
-- Table structure for table `mock_test_question_groups`
--

CREATE TABLE `mock_test_question_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `mock_test_section_id` bigint UNSIGNED NOT NULL,
  `type` enum('single','multiple') COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_type` enum('passage','audio') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci COMMENT 'It can be passage or audio file path.',
  `question_quantity` int NOT NULL DEFAULT '1',
  `status` enum('active','disabled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mock_test_question_groups`
--

INSERT INTO `mock_test_question_groups` (`id`, `mock_test_section_id`, `type`, `group_type`, `content`, `question_quantity`, `status`, `created_at`, `updated_at`) VALUES
(11, 1, 'single', NULL, NULL, 1, 'active', '2025-09-18 11:32:11', '2025-09-18 11:32:11'),
(12, 2, 'single', NULL, NULL, 1, 'active', '2025-09-18 11:33:46', '2025-09-18 11:33:46'),
(13, 2, 'single', NULL, NULL, 1, 'active', '2025-09-21 17:49:39', '2025-09-21 17:49:39'),
(14, 1, 'multiple', 'passage', '<p>asddddddddddddcvdddd dfcddddddddddddd dsfasdssssssssssssssssssssssssss</p>', 2, 'active', '2025-09-22 12:24:29', '2025-09-22 12:24:29'),
(15, 6, 'single', NULL, NULL, 1, 'active', '2025-09-22 13:13:00', '2025-09-22 13:13:00'),
(16, 6, 'single', NULL, NULL, 1, 'active', '2025-09-22 13:13:34', '2025-09-22 13:13:34'),
(17, 1, 'single', NULL, NULL, 1, 'active', '2025-09-22 13:20:54', '2025-09-22 13:20:54'),
(18, 1, 'multiple', 'passage', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 3, 'active', '2025-09-22 13:22:19', '2025-09-22 13:22:19'),
(19, 1, 'multiple', 'passage', '<p>b xvghnsrth</p>', 2, 'active', '2025-09-22 13:22:52', '2025-09-22 13:22:52');

-- --------------------------------------------------------

--
-- Table structure for table `mock_test_question_options`
--

CREATE TABLE `mock_test_question_options` (
  `id` bigint UNSIGNED NOT NULL,
  `values` json NOT NULL,
  `mock_test_question_id` bigint UNSIGNED NOT NULL,
  `correct_answer_index` enum('1','2','3','4') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mock_test_question_options`
--

INSERT INTO `mock_test_question_options` (`id`, `values`, `mock_test_question_id`, `correct_answer_index`, `created_at`, `updated_at`) VALUES
(15, '\"{\\\"1\\\":\\\"aaaa\\\",\\\"2\\\":\\\"bbbb\\\",\\\"3\\\":\\\"cccc\\\",\\\"4\\\":\\\"dddd\\\"}\"', 15, '4', '2025-09-18 11:32:14', '2025-09-22 12:09:53'),
(16, '\"{\\\"3\\\":\\\"ertaert dcd\\\",\\\"4\\\":\\\"dethto gyht wdw\\\",\\\"5\\\":\\\"fASfsef\\\",\\\"6\\\":\\\"nberfv\\\"}\"', 16, '4', '2025-09-18 11:33:46', '2025-09-22 11:38:24'),
(18, '\"{\\\"1\\\":\\\"asdasd\\\",\\\"2\\\":\\\"dfgu\\\",\\\"3\\\":\\\"dfgs\\\",\\\"4\\\":\\\"asdasdss\\\"}\"', 18, '4', '2025-09-22 12:24:29', '2025-09-22 12:24:29'),
(19, '\"{\\\"1\\\":\\\"dfghdfv\\\",\\\"2\\\":\\\"Veritatis ea facilis\\\",\\\"3\\\":\\\"Amet fuga Iusto pe\\\",\\\"4\\\":\\\"Ut libero molestiae\\\"}\"', 19, '4', '2025-09-22 12:24:29', '2025-09-22 12:24:29'),
(20, '\"{\\\"1\\\":\\\"Aliqua Duis eligend\\\",\\\"2\\\":\\\"Non et nesciunt sin\\\",\\\"3\\\":\\\"Quibusdam commodo au\\\",\\\"4\\\":\\\"Dicta quaerat quidem\\\"}\"', 20, '1', '2025-09-22 13:13:00', '2025-09-22 13:13:00'),
(21, '\"{\\\"1\\\":\\\"Dolore quo dolor off\\\",\\\"2\\\":\\\"Fuga Et at totam in\\\",\\\"3\\\":\\\"Nihil et deleniti of\\\",\\\"4\\\":\\\"Necessitatibus labor\\\"}\"', 21, '2', '2025-09-22 13:13:34', '2025-09-22 13:13:34'),
(22, '\"{\\\"1\\\":\\\"sdf\\\",\\\"2\\\":\\\"dfgasd\\\",\\\"3\\\":\\\"sadsda\\\",\\\"4\\\":\\\"\\\\u30c6\\\\u30cb\\\\u30b9\\\"}\"', 22, '3', '2025-09-22 13:20:54', '2025-09-22 13:20:54'),
(23, '\"{\\\"1\\\":\\\"fgdf\\\",\\\"2\\\":\\\"fgh\\\",\\\"3\\\":\\\"fsese\\\",\\\"4\\\":\\\"fghfgfg\\\"}\"', 23, '3', '2025-09-22 13:22:19', '2025-09-22 13:22:19'),
(24, '\"{\\\"1\\\":\\\"a\\\",\\\"2\\\":\\\"b\\\",\\\"3\\\":\\\"c\\\",\\\"4\\\":\\\"d\\\"}\"', 24, '2', '2025-09-22 13:22:20', '2025-09-22 13:24:31'),
(25, '\"{\\\"1\\\":\\\"er\\\",\\\"2\\\":\\\"asd\\\",\\\"3\\\":\\\"xcz\\\",\\\"4\\\":\\\"dfg\\\"}\"', 25, '1', '2025-09-22 13:22:20', '2025-09-22 13:22:20'),
(26, '\"{\\\"1\\\":\\\"fg\\\",\\\"2\\\":\\\"dd\\\",\\\"3\\\":\\\"dfg\\\",\\\"4\\\":\\\"gfd\\\"}\"', 26, '1', '2025-09-22 13:22:52', '2025-09-22 13:22:52'),
(27, '\"{\\\"1\\\":\\\"dfg\\\",\\\"2\\\":\\\"fdd\\\",\\\"3\\\":\\\"dfg\\\",\\\"4\\\":\\\"fgdfg\\\"}\"', 27, '2', '2025-09-22 13:22:53', '2025-09-22 13:22:53');

-- --------------------------------------------------------

--
-- Table structure for table `mock_test_records`
--

CREATE TABLE `mock_test_records` (
  `id` bigint UNSIGNED NOT NULL,
  `candidate_id` bigint UNSIGNED NOT NULL,
  `question_set` int NOT NULL,
  `reading_answered` int NOT NULL DEFAULT '0',
  `correct_reading_answer` int NOT NULL DEFAULT '0',
  `wrong_reading_answer` int NOT NULL DEFAULT '0',
  `listening_answered` int NOT NULL DEFAULT '0',
  `correct_listening_answer` int NOT NULL DEFAULT '0',
  `wrong_listening_answer` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mock_test_records`
--

INSERT INTO `mock_test_records` (`id`, `candidate_id`, `question_set`, `reading_answered`, `correct_reading_answer`, `wrong_reading_answer`, `listening_answered`, `correct_listening_answer`, `wrong_listening_answer`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 1, 1, 3, 3, 0, '2025-09-16 15:20:15', '2025-09-16 15:20:15'),
(2, 1, 1, 2, 1, 1, 3, 3, 0, '2025-09-16 16:00:12', '2025-09-16 16:00:12');

-- --------------------------------------------------------

--
-- Table structure for table `mock_test_sections`
--

CREATE TABLE `mock_test_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `mock_test_module_id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sample_question` longtext COLLATE utf8mb4_unicode_ci,
  `status` enum('active','disabled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mock_test_sections`
--

INSERT INTO `mock_test_sections` (`id`, `mock_test_module_id`, `slug`, `title`, `sample_question`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'photo-description', 'Photo description', 'What is in the photo?\\nA) A dog\\nB) A cat\\nC) A bird\\nAnswer: A', 'active', '2025-09-09 15:53:33', '2025-09-09 15:53:33'),
(2, 1, 'questions-and-answers', 'Questions and Answers', 'What is the capital of France?\\nA) Berlin\\nB) Madrid\\nC) Paris\\nAnswer: C', 'active', '2025-09-09 15:53:33', '2025-09-09 15:53:33'),
(3, 1, 'dialogue', 'Dialogue', 'What did John say to Mary?\\nA) Hello\\nB) Goodbye\\nC) See you later\\nAnswer: A', 'active', '2025-09-09 15:53:33', '2025-09-09 15:53:33'),
(4, 1, 'explanatory-text', 'Explanatory text', 'Read the following passage and answer the question.\\n\"Paris is the capital of France. It is known for its iconic landmarks, like the Eiffel Tower.\"\\nWhat is the capital of France?\\nA) Paris\\nB) London\\nC) New York\\nAnswer: A', 'active', '2025-09-09 15:53:33', '2025-09-09 15:53:33'),
(5, 2, 'choose-correct-answer', 'Choose correct answer', 'fghfghfghfh', 'active', '2025-09-09 15:53:33', '2025-09-18 11:27:52'),
(6, 2, 'correct-wrong-sentences', 'Correct wrong sentences', 'Choose the correct sentence:\\nA) He don\'t like ice cream.\\nB) He doesn\'t like ice cream.\\nAnswer: B', 'active', '2025-09-09 15:53:33', '2025-09-09 15:53:33'),
(7, 2, 'fill-in-the-blanks', 'Fill in the blanks', 'Fill in the blank: The sun rises in the _____.\\nA) west\\nB) east\\nC) north\\nAnswer: B', 'active', '2025-09-09 15:53:33', '2025-09-09 15:53:33'),
(8, 2, 'reading-comprehension', 'Reading comprehension', 'Read the passage: \"The sun is a star. It provides light and warmth to the Earth.\" What does the sun do?\\nA) It is a planet\\nB) It provides light and warmth\\nC) It is cold\\nAnswer: B', 'active', '2025-09-09 15:53:33', '2025-09-09 15:53:33');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Role', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(2, 'users', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(3, 'Candidate', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(4, 'Exam', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(5, 'Business-Settings', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(6, 'FAQ', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(7, 'Center', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(8, 'booking', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(9, 'certificate-claim', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(10, 'payment', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(11, 'import', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(12, 'News', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(13, 'Testimonials', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(14, 'support', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(15, 'demo-questions', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(16, 'promotions', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(17, 'agents', 'active', '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(18, 'accountings', 'active', '2025-09-23 17:19:31', '2025-09-23 17:19:31'),
(19, 'mock-tests', 'active', '2025-09-23 17:19:31', '2025-09-23 17:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `author_name`, `author_designation`, `category_name`, `content`, `featured_image`, `meta_title`, `meta_description`, `meta_keywords`, `status`, `is_featured`, `published_at`, `deleted_at`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'Quis non voluptas ir', 'quis-non-voluptas-ir', 'Dylan Montoya', 'Irure fugiat volupt', 'Oliver Cummings', '<p>fdgvdf</p>', 'https://media.kaicombd.com/uploads/news/38648556-2681-4713-a00a-ce183c829295.jpg', 'Odit voluptatem aut', 'Qui elit dolor qui', 'Maiores consectetur', 'published', 1, '2025-06-19 18:11:00', NULL, '2025-09-16 11:58:35', '2025-09-16 12:01:43', 1),
(2, 'Ab ut omnis enim inc', 'ab-ut-omnis-enim-inc', 'Arthur Santiago', 'Ab voluptatem conseq', 'Reese Madden', NULL, 'https://media.kaicombd.com/uploads/news/9af0eb48-b33b-4d5f-a61b-1b4c86c6e694.jpeg', 'Occaecat suscipit ma', 'In velit eum nesciu', 'Sit consequatur par', 'published', 0, '2025-06-26 07:33:00', NULL, '2025-09-16 11:59:50', '2025-09-16 11:59:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('subscribed','unsubscribed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'subscribed',
  `subscribed_at` timestamp NULL DEFAULT NULL,
  `unsubscribed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('18e1f296-ceaa-42a4-a2d8-4de400c7bc42', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 12, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date: Arigana Proficiency Exam has been updated. Check your profile. \",\"url\":\"\"}', NULL, '2025-09-24 11:54:29', '2025-09-24 11:54:29'),
('1da2a303-5820-4ebe-ac47-990a5c06e8e0', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 9, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date: Arigana Proficiency Exam has been updated. Check your profile. \",\"url\":\"\"}', NULL, '2025-09-17 15:39:31', '2025-09-17 15:39:31'),
('1f319977-1d17-4c65-bfe7-bc082257fc8a', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 2, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date has been updated. Check your profile. \",\"url\":\"\"}', '2025-09-23 11:01:32', '2025-09-22 17:47:47', '2025-09-23 11:01:32'),
('1f8428a3-e614-45ae-9829-fef9279dd20a', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 2, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date has been updated. Check your profile. \",\"url\":\"\"}', '2025-09-23 11:01:33', '2025-09-22 17:47:41', '2025-09-23 11:01:33'),
('2123c43a-5d2d-4c65-aa82-e8f8fe673f68', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 2, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date has been updated. Check your profile. \",\"url\":\"\"}', '2025-09-23 11:01:33', '2025-09-22 17:44:38', '2025-09-23 11:01:33'),
('263adb09-7710-4826-b7e0-59029ab906c4', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 2, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date has been updated. Check your profile. \",\"url\":\"\"}', '2025-09-22 17:24:34', '2025-09-22 17:20:01', '2025-09-22 17:24:34'),
('44a7ada7-031f-4a2b-a8aa-ca8221d09cd3', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 2, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date has been updated. Check your profile. \",\"url\":\"\"}', '2025-09-23 11:01:31', '2025-09-22 17:49:15', '2025-09-23 11:01:31'),
('4836c543-81f7-4e74-8ac0-df04b7c846f6', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 15, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date: Arigana Proficiency Exam has been updated. Check your profile. \",\"url\":\"\"}', NULL, '2025-09-24 11:18:55', '2025-09-24 11:18:55'),
('5a499307-c090-47d4-a5b2-310f7ebed4a0', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 2, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date has been updated. Check your profile. \",\"url\":\"\"}', '2025-09-23 11:01:36', '2025-09-22 17:30:50', '2025-09-23 11:01:36'),
('647daad9-177e-4dc0-89ed-1beaaf2cc97d', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 2, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date has been updated. Check your profile. \",\"url\":\"\"}', '2025-09-23 11:01:36', '2025-09-22 17:24:44', '2025-09-23 11:01:36'),
('a8e3a0ef-4957-4754-a500-44fc4ec80c3d', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 2, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date has been updated. Check your profile. \",\"url\":\"\"}', '2025-09-22 17:24:38', '2025-09-22 17:19:49', '2025-09-22 17:24:38'),
('ad5e84d3-2be3-4bfa-8cfe-8734056b1506', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 15, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date: Arigana Proficiency Exam has been updated. Check your profile. \",\"url\":\"\"}', NULL, '2025-09-24 11:18:19', '2025-09-24 11:18:19'),
('b273af13-8992-4dd2-aa34-89794788ba74', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 15, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date: Arigana Proficiency Exam has been updated. Check your profile. \",\"url\":\"\"}', NULL, '2025-09-24 11:54:08', '2025-09-24 11:54:08'),
('cd13756f-24ae-4eb0-9245-0836b2c69b76', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 2, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date has been updated. Check your profile. \",\"url\":\"\"}', '2025-09-22 17:24:40', '2025-09-22 17:19:05', '2025-09-22 17:24:40'),
('f643ddc5-0121-4214-a6c5-8a66bd29f8fc', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 15, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date: Arigana Proficiency Exam has been updated. Check your profile. \",\"url\":\"\"}', NULL, '2025-09-24 11:53:49', '2025-09-24 11:53:49'),
('ffedb9d8-637a-4694-95e6-7818b0d6cd8b', 'App\\Notifications\\CandidateNotification', 'App\\Models\\Candidate', 2, '{\"title\":\"Booking Update !\",\"message\":\"Your booking of Exam Date has been updated. Check your profile. \",\"url\":\"\"}', '2025-09-23 11:01:40', '2025-09-22 17:33:40', '2025-09-23 11:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `type` enum('booking','certificate') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'booking',
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additionals` text COLLATE utf8mb4_unicode_ci COMMENT 'all details of each payment request',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `module_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `status`, `module_id`, `created_at`, `updated_at`) VALUES
(1, 'User Roles List', 'user.roles.list', 'active', 1, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(2, 'User Roles Create', 'user.roles.create', 'active', 1, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(3, 'User Roles Store', 'user.roles.store', 'active', 1, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(4, 'User Roles Edit', 'user.roles.edit', 'active', 1, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(5, 'User Roles Update', 'user.roles.update', 'active', 1, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(6, 'User Roles ToggleStatus', 'user.roles.toggleStatus', 'active', 1, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(7, 'Users List', 'users.list', 'active', 2, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(8, 'Users Create', 'users.create', 'active', 2, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(9, 'Users ToggleStatus', 'users.toggleStatus', 'active', 2, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(10, 'Users Store', 'users.store', 'active', 2, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(11, 'Users Edit', 'users.edit', 'active', 2, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(12, 'Users Profile', 'users.profile', 'active', 2, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(13, 'Users Update', 'users.update', 'active', 2, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(14, 'Users Destroy', 'users.destroy', 'active', 2, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(15, 'Candidate List', 'candidate.list', 'active', 3, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(16, 'Candidate Create', 'candidate.create', 'active', 3, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(17, 'Candidate Store', 'candidate.store', 'active', 3, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(18, 'Candidate Edit', 'candidate.edit', 'active', 3, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(19, 'Candidate Update', 'candidate.update', 'active', 3, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(20, 'Candidate Delete', 'candidate.delete', 'active', 3, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(21, 'Candidate ToggleStatus', 'candidate.toggleStatus', 'active', 3, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(22, 'Candidate Applications', 'candidate.applications', 'active', 3, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(23, 'Exam List', 'exam.list', 'active', 4, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(24, 'Exam Create', 'exam.create', 'active', 4, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(25, 'Exam Store', 'exam.store', 'active', 4, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(26, 'Exam Edit', 'exam.edit', 'active', 4, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(27, 'Exam Update', 'exam.update', 'active', 4, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(28, 'Exam ToggleStatus', 'exam.toggleStatus', 'active', 4, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(29, 'Business-settings Edit', 'business-settings.edit', 'active', 5, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(30, 'Business-settings General', 'business-settings.general', 'active', 5, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(31, 'Business-settings Legal', 'business-settings.legal', 'active', 5, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(32, 'Business-settings Social', 'business-settings.social', 'active', 5, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(33, 'Business-settings Policies', 'business-settings.policies', 'active', 5, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(34, 'Faq List', 'faq.list', 'active', 6, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(35, 'Faq Create', 'faq.create', 'active', 6, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(36, 'Faq Store', 'faq.store', 'active', 6, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(37, 'Faq Edit', 'faq.edit', 'active', 6, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(38, 'Faq Update', 'faq.update', 'active', 6, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(39, 'Faq ToggleStatus', 'faq.toggleStatus', 'active', 6, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(40, 'Faq Delete', 'faq.delete', 'active', 6, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(41, 'Center List', 'center.list', 'active', 7, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(42, 'Center Create', 'center.create', 'active', 7, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(43, 'Center Store', 'center.store', 'active', 7, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(44, 'Center Edit', 'center.edit', 'active', 7, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(45, 'Center Update', 'center.update', 'active', 7, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(46, 'Center ToggleStatus', 'center.toggleStatus', 'active', 7, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(47, 'Booking List', 'booking.list', 'active', 8, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(48, 'Booking View', 'booking.view', 'active', 8, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(49, 'Booking Edit', 'booking.edit', 'active', 8, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(50, 'Booking Import', 'booking.import', 'active', 8, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(51, 'Booking Update', 'booking.update', 'active', 8, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(52, 'Booking Export Csv', 'booking.export.csv', 'active', 8, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(53, 'Booking Export Image', 'booking.export.image', 'active', 8, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(54, 'Booking Import Csv', 'booking.import.csv', 'active', 8, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(55, 'Booking Payment Store', 'booking.payment.store', 'active', 8, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(56, 'Certificate-claim List', 'certificate-claim.list', 'active', 9, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(57, 'Certificate-claim Edit', 'certificate-claim.edit', 'active', 9, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(58, 'Certificate-claim Update', 'certificate-claim.update', 'active', 9, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(59, 'Payment List', 'payment.list', 'active', 10, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(60, 'Import Show', 'import.show', 'active', 11, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(61, 'Import Examinee Csv View', 'import.examinee.csv.view', 'active', 11, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(62, 'Import Examinee Csv Post', 'import.examinee.csv.post', 'active', 11, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(63, 'Import Result Csv', 'import.result.csv', 'active', 11, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(64, 'Import Post Result Csv', 'import.post.result.csv', 'active', 11, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(65, 'Import Upload', 'import.upload', 'active', 11, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(66, 'News List', 'news.list', 'active', 12, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(67, 'News Create', 'news.create', 'active', 12, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(68, 'News Store', 'news.store', 'active', 12, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(69, 'News Edit', 'news.edit', 'active', 12, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(70, 'News Update', 'news.update', 'active', 12, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(71, 'News Delete', 'news.delete', 'active', 12, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(72, 'News ToggleStatus', 'news.toggleStatus', 'active', 12, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(73, 'Testimonials List', 'testimonials.list', 'active', 13, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(74, 'Testimonials Create', 'testimonials.create', 'active', 13, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(75, 'Testimonials Store', 'testimonials.store', 'active', 13, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(76, 'Testimonials Edit', 'testimonials.edit', 'active', 13, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(77, 'Testimonials Delete', 'testimonials.delete', 'active', 13, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(78, 'Testimonials Update', 'testimonials.update', 'active', 13, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(79, 'Testimonials ToggleStatus', 'testimonials.toggleStatus', 'active', 13, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(80, 'Support List', 'support.list', 'active', 14, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(81, 'Support View', 'support.view', 'active', 14, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(82, 'Support Send Messages', 'support.send.messages', 'active', 14, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(83, 'Demo-questions List', 'demo-questions.list', 'active', 15, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(84, 'Demo-questions Create', 'demo-questions.create', 'active', 15, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(85, 'Demo-questions Store', 'demo-questions.store', 'active', 15, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(86, 'Demo-questions ToggleStatus', 'demo-questions.toggleStatus', 'active', 15, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(87, 'Demo-questions Delete', 'demo-questions.delete', 'active', 15, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(88, 'Promotions List', 'promotions.list', 'active', 16, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(89, 'Promotions Create', 'promotions.create', 'active', 16, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(90, 'Promotions Store', 'promotions.store', 'active', 16, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(91, 'Promotions Copy', 'promotions.copy', 'active', 16, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(92, 'Agents List', 'agents.list', 'active', 17, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(93, 'Agents Create', 'agents.create', 'active', 17, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(94, 'Agents Store', 'agents.store', 'active', 17, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(95, 'Agents Edit', 'agents.edit', 'active', 17, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(96, 'Agents Update', 'agents.update', 'active', 17, '2025-09-23 17:19:30', '2025-09-23 17:19:30'),
(97, 'Agents ToggleStatus', 'agents.toggleStatus', 'active', 17, '2025-09-23 17:19:31', '2025-09-23 17:19:31'),
(98, 'Accountings Index', 'accountings.index', 'active', 18, '2025-09-23 17:19:31', '2025-09-23 17:19:31'),
(99, 'Accountings Calculate', 'accountings.calculate', 'active', 18, '2025-09-23 17:19:31', '2025-09-23 17:19:31'),
(100, 'Mock-tests Question List', 'mock-tests.question.list', 'active', 19, '2025-09-23 17:19:31', '2025-09-23 17:19:31'),
(101, 'Mock-tests Module-section Info', 'mock-tests.module-section.info', 'active', 19, '2025-09-23 17:19:31', '2025-09-23 17:19:31'),
(102, 'Mock-tests Question-setup Form', 'mock-tests.question-setup.form', 'active', 19, '2025-09-23 17:19:31', '2025-09-23 17:19:31'),
(103, 'Mock-tests Question-setup Post', 'mock-tests.question-setup.post', 'active', 19, '2025-09-23 17:19:31', '2025-09-23 17:19:31'),
(104, 'Mock-tests Section Edit', 'mock-tests.section.edit', 'active', 19, '2025-09-23 17:19:31', '2025-09-23 17:19:31'),
(105, 'Mock-tests Section Update', 'mock-tests.section.update', 'active', 19, '2025-09-23 17:19:31', '2025-09-23 17:19:31'),
(106, 'Mock-tests Edit Question', 'mock-tests.edit.question', 'active', 19, '2025-09-23 17:19:31', '2025-09-23 17:19:31'),
(107, 'Mock-tests Question Update', 'mock-tests.question.update', 'active', 19, '2025-09-23 17:19:31', '2025-09-23 17:19:31'),
(108, 'Mock-tests Question Delete', 'mock-tests.question.delete', 'active', 19, '2025-09-23 17:19:31', '2025-09-23 17:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` bigint UNSIGNED DEFAULT NULL,
  `template_id` bigint UNSIGNED NOT NULL,
  `send_to` enum('targets','groups') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'groups',
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `status` enum('draft','scheduled','sent','now') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotion_groups`
--

CREATE TABLE `promotion_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotion_group_candidates`
--

CREATE TABLE `promotion_group_candidates` (
  `id` bigint UNSIGNED NOT NULL,
  `group_id` bigint UNSIGNED NOT NULL,
  `candidate_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotion_logs`
--

CREATE TABLE `promotion_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `promotion_id` bigint UNSIGNED NOT NULL,
  `candidate_id` bigint UNSIGNED DEFAULT NULL,
  `channel` enum('email','sms') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','sent','failed','bounced') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `response` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotion_targets`
--

CREATE TABLE `promotion_targets` (
  `id` bigint UNSIGNED NOT NULL,
  `promotion_id` bigint UNSIGNED NOT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotion_templates`
--

CREATE TABLE `promotion_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('email','sms') COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Super-Admin', 'super-admin', 'active', '2025-09-09 15:53:32', '2025-09-09 15:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_button_enable` tinyint(1) NOT NULL DEFAULT '0',
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slider_text` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `position` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `candidate_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `candidate_designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `candidate_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `position` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','freeze') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `failed_attempt_count` int NOT NULL DEFAULT '0',
  `last_login_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role_id`, `email`, `email_verified_at`, `password`, `image`, `status`, `failed_attempt_count`, `last_login_ip`, `last_login`, `created_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 1, 'admin@example.com', NULL, '$2y$12$3dGF0Lyxi7Md5InpVE.ySOmGjgZFiaMd43lEXRWyqmxBJI577p17O', NULL, 'active', 0, NULL, '2025-09-24 10:32:31', NULL, NULL, '2025-09-09 15:53:32', '2025-09-24 10:32:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `agents_email_unique` (`email`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`),
  ADD KEY `blogs_created_by_foreign` (`created_by`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_examinee_number_unique` (`examinee_number`),
  ADD KEY `bookings_candidate_id_foreign` (`candidate_id`),
  ADD KEY `bookings_exam_id_foreign` (`exam_id`),
  ADD KEY `bookings_center_id_foreign` (`center_id`),
  ADD KEY `bookings_agent_id_foreign` (`agent_id`);

--
-- Indexes for table `business_settings`
--
ALTER TABLE `business_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `candidates_email_unique` (`email`);

--
-- Indexes for table `candidate_promotions`
--
ALTER TABLE `candidate_promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_promotions_exam_id_foreign` (`exam_id`);

--
-- Indexes for table `centers`
--
ALTER TABLE `centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificate_claims`
--
ALTER TABLE `certificate_claims`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certificate_claims_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversations_user_id_foreign` (`user_id`),
  ADD KEY `conversations_candidate_id_user_id_index` (`candidate_id`,`user_id`);

--
-- Indexes for table `demo_questions`
--
ALTER TABLE `demo_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exams_slug_unique` (`slug`),
  ADD KEY `exams_created_by_foreign` (`created_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_processes`
--
ALTER TABLE `file_processes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `integrations`
--
ALTER TABLE `integrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `integrations_slug_unique` (`slug`),
  ADD KEY `integrations_created_by_foreign` (`created_by`),
  ADD KEY `integrations_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jpt_acceptors`
--
ALTER TABLE `jpt_acceptors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mock_test_modules`
--
ALTER TABLE `mock_test_modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mock_test_modules_slug_unique` (`slug`);

--
-- Indexes for table `mock_test_questions`
--
ALTER TABLE `mock_test_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mock_test_questions_mock_test_section_id_foreign` (`mock_test_section_id`),
  ADD KEY `mock_test_questions_mock_test_question_group_id_foreign` (`mock_test_question_group_id`);

--
-- Indexes for table `mock_test_question_groups`
--
ALTER TABLE `mock_test_question_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mock_test_question_groups_mock_test_section_id_foreign` (`mock_test_section_id`);

--
-- Indexes for table `mock_test_question_options`
--
ALTER TABLE `mock_test_question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mock_test_question_options_mock_test_question_id_foreign` (`mock_test_question_id`);

--
-- Indexes for table `mock_test_records`
--
ALTER TABLE `mock_test_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mock_test_records_candidate_id_foreign` (`candidate_id`);

--
-- Indexes for table `mock_test_sections`
--
ALTER TABLE `mock_test_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mock_test_sections_slug_unique` (`slug`),
  ADD KEY `mock_test_sections_mock_test_module_id_foreign` (`mock_test_module_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`),
  ADD KEY `news_created_by_foreign` (`created_by`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `newsletters_email_unique` (`email`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`),
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`),
  ADD KEY `permissions_module_id_foreign` (`module_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotions_group_id_foreign` (`group_id`),
  ADD KEY `promotions_template_id_foreign` (`template_id`);

--
-- Indexes for table `promotion_groups`
--
ALTER TABLE `promotion_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotion_group_candidates`
--
ALTER TABLE `promotion_group_candidates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promotion_group_candidates_group_id_candidate_id_unique` (`group_id`,`candidate_id`),
  ADD KEY `promotion_group_candidates_candidate_id_foreign` (`candidate_id`);

--
-- Indexes for table `promotion_logs`
--
ALTER TABLE `promotion_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotion_logs_promotion_id_foreign` (`promotion_id`),
  ADD KEY `promotion_logs_candidate_id_foreign` (`candidate_id`),
  ADD KEY `promotion_logs_status_index` (`status`);

--
-- Indexes for table `promotion_targets`
--
ALTER TABLE `promotion_targets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotion_targets_promotion_id_foreign` (`promotion_id`);

--
-- Indexes for table `promotion_templates`
--
ALTER TABLE `promotion_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_permissions_role_id_foreign` (`role_id`),
  ADD KEY `role_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `business_settings`
--
ALTER TABLE `business_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `candidate_promotions`
--
ALTER TABLE `candidate_promotions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `centers`
--
ALTER TABLE `centers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `certificate_claims`
--
ALTER TABLE `certificate_claims`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demo_questions`
--
ALTER TABLE `demo_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_processes`
--
ALTER TABLE `file_processes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `integrations`
--
ALTER TABLE `integrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `jpt_acceptors`
--
ALTER TABLE `jpt_acceptors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `mock_test_modules`
--
ALTER TABLE `mock_test_modules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mock_test_questions`
--
ALTER TABLE `mock_test_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `mock_test_question_groups`
--
ALTER TABLE `mock_test_question_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `mock_test_question_options`
--
ALTER TABLE `mock_test_question_options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `mock_test_records`
--
ALTER TABLE `mock_test_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mock_test_sections`
--
ALTER TABLE `mock_test_sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotion_groups`
--
ALTER TABLE `promotion_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotion_group_candidates`
--
ALTER TABLE `promotion_group_candidates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotion_logs`
--
ALTER TABLE `promotion_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotion_targets`
--
ALTER TABLE `promotion_targets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotion_templates`
--
ALTER TABLE `promotion_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`),
  ADD CONSTRAINT `bookings_center_id_foreign` FOREIGN KEY (`center_id`) REFERENCES `centers` (`id`),
  ADD CONSTRAINT `bookings_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`);

--
-- Constraints for table `candidate_promotions`
--
ALTER TABLE `candidate_promotions`
  ADD CONSTRAINT `candidate_promotions_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certificate_claims`
--
ALTER TABLE `certificate_claims`
  ADD CONSTRAINT `certificate_claims_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `integrations`
--
ALTER TABLE `integrations`
  ADD CONSTRAINT `integrations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `integrations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `mock_test_questions`
--
ALTER TABLE `mock_test_questions`
  ADD CONSTRAINT `mock_test_questions_mock_test_question_group_id_foreign` FOREIGN KEY (`mock_test_question_group_id`) REFERENCES `mock_test_question_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mock_test_questions_mock_test_section_id_foreign` FOREIGN KEY (`mock_test_section_id`) REFERENCES `mock_test_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mock_test_question_groups`
--
ALTER TABLE `mock_test_question_groups`
  ADD CONSTRAINT `mock_test_question_groups_mock_test_section_id_foreign` FOREIGN KEY (`mock_test_section_id`) REFERENCES `mock_test_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mock_test_question_options`
--
ALTER TABLE `mock_test_question_options`
  ADD CONSTRAINT `mock_test_question_options_mock_test_question_id_foreign` FOREIGN KEY (`mock_test_question_id`) REFERENCES `mock_test_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mock_test_records`
--
ALTER TABLE `mock_test_records`
  ADD CONSTRAINT `mock_test_records_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mock_test_sections`
--
ALTER TABLE `mock_test_sections`
  ADD CONSTRAINT `mock_test_sections_mock_test_module_id_foreign` FOREIGN KEY (`mock_test_module_id`) REFERENCES `mock_test_modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `promotions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `promotion_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotions_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `promotion_templates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promotion_group_candidates`
--
ALTER TABLE `promotion_group_candidates`
  ADD CONSTRAINT `promotion_group_candidates_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotion_group_candidates_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `promotion_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promotion_logs`
--
ALTER TABLE `promotion_logs`
  ADD CONSTRAINT `promotion_logs_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotion_logs_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promotion_targets`
--
ALTER TABLE `promotion_targets`
  ADD CONSTRAINT `promotion_targets_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
