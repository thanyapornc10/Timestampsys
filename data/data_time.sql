-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2023 at 06:42 PM
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
-- Database: `data_time`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminuser`
--

CREATE TABLE `adminuser` (
  `ad_id` int(11) NOT NULL,
  `useradmin` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminuser`
--

INSERT INTO `adminuser` (`ad_id`, `useradmin`, `password`) VALUES
(1, 'admin', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dep_id` int(11) NOT NULL,
  `dname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dep_id`, `dname`) VALUES
(1, 'QA'),
(2, 'HR'),
(3, 'CEO'),
(4, 'SA'),
(5, ' Sup');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `dep` int(11) DEFAULT NULL,
  `sex` varchar(20) NOT NULL,
  `birth` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `address` varchar(300) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `fname`, `lname`, `dep`, `sex`, `birth`, `email`, `phone`, `address`, `image_path`) VALUES
(1001, 'Darin', 'Pibun', 2, 'male', '2000-02-01', 'darin@gmail.com', '0801021996', '26/07 Chiangmai Thailand', ''),
(1002, 'Jukkarin', 'Ruttanapibun', 3, 'male', '1997-02-14', 'jukkarin@gmail.com', '0814021997', '09/127 Bangkok Thailand', 'uploads/653787357a671.jpg'),
(1003, 'Jasmin', 'Lee', 5, 'female', '2000-08-13', 'jase@gmail.com', '0908132000', '19/77 Chaingmai Thailand', ''),
(1004, 'Heman', 'Boribun', 1, 'male', '2000-08-02', 'heman@gmail.com', '0602081999', '07/399 Khonkaen Thailand', ''),
(1005, 'Sirintorn', 'Pachock', 4, 'female', '2000-01-01', 'sirintorn@gmail.com', '0963241963', '241/14 Phitsanulok Thailand', ''),
(1006, 'Maprod', 'Sanlho', 1, 'male', '2000-06-06', 'maprod@gmail.com', '0806062000', '09/127 Phuket Thailand', 'uploads/chin.jpg'),
(1007, 'Nareetip', 'Pongsawad', 5, 'female', '2001-11-03', 'naree@gmail.com', '0900103201', '301/20 Pitsanulok Thailand', 'uploads/chin.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reason`
--

CREATE TABLE `reason` (
  `r_id` int(11) NOT NULL,
  `rname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reason`
--

INSERT INTO `reason` (`r_id`, `rname`) VALUES
(1, '-'),
(2, 'leave'),
(3, 'sick'),
(4, 'other');

-- --------------------------------------------------------

--
-- Table structure for table `time_stamp`
--

CREATE TABLE `time_stamp` (
  `time_num` int(11) NOT NULL,
  `id_time` int(11) NOT NULL,
  `timedate` varchar(50) NOT NULL,
  `time_in` varchar(50) DEFAULT NULL,
  `time_out` varchar(50) DEFAULT NULL,
  `reason` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_stamp`
--

INSERT INTO `time_stamp` (`time_num`, `id_time`, `timedate`, `time_in`, `time_out`, `reason`) VALUES
(12, 1002, '2023-10-24', '09:24', '17:00', 1),
(23, 1001, '2023-10-16', '08:30', '16:00', 1),
(24, 1001, '2023-10-18', '08:05', '16:00', 1),
(25, 1001, '2023-10-18', NULL, NULL, 3),
(27, 1006, '2023-10-23', '08:24', '16:05', 1),
(28, 1006, '2023-10-22', '08:03', '16:00', 1),
(29, 1004, '2023-10-23', '08:25', '16:00', 1),
(30, 1004, '2023-10-23', '08:00', '16:00', 1),
(31, 1004, '2023-10-18', NULL, NULL, 2),
(32, 1006, '2023-10-20', NULL, NULL, 2),
(33, 1002, '2023-10-23', '08:00', '17:30', 1),
(34, 1003, '2023-10-23', '08:05', '16:00', 1),
(35, 1005, '2023-10-23', NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_usenum` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_usenum`, `users_id`, `username`, `password`) VALUES
(1, 1001, 'darin', '0201'),
(2, 1002, 'juk', '0214'),
(3, 1003, 'jasmin', '0813'),
(4, 1004, 'heman', '0802'),
(5, 1005, 'sirin', '0101'),
(6, 1006, 'prod', '0606'),
(7, 1007, 'root', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminuser`
--
ALTER TABLE `adminuser`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dep_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `dep` (`dep`);

--
-- Indexes for table `reason`
--
ALTER TABLE `reason`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `time_stamp`
--
ALTER TABLE `time_stamp`
  ADD PRIMARY KEY (`time_num`),
  ADD KEY `emp` (`id_time`),
  ADD KEY `have` (`reason`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_usenum`),
  ADD KEY `owner` (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminuser`
--
ALTER TABLE `adminuser`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1012;

--
-- AUTO_INCREMENT for table `reason`
--
ALTER TABLE `reason`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `time_stamp`
--
ALTER TABLE `time_stamp`
  MODIFY `time_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_usenum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `dep` FOREIGN KEY (`dep`) REFERENCES `department` (`dep_id`);

--
-- Constraints for table `time_stamp`
--
ALTER TABLE `time_stamp`
  ADD CONSTRAINT `emp` FOREIGN KEY (`id_time`) REFERENCES `employee` (`Emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `have` FOREIGN KEY (`reason`) REFERENCES `reason` (`R_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `owner` FOREIGN KEY (`users_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
