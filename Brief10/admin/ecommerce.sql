-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2020 at 07:43 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `pannier`
--

CREATE TABLE `pannier` (
  `p_id` int(11) NOT NULL,
  `p_u_id` int(11) NOT NULL,
  `p_p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pannier`
--

INSERT INTO `pannier` (`p_id`, `p_u_id`, `p_p_id`) VALUES
(3, 41, 0),
(4, 41, 0),
(5, 41, 0),
(6, 42, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `date` date NOT NULL,
  `qte` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `date`, `qte`) VALUES
(4, 'Banane', 'Fruit / Desert', 3.95, '2020-05-11', 30),
(9, 'Pomme de terre', 'Légume', 8.9, '2020-05-28', 15),
(10, 'Choux', 'Légume', 4, '2020-05-28', 20),
(11, 'Pomme', 'Fruit', 6, '2020-05-28', 20),
(12, 'Avocat', 'Fruit', 12, '2020-05-28', 15),
(13, 'Citron', 'Fruit', 2.5, '2020-05-28', 68),
(14, 'Grenade', 'Fruit', 14, '2020-05-28', 14),
(15, 'Flocons d\'avoine', 'Healty', 18, '2020-05-29', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL COMMENT 'id de user',
  `username` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'nom de connexion',
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'nom que s''affiche',
  `groupeID` int(11) NOT NULL DEFAULT 0 COMMENT 'type de groupe de permission',
  `regStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'user approbation',
  `dateRegistre` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`, `email`, `fullname`, `groupeID`, `regStatus`, `dateRegistre`) VALUES
(40, 'youness', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'youness@gmail.com', 'youness srhayar', 0, 1, '2020-05-14'),
(41, 'taha', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'taha@safi.sfd', 'taha srhayar', 1, 0, '0000-00-00'),
(42, 'ahmed', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'ahmed@safi.com', 'ahmed safi', 0, 1, '2020-05-14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pannier`
--
ALTER TABLE `pannier`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `p_u_id` (`p_u_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pannier`
--
ALTER TABLE `pannier`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de user', AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pannier`
--
ALTER TABLE `pannier`
  ADD CONSTRAINT `pannier_ibfk_1` FOREIGN KEY (`p_u_id`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
