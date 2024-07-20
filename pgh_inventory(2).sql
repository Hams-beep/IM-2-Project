-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2024 at 07:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pgh_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `itemID` int(11) NOT NULL,
  `itemName` varchar(50) NOT NULL,
  `unitOfMeasure` varchar(25) NOT NULL,
  `itemType` varchar(25) NOT NULL,
  `quantity` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `minStockLevel` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `itemStatus` enum('Selling','Not Selling') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemID`, `itemName`, `unitOfMeasure`, `itemType`, `quantity`, `minStockLevel`, `itemStatus`) VALUES
(34, 'Cola', 'Can', 'Soda', 86, 100, 'Selling'),
(35, 'Lemon-Lime Soda', 'Bottle', 'Soda', 6, 80, 'Selling'),
(36, 'Orange Juice', 'Carton', 'Juice', 200, 40, 'Selling'),
(37, 'Bottled Water', 'Bottle', 'Water', 1000, 200, 'Selling'),
(38, 'Red Wine', 'Bottle', 'Alcohol', 150, 30, 'Not Selling'),
(39, 'White Wine', 'Bottle', 'Alcohol', 150, 30, 'Selling'),
(40, 'Beer', 'Can', 'Alcohol', 600, 120, 'Selling'),
(41, 'Craft Beer', 'Bottle', 'Alcohol', 300, 60, 'Selling'),
(42, 'Whiskey', 'Bottle', 'Alcohol', 8, 20, 'Selling'),
(43, 'Vodka', 'Bottle', 'Alcohol', 100, 20, 'Selling'),
(44, 'Gin', 'Bottle', 'Alcohol', 80, 16, 'Selling'),
(45, 'Rum', 'Bottle', 'Alcohol', 80, 16, 'Selling'),
(46, 'Tequila', 'Bottle', 'Alcohol', 94, 16, 'Selling'),
(47, 'Energy Drink', 'Can', 'Energy Drink', 26, 80, 'Not Selling'),
(48, 'Iced Tea', 'Bottle', 'Tea', 341, 60, 'Selling'),
(49, 'Green Tea', 'Box', 'Tea', 2, 30, 'Selling'),
(50, 'Coffee Beans', 'Bag', 'Coffee', 100, 20, 'Not Selling'),
(51, 'Apple Juice', 'Bottle', 'Juice', 22, 40, 'Selling'),
(52, 'Grape Juice', 'Bottle', 'Juice', 200, 40, 'Selling'),
(53, 'Sparkling Water', 'Can', 'Water', 47, 80, 'Selling'),
(54, 'Coconut Water', 'Carton', 'Water', 160, 30, 'Selling'),
(55, 'Root Beer', 'Bottle', 'Soda', 250, 50, 'Selling'),
(56, 'Ginger Ale', 'Can', 'Soda', 250, 50, 'Selling'),
(57, 'Champagne', 'Bottle', 'Alcohol', 3, 20, 'Selling'),
(58, 'Sports Drink', 'Bottle', 'Sports Drink', 300, 60, 'Not Selling'),
(59, 'Lemonade', 'Carton', 'Juice', 200, 40, 'Selling'),
(60, 'Almond Milk', 'Carton', 'Milk Alternative', 150, 30, 'Selling'),
(61, 'Soy Milk', 'Carton', 'Milk Alternative', 150, 30, 'Not Selling'),
(62, 'Hot Chocolate Mix', 'Box', 'Powdered Drink', 100, 20, 'Selling'),
(63, 'Kombucha', 'Bottle', 'Fermented Drink', 120, 24, 'Selling');

-- --------------------------------------------------------

--
-- Table structure for table `item_changes`
--

CREATE TABLE `item_changes` (
  `historyID` int(11) NOT NULL,
  `dateModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `itemID` int(11) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `oldQuantity` int(11) UNSIGNED NOT NULL,
  `adjustedQuantity` int(11) DEFAULT NULL,
  `newQuantity` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_changes`
--

INSERT INTO `item_changes` (`historyID`, `dateModified`, `itemID`, `description`, `oldQuantity`, `adjustedQuantity`, `newQuantity`) VALUES
(7, '2024-07-20 02:08:17', 46, 'Purchase Request #7', 80, 14, 94),
(8, '2024-07-20 02:08:17', 54, 'Purchase Request #7', 150, 10, 160),
(9, '2024-07-20 05:18:06', 48, 'Purchase Request #8', 300, 41, 341),
(10, '2024-07-20 05:18:06', 34, 'Purchase Request #8', 81, 5, 86),
(11, '2024-07-20 05:18:06', 51, 'Purchase Request #8', 20, 2, 22);

-- --------------------------------------------------------

--
-- Table structure for table `item_costs`
--

CREATE TABLE `item_costs` (
  `itemID` int(11) NOT NULL,
  `supplierID` int(11) NOT NULL,
  `cost` decimal(11,2) UNSIGNED DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_costs`
--

INSERT INTO `item_costs` (`itemID`, `supplierID`, `cost`) VALUES
(34, 6, 1231.00),
(34, 10, 32.00),
(37, 10, 30.00),
(42, 4, 34.00),
(44, 5, 93.00),
(44, 6, 120.00),
(51, 4, 37.00),
(51, 9, 23.00),
(51, 10, 32.00),
(51, 11, 35.00),
(51, 13, 40.00),
(52, 8, 55.00),
(54, 11, 84.00);

-- --------------------------------------------------------

--
-- Table structure for table `pr_item`
--

CREATE TABLE `pr_item` (
  `PRID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `supplierID` int(11) DEFAULT NULL,
  `requestQuantity` int(11) NOT NULL DEFAULT 1,
  `estimatedCost` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pr_item`
--

INSERT INTO `pr_item` (`PRID`, `itemID`, `supplierID`, `requestQuantity`, `estimatedCost`) VALUES
(7, 46, NULL, 14, 0.00),
(7, 54, 11, 10, 840.00),
(8, 48, NULL, 41, 0.00),
(8, 34, 10, 5, 160.00),
(8, 51, 11, 2, 70.00),
(9, 35, NULL, 5, 0.00),
(9, 49, NULL, 5, 0.00),
(9, 34, NULL, 5, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_requests`
--

CREATE TABLE `purchase_requests` (
  `PRID` int(11) NOT NULL,
  `requestedBy` int(11) DEFAULT NULL,
  `PRDateRequested` date NOT NULL,
  `dateNeeded` date NOT NULL,
  `PRStatus` enum('pending','completed','partially fulfilled') NOT NULL DEFAULT 'pending',
  `estimatedCost` decimal(11,2) DEFAULT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_requests`
--

INSERT INTO `purchase_requests` (`PRID`, `requestedBy`, `PRDateRequested`, `dateNeeded`, `PRStatus`, `estimatedCost`, `reason`) VALUES
(7, 7, '2024-07-20', '2024-08-02', 'completed', 840.00, 'asdasd'),
(8, 7, '2024-07-20', '2024-07-31', 'completed', 230.00, 'fdfgfds'),
(9, 7, '2024-07-20', '2024-07-26', 'pending', 0.00, 'For Party');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplierID` int(11) NOT NULL,
  `companyName` varchar(25) NOT NULL,
  `address` varchar(25) NOT NULL,
  `contactNum` varchar(25) DEFAULT NULL,
  `supplierEmail` varchar(25) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplierID`, `companyName`, `address`, `contactNum`, `supplierEmail`, `status`) VALUES
(4, 'Manila Refreshments Corp.', 'Quezon City, Metro Manila', '+63 123-123-1414', '', 'active'),
(5, 'Pinoy Spirits Distributor', 'Makati City, Metro Manila', '0918-234-567', 'sales@pinoyspirits.ph', 'active'),
(6, 'Baguio Vineyard Selection', 'Baguio City, Benguet', NULL, 'info@baguiovineyard.com', 'active'),
(7, 'Cebu Craft Beer Collectiv', 'Cebu City, Cebu', '0919-345-678', NULL, 'active'),
(8, 'Davao Fruit Juices & Co.', 'Davao City, Davao del Sur', '', 'supply@davaojuices.com', 'inactive'),
(9, 'Fizzy Pop Pilipinas', 'Pasig City, Metro Manila', NULL, 'sales@fizzypopph.com', 'active'),
(10, 'Laguna Spring Water', 'Los Baños, Laguna', '0921-567-890', NULL, 'active'),
(11, 'Healthy Pinas Drinks', 'Tagaytay City, Cavite', '0922-678-901', 'orders@healthypinas.com', 'active'),
(12, 'Palawan Tropical Imports', 'Puerto Princesa, Palawan', NULL, 'imports@palawandef.com', 'active'),
(13, 'Batangas Coffee Supply Co', 'Lipa City, Batangas', '0923-789-012', 'wholesale@batangascoffee.', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `department` varchar(25) NOT NULL,
  `permissions` varchar(25) NOT NULL,
  `password` varchar(300) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `workStatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `fname`, `lname`, `department`, `permissions`, `password`, `email`, `created_at`, `workStatus`) VALUES
(6, 'Sharly', 'Barago', 'Dept', 'Admin', '$2y$10$fA0E5d1NEF8.djp0M3ZrA.PGvIO3blYjkUfcGcDEroZTFIAXiSOAS', 'sharly@gmail.com', '2024-07-16 07:39:52', 1),
(7, 'Hasm', 'Agunod', 'Dept', 'Admin', '$2y$10$f85/GEibezVjW/ChW5xHUe5iS8QsHGKnIyfp8YdFGiN9kqB4Fxgui', 'hasm@gmail.com', '2024-07-20 05:39:46', 1),
(8, 'Eddy', 'Ybanez', 'Dept', 'IT', '$2y$10$00.QApNmLauZu4E8eOZ3xesDUP7kc87ndauHsVXRbnDw9OctCqiIi', 'eddy@gmail.com', '2024-07-18 08:18:42', 1),
(10, 'Marc', 'Laroa', 'Dept', 'Admin', '$2y$10$Ls6T25RpnkUi4qj.cgNpSOHdttCJCkdiQMKn5iq7Cy1xVOx9/XoXS', 'marc@gmail.com', '2024-07-18 08:22:49', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `item_changes`
--
ALTER TABLE `item_changes`
  ADD PRIMARY KEY (`historyID`),
  ADD KEY `Item` (`itemID`);

--
-- Indexes for table `item_costs`
--
ALTER TABLE `item_costs`
  ADD UNIQUE KEY `cost` (`itemID`,`supplierID`) USING BTREE,
  ADD KEY `item_costs_ibfk_2` (`supplierID`);

--
-- Indexes for table `pr_item`
--
ALTER TABLE `pr_item`
  ADD UNIQUE KEY `PRID_ITEM` (`PRID`,`itemID`,`supplierID`) USING BTREE,
  ADD KEY `itemID` (`itemID`),
  ADD KEY `supplierID` (`supplierID`);

--
-- Indexes for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD PRIMARY KEY (`PRID`),
  ADD KEY `userid` (`requestedBy`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplierID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `item_changes`
--
ALTER TABLE `item_changes`
  MODIFY `historyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  MODIFY `PRID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item_costs`
--
ALTER TABLE `item_costs`
  ADD CONSTRAINT `item_costs_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `item_costs_ibfk_2` FOREIGN KEY (`supplierID`) REFERENCES `supplier` (`supplierID`) ON UPDATE CASCADE;

--
-- Constraints for table `pr_item`
--
ALTER TABLE `pr_item`
  ADD CONSTRAINT `pr_item_ibfk_2` FOREIGN KEY (`PRID`) REFERENCES `purchase_requests` (`PRID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pr_item_ibfk_4` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pr_item_ibfk_5` FOREIGN KEY (`supplierID`) REFERENCES `supplier` (`supplierID`) ON UPDATE CASCADE;

--
-- Constraints for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD CONSTRAINT `purchase_requests_ibfk_1` FOREIGN KEY (`requestedBy`) REFERENCES `users` (`userID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
