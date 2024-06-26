-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2024 at 08:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `children` (
  `ID` int(11) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  `dob` date NOT NULL,
  `stage` varchar(40) NOT NULL,
  `parent_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `groups` (
  `ID` int(11) NOT NULL,
  `parent_ID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `nr_Children` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `group_children` (
  `ID` int(11) NOT NULL,
  `child_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `images` (
  `ID` int(11) NOT NULL,
  `child_ID` int(11) NOT NULL,
  `Picture` varchar(200) NOT NULL,
  `timeline` tinyint(1) DEFAULT NULL,
  `Message` text NOT NULL,
  `uploadDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `notifications` (
  `ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `child_ID` int(11) NOT NULL,
  `message` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `time_issued` timestamp NOT NULL DEFAULT current_timestamp(),
  `readN` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `schedule_events` (
  `ID` int(11) NOT NULL,
  `child_ID` int(11) NOT NULL,
  `type` text NOT NULL,
  `message` text NOT NULL,
  `recurrence` enum('Daily','Weekly','Monthly','Yearly') NOT NULL,
  `time` text NOT NULL,
  `date` date DEFAULT NULL,
  `expiration` date DEFAULT NULL,
  `nextNotif` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `firstName` varchar(300) NOT NULL,
  `lastName` varchar(300) NOT NULL,
  `relationship` varchar(21) NOT NULL,
  `email` varchar(300) NOT NULL,
  `dob` date NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `children`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `groups`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `group_children`
  ADD PRIMARY KEY (`ID`,`child_ID`);

ALTER TABLE `images`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Owner` (`child_ID`);

ALTER TABLE `notifications`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `schedule_events`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_child_ID` (`child_ID`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);


ALTER TABLE `children`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `groups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `images`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `notifications`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `schedule_events`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `images`
  ADD CONSTRAINT `Owner` FOREIGN KEY (`child_ID`) REFERENCES `children` (`ID`);

ALTER TABLE `schedule_events`
  ADD CONSTRAINT `fk_child_ID` FOREIGN KEY (`child_ID`) REFERENCES `children` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
