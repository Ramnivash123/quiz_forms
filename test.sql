-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2024 at 05:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `qn` int(11) NOT NULL,
  `question` text NOT NULL,
  `opt1` varchar(100) NOT NULL,
  `opt2` varchar(100) NOT NULL,
  `opt3` varchar(100) NOT NULL,
  `opt4` varchar(100) NOT NULL,
  `answer` text NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `qn`, `question`, `opt1`, `opt2`, `opt3`, `opt4`, `answer`, `title`) VALUES
(95, 1, '6+6', '12', '1', '2', '3', '12', 'add6'),
(96, 2, '7+7', '14', '1', '2', '3', '14', 'add6');

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `timer` int(11) NOT NULL,
  `teacher` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `c_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`id`, `title`, `timer`, `teacher`, `subject`, `c_date`) VALUES
(65, 'add6', 2, 'Ramnivash', 'mat6', '2024-08-09 21:26:28');

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE `feed` (
  `id` int(11) NOT NULL,
  `qn` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `timing` time NOT NULL,
  `c_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `feed`
--

INSERT INTO `feed` (`id`, `qn`, `name`, `reason`, `title`, `subject`, `timing`, `c_date`) VALUES
(28, 1, 'Harish', 'Boring', 'add6', 'mat6', '00:00:03', '2024-08-09 21:05:29');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `stu_name` varchar(100) NOT NULL,
  `correct` int(11) NOT NULL,
  `wrong` int(11) NOT NULL,
  `marks` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `time_difference` time NOT NULL,
  `status` varchar(10) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`id`, `title`, `stu_name`, `correct`, `wrong`, `marks`, `date`, `start_time`, `end_time`, `time_difference`, `status`) VALUES
(79, 'add1', 'Harish', 2, 0, 100, '2024-07-31', '11:42:50', '11:43:01', '00:00:11', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `stu_signup`
--

CREATE TABLE `stu_signup` (
  `id` int(11) NOT NULL,
  `na` varchar(100) NOT NULL,
  `em` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stu_signup`
--

INSERT INTO `stu_signup` (`id`, `na`, `em`, `pass`) VALUES
(12, 'Harish', 'harish@gmail.com', '$2y$10$9fAxKQ1P/WqhcYqYeOEeOOMqTZ7pTs1JyxdSLyGnPHw/ReM6i/sVK');

-- --------------------------------------------------------

--
-- Table structure for table `tea_signup`
--

CREATE TABLE `tea_signup` (
  `id` int(11) NOT NULL,
  `na` varchar(100) NOT NULL,
  `em` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tea_signup`
--

INSERT INTO `tea_signup` (`id`, `na`, `em`, `pass`) VALUES
(12, 'Ramnivash', 'ram@gmail.com', '$2y$10$SwB7rsQUZxuauA5zryyXtOFQ5xD.4uxcXGyljfytrRAe0NzjmogR2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stu_signup`
--
ALTER TABLE `stu_signup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tea_signup`
--
ALTER TABLE `tea_signup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `feed`
--
ALTER TABLE `feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `stu_signup`
--
ALTER TABLE `stu_signup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tea_signup`
--
ALTER TABLE `tea_signup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
