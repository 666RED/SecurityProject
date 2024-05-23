-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 04:44 PM
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
-- Database: `security_project_db`
--

CREATE DATABASE security_project_db;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_code` varchar(255) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_credit_hour` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_code`, `course_name`, `course_credit_hour`) VALUES
('CS101', 'Introduction to Computer Science', 3),
('ENG201', 'Advanced English Writing', 2);

-- --------------------------------------------------------

--
-- Table structure for table `course_lecturer`
--

CREATE TABLE `course_lecturer` (
  `course_code` varchar(255) NOT NULL,
  `lecturer_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_lecturer`
--

INSERT INTO `course_lecturer` (`course_code`, `lecturer_id`) VALUES
('CS101', 'noraini'),
('ENG201', 'sitihajar');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `lecturer_id` varchar(255) NOT NULL,
  `lecturer_name` varchar(255) NOT NULL,
  `lecturer_phone_number` varchar(255) NOT NULL,
  `lecturer_gender` varchar(255) NOT NULL,
  `lecturer_race` varchar(255) NOT NULL,
  `lecturer_email` varchar(255) NOT NULL,
  `lecturer_personal_email` varchar(255) DEFAULT NULL,
  `lecturer_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`lecturer_id`, `lecturer_name`, `lecturer_phone_number`, `lecturer_gender`, `lecturer_race`, `lecturer_email`, `lecturer_personal_email`, `lecturer_password`) VALUES
('noraini', 'Noraini Binti Ahmad', '012-3456789', 'Female', 'Malay', 'noraini@example.com', NULL, 'password123'),
('sitihajar', 'Siti Hajar Binti Mohamed', '019-8765432', 'Female', 'Malay', 'sitihajar@example.com', NULL, 'securepassword');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `lecturer_id` varchar(255) NOT NULL,
  `section_number` int(11) NOT NULL,
  `section_day` varchar(255) NOT NULL,
  `section_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `course_code`, `lecturer_id`, `section_number`, `section_day`, `section_time`) VALUES
(1, 'CS101', 'noraini', 1, 'Monday', '08:00:00'),
(2, 'ENG201', 'sitihajar', 1, 'Wednesday', '10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` varchar(255) NOT NULL,
  `staff_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_password`) VALUES
('admin', '$2y$10$LItoFp7E2Zw0g8uxnZA7zeaAwwvqUZ9EXgdPzwH3hK/4Ro5fYRxYi');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_matric_number` varchar(255) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_phone_number` varchar(255) NOT NULL,
  `student_IC` varchar(255) NOT NULL,
  `student_password` varchar(255) NOT NULL,
  `student_DOB` date NOT NULL,
  `student_nationality` varchar(255) NOT NULL,
  `student_gender` varchar(255) NOT NULL,
  `student_race` varchar(255) NOT NULL,
  `student_personal_email` varchar(255) DEFAULT NULL,
  `student_student_email` varchar(255) NOT NULL,
  `student_muet_band` int(11) NOT NULL,
  `student_pre_university_result` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_matric_number`, `student_name`, `student_phone_number`, `student_IC`, `student_password`, `student_DOB`, `student_nationality`, `student_gender`, `student_race`, `student_personal_email`, `student_student_email`, `student_muet_band`, `student_pre_university_result`) VALUES
('A123456', 'John Doe', '123-456-7890', '123456-01-2345', 'password123', '2000-01-01', 'Malaysian', 'Male', 'Asian', 'john.doe@example.com', 'john.doe@student.example.com', 4, 'STPM'),
('B987654', 'Jane Smith', '987-654-3210', '987654-12-3456', 'securepassword', '1999-05-15', 'Malaysian', 'Female', 'Caucasian', 'jane.smith@example.com', 'jane.smith@student.example.com', 5, 'A-Levels');

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE `student_course` (
  `student_matric_number` varchar(255) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `course_mark` int(11) DEFAULT NULL,
  `course_grade` varchar(255) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`student_matric_number`, `course_code`, `course_mark`, `course_grade`, `enrollment_date`) VALUES
('A123456', 'CS101', 85, 'A', '2024-05-01'),
('B987654', 'ENG201', 78, 'B', '2024-05-03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_code`);

--
-- Indexes for table `course_lecturer`
--
ALTER TABLE `course_lecturer`
  ADD PRIMARY KEY (`course_code`,`lecturer_id`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`lecturer_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `course_code` (`course_code`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_matric_number`);

--
-- Indexes for table `student_course`
--
ALTER TABLE `student_course`
  ADD PRIMARY KEY (`student_matric_number`,`course_code`),
  ADD KEY `course_code` (`course_code`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_lecturer`
--
ALTER TABLE `course_lecturer`
  ADD CONSTRAINT `course_lecturer_ibfk_1` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`),
  ADD CONSTRAINT `course_lecturer_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`),
  ADD CONSTRAINT `section_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`);

--
-- Constraints for table `student_course`
--
ALTER TABLE `student_course`
  ADD CONSTRAINT `student_course_ibfk_1` FOREIGN KEY (`student_matric_number`) REFERENCES `student` (`student_matric_number`),
  ADD CONSTRAINT `student_course_ibfk_2` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
