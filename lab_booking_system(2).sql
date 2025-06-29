-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2025 at 08:51 AM
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
-- Database: `lab_booking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `Instructor_ID` int(11) NOT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`Instructor_ID`, `user_id`, `Name`) VALUES
(1, 'IT1', 'Dr. Bob Smith'),
(2, 'IT2', 'madushanka'),
(3, 'IT3', 'Dr. Nuwan Jayasinghe'),
(4, 'IT4', 'Dr. Shalini Perera'),
(5, 'IT3', 'Dr. Nuwan Jayasinghe'),
(6, 'IT4', 'Dr. Shalini Perera');

-- --------------------------------------------------------

--
-- Table structure for table `lab`
--

CREATE TABLE `lab` (
  `Lab_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `Capacity` int(11) DEFAULT NULL,
  `Lab_TO_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab`
--

INSERT INTO `lab` (`Lab_ID`, `Name`, `Type`, `Capacity`, `Lab_TO_ID`) VALUES
(1, 'Physics Lab', 'Physics', 30, 1),
(2, 'Computer Lab', 'Computer Science', 40, 1),
(3, 'Electronics Lab', 'Electronics', 35, 2),
(4, 'Mechanical Lab', 'Mechanical', 20, 2),
(5, 'Civil Lab', 'Civil', 25, 2);

-- --------------------------------------------------------

--
-- Table structure for table `lab_booking`
--

CREATE TABLE `lab_booking` (
  `Booking_ID` int(11) NOT NULL,
  `Booking_Date` date DEFAULT NULL,
  `Status` enum('pending','approved','rejected','cancelled','confirmed') NOT NULL DEFAULT 'confirmed',
  `Student_ID` varchar(20) DEFAULT NULL,
  `Schedule_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_booking`
--

INSERT INTO `lab_booking` (`Booking_ID`, `Booking_Date`, `Status`, `Student_ID`, `Schedule_ID`) VALUES
(1, '2025-06-20', 'confirmed', '2022e180', 1),
(2, '2025-07-05', 'confirmed', '2022e183', 2),
(3, '2025-07-06', 'pending', '2022e184', 3),
(4, '2025-07-07', 'approved', '2022e183', 4),
(5, '2025-07-08', 'rejected', '2022e184', 4);

-- --------------------------------------------------------

--
-- Table structure for table `lab_equipment`
--

CREATE TABLE `lab_equipment` (
  `Equipment_ID` int(11) NOT NULL,
  `Lab_ID` int(11) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_equipment`
--

INSERT INTO `lab_equipment` (`Equipment_ID`, `Lab_ID`, `Name`, `Quantity`) VALUES
(1, 1, 'Oscilloscope', 10),
(2, 2, 'Desktop PC', 40),
(3, 3, 'Multimeter', 12),
(4, 3, 'Soldering Station', 5),
(5, 4, 'Lathe Machine', 2),
(6, 4, 'Drill Press', 3),
(7, 5, 'Concrete Mixer', 1),
(8, 5, 'Compression Tester', 2);

-- --------------------------------------------------------

--
-- Table structure for table `lab_schedule`
--

CREATE TABLE `lab_schedule` (
  `Schedule_ID` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Start_Time` time DEFAULT NULL,
  `End_Time` time DEFAULT NULL,
  `Lab_ID` int(11) DEFAULT NULL,
  `Remaining_Capacity` int(11) DEFAULT NULL,
  `Status` enum('pending','approved','rejected') DEFAULT 'pending',
  `Instructor_ID` int(11) DEFAULT NULL,
  `Lab_TO_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_schedule`
--

INSERT INTO `lab_schedule` (`Schedule_ID`, `Date`, `Start_Time`, `End_Time`, `Lab_ID`, `Remaining_Capacity`, `Status`, `Instructor_ID`, `Lab_TO_ID`) VALUES
(1, '2025-07-01', '09:00:00', '11:00:00', 1, 30, 'approved', 1, 1),
(2, '2025-07-10', '08:00:00', '10:00:00', 3, 35, 'approved', 3, 2),
(3, '2025-07-12', '14:00:00', '16:00:00', 4, 20, 'pending', 4, 2),
(4, '2025-07-15', '09:00:00', '11:00:00', 5, 25, 'approved', 3, 2),
(5, '2025-07-23', '08:00:00', '12:00:00', 2, 20, 'approved', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lab_to`
--

CREATE TABLE `lab_to` (
  `Lab_TO_ID` int(11) NOT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_to`
--

INSERT INTO `lab_to` (`Lab_TO_ID`, `user_id`, `Name`) VALUES
(1, 'TO1', 'Charlie Brown'),
(2, 'TO2', 'Ruwan Jayasuriya'),
(3, 'TO2', 'Ruwan Jayasuriya');

-- --------------------------------------------------------

--
-- Table structure for table `lecture`
--

CREATE TABLE `lecture` (
  `Lecture_ID` int(11) NOT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Department` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecture`
--

INSERT INTO `lecture` (`Lecture_ID`, `user_id`, `Name`, `Department`) VALUES
(1, 'L1', 'Prof. Diana Prince', 'Computer Science'),
(2, 'L2', 'Prof. Nadeesha Fernando', 'Mechanical Engineering'),
(3, 'L3', 'Dr. Amara Silva', 'Civil Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Student_ID` varchar(20) NOT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Semester` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Student_ID`, `user_id`, `Name`, `Semester`) VALUES
('2022e180', 'ST1', 'Alice Johnson', 4),
('2022e183', 'ST3', 'Ishan Fernando', 2),
('2022e184', 'ST4', 'Harini Gunasekara', 1),
('it5', 'ST2', 'madushanka', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','instructor','labto','lecture') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `status`) VALUES
('IT1', 'instructor1', 'pass123', 'instructor', 'active'),
('IT2', 'madushanka', 'madu123', 'instructor', 'active'),
('IT3', 'instructor3', 'pass321', 'instructor', 'active'),
('IT4', 'instructor4', 'pass654', 'instructor', 'active'),
('L1', 'lecture1', 'pass123', 'lecture', 'active'),
('L2', 'lecture2', 'pass654', 'lecture', 'active'),
('L3', 'lecture3', 'pass987', 'lecture', 'active'),
('ST1', 'student1', 'pass123', 'student', 'active'),
('ST2', 'navidu', 'stu123', 'student', 'active'),
('ST3', 'student3', 'pass789', 'student', 'active'),
('ST4', 'student4', 'pass987', 'student', 'active'),
('TO1', 'labto1', 'pass123', 'labto', 'active'),
('TO2', 'labto2', 'pass321', 'labto', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`Instructor_ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lab`
--
ALTER TABLE `lab`
  ADD PRIMARY KEY (`Lab_ID`),
  ADD KEY `Lab_TO_ID` (`Lab_TO_ID`);

--
-- Indexes for table `lab_booking`
--
ALTER TABLE `lab_booking`
  ADD PRIMARY KEY (`Booking_ID`),
  ADD KEY `Student_ID` (`Student_ID`),
  ADD KEY `Schedule_ID` (`Schedule_ID`);

--
-- Indexes for table `lab_equipment`
--
ALTER TABLE `lab_equipment`
  ADD PRIMARY KEY (`Equipment_ID`),
  ADD KEY `Lab_ID` (`Lab_ID`);

--
-- Indexes for table `lab_schedule`
--
ALTER TABLE `lab_schedule`
  ADD PRIMARY KEY (`Schedule_ID`),
  ADD KEY `Lab_ID` (`Lab_ID`),
  ADD KEY `Instructor_ID` (`Instructor_ID`),
  ADD KEY `Lab_TO_ID` (`Lab_TO_ID`);

--
-- Indexes for table `lab_to`
--
ALTER TABLE `lab_to`
  ADD PRIMARY KEY (`Lab_TO_ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lecture`
--
ALTER TABLE `lecture`
  ADD PRIMARY KEY (`Lecture_ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Student_ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `Instructor_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lab`
--
ALTER TABLE `lab`
  MODIFY `Lab_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lab_booking`
--
ALTER TABLE `lab_booking`
  MODIFY `Booking_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lab_equipment`
--
ALTER TABLE `lab_equipment`
  MODIFY `Equipment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `lab_schedule`
--
ALTER TABLE `lab_schedule`
  MODIFY `Schedule_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lab_to`
--
ALTER TABLE `lab_to`
  MODIFY `Lab_TO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lecture`
--
ALTER TABLE `lecture`
  MODIFY `Lecture_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `instructor`
--
ALTER TABLE `instructor`
  ADD CONSTRAINT `instructor_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `lab`
--
ALTER TABLE `lab`
  ADD CONSTRAINT `lab_ibfk_1` FOREIGN KEY (`Lab_TO_ID`) REFERENCES `lab_to` (`Lab_TO_ID`) ON DELETE SET NULL;

--
-- Constraints for table `lab_booking`
--
ALTER TABLE `lab_booking`
  ADD CONSTRAINT `lab_booking_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `student` (`Student_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `lab_booking_ibfk_2` FOREIGN KEY (`Schedule_ID`) REFERENCES `lab_schedule` (`Schedule_ID`) ON DELETE CASCADE;

--
-- Constraints for table `lab_equipment`
--
ALTER TABLE `lab_equipment`
  ADD CONSTRAINT `lab_equipment_ibfk_1` FOREIGN KEY (`Lab_ID`) REFERENCES `lab` (`Lab_ID`) ON DELETE CASCADE;

--
-- Constraints for table `lab_schedule`
--
ALTER TABLE `lab_schedule`
  ADD CONSTRAINT `lab_schedule_ibfk_1` FOREIGN KEY (`Lab_ID`) REFERENCES `lab` (`Lab_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `lab_schedule_ibfk_2` FOREIGN KEY (`Instructor_ID`) REFERENCES `instructor` (`Instructor_ID`) ON DELETE SET NULL,
  ADD CONSTRAINT `lab_schedule_ibfk_3` FOREIGN KEY (`Lab_TO_ID`) REFERENCES `lab_to` (`Lab_TO_ID`) ON DELETE SET NULL;

--
-- Constraints for table `lab_to`
--
ALTER TABLE `lab_to`
  ADD CONSTRAINT `lab_to_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `lecture`
--
ALTER TABLE `lecture`
  ADD CONSTRAINT `lecture_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
