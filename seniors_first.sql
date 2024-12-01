-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 03:04 PM
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
-- Database: `seniors_first`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `role`) VALUES
(1, 'Bacuyangan', '$2y$10$E5s72sjLfoFZK2tfxs0KDOKrUY3ub7FW1EK9v/eydsVo6MrAf4Rkm', 'brgy');

-- --------------------------------------------------------

--
-- Table structure for table `bhw`
--

CREATE TABLE `bhw` (
  `bhw_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `purok_name` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `contact_number` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bhw`
--

INSERT INTO `bhw` (`bhw_id`, `parent_id`, `purok_name`, `fullname`, `contact_number`, `username`, `password`, `role`, `created_at`, `status`) VALUES
(1, 1, 'Zone 1', 'Rema', 2147483647, 'RemaBHW', '$2y$10$XxXL37f9rZ0/INkOS2UBDOVnF80dg9w7CV5QMBnlIPj80/i2EjF3m', 'bhw', '2024-11-30 16:52:07', 'active'),
(2, 2, 'Spar 3', 'Remar', 2147483647, 'RemarBHW', '$2y$10$jQzbLgJanUgLgGLeoQtsMOgeiTghhIWIfyiXkwYzSsnjE6dfrcnZ.', 'bhw', '2024-11-30 16:52:06', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `bhw_profile`
--

CREATE TABLE `bhw_profile` (
  `bhw_ID` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `brgy` varchar(100) NOT NULL,
  `zone` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bhw_profile`
--

INSERT INTO `bhw_profile` (`bhw_ID`, `parent_id`, `name`, `email`, `dob`, `age`, `gender`, `province`, `city`, `brgy`, `zone`, `created_at`, `updated_at`) VALUES
(1, 1, 'Rema Gonzales', 'lyrremy@gmail.com', '2024-11-11', 65, 'female', 'Negros Occidental', 'Hinobaan', 'Bacuyangan', 'Zone 1', '2024-11-29 00:27:42', '2024-11-29 00:27:42'),
(2, 2, 'Remar Reliquias', 'lyrremy@gmail.com', '2024-11-06', 65, 'male', 'Negros Occidental', 'Hinobaan', 'Bacuyangan', 'Zone 1', '2024-11-29 00:28:16', '2024-11-29 00:28:16');

-- --------------------------------------------------------

--
-- Table structure for table `eco_sec`
--

CREATE TABLE `eco_sec` (
  `eco_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `income_sources` text DEFAULT NULL,
  `income_range` text DEFAULT NULL,
  `other_income` varchar(255) DEFAULT NULL,
  `sss_type` varchar(50) DEFAULT NULL,
  `own_pension_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eco_sec`
--

INSERT INTO `eco_sec` (`eco_id`, `parent_id`, `income_sources`, `income_range`, `other_income`, `sss_type`, `own_pension_type`) VALUES
(1, 1, 'pension', '20000_30000', '', '', 'national'),
(2, 2, 'pension', 'below_5000', '', '', 'national');

-- --------------------------------------------------------

--
-- Table structure for table `edu_sec`
--

CREATE TABLE `edu_sec` (
  `educ_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `education` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `edu_sec`
--

INSERT INTO `edu_sec` (`educ_id`, `parent_id`, `education`) VALUES
(1, 1, 'not_attended'),
(2, 2, 'elementary_grad');

-- --------------------------------------------------------

--
-- Table structure for table `family_sec`
--

CREATE TABLE `family_sec` (
  `family_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `spouse_lastname` varchar(255) DEFAULT NULL,
  `spouse_firstname` varchar(255) DEFAULT NULL,
  `spouse_middlename` varchar(255) DEFAULT NULL,
  `spouse_extension` varchar(50) DEFAULT NULL,
  `father_lastname` varchar(255) DEFAULT NULL,
  `father_firstname` varchar(255) DEFAULT NULL,
  `father_middlename` varchar(255) DEFAULT NULL,
  `father_extension` varchar(50) DEFAULT NULL,
  `mother_lastname` varchar(255) DEFAULT NULL,
  `mother_firstname` varchar(255) DEFAULT NULL,
  `mother_middlename` varchar(255) DEFAULT NULL,
  `mother_extension` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `family_sec`
--

INSERT INTO `family_sec` (`family_id`, `parent_id`, `spouse_lastname`, `spouse_firstname`, `spouse_middlename`, `spouse_extension`, `father_lastname`, `father_firstname`, `father_middlename`, `father_extension`, `mother_lastname`, `mother_firstname`, `mother_middlename`, `mother_extension`) VALUES
(1, 1, 'Espino', 'Ram Franz', 'Reliquias', '', 'Diagdal', 'Julito', 'Desoyo', 'Jr', 'Diagdal', 'Jelly Mae', 'Desoyo', ''),
(2, 2, 'Espino', 'Ram Franz', 'Reliquias', '', 'Diagdal', 'Julito', 'Desoyo', 'Jr', 'Diagdal', 'Jelly Mae', 'Desoyo', '');

-- --------------------------------------------------------

--
-- Table structure for table `info_sec`
--

CREATE TABLE `info_sec` (
  `info_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `extension` varchar(11) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `brgy` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `day` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `birthPlace` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `ethnicOrigin` varchar(255) DEFAULT NULL,
  `oscaID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `info_sec`
--

INSERT INTO `info_sec` (`info_id`, `parent_id`, `lastname`, `firstname`, `middlename`, `extension`, `region`, `province`, `city`, `brgy`, `month`, `day`, `year`, `birthPlace`, `status`, `religion`, `ethnicOrigin`, `oscaID`) VALUES
(1, 1, 'Diagdal', 'RAM FRANZ', 'Desoyo', '', 'Region VI', 'Negros Occidental', 'Hinobaan', 'Bacuyangan', '07', 14, 2000, 'Las Pinas', 'Single', 'Catholic', 'Ilonggo', '1eqweasd2132'),
(2, 2, 'ESPINO', 'RAM FRANZ', 'RELIQUIAS', '', 'VI', 'Negros Occidental', 'Hinobaan', 'Bacuyangan', '07', 14, 2000, 'Las Pinas', 'Single', 'Catholic', 'Ilonggo', '1eqweasd2132');

-- --------------------------------------------------------

--
-- Table structure for table `puroks`
--

CREATE TABLE `puroks` (
  `purok_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `purok_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `puroks`
--

INSERT INTO `puroks` (`purok_id`, `parent_id`, `purok_name`, `contact_person`, `contact_number`, `email_address`) VALUES
(1, 1, 'Zone 1', 'Rema Reliquias', '09123456789', 'asdwad@gmail.com'),
(2, 2, 'Zone 2', 'Rema', '09123456789', 'asdwad@gmail.com'),
(3, 3, 'Spar 3', 'Remar Reliquias', '09123456789', 'asdwad@gmail.com'),
(4, 4, 'Housing', 'Remar Reliquias', '09123456789', 'asdwad@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `phone_no`, `password`, `confirm_password`, `created_at`, `status`) VALUES
(1, 'joialyn123', '09959802187', '$2y$10$dKMgZBM/6Vqqy7r/tlctJO.PkDA41sQZuJI1S9uYyXN0dZHJM3Yeu', '$2y$10$dKMgZBM/6Vqqy7r/tlctJO.PkDA41sQZuJI1S9uYyXN0dZHJM3Yeu', '2024-11-25 11:06:31', 'active'),
(2, 'mark123', '09959802187', '$2y$10$qUsgwc06SYe1JsvVFORczOQ.tHQ7oV4RWfgNYQ0QbGn3qE5j4GJGm', '$2y$10$qUsgwc06SYe1JsvVFORczOQ.tHQ7oV4RWfgNYQ0QbGn3qE5j4GJGm', '2024-11-26 03:39:01', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `profile_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `extension` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `region` varchar(255) NOT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `brgy` varchar(255) DEFAULT NULL,
  `purok_name` varchar(255) DEFAULT NULL,
  `approval_status` enum('Pending','Approved','Denied') DEFAULT 'Pending',
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`profile_id`, `parent_id`, `firstname`, `middlename`, `lastname`, `extension`, `email`, `age`, `dob`, `gender`, `region`, `province`, `city`, `brgy`, `purok_name`, `approval_status`, `status`) VALUES
(1, 1, 'Joialyn', 'Diagdal', 'Espino', 'Jr', 'lyrremy@gmail.com', 30, '1994-10-13', 'Female', 'Region VI', 'Negros Occidental', 'Hinobaan', 'Bacuyangan', 'Zone 1', 'Approved', 'Inactive'),
(2, 2, 'RAM FRANZ', 'RELIQUIAS', 'ESPINO', '', 'lyrremy@gmail.com', 65, '2024-10-31', 'Male', 'VI', 'Negros Occidental', 'Hinobaan', 'Bacuyangan', 'Spar 3', 'Approved', 'Inactive');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bhw`
--
ALTER TABLE `bhw`
  ADD PRIMARY KEY (`bhw_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `bhw_profile`
--
ALTER TABLE `bhw_profile`
  ADD PRIMARY KEY (`bhw_ID`),
  ADD UNIQUE KEY `parent_id` (`parent_id`);

--
-- Indexes for table `eco_sec`
--
ALTER TABLE `eco_sec`
  ADD PRIMARY KEY (`eco_id`);

--
-- Indexes for table `edu_sec`
--
ALTER TABLE `edu_sec`
  ADD PRIMARY KEY (`educ_id`);

--
-- Indexes for table `family_sec`
--
ALTER TABLE `family_sec`
  ADD PRIMARY KEY (`family_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `info_sec`
--
ALTER TABLE `info_sec`
  ADD PRIMARY KEY (`info_id`),
  ADD KEY `family_id` (`parent_id`);

--
-- Indexes for table `puroks`
--
ALTER TABLE `puroks`
  ADD PRIMARY KEY (`purok_id`),
  ADD KEY `purok_id` (`parent_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bhw`
--
ALTER TABLE `bhw`
  MODIFY `bhw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bhw_profile`
--
ALTER TABLE `bhw_profile`
  MODIFY `bhw_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `eco_sec`
--
ALTER TABLE `eco_sec`
  MODIFY `eco_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `edu_sec`
--
ALTER TABLE `edu_sec`
  MODIFY `educ_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `family_sec`
--
ALTER TABLE `family_sec`
  MODIFY `family_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `info_sec`
--
ALTER TABLE `info_sec`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `puroks`
--
ALTER TABLE `puroks`
  MODIFY `purok_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
