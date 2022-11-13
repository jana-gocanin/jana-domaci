-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2022 at 12:05 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `azil`
--

-- --------------------------------------------------------

--
-- Table structure for table `psi`
--

CREATE TABLE `psi` (
  `id` int(11) NOT NULL,
  `ime` varchar(50) DEFAULT NULL,
  `godine` double DEFAULT NULL,
  `boja` varchar(30) DEFAULT NULL,
  `tezina` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `psi`
--

INSERT INTO `psi` (`id`, `ime`, `godine`, `boja`, `tezina`) VALUES
(1, 'Kiki', 2.5, 'crna', 5),
(2, 'Bella', 6, 'crno-bela', 24),
(3, 'Bleki', 5, 'Bela', 20);

-- --------------------------------------------------------

--
-- Table structure for table `udomitelji`
--

CREATE TABLE `udomitelji` (
  `id` int(11) NOT NULL,
  `ime` varchar(30) DEFAULT NULL,
  `prezime` varchar(30) DEFAULT NULL,
  `datum_rodjenja` date DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `udomitelji`
--

INSERT INTO `udomitelji` (`id`, `ime`, `prezime`, `datum_rodjenja`, `email`) VALUES
(1, 'Milan', 'Milanovic', '2022-04-04', 'milan@gmail.com'),
(2, 'Lena', 'Bogdanovic', '2021-12-20', 'lena@gmail.com'),
(3, 'Sara', 'Nikolic', '1997-02-11', 'saranik@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `ugovori`
--

CREATE TABLE `ugovori` (
  `id` int(11) NOT NULL,
  `potpisano` tinyint(1) NOT NULL DEFAULT 0,
  `datum_potpisa` timestamp NOT NULL DEFAULT current_timestamp(),
  `pas_id` int(11) NOT NULL,
  `udomitelj_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ugovori`
--

INSERT INTO `ugovori` (`id`, `potpisano`, `datum_potpisa`, `pas_id`, `udomitelj_id`) VALUES
(1, 1, '2022-11-06 21:04:49', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`) VALUES
(1, 'jana', 'jana');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `psi`
--
ALTER TABLE `psi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `udomitelji`
--
ALTER TABLE `udomitelji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ugovori`
--
ALTER TABLE `ugovori`
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
-- AUTO_INCREMENT for table `psi`
--
ALTER TABLE `psi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `udomitelji`
--
ALTER TABLE `udomitelji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ugovori`
--
ALTER TABLE `ugovori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
