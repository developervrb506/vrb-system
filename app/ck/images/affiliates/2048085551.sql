-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 13, 2024 at 10:18 AM
-- Server version: 10.3.39-MariaDB
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inspin_insider`
--

-- --------------------------------------------------------

--
-- Table structure for table `streak_tool_filters`
--

CREATE TABLE `streak_tool_filters` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `streak_tool_filters`
--

INSERT INTO `streak_tool_filters` (`id`, `description`) VALUES
(0, 'No Filter'),
(1, 'Last 10 picks'),
(2, 'Last 25 picks'),
(3, 'Last 14 days'),
(4, 'Last 30 days'),
(5, 'Last 60 days'),
(6, 'Last 90 days'),
(7, '1 star plays'),
(8, '2 stars plays'),
(9, '3 stars plays'),
(10, '4 stars plays'),
(11, '5 stars plays'),
(12, '6 stars plays'),
(13, 'Whale Package');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `streak_tool_filters`
--
ALTER TABLE `streak_tool_filters`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `streak_tool_filters`
--
ALTER TABLE `streak_tool_filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
