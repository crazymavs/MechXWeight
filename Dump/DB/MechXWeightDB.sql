-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 12, 2025 at 10:20 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MechXWeightDB`
--

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
(0, 'KNPL Operator', 'operator', 'operator@nerolac.com', '$2y$10$K3HcoBMWMWb0McIZswJCcuq2LtQAuUNskQj3s7mZG/jJGxgj2O.H2', 0, 1, '2025-07-21 15:59:39');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
