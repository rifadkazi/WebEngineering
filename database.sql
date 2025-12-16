-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `agricare_db`
--

-- --------------------------------------------------------

--
-- 1. Table structure for table `users` (Login & Signup)
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 2. Table structure for table `sensor_data` (IoT Dashboard)
--

CREATE TABLE IF NOT EXISTS `sensor_data` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `temperature` float NOT NULL,
  `humidity` float NOT NULL,
  `soil_moisture` int(11) NOT NULL,
  `reading_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 3. Table structure for table `crop_budgets` (Calculator History)
--

CREATE TABLE IF NOT EXISTS `crop_budgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `budget_name` varchar(100) DEFAULT NULL,
  `acreage` float DEFAULT NULL,
  `seed_cost` float DEFAULT NULL,
  `fertilizer_cost` float DEFAULT NULL,
  `pesticide_cost` float DEFAULT NULL,
  `labor_cost` float DEFAULT NULL,
  `other_cost` float DEFAULT NULL,
  `expected_yield` float DEFAULT NULL,
  `price_per_bushel` float DEFAULT NULL,
  `total_cost` float DEFAULT NULL,
  `total_revenue` float DEFAULT NULL,
  `total_profit` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 4. Table structure for table `market_listings` (Marketplace)
--

CREATE TABLE IF NOT EXISTS `market_listings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `farmer_name` varchar(100) DEFAULT NULL,
  `crop_name` varchar(100) DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `price` varchar(50) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping dummy data for table `market_listings`
-- (So your marketplace isn't empty on the first run)
--

INSERT INTO `market_listings` (`farmer_name`, `crop_name`, `quantity`, `price`, `contact`) VALUES
('Rahim Uddin', 'Rice (Basmati)', '500 kg', '1200', '01711223344'),
('Karim Mia', 'Potato', '1 Ton', '180', '01999887766'),
('Anita Roy', 'Wheat', '200 kg', '320', '01888776655');

COMMIT;