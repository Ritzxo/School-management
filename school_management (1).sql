-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2025 at 03:44 PM
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
-- Database: `school management`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `capacity` int(11) NOT NULL,
  `classID` int(11) NOT NULL,
  `className` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`capacity`, `classID`, `className`) VALUES
(20, 1, '1A'),
(20, 2, '1B'),
(20, 3, '1C'),
(30, 4, '2A'),
(30, 5, '2B'),
(30, 6, '2C'),
(30, 7, '3A'),
(30, 8, '3B'),
(30, 9, '3C'),
(30, 10, '4A'),
(30, 11, '4B'),
(30, 12, '4C'),
(30, 13, '5A'),
(30, 14, '5B'),
(30, 15, '8A'),
(30, 16, '5C'),
(30, 17, '6A'),
(30, 18, '6B'),
(30, 19, '6C'),
(30, 20, '7A'),
(30, 21, '7B'),
(30, 22, '7C'),
(20, 25, '101');

-- --------------------------------------------------------

--
-- Table structure for table `dinner_money`
--

CREATE TABLE `dinner_money` (
  `Amount` int(11) NOT NULL,
  `DinnerMoneyID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `Pupil_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dinner_money`
--

INSERT INTO `dinner_money` (`Amount`, `DinnerMoneyID`, `PaymentDate`, `Pupil_ID`) VALUES
(500, 127, '2025-05-16', 331),
(510, 128, '2025-05-17', 332),
(520, 129, '2025-05-18', 333),
(530, 130, '2025-05-19', 334),
(540, 131, '2025-05-20', 335),
(550, 132, '2025-05-21', 336),
(560, 133, '2025-05-22', 337),
(570, 134, '2025-05-23', 338),
(580, 135, '2025-05-24', 339),
(590, 136, '2025-05-25', 340),
(600, 137, '2025-05-26', 341),
(610, 138, '2025-05-27', 342),
(620, 139, '2025-05-28', 343),
(630, 140, '2025-05-29', 344),
(640, 141, '2025-05-30', 345),
(650, 142, '2025-05-31', 346),
(660, 143, '2025-06-01', 347),
(670, 144, '2025-06-02', 348),
(680, 145, '2025-06-03', 349),
(690, 146, '2025-06-04', 350),
(700, 147, '2025-06-05', 351),
(710, 148, '2025-06-06', 352),
(720, 149, '2025-06-07', 353),
(730, 150, '2025-06-08', 354),
(740, 151, '2025-06-09', 355),
(750, 152, '2025-06-10', 356),
(760, 153, '2025-06-11', 357),
(770, 154, '2025-06-12', 358),
(780, 155, '2025-06-13', 359),
(790, 156, '2025-06-14', 360),
(800, 157, '2025-06-15', 361),
(810, 158, '2025-06-16', 362),
(820, 159, '2025-06-17', 363),
(830, 160, '2025-06-18', 364),
(840, 161, '2025-06-19', 365);

-- --------------------------------------------------------

--
-- Table structure for table `library_books`
--

CREATE TABLE `library_books` (
  `Author` text NOT NULL,
  `BookTitle` text NOT NULL,
  `Book_ID` int(11) NOT NULL,
  `IssueDate` int(11) NOT NULL,
  `Pupil_ID` int(11) NOT NULL,
  `ReturnDate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `library_books`
--

INSERT INTO `library_books` (`Author`, `BookTitle`, `Book_ID`, `IssueDate`, `Pupil_ID`, `ReturnDate`) VALUES
('Author 1', 'Book Title 1', 322, 2025, 286, 2025),
('Author 2', 'Book Title 2', 323, 2025, 287, 2025),
('Author 3', 'Book Title 3', 324, 2025, 288, 2025),
('Author 4', 'Book Title 4', 325, 2025, 289, 2025),
('Author 5', 'Book Title 5', 326, 2025, 290, 2025),
('Author 6', 'Book Title 6', 327, 2025, 291, 2025),
('Author 7', 'Book Title 7', 328, 2025, 292, 2025),
('Author 8', 'Book Title 8', 329, 2025, 293, 2025),
('Author 9', 'Book Title 9', 330, 2025, 294, 2025),
('Author 10', 'Book Title 10', 331, 2025, 295, 2025),
('Author 11', 'Book Title 11', 332, 2025, 296, 2025),
('Author 12', 'Book Title 12', 333, 2025, 297, 2025),
('Author 13', 'Book Title 13', 334, 2025, 298, 2025),
('Author 14', 'Book Title 14', 335, 2025, 299, 2025),
('Author 15', 'Book Title 15', 336, 2025, 300, 2025),
('Author 16', 'Book Title 16', 337, 2025, 301, 2025),
('Author 17', 'Book Title 17', 338, 2025, 302, 2025),
('Author 18', 'Book Title 18', 339, 2025, 303, 2025),
('Author 19', 'Book Title 19', 340, 2025, 304, 2025),
('Author 20', 'Book Title 20', 341, 2025, 305, 2025),
('Author 21', 'Book Title 21', 342, 2025, 306, 2025),
('Author 22', 'Book Title 22', 343, 2025, 307, 2025),
('Author 23', 'Book Title 23', 344, 2025, 308, 2025),
('Author 24', 'Book Title 24', 345, 2025, 309, 2025),
('Author 25', 'Book Title 25', 346, 2025, 310, 2025),
('Author 26', 'Book Title 26', 347, 2025, 311, 2025),
('Author 27', 'Book Title 27', 348, 2025, 312, 2025),
('Author 28', 'Book Title 28', 349, 2025, 313, 2025),
('Author 29', 'Book Title 29', 350, 2025, 314, 2025),
('Author 30', 'Book Title 30', 351, 2025, 315, 2025),
('Author 31', 'Book Title 31', 352, 2025, 316, 2025),
('Author 32', 'Book Title 32', 353, 2025, 317, 2025),
('Author 33', 'Book Title 33', 354, 2025, 318, 2025),
('Author 34', 'Book Title 34', 355, 2025, 319, 2025),
('Author 35', 'Book Title 35', 356, 2025, 320, 2025),
('Author 36', 'Book Title 36', 357, 2025, 321, 2025),
('Author 37', 'Book Title 37', 358, 2025, 322, 2025),
('Author 38', 'Book Title 38', 359, 2025, 323, 2025),
('Author 39', 'Book Title 39', 360, 2025, 324, 2025),
('Author 40', 'Book Title 40', 361, 2025, 325, 2025),
('Author 41', 'Book Title 41', 362, 2025, 326, 2025),
('Author 42', 'Book Title 42', 363, 2025, 327, 2025),
('Author 43', 'Book Title 43', 364, 2025, 328, 2025),
('Author 44', 'Book Title 44', 365, 2025, 329, 2025),
('Author 45', 'Book Title 45', 366, 2025, 330, 2025),
('Author 46', 'Book Title 46', 367, 2025, 331, 2025),
('Author 47', 'Book Title 47', 368, 2025, 332, 2025),
('Author 48', 'Book Title 48', 369, 2025, 333, 2025),
('Author 49', 'Book Title 49', 370, 2025, 334, 2025),
('Author 50', 'Book Title 50', 371, 2025, 335, 2025),
('Author 51', 'Book Title 51', 372, 2025, 336, 2025),
('Author 52', 'Book Title 52', 373, 2025, 337, 2025),
('Author 53', 'Book Title 53', 374, 2025, 338, 2025),
('Author 54', 'Book Title 54', 375, 2025, 339, 2025),
('Author 55', 'Book Title 55', 376, 2025, 340, 2025),
('Author 56', 'Book Title 56', 377, 2025, 341, 2025),
('Author 57', 'Book Title 57', 378, 2025, 342, 2025),
('Author 58', 'Book Title 58', 379, 2025, 343, 2025),
('Author 59', 'Book Title 59', 380, 2025, 344, 2025),
('Author 60', 'Book Title 60', 381, 2025, 345, 2025),
('Author 61', 'Book Title 61', 382, 2025, 346, 2025),
('Author 62', 'Book Title 62', 383, 2025, 347, 2025),
('Author 63', 'Book Title 63', 384, 2025, 348, 2025),
('Author 64', 'Book Title 64', 385, 2025, 349, 2025),
('Author 65', 'Book Title 65', 386, 2025, 350, 2025),
('Author 66', 'Book Title 66', 387, 2025, 351, 2025),
('Author 67', 'Book Title 67', 388, 2025, 352, 2025),
('Author 68', 'Book Title 68', 389, 2025, 353, 2025),
('Author 69', 'Book Title 69', 390, 2025, 354, 2025),
('Author 70', 'Book Title 70', 391, 2025, 355, 2025),
('Author 71', 'Book Title 71', 392, 2025, 356, 2025),
('Author 72', 'Book Title 72', 393, 2025, 357, 2025),
('Author 73', 'Book Title 73', 394, 2025, 358, 2025),
('Author 74', 'Book Title 74', 395, 2025, 359, 2025),
('Author 75', 'Book Title 75', 396, 2025, 360, 2025),
('Author 76', 'Book Title 76', 397, 2025, 361, 2025),
('Author 77', 'Book Title 77', 398, 2025, 362, 2025),
('Author 78', 'Book Title 78', 399, 2025, 363, 2025),
('Author 79', 'Book Title 79', 400, 2025, 364, 2025),
('Author 80', 'Book Title 80', 401, 2025, 365, 2025);

-- --------------------------------------------------------

--
-- Table structure for table `parents_guardians`
--

CREATE TABLE `parents_guardians` (
  `Address` varchar(100) NOT NULL,
  `Email` text NOT NULL,
  `Name` text NOT NULL,
  `ParentID` int(11) NOT NULL,
  `Phone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents_guardians`
--

INSERT INTO `parents_guardians` (`Address`, `Email`, `Name`, `ParentID`, `Phone`) VALUES
('Parent Address 1', 'parent1@email.com', 'Parent 1', 6, 1000000001),
('Parent Address 2', 'parent2@email.com', 'Parent 2', 7, 1000000002),
('Parent Address 3', 'parent3@email.com', 'Parent 3', 8, 1000000003),
('Parent Address 4', 'parent4@email.com', 'Parent 4', 9, 1000000004),
('Parent Address 5', 'parent5@email.com', 'Parent 5', 10, 1000000005),
('Parent Address 6', 'parent6@email.com', 'Parent 6', 11, 1000000006),
('Parent Address 7', 'parent7@email.com', 'Parent 7', 12, 1000000007),
('Parent Address 8', 'parent8@email.com', 'Parent 8', 13, 1000000008),
('Parent Address 9', 'parent9@email.com', 'Parent 9', 14, 1000000009),
('Parent Address 10', 'parent10@email.com', 'Parent 10', 15, 1000000010),
('Parent Address 11', 'parent11@email.com', 'Parent 11', 16, 1000000011),
('Parent Address 12', 'parent12@email.com', 'Parent 12', 17, 1000000012),
('Parent Address 13', 'parent13@email.com', 'Parent 13', 18, 1000000013),
('Parent Address 14', 'parent14@email.com', 'Parent 14', 19, 1000000014),
('Parent Address 15', 'parent15@email.com', 'Parent 15', 20, 1000000015),
('Parent Address 16', 'parent16@email.com', 'Parent 16', 21, 1000000016),
('Parent Address 17', 'parent17@email.com', 'Parent 17', 22, 1000000017),
('Parent Address 18', 'parent18@email.com', 'Parent 18', 23, 1000000018),
('Parent Address 19', 'parent19@email.com', 'Parent 19', 24, 1000000019),
('Parent Address 20', 'parent20@email.com', 'Parent 20', 25, 1000000020),
('Parent Address 21', 'parent21@email.com', 'Parent 21', 26, 1000000021),
('Parent Address 22', 'parent22@email.com', 'Parent 22', 27, 1000000022),
('Parent Address 23', 'parent23@email.com', 'Parent 23', 28, 1000000023),
('Parent Address 24', 'parent24@email.com', 'Parent 24', 29, 1000000024),
('Parent Address 25', 'parent25@email.com', 'Parent 25', 30, 1000000025),
('Parent Address 26', 'parent26@email.com', 'Parent 26', 31, 1000000026),
('Parent Address 27', 'parent27@email.com', 'Parent 27', 32, 1000000027),
('Parent Address 28', 'parent28@email.com', 'Parent 28', 33, 1000000028),
('Parent Address 29', 'parent29@email.com', 'Parent 29', 34, 1000000029),
('Parent Address 30', 'parent30@email.com', 'Parent 30', 35, 1000000030),
('Parent Address 31', 'parent31@email.com', 'Parent 31', 36, 1000000031),
('Parent Address 32', 'parent32@email.com', 'Parent 32', 37, 1000000032),
('Parent Address 33', 'parent33@email.com', 'Parent 33', 38, 1000000033),
('Parent Address 34', 'parent34@email.com', 'Parent 34', 39, 1000000034),
('Parent Address 35', 'parent35@email.com', 'Parent 35', 40, 1000000035),
('Parent Address 36', 'parent36@email.com', 'Parent 36', 41, 1000000036),
('Parent Address 37', 'parent37@email.com', 'Parent 37', 42, 1000000037),
('Parent Address 38', 'parent38@email.com', 'Parent 38', 43, 1000000038),
('Parent Address 39', 'parent39@email.com', 'Parent 39', 44, 1000000039),
('Parent Address 40', 'parent40@email.com', 'Parent 40', 45, 1000000040),
('Parent Address 41', 'parent41@email.com', 'Parent 41', 46, 1000000041),
('Parent Address 42', 'parent42@email.com', 'Parent 42', 47, 1000000042),
('Parent Address 43', 'parent43@email.com', 'Parent 43', 48, 1000000043),
('Parent Address 44', 'parent44@email.com', 'Parent 44', 49, 1000000044),
('Parent Address 45', 'parent45@email.com', 'Parent 45', 50, 1000000045),
('Parent Address 46', 'parent46@email.com', 'Parent 46', 51, 1000000046),
('Parent Address 47', 'parent47@email.com', 'Parent 47', 52, 1000000047),
('Parent Address 48', 'parent48@email.com', 'Parent 48', 53, 1000000048),
('Parent Address 49', 'parent49@email.com', 'Parent 49', 54, 1000000049),
('Parent Address 50', 'parent50@email.com', 'Parent 50', 55, 1000000050),
('Parent Address 51', 'parent51@email.com', 'Parent 51', 56, 1000000051),
('Parent Address 52', 'parent52@email.com', 'Parent 52', 57, 1000000052),
('Parent Address 53', 'parent53@email.com', 'Parent 53', 58, 1000000053),
('Parent Address 54', 'parent54@email.com', 'Parent 54', 59, 1000000054),
('Parent Address 55', 'parent55@email.com', 'Parent 55', 60, 1000000055),
('Parent Address 56', 'parent56@email.com', 'Parent 56', 61, 1000000056),
('Parent Address 57', 'parent57@email.com', 'Parent 57', 62, 1000000057),
('Parent Address 58', 'parent58@email.com', 'Parent 58', 63, 1000000058),
('Parent Address 59', 'parent59@email.com', 'Parent 59', 64, 1000000059),
('Parent Address 60', 'parent60@email.com', 'Parent 60', 65, 1000000060),
('Parent Address 61', 'parent61@email.com', 'Parent 61', 66, 1000000061),
('Parent Address 62', 'parent62@email.com', 'Parent 62', 67, 1000000062),
('Parent Address 63', 'parent63@email.com', 'Parent 63', 68, 1000000063),
('Parent Address 64', 'parent64@email.com', 'Parent 64', 69, 1000000064),
('Parent Address 65', 'parent65@email.com', 'Parent 65', 70, 1000000065),
('Parent Address 66', 'parent66@email.com', 'Parent 66', 71, 1000000066),
('Parent Address 67', 'parent67@email.com', 'Parent 67', 72, 1000000067),
('Parent Address 68', 'parent68@email.com', 'Parent 68', 73, 1000000068),
('Parent Address 69', 'parent69@email.com', 'Parent 69', 74, 1000000069),
('Parent Address 70', 'parent70@email.com', 'Parent 70', 75, 1000000070),
('Parent Address 71', 'parent71@email.com', 'Parent 71', 76, 1000000071),
('Parent Address 72', 'parent72@email.com', 'Parent 72', 77, 1000000072),
('Parent Address 73', 'parent73@email.com', 'Parent 73', 78, 1000000073),
('Parent Address 74', 'parent74@email.com', 'Parent 74', 79, 1000000074),
('Parent Address 75', 'parent75@email.com', 'Parent 75', 80, 1000000075),
('Parent Address 76', 'parent76@email.com', 'Parent 76', 81, 1000000076),
('Parent Address 77', 'parent77@email.com', 'Parent 77', 82, 1000000077),
('Parent Address 78', 'parent78@email.com', 'Parent 78', 83, 1000000078),
('Parent Address 79', 'parent79@email.com', 'Parent 79', 84, 1000000079),
('Parent Address 80', 'parent80@email.com', 'Parent 80', 85, 1000000080);

-- --------------------------------------------------------

--
-- Table structure for table `pupils`
--

CREATE TABLE `pupils` (
  `Address` text NOT NULL,
  `classID` int(11) NOT NULL,
  `Medical_info` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Pupil_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pupils`
--

INSERT INTO `pupils` (`Address`, `classID`, `Medical_info`, `Name`, `Pupil_ID`) VALUES
('Address 1', 1, 1, 'Student 1', 286),
('Address 2', 1, 0, 'Student 2', 287),
('Address 3', 1, 1, 'Student 3', 288),
('Address 4', 1, 0, 'Student 4', 289),
('Address 5', 2, 1, 'Student 5', 290),
('Address 6', 2, 0, 'Student 6', 291),
('Address 7', 2, 1, 'Student 7', 292),
('Address 8', 2, 0, 'Student 8', 293),
('Address 9', 3, 1, 'Student 9', 294),
('Address 10', 3, 0, 'Student 10', 295),
('Address 11', 3, 1, 'Student 11', 296),
('Address 12', 3, 0, 'Student 12', 297),
('Address 13', 4, 1, 'Student 13', 298),
('Address 14', 4, 0, 'Student 14', 299),
('Address 15', 4, 1, 'Student 15', 300),
('Address 16', 4, 0, 'Student 16', 301),
('Address 17', 5, 1, 'Student 17', 302),
('Address 18', 5, 0, 'Student 18', 303),
('Address 19', 5, 1, 'Student 19', 304),
('Address 20', 5, 0, 'Student 20', 305),
('Address 21', 6, 1, 'Student 21', 306),
('Address 22', 6, 0, 'Student 22', 307),
('Address 23', 6, 1, 'Student 23', 308),
('Address 24', 6, 0, 'Student 24', 309),
('Address 25', 7, 1, 'Student 25', 310),
('Address 26', 7, 0, 'Student 26', 311),
('Address 27', 7, 1, 'Student 27', 312),
('Address 28', 7, 0, 'Student 28', 313),
('Address 29', 8, 1, 'Student 29', 314),
('Address 30', 8, 0, 'Student 30', 315),
('Address 31', 8, 1, 'Student 31', 316),
('Address 32', 8, 0, 'Student 32', 317),
('Address 33', 9, 1, 'Student 33', 318),
('Address 34', 9, 0, 'Student 34', 319),
('Address 35', 9, 1, 'Student 35', 320),
('Address 36', 9, 0, 'Student 36', 321),
('Address 37', 10, 1, 'Student 37', 322),
('Address 38', 10, 0, 'Student 38', 323),
('Address 39', 10, 1, 'Student 39', 324),
('Address 40', 10, 0, 'Student 40', 325),
('Address 41', 11, 1, 'Student 41', 326),
('Address 42', 11, 0, 'Student 42', 327),
('Address 43', 11, 1, 'Student 43', 328),
('Address 44', 11, 0, 'Student 44', 329),
('Address 45', 12, 1, 'Student 45', 330),
('Address 46', 12, 0, 'Student 46', 331),
('Address 47', 12, 1, 'Student 47', 332),
('Address 48', 12, 0, 'Student 48', 333),
('Address 49', 13, 1, 'Student 49', 334),
('Address 50', 13, 0, 'Student 50', 335),
('Address 51', 13, 1, 'Student 51', 336),
('Address 52', 13, 0, 'Student 52', 337),
('Address 53', 14, 1, 'Student 53', 338),
('Address 54', 14, 0, 'Student 54', 339),
('Address 55', 14, 1, 'Student 55', 340),
('Address 56', 14, 0, 'Student 56', 341),
('Address 57', 15, 1, 'Student 57', 342),
('Address 58', 15, 0, 'Student 58', 343),
('Address 59', 15, 1, 'Student 59', 344),
('Address 60', 16, 0, 'Student 60', 345),
('Address 61', 16, 1, 'Student 61', 346),
('Address 62', 16, 0, 'Student 62', 347),
('Address 63', 17, 1, 'Student 63', 348),
('Address 64', 17, 0, 'Student 64', 349),
('Address 65', 17, 1, 'Student 65', 350),
('Address 66', 18, 0, 'Student 66', 351),
('Address 67', 18, 1, 'Student 67', 352),
('Address 68', 18, 0, 'Student 68', 353),
('Address 69', 19, 1, 'Student 69', 354),
('Address 70', 19, 0, 'Student 70', 355),
('Address 71', 19, 1, 'Student 71', 356),
('Address 72', 20, 0, 'Student 72', 357),
('Address 73', 20, 1, 'Student 73', 358),
('Address 74', 20, 0, 'Student 74', 359),
('Address 75', 21, 1, 'Student 75', 360),
('Address 76', 21, 0, 'Student 76', 361),
('Address 77', 21, 1, 'Student 77', 362),
('Address 78', 22, 0, 'Student 78', 363),
('Address 79', 22, 1, 'Student 79', 364),
('Address 80', 22, 0, 'Student 80', 365);

-- --------------------------------------------------------

--
-- Table structure for table `pupils_parents`
--

CREATE TABLE `pupils_parents` (
  `parent_id` int(11) NOT NULL,
  `pupil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pupils_parents`
--

INSERT INTO `pupils_parents` (`parent_id`, `pupil_id`) VALUES
(6, 286),
(7, 287),
(8, 288),
(9, 289),
(10, 290),
(11, 291),
(12, 292),
(13, 293),
(14, 294),
(15, 295),
(16, 296),
(17, 297),
(18, 298),
(19, 299),
(20, 300),
(21, 301),
(22, 302),
(23, 303),
(24, 304),
(25, 305),
(26, 306),
(27, 307),
(28, 308),
(29, 309),
(30, 310),
(31, 311),
(32, 312),
(33, 313),
(34, 314),
(35, 315),
(36, 316),
(37, 317),
(38, 318),
(39, 319),
(40, 320),
(41, 321),
(42, 322),
(43, 323),
(44, 324),
(45, 325),
(46, 326),
(47, 327),
(48, 328),
(49, 329),
(50, 330),
(51, 331),
(52, 332),
(53, 333),
(54, 334),
(55, 335),
(56, 336),
(57, 337),
(58, 338),
(59, 339),
(60, 340),
(61, 341),
(62, 342),
(63, 343),
(64, 344),
(65, 345),
(66, 346),
(67, 347),
(68, 348),
(69, 349),
(70, 350),
(71, 351),
(72, 352),
(73, 353),
(74, 354),
(75, 355),
(76, 356),
(77, 357),
(78, 358),
(79, 359),
(80, 360),
(81, 361),
(82, 362),
(83, 363),
(84, 364),
(85, 365);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `Address` text NOT NULL,
  `BackgroundCheck` text NOT NULL,
  `ClassID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Phone` int(11) NOT NULL,
  `Salary` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`Address`, `BackgroundCheck`, `ClassID`, `Name`, `Phone`, `Salary`, `TeacherID`) VALUES
('123 Main St', 'Yes', 1, 'John Doe', 0, 45000, 43),
('456 Oak St', 'No', 2, 'Jane Smith', 0, 47000, 44),
('789 Pine St', 'Yes', 3, 'Michael Johnson', 0, 44000, 45),
('321 Maple St', 'No', 4, 'Emily Brown', 0, 46000, 46),
('654 Birch St', 'Yes', 5, 'Robert Davis', 0, 43000, 47),
('987 Cedar St', 'No', 6, 'Sarah Wilson', 0, 48000, 48),
('741 Walnut St', 'Yes', 7, 'David Martinez', 0, 45500, 49),
('258 Spruce St', 'No', 8, 'Laura Anderson', 0, 46500, 50),
('369 Elm St', 'Yes', 9, 'James Thomas', 0, 47000, 51),
('159 Cherry St', 'No', 10, 'Jessica Hernandez', 0, 44000, 52),
('852 Chestnut St', 'Yes', 11, 'William Garcia', 0, 46000, 53),
('357 Aspen St', 'No', 12, 'Lisa Rodriguez', 0, 45000, 54),
('753 Sycamore St', 'Yes', 13, 'Matthew Clark', 0, 47500, 55),
('159 Beech St', 'No', 14, 'Stephanie Lewis', 0, 42000, 56),
('486 Redwood St', 'Yes', 15, 'Anthony Walker', 0, 45500, 57),
('795 Poplar St', 'No', 16, 'Megan Hall', 0, 46000, 58),
('246 Fir St', 'Yes', 17, 'Joshua Young', 0, 47000, 59),
('975 Palm St', 'No', 18, 'Kimberly Allen', 0, 44500, 60),
('183 Cypress St', 'Yes', 19, 'Ryan Scott', 0, 43000, 61),
('562 Bamboo St', 'No', 20, 'Sophia Adams', 0, 48000, 62),
('214 Olive St', 'Yes', 21, 'Daniel Baker', 0, 46000, 63),
('673 Cedar Ave', 'No', 1, 'Olivia Nelson', 0, 47000, 64),
('321 Hemlock St', 'Yes', 2, 'Andrew Carter', 0, 45000, 65),
('841 Alder St', 'No', 3, 'Brittany Perez', 0, 44000, 66),
('935 Willow St', 'Yes', 4, 'Christopher Hall', 0, 45500, 67),
('729 Hawthorn St', 'No', 5, 'Victoria Evans', 0, 46500, 68),
('813 Cottonwood St', 'Yes', 6, 'Justin King', 0, 47000, 69),
('375 Dogwood St', 'No', 7, 'Natalie Wright', 0, 43000, 70),
('496 Eucalyptus St', 'Yes', 8, 'Kevin Torres', 0, 48000, 71),
('682 Juniper St', 'No', 9, 'Rachel Flores', 0, 46000, 72),
('783 Magnolia St', 'Yes', 10, 'Eric Simmons', 0, 47000, 73),
('395 Lilac St', 'No', 11, 'Amanda Russell', 0, 44500, 74),
('207 Ash St', 'Yes', 12, 'Benjamin Bailey', 0, 42000, 75),
('558 Orchid St', 'No', 13, 'Lauren Murphy', 0, 45500, 76),
('349 Azalea St', 'Yes', 14, 'Steven Foster', 0, 46000, 77),
('612 Poppy St', 'No', 15, 'Catherine Simmons', 0, 47000, 78),
('478 Sunflower St', 'Yes', 16, 'Jonathan Reed', 0, 43000, 79),
('125 Marigold St', 'No', 17, 'Nicole Green', 0, 48000, 80),
('867 Rosewood St', 'Yes', 18, 'Thomas Bryant', 0, 46000, 81),
('349 Camellia St', 'No', 19, 'Elizabeth Jenkins', 0, 47000, 82);

-- --------------------------------------------------------

--
-- Table structure for table `teaching assistants`
--

CREATE TABLE `teaching assistants` (
  `Address` text NOT NULL,
  `AssistantID` int(11) NOT NULL,
  `ClassID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Phone` int(11) NOT NULL,
  `Salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teaching assistants`
--

INSERT INTO `teaching assistants` (`Address`, `AssistantID`, `ClassID`, `Name`, `Phone`, `Salary`) VALUES
('123 Elm Street', 1, 1, 'John Doe', 123, 2500),
('456 Oak Avenue', 2, 2, 'Jane Smith', 987, 2700),
('789 Pine Road', 3, 3, 'Mark Johnson', 555, 2600),
('101 Maple Lane', 4, 4, 'Emily Davis', 555, 2800),
('202 Birch Boulevard', 5, 5, 'Linda Wilson', 555, 3000),
('303 Cedar Drive', 6, 6, 'David Lee', 555, 2500),
('404 Willow Street', 7, 7, 'Sarah Brown', 555, 2700),
('505 Cherry Lane', 8, 8, 'Paul Green', 555, 2600),
('606 Ash Drive', 9, 9, 'Laura White', 555, 2800),
('707 Pine Street', 10, 10, 'Kevin Harris', 555, 3000),
('808 Cedar Avenue', 11, 11, 'Olivia Walker', 555, 2600),
('909 Oak Boulevard', 12, 12, 'Jake Hall', 555, 2700),
('1010 Maple Street', 13, 13, 'Sophia Clark', 555, 2500),
('1111 Birch Drive', 14, 14, 'Liam Adams', 555, 2800),
('1212 Willow Lane', 15, 15, 'Ava Miller', 555, 2900),
('1313 Pine Avenue', 16, 16, 'Ethan Scott', 555, 2600),
('1414 Cedar Street', 17, 17, 'Mia Young', 555, 2700),
('1515 Oak Road', 18, 18, 'James Lewis', 555, 2800),
('1616 Maple Lane', 19, 19, 'Charlotte Robinson', 555, 3000),
('1717 Birch Avenue', 20, 20, 'Lucas Walker', 555, 2900),
('1818 Pine Drive', 21, 21, 'Amelia Harris', 555, 2700),
('1919 Cedar Lane', 22, 22, 'Benjamin Carter', 555, 2800);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`classID`);

--
-- Indexes for table `dinner_money`
--
ALTER TABLE `dinner_money`
  ADD PRIMARY KEY (`DinnerMoneyID`),
  ADD KEY `Pupil_ID` (`Pupil_ID`);

--
-- Indexes for table `library_books`
--
ALTER TABLE `library_books`
  ADD PRIMARY KEY (`Book_ID`),
  ADD KEY `Pupil_ID` (`Pupil_ID`);

--
-- Indexes for table `parents_guardians`
--
ALTER TABLE `parents_guardians`
  ADD PRIMARY KEY (`ParentID`);

--
-- Indexes for table `pupils`
--
ALTER TABLE `pupils`
  ADD PRIMARY KEY (`Pupil_ID`),
  ADD KEY `classID` (`classID`);

--
-- Indexes for table `pupils_parents`
--
ALTER TABLE `pupils_parents`
  ADD KEY `parent_id` (`parent_id`,`pupil_id`),
  ADD KEY `pupil_id` (`pupil_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`TeacherID`),
  ADD KEY `ClassID` (`ClassID`);

--
-- Indexes for table `teaching assistants`
--
ALTER TABLE `teaching assistants`
  ADD PRIMARY KEY (`AssistantID`),
  ADD KEY `ClassID` (`ClassID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dinner_money`
--
ALTER TABLE `dinner_money`
  MODIFY `DinnerMoneyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `library_books`
--
ALTER TABLE `library_books`
  MODIFY `Book_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=402;

--
-- AUTO_INCREMENT for table `parents_guardians`
--
ALTER TABLE `parents_guardians`
  MODIFY `ParentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `pupils`
--
ALTER TABLE `pupils`
  MODIFY `Pupil_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=366;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `TeacherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `teaching assistants`
--
ALTER TABLE `teaching assistants`
  MODIFY `AssistantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dinner_money`
--
ALTER TABLE `dinner_money`
  ADD CONSTRAINT `dinner_money_ibfk_1` FOREIGN KEY (`Pupil_ID`) REFERENCES `pupils` (`Pupil_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `library_books`
--
ALTER TABLE `library_books`
  ADD CONSTRAINT `library_books_ibfk_1` FOREIGN KEY (`Pupil_ID`) REFERENCES `pupils` (`Pupil_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pupils`
--
ALTER TABLE `pupils`
  ADD CONSTRAINT `pupils_ibfk_1` FOREIGN KEY (`classID`) REFERENCES `classes` (`classID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pupils_parents`
--
ALTER TABLE `pupils_parents`
  ADD CONSTRAINT `pupils_parents_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `parents_guardians` (`ParentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pupils_parents_ibfk_2` FOREIGN KEY (`pupil_id`) REFERENCES `pupils` (`Pupil_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`ClassID`) REFERENCES `classes` (`classID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teaching assistants`
--
ALTER TABLE `teaching assistants`
  ADD CONSTRAINT `teaching assistants_ibfk_1` FOREIGN KEY (`ClassID`) REFERENCES `classes` (`classID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
