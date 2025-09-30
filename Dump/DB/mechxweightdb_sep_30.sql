-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2025 at 07:19 PM
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
-- Database: `mechxweightdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_addr` varchar(500) NOT NULL,
  `company_phone` int(11) NOT NULL,
  `company_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `label_mapping`
--

CREATE TABLE `label_mapping` (
  `label_id` int(11) NOT NULL,
  `conpany_id` int(11) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `column_name` varchar(50) NOT NULL,
  `label_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `material_id` int(11) NOT NULL,
  `material_name` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`material_id`, `material_name`, `is_active`) VALUES
(0, 'Empty', 1),
(2, 'Copper', 1),
(3, 'Steel', 1),
(5, 'Iron', 1),
(7, 'Concrete', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE `parties` (
  `party_id` int(11) NOT NULL,
  `party_name` varchar(100) NOT NULL,
  `party_email` varchar(50) NOT NULL,
  `party_phone` varchar(15) NOT NULL,
  `party_status` tinyint(4) NOT NULL,
  `party_created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`party_id`, `party_name`, `party_email`, `party_phone`, `party_status`, `party_created_at`) VALUES
(7, 'Crazy', 'crazy@mail.com', '1231231231', 1, '2025-09-25'),
(8, 'Maveriks', 'maveriks@mail.com', '2342342342', 1, '2025-09-25'),
(9, 'Mecha', 'mecha@mail.com', '1232342342', 1, '2025-09-25'),
(10, 'Troniks', 'troniks@mail.com', '1233245342', 1, '2025-09-25'),
(11, 'Thonks2', 'thonksss@mail.com', '2343451231', 1, '2025-09-29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_username` varchar(50) DEFAULT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_is_admin` tinyint(1) DEFAULT 0,
  `user_is_active` tinyint(1) DEFAULT 1,
  `user_created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_username`, `user_email`, `user_password`, `user_is_admin`, `user_is_active`, `user_created_at`) VALUES
(3, 'KNPL Jainpur', 'knplvariance', 'knplvariance@nerolac.com', '$2y$10$1w8HtPWVNeXHwid6rQIybuhlIhZbTuKmjUsXYkk5.dLkPGl0moiJ6', 1, 1, '2025-06-28 17:19:40'),
(6, 'Ashwini Shankar', 'ashwini', 'it@digi-int.com', '$2y$10$XRGheoOk4DGW7LJaDlj4wOobAO.hE/3Ze3CE/mESFXKJJivLZphNS', 1, 1, '2025-06-29 04:20:12'),
(7, 'Variance User', 'varianceuser', 'varianceuser@nerolac.com', '$2y$10$7zZj0uaeWfdIM.NTJk1WwOO0JAVy76LgAVWjMpvlGix3Ecf/UnLga', 0, 1, '2025-06-29 08:08:26'),
(0, 'Abhishek Mishra', 'abhishekmishra', 'abhishekmishra@nerolac.com', '$2y$10$V.gYPTBlEfnyKbg5HqdvbOGfNz8l2C5ge/apeUgijnm4WyIk.7Qee', 1, 1, '2025-07-21 10:54:25'),
(0, 'KNPL Operator', 'operator', 'operator@nerolac.com', '$2y$10$K3HcoBMWMWb0McIZswJCcuq2LtQAuUNskQj3s7mZG/jJGxgj2O.H2', 0, 1, '2025-07-21 15:59:39'),
(4, 'Akhilesh', 'akhil', 'akhil@mail.com', '$2y$10$/MkqRAc.qPOgNsqm/Y3WO.YTt3uI8cRawsCSyqum5RNXyaF6jY3AW', 1, 1, '2025-09-15 16:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL,
  `user_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `user_type`) VALUES
(1, 'super_admin'),
(2, 'admin'),
(3, 'supervisor'),
(4, 'operator');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `vehicle_owner` varchar(100) NOT NULL,
  `vehicle_number` varchar(10) NOT NULL,
  `vehicle_created_at` date NOT NULL,
  `vehicle_status` tinyint(4) NOT NULL,
  `vehicle_weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `vehicle_owner`, `vehicle_number`, `vehicle_created_at`, `vehicle_status`, `vehicle_weight`) VALUES
(19, 'Maveriksw', 'KA02MA0245', '2025-09-29', 1, 2000),
(20, 'Crazy', 'KA02MA3422', '2025-09-29', 1, 1230),
(21, 'Mecha', 'KA04NA3443', '2025-09-29', 1, 1326);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_type`
--

CREATE TABLE `vehicle_type` (
  `vehicle_type_id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_type`
--

INSERT INTO `vehicle_type` (`vehicle_type_id`, `type_name`) VALUES
(1, 'lorry'),
(2, 'mini goods');

-- --------------------------------------------------------

--
-- Table structure for table `weighing_record`
--

CREATE TABLE `weighing_record` (
  `weighingrecord_id` int(11) NOT NULL,
  `weighment_type` int(11) NOT NULL,
  `ticket_no` int(11) NOT NULL,
  `vehicle_number` varchar(11) NOT NULL,
  `party_name` varchar(255) NOT NULL,
  `charges` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_pending` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weighing_record`
--

INSERT INTO `weighing_record` (`weighingrecord_id`, `weighment_type`, `ticket_no`, `vehicle_number`, `party_name`, `charges`, `created_at`, `is_pending`) VALUES
(17, 1, 123123, '123123', 'Crazy', 1, '2025-09-30 12:38:11', 1),
(21, 1, 213123, 'KA02MA3422', 'Mecha', 1, '2025-09-30 17:10:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `weightment_type`
--

CREATE TABLE `weightment_type` (
  `weightment_type_id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weightment_type`
--

INSERT INTO `weightment_type` (`weightment_type_id`, `type_name`) VALUES
(1, 'first'),
(4, 'multipart'),
(5, 'preloaded'),
(2, 'second'),
(3, 'single');

-- --------------------------------------------------------

--
-- Table structure for table `weights`
--

CREATE TABLE `weights` (
  `weights_id` int(11) NOT NULL,
  `weighingrecord_id` int(11) NOT NULL,
  `weightment_type` int(11) NOT NULL,
  `material` varchar(50) NOT NULL,
  `charges` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `weight_count` int(11) NOT NULL,
  `weighed_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weights`
--

INSERT INTO `weights` (`weights_id`, `weighingrecord_id`, `weightment_type`, `material`, `charges`, `weight`, `weight_count`, `weighed_on`) VALUES
(12, 17, 1, 'Steel', 12312, 23, 2, '2025-09-30'),
(13, 17, 1, 'Concrete', 123, 12312, 3, '2025-09-30'),
(14, 17, 1, 'Copper', 123123, 123123, 4, '2025-09-30'),
(15, 17, 1, 'Thungstan', 232, 12312, 5, '2025-09-30'),
(16, 21, 1, 'Concrete', 23, 123, 2, '2025-09-30'),
(17, 21, 1, 'Steel', 343, 123, 3, '2025-09-30'),
(18, 21, 1, 'gold', 323, 1123, 4, '2025-09-30'),
(19, 21, 1, 'asdasd', 232, 2323, 5, '2025-09-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `label_mapping`
--
ALTER TABLE `label_mapping`
  ADD PRIMARY KEY (`label_id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`party_id`),
  ADD UNIQUE KEY `party_email` (`party_email`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD UNIQUE KEY `vehicle_number` (`vehicle_number`);

--
-- Indexes for table `vehicle_type`
--
ALTER TABLE `vehicle_type`
  ADD PRIMARY KEY (`vehicle_type_id`),
  ADD UNIQUE KEY `type_name` (`type_name`);

--
-- Indexes for table `weighing_record`
--
ALTER TABLE `weighing_record`
  ADD PRIMARY KEY (`weighingrecord_id`),
  ADD UNIQUE KEY `ticket_no` (`ticket_no`);

--
-- Indexes for table `weightment_type`
--
ALTER TABLE `weightment_type`
  ADD PRIMARY KEY (`weightment_type_id`),
  ADD UNIQUE KEY `type_name` (`type_name`);

--
-- Indexes for table `weights`
--
ALTER TABLE `weights`
  ADD PRIMARY KEY (`weights_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `label_mapping`
--
ALTER TABLE `label_mapping`
  MODIFY `label_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `party_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `vehicle_type`
--
ALTER TABLE `vehicle_type`
  MODIFY `vehicle_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `weighing_record`
--
ALTER TABLE `weighing_record`
  MODIFY `weighingrecord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `weightment_type`
--
ALTER TABLE `weightment_type`
  MODIFY `weightment_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `weights`
--
ALTER TABLE `weights`
  MODIFY `weights_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
