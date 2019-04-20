-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2018 at 03:38 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `ColorID` int(11) NOT NULL,
  `Color` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`ColorID`, `Color`) VALUES
(3, 'Black'),
(2, 'Blue'),
(4, 'NA'),
(1, 'Red');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `InvID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `Color` varchar(150) NOT NULL,
  `Size` varchar(150) NOT NULL,
  `InStockQty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`InvID`, `ItemID`, `Color`, `Size`, `InStockQty`) VALUES
(1, 9, 'NA', 'NA', 10),
(2, 8, 'NA', 'NA', 10),
(3, 7, 'NA', 'NA', 10),
(4, 1, 'Black', 'One Size Fits All', 10),
(5, 1, 'Blue', 'One Size Fits All', 10),
(6, 1, 'Red', 'One Size Fits All', 10),
(7, 2, 'NA', 'One Size Fits All', 10),
(8, 3, 'NA', 'One Size Fits All', 10),
(9, 5, 'NA', 'NA', 10),
(10, 6, 'NA', 'NA', 10),
(11, 4, 'NA', 'S', 10),
(12, 4, 'NA', 'M', 10),
(13, 4, 'NA', 'L', 10),
(14, 4, 'NA', 'XL', 10);

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `SizeID` int(11) NOT NULL,
  `Size` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`SizeID`, `Size`) VALUES
(4, 'L'),
(3, 'M'),
(6, 'NA'),
(1, 'One Size Fits All'),
(2, 'S'),
(5, 'XL');

-- --------------------------------------------------------

--
-- Table structure for table `store_categories`
--

CREATE TABLE `store_categories` (
  `id` int(11) NOT NULL,
  `cat_title` varchar(50) DEFAULT NULL,
  `cat_desc` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_categories`
--

INSERT INTO `store_categories` (`id`, `cat_title`, `cat_desc`) VALUES
(1, 'Hats', 'Funky hats in all shapes and sizes!'),
(2, 'Shirts', 'From t-shirts to sweatshirts to polo shirts and beyond'),
(3, 'Books', 'Paperback, hardback, books for school or play ');

-- --------------------------------------------------------

--
-- Table structure for table `store_items`
--

CREATE TABLE `store_items` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `item_title` varchar(75) DEFAULT NULL,
  `item_price` float DEFAULT NULL,
  `item_desc` text,
  `item_image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_items`
--

INSERT INTO `store_items` (`id`, `cat_id`, `item_title`, `item_price`, `item_desc`, `item_image`) VALUES
(1, 1, 'Baseball Hat', 12, 'Fancy, low-profile baseball hat.', 'Images/baseballhat.jpg'),
(2, 1, 'Cowboy hat', 52, '10 gallon variety', 'Images/cowboyhat.jpg'),
(3, 1, 'Top Hat', 102, 'good for costumes', 'Images/tophat.jpg'),
(4, 2, 'Short-Sleeved T-Shirt', 12, '100% cotton, pre-shrunk', 'Images/sstshirt.jpg'),
(5, 2, 'Long-Sleeved T-Shirt', 15, 'Just like the short-sleeved shirt, with longer sleeves', 'Images/lstshirt.gif'),
(6, 2, 'Sweatshirt', 22, 'Heavy and warm', 'Images/sweatshirt.jpg'),
(7, 3, 'Jane\\\'s Self-Help Book ', 12, 'Jane gives advice', 'Images/selfhelpbook.gif'),
(8, 3, 'Generic Academic Book', 35, 'Some required reading for school, will put you to sleep.', 'Images/boringbook.jpg'),
(9, 3, 'Chicago Manual of Style', 9.99, 'Good for copywriters', 'Images/chicagostyle.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `store_item_color`
--

CREATE TABLE `store_item_color` (
  `item_id` int(11) NOT NULL,
  `item_color` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_item_color`
--

INSERT INTO `store_item_color` (`item_id`, `item_color`) VALUES
(1, 'red'),
(1, 'black'),
(1, 'blue');

-- --------------------------------------------------------

--
-- Table structure for table `store_item_size`
--

CREATE TABLE `store_item_size` (
  `item_id` int(11) NOT NULL,
  `item_size` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_item_size`
--

INSERT INTO `store_item_size` (`item_id`, `item_size`) VALUES
(1, 'One Size Fits All'),
(2, 'One Size Fits All'),
(3, 'One Size Fits All'),
(4, 'S'),
(4, 'M'),
(4, 'L'),
(4, 'XL');

-- --------------------------------------------------------

--
-- Table structure for table `store_orders`
--

CREATE TABLE `store_orders` (
  `id` int(11) NOT NULL,
  `order_date` datetime DEFAULT NULL,
  `order_name` varchar(100) DEFAULT NULL,
  `order_address` varchar(255) DEFAULT NULL,
  `order_city` varchar(50) DEFAULT NULL,
  `order_state` char(2) DEFAULT NULL,
  `order_zip` varchar(10) DEFAULT NULL,
  `order_tel` varchar(25) DEFAULT NULL,
  `order_email` varchar(100) DEFAULT NULL,
  `item_total` float DEFAULT NULL,
  `shipping_total` float DEFAULT NULL,
  `[authorization]` varchar(50) DEFAULT NULL,
  `status` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `store_orders_items`
--

CREATE TABLE `store_orders_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `sel_item_id` int(11) DEFAULT NULL,
  `sel_item_qty` smallint(6) DEFAULT NULL,
  `sel_item_size` varchar(25) DEFAULT NULL,
  `sel_item_color` varchar(25) DEFAULT NULL,
  `sel_item_price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`ColorID`),
  ADD UNIQUE KEY `Color` (`Color`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`InvID`),
  ADD KEY `Color` (`Color`),
  ADD KEY `Size` (`Size`),
  ADD KEY `ItemID` (`ItemID`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`SizeID`),
  ADD UNIQUE KEY `Size` (`Size`);

--
-- Indexes for table `store_categories`
--
ALTER TABLE `store_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_items`
--
ALTER TABLE `store_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_orders`
--
ALTER TABLE `store_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_orders_items`
--
ALTER TABLE `store_orders_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `ColorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `InvID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `SizeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `store_categories`
--
ALTER TABLE `store_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `store_items`
--
ALTER TABLE `store_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `store_orders`
--
ALTER TABLE `store_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_orders_items`
--
ALTER TABLE `store_orders_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `Color` FOREIGN KEY (`Color`) REFERENCES `colors` (`Color`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ItemID` FOREIGN KEY (`ItemID`) REFERENCES `store_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Size` FOREIGN KEY (`Size`) REFERENCES `sizes` (`Size`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
