-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2024 at 07:34 PM
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

INSERT INTO `bhw` (`bhw_id`, `purok_name`, `fullname`, `contact_number`, `username`, `password`, `role`, `created_at`, `status`) VALUES
(1, 'Housing', 'Rema', 123245243, 'rema_bhw', '$2y$10$Ku4CvWK86xle1o5prHO04ehjiWhSF8z7yffBVTL8EZZonCjAvJ/hi', 'bhw', '2024-11-16 11:45:05', 'active'),
(2, 'Zone 1', 'Remar Reliquias', 2147483647, 'remar_bhw', '$2y$10$HdfVrNTF9lfOH5VrCXrel.h8X9F/bEFiDUFbi4n13MJu.D4pwJUTa', 'bhw', '2024-11-16 11:45:06', 'active'),
(3, 'Zone 4', 'Torcuato Reliquias', 2147483647, 'jun_bhw', '$2y$10$6/5ROF3xxsi8diAf8QjB9edK667HKaNQct5jrnBzyfesCE4Ok1a5K', 'bhw', '2024-11-15 00:07:53', 'active'),
(4, 'Spar 3', 'Torcuato Reliquias', 2147483647, 'tor_bhw', '$2y$10$FDpKCh1icPZ/i5Q5IWQe3uWzS6uGwXlWdneW62573zLYBkQFrZvNG', 'bhw', '2024-11-12 06:57:08', 'active'),
(5, 'Obong', 'Franz', 2147483647, 'franz_bhw', '$2y$10$fh2eZAVhUUVYfra4rLwcoOPH74dZg6FunepdIAkROOjX7PWg4LtAK', 'bhw', '2024-11-12 01:34:27', 'active');

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
(1, 1, 'Rema Gonzales', 'lyrremy@gmail.com', '2024-10-28', 56, 'female', 'Negros Occidental', 'Hinoba-an', 'Bacuyangan', 'Zone 4', '2024-11-03 13:38:07', '2024-11-03 13:38:07'),
(2, 2, 'Remar Reliquias', 'lyrremy@gmail.com', '2024-10-27', 75, 'male', 'Negros Occidental', 'Hinoba-an', 'Bacuyangan', 'Zone 10', '2024-11-03 14:04:06', '2024-11-03 14:04:06'),
(3, 4, 'Torcuato Reliquias', 'asddsaw@gmail.com', '2024-11-10', 75, 'male', 'Negros Occidental', 'Hinoba-an', 'Bacuyangan', 'Housing', '2024-11-06 00:43:21', '2024-11-06 00:43:21'),
(4, 5, 'Ram Franz Espino', 'asddsaw@gmail.com', '2000-07-14', 35, 'male', 'Negros Occidental', 'Hinoba-an', 'Bacuyangan', 'Zone 1', '2024-11-12 01:35:52', '2024-11-12 01:35:52');

-- --------------------------------------------------------

--
-- Table structure for table `economic_sec`
--

CREATE TABLE `economic_sec` (
  `eco_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `education_sec`
--

CREATE TABLE `education_sec` (
  `educ_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 1, 'Espino', 'Joialyn', 'Diagdal', '', 'Region IV', 'Negros Occidental', 'Hinoba-an', 'Bacuyangan', '07', 14, 2000, 'Las Pinas', 'Separated', 'Catholic', 'Hiligaynon', '');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
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
  `zone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profile_id`, `parent_id`, `firstname`, `middlename`, `lastname`, `extension`, `email`, `age`, `dob`, `gender`, `region`, `province`, `city`, `brgy`, `zone`) VALUES
(1, 1, 'Joialyn', 'Diagdal', 'Espino', '', 'joialyndiagdal@gmail.com', 56, '2024-10-07', 'Female', 'Region IV', 'Negros Occidental', 'Hinoba-an', 'Bacuyangan', 'Zone 1'),
(2, 2, 'Joialyn', 'Diagdal', 'Espino', '', 'joialyndiagdal@gmail.com', 56, '2024-10-08', 'Female', '', 'Negros Occidental', 'Hinoba-an', 'Bacuyangan', 'Zone 1'),
(3, 3, 'asd', 'asd', 'asd', '', 'asd@gmail.com', 65, '2024-10-28', 'female', '', 'Negros Occidental', 'Hinoba-an', 'Bacuyangan', 'Zone 2'),
(4, 4, 'Mark', 'Layda', 'Lapore', '', 'marklapore25@gmail.com', 75, '2023-10-29', 'male', '', 'Negros Occidental', 'Hinoba-an', 'Bacuyangan', 'Zone 4');

-- --------------------------------------------------------

--
-- Table structure for table `puroks`
--

CREATE TABLE `puroks` (
  `purok_id` int(11) NOT NULL,
  `purok_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `puroks`
--

INSERT INTO `puroks` (`purok_id`, `purok_name`, `contact_person`, `contact_number`, `email_address`) VALUES
(1, 'Zone 1', 'Remar Reliquias', '09959802187', 'lyrremy@gmail.com'),
(2, 'Zone 2', 'Rema Gonzales', '09123456789', 'asdw@gmail.com'),
(3, 'Zone 3', 'Michael Reliquias', '09123456789', 'asdwad@gmail.com'),
(4, 'Zone 4', 'as', '75764563', 'ftyghdf@gmail.com'),
(5, 'Sangke', 'asdawdsa', '23452345234', 'asdws@gmail.com'),
(6, 'Obong', 'asdjwhu', '0871236879', 'asdkbw@gmail.com'),
(7, 'Housing', 'Marlyn Linaja', '091234awds', 'asdwsca@gmail.com'),
(8, 'Spar 3', 'wasdw', '12312323432', 'asfrjgncd@gmail.com'),
(9, 'Vasquez', 'Joelyn', '235234523', 'asdasg@gmail.com');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `phone_no`, `password`, `confirm_password`, `created_at`) VALUES
(1, 'joialyn123', '09560032013', '$2y$10$E7f1pgSaagxejbCbfvr0kOyIy1M1BduUi.GIUCeynHw.E/Cv/c/rC', '$2y$10$E7f1pgSaagxejbCbfvr0kOyIy1M1BduUi.GIUCeynHw.E/Cv/c/rC', '2024-10-10 03:31:33'),
(2, 'rema123', '09560032013', '$2y$10$GROecPso7JXjeqDu5.ggs.SHLHFpz9w/1DX0dBGAeXMQ3RxHEN5mq', '$2y$10$GROecPso7JXjeqDu5.ggs.SHLHFpz9w/1DX0dBGAeXMQ3RxHEN5mq', '2024-10-24 11:43:33'),
(3, 'marlyn225', '09959802187', '$2y$10$937btnO7TwXvN5ISqHLXXOf2ZjnWAsnlPVJl.4yXtbFVUctyUyjjm', '$2y$10$937btnO7TwXvN5ISqHLXXOf2ZjnWAsnlPVJl.4yXtbFVUctyUyjjm', '2024-11-03 04:40:49'),
(4, 'mark123', '09959802187', '$2y$10$KWzm1yB6pkIve4NAQRhV4uT3riDk02NXjuNnqlC4aeVZbX8xWUovG', '$2y$10$KWzm1yB6pkIve4NAQRhV4uT3riDk02NXjuNnqlC4aeVZbX8xWUovG', '2024-11-03 04:57:37');

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
  ADD PRIMARY KEY (`bhw_id`);

--
-- Indexes for table `bhw_profile`
--
ALTER TABLE `bhw_profile`
  ADD PRIMARY KEY (`bhw_ID`),
  ADD UNIQUE KEY `parent_id` (`parent_id`);

--
-- Indexes for table `economic_sec`
--
ALTER TABLE `economic_sec`
  ADD PRIMARY KEY (`eco_id`);

--
-- Indexes for table `education_sec`
--
ALTER TABLE `education_sec`
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
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `puroks`
--
ALTER TABLE `puroks`
  ADD PRIMARY KEY (`purok_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `username` (`username`);

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
  MODIFY `bhw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bhw_profile`
--
ALTER TABLE `bhw_profile`
  MODIFY `bhw_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `economic_sec`
--
ALTER TABLE `economic_sec`
  MODIFY `eco_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `education_sec`
--
ALTER TABLE `education_sec`
  MODIFY `educ_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `family_sec`
--
ALTER TABLE `family_sec`
  MODIFY `family_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `info_sec`
--
ALTER TABLE `info_sec`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `puroks`
--
ALTER TABLE `puroks`
  MODIFY `purok_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
