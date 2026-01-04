-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2025 at 06:38 AM
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

INSERT INTO `orders` (`id`, `product_name`, `price`, `image`, `order_status`, `created_at`, `order_date`, `wrapping_option`, `gift_message`, `samples`, `status`, `quantity`) VALUES
(1, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:42:01', NULL, NULL, NULL, 'Pending', 1),
(2, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:42:01', NULL, NULL, NULL, 'Pending', 1),
(3, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:42:01', NULL, NULL, NULL, 'Pending', 1),
(4, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:42:01', NULL, NULL, NULL, 'Pending', 1),
(5, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:42:16', NULL, NULL, NULL, 'Pending', 1),
(6, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:45:58', NULL, NULL, NULL, 'Pending', 1),
(7, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:48:12', NULL, NULL, NULL, 'Pending', 1),
(8, 'LE BLANC', 120.00, '/Website/img/bla.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:48:31', NULL, NULL, NULL, 'Pending', 1),
(9, 'L’HUILE ROSE', 120.00, '/Website/img/rose.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:48:31', NULL, NULL, NULL, 'Pending', 1),
(10, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:54:52', NULL, NULL, NULL, 'Pending', 1),
(11, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:54:52', NULL, NULL, NULL, 'Pending', 1),
(12, 'L’Huile Vanille', 120.00, '/Website/img/vani.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:54:52', NULL, NULL, NULL, 'Pending', 1),
(13, 'Sublimage Le Masque', 120.00, '/Website/img/sub.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:58:05', NULL, NULL, NULL, 'Pending', 1),
(14, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:58:05', NULL, NULL, NULL, 'Pending', 1),
(15, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 04:58:05', NULL, NULL, NULL, 'Pending', 1),
(16, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:01:31', NULL, NULL, NULL, 'Pending', 1),
(17, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:01:31', NULL, NULL, NULL, 'Pending', 1),
(18, 'L’Huile Vanille', 120.00, '/Website/img/vani.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:01:31', NULL, NULL, NULL, 'Pending', 1),
(19, 'LE BLANC', 120.00, '/Website/img/bla.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:01:31', NULL, NULL, NULL, 'Pending', 1),
(20, 'L’HUILE ORIENT', 120.00, '/Website/img/ori.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:02:06', NULL, NULL, NULL, 'Pending', 1),
(21, 'ALLURE SENSUELLE', 190.00, '/Website/img/sen.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:07:32', NULL, NULL, NULL, 'Pending', 1),
(22, 'N°5 EAU PREMIÈRE', 120.00, '/Website/img/pre.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:07:32', NULL, NULL, NULL, 'Pending', 1),
(23, 'N°5 EAU PREMIÈRE', 120.00, '/Website/img/pre.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:11:54', NULL, NULL, NULL, 'Pending', 1),
(24, 'LE VERNIS - 403 - GOLDEN MERMAID', 120.00, '/Website/img/le1.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:11:54', NULL, NULL, NULL, 'Pending', 1),
(25, 'LE VERNIS - 403 - GOLDEN MERMAID', 120.00, '/Website/img/le1.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:12:12', NULL, NULL, NULL, 'Pending', 1),
(26, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:13:07', NULL, NULL, NULL, 'Pending', 1),
(27, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:13:07', NULL, NULL, NULL, 'Pending', 1),
(28, 'POUR MONSIEUR', 87.00, '/Website/img/pour.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:13:39', NULL, NULL, NULL, 'Pending', 1),
(29, 'ALLURE HOMME SPORT', 95.00, '/Website/img/homme.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 05:18:11', NULL, NULL, NULL, 'Pending', 1),
(30, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 07:14:03', NULL, NULL, NULL, 'Pending', 1),
(31, 'LE LIFT LOTION', 120.00, '/Website/img/lift.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 08:04:07', NULL, NULL, NULL, 'Pending', 1),
(32, 'Sublimage Le Masque', 120.00, '/Website/img/sub.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 08:04:50', NULL, NULL, NULL, 'Pending', 1),
(33, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:01:38', 'The Essential', '', 'CHANCE EAU SPLENDIDE, COCO MADEMOISELLE', 'Pending', 1),
(34, 'POUR MONSIEUR', 87.00, '/Website/img/pour.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:01:38', 'The Essential', '', 'CHANCE EAU SPLENDIDE, COCO MADEMOISELLE', 'Pending', 1),
(35, 'ALLURE HOMME SPORT', 95.00, '/Website/img/homme.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:02:16', NULL, NULL, NULL, 'Pending', 1),
(36, 'POUR MONSIEUR', 87.00, '/Website/img/pour.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:02:16', NULL, NULL, NULL, 'Pending', 1),
(37, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:04:22', NULL, NULL, NULL, 'Pending', 1),
(38, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:07:33', NULL, NULL, NULL, 'Pending', 1),
(39, 'POUR MONSIEUR', 87.00, '/Website/img/pour.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:09:01', NULL, NULL, NULL, 'Pending', 1),
(40, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:09:01', NULL, NULL, NULL, 'Pending', 1),
(41, 'ALLURE HOMME SPORT', 95.00, '/Website/img/homme.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:09:01', NULL, NULL, NULL, 'Pending', 1),
(42, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:09:01', NULL, NULL, NULL, 'Pending', 1),
(43, 'HUILE DE JASMIN', 120.00, '/Website/img/jas.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:09:01', NULL, NULL, NULL, 'Pending', 1),
(44, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:23:37', NULL, NULL, NULL, 'Pending', 1),
(45, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:23:37', NULL, NULL, NULL, 'Pending', 1),
(46, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 09:23:37', NULL, NULL, NULL, 'Pending', 1),
(47, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-15 10:31:59', NULL, NULL, NULL, 'Pending', 1),
(48, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:12:37', NULL, NULL, NULL, 'Pending', 1),
(49, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:12:37', NULL, NULL, NULL, 'Pending', 1),
(50, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:12:37', NULL, NULL, NULL, 'Pending', 1),
(51, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:12:37', NULL, NULL, NULL, 'Pending', 1),
(52, 'L’HUILE ORIENT', 120.00, '/Website/img/ori.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:12:37', NULL, NULL, NULL, 'Pending', 1),
(53, 'N°5 EAU PREMIÈRE', 120.00, '/Website/img/pre.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:19:16', NULL, NULL, NULL, 'Pending', 1),
(54, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:19:16', NULL, NULL, NULL, 'Pending', 1),
(55, 'Sublimage Le Masque', 120.00, '/Website/img/sub.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:19:16', NULL, NULL, NULL, 'Pending', 1),
(56, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:19:16', NULL, NULL, NULL, 'Pending', 1),
(57, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:19:16', NULL, NULL, NULL, 'Pending', 1),
(58, 'LE BLANC', 120.00, '/Website/img/bla.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:19:16', NULL, NULL, NULL, 'Pending', 1),
(59, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:19:42', NULL, NULL, NULL, 'Pending', 1),
(60, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:20:20', NULL, NULL, NULL, 'Pending', 1),
(61, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:24:42', NULL, NULL, NULL, 'Pending', 1),
(62, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:25:07', NULL, NULL, NULL, 'Pending', 1),
(63, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:25:07', NULL, NULL, NULL, 'Pending', 1),
(64, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:33:56', NULL, NULL, NULL, 'Pending', 1),
(65, 'GARDÉNIA', 95.00, '/Website/img/gardenia.webp', 'Order Placed', '2025-09-18 17:03:28', '2025-09-18 15:33:56', NULL, NULL, NULL, 'Pending', 1),
(66, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-19 03:45:24', '2025-09-19 03:45:24', NULL, NULL, NULL, 'Pending', 1),
(67, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-19 03:45:25', '2025-09-19 03:45:25', NULL, NULL, NULL, 'Pending', 1),
(68, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-19 03:45:52', '2025-09-19 03:45:52', NULL, NULL, NULL, 'Pending', 1),
(69, 'BLEU DE CHANEL', 95.00, '/Website/img/deodrant.webp', 'Order Placed', '2025-09-19 06:29:32', '2025-09-19 06:29:32', NULL, NULL, NULL, 'Pending', 1),
(70, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-19 06:29:32', '2025-09-19 06:29:32', NULL, NULL, NULL, 'Pending', 1),
(71, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-19 06:29:32', '2025-09-19 06:29:32', NULL, NULL, NULL, 'Pending', 1),
(72, 'ALLURE HOMME SPORT', 95.00, '/Website/img/homme.webp', 'Order Placed', '2025-09-19 06:29:32', '2025-09-19 06:29:32', NULL, NULL, NULL, 'Pending', 1),
(73, 'Classic Handbag', 1250.50, 'uploads/handbag.jpg', 'Completed', '2025-09-19 07:23:34', '2025-09-19 07:23:34', 'Signature', 'Happy Birthday!', 'Sample A', 'active', 1),
(74, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-20 06:02:55', '2025-09-20 06:02:55', NULL, NULL, NULL, 'Pending', 1),
(75, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-20 06:02:55', '2025-09-20 06:02:55', NULL, NULL, NULL, 'Pending', 1),
(76, 'HUILE DE JASMIN', 120.00, '/Website/img/jas.webp', 'Order Placed', '2025-09-20 06:02:55', '2025-09-20 06:02:55', NULL, NULL, NULL, 'Pending', 1),
(77, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-20 06:49:18', '2025-09-20 06:49:18', NULL, NULL, NULL, 'Pending', 1),
(78, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-20 06:49:18', '2025-09-20 06:49:18', NULL, NULL, NULL, 'Pending', 1),
(79, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-20 06:51:51', '2025-09-20 06:51:51', NULL, NULL, NULL, 'Pending', 1),
(80, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-20 06:51:51', '2025-09-20 06:51:51', NULL, NULL, NULL, 'Pending', 1),
(81, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-21 14:49:22', '2025-09-21 14:49:22', NULL, NULL, NULL, 'Pending', 1),
(82, 'ALLURE SENSUELLE', 190.00, '/Website/img/sen.webp', 'Order Placed', '2025-09-21 14:49:22', '2025-09-21 14:49:22', NULL, NULL, NULL, 'Pending', 1),
(83, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-21 14:49:22', '2025-09-21 14:49:22', NULL, NULL, NULL, 'Pending', 1),
(84, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-21 16:39:52', '2025-09-21 16:39:52', NULL, NULL, NULL, 'Pending', 1),
(85, 'CHANCE', 95.00, '/Website/img/chance.webp', 'Order Placed', '2025-09-21 16:39:52', '2025-09-21 16:39:52', NULL, NULL, NULL, 'Pending', 1),
(86, 'HUILE DE JASMIN', 230.00, '/Website/img/jas.webp', 'Order Placed', '2025-09-21 16:39:52', '2025-09-21 16:39:52', NULL, NULL, NULL, 'Pending', 1),
(87, 'ALLURE HOMME ÉDITION BLANCHE', 120.00, '/Website/img/allure.webp', 'Order Placed', '2025-09-22 04:10:29', '2025-09-22 04:10:29', NULL, NULL, NULL, 'Pending', 1),
(88, 'LE VERNIS - 401 - BEACH ICON', 120.00, '/Website/img/le2.webp', 'Order Placed', '2025-09-22 04:10:29', '2025-09-22 04:10:29', NULL, NULL, NULL, 'Pending', 1),
(89, 'L’Huile Vanille', 120.00, '/Website/img/vani.webp', 'Order Placed', '2025-09-22 04:10:29', '2025-09-22 04:10:29', NULL, NULL, NULL, 'Pending', 1);

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
(19, 'chanel', 'New Body Spray lnn', 'uploads/chance.webp', 67.00, '', '2025-09-19 05:04:11'),
(26, 'ALLURE HOMME SPORT', '', 'uploads/neww6.webp', 987.00, '', '2025-09-19 07:25:27'),
(34, 'Teena', 'NEW BRAND', 'uploads/1758298801_coco_manem.webp', 377.90, '', '2025-09-19 16:20:01'),
(36, 'Chanel Makeup', '', 'uploads/1758299922_neww3.webp', 777.99, '', '2025-09-19 16:38:42'),
(38, 'Chance', 'New Hair Mist', 'uploads/1758347744_chance_eau_tendre.webp', 82.00, '', '2025-09-20 05:55:44');

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
(6, 1, 'Jennie', 5, 'dfgfdhgfxmgh,fghnm', '2025-09-22 04:08:55');

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
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `validation_code` varchar(10) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`, `role`, `created_at`, `validation_code`, `is_active`) VALUES
(3, 'Teena', '', 'Teena@gmail.com', '$2y$10$rh/.Qt.nq8xlndtqYBHULu7hDWISaCdEezd.BXrs/8zDCJw1jL1QK', '', '2025-09-20 05:59:59', '437021', 0),
(4, 'Jennie', '', 'Jennie@gmail.com', '$2y$10$NVl49HBkVIOBAW4JDoYPBOJkUe8TSYOlfC/LBDSxjar944LaC.Isy', 'admin', '2025-09-20 06:00:51', NULL, 0),
(6, 'leo', '', 'Leo@gmail.com', '$2y$10$WmS31mxG7XFm6K9JHsOGVuKQHu5fQCWw8r0LG/ii1EvWAuAUwAtRC', 'admin', '2025-09-20 06:01:26', NULL, 1),
(7, 'Romeo', '', 'Romeo@gmail.com', '$2y$10$Mrzt/Mok3nEgemwun2MtI.3lDZIUZ8xzhQ5JClYJkSinul5anHu3G', 'admin', '2025-09-20 06:01:47', NULL, 0),
(9, 'ninna', '', 'ninna@gmail.com', '$2y$10$YecC/1oxwd8XYGN4LuduXuFNIhlPumUCFKbvkCTPzegwTmJSr2wOC', 'user', '2025-09-20 08:46:22', NULL, 1),
(11, 'leon', '', 'leon@gmail.com', '$2y$10$fNRenoOHBVLcH1ucI2uXF.XzUS8fr5/47nnqOQPUuGdxW87LkMEKC', 'admin', '2025-09-21 14:48:09', NULL, 0),
(12, 'cc', '', 'cc@gamil.com', '$2y$10$G0K.jGMUwC/adEpISq3M7OZPDLhgID16Wi60YUguIwAzkQPmaYUTa', 'user', '2025-09-21 14:50:30', NULL, 1);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `store_search`
--
ALTER TABLE `store_search`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
