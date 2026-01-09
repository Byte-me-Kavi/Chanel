-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2026 at 02:15 PM
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
-- Database: `chanel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-5b9ba20ff43a4f453378625d67263e3a', 'i:1;', 1767541034),
('laravel-cache-5b9ba20ff43a4f453378625d67263e3a:timer', 'i:1767541034;', 1767541034),
('laravel-cache-82a0f73f9ffa16cf310a19a2bd5da29e', 'i:1;', 1767548126),
('laravel-cache-82a0f73f9ffa16cf310a19a2bd5da29e:timer', 'i:1767548126;', 1767548126),
('laravel-cache-8678e306ffa7945bdbfbdb16e55aa1bb', 'i:1;', 1767548265),
('laravel-cache-8678e306ffa7945bdbfbdb16e55aa1bb:timer', 'i:1767548265;', 1767548265),
('laravel-cache-admin@chanel.comom|127.0.0.1', 'i:1;', 1767548126),
('laravel-cache-admin@chanel.comom|127.0.0.1:timer', 'i:1767548126;', 1767548126);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `employee_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `name`, `employee_id`) VALUES
(1, 'Leslie Alexander', 'EMP-3321');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` int(11) NOT NULL,
  `order_number` varchar(100) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_category` varchar(255) DEFAULT NULL,
  `delivery_code` varchar(100) DEFAULT NULL,
  `courier_id` int(11) DEFAULT NULL,
  `status` enum('On Progress','Successful','On Hold','Canceled','Refunded') DEFAULT 'On Progress',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`id`, `order_number`, `item_name`, `item_category`, `delivery_code`, `courier_id`, `status`, `created_at`, `customer_name`, `address`, `product`, `quantity`) VALUES
(7, 'ORD-1758303013-2576', '', NULL, NULL, NULL, 'Canceled', '2025-09-19 17:30:13', 'razik', 'sigiriya', 'Chanel Perfume', 1),
(11, 'ORD-1758303536', '', NULL, NULL, NULL, 'Refunded', '2025-09-19 17:38:56', 'sha', 'hirassagala', 'chanel', 1),
(16, 'ORD-1758304194', '', NULL, NULL, NULL, 'On Hold', '2025-09-19 17:49:54', 'Shabeena', '408/16/5 Hirrasagala Bowalawaththa Kandy', 'Chanel Perfume', 1),
(17, 'ORD-1758304207', '', NULL, NULL, NULL, 'Canceled', '2025-09-19 17:50:07', 'Shabeena', '408/16/5 Hirrasagala Bowalawaththa Kandy', 'Chanel Perfume', 1),
(19, 'ORD-1758347646', '', NULL, NULL, NULL, 'Successful', '2025-09-20 05:54:06', 'Teena', '67/34/9, Kandy', 'Chanel Perfume', 4),
(21, 'ORD-1758465918', '', NULL, NULL, NULL, 'Refunded', '2025-09-21 14:45:18', 'Leo', '408/16/5 Hirrasagala Bowalawaththa Kandy', 'CHANCE EAU TENDRE', 8);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_checkpoints`
--

CREATE TABLE `delivery_checkpoints` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `actual_condition` varchar(255) DEFAULT NULL,
  `delivery_start` date DEFAULT NULL,
  `expected_ends` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `lat` decimal(10,8) DEFAULT NULL,
  `lng` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(1, '2026_01_04_000001_add_jetstream_columns_to_users_table', 1),
(2, '0001_01_01_000000_create_users_table', 2),
(3, '0001_01_01_000001_create_cache_table', 2),
(4, '0001_01_01_000002_create_jobs_table', 2),
(5, '2026_01_04_144013_add_two_factor_columns_to_users_table', 3),
(6, '2026_01_04_144112_create_personal_access_tokens_table', 3),
(7, '2026_01_04_220000_add_user_id_to_orders_table', 4),
(8, '2026_01_04_223000_create_wishlists_table', 5),
(10, '2026_01_04_230000_add_role_to_users_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`, `created_at`) VALUES
(1, 'shabeenaifthi2020@gmail.com', '2025-09-14 16:41:41'),
(2, 'shabeenaifthi2020@gmail.com', '2025-09-18 15:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'Order Placed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `wrapping_option` varchar(255) DEFAULT NULL,
  `gift_message` text DEFAULT NULL,
  `samples` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_name`, `price`, `image`, `order_status`, `created_at`, `order_date`, `wrapping_option`, `gift_message`, `samples`, `status`, `quantity`) VALUES
(1, NULL, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:42:01', NULL, NULL, NULL, 'Pending', 1),
(2, NULL, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:42:01', NULL, NULL, NULL, 'Pending', 1),
(3, NULL, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:42:01', NULL, NULL, NULL, 'Pending', 1),
(4, NULL, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:42:01', NULL, NULL, NULL, 'Pending', 1),
(5, NULL, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:42:16', NULL, NULL, NULL, 'Pending', 1),
(6, NULL, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:45:58', NULL, NULL, NULL, 'Pending', 1),
(7, NULL, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:48:12', NULL, NULL, NULL, 'Pending', 1),
(8, NULL, 'LE BLANC', 120.00, '/Website/img/bla.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:48:31', NULL, NULL, NULL, 'Pending', 1),
(9, NULL, 'L’HUILE ROSE', 120.00, '/Website/img/rose.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:48:31', NULL, NULL, NULL, 'Pending', 1),
(10, NULL, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:54:52', NULL, NULL, NULL, 'Pending', 1),
(11, NULL, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:54:52', NULL, NULL, NULL, 'Pending', 1),
(12, NULL, 'L’Huile Vanille', 120.00, '/Website/img/vani.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:54:52', NULL, NULL, NULL, 'Pending', 1),
(13, NULL, 'Sublimage Le Masque', 120.00, '/Website/img/sub.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:58:05', NULL, NULL, NULL, 'Pending', 1),
(14, NULL, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:58:05', NULL, NULL, NULL, 'Pending', 1),
(15, NULL, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:58:05', NULL, NULL, NULL, 'Pending', 1),
(16, NULL, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:01:31', NULL, NULL, NULL, 'Pending', 1),
(17, NULL, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:01:31', NULL, NULL, NULL, 'Pending', 1),
(18, NULL, 'L’Huile Vanille', 120.00, '/Website/img/vani.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:01:31', NULL, NULL, NULL, 'Pending', 1),
(19, NULL, 'LE BLANC', 120.00, '/Website/img/bla.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:01:31', NULL, NULL, NULL, 'Pending', 1),
(20, NULL, 'L’HUILE ORIENT', 120.00, '/Website/img/ori.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:02:06', NULL, NULL, NULL, 'Pending', 1),
(21, NULL, 'ALLURE SENSUELLE', 190.00, '/Website/img/sen.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:07:32', NULL, NULL, NULL, 'Pending', 1),
(22, NULL, 'N°5 EAU PREMIÈRE', 120.00, '/Website/img/pre.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:07:32', NULL, NULL, NULL, 'Pending', 1),
(23, NULL, 'N°5 EAU PREMIÈRE', 120.00, '/Website/img/pre.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:11:54', NULL, NULL, NULL, 'Pending', 1),
(24, NULL, 'LE VERNIS - 403 - GOLDEN MERMAID', 120.00, '/Website/img/le1.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:11:54', NULL, NULL, NULL, 'Pending', 1),
(25, NULL, 'LE VERNIS - 403 - GOLDEN MERMAID', 120.00, '/Website/img/le1.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:12:12', NULL, NULL, NULL, 'Pending', 1),
(26, NULL, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:13:07', NULL, NULL, NULL, 'Pending', 1),
(27, NULL, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:13:07', NULL, NULL, NULL, 'Pending', 1),
(28, NULL, 'POUR MONSIEUR', 87.00, '/Website/img/pour.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:13:39', NULL, NULL, NULL, 'Pending', 1),
(29, NULL, 'ALLURE HOMME SPORT', 95.00, '/Website/img/homme.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:18:11', NULL, NULL, NULL, 'Pending', 1),
(30, NULL, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 07:14:03', NULL, NULL, NULL, 'Pending', 1),
(31, NULL, 'LE LIFT LOTION', 120.00, '/Website/img/lift.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 08:04:07', NULL, NULL, NULL, 'Pending', 1),
(32, NULL, 'Sublimage Le Masque', 120.00, '/Website/img/sub.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 08:04:50', NULL, NULL, NULL, 'Pending', 1),
(33, NULL, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:01:38', 'The Essential', '', 'CHANCE EAU SPLENDIDE, COCO MADEMOISELLE', 'Pending', 1),
(34, NULL, 'POUR MONSIEUR', 87.00, '/Website/img/pour.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:01:38', 'The Essential', '', 'CHANCE EAU SPLENDIDE, COCO MADEMOISELLE', 'Pending', 1),
(35, NULL, 'ALLURE HOMME SPORT', 95.00, '/Website/img/homme.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:02:16', NULL, NULL, NULL, 'Pending', 1),
(36, NULL, 'POUR MONSIEUR', 87.00, '/Website/img/pour.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:02:16', NULL, NULL, NULL, 'Pending', 1),
(37, NULL, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:04:22', NULL, NULL, NULL, 'Pending', 1),
(38, NULL, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:07:33', NULL, NULL, NULL, 'Pending', 1),
(39, NULL, 'POUR MONSIEUR', 87.00, '/Website/img/pour.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:09:01', NULL, NULL, NULL, 'Pending', 1),
(40, NULL, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:09:01', NULL, NULL, NULL, 'Pending', 1),
(41, NULL, 'ALLURE HOMME SPORT', 95.00, '/Website/img/homme.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:09:01', NULL, NULL, NULL, 'Pending', 1),
(42, NULL, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:09:01', NULL, NULL, NULL, 'Pending', 1),
(43, NULL, 'HUILE DE JASMIN', 120.00, '/Website/img/jas.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:09:01', NULL, NULL, NULL, 'Pending', 1),
(44, NULL, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:23:37', NULL, NULL, NULL, 'Pending', 1),
(45, NULL, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:23:37', NULL, NULL, NULL, 'Pending', 1),
(46, NULL, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:23:37', NULL, NULL, NULL, 'Pending', 1),
(47, NULL, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 10:31:59', NULL, NULL, NULL, 'Pending', 1),
(48, NULL, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:12:37', NULL, NULL, NULL, 'Pending', 1),
(49, NULL, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:12:37', NULL, NULL, NULL, 'Pending', 1),
(50, NULL, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:12:37', NULL, NULL, NULL, 'Pending', 1),
(51, NULL, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:12:37', NULL, NULL, NULL, 'Pending', 1),
(52, NULL, 'L’HUILE ORIENT', 120.00, '/Website/img/ori.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:12:37', NULL, NULL, NULL, 'Pending', 1),
(53, NULL, 'N°5 EAU PREMIÈRE', 120.00, '/Website/img/pre.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:19:16', NULL, NULL, NULL, 'Pending', 1),
(54, NULL, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:19:16', NULL, NULL, NULL, 'Pending', 1),
(55, NULL, 'Sublimage Le Masque', 120.00, '/Website/img/sub.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:19:16', NULL, NULL, NULL, 'Pending', 1),
(56, NULL, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:19:16', NULL, NULL, NULL, 'Pending', 1),
(57, NULL, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:19:16', NULL, NULL, NULL, 'Pending', 1),
(58, NULL, 'LE BLANC', 120.00, '/Website/img/bla.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:19:16', NULL, NULL, NULL, 'Pending', 1),
(59, NULL, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:19:42', NULL, NULL, NULL, 'Pending', 1),
(60, NULL, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:20:20', NULL, NULL, NULL, 'Pending', 1),
(61, NULL, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:24:42', NULL, NULL, NULL, 'Pending', 1),
(62, NULL, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:25:07', NULL, NULL, NULL, 'Pending', 1),
(63, NULL, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:25:07', NULL, NULL, NULL, 'Pending', 1),
(64, NULL, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:33:56', NULL, NULL, NULL, 'Pending', 1),
(65, NULL, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:33:56', NULL, NULL, NULL, 'Pending', 1),
(66, NULL, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-19 03:45:24', '2025-09-19 03:45:24', NULL, NULL, NULL, 'Pending', 1),
(67, NULL, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-19 03:45:25', '2025-09-19 03:45:25', NULL, NULL, NULL, 'Pending', 1),
(68, NULL, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-19 03:45:52', '2025-09-19 03:45:52', NULL, NULL, NULL, 'Pending', 1),
(69, NULL, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-19 06:29:32', '2025-09-19 06:29:32', NULL, NULL, NULL, 'Pending', 1),
(70, NULL, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-19 06:29:32', '2025-09-19 06:29:32', NULL, NULL, NULL, 'Pending', 1),
(71, NULL, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-19 06:29:32', '2025-09-19 06:29:32', NULL, NULL, NULL, 'Pending', 1),
(72, NULL, 'ALLURE HOMME SPORT', 95.00, '/Website/img/homme.webp', 'Order Placed', '2025-09-19 06:29:32', '2025-09-19 06:29:32', NULL, NULL, NULL, 'Pending', 1),
(73, NULL, 'Classic Handbag', 1250.50, 'uploads/handbag.jpg', 'Completed', '2025-09-19 07:23:34', '2025-09-19 07:23:34', 'Signature', 'Happy Birthday!', 'Sample A', 'active', 1),
(74, NULL, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-20 06:02:55', '2025-09-20 06:02:55', NULL, NULL, NULL, 'Pending', 1),
(75, NULL, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-20 06:02:55', '2025-09-20 06:02:55', NULL, NULL, NULL, 'Pending', 1),
(76, NULL, 'HUILE DE JASMIN', 120.00, '/Website/img/jas.webp', 'Order Placed', '2025-09-20 06:02:55', '2025-09-20 06:02:55', NULL, NULL, NULL, 'Pending', 1),
(77, NULL, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-20 06:49:18', '2025-09-20 06:49:18', NULL, NULL, NULL, 'Pending', 1),
(78, NULL, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-20 06:49:18', '2025-09-20 06:49:18', NULL, NULL, NULL, 'Pending', 1),
(79, NULL, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-20 06:51:51', '2025-09-20 06:51:51', NULL, NULL, NULL, 'Pending', 1),
(80, NULL, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-20 06:51:51', '2025-09-20 06:51:51', NULL, NULL, NULL, 'Pending', 1),
(81, NULL, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-21 14:49:22', '2025-09-21 14:49:22', NULL, NULL, NULL, 'Pending', 1),
(82, NULL, 'ALLURE SENSUELLE', 190.00, '/Website/img/sen.webp', 'Order Placed', '2025-09-21 14:49:22', '2025-09-21 14:49:22', NULL, NULL, NULL, 'Pending', 1),
(83, NULL, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-21 14:49:22', '2025-09-21 14:49:22', NULL, NULL, NULL, 'Pending', 1),
(84, NULL, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-21 16:39:52', '2025-09-21 16:39:52', NULL, NULL, NULL, 'Pending', 1),
(85, NULL, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-21 16:39:52', '2025-09-21 16:39:52', NULL, NULL, NULL, 'Pending', 1),
(86, NULL, 'HUILE DE JASMIN', 230.00, '/Website/img/jas.webp', 'Order Placed', '2025-09-21 16:39:52', '2025-09-21 16:39:52', NULL, NULL, NULL, 'Pending', 1),
(87, NULL, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-22 04:10:29', '2025-09-22 04:10:29', NULL, NULL, NULL, 'Pending', 1),
(88, NULL, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-22 04:10:29', '2025-09-22 04:10:29', NULL, NULL, NULL, 'Pending', 1),
(89, NULL, 'L’Huile Vanille', 120.00, '/Website/img/vani.webp', 'Order Placed', '2025-09-22 04:10:29', '2025-09-22 04:10:29', NULL, NULL, NULL, 'Pending', 1),
(90, NULL, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2026-01-04 13:10:48', '2026-01-04 13:10:48', NULL, NULL, NULL, 'Pending', 1),
(91, NULL, 'chanel', 67.00, 'uploads/chance.webp', 'Order Placed', '2026-01-04 16:16:17', '2026-01-04 16:16:17', 'The Essential', '', NULL, 'Pending', 1),
(92, NULL, 'ALLURE HOMME SPORT', 987.00, 'uploads/neww6.webp', 'Order Placed', '2026-01-04 16:16:17', '2026-01-04 16:16:17', 'The Essential', '', NULL, 'Pending', 1),
(93, NULL, 'ALLURE HOMME SPORT', 987.00, 'uploads/neww6.webp', 'Order Placed', '2026-01-04 16:16:57', '2026-01-04 16:16:57', 'The Essential', '', NULL, 'Pending', 1),
(94, 17, 'chanel', 67.00, 'uploads/chance.webp', 'Order Placed', '2026-01-04 16:51:08', '2026-01-04 16:51:08', 'The Essential', '', NULL, 'Pending', 1),
(95, 18, 'chanel', 67.00, 'uploads/chance.webp', 'Order Placed', '2026-01-04 17:33:51', '2026-01-04 17:33:51', 'The Essential', '', NULL, 'Pending', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `image_url`, `created_at`) VALUES
(1, 'Chance', 'New Hair Mist', 'uploads/1758347744_chance_eau_tendre.webp', 82.00, '', '2025-09-20 05:55:44'),
(19, 'chanel', 'New Body Spray lnn', 'uploads/chance.webp', 67.00, '', '2025-09-19 05:04:11'),
(26, 'ALLURE HOMME SPORT', '', 'uploads/neww6.webp', 987.00, '', '2025-09-19 07:25:27'),
(34, 'Teena', 'NEW BRAND', 'uploads/1758298801_coco_manem.webp', 377.90, '', '2025-09-19 16:20:01'),
(36, 'Chanel Makeup', '', 'uploads/1758299922_neww3.webp', 777.99, '', '2025-09-19 16:38:42'),
(41, 'Test', 'test product', 'uploads/vani.webp', 100.00, '', '2026-01-04 16:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `author_name`, `rating`, `review_text`, `created_at`) VALUES
(1, 1, 'teena', 5, 'aa', '2025-09-21 07:44:58'),
(2, 1, 'teena', 5, 'The product quality is consistently outstanding, exceeding my expectations every time.', '2025-09-21 10:39:35'),
(3, 1, 'Leo', 2, 'Efficiency and punctuality are hallmarks of their service.', '2025-09-21 10:55:05'),
(4, 1, 'teena', 3, 'great', '2025-09-21 15:03:53'),
(5, 1, 'Chris', 5, 'The product quality is consistently outstanding, exceeding my expectations every time.', '2025-09-21 15:13:24'),
(6, 1, 'Jennie', 5, 'dfgfdhgfxmgh,fghnm', '2025-09-22 04:08:55'),
(7, 26, 'kavi', 5, 'nice', '2026-01-04 16:26:28');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_search`
--

CREATE TABLE `store_search` (
  `id` int(11) NOT NULL,
  `postal_code` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store_search`
--

INSERT INTO `store_search` (`id`, `postal_code`, `created_at`) VALUES
(1, '2000', '2025-09-14 16:41:29'),
(2, '2000', '2025-09-18 15:08:40'),
(3, '333', '2025-09-18 15:12:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `validation_code` varchar(10) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `created_at`, `updated_at`, `validation_code`, `is_active`, `current_team_id`, `profile_photo_path`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`) VALUES
(3, 'Teena', '', 'Teena@gmail.com', NULL, '$2y$10$rh/.Qt.nq8xlndtqYBHULu7hDWISaCdEezd.BXrs/8zDCJw1jL1QK', NULL, '', '2025-09-20 05:59:59', NULL, '437021', 0, NULL, NULL, NULL, NULL, NULL),
(4, 'Jennie', '', 'Jennie@gmail.com', NULL, '$2y$10$NVl49HBkVIOBAW4JDoYPBOJkUe8TSYOlfC/LBDSxjar944LaC.Isy', NULL, 'admin', '2025-09-20 06:00:51', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(6, 'leo', '', 'Leo@gmail.com', NULL, '$2y$10$WmS31mxG7XFm6K9JHsOGVuKQHu5fQCWw8r0LG/ii1EvWAuAUwAtRC', NULL, 'admin', '2025-09-20 06:01:26', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(7, 'Romeo', '', 'Romeo@gmail.com', NULL, '$2y$10$Mrzt/Mok3nEgemwun2MtI.3lDZIUZ8xzhQ5JClYJkSinul5anHu3G', NULL, 'admin', '2025-09-20 06:01:47', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(9, 'ninna', '', 'ninna@gmail.com', NULL, '$2y$10$YecC/1oxwd8XYGN4LuduXuFNIhlPumUCFKbvkCTPzegwTmJSr2wOC', NULL, 'user', '2025-09-20 08:46:22', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(11, 'leon', '', 'leon@gmail.com', NULL, '$2y$10$fNRenoOHBVLcH1ucI2uXF.XzUS8fr5/47nnqOQPUuGdxW87LkMEKC', NULL, 'admin', '2025-09-21 14:48:09', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(12, 'cc', '', 'cc@gamil.com', NULL, '$2y$10$G0K.jGMUwC/adEpISq3M7OZPDLhgID16Wi60YUguIwAzkQPmaYUTa', NULL, 'user', '2025-09-21 14:50:30', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(17, 'kavi', 'kavi', 'kaveeshatrishan@gmail.com', NULL, '$2y$12$8cCVm96ti6ecOFIxHVRgeuZZOAlqiLGLvcgt7Di7SDCWfEZ9Pd.lm', NULL, 'user', '2026-01-04 09:30:35', '2026-01-04 09:30:35', NULL, 1, NULL, NULL, NULL, NULL, NULL),
(18, 'admin', 'Admin', 'admin@chanel.com', NULL, '$2y$12$uQwhgEJ15.7ZJ7/SMqWey.1MlrAFqg4Mvct6NgiFkD/IJhJnKh3lK', NULL, 'admin', '2026-01-04 17:28:40', '2026-01-04 17:28:40', NULL, 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(1, 17, 19, '2026-01-04 17:11:35'),
(2, 17, 1, '2026-01-04 17:11:58');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `courier_id` (`courier_id`);

--
-- Indexes for table `delivery_checkpoints`
--
ALTER TABLE `delivery_checkpoints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `store_search`
--
ALTER TABLE `store_search`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `delivery_checkpoints`
--
ALTER TABLE `delivery_checkpoints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `store_search`
--
ALTER TABLE `store_search`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_ibfk_1` FOREIGN KEY (`courier_id`) REFERENCES `couriers` (`id`);

--
-- Constraints for table `delivery_checkpoints`
--
ALTER TABLE `delivery_checkpoints`
  ADD CONSTRAINT `delivery_checkpoints_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `deliveries` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
