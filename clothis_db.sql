-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2024 at 11:52 PM
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
-- Database: `clothis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(6, 6, 3, 6, '2024-02-26 01:37:32'),
(7, 6, 2, 2, '2024-02-26 01:49:55');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`) VALUES
(1, 'ملابس'),
(2, 'أثاث'),
(3, 'فساتين'),
(4, 'ملابس رجالية'),
(5, 'ملابس نسائية');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` mediumtext NOT NULL,
  `description` longtext DEFAULT NULL,
  `imagepath` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `imagepath`, `price`, `user_id`, `date`, `category_id`) VALUES
(2, 'غرفة نوم راقية', 'غرفة نوم راقية', 'images/bedrooms.jpg', 1000.00, 6, '0000-00-00', 2),
(3, 'غرفة جلوس عصرية وحديثة', 'غرفة نوم عصرية وحديثة لمنزل أجمل', 'images/bg2.jpg', 500.00, 6, '0000-00-00', 2),
(4, 'ملابس جديدة', 'ملابس جديدة ونظيفة', 'images/clothes2.png', 200.00, 6, '2024-02-25', 1),
(8, 'ملابس جديدة', 'ملابس حديثة وجديدة', 'images/clo2.png', 200.00, 6, '2024-02-25', 1),
(9, 'ملابس رجالية أنيقة', 'ملابس رجالية أنيقة كما في الصورة', 'images/uploads/clothes3.png', 300.00, 6, '2024-02-26', 4),
(10, 'كنب مجلس', 'كنب مجلس عربي جديد', 'images/uploads/post-2.jpg', 500.00, 8, '2024-02-26', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_path` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_path`, `phone`) VALUES
(6, 'بهز عباس اسماعيل رونه', 'bahzabbasismaeel@gmail.com', '$2y$10$WaJz.GqYF61lPPoGQzvrX.BnETFYb2W1Dx0w8RvGLLfFQWp0ho.Nu', NULL, NULL),
(7, 'Bahz Abbas', 'bahzabbasismail@gmail.com', '$2y$10$iI.bEDWcYxHubjmEvT0cH.sTbw3Ez1gLKqCaDlLlfqQpr74E1pkle', NULL, '017162150'),
(8, 'Bahz Abbas', 'bahz@gmail.com', '$2y$10$XypXIivjIOMMaQ5o4/OUFe0qDvxhhhf59udSLWd/Hmukr1DyZq/am', NULL, '017162150');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
