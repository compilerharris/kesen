-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2024 at 09:16 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kesen`
--

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `name`, `status`, `created_by`, `created_date`) VALUES
(1, 'Hindi', 1, 1, '2017-10-25 16:05:04'),
(2, 'Marathi', 1, 1, '2017-10-25 16:05:17'),
(3, 'Gujarati', 1, 1, '2017-10-25 16:05:24'),
(4, 'Tamil', 1, 1, '2017-10-25 16:05:29'),
(5, 'Telugu', 1, 1, '2017-10-25 16:05:35'),
(6, 'Malayalam', 1, 1, '2017-10-25 16:06:14'),
(7, 'Kannada', 1, 1, '2017-10-25 16:06:27'),
(8, 'Oriya', 1, 1, '2017-10-25 16:06:54'),
(9, 'Urdu', 1, 1, '2017-10-25 16:07:05'),
(10, 'Assamese', 1, 1, '2017-10-25 16:07:34'),
(11, 'Punjabi', 1, 1, '2017-10-25 16:07:50'),
(12, 'Bengali', 1, 1, '2017-10-25 16:07:58'),
(13, 'French', 1, 1, '2017-10-25 16:12:22'),
(14, 'Spanish', 1, 1, '2017-10-25 16:12:51'),
(15, 'German', 1, 1, '2017-10-25 16:13:22'),
(16, 'Chinese', 1, 1, '2017-10-25 16:13:40'),
(17, 'Japanese', 1, 1, '2017-10-25 16:14:55'),
(18, 'English', 1, 7, '2017-10-26 16:37:21'),
(19, 'Manipuri', 1, 7, '2017-10-27 11:59:28'),
(20, 'Nepali', 1, 7, '2017-10-27 11:59:42'),
(21, 'Mizo', 1, 7, '2017-10-27 12:00:32'),
(22, 'Konkani', 1, 7, '2017-11-04 15:29:10'),
(23, 'Sanskrit', 1, 7, '2017-11-04 15:29:21'),
(24, 'Maithili', 1, 7, '2017-11-04 15:29:34'),
(25, 'Sri Lankan', 1, 7, '2017-11-22 12:18:00'),
(26, 'Sinhalese', 1, 7, '2017-11-22 12:18:20'),
(27, 'Russian', 1, 7, '2017-11-29 16:35:35'),
(33, 'Bangla', 1, 2, '2018-04-16 11:35:43'),
(29, 'Italian', 1, 7, '2018-03-16 14:31:43'),
(30, 'Flemish', 1, 7, '2018-03-16 14:31:58'),
(31, 'Portugeese', 1, 7, '2018-03-16 14:32:19'),
(32, 'Swedish', 1, 7, '2018-03-16 14:32:29'),
(34, 'Haryanvi', 1, 2, '2018-05-15 12:19:57'),
(35, 'Arabic', 1, 2, '2018-06-12 10:57:17'),
(36, 'Belgium', 1, 37, '2019-03-07 14:30:09'),
(37, 'Deutch', 1, 37, '2019-03-08 14:14:15'),
(38, 'Kashmiri', 1, 37, '2019-05-09 12:37:07'),
(39, 'Rajasthani', 1, 37, '2019-05-09 12:41:30'),
(40, 'Bhojpuri', 1, 37, '2019-05-09 12:41:48'),
(41, 'Konkani', 1, 37, '2019-05-09 12:42:07'),
(42, 'Thai', 1, 37, '2019-05-09 12:42:18'),
(43, 'Burmese', 1, 61, '2020-03-17 19:53:49'),
(44, 'Chhattisgarhi', 1, 37, '2020-04-19 14:35:51'),
(45, 'Marwadi', 1, 37, '2020-04-19 14:37:47'),
(46, 'Bulgarian', 1, 61, '2021-02-03 15:16:41'),
(47, 'Romanian', 1, 61, '2021-05-04 15:21:17'),
(48, 'Croatian', 1, 61, '2021-05-04 15:21:51'),
(49, 'Korean', 1, 61, '2022-04-21 13:31:53'),
(50, 'Ukrainian', 1, 61, '2022-04-27 18:14:26'),
(51, 'Mandarin Chinese (Ta', 1, 61, '2022-04-27 18:21:58'),
(52, 'Polish', 1, 37, '2022-05-14 12:30:46'),
(53, 'Slovak', 1, 37, '2022-07-29 15:17:41'),
(54, 'Czech', 1, 37, '2022-07-29 15:18:07'),
(55, 'Hungarian', 1, 37, '2022-07-29 15:20:01'),
(56, 'Vietnamese', 1, 61, '2022-09-05 14:35:53'),
(57, 'FARSI', 1, 61, '2022-09-12 17:30:35'),
(58, 'Turkish', 1, 61, '2022-09-12 17:30:53'),
(59, 'Taiwanese', 1, 61, '2022-10-17 14:29:47'),
(60, 'Khasi', 1, 76, '2022-11-15 18:43:01'),
(61, 'Danish', 1, 37, '2022-11-24 17:04:38'),
(62, 'Dutch', 1, 76, '2023-07-22 17:40:01'),
(63, 'Swiss', 1, 76, '2023-11-22 10:43:48'),
(64, 'Greek', 1, 76, '2024-01-09 14:58:07'),
(65, 'Estonian', 1, 76, '2024-01-09 14:58:46'),
(66, 'Finnish', 1, 76, '2024-01-09 14:59:05'),
(67, 'Irish', 1, 76, '2024-01-09 14:59:41'),
(68, 'Latvian', 1, 76, '2024-01-09 15:00:08'),
(69, ' Lithuanian', 1, 76, '2024-01-09 15:00:42'),
(70, '  Luxembourgish', 1, 76, '2024-01-09 15:01:30'),
(71, 'Maltese', 1, 76, '2024-01-09 15:01:43'),
(72, 'Slovenian', 1, 76, '2024-01-09 15:02:40'),
(73, 'Icelandic', 1, 76, '2024-01-09 15:03:09'),
(74, 'Norwegian', 1, 76, '2024-01-09 15:04:12'),
(75, 'Bengali(Bangladesh)', 1, 76, '2024-07-22 13:13:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
