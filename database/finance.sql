-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2026 at 05:39 AM
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
-- Database: `finance`
--

-- --------------------------------------------------------

--
-- Table structure for table `finance_management_audit`
--

CREATE TABLE `finance_management_audit` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `ip` varchar(40) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `table` varchar(300) DEFAULT NULL,
  `action` varchar(250) NOT NULL,
  `description` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `finance_management_audit`
--

INSERT INTO `finance_management_audit` (`id`, `datetime`, `ip`, `user`, `table`, `action`, `description`) VALUES
(100, '2026-03-23 00:20:05', '127.0.0.1', 'user', 'tbl_users', 'failed login', ''),
(102, '2026-03-23 00:20:11', '127.0.0.1', 'user', 'tbl_users', 'failed login', ''),
(104, '2026-03-23 00:26:21', '127.0.0.1', 'user', 'tbl_users', 'login', ''),
(105, '2026-03-23 00:26:25', '127.0.0.1', 'user', 'tbl_users', 'logout', ''),
(106, '2026-03-23 00:34:39', '127.0.0.1', 'user', 'tbl_users', 'login', '');

-- --------------------------------------------------------

--
-- Table structure for table `finance_management_locking`
--

CREATE TABLE `finance_management_locking` (
  `id` int(11) NOT NULL,
  `table` varchar(300) NOT NULL,
  `startdatetime` datetime NOT NULL,
  `confirmdatetime` datetime NOT NULL,
  `keys` varchar(300) NOT NULL,
  `sessionid` varchar(100) NOT NULL,
  `userid` varchar(300) NOT NULL,
  `action` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_budgets`
--

CREATE TABLE `tbl_budgets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `budget_month` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_budgets`
--

INSERT INTO `tbl_budgets` (`id`, `user_id`, `category_id`, `budget_month`, `amount`) VALUES
(33, 1, 30, '2026-03', 190.00),
(34, 1, 33, '2026-03', 100.00),
(35, 1, 10, '2026-04', 0.00),
(36, 1, 3, '2026-03', 200.00),
(37, 1, 2, '2026-04', 500.00),
(38, 1, 34, '2026-03', 60.00),
(39, 1, 30, '2026-04', 100.00),
(40, 1, 3, '2026-04', 36.07),
(41, 1, 5, '2026-04', 915.00),
(42, 10, 39, '2026-03', 0.00),
(43, 10, 38, '2026-03', 0.00),
(44, 1, 36, '2026-04', 85.00),
(45, 1, 21, '2026-04', 220.00),
(46, 13, 48, '2026-03', 300.00),
(47, 13, 46, '2026-03', 400.00),
(48, 13, 47, '2026-03', 600.00),
(49, 13, 42, '2026-03', 6000.00),
(50, 13, 43, '2026-03', 550.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type_id` int(1) DEFAULT 1,
  `type` varchar(20) DEFAULT 'expense',
  `color_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id`, `name`, `user_id`, `type_id`, `type`, `color_code`) VALUES
(42, 'GAJI', 13, 2, 'Pendapatan', '#8b5cf6'),
(43, 'BONUS', 13, 2, 'Pendapatan', '#5ff77d'),
(44, 'BIL ELEKTRIK', 13, 3, 'Komitmen', '#f7695f'),
(45, 'BIL INTERNET', 13, 3, 'Komitmen', '#5ff7ec'),
(46, 'MAKAN LUAR', 13, 1, 'Perbelanjaan', '#f7f25f'),
(47, 'PETROL', 13, 1, 'Perbelanjaan', '#f7e25f'),
(48, 'BARANG DAPUR', 13, 1, 'Perbelanjaan', '#f7c75f'),
(49, 'SIMPANAN EMAS', 13, 4, 'Pelaburan', '#69f75f'),
(50, 'CRYPTO', 13, 4, 'Pelaburan', '#d65ff7');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expenses`
--

CREATE TABLE `tbl_expenses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `expense_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `receipt_path` varchar(255) DEFAULT NULL,
  `original_currency` varchar(10) DEFAULT 'MYR',
  `original_amount` decimal(15,2) DEFAULT NULL,
  `exchange_rate` decimal(15,6) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_lhdn` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_expenses`
--

INSERT INTO `tbl_expenses` (`id`, `user_id`, `category_id`, `expense_date`, `amount`, `description`, `receipt_path`, `original_currency`, `original_amount`, `exchange_rate`, `created_at`, `is_lhdn`) VALUES
(60, 13, 50, '2026-03-25', 350.00, 'CRYPTO', NULL, 'MYR', NULL, NULL, '2026-03-23 12:38:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_income`
--

CREATE TABLE `tbl_income` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `income_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `receipt_path` varchar(255) DEFAULT NULL,
  `original_currency` varchar(10) DEFAULT 'MYR',
  `original_amount` decimal(15,2) DEFAULT NULL,
  `exchange_rate` decimal(15,6) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_income`
--

INSERT INTO `tbl_income` (`id`, `user_id`, `income_date`, `amount`, `category_id`, `description`, `receipt_path`, `original_currency`, `original_amount`, `exchange_rate`, `created_at`) VALUES
(19, 13, '2026-03-23', 6000.00, 42, '', NULL, 'MYR', NULL, NULL, '2026-03-23 12:38:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `fullname1` mediumtext DEFAULT NULL,
  `groupid` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `ext_security_id` varchar(100) DEFAULT NULL,
  `userpic` mediumblob DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`ID`, `username`, `password`, `fullname`, `fullname1`, `groupid`, `active`, `ext_security_id`, `userpic`, `email`) VALUES
(13, 'user', '5B013E7A1EF7449BB4A073959F6F5329', 'user', NULL, NULL, 1, NULL, NULL, 'user@user.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `finance_management_audit`
--
ALTER TABLE `finance_management_audit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_management_locking`
--
ALTER TABLE `finance_management_locking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_budgets`
--
ALTER TABLE `tbl_budgets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_income`
--
ALTER TABLE `tbl_income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `finance_management_audit`
--
ALTER TABLE `finance_management_audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `finance_management_locking`
--
ALTER TABLE `finance_management_locking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_budgets`
--
ALTER TABLE `tbl_budgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tbl_income`
--
ALTER TABLE `tbl_income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
