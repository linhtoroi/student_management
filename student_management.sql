-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 28, 2020 at 12:51 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

CREATE TABLE `challenges` (
  `challenge` int(5) NOT NULL,
  `account` varchar(15) NOT NULL,
  `hint` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`challenge`, `account`, `hint`) VALUES
(1, '1000', 'Người Việt Nam đầu tiên đặt chân lên mặt trăng'),
(6, '1000', 'Thành phố xanh hòa bình Soi bóng dòng sông đổ Lịch sư ngàn năm qua Bao dấu son còn đó Đây Ba Đình , Đống Đa Đây Hồ Gươm , Tháp Bút Mãi mãi bản hùng ca ?'),
(7, '1000', 'Thủ đô của nước Việt Nam'),
(8, '1000', 'Thủ đô của nước Việt Nam');

-- --------------------------------------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE `exercise` (
  `account` varchar(15) NOT NULL,
  `codeOfExercise` int(15) NOT NULL,
  `summarise` varchar(50) NOT NULL,
  `fileName` varchar(100) NOT NULL,
  `fileEnding` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exercise`
--

INSERT INTO `exercise` (`account`, `codeOfExercise`, `summarise`, `fileName`, `fileEnding`) VALUES
('1000', 10, 'haha', 'BaitapChuong1.txt', 'text/plain'),
('1000', 11, 'haha', 'Ha Noi.txt', 'text/plain'),
('1000', 12, 'haha', 'hahaha.txt', 'text/plain');

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE `homework` (
  `accountStudent` varchar(15) NOT NULL,
  `codeOfExercise` int(15) NOT NULL,
  `completedExercise` text NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `mark` int(2) DEFAULT NULL,
  `fileEnding` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `homework`
--

INSERT INTO `homework` (`accountStudent`, `codeOfExercise`, `completedExercise`, `time`, `mark`, `fileEnding`) VALUES
('18020758', 10, 'Ha Noi.txt', '2020-09-27 20:58:36', NULL, 'text/plain'),
('18020758', 11, 'hahaha.txt', '2020-09-27 21:42:10', NULL, 'text/plain');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `accountReceiver` varchar(15) NOT NULL,
  `accountSender` varchar(15) NOT NULL,
  `message` text NOT NULL,
  `fileEnding` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`accountReceiver`, `accountSender`, `message`, `fileEnding`) VALUES
('18020759', '18020758', '18020759_18020758.txt', 'text/plain'),
('18020758', '1000', '1801_1000.txt', 'text/plain');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `account` varchar(15) NOT NULL,
  `passwordOfUser` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`account`, `passwordOfUser`) VALUES
('1000', '1000abc'),
('1001', '1001abcdefgh'),
('1111', 'hhiiii'),
('18020758', 'hihihi'),
('18020759', 'jdgsfhjgsa'),
('18020760', 'hihihi'),
('18020761', 'hihihi'),
('18020762', 'hihi'),
('18020763', 'hihihi'),
('1802078', 'hxhhxh'),
('18020799', 'hihihi');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `account` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fullName` varchar(50) NOT NULL,
  `phoneNumber` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`account`, `email`, `fullName`, `phoneNumber`) VALUES
('18020758', 'linhhaha@gmail.com', 'Hoàng Linh', 909090),
('18020759', 'hangnguyenthi@gmail.com', 'Nguyễn Thị Hằng', 900678910),
('18020762', 'linhlinh.torres.reus@gmail.com', 'Nguyễn Thanh Tùng', 911782129),
('18020763', 'linhlinh.torres.reus@gmail.com', 'Nguyễn Thanh Tùng', 911782129),
('18020799', 'tung@gmail.com', 'Nguyễn Thanh Tùng', 911782129);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `account` varchar(15) NOT NULL,
  `nameOfTeacher` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`account`, `nameOfTeacher`) VALUES
('1000', 'Ma Thị Châu'),
('1001', 'Nguyễn Đại Thọ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`challenge`);

--
-- Indexes for table `exercise`
--
ALTER TABLE `exercise`
  ADD PRIMARY KEY (`codeOfExercise`),
  ADD KEY `fk_accountTC1` (`account`);

--
-- Indexes for table `homework`
--
ALTER TABLE `homework`
  ADD PRIMARY KEY (`codeOfExercise`),
  ADD KEY `fk_accountST1` (`accountStudent`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD KEY `fk_accounR` (`accountReceiver`),
  ADD KEY `fk_accountS` (`accountSender`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`account`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`account`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD KEY `fk_accountTC` (`account`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `challenges`
--
ALTER TABLE `challenges`
  MODIFY `challenge` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `exercise`
--
ALTER TABLE `exercise`
  MODIFY `codeOfExercise` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exercise`
--
ALTER TABLE `exercise`
  ADD CONSTRAINT `fk_accountTC1` FOREIGN KEY (`account`) REFERENCES `teacher` (`account`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `homework`
--
ALTER TABLE `homework`
  ADD CONSTRAINT `fk_accountST1` FOREIGN KEY (`accountStudent`) REFERENCES `student` (`account`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_codeOfExs` FOREIGN KEY (`codeOfExercise`) REFERENCES `exercise` (`codeOfExercise`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_accounR` FOREIGN KEY (`accountReceiver`) REFERENCES `person` (`account`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_accountS` FOREIGN KEY (`accountSender`) REFERENCES `person` (`account`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_accountST` FOREIGN KEY (`account`) REFERENCES `person` (`account`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `fk_accountTC` FOREIGN KEY (`account`) REFERENCES `person` (`account`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
