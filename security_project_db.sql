-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2024 at 12:34 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

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
('CHE205', 'Organic Chemistry', 4, 1),
('CS101', 'Introduction to Computer Science', 3, 1),
('CSC301', 'Data Structures and Algorithms', 4, 0),
('ENG110', 'English Composition', 4, 1),
('ENG201', 'Advanced English Writing', 2, 0),
('MAT201', 'Calculus I', 4, 0),
('MUS120', 'Music Appreciation', 3, 0),
('PHY105', 'Physics for Engineers', 3, 1),
('PSY101', 'Introduction to Psychology', 3, 0),
('qwe 1234', 'test', 2, 1),
('test 123', 'testing purpose\\\'s', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_attempts`
--

CREATE TABLE `enrollment_attempts` (
  `id` int(11) NOT NULL,
  `student_matric_number` varchar(255) NOT NULL,
  `attempt_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment_attempts`
--

INSERT INTO `enrollment_attempts` (`id`, `student_matric_number`, `attempt_time`) VALUES
(1, 'AI210334', '2024-06-18 18:15:40'),
(2, 'AI210334', '2024-06-18 18:15:42');

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
(11, 'Ling Chii Sung', '0127482758', 'Male', 'Chinese', 'chiisung1@uthm.edu.my', '$2y$10$AiX/aN6iuK.PVVfe74lpn.os3CVgGiC/LamHOGTmqM4aEOQzPav32', 0, 'chiisung1@gmail.com'),
(12, 'EDISON LING AI BIN', '0123456789', 'Female', 'Other', 'edison@uthm.edu.my', '$2y$10$GnYAHKsrvRsQ35nD2pIJI.nw4zbs.8J4DAywonww/TdoS3tYhrD82', 0, '');

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
(2, 'A', 'bic12346', 10, 'Sun', '04:18:00', '05:18:00', 1, 2, '1', 1),
(3, 'A', 'BIC30503', 12, 'Wed', '08:00:00', '10:00:00', 2, 40, 'BT1', 0),
(3, 'A', 'BIC30513', 12, 'Wed', '02:00:00', '04:00:00', 2, 40, 'BT1', 0),
(3, 'A', 'CSC301', 11, 'Sun', '16:00:00', '18:00:00', 2, 40, 'BT3', 0),
(3, 'K', 'BIC30503', 12, 'Mon', '10:00:00', '12:00:00', 2, 40, 'Auditorium', 0),
(3, 'K', 'BIC30513', 12, 'Mon', '09:00:00', '11:00:00', 2, 40, 'BS1', 0),
(3, 'K', 'CSC301', 11, 'Sun', '14:00:00', '16:00:00', 2, 40, 'Auditorium', 0),
(4, 'A', 'BIC30503', 12, 'Thu', '08:00:00', '10:00:00', 2, 40, 'BT1', 0),
(4, 'K', 'BIC30503', 12, 'Mon', '10:00:00', '12:00:00', 2, 40, 'Auditorium', 0),
(10, 'K', 'qwe 1234', 12, 'Tue', '05:31:00', '08:31:00', 3, 40, 'test', 1),
(11, 'K', 'BUS202', 10, 'Tue', '08:00:00', '10:00:00', 2, 40, 'BK3', 0);

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
  `student_nationality` enum('Malaysian','Non-Malaysian') NOT NULL,
  `student_gender` enum('Male','Female') NOT NULL,
  `student_race` enum('Malay','Chinese','India','Other') NOT NULL,
  `student_personal_email` varchar(255) DEFAULT NULL,
  `student_student_email` varchar(255) NOT NULL,
  `student_muet_band` enum('1','2','3','4','5','6') NOT NULL,
  `student_pre_university_result` varchar(255) NOT NULL,
  `student_archive` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_matric_number`, `student_name`, `student_phone_number`, `student_IC`, `student_password`, `student_DOB`, `student_nationality`, `student_gender`, `student_race`, `student_personal_email`, `student_student_email`, `student_muet_band`, `student_pre_university_result`, `student_archive`) VALUES
('AI012345', 'Test', '01184923564', '0123456789', '$2y$10$twiUhnfSq8pht8c758Eus.xRB.ff94zLgYemjaJ8ktl9dwVaPQ0Ki', '2003-06-11', 'Non-Malaysian', 'Male', 'Other', '', 'test@student.uthm.edu.my', '6', '4.00', 0),
('AI210334', 'See Hong Chen', '01110789940', '010320011147', '$2y$10$03r222V00P7f.OAscuWDa.4xzO0iMbPIXwLCtOhnyrugu2dJ61TT2', '2001-03-20', 'Malaysian', 'Male', 'Chinese', 'hongchensee8@gmail.com', 'AI210334@student.uthm.edu.my', '4', '3.67', 0),
('AI210343', 'Ling Chii Sung', '0128579285', '010234015678', '$2y$10$2IHyAes4hWoEPW.rtCCnlu07oaypeMTzMBGZDvoDKyHm2l5C5kpmS', '2001-06-01', 'Non-Malaysian', 'Male', 'Chinese', 'chiisung@gmail.com', 'AI210343@student.uthm.edu.my', '2', '3.50', 0),
('AI210408', 'Edison Ling Ai Bin', '01118572859', '098765017583', '$2y$10$4HUezdIe8B6oSUhb6QXiguIA4ggVv6570kBOdULXILLlhLKJ.yz/6', '2024-05-07', 'Malaysian', 'Male', 'Chinese', 'edison@gmail.com', 'AI210408@student.uthm.edu.my', '3', '3.5', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_section`
--

CREATE TABLE `student_section` (
  `student_matric_number` varchar(255) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `section_number` int(11) NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  `quiz_mark` decimal(10,2) NOT NULL,
  `assignment_mark` decimal(10,2) NOT NULL,
  `test_mark` decimal(10,2) NOT NULL,
  `project_mark` decimal(10,2) NOT NULL,
  `course_mark` decimal(10,2) DEFAULT NULL,
  `final_mark` decimal(10,2) NOT NULL,
  `course_grade` varchar(255) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `expired` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_section`
--

INSERT INTO `student_section` (`student_matric_number`, `course_code`, `section_number`, `lecturer_id`, `quiz_mark`, `assignment_mark`, `test_mark`, `project_mark`, `course_mark`, `final_mark`, `course_grade`, `enrollment_date`, `expired`) VALUES
('AI210334', 'BIC30503', 1, 11, '0.00', '0.00', '0.00', '0.00', '100.00', '0.00', 'A', '2024-05-01', b'1'),
('AI210408', 'BIC30513', 3, 12, '5.00', '20.00', '15.00', '20.00', '60.00', '0.00', 'B-', '2024-05-21', b'0'),
('AI210334', 'BIC30513', 3, 12, '5.00', '20.00', '15.00', '20.00', '60.00', '40.00', 'A+', '2024-06-01', b'0'),
('AI210343', 'BIC30513', 3, 12, '5.00', '20.00', '11.00', '18.00', '54.00', '30.00', 'A', '2024-06-01', b'0'),
('AI012345', 'BIC30513', 3, 12, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'F', '2024-06-01', b'0'),
('AI210334', 'ACC101', 1, 10, '0.00', '0.00', '0.00', '0.00', NULL, '0.00', NULL, '2024-06-18', b'0'),
('AI210334', 'BIC30503', 3, 12, '5.00', '20.00', '15.00', '20.00', '60.00', '40.00', 'A+', '2024-06-18', b'0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_code`);

--
-- Indexes for table `enrollment_attempts`
--
ALTER TABLE `enrollment_attempts`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `course_code` (`course_code`),
  ADD KEY `section_number` (`section_number`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enrollment_attempts`
--
ALTER TABLE `enrollment_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `lecturer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
