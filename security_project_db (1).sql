-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2024 at 10:30 PM
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
  `course_credit_hour` int(11) NOT NULL,
  `course_archive` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_code`, `course_name`, `course_credit_hour`, `course_archive`) VALUES
('ACC101', 'Introduction To Accounting', 3, 0),
('bic12345', 'hello world', 2, 1),
('bic12346', 'hello world', 2, 1),
('BIC30503', 'Software Security Engineering', 3, 0),
('BIC30513', 'Algorithm And Complexity', 3, 0),
('BUS202', 'Business Ethics', 3, 0),
('CHE205', 'Organic Chemistry', 4, 0),
('CS101', 'Introduction to Computer Science', 3, 0),
('CSC301', 'Data Structures and Algorithms', 4, 0),
('ENG110', 'English Composition', 4, 0),
('ENG201', 'Advanced English Writing', 2, 0),
('MAT201', 'Calculus I', 4, 0),
('MUS120', 'Music Appreciation', 3, 0),
('PHY105', 'Physics for Engineers', 3, 0),
('PSY101', 'Introduction to Psychology', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `lecturer_id` int(11) NOT NULL,
  `lecturer_name` varchar(255) NOT NULL,
  `lecturer_phone_number` varchar(255) NOT NULL,
  `lecturer_gender` enum('Male','Female') NOT NULL,
  `lecturer_race` enum('Malay','Chinese','India','Other') NOT NULL,
  `lecturer_email` varchar(255) NOT NULL,
  `lecturer_password` varchar(255) NOT NULL,
  `lecturer_archive` tinyint(1) NOT NULL DEFAULT 0,
  `lecturer_personal_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`lecturer_id`, `lecturer_name`, `lecturer_phone_number`, `lecturer_gender`, `lecturer_race`, `lecturer_email`, `lecturer_password`, `lecturer_archive`, `lecturer_personal_email`) VALUES
(4, 'Ling Chii Sung', '0128888888', 'Male', 'Chinese', 'chiisung@uthm.edu.my', '$2y$10$eUcAzQ4G3C4upUWywRqAU.8cD0pvM.ky4iEp1Fym7gIbaZjdhEHUK', 1, 'chiisung@gmail.com'),
(10, 'See Hong Chen', '01110789940', 'Male', 'Chinese', 'hongchen@uthm.edu.my', '$2y$10$Q5gLtNg.XCYWZgKqwuaBk.nfVZ/1ljBAvzBW1aoRtIEsy07q7KgzS', 0, 'hongchen@gmail.com'),
(11, 'Ling Chii Sung', '0127482758', 'Male', 'Chinese', 'chiisung1@uthm.edu.my', '$2y$10$AiX/aN6iuK.PVVfe74lpn.os3CVgGiC/LamHOGTmqM4aEOQzPav32', 0, 'chiisung1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_number` int(11) NOT NULL,
  `section_type` varchar(255) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  `section_day` varchar(255) NOT NULL,
  `section_start_time` time NOT NULL,
  `section_end_time` time NOT NULL,
  `section_duration` int(11) NOT NULL,
  `section_quota` int(11) NOT NULL,
  `section_location` varchar(255) NOT NULL,
  `section_archive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_number`, `section_type`, `course_code`, `lecturer_id`, `section_day`, `section_start_time`, `section_end_time`, `section_duration`, `section_quota`, `section_location`, `section_archive`) VALUES
(1, 'A', 'ACC101', 10, 'Mon', '05:08:00', '07:08:00', 2, 2, '2', 0),
(2, 'A', 'bic12346', 10, 'Sun', '04:18:00', '05:18:00', 1, 2, '1', 1);

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
  `student_pre_university_result` varchar(255) NOT NULL,
  `student_archive` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_matric_number`, `student_name`, `student_phone_number`, `student_IC`, `student_password`, `student_DOB`, `student_nationality`, `student_gender`, `student_race`, `student_personal_email`, `student_student_email`, `student_muet_band`, `student_pre_university_result`, `student_archive`) VALUES
('A123456', 'John Doe', '123-456-7890', '123456-01-2345', 'password123', '2000-01-01', 'Malaysian', 'Male', 'Asian', 'john.doe@example.com', 'john.doe@student.example.com', 4, 'STPM', 0),
('B987654', 'Jane Smith', '987-654-3210', '987654-12-3456', 'securepassword', '1999-05-15', 'Malaysian', 'Female', 'Caucasian', 'jane.smith@example.com', 'jane.smith@student.example.com', 5, 'A-Levels', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_section`
--

CREATE TABLE `student_section` (
  `student_matric_number` varchar(255) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `section_number` int(11) NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  `course_mark` int(11) DEFAULT NULL,
  `course_grade` varchar(255) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `expired` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_code`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`lecturer_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_number`,`section_type`,`course_code`),
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
-- Indexes for table `student_section`
--
ALTER TABLE `student_section`
  ADD PRIMARY KEY (`student_matric_number`,`course_code`,`section_number`),
  ADD KEY `course_code` (`course_code`),
  ADD KEY `section_number` (`section_number`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `lecturer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`),
  ADD CONSTRAINT `section_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`);

--
-- Constraints for table `student_section`
--
ALTER TABLE `student_section`
  ADD CONSTRAINT `student_section_ibfk_1` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`),
  ADD CONSTRAINT `student_section_ibfk_2` FOREIGN KEY (`section_number`) REFERENCES `section` (`section_number`),
  ADD CONSTRAINT `student_section_ibfk_3` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
