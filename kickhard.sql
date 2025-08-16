-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 16, 2025 at 09:35 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kickhard`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(14, 'test', 'test@gmail.com', '$2y$10$wtPt1JlEvY/w55P7ITpwWOhrw0o62Or1DXfjOMcdYgyhZesomCMZK', '2025-08-13 12:20:58'),
(15, 'one', 'one@gmail.com', '$2y$10$zkHy88hL/8XGXVa5l473Ze04Il9HOZnSToUMfS1h0MfCpVEGBzxsC', '2025-08-14 06:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `shoes`
--

CREATE TABLE `shoes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `size` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shoes`
--

INSERT INTO `shoes` (`id`, `name`, `brand`, `size`, `price`, `image`, `type`) VALUES
(13, 'Vans Low Milk Tea', 'VANS', 42, 200.00, '1755093087_Premium-Authentic-Shoe.png', 1),
(14, 'Premium Old Skool 36 FM Shoe', 'VANS', 42, 120.50, '1755093644_Premium-Old-Skool-36-FM-Shoe.png', 1),
(15, 'Adizero Adios 9 Running Shoes', 'Adizero', 41, 189.00, '1755093764_Adizero_Adios_9_Running_Shoes_Turquoise_JH5243_01_00_standard.png', 0),
(16, 'Ultraboost 5 Shoes Price', 'ADDIDAS', 42, 259.00, '1755093839_Ultraboost_5_Shoes_Black_JH9633_01_standard.png', 0),
(17, 'ULTRABOOST 1.0 SHOES', 'ADDIDAS', 41, 207.00, '1755093909_Ultraboost_5_Shoes_Black_JH9633_01_standard.png', 0),
(18, 'Taekwondo Lace Shoes', 'ADDIDAS', 40, 96.00, '1755093982_Taekwondo_Lace_Shoes_Red_JS1460_01_00_standard.png', 0),
(19, 'Nike Air Force 1 \'07 LV8', 'NIKE', 42, 189.00, '1755094053_AIR+FORCE+1+\'07+LV8.png', 1),
(20, 'Nike Dunk Low Retro', 'NIKE', 40, 165.00, '1755094100_NIKE+DUNK+LOW+RETRO.png', 1),
(21, 'Nike P-6000', 'NIKE', 41, 159.00, '1755094766_NIKE+P-6000.png', 1),
(22, 'Air Jordan MVP 92', 'NIKE', 42, 219.00, '1755094840_JORDAN+MVP+92.png', 1),
(23, 'Chuck Taylor All Star Lift', 'CONVERSE', 38, 87.00, '1755094958_0883-CONA14937C005007-1.png', 1),
(24, 'Chuck Taylor All Star Lift', 'CONVERSE', 41, 119.00, '1755095003_0883-CON560251C000011-1.png', 1),
(25, 'Chuck Taylor All Star Lift', 'CONVERSE', 42, 129.00, '1755095053_0883-CON560845C005008-1.png', 1),
(26, 'Chuck Taylor All Star Lift Double Stack', 'CONVERSE', 42, 129.00, '1755095111_0883-CONA12975C005008-1.png', 1),
(27, 'Chuck Taylor All Star Lift Double Stack', 'CONVERSE', 42, 119.00, '1755095468_0883-CONA15490C005011-1.png', 1),
(28, 'Chuck Taylor All Star', 'CONVERSE', 42, 89.00, '1755095538_0883-CONM9622C000003-1.png', 1),
(29, 'Converse Sport Casual', 'CONVERSE', 39, 79.00, '1755095613_0883-CONA10548CGRE009-1.png', 0),
(30, 'Converse Chuck 70 De Luxe Heel Shoes - Egret (A05348C)', 'CONVERSE', 36, 102.00, '1755095709_s-l1600.png', 1),
(31, 'Inhale Sneakers Unisex', 'PUMA', 42, 179.00, '1755095816_Inhale-Sneakers-Unisex.png', 0),
(32, 'Majesty Sneakers Unisex', 'PUMA', 40, 149.00, '1755095879_Majesty-Sneakers-Unisex.png', 1),
(33, 'Mostro OG Sneakers Unisex', 'PUMA', 42, 189.00, '1755095938_Mostro-OG-Sneakers-Unisex.png', 0),
(34, 'Serve Pro Lite Trainers', 'PUMA', 38, 69.00, '1755096010_Serve-Pro-Lite-Trainers.png', 1),
(35, 'Rebound V6 Low Sneakers', 'PUMA', 42, 76.00, '1755096061_Rebound-V6-Low-Sneakers.png', 1),
(36, 'A$AP ROCKY x PUMA Inhale Sneakers Unisex', 'PUMA', 42, 186.00, '1755096134_A$AP-ROCKY-x-PUMA-Inhale-Sneakers-Unisex.png', 0),
(37, 'Bella Classic Sneakers Women', 'PUMA', 36, 129.00, '1755096198_Bella-Classic-Sneakers-Women.png', 1),
(38, 'Cilia Mode Women\'s Trainers', 'PUMA', 36, 89.00, '1755096261_Cilia-Mode-Women\'s-Trainers.png', 0),
(39, 'Mostro Perforated Sneakers Unisex', 'PUMA', 42, 189.00, '1755096322_Mostro-Perforated-Sneakers-Unisex.png', 0),
(40, 'FENTY x PUMA Avanti LS Sneakers Unisex', 'PUMA', 40, 179.00, '1755097150_FENTY-x-PUMA-Avanti-LS-Sneakers-Unisex.png', 0),
(41, 'Speedcat TTF Sneakers Unisex', 'PUMA', 42, 199.00, '1755097306_Speedcat-TTF-Sneakers-Unisex.png', 1),
(42, 'Men\'s Club C Golf Shoes', 'REEBOK', 41, 100.00, '1755097448_JPG-100236000_SLC_eCom.png', 1),
(43, 'Men\'s Club C Golf Shoes', 'REEBOK', 42, 130.00, '1755097520_100229538_SLC_eCom.png', 1),
(44, 'Women\'s Club C Grounds UK Shoes', 'REEBOK', 36, 80.00, '1755097599_JPG-100229527_SLC_eCom.png', 1),
(45, 'Men\'s Gucci Re-Web sneaker', 'GUCCI', 42, 1750.00, '1755097764_831661_AAEX3_3343_001_100_0000_Light-Mens-Gucci-Re-Web-sneaker.png', 1),
(46, 'Men\'s Gucci Re-Motion sneaker', 'GUCCI', 41, 1500.00, '1755097814_832461_AAEW3_6141_001_100_0000_Light-Mens-Gucci-Re-Motion-sneaker.png', 1),
(47, 'Men\'s G75 sneaker', 'GUCCI', 42, 1400.00, '1755097864_840330_AAE80_1066_001_100_0000_Light-Mens-G75-sneaker.png', 1),
(48, 'Women\'s G75 trainer', 'GUCCI', 36, 1400.00, '1755097952_812656_AAEGA_2741_001_100_0000_Light-Womens-G75-trainer.png', 1),
(49, 'Women\'s Gucci Re-Motion sneaker', 'GUCCI', 38, 1600.00, '1755098002_832918_AAEZM_3754_001_100_0000_Light-Womens-Gucci-Re-Motion-sneaker.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `shoes`
--
ALTER TABLE `shoes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `shoes`
--
ALTER TABLE `shoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
