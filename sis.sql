-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2021 at 07:20 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sis`
--

-- --------------------------------------------------------

--
-- Table structure for table `allocated_subjects`
--

CREATE TABLE `allocated_subjects` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `allocated_subjects`
--

INSERT INTO `allocated_subjects` (`id`, `teacher_id`, `class_id`, `subject_id`) VALUES
(1, 3, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `created_at`) VALUES
(1, 'KG', '2021-12-05 12:21:40'),
(2, '1', '2021-12-05 12:21:57'),
(4, '2', '2021-12-05 12:22:11'),
(5, '3', '2021-12-05 12:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `student_class`
--

CREATE TABLE `student_class` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_class`
--

INSERT INTO `student_class` (`id`, `student_id`, `class_id`) VALUES
(1, 9, 4),
(2, 8, 1),
(3, 9, 5),
(4, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `student_subject`
--

CREATE TABLE `student_subject` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_subject`
--

INSERT INTO `student_subject` (`id`, `student_id`, `subject_id`, `class_id`) VALUES
(1, 9, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` text NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_code` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `class_id`, `subject_code`, `created_at`) VALUES
(1, 'English', 0, 'cd345', '2021-12-03 05:46:07'),
(3, 'English', 2, '234234', '2021-12-05 12:40:40'),
(4, 'Urdu', 4, '34534', '2021-12-05 17:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `time_from` time DEFAULT NULL,
  `time_to` time DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 = not approved, 1 = approved',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`id`, `teacher_id`, `class_id`, `subject_id`, `time_from`, `time_to`, `status`, `created_at`) VALUES
(2, 3, 4, 1, '04:17:00', '05:17:00', 1, '2021-12-06 19:17:11'),
(3, 3, 4, 4, '00:54:00', '05:54:00', 0, '2021-12-07 03:54:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 = not approved, 1 = approved',
  `role` tinyint(4) NOT NULL COMMENT '0 = admin, 1= teacher, 2= student, 3= parent',
  `email` text NOT NULL,
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `city` text NOT NULL,
  `phone` text NOT NULL,
  `salary` text NOT NULL,
  `cnic` text NOT NULL,
  `fee` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `address`, `status`, `role`, `email`, `password`, `created_at`, `city`, `phone`, `salary`, `cnic`, `fee`) VALUES
(1, '', '', '', 1, 0, 'admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2021-12-02 06:17:23', '', '', '', '', ''),
(2, 'Aseer', 'Ali', 'MCB 1/1435 Moh. Line park st# govt. girls high school No. 2', 1, 2, 'shani1825@hotmail.com', '', '2021-12-03 06:10:31', '', '', '', '', ''),
(3, 'Ahmed', 'Ali', 'MCB 1/1435 Moh. Line park st# govt. girls high school No. 2', 1, 1, 'teacher@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2021-12-03 06:21:51', 'Chakwal', '33256485', '433333', '2324234234234234', ''),
(5, 'Zain', 'Ali', '', 1, 1, 'shani1825@hotmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2021-12-05 11:44:51', 'Chakwal', '03085032607', '', '', ''),
(9, 'Hassan', 'Ali', '', 1, 2, 'student@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2021-12-05 17:12:00', 'Chakwal', '03085032607', '', '', '2000'),
(10, '', '', '', 0, 2, '', '', '2021-12-06 18:05:55', '', '', '', '', ''),
(11, 'Zeeshan', 'Ali', 'MCB 1/1435 Moh. Line park st# govt. girls high school No. 2', 0, 1, 'shani1825@hotmail.com', '', '2021-12-06 18:07:55', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allocated_subjects`
--
ALTER TABLE `allocated_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_class`
--
ALTER TABLE `student_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_subject`
--
ALTER TABLE `student_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allocated_subjects`
--
ALTER TABLE `allocated_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_class`
--
ALTER TABLE `student_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student_subject`
--
ALTER TABLE `student_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
