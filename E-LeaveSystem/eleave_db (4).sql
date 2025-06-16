-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2025 at 02:28 PM
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
-- Database: `eleave_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `apply_date` date DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `permission_type` varchar(50) DEFAULT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `submit_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `system_ip` varchar(45) DEFAULT NULL,
  `approved_status` tinyint(4) DEFAULT 0,
  `approved_date` datetime DEFAULT NULL,
  `admin_remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `username`, `name`, `apply_date`, `from_date`, `to_date`, `permission_type`, `reason`, `remarks`, `submit_date`, `system_ip`, `approved_status`, `approved_date`, `admin_remarks`) VALUES
(2, 'staff', 'jebastin', '2025-05-05', '2025-05-05', '2025-05-07', 'Others', 'Others', NULL, '2025-05-05 06:00:05', '192.168.1.5', 2, NULL, NULL),
(3, 'staff', 'jebastin', '2025-05-05', '2025-05-05', '2025-05-08', 'Others', 'Personal Leave', NULL, '2025-05-05 06:02:14', '192.168.1.5', 1, NULL, NULL),
(4, 'staff', 'jebastinraj', '2025-05-05', '2025-05-05', '2025-05-14', 'Others', 'Emergency', 'ihgdkgdkahkda', '2025-05-05 06:04:41', '192.168.1.5', 2, NULL, ''),
(5, 'staff', 'Joel', '2025-05-05', '2025-05-05', '2025-05-06', 'Others', 'Sick Leave', 'tyjtjtjtejrtyyt', '2025-05-05 08:41:27', '192.168.1.5', 1, NULL, NULL),
(6, 'staff', 'jebastin', '2025-05-06', '2025-05-07', '2025-05-07', 'od', 'CL', NULL, '2025-05-06 04:32:45', '::1', 2, NULL, NULL),
(7, 'admin', 'joel', '2025-05-06', '2025-05-07', '2025-05-08', 'Full day', 'Vacation', 'no', '2025-05-06 06:08:08', '::1', 2, NULL, NULL),
(8, 'staff', 'alex', '2025-05-06', '2025-05-07', '2025-05-08', 'Half day', 'Sick Leave', 'ok', '2025-05-06 06:14:09', '::1', 2, NULL, NULL),
(10, 'staff', 'vasanth', '2025-05-06', '2025-05-16', '2025-05-17', 'Full day', 'Personal Leave', 'fffff', '2025-05-06 06:39:16', '::1', 1, NULL, 'ok'),
(12, 'jebas', 'jebastinraj', '2025-05-06', '2025-05-07', '2025-05-07', 'od', 'Others', 'od', '2025-05-06 09:09:00', '::1', 2, NULL, ''),
(13, 'staff', 'Jebastin', '2025-05-06', '2025-05-07', '2025-05-08', 'od', 'Emergency', '', '2025-05-06 09:15:05', '::1', 2, NULL, ''),
(14, 'staff', 'Jebastin', '2025-05-06', '2025-05-07', '2025-05-08', 'Full day', 'Sick Leave', 'kkk', '2025-05-06 09:27:52', '::1', 2, NULL, ''),
(15, 'jebas', 'jebastinraj', '2025-05-07', '2025-05-08', '2025-05-09', 'od', 'CL', 'fujfjugjfgj', '2025-05-07 06:43:24', '::1', 2, NULL, ''),
(16, 'admin', 'jebastinraj', '2025-05-07', '2025-05-08', '2025-05-15', 'od', 'Sick Leave', 'gkgk', '2025-05-07 06:44:45', '::1', 1, NULL, ''),
(17, 'gowtham', 'Gowtham', '2025-05-07', '2025-05-08', '2025-05-08', 'Full day', 'Personal Leave', 'joel mariage function', '2025-05-07 09:15:34', '::1', 1, NULL, ''),
(18, 'admin', 'Gowtham', '2025-05-07', '2025-05-08', '2025-05-09', 'Half day', 'Personal Leave', 'HJHJGHGHHGHG', '2025-05-07 09:38:03', '::1', 2, NULL, ''),
(19, 'staff', 'Jebastin', '2025-05-07', '2025-05-08', '2025-05-09', 'Full day', 'Vacation', 'tour', '2025-05-07 09:47:45', '::1', 1, NULL, 'no'),
(20, 'gowtham', 'Gowtham', '2025-05-07', '2025-05-08', '2025-05-09', 'Others', 'Vacation', 'tour', '2025-05-07 09:51:17', '::1', 2, NULL, 'no'),
(21, 'jebas', 'jebastinraj', '2025-05-07', '2025-05-08', '2025-05-09', 'Others', 'Vacation', 'muunar holiday', '2025-05-07 09:56:56', '::1', 1, NULL, 'ok'),
(22, 'jebas', 'jebastinraj', '2025-05-07', '2025-05-07', '2025-05-09', 'Full day', 'CL', 'ggg', '2025-05-07 10:12:21', '::1', 1, NULL, ''),
(23, 'admin', 'Gowtham', '2025-05-07', '2025-05-08', '2025-05-10', 'Full day', 'Personal Leave', 'jjj', '2025-05-07 10:14:46', '::1', 1, NULL, 'hhh'),
(24, 'admin', 'Jebastin', '2025-05-07', '2025-05-08', '2025-05-09', 'Others', 'Vacation', 'ffffff', '2025-05-07 10:22:39', '::1', 1, NULL, '123'),
(25, 'staff', 'Jebastin', '2025-05-07', '2025-05-08', '2025-05-09', 'Others', 'Emergency', 'aaa', '2025-05-07 10:28:59', '::1', 1, NULL, 'dddd'),
(26, 'staff', 'Jebastin', '2025-05-07', '2025-05-08', '2025-05-09', 'Half day', 'Emergency', 'jjjjj', '2025-05-07 10:31:47', '::1', 1, NULL, ''),
(27, 'staff', 'Jebastin', '2025-05-07', '2025-05-08', '2025-05-09', 'Full day', 'Emergency', 'jjjjj', '2025-05-07 11:30:46', '::1', 1, NULL, 'kkk'),
(28, 'staff', 'Jebastin', '2025-05-08', '2025-05-09', '2025-05-10', 'Full day', 'CL', 'hhhh', '2025-05-08 04:21:09', '::1', 1, NULL, 'sss'),
(29, 'staff', 'Jebastin', '2025-05-08', '2025-05-09', '2025-05-06', 'Half day', 'Personal Leave', 'hh', '2025-05-08 04:52:20', '::1', 1, NULL, ''),
(30, 'admin', 'Jebastin', '2025-05-08', '2025-05-09', '2025-05-09', 'Half day', 'Sick Leave', 'jjj', '2025-05-08 04:54:01', '::1', 2, NULL, ''),
(33, 'staff', 'Jebastin', '2025-05-08', '2025-05-09', '2025-05-10', 'Full day', 'Vacation', 'nnn', '2025-05-08 05:49:17', '::1', 2, NULL, ''),
(34, 'admin', 'Jebastin', '2025-05-08', '2025-05-09', '2025-05-10', 'Others', 'CL', 'nn', '2025-05-08 05:52:00', '::1', 2, NULL, ''),
(36, 'jebas', 'jebastinraj', '2025-05-08', '2025-05-09', '2025-05-09', 'Full day', 'Personal Leave', 'ppp', '2025-05-08 06:20:37', '::1', 1, NULL, ''),
(39, 'jebas', 'jebastinraj', '2025-05-08', '2025-05-09', '2025-05-10', 'od', 'Vacation', 'vvvv', '2025-05-08 06:30:54', '::1', 1, NULL, 'ok'),
(40, 'jebas', 'jebastinraj', '2025-05-08', '2025-05-10', '2025-05-10', 'od', 'Sick Leave', 'jjj', '2025-05-08 06:35:35', '::1', 1, NULL, 'ok'),
(41, 'staff', 'Jebastin', '2025-05-08', '2025-05-09', '2025-05-10', 'Full day', 'Vacation', 'tour\r\n', '2025-05-08 08:48:08', '::1', 1, NULL, ''),
(42, 'staff', 'Jebastin', '2025-05-08', '2025-05-10', '2025-05-13', 'Full day', 'Personal Leave', 'ppp', '2025-05-08 08:57:29', '::1', 1, NULL, 'ok'),
(43, 'staff', 'Jebastin', '2025-05-08', '2025-05-09', '2025-05-10', 'Full day', 'Personal Leave', 'aaaa', '2025-05-08 11:10:42', '::1', 1, NULL, ''),
(44, 'staff', 'Jebastin', '2025-05-09', '2025-05-13', '2025-05-14', 'od', 'Emergency', 'hhh', '2025-05-09 05:21:22', '::1', 1, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL CHECK (char_length(`username`) >= 5),
  `name` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL CHECK (char_length(`password`) >= 8),
  `role` enum('Admin','Staff') NOT NULL DEFAULT 'Staff',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `password`, `role`, `status`) VALUES
(1, 'admin', 'Admin', 'admin123', 'Admin', 'Active'),
(2, 'staff', 'Jebastin', 'staff123', 'Staff', 'Active'),
(4, 'joel1', 'joelraj', '12345678', 'Staff', 'Inactive'),
(5, 'jebas', 'jebastinraj', '12345678', 'Staff', 'Active'),
(6, 'gowtham', 'Gowtham', '12345678', 'Staff', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
