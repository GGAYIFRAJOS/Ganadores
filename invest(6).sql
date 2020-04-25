-- phpMyAdmin SQL Dump
-- version 4.9.2deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 25, 2020 at 02:11 AM
-- Server version: 10.3.18-MariaDB-1
-- PHP Version: 7.3.10-1+b1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invest`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `fine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `member_id`, `member`, `date`, `status`, `fine`) VALUES
(1, 1, 'KENNETH', '2020-02-02', 'present', 0),
(2, 2, 'SUREA', '2020-02-02', 'present', 0),
(3, 3, 'MAKABAYI', '2020-02-02', 'absent', 30000),
(4, 1, 'KENNETH', '2020-02-05', 'present', 0),
(5, 2, 'SUREA', '2020-02-05', 'absent', 30000),
(6, 3, 'MAKABAYI', '2020-02-05', 'present', 0);

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` int(11) NOT NULL,
  `Balance` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'not_paid',
  `member_id` int(11) NOT NULL,
  `pay_balance` int(11) NOT NULL,
  `balance_range` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `balances`
--

INSERT INTO `balances` (`id`, `Balance`, `status`, `member_id`, `pay_balance`, `balance_range`, `amount_paid`) VALUES
(1, 200000, 'paid', 1, 0, 2, 200000),
(2, 200000, 'paid', 1, 0, 3, 200000),
(3, 200000, 'paid', 1, 0, 4, 200000),
(4, 200000, 'paid', 1, 0, 5, 200000),
(5, 50000, 'paid', 1, 0, 6, 50000),
(6, 200000, 'not_paid', 1, 50000, 7, 150000);

-- --------------------------------------------------------

--
-- Table structure for table `chairman`
--

CREATE TABLE `chairman` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `fine` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date_range` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chairman`
--

INSERT INTO `chairman` (`id`, `member_id`, `member`, `date`, `status`, `fine`, `amount`, `date_range`) VALUES
(1, 1, 'KENNETH', '2020-02-02', 'not_payed', 5000, 0, 8),
(2, 2, 'SUREA', '2020-02-02', 'payed', 0, 5000, 8),
(3, 3, 'MAKABAYI', '2020-02-02', 'payed', 0, 5000, 8);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fines`
--

CREATE TABLE `fines` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `fine` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'not_cleared',
  `Balance` int(11) NOT NULL,
  `fine_range` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fines`
--

INSERT INTO `fines` (`id`, `member_id`, `fine`, `status`, `Balance`, `fine_range`, `amount_paid`) VALUES
(1, 1, 30000, 'cleared', 0, 2, 30000),
(2, 1, 30000, 'cleared', 0, 3, 30000),
(3, 1, 30000, 'not_cleared', 10000, 4, 20000),
(4, 1, 30000, 'not_cleared', 30000, 5, 0),
(5, 1, 30000, 'not_cleared', 30000, 6, 0),
(6, 1, 30000, 'not_cleared', 30000, 7, 0),
(7, 3, 30000, 'not_cleared', 30000, 8, 0),
(8, 2, 30000, 'not_cleared', 30000, 8, 0),
(9, 1, 5000, 'not_cleared', 5000, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `loan_progress_update`
--

CREATE TABLE `loan_progress_update` (
  `id` int(11) NOT NULL,
  `identification_id` int(11) NOT NULL,
  `membership` varchar(255) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `range_dates` varchar(255) NOT NULL,
  `amount_forward` int(11) NOT NULL,
  `fine` int(11) NOT NULL DEFAULT 0,
  `amount_paid` int(11) NOT NULL,
  `total_owed` int(11) NOT NULL,
  `interest` int(11) NOT NULL DEFAULT 0,
  `total_paid` int(11) NOT NULL,
  `balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loan_progress_update`
--

INSERT INTO `loan_progress_update` (`id`, `identification_id`, `membership`, `loan_id`, `type`, `range_dates`, `amount_forward`, `fine`, `amount_paid`, `total_owed`, `interest`, `total_paid`, `balance`) VALUES
(1, 1, 'member', 1, 'fine', 'from 2019-08-09 to 2019-09-09', 1000000, 50000, 0, 1050000, 0, 0, 1050000),
(2, 1, 'member', 1, 'fine', 'from 2019-09-09 to 2019-10-09', 1050000, 52500, 0, 1102500, 0, 0, 1102500),
(3, 1, 'member', 1, 'fine', 'from 2019-10-09 to 2019-11-09', 1102500, 55125, 0, 1157625, 0, 0, 1157625),
(4, 1, 'member', 1, 'fine', 'from 2019-11-09 to 2019-12-09', 1157625, 57881, 0, 1215506, 0, 0, 1215506),
(5, 1, 'member', 1, 'fine', 'from 2019-12-09 to 2020-01-09', 1215506, 60775, 0, 1276282, 0, 0, 1276282),
(6, 1, 'member', 1, 'fine', 'from 2020-01-09 to 2020-02-09', 1276282, 63814, 0, 1340096, 0, 0, 1340096),
(7, 1, 'member', 1, 'fine', 'from 2020-02-09 to 2020-03-09', 1340096, 67005, 0, 1407100, 0, 0, 1407100),
(8, 1, 'member', 1, 'fine', 'from 2020-03-09 to 2020-04-09', 1407100, 70355, 0, 1477455, 0, 0, 1477455),
(9, 1, 'member', 1, 'fine', 'from 2020-04-09 to 2020-05-09', 1477455, 73873, 0, 1551328, 0, 0, 1551328),
(10, 1, 'member', 1, 'fine', 'from 2020-05-09 to 2020-06-09', 1551328, 77566, 0, 1628895, 0, 0, 1628895),
(11, 1, 'member', 1, 'fine', 'from 2020-06-09 to 2020-07-09', 1628895, 81445, 0, 1710339, 0, 0, 1710339),
(12, 1, 'member', 1, 'fine', 'from 2020-07-09 to 2020-08-09', 1710339, 85517, 0, 1795856, 0, 0, 1795856),
(13, 1, 'member', 1, 'fine', 'from 2020-08-09 to 2020-09-09', 1795856, 89793, 0, 1885649, 0, 0, 1885649),
(14, 1, 'member', 1, 'fine', 'from 2020-09-09 to 2020-10-09', 1885649, 94282, 0, 1979932, 0, 0, 1979932),
(15, 1, 'member', 1, 'fine', 'from 2020-10-09 to 2020-11-09', 1979932, 98997, 0, 2078928, 0, 0, 2078928),
(16, 1, 'member', 1, 'fine', 'from 2020-11-09 to 2020-12-09', 2078928, 103946, 0, 2182875, 0, 0, 2182875),
(17, 1, 'member', 1, 'fine', 'from 2020-12-09 to 2021-01-09', 2182875, 109144, 0, 2292018, 0, 0, 2292018),
(18, 1, 'member', 1, 'fine', 'from 2021-01-09 to 2021-02-09', 2292018, 114601, 0, 2406619, 0, 0, 2406619),
(19, 1, 'member', 1, 'fine', 'from 2021-02-09 to 2021-03-09', 2406619, 120331, 0, 2526950, 0, 0, 2526950),
(20, 1, 'member', 1, 'fine', 'from 2021-03-09 to 2021-04-09', 2526950, 126348, 0, 2653298, 0, 0, 2653298),
(21, 1, 'member', 1, 'fine', 'from 2021-04-09 to 2021-05-09', 2653298, 132665, 0, 2785963, 0, 0, 2785963),
(22, 1, 'member', 1, 'fine', 'from 2021-05-09 to 2021-06-09', 2785963, 139298, 0, 2925261, 0, 0, 2925261),
(23, 1, 'member', 1, 'loan_payment', 'from 2021-06-09 to 2021-07-09', 2925261, 0, 200000, 3047147, 121886, 200000, 2847147),
(24, 1, 'member', 1, 'fine', 'from 2021-07-09 to 2021-08-09', 2847147, 142357, 0, 2989504, 0, 200000, 2989504),
(25, 1, 'member', 1, 'fine', 'from 2021-08-09 to 2021-09-09', 2989504, 149475, 0, 3138979, 0, 200000, 3138979),
(26, 1, 'member', 1, 'loan_payment', 'from 2019-10-09 to 2019-11-09', 3138979, 0, 500000, 3194671, 55692, 700000, 2694671),
(27, 1, 'member', 1, 'fine', 'from 2019-11-09 to 2019-12-09', 2694671, 134734, 0, 2829404, 0, 700000, 2829404),
(28, 1, 'member', 1, 'fine', 'from 2019-12-09 to 2020-01-09', 2829404, 141470, 0, 2970874, 0, 700000, 2970874),
(29, 1, 'member', 1, 'fine', 'from 2020-01-09 to 2020-02-09', 2970874, 148544, 0, 3119418, 0, 700000, 3119418),
(30, 1, 'member', 1, 'loan_payment', 'from 2019-11-09 to 2019-12-09', 3119418, 0, 150000, 3135015, 15597, 850000, 2985015),
(31, 1, 'member', 1, 'fine', 'from 2019-12-09 to 2020-01-09', 2985015, 149251, 0, 3134266, 0, 850000, 3134266),
(32, 1, 'member', 1, 'fine', 'from 2020-01-09 to 2020-02-09', 3134266, 156713, 0, 3290979, 0, 850000, 3290979),
(33, 1, 'member', 1, 'fine', 'from 2020-02-09 to 2020-03-09', 3290979, 164549, 0, 3455528, 0, 850000, 3455528),
(34, 1, 'member', 1, 'loan_payment', 'from 2019-11-09 to 2019-12-09', 3455528, 0, 400000, 3576472, 120943, 1250000, 3176472),
(35, 1, 'member', 1, 'fine', 'from 2019-12-09 to 2020-01-09', 3176472, 158824, 0, 3335295, 0, 1250000, 3335295),
(36, 1, 'member', 1, 'fine', 'from 2020-01-09 to 2020-02-09', 3335295, 166765, 0, 3502060, 0, 1250000, 3502060),
(37, 1, 'member', 1, 'fine', 'from 2020-02-09 to 2020-03-09', 3502060, 175103, 0, 3677163, 0, 1250000, 3677163),
(38, 1, 'member', 1, 'fine', 'from 2020-03-09 to 2020-04-09', 3677163, 183858, 0, 3861021, 0, 1250000, 3861021),
(39, 1, 'member', 1, 'loan_payment', 'from 2019-12-09 to 2020-01-09', 3861021, 0, 200000, 3856975, -4046, 1450000, 3656975),
(40, 1, 'member', 1, 'fine', 'from 2020-01-09 to 2020-02-09', 3656975, 182849, 0, 3839824, 0, 1450000, 3839824),
(41, 1, 'member', 1, 'fine', 'from 2020-02-09 to 2020-03-09', 3839824, 191991, 0, 4031815, 0, 1450000, 4031815),
(42, 1, 'member', 1, 'fine', 'from 2020-03-09 to 2020-04-09', 4031815, 201591, 0, 4233406, 0, 1450000, 4233406),
(43, 1, 'member', 1, 'fine', 'from 2020-04-09 to 2020-05-09', 4233406, 211670, 0, 4445076, 0, 1450000, 4445076),
(44, 1, 'member', 1, 'fine', 'from 2020-05-09 to 2020-06-09', 4445076, 222254, 0, 4667330, 0, 1450000, 4667330),
(45, 1, 'member', 1, 'loan_payment', 'from 2020-01-09 to 2020-02-09', 4667330, 0, 180000, 4848001, 180671, 1630000, 4668001),
(46, 1, 'member', 1, 'fine', 'from 2020-02-09 to 2020-03-09', 4668001, 233400, 0, 4901401, 0, 1630000, 4901401),
(47, 1, 'member', 1, 'fine', 'from 2020-03-09 to 2020-04-09', 4901401, 245070, 0, 5146471, 0, 1630000, 5146471),
(48, 1, 'member', 1, 'fine', 'from 2020-04-09 to 2020-05-09', 5146471, 257324, 0, 5403795, 0, 1630000, 5403795),
(49, 1, 'member', 1, 'fine', 'from 2020-05-09 to 2020-06-09', 5403795, 270190, 0, 5673984, 0, 1630000, 5673984),
(50, 1, 'member', 1, 'fine', 'from 2020-06-09 to 2020-07-09', 5673984, 283699, 0, 5957684, 0, 1630000, 5957684),
(51, 1, 'member', 1, 'loan_payment', 'from 2020-01-09 to 2020-02-09', 5957684, 0, 80000, 6188304, 230620, 1710000, 6108304),
(52, 1, 'member', 1, 'fine', 'from 2020-02-09 to 2020-03-09', 6108304, 305415, 0, 6413719, 0, 1710000, 6413719),
(53, 1, 'member', 1, 'fine', 'from 2020-03-09 to 2020-04-09', 6413719, 320686, 0, 6734405, 0, 1710000, 6734405),
(54, 1, 'member', 1, 'fine', 'from 2020-04-09 to 2020-05-09', 6734405, 336720, 0, 7071125, 0, 1710000, 7071125),
(55, 1, 'member', 1, 'fine', 'from 2020-05-09 to 2020-06-09', 7071125, 353556, 0, 7424681, 0, 1710000, 7424681),
(56, 1, 'member', 1, 'fine', 'from 2020-06-09 to 2020-07-09', 7424681, 371234, 0, 7795915, 0, 1710000, 7795915),
(57, 1, 'member', 1, 'loan_payment', 'from 2020-01-09 to 2020-02-09', 7795915, 0, 1000000, 8097693, 301777, 2710000, 7097693),
(58, 2, 'member', 2, 'fine', 'from 2019-08-09 to 2019-09-09', 2000000, 100000, 0, 2100000, 0, 0, 2100000),
(59, 2, 'member', 2, 'fine', 'from 2019-09-09 to 2019-10-09', 2100000, 105000, 0, 2205000, 0, 0, 2205000),
(60, 2, 'member', 2, 'loan_payment', 'from 2019-10-09 to 2019-11-09', 2205000, 0, 1000000, 2244121, 39121, 1000000, 1244121),
(61, 2, 'member', 2, 'loan_payment', 'from 2019-11-09 to 2019-12-09', 1244121, 0, 800000, 1287665, 43544, 1800000, 487665),
(62, 2, 'member', 2, 'loan_payment', 'from 2019-12-09 to 2020-01-09', 487665, 0, 400000, 487154, -511, 2200000, 87154),
(63, 3, 'member', 3, 'fine', 'from 2019-08-09 to 2019-09-09', 1000000, 50000, 0, 1050000, 0, 0, 1050000),
(64, 3, 'member', 3, 'fine', 'from 2019-09-09 to 2019-10-09', 1050000, 52500, 0, 1102500, 0, 0, 1102500),
(65, 3, 'member', 3, 'loan_payment', 'from 2019-10-09 to 2019-11-09', 1102500, 0, 500000, 1122060, 19560, 500000, 622060),
(66, 3, 'member', 3, 'loan_payment', 'from 2019-11-09 to 2019-12-09', 622060, 0, 400000, 643833, 21772, 900000, 243833),
(67, 3, 'member', 3, 'loan_payment', 'from 2019-12-09 to 2020-01-09', 243833, 0, 200000, 244088, 256, 1100000, 44088),
(68, 4, 'member', 4, 'fine', 'from 2019-08-09 to 2019-09-09', 1000000, 50000, 0, 1050000, 0, 0, 1050000),
(69, 4, 'member', 4, 'fine', 'from 2019-09-09 to 2019-10-09', 1050000, 52500, 0, 1102500, 0, 0, 1102500),
(70, 4, 'member', 4, 'loan_payment', 'from 2019-10-09 to 2019-11-09', 1102500, 0, 500000, 1122060, 19560, 500000, 622060),
(71, 4, 'member', 4, 'loan_payment', 'from 2019-11-09 to 2019-12-09', 622060, 0, 400000, 643833, 21772, 900000, 243833),
(72, 4, 'member', 4, 'loan_payment', 'from 2019-12-09 to 2020-01-09', 243833, 0, 200000, 244088, 256, 1100000, 44088),
(73, 5, 'member', 5, 'fine', 'from 2019-02-09 to 2019-03-09', 1000000, 50000, 0, 1050000, 0, 0, 1050000),
(74, 5, 'member', 5, 'fine', 'from 2019-03-09 to 2019-04-09', 1050000, 52500, 0, 1102500, 0, 0, 1102500),
(75, 5, 'member', 5, 'loan_payment', 'from 2019-04-09 to 2019-05-09', 1102500, 0, 500000, 1122713, 20213, 500000, 622713),
(76, 5, 'member', 5, 'loan_payment', 'from 2019-05-09 to 2019-06-09', 622713, 0, 400000, 643804, 21092, 900000, 243804),
(77, 5, 'member', 5, 'loan_payment', 'from 2019-06-09 to 2019-07-09', 243804, 0, 200000, 246649, 2844, 1100000, 46649);

-- --------------------------------------------------------

--
-- Table structure for table `loan_ranges`
--

CREATE TABLE `loan_ranges` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `max_date` date NOT NULL,
  `loan_range` int(11) NOT NULL,
  `range_balance` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loan_ranges`
--

INSERT INTO `loan_ranges` (`id`, `member_id`, `loan_id`, `max_date`, `loan_range`, `range_balance`) VALUES
(1, 1, 1, '2019-08-09', 1, 1000000),
(2, 1, 1, '2019-09-09', 2, NULL),
(3, 1, 1, '2019-10-09', 3, NULL),
(4, 1, 1, '2019-11-09', 4, 2694671),
(5, 1, 1, '2019-12-09', 5, 3176472),
(6, 1, 1, '2020-01-09', 6, 3656975),
(7, 1, 1, '2020-02-09', 7, 7097693),
(8, 1, 1, '2020-03-09', 8, NULL),
(9, 1, 1, '2020-04-09', 9, NULL),
(10, 1, 1, '2020-05-09', 10, NULL),
(11, 1, 1, '2020-06-09', 11, NULL),
(12, 1, 1, '2020-07-09', 12, NULL),
(13, 1, 1, '2020-08-09', 13, NULL),
(14, 1, 1, '2020-09-09', 14, NULL),
(15, 1, 1, '2020-10-09', 15, NULL),
(16, 1, 1, '2020-11-09', 16, NULL),
(17, 1, 1, '2020-12-09', 17, NULL),
(18, 1, 1, '2021-01-09', 18, NULL),
(19, 1, 1, '2021-02-09', 19, NULL),
(20, 1, 1, '2021-03-09', 20, NULL),
(21, 1, 1, '2021-04-09', 21, NULL),
(22, 1, 1, '2021-05-09', 22, NULL),
(23, 1, 1, '2021-06-09', 23, NULL),
(24, 1, 1, '2021-07-09', 24, 2847147),
(25, 2, 2, '2019-08-09', 1, 2000000),
(26, 2, 2, '2019-09-09', 2, NULL),
(27, 2, 2, '2019-10-09', 3, NULL),
(28, 2, 2, '2019-11-09', 4, 1244121),
(29, 2, 2, '2019-12-09', 5, 487665),
(30, 2, 2, '2020-01-09', 6, 87154),
(31, 2, 2, '2020-02-09', 7, NULL),
(32, 2, 2, '2020-03-09', 8, NULL),
(33, 2, 2, '2020-04-09', 9, NULL),
(34, 2, 2, '2020-05-09', 10, NULL),
(35, 2, 2, '2020-06-09', 11, NULL),
(36, 2, 2, '2020-07-09', 12, NULL),
(37, 2, 2, '2020-08-09', 13, NULL),
(38, 2, 2, '2020-09-09', 14, NULL),
(39, 2, 2, '2020-10-09', 15, NULL),
(40, 2, 2, '2020-11-09', 16, NULL),
(41, 2, 2, '2020-12-09', 17, NULL),
(42, 2, 2, '2021-01-09', 18, NULL),
(43, 2, 2, '2021-02-09', 19, NULL),
(44, 2, 2, '2021-03-09', 20, NULL),
(45, 2, 2, '2021-04-09', 21, NULL),
(46, 2, 2, '2021-05-09', 22, NULL),
(47, 2, 2, '2021-06-09', 23, NULL),
(48, 2, 2, '2021-07-09', 24, NULL),
(49, 3, 3, '2019-08-09', 1, 1000000),
(50, 3, 3, '2019-09-09', 2, NULL),
(51, 3, 3, '2019-10-09', 3, NULL),
(52, 3, 3, '2019-11-09', 4, 622060),
(53, 3, 3, '2019-12-09', 5, 243833),
(54, 3, 3, '2020-01-09', 6, 44088),
(55, 3, 3, '2020-02-09', 7, NULL),
(56, 3, 3, '2020-03-09', 8, NULL),
(57, 3, 3, '2020-04-09', 9, NULL),
(58, 3, 3, '2020-05-09', 10, NULL),
(59, 3, 3, '2020-06-09', 11, NULL),
(60, 3, 3, '2020-07-09', 12, NULL),
(61, 3, 3, '2020-08-09', 13, NULL),
(62, 3, 3, '2020-09-09', 14, NULL),
(63, 3, 3, '2020-10-09', 15, NULL),
(64, 3, 3, '2020-11-09', 16, NULL),
(65, 3, 3, '2020-12-09', 17, NULL),
(66, 3, 3, '2021-01-09', 18, NULL),
(67, 3, 3, '2021-02-09', 19, NULL),
(68, 3, 3, '2021-03-09', 20, NULL),
(69, 3, 3, '2021-04-09', 21, NULL),
(70, 3, 3, '2021-05-09', 22, NULL),
(71, 3, 3, '2021-06-09', 23, NULL),
(72, 3, 3, '2021-07-09', 24, NULL),
(73, 4, 4, '2019-08-09', 1, 1000000),
(74, 4, 4, '2019-09-09', 2, NULL),
(75, 4, 4, '2019-10-09', 3, NULL),
(76, 4, 4, '2019-11-09', 4, 622060),
(77, 4, 4, '2019-12-09', 5, 243833),
(78, 4, 4, '2020-01-09', 6, 44088),
(79, 4, 4, '2020-02-09', 7, NULL),
(80, 4, 4, '2020-03-09', 8, NULL),
(81, 4, 4, '2020-04-09', 9, NULL),
(82, 4, 4, '2020-05-09', 10, NULL),
(83, 4, 4, '2020-06-09', 11, NULL),
(84, 4, 4, '2020-07-09', 12, NULL),
(85, 4, 4, '2020-08-09', 13, NULL),
(86, 4, 4, '2020-09-09', 14, NULL),
(87, 4, 4, '2020-10-09', 15, NULL),
(88, 4, 4, '2020-11-09', 16, NULL),
(89, 4, 4, '2020-12-09', 17, NULL),
(90, 4, 4, '2021-01-09', 18, NULL),
(91, 4, 4, '2021-02-09', 19, NULL),
(92, 4, 4, '2021-03-09', 20, NULL),
(93, 4, 4, '2021-04-09', 21, NULL),
(94, 4, 4, '2021-05-09', 22, NULL),
(95, 4, 4, '2021-06-09', 23, NULL),
(96, 4, 4, '2021-07-09', 24, NULL),
(97, 5, 5, '2019-02-09', 1, 1000000),
(98, 5, 5, '2019-03-09', 2, NULL),
(99, 5, 5, '2019-04-09', 3, NULL),
(100, 5, 5, '2019-05-09', 4, 622713),
(101, 5, 5, '2019-06-09', 5, 243804),
(102, 5, 5, '2019-07-09', 6, 46649),
(103, 5, 5, '2019-08-09', 7, NULL),
(104, 5, 5, '2019-09-09', 8, NULL),
(105, 5, 5, '2019-10-09', 9, NULL),
(106, 5, 5, '2019-11-09', 10, NULL),
(107, 5, 5, '2019-12-09', 11, NULL),
(108, 5, 5, '2020-01-09', 12, NULL),
(109, 5, 5, '2020-02-09', 13, NULL),
(110, 5, 5, '2020-03-09', 14, NULL),
(111, 5, 5, '2020-04-09', 15, NULL),
(112, 5, 5, '2020-05-09', 16, NULL),
(113, 5, 5, '2020-06-09', 17, NULL),
(114, 5, 5, '2020-07-09', 18, NULL),
(115, 5, 5, '2020-08-09', 19, NULL),
(116, 5, 5, '2020-09-09', 20, NULL),
(117, 5, 5, '2020-10-09', 21, NULL),
(118, 5, 5, '2020-11-09', 22, NULL),
(119, 5, 5, '2020-12-09', 23, NULL),
(120, 5, 5, '2021-01-09', 24, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `phone_cell` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `member_id`, `names`, `adress`, `phone_cell`, `email`) VALUES
(1, 1, 'KENNETH', '1234, KAMPALA', 784567382, 'kenneth@gmail.com'),
(2, 2, 'SUREA NJUKI', '3233', 784567382, 'sureanjuki@gmail.com'),
(3, 3, 'MAKABAYI', '24242', 784567382, 'makabi@yahoo.com'),
(4, 4, 'GGAYI FRANKLIN', '1234, KAMPALA', 776114867, 'ggayifranklinj@gmail.com'),
(5, 5, 'ALAINE', '1342, LUWEERO', 784567382, 'alaine@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `member_loan_info`
--

CREATE TABLE `member_loan_info` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `total_amount` int(11) DEFAULT 0,
  `balance` int(11) NOT NULL DEFAULT 200000,
  `amount` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL DEFAULT 0,
  `loan_date` date NOT NULL,
  `names` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `interest` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'NOT PAID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member_loan_info`
--

INSERT INTO `member_loan_info` (`id`, `member_id`, `total_amount`, `balance`, `amount`, `amount_paid`, `loan_date`, `names`, `date`, `interest`, `due_date`, `status`) VALUES
(1, 1, 1100000, 7097693, 1000000, 200000, '2019-07-09', 'KENNETH', '2019-07-09', 5, '2019-08-09', 'NOT PAID'),
(2, 2, 2200000, 87154, 2000000, 400000, '2019-07-09', 'SUREA NJUKI', '2019-07-09', 5, '2019-08-09', 'NOT PAID'),
(3, 3, 1100000, 44088, 1000000, 200000, '2019-07-09', 'MAKABAYI', '2019-07-09', 5, '2019-08-09', 'NOT PAID'),
(4, 4, 1100000, 44088, 1000000, 200000, '2019-07-09', 'GGAYI FRANKLIN', '2019-07-09', 5, '2019-08-09', 'NOT PAID'),
(5, 5, 1100000, 46649, 1000000, 200000, '2019-01-09', 'ALAINE', '2019-01-09', 5, '2019-02-09', 'NOT PAID');

-- --------------------------------------------------------

--
-- Table structure for table `non_members`
--

CREATE TABLE `non_members` (
  `id` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `contact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `non_member_loan_info`
--

CREATE TABLE `non_member_loan_info` (
  `id` int(11) NOT NULL,
  `non_member` varchar(255) NOT NULL,
  `balance` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `non_member_id` int(11) NOT NULL,
  `status` varchar(255) DEFAULT 'NOT PAID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `non_member_transactions`
--

CREATE TABLE `non_member_transactions` (
  `id` int(11) NOT NULL,
  `non_member` varchar(255) NOT NULL,
  `non_member_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `member_id` int(11) NOT NULL,
  `payment_amount` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `membership` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `balance` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'not_fined'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `names`, `member_id`, `payment_amount`, `payment_date`, `membership`, `type`, `balance`, `status`) VALUES
(1, 'KENNETH', 1, 200000, '2019-07-04', 'member', 'savings', 2847147, 'fined'),
(2, 'KENNETH', 1, 150000, '2019-11-12', 'member', 'savings', 2985015, 'fined'),
(3, 'KENNETH', 1, 180000, '2020-02-02', 'member', 'savings', 4668001, 'fined'),
(4, 'KENNETH', 1, 80000, '2020-02-02', 'member', 'fines', 6108304, 'fined'),
(5, 'KENNETH', 1, 1000000, '2020-02-02', 'member', 'balances', 7097693, 'fined'),
(6, 'KENNETH', 1, 500000, '2019-10-20', 'member', 'loans_payment', 2694671, 'fined'),
(7, 'KENNETH', 1, 400000, '2019-11-30', 'member', 'loans_payment', 3176472, 'fined'),
(8, 'KENNETH', 1, 200000, '2019-12-16', 'member', 'loans_payment', 3656975, 'fined'),
(9, 'SUREA NJUKI', 2, 1000000, '2019-10-20', 'member', 'loans_payment', 1244121, 'fined'),
(10, 'SUREA NJUKI', 2, 800000, '2019-11-30', 'member', 'loans_payment', 487665, 'fined'),
(11, 'SUREA NJUKI', 2, 400000, '2019-12-16', 'member', 'loans_payment', 87154, 'fined'),
(12, 'MAKABAYI', 3, 500000, '2019-10-20', 'member', 'loans_payment', 622060, 'fined'),
(13, 'MAKABAYI', 3, 400000, '2019-11-30', 'member', 'loans_payment', 243833, 'fined'),
(14, 'MAKABAYI', 3, 200000, '2019-12-16', 'member', 'loans_payment', 44088, 'fined'),
(15, 'GGAYI FRANKLIN', 4, 500000, '2019-10-20', 'member', 'loans_payment', 622060, 'fined'),
(16, 'GGAYI FRANKLIN', 4, 400000, '2019-11-30', 'member', 'loans_payment', 243833, 'fined'),
(17, 'GGAYI FRANKLIN', 4, 200000, '2019-12-16', 'member', 'loans_payment', 44088, 'fined'),
(18, 'ALAINE', 5, 500000, '2019-04-20', 'member', 'loans_payment', 622713, 'fined'),
(19, 'ALAINE', 5, 400000, '2019-05-30', 'member', 'loans_payment', 243804, 'fined'),
(20, 'ALAINE', 5, 200000, '2019-06-16', 'member', 'loans_payment', 46649, 'fined');

-- --------------------------------------------------------

--
-- Table structure for table `ranges`
--

CREATE TABLE `ranges` (
  `id` int(11) NOT NULL,
  `range_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `saving_range` int(11) NOT NULL,
  `saving_sched` date NOT NULL,
  `range_dates` varchar(255) NOT NULL,
  `amount` int(11) DEFAULT 0,
  `total_paid` int(11) DEFAULT 0,
  `balance` int(11) DEFAULT 200000,
  `status` varchar(255) NOT NULL DEFAULT 'NOT CLEARED',
  `saving_status` varchar(255) NOT NULL DEFAULT 'not_passed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ranges`
--

INSERT INTO `ranges` (`id`, `range_id`, `member_id`, `names`, `saving_range`, `saving_sched`, `range_dates`, `amount`, `total_paid`, `balance`, `status`, `saving_status`) VALUES
(1, 1, 1, 'KENNETH', 1, '2019-07-06', 'from 2019-06-06 to 2019-07-06', 200000, 200000, 0, 'CLEARED', 'not_passed'),
(2, 2, 1, 'KENNETH', 2, '2019-08-06', 'from 2019-07-06 to 2019-08-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(3, 3, 1, 'KENNETH', 3, '2019-09-06', 'from 2019-08-06 to 2019-09-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(4, 4, 1, 'KENNETH', 4, '2019-10-06', 'from 2019-09-06 to 2019-10-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(5, 5, 1, 'KENNETH', 5, '2019-11-06', 'from 2019-10-06 to 2019-11-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(6, 6, 1, 'KENNETH', 6, '2019-12-06', 'from 2019-11-06 to 2019-12-06', 150000, 150000, 50000, 'NOT CLEARED', 'passed'),
(7, 7, 1, 'KENNETH', 7, '2020-01-06', 'from 2019-12-06 to 2020-01-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(8, 8, 1, 'KENNETH', 8, '2020-02-06', 'from 2020-01-06 to 2020-02-06', 180000, 180000, 20000, 'NOT CLEARED', 'not_passed'),
(9, 9, 1, 'KENNETH', 9, '2020-03-06', 'from 2020-02-06 to 2020-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(10, 10, 1, 'KENNETH', 10, '2020-04-06', 'from 2020-03-06 to 2020-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(11, 11, 1, 'KENNETH', 11, '2020-05-06', 'from 2020-04-06 to 2020-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(12, 12, 1, 'KENNETH', 12, '2020-06-06', 'from 2020-05-06 to 2020-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(13, 13, 1, 'KENNETH', 13, '2020-07-06', 'from 2020-06-06 to 2020-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(14, 14, 1, 'KENNETH', 14, '2020-08-06', 'from 2020-07-06 to 2020-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(15, 15, 1, 'KENNETH', 15, '2020-09-06', 'from 2020-08-06 to 2020-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(16, 16, 1, 'KENNETH', 16, '2020-10-06', 'from 2020-09-06 to 2020-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(17, 17, 1, 'KENNETH', 17, '2020-11-06', 'from 2020-10-06 to 2020-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(18, 18, 1, 'KENNETH', 18, '2020-12-06', 'from 2020-11-06 to 2020-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(19, 19, 1, 'KENNETH', 19, '2021-01-06', 'from 2020-12-06 to 2021-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(20, 20, 1, 'KENNETH', 20, '2021-02-06', 'from 2021-01-06 to 2021-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(21, 21, 1, 'KENNETH', 21, '2021-03-06', 'from 2021-02-06 to 2021-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(22, 22, 1, 'KENNETH', 22, '2021-04-06', 'from 2021-03-06 to 2021-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(23, 23, 1, 'KENNETH', 23, '2021-05-06', 'from 2021-04-06 to 2021-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(24, 24, 1, 'KENNETH', 24, '2021-06-06', 'from 2021-05-06 to 2021-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(25, 25, 1, 'KENNETH', 25, '2021-07-06', 'from 2021-06-06 to 2021-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(26, 26, 1, 'KENNETH', 26, '2021-08-06', 'from 2021-07-06 to 2021-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(27, 27, 1, 'KENNETH', 27, '2021-09-06', 'from 2021-08-06 to 2021-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(28, 28, 1, 'KENNETH', 28, '2021-10-06', 'from 2021-09-06 to 2021-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(29, 29, 1, 'KENNETH', 29, '2021-11-06', 'from 2021-10-06 to 2021-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(30, 30, 1, 'KENNETH', 30, '2021-12-06', 'from 2021-11-06 to 2021-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(31, 31, 1, 'KENNETH', 31, '2022-01-06', 'from 2021-12-06 to 2022-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(32, 32, 1, 'KENNETH', 32, '2022-02-06', 'from 2022-01-06 to 2022-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(33, 33, 1, 'KENNETH', 33, '2022-03-06', 'from 2022-02-06 to 2022-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(34, 34, 1, 'KENNETH', 34, '2022-04-06', 'from 2022-03-06 to 2022-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(35, 35, 1, 'KENNETH', 35, '2022-05-06', 'from 2022-04-06 to 2022-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(36, 36, 1, 'KENNETH', 36, '2022-06-06', 'from 2022-05-06 to 2022-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(37, 37, 1, 'KENNETH', 37, '2022-07-06', 'from 2022-06-06 to 2022-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(38, 38, 1, 'KENNETH', 38, '2022-08-06', 'from 2022-07-06 to 2022-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(39, 39, 1, 'KENNETH', 39, '2022-09-06', 'from 2022-08-06 to 2022-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(40, 40, 1, 'KENNETH', 40, '2022-10-06', 'from 2022-09-06 to 2022-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(41, 41, 1, 'KENNETH', 41, '2022-11-06', 'from 2022-10-06 to 2022-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(42, 42, 1, 'KENNETH', 42, '2022-12-06', 'from 2022-11-06 to 2022-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(43, 43, 1, 'KENNETH', 43, '2023-01-06', 'from 2022-12-06 to 2023-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(44, 44, 1, 'KENNETH', 44, '2023-02-06', 'from 2023-01-06 to 2023-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(45, 45, 1, 'KENNETH', 45, '2023-03-06', 'from 2023-02-06 to 2023-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(46, 46, 1, 'KENNETH', 46, '2023-04-06', 'from 2023-03-06 to 2023-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(47, 47, 1, 'KENNETH', 47, '2023-05-06', 'from 2023-04-06 to 2023-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(48, 48, 1, 'KENNETH', 48, '2023-06-06', 'from 2023-05-06 to 2023-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(49, 49, 1, 'KENNETH', 49, '2023-07-06', 'from 2023-06-06 to 2023-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(50, 50, 1, 'KENNETH', 50, '2023-08-06', 'from 2023-07-06 to 2023-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(51, 51, 1, 'KENNETH', 51, '2023-09-06', 'from 2023-08-06 to 2023-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(52, 52, 1, 'KENNETH', 52, '2023-10-06', 'from 2023-09-06 to 2023-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(53, 53, 1, 'KENNETH', 53, '2023-11-06', 'from 2023-10-06 to 2023-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(54, 54, 1, 'KENNETH', 54, '2023-12-06', 'from 2023-11-06 to 2023-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(55, 55, 1, 'KENNETH', 55, '2024-01-06', 'from 2023-12-06 to 2024-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(56, 56, 1, 'KENNETH', 56, '2024-02-06', 'from 2024-01-06 to 2024-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(57, 57, 1, 'KENNETH', 57, '2024-03-06', 'from 2024-02-06 to 2024-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(58, 58, 1, 'KENNETH', 58, '2024-04-06', 'from 2024-03-06 to 2024-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(59, 59, 1, 'KENNETH', 59, '2024-05-06', 'from 2024-04-06 to 2024-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(60, 60, 1, 'KENNETH', 60, '2024-06-06', 'from 2024-05-06 to 2024-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(61, 1, 2, 'SUREA NJUKI', 1, '2019-07-06', 'from 2019-06-06 to 2019-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(62, 2, 2, 'SUREA NJUKI', 2, '2019-08-06', 'from 2019-07-06 to 2019-08-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(63, 3, 2, 'SUREA NJUKI', 3, '2019-09-06', 'from 2019-08-06 to 2019-09-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(64, 4, 2, 'SUREA NJUKI', 4, '2019-10-06', 'from 2019-09-06 to 2019-10-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(65, 5, 2, 'SUREA NJUKI', 5, '2019-11-06', 'from 2019-10-06 to 2019-11-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(66, 6, 2, 'SUREA NJUKI', 6, '2019-12-06', 'from 2019-11-06 to 2019-12-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(67, 7, 2, 'SUREA NJUKI', 7, '2020-01-06', 'from 2019-12-06 to 2020-01-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(68, 8, 2, 'SUREA NJUKI', 8, '2020-02-06', 'from 2020-01-06 to 2020-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(69, 9, 2, 'SUREA NJUKI', 9, '2020-03-06', 'from 2020-02-06 to 2020-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(70, 10, 2, 'SUREA NJUKI', 10, '2020-04-06', 'from 2020-03-06 to 2020-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(71, 11, 2, 'SUREA NJUKI', 11, '2020-05-06', 'from 2020-04-06 to 2020-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(72, 12, 2, 'SUREA NJUKI', 12, '2020-06-06', 'from 2020-05-06 to 2020-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(73, 13, 2, 'SUREA NJUKI', 13, '2020-07-06', 'from 2020-06-06 to 2020-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(74, 14, 2, 'SUREA NJUKI', 14, '2020-08-06', 'from 2020-07-06 to 2020-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(75, 15, 2, 'SUREA NJUKI', 15, '2020-09-06', 'from 2020-08-06 to 2020-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(76, 16, 2, 'SUREA NJUKI', 16, '2020-10-06', 'from 2020-09-06 to 2020-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(77, 17, 2, 'SUREA NJUKI', 17, '2020-11-06', 'from 2020-10-06 to 2020-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(78, 18, 2, 'SUREA NJUKI', 18, '2020-12-06', 'from 2020-11-06 to 2020-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(79, 19, 2, 'SUREA NJUKI', 19, '2021-01-06', 'from 2020-12-06 to 2021-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(80, 20, 2, 'SUREA NJUKI', 20, '2021-02-06', 'from 2021-01-06 to 2021-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(81, 21, 2, 'SUREA NJUKI', 21, '2021-03-06', 'from 2021-02-06 to 2021-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(82, 22, 2, 'SUREA NJUKI', 22, '2021-04-06', 'from 2021-03-06 to 2021-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(83, 23, 2, 'SUREA NJUKI', 23, '2021-05-06', 'from 2021-04-06 to 2021-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(84, 24, 2, 'SUREA NJUKI', 24, '2021-06-06', 'from 2021-05-06 to 2021-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(85, 25, 2, 'SUREA NJUKI', 25, '2021-07-06', 'from 2021-06-06 to 2021-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(86, 26, 2, 'SUREA NJUKI', 26, '2021-08-06', 'from 2021-07-06 to 2021-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(87, 27, 2, 'SUREA NJUKI', 27, '2021-09-06', 'from 2021-08-06 to 2021-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(88, 28, 2, 'SUREA NJUKI', 28, '2021-10-06', 'from 2021-09-06 to 2021-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(89, 29, 2, 'SUREA NJUKI', 29, '2021-11-06', 'from 2021-10-06 to 2021-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(90, 30, 2, 'SUREA NJUKI', 30, '2021-12-06', 'from 2021-11-06 to 2021-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(91, 31, 2, 'SUREA NJUKI', 31, '2022-01-06', 'from 2021-12-06 to 2022-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(92, 32, 2, 'SUREA NJUKI', 32, '2022-02-06', 'from 2022-01-06 to 2022-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(93, 33, 2, 'SUREA NJUKI', 33, '2022-03-06', 'from 2022-02-06 to 2022-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(94, 34, 2, 'SUREA NJUKI', 34, '2022-04-06', 'from 2022-03-06 to 2022-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(95, 35, 2, 'SUREA NJUKI', 35, '2022-05-06', 'from 2022-04-06 to 2022-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(96, 36, 2, 'SUREA NJUKI', 36, '2022-06-06', 'from 2022-05-06 to 2022-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(97, 37, 2, 'SUREA NJUKI', 37, '2022-07-06', 'from 2022-06-06 to 2022-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(98, 38, 2, 'SUREA NJUKI', 38, '2022-08-06', 'from 2022-07-06 to 2022-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(99, 39, 2, 'SUREA NJUKI', 39, '2022-09-06', 'from 2022-08-06 to 2022-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(100, 40, 2, 'SUREA NJUKI', 40, '2022-10-06', 'from 2022-09-06 to 2022-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(101, 41, 2, 'SUREA NJUKI', 41, '2022-11-06', 'from 2022-10-06 to 2022-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(102, 42, 2, 'SUREA NJUKI', 42, '2022-12-06', 'from 2022-11-06 to 2022-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(103, 43, 2, 'SUREA NJUKI', 43, '2023-01-06', 'from 2022-12-06 to 2023-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(104, 44, 2, 'SUREA NJUKI', 44, '2023-02-06', 'from 2023-01-06 to 2023-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(105, 45, 2, 'SUREA NJUKI', 45, '2023-03-06', 'from 2023-02-06 to 2023-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(106, 46, 2, 'SUREA NJUKI', 46, '2023-04-06', 'from 2023-03-06 to 2023-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(107, 47, 2, 'SUREA NJUKI', 47, '2023-05-06', 'from 2023-04-06 to 2023-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(108, 48, 2, 'SUREA NJUKI', 48, '2023-06-06', 'from 2023-05-06 to 2023-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(109, 49, 2, 'SUREA NJUKI', 49, '2023-07-06', 'from 2023-06-06 to 2023-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(110, 50, 2, 'SUREA NJUKI', 50, '2023-08-06', 'from 2023-07-06 to 2023-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(111, 51, 2, 'SUREA NJUKI', 51, '2023-09-06', 'from 2023-08-06 to 2023-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(112, 52, 2, 'SUREA NJUKI', 52, '2023-10-06', 'from 2023-09-06 to 2023-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(113, 53, 2, 'SUREA NJUKI', 53, '2023-11-06', 'from 2023-10-06 to 2023-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(114, 54, 2, 'SUREA NJUKI', 54, '2023-12-06', 'from 2023-11-06 to 2023-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(115, 55, 2, 'SUREA NJUKI', 55, '2024-01-06', 'from 2023-12-06 to 2024-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(116, 56, 2, 'SUREA NJUKI', 56, '2024-02-06', 'from 2024-01-06 to 2024-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(117, 57, 2, 'SUREA NJUKI', 57, '2024-03-06', 'from 2024-02-06 to 2024-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(118, 58, 2, 'SUREA NJUKI', 58, '2024-04-06', 'from 2024-03-06 to 2024-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(119, 59, 2, 'SUREA NJUKI', 59, '2024-05-06', 'from 2024-04-06 to 2024-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(120, 60, 2, 'SUREA NJUKI', 60, '2024-06-06', 'from 2024-05-06 to 2024-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(121, 1, 3, 'MAKABAYI', 1, '2019-07-06', 'from 2019-06-06 to 2019-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(122, 2, 3, 'MAKABAYI', 2, '2019-08-06', 'from 2019-07-06 to 2019-08-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(123, 3, 3, 'MAKABAYI', 3, '2019-09-06', 'from 2019-08-06 to 2019-09-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(124, 4, 3, 'MAKABAYI', 4, '2019-10-06', 'from 2019-09-06 to 2019-10-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(125, 5, 3, 'MAKABAYI', 5, '2019-11-06', 'from 2019-10-06 to 2019-11-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(126, 6, 3, 'MAKABAYI', 6, '2019-12-06', 'from 2019-11-06 to 2019-12-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(127, 7, 3, 'MAKABAYI', 7, '2020-01-06', 'from 2019-12-06 to 2020-01-06', 0, 0, 200000, 'NOT CLEARED', 'passed'),
(128, 8, 3, 'MAKABAYI', 8, '2020-02-06', 'from 2020-01-06 to 2020-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(129, 9, 3, 'MAKABAYI', 9, '2020-03-06', 'from 2020-02-06 to 2020-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(130, 10, 3, 'MAKABAYI', 10, '2020-04-06', 'from 2020-03-06 to 2020-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(131, 11, 3, 'MAKABAYI', 11, '2020-05-06', 'from 2020-04-06 to 2020-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(132, 12, 3, 'MAKABAYI', 12, '2020-06-06', 'from 2020-05-06 to 2020-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(133, 13, 3, 'MAKABAYI', 13, '2020-07-06', 'from 2020-06-06 to 2020-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(134, 14, 3, 'MAKABAYI', 14, '2020-08-06', 'from 2020-07-06 to 2020-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(135, 15, 3, 'MAKABAYI', 15, '2020-09-06', 'from 2020-08-06 to 2020-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(136, 16, 3, 'MAKABAYI', 16, '2020-10-06', 'from 2020-09-06 to 2020-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(137, 17, 3, 'MAKABAYI', 17, '2020-11-06', 'from 2020-10-06 to 2020-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(138, 18, 3, 'MAKABAYI', 18, '2020-12-06', 'from 2020-11-06 to 2020-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(139, 19, 3, 'MAKABAYI', 19, '2021-01-06', 'from 2020-12-06 to 2021-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(140, 20, 3, 'MAKABAYI', 20, '2021-02-06', 'from 2021-01-06 to 2021-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(141, 21, 3, 'MAKABAYI', 21, '2021-03-06', 'from 2021-02-06 to 2021-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(142, 22, 3, 'MAKABAYI', 22, '2021-04-06', 'from 2021-03-06 to 2021-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(143, 23, 3, 'MAKABAYI', 23, '2021-05-06', 'from 2021-04-06 to 2021-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(144, 24, 3, 'MAKABAYI', 24, '2021-06-06', 'from 2021-05-06 to 2021-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(145, 25, 3, 'MAKABAYI', 25, '2021-07-06', 'from 2021-06-06 to 2021-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(146, 26, 3, 'MAKABAYI', 26, '2021-08-06', 'from 2021-07-06 to 2021-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(147, 27, 3, 'MAKABAYI', 27, '2021-09-06', 'from 2021-08-06 to 2021-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(148, 28, 3, 'MAKABAYI', 28, '2021-10-06', 'from 2021-09-06 to 2021-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(149, 29, 3, 'MAKABAYI', 29, '2021-11-06', 'from 2021-10-06 to 2021-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(150, 30, 3, 'MAKABAYI', 30, '2021-12-06', 'from 2021-11-06 to 2021-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(151, 31, 3, 'MAKABAYI', 31, '2022-01-06', 'from 2021-12-06 to 2022-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(152, 32, 3, 'MAKABAYI', 32, '2022-02-06', 'from 2022-01-06 to 2022-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(153, 33, 3, 'MAKABAYI', 33, '2022-03-06', 'from 2022-02-06 to 2022-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(154, 34, 3, 'MAKABAYI', 34, '2022-04-06', 'from 2022-03-06 to 2022-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(155, 35, 3, 'MAKABAYI', 35, '2022-05-06', 'from 2022-04-06 to 2022-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(156, 36, 3, 'MAKABAYI', 36, '2022-06-06', 'from 2022-05-06 to 2022-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(157, 37, 3, 'MAKABAYI', 37, '2022-07-06', 'from 2022-06-06 to 2022-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(158, 38, 3, 'MAKABAYI', 38, '2022-08-06', 'from 2022-07-06 to 2022-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(159, 39, 3, 'MAKABAYI', 39, '2022-09-06', 'from 2022-08-06 to 2022-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(160, 40, 3, 'MAKABAYI', 40, '2022-10-06', 'from 2022-09-06 to 2022-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(161, 41, 3, 'MAKABAYI', 41, '2022-11-06', 'from 2022-10-06 to 2022-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(162, 42, 3, 'MAKABAYI', 42, '2022-12-06', 'from 2022-11-06 to 2022-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(163, 43, 3, 'MAKABAYI', 43, '2023-01-06', 'from 2022-12-06 to 2023-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(164, 44, 3, 'MAKABAYI', 44, '2023-02-06', 'from 2023-01-06 to 2023-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(165, 45, 3, 'MAKABAYI', 45, '2023-03-06', 'from 2023-02-06 to 2023-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(166, 46, 3, 'MAKABAYI', 46, '2023-04-06', 'from 2023-03-06 to 2023-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(167, 47, 3, 'MAKABAYI', 47, '2023-05-06', 'from 2023-04-06 to 2023-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(168, 48, 3, 'MAKABAYI', 48, '2023-06-06', 'from 2023-05-06 to 2023-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(169, 49, 3, 'MAKABAYI', 49, '2023-07-06', 'from 2023-06-06 to 2023-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(170, 50, 3, 'MAKABAYI', 50, '2023-08-06', 'from 2023-07-06 to 2023-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(171, 51, 3, 'MAKABAYI', 51, '2023-09-06', 'from 2023-08-06 to 2023-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(172, 52, 3, 'MAKABAYI', 52, '2023-10-06', 'from 2023-09-06 to 2023-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(173, 53, 3, 'MAKABAYI', 53, '2023-11-06', 'from 2023-10-06 to 2023-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(174, 54, 3, 'MAKABAYI', 54, '2023-12-06', 'from 2023-11-06 to 2023-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(175, 55, 3, 'MAKABAYI', 55, '2024-01-06', 'from 2023-12-06 to 2024-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(176, 56, 3, 'MAKABAYI', 56, '2024-02-06', 'from 2024-01-06 to 2024-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(177, 57, 3, 'MAKABAYI', 57, '2024-03-06', 'from 2024-02-06 to 2024-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(178, 58, 3, 'MAKABAYI', 58, '2024-04-06', 'from 2024-03-06 to 2024-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(179, 59, 3, 'MAKABAYI', 59, '2024-05-06', 'from 2024-04-06 to 2024-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(180, 60, 3, 'MAKABAYI', 60, '2024-06-06', 'from 2024-05-06 to 2024-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(181, 1, 4, 'GGAYI FRANKLIN', 1, '2019-07-06', 'from 2019-06-06 to 2019-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(182, 2, 4, 'GGAYI FRANKLIN', 2, '2019-08-06', 'from 2019-07-06 to 2019-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(183, 3, 4, 'GGAYI FRANKLIN', 3, '2019-09-06', 'from 2019-08-06 to 2019-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(184, 4, 4, 'GGAYI FRANKLIN', 4, '2019-10-06', 'from 2019-09-06 to 2019-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(185, 5, 4, 'GGAYI FRANKLIN', 5, '2019-11-06', 'from 2019-10-06 to 2019-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(186, 6, 4, 'GGAYI FRANKLIN', 6, '2019-12-06', 'from 2019-11-06 to 2019-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(187, 7, 4, 'GGAYI FRANKLIN', 7, '2020-01-06', 'from 2019-12-06 to 2020-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(188, 8, 4, 'GGAYI FRANKLIN', 8, '2020-02-06', 'from 2020-01-06 to 2020-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(189, 9, 4, 'GGAYI FRANKLIN', 9, '2020-03-06', 'from 2020-02-06 to 2020-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(190, 10, 4, 'GGAYI FRANKLIN', 10, '2020-04-06', 'from 2020-03-06 to 2020-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(191, 11, 4, 'GGAYI FRANKLIN', 11, '2020-05-06', 'from 2020-04-06 to 2020-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(192, 12, 4, 'GGAYI FRANKLIN', 12, '2020-06-06', 'from 2020-05-06 to 2020-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(193, 13, 4, 'GGAYI FRANKLIN', 13, '2020-07-06', 'from 2020-06-06 to 2020-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(194, 14, 4, 'GGAYI FRANKLIN', 14, '2020-08-06', 'from 2020-07-06 to 2020-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(195, 15, 4, 'GGAYI FRANKLIN', 15, '2020-09-06', 'from 2020-08-06 to 2020-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(196, 16, 4, 'GGAYI FRANKLIN', 16, '2020-10-06', 'from 2020-09-06 to 2020-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(197, 17, 4, 'GGAYI FRANKLIN', 17, '2020-11-06', 'from 2020-10-06 to 2020-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(198, 18, 4, 'GGAYI FRANKLIN', 18, '2020-12-06', 'from 2020-11-06 to 2020-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(199, 19, 4, 'GGAYI FRANKLIN', 19, '2021-01-06', 'from 2020-12-06 to 2021-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(200, 20, 4, 'GGAYI FRANKLIN', 20, '2021-02-06', 'from 2021-01-06 to 2021-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(201, 21, 4, 'GGAYI FRANKLIN', 21, '2021-03-06', 'from 2021-02-06 to 2021-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(202, 22, 4, 'GGAYI FRANKLIN', 22, '2021-04-06', 'from 2021-03-06 to 2021-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(203, 23, 4, 'GGAYI FRANKLIN', 23, '2021-05-06', 'from 2021-04-06 to 2021-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(204, 24, 4, 'GGAYI FRANKLIN', 24, '2021-06-06', 'from 2021-05-06 to 2021-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(205, 25, 4, 'GGAYI FRANKLIN', 25, '2021-07-06', 'from 2021-06-06 to 2021-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(206, 26, 4, 'GGAYI FRANKLIN', 26, '2021-08-06', 'from 2021-07-06 to 2021-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(207, 27, 4, 'GGAYI FRANKLIN', 27, '2021-09-06', 'from 2021-08-06 to 2021-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(208, 28, 4, 'GGAYI FRANKLIN', 28, '2021-10-06', 'from 2021-09-06 to 2021-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(209, 29, 4, 'GGAYI FRANKLIN', 29, '2021-11-06', 'from 2021-10-06 to 2021-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(210, 30, 4, 'GGAYI FRANKLIN', 30, '2021-12-06', 'from 2021-11-06 to 2021-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(211, 31, 4, 'GGAYI FRANKLIN', 31, '2022-01-06', 'from 2021-12-06 to 2022-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(212, 32, 4, 'GGAYI FRANKLIN', 32, '2022-02-06', 'from 2022-01-06 to 2022-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(213, 33, 4, 'GGAYI FRANKLIN', 33, '2022-03-06', 'from 2022-02-06 to 2022-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(214, 34, 4, 'GGAYI FRANKLIN', 34, '2022-04-06', 'from 2022-03-06 to 2022-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(215, 35, 4, 'GGAYI FRANKLIN', 35, '2022-05-06', 'from 2022-04-06 to 2022-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(216, 36, 4, 'GGAYI FRANKLIN', 36, '2022-06-06', 'from 2022-05-06 to 2022-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(217, 37, 4, 'GGAYI FRANKLIN', 37, '2022-07-06', 'from 2022-06-06 to 2022-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(218, 38, 4, 'GGAYI FRANKLIN', 38, '2022-08-06', 'from 2022-07-06 to 2022-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(219, 39, 4, 'GGAYI FRANKLIN', 39, '2022-09-06', 'from 2022-08-06 to 2022-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(220, 40, 4, 'GGAYI FRANKLIN', 40, '2022-10-06', 'from 2022-09-06 to 2022-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(221, 41, 4, 'GGAYI FRANKLIN', 41, '2022-11-06', 'from 2022-10-06 to 2022-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(222, 42, 4, 'GGAYI FRANKLIN', 42, '2022-12-06', 'from 2022-11-06 to 2022-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(223, 43, 4, 'GGAYI FRANKLIN', 43, '2023-01-06', 'from 2022-12-06 to 2023-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(224, 44, 4, 'GGAYI FRANKLIN', 44, '2023-02-06', 'from 2023-01-06 to 2023-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(225, 45, 4, 'GGAYI FRANKLIN', 45, '2023-03-06', 'from 2023-02-06 to 2023-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(226, 46, 4, 'GGAYI FRANKLIN', 46, '2023-04-06', 'from 2023-03-06 to 2023-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(227, 47, 4, 'GGAYI FRANKLIN', 47, '2023-05-06', 'from 2023-04-06 to 2023-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(228, 48, 4, 'GGAYI FRANKLIN', 48, '2023-06-06', 'from 2023-05-06 to 2023-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(229, 49, 4, 'GGAYI FRANKLIN', 49, '2023-07-06', 'from 2023-06-06 to 2023-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(230, 50, 4, 'GGAYI FRANKLIN', 50, '2023-08-06', 'from 2023-07-06 to 2023-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(231, 51, 4, 'GGAYI FRANKLIN', 51, '2023-09-06', 'from 2023-08-06 to 2023-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(232, 52, 4, 'GGAYI FRANKLIN', 52, '2023-10-06', 'from 2023-09-06 to 2023-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(233, 53, 4, 'GGAYI FRANKLIN', 53, '2023-11-06', 'from 2023-10-06 to 2023-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(234, 54, 4, 'GGAYI FRANKLIN', 54, '2023-12-06', 'from 2023-11-06 to 2023-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(235, 55, 4, 'GGAYI FRANKLIN', 55, '2024-01-06', 'from 2023-12-06 to 2024-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(236, 56, 4, 'GGAYI FRANKLIN', 56, '2024-02-06', 'from 2024-01-06 to 2024-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(237, 57, 4, 'GGAYI FRANKLIN', 57, '2024-03-06', 'from 2024-02-06 to 2024-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(238, 58, 4, 'GGAYI FRANKLIN', 58, '2024-04-06', 'from 2024-03-06 to 2024-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(239, 59, 4, 'GGAYI FRANKLIN', 59, '2024-05-06', 'from 2024-04-06 to 2024-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(240, 60, 4, 'GGAYI FRANKLIN', 60, '2024-06-06', 'from 2024-05-06 to 2024-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(241, 1, 5, 'ALAINE', 1, '2019-07-06', 'from 2019-06-06 to 2019-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(242, 2, 5, 'ALAINE', 2, '2019-08-06', 'from 2019-07-06 to 2019-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(243, 3, 5, 'ALAINE', 3, '2019-09-06', 'from 2019-08-06 to 2019-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(244, 4, 5, 'ALAINE', 4, '2019-10-06', 'from 2019-09-06 to 2019-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(245, 5, 5, 'ALAINE', 5, '2019-11-06', 'from 2019-10-06 to 2019-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(246, 6, 5, 'ALAINE', 6, '2019-12-06', 'from 2019-11-06 to 2019-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(247, 7, 5, 'ALAINE', 7, '2020-01-06', 'from 2019-12-06 to 2020-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(248, 8, 5, 'ALAINE', 8, '2020-02-06', 'from 2020-01-06 to 2020-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(249, 9, 5, 'ALAINE', 9, '2020-03-06', 'from 2020-02-06 to 2020-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(250, 10, 5, 'ALAINE', 10, '2020-04-06', 'from 2020-03-06 to 2020-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(251, 11, 5, 'ALAINE', 11, '2020-05-06', 'from 2020-04-06 to 2020-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(252, 12, 5, 'ALAINE', 12, '2020-06-06', 'from 2020-05-06 to 2020-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(253, 13, 5, 'ALAINE', 13, '2020-07-06', 'from 2020-06-06 to 2020-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(254, 14, 5, 'ALAINE', 14, '2020-08-06', 'from 2020-07-06 to 2020-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(255, 15, 5, 'ALAINE', 15, '2020-09-06', 'from 2020-08-06 to 2020-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(256, 16, 5, 'ALAINE', 16, '2020-10-06', 'from 2020-09-06 to 2020-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(257, 17, 5, 'ALAINE', 17, '2020-11-06', 'from 2020-10-06 to 2020-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(258, 18, 5, 'ALAINE', 18, '2020-12-06', 'from 2020-11-06 to 2020-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(259, 19, 5, 'ALAINE', 19, '2021-01-06', 'from 2020-12-06 to 2021-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(260, 20, 5, 'ALAINE', 20, '2021-02-06', 'from 2021-01-06 to 2021-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(261, 21, 5, 'ALAINE', 21, '2021-03-06', 'from 2021-02-06 to 2021-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(262, 22, 5, 'ALAINE', 22, '2021-04-06', 'from 2021-03-06 to 2021-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(263, 23, 5, 'ALAINE', 23, '2021-05-06', 'from 2021-04-06 to 2021-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(264, 24, 5, 'ALAINE', 24, '2021-06-06', 'from 2021-05-06 to 2021-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(265, 25, 5, 'ALAINE', 25, '2021-07-06', 'from 2021-06-06 to 2021-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(266, 26, 5, 'ALAINE', 26, '2021-08-06', 'from 2021-07-06 to 2021-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(267, 27, 5, 'ALAINE', 27, '2021-09-06', 'from 2021-08-06 to 2021-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(268, 28, 5, 'ALAINE', 28, '2021-10-06', 'from 2021-09-06 to 2021-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(269, 29, 5, 'ALAINE', 29, '2021-11-06', 'from 2021-10-06 to 2021-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(270, 30, 5, 'ALAINE', 30, '2021-12-06', 'from 2021-11-06 to 2021-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(271, 31, 5, 'ALAINE', 31, '2022-01-06', 'from 2021-12-06 to 2022-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(272, 32, 5, 'ALAINE', 32, '2022-02-06', 'from 2022-01-06 to 2022-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(273, 33, 5, 'ALAINE', 33, '2022-03-06', 'from 2022-02-06 to 2022-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(274, 34, 5, 'ALAINE', 34, '2022-04-06', 'from 2022-03-06 to 2022-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(275, 35, 5, 'ALAINE', 35, '2022-05-06', 'from 2022-04-06 to 2022-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(276, 36, 5, 'ALAINE', 36, '2022-06-06', 'from 2022-05-06 to 2022-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(277, 37, 5, 'ALAINE', 37, '2022-07-06', 'from 2022-06-06 to 2022-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(278, 38, 5, 'ALAINE', 38, '2022-08-06', 'from 2022-07-06 to 2022-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(279, 39, 5, 'ALAINE', 39, '2022-09-06', 'from 2022-08-06 to 2022-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(280, 40, 5, 'ALAINE', 40, '2022-10-06', 'from 2022-09-06 to 2022-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(281, 41, 5, 'ALAINE', 41, '2022-11-06', 'from 2022-10-06 to 2022-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(282, 42, 5, 'ALAINE', 42, '2022-12-06', 'from 2022-11-06 to 2022-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(283, 43, 5, 'ALAINE', 43, '2023-01-06', 'from 2022-12-06 to 2023-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(284, 44, 5, 'ALAINE', 44, '2023-02-06', 'from 2023-01-06 to 2023-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(285, 45, 5, 'ALAINE', 45, '2023-03-06', 'from 2023-02-06 to 2023-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(286, 46, 5, 'ALAINE', 46, '2023-04-06', 'from 2023-03-06 to 2023-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(287, 47, 5, 'ALAINE', 47, '2023-05-06', 'from 2023-04-06 to 2023-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(288, 48, 5, 'ALAINE', 48, '2023-06-06', 'from 2023-05-06 to 2023-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(289, 49, 5, 'ALAINE', 49, '2023-07-06', 'from 2023-06-06 to 2023-07-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(290, 50, 5, 'ALAINE', 50, '2023-08-06', 'from 2023-07-06 to 2023-08-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(291, 51, 5, 'ALAINE', 51, '2023-09-06', 'from 2023-08-06 to 2023-09-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(292, 52, 5, 'ALAINE', 52, '2023-10-06', 'from 2023-09-06 to 2023-10-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(293, 53, 5, 'ALAINE', 53, '2023-11-06', 'from 2023-10-06 to 2023-11-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(294, 54, 5, 'ALAINE', 54, '2023-12-06', 'from 2023-11-06 to 2023-12-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(295, 55, 5, 'ALAINE', 55, '2024-01-06', 'from 2023-12-06 to 2024-01-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(296, 56, 5, 'ALAINE', 56, '2024-02-06', 'from 2024-01-06 to 2024-02-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(297, 57, 5, 'ALAINE', 57, '2024-03-06', 'from 2024-02-06 to 2024-03-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(298, 58, 5, 'ALAINE', 58, '2024-04-06', 'from 2024-03-06 to 2024-04-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(299, 59, 5, 'ALAINE', 59, '2024-05-06', 'from 2024-04-06 to 2024-05-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed'),
(300, 60, 5, 'ALAINE', 60, '2024-06-06', 'from 2024-05-06 to 2024-06-06', 0, 0, 200000, 'NOT CLEARED', 'not_passed');

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE `savings` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL,
  `payment_id` int(11) NOT NULL,
  `date_range` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `savings`
--

INSERT INTO `savings` (`id`, `member_id`, `member`, `amount`, `date`, `payment_id`, `date_range`) VALUES
(1, 1, 'KENNETH', 200000, '2019-07-04', 1, 1),
(2, 1, 'KENNETH', 150000, '2019-11-12', 2, 6),
(3, 1, 'KENNETH', 180000, '2020-02-02', 3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `total_balances`
--

CREATE TABLE `total_balances` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(255) NOT NULL,
  `total_balances` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `total_balances`
--

INSERT INTO `total_balances` (`id`, `member_id`, `member`, `total_balances`, `amount_paid`) VALUES
(1, 1, 'KENNETH', 50000, 1000000),
(2, 2, 'SUREA NJUKI', 0, 0),
(3, 3, 'MAKABAYI', 0, 0),
(4, 4, 'GGAYI FRANKLIN', 0, 0),
(5, 5, 'ALAINE', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `total_fines`
--

CREATE TABLE `total_fines` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `total_fines` int(11) NOT NULL,
  `member` varchar(255) NOT NULL,
  `amount_paid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `total_fines`
--

INSERT INTO `total_fines` (`id`, `member_id`, `total_fines`, `member`, `amount_paid`) VALUES
(1, 1, 5000, 'KENNETH', 80000),
(2, 2, 30000, 'SUREA NJUKI', 0),
(3, 3, 30000, 'MAKABAYI', 0),
(4, 4, 0, 'GGAYI FRANKLIN', 0),
(5, 5, 0, 'ALAINE', 0);

-- --------------------------------------------------------

--
-- Table structure for table `total_savings`
--

CREATE TABLE `total_savings` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `amount_total` int(11) NOT NULL,
  `member` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `total_savings`
--

INSERT INTO `total_savings` (`id`, `member_id`, `amount_total`, `member`) VALUES
(1, 1, 530000, 'KENNETH');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `member_id` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `date`, `member_id`, `names`, `type`, `amount`, `payment_id`) VALUES
(1, '2019-07-04', 1, 'KENNETH', 'savings_payment', 200000, 1),
(2, '2019-11-12', 1, 'KENNETH', 'savings_payment', 150000, 2),
(3, '2020-02-02', 1, 'KENNETH', 'savings_payment', 180000, 3),
(4, '2020-02-02', 1, 'KENNETH', 'fines_payment', 30000, 4),
(5, '2020-02-02', 1, 'KENNETH', 'fines_payment', 30000, 4),
(6, '2020-02-02', 1, 'KENNETH', 'fines_payment', 20000, 4),
(7, '2020-02-02', 1, 'KENNETH', 'balances_payment', 200000, 5),
(8, '2020-02-02', 1, 'KENNETH', 'balances_payment', 200000, 5),
(9, '2020-02-02', 1, 'KENNETH', 'balances_payment', 200000, 5),
(10, '2020-02-02', 1, 'KENNETH', 'balances_payment', 200000, 5),
(11, '2020-02-02', 1, 'KENNETH', 'balances_payment', 50000, 5),
(12, '2020-02-02', 1, 'KENNETH', 'balances_payment', 150000, 5),
(13, '2019-07-09', 1, 'KENNETH', 'loan_aquisition', 1000000, NULL),
(14, '2019-07-04', 1, 'KENNETH', 'loan_payment', 200000, 1),
(15, '2019-10-20', 1, 'KENNETH', 'loan_payment', 500000, 6),
(16, '2019-11-12', 1, 'KENNETH', 'loan_payment', 150000, 2),
(17, '2019-11-30', 1, 'KENNETH', 'loan_payment', 400000, 7),
(18, '2019-12-16', 1, 'KENNETH', 'loan_payment', 200000, 8),
(19, '2020-02-02', 1, 'KENNETH', 'loan_payment', 180000, 3),
(20, '2020-02-02', 1, 'KENNETH', 'loan_payment', 80000, 4),
(21, '2020-02-02', 1, 'KENNETH', 'loan_payment', 1000000, 5),
(22, '2019-07-09', 2, 'SUREA NJUKI', 'loan_aquisition', 2000000, NULL),
(23, '2019-10-20', 2, 'SUREA NJUKI', 'loan_payment', 1000000, 9),
(24, '2019-11-30', 2, 'SUREA NJUKI', 'loan_payment', 800000, 10),
(25, '2019-12-16', 2, 'SUREA NJUKI', 'loan_payment', 400000, 11),
(26, '2019-07-09', 3, 'MAKABAYI', 'loan_aquisition', 1000000, NULL),
(27, '2019-10-20', 3, 'MAKABAYI', 'loan_payment', 500000, 12),
(28, '2019-11-30', 3, 'MAKABAYI', 'loan_payment', 400000, 13),
(29, '2019-12-16', 3, 'MAKABAYI', 'loan_payment', 200000, 14),
(30, '2019-07-09', 4, 'GGAYI FRANKLIN', 'loan_aquisition', 1000000, NULL),
(31, '2019-10-20', 4, 'GGAYI FRANKLIN', 'loan_payment', 500000, 15),
(32, '2019-11-30', 4, 'GGAYI FRANKLIN', 'loan_payment', 400000, 16),
(33, '2019-12-16', 4, 'GGAYI FRANKLIN', 'loan_payment', 200000, 17),
(34, '2019-01-09', 5, 'ALAINE', 'loan_aquisition', 1000000, NULL),
(35, '2019-04-20', 5, 'ALAINE', 'loan_payment', 500000, 18),
(36, '2019-05-30', 5, 'ALAINE', 'loan_payment', 400000, 19),
(37, '2019-06-16', 5, 'ALAINE', 'loan_payment', 200000, 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `role`, `password`) VALUES
(1, 'ADMINISTRATOR', 'admin', '0192023a7bbd73250516f069df18b500'),
(2, 'KENNETH LUKUNDO', 'admin', '0b24638bdda86efbb83c85ebbbc6b670'),
(3, 'KENNETH', 'user', '25d546fb34c84a4fee11d75c6d5e39b4'),
(4, 'ADMINISTRATOR', 'admin', '29424953e2106154888d8a52d94bfbf1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chairman`
--
ALTER TABLE `chairman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fines`
--
ALTER TABLE `fines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_progress_update`
--
ALTER TABLE `loan_progress_update`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_ranges`
--
ALTER TABLE `loan_ranges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_loan_info`
--
ALTER TABLE `member_loan_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `non_members`
--
ALTER TABLE `non_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `non_member_loan_info`
--
ALTER TABLE `non_member_loan_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `non_member_transactions`
--
ALTER TABLE `non_member_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ranges`
--
ALTER TABLE `ranges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `total_balances`
--
ALTER TABLE `total_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `total_fines`
--
ALTER TABLE `total_fines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `total_savings`
--
ALTER TABLE `total_savings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chairman`
--
ALTER TABLE `chairman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fines`
--
ALTER TABLE `fines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `loan_progress_update`
--
ALTER TABLE `loan_progress_update`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `loan_ranges`
--
ALTER TABLE `loan_ranges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `member_loan_info`
--
ALTER TABLE `member_loan_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `non_members`
--
ALTER TABLE `non_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `non_member_loan_info`
--
ALTER TABLE `non_member_loan_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `non_member_transactions`
--
ALTER TABLE `non_member_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ranges`
--
ALTER TABLE `ranges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT for table `savings`
--
ALTER TABLE `savings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `total_balances`
--
ALTER TABLE `total_balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `total_fines`
--
ALTER TABLE `total_fines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `total_savings`
--
ALTER TABLE `total_savings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
