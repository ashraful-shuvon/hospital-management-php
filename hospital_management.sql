-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 25, 2024 at 09:57 PM
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
-- Database: `hospital_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(2, 'jannat', '$2y$10$fVGiYbciibBF9QiHE7MWmu6ANPFSLRndiH7vKgmKvQu8u4oy0WJGW'),
(3, 'ashraful', '$2y$10$G7WPDS8WTtpi06TGZaJ65u/zP8sgmzNjq5QvAdRz.Nscro/RoGQKW'),
(4, 'arbi', '$2y$10$.TBCPp1njaIXqsNKOPJFCu6L.khakCRBYeCQl3SSNHR6z0amwS.T.'),
(5, 'hababuba', '$2y$10$dQiDBEzdFoiNTqrUAwmVuurTur02r0Bmy.zBTn.tKy4KbMhA1ArFS'),
(6, 'shuvooo', '$2y$10$4EfolNTLeFNO8PXOhrL6P.gIyM4mjtSMcPVh/8sOKFzh25s/TGeey'),
(7, 'ovi', '$2y$10$q1WcLjq4aNF7MGKBsUur9.xIvpv7EAXnkh8p25BZPyP5tdtxRhWo6'),
(8, 'jannaatt', '$2y$10$7jBEP.45gtuFJ2cG7jalSulAXf2.RtUjkIKUD5.Jk8qtH38XoJ0SW'),
(9, 'miraj', '$2y$10$VpaPjVYNvreBrEslmdV8seilbz8Cn5dheK257MJME1cwSc20GEi4e');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` datetime NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `doctor_id`, `appointment_date`, `status`) VALUES
(3, 5, 3, '2024-11-16 19:22:00', 'Scheduled'),
(5, 8, 3, '2024-11-17 15:51:00', 'Scheduled'),
(6, 1, 3, '2024-11-17 22:31:00', 'Scheduled'),
(8, 5, 3, '2024-11-17 21:00:00', 'Scheduled'),
(9, 2, 3, '2024-11-17 21:07:00', 'Scheduled'),
(10, 1, 3, '2024-11-17 00:00:00', 'Completed'),
(11, 2, 3, '2024-11-17 23:55:00', 'Scheduled'),
(12, 10, 5, '2024-11-18 22:17:00', 'Scheduled'),
(13, 13, 9, '2024-11-26 20:15:00', 'Scheduled');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `bill_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `treatment_fee` decimal(10,2) NOT NULL,
  `service_charge` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`bill_id`, `patient_id`, `treatment_fee`, `service_charge`, `total_amount`, `created_at`) VALUES
(1, 5, 500.00, 150.00, 1300.00, '2024-11-25 19:50:31'),
(2, 10, 2000.00, 1211.00, 3911.00, '2024-11-25 19:57:02'),
(4, 2, 1200.00, 100.00, 1350.00, '2024-11-25 20:09:00'),
(5, 13, 1233.00, 123.00, 1456.00, '2024-11-25 20:41:56');

-- --------------------------------------------------------

--
-- Table structure for table `bill_tests`
--

CREATE TABLE `bill_tests` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_tests`
--

INSERT INTO `bill_tests` (`id`, `bill_id`, `test_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 3),
(5, 2, 4),
(6, 4, 1),
(7, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `first_name`, `last_name`, `specialization`, `contact_number`, `email`, `username`, `password`, `created_at`) VALUES
(3, 'dr r', 'pori', 'breaking hearts', '2233445566', 'pori@gmail.com', 'pori', '$2y$10$QzrLCZxTuou5OvNlfeMCM.goITA2AEKa8TJMAfloUf9B2VqLDeKuC', '2024-11-16 00:11:33'),
(5, 'Jannat', 'Ashraful', 'Heart', '1234567899', 'jaan@gmail.com', 'ash', '$2y$10$RLADRWIOkbwfvZS229ws4.7UrjjJ5aXdGRR5xLXALLRBFluzY1uOe', '2024-11-18 00:17:19'),
(8, 'Ashraful', 'nnnn', 'Heart', '1234567899', 'mily.jnu4024@gmail.com', 'nnnn', '$2y$10$zngAI8DsM.qLrvMhZjRNfOjhB0CtMl1FkGB4q9zNhYAXHQBEELiSW', '2024-11-25 19:37:06'),
(9, 'dr', 'arbi', 'gynecologist', '01950505050', 'arbi@apple.com', 'arbii', '$2y$10$hrV14WDZtvtkKQ3WsbCA6.ZT.U72ocFEO25oiKiGOVFvSpmNaBJce', '2024-11-25 20:31:54');

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `diagnosis` text NOT NULL,
  `prescription` text NOT NULL,
  `test_results` text DEFAULT NULL,
  `date_recorded` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`record_id`, `patient_id`, `doctor_id`, `diagnosis`, `prescription`, `test_results`, `date_recorded`) VALUES
(11, 10, 5, 'Heart', 'Coffeew', 'Positive', '2024-11-18 06:18:57'),
(13, 5, 3, 'heart', 'asadasdad', 'asdasdasda', '2024-11-26 02:17:16'),
(14, 13, 9, 'Betha ', 'Medicine ', 'positive', '2024-11-26 02:33:46');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `contact_number`, `email`, `address`, `username`, `password`, `created_at`) VALUES
(2, 'ovi', 'mawwwww', '1999-12-12', 'Male', '1234567899', 'ovi@gmail.com', 'motijheel', 'ovi', '$2y$10$TYd8OTN.IB0pelDtbm7TSuUl9vw4nrvK8JE2hwlC6Qflcvp9/NYaK', '2024-11-17 13:55:13'),
(5, 'Ashraful', 'Shuvon', '1998-11-17', 'Male', '0195050505', 'shuvin@gmail.com', 'asdasd', 'Shu', '$2y$10$kalfjKza5Zluqtegt0xksOGI.4k60.tpSy2cPm00e7stsAC38s6sC', '2024-11-17 14:59:22'),
(10, 'Jannat', 'Shuvon', '2000-11-18', 'Female', '0195050505', 'ashraful.shuvon@gmail.com', 'Mirpur, Dhaka', 'jannat', '$2y$10$8T8qKMBQ.kr51wv8V.0qLeUMAbc5euBa4MdWDd.X1t1zdlOfSB9VS', '2024-11-18 00:14:51'),
(13, 'ovi', 'bhai', '2000-10-10', 'Male', '01950505050', 'ovii@gmail.com', 'Motijheel', 'oviii', '$2y$10$WedoPhgkfKq0Be1NglX/vOEpmKE3dZ2k3s.BRpiTM/kcXUIjBKZXu', '2024-11-25 20:28:55');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `test_id` int(11) NOT NULL,
  `test_name` varchar(255) NOT NULL,
  `test_fee` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`test_id`, `test_name`, `test_fee`) VALUES
(1, 'Blood Test', 50.00),
(2, 'X-Ray', 100.00),
(3, 'MRI', 500.00),
(4, 'Ultrasound', 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `treatment_plans`
--

CREATE TABLE `treatment_plans` (
  `treatment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `diagnosis` text NOT NULL,
  `prescribed_date` date NOT NULL,
  `medicine_name` text NOT NULL,
  `dosage` text NOT NULL,
  `duration` text NOT NULL,
  `tests` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment_plans`
--

INSERT INTO `treatment_plans` (`treatment_id`, `patient_id`, `doctor_id`, `diagnosis`, `prescribed_date`, `medicine_name`, `dosage`, `duration`, `tests`) VALUES
(8, 5, 3, 'asdasdas', '2024-11-25', 'asdasda', 'asdaasd', 'asdaasd', 'asdada'),
(9, 13, 9, 'betha kome na ', '2024-11-25', 'Medicine ', '3 bela ', '1 month ', 'buker X-ray');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `bill_tests`
--
ALTER TABLE `bill_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `test_id` (`test_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `treatment_plans`
--
ALTER TABLE `treatment_plans`
  ADD PRIMARY KEY (`treatment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bill_tests`
--
ALTER TABLE `bill_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `treatment_plans`
--
ALTER TABLE `treatment_plans`
  MODIFY `treatment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`);

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `bill_tests`
--
ALTER TABLE `bill_tests`
  ADD CONSTRAINT `bill_tests_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bill_tests_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `tests` (`test_id`);

--
-- Constraints for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medical_records_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE;

--
-- Constraints for table `treatment_plans`
--
ALTER TABLE `treatment_plans`
  ADD CONSTRAINT `treatment_plans_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treatment_plans_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
