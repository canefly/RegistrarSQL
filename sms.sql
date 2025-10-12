-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2025 at 04:22 PM
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
-- Database: `admin_dashboard`
--
CREATE DATABASE IF NOT EXISTS `admin_dashboard` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `admin_dashboard`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `contact_add` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `username`, `lastname`, `gender`, `contact_add`, `address`, `password`) VALUES
(0, 'jona', 'maunes', 'Female', '09222222222', 'sanjose', 'jona123'),
(0, 'admin', 'user', 'Male', 'n/a', 'alicia', 'admin123'),
(0, 'marclloyd', 'de leon', 'Male', '09111111111', '23hfjhsdufhuiwfw', 'try123');

-- --------------------------------------------------------

--
-- Table structure for table `customer_user`
--

CREATE TABLE `customer_user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` enum('Male','Female','Other','') NOT NULL,
  `contact_add` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_user`
--

INSERT INTO `customer_user` (`id`, `username`, `lastname`, `gender`, `contact_add`, `address`, `password`) VALUES
(1, 'hugo', 'salam', 'Male', '09921731121', 'alicia', 'hugowilab'),
(2, 'marc', 'deleon', 'Male', '0911111111111', 'balintawak', 'marcwilab'),
(3, 'user', 'user', 'Male', 'n/a', 'alicia', 'user123');

-- --------------------------------------------------------

--
-- Table structure for table `outgoing`
--

CREATE TABLE `outgoing` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  `slot_number` int(11) NOT NULL,
  `vehicle_company` varchar(50) DEFAULT NULL,
  `parking_attendant` varchar(25) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `vehicle_type` varchar(25) NOT NULL,
  `customer_type` enum('VIP','Member','Guest') NOT NULL,
  `time_in` varchar(50) NOT NULL,
  `date_in` date NOT NULL,
  `time_out` varchar(50) NOT NULL,
  `fee` double NOT NULL,
  `cash` int(11) NOT NULL,
  `change_due` double NOT NULL,
  `date_out` date NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outgoing`
--

INSERT INTO `outgoing` (`id`, `fullname`, `plate_number`, `slot_number`, `vehicle_company`, `parking_attendant`, `contact_number`, `vehicle_type`, `customer_type`, `time_in`, `date_in`, `time_out`, `fee`, `cash`, `change_due`, `date_out`, `status`) VALUES
(61, 'Lloyd', 'ytw345', 2, 'ford', 'hugo', 'n/a', 'side car', 'Guest', '08:49 AM', '2024-11-23', '08:51 AM', 3.34, 4, 0.66, '2024-11-23', 'Outgoing'),
(65, 'joy', 'bmw123', 1, 'ford', 'hugo', 'n/a', 'side car', 'Member', '03:15 PM', '2024-11-23', '03:19 PM', 0, 0, 0, '2024-11-23', 'Outgoing'),
(69, 'zy', 'ghs123', 2, 'suzuki', 'hugo', 'na', 'Four wheels', 'VIP', '05:18 PM', '2024-11-25', '05:19 PM', 0, 0, 0, '2024-11-25', 'Outgoing'),
(70, 'she', 'bmw123', 2, 'ford', 'attendant', 'n/a', 'Four wheels', 'VIP', '01:37 PM', '2024-11-27', '01:37 PM', 0, 0, 0, '2024-11-27', 'Outgoing'),
(71, 'kevin', 'bmw123', 1, 'ford', 'hugo', 'n/a', 'side car', 'Guest', '04:00 PM', '2024-11-23', '05:50 PM', 183.7, 400, 216.3, '2024-12-02', 'Outgoing');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  `slot_number` int(11) NOT NULL,
  `vehicle_company` varchar(50) DEFAULT NULL,
  `parking_attendant` varchar(25) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `vehicle_type` varchar(25) NOT NULL,
  `customer_type` enum('VIP','Member','Guest') NOT NULL,
  `time_in` varchar(50) NOT NULL,
  `date_in` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `contact_add` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('logged_in','logged_out') NOT NULL DEFAULT 'logged_out'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `lastname`, `gender`, `contact_add`, `address`, `password`, `status`) VALUES
(10, 'marc', 'deleon', 'Male', '0911111111111', 'balintawak', 'marc123', 'logged_out'),
(12, 'hugo', 'salam', 'Male', '0988312231', 'alicia', 'hugo123', 'logged_in'),
(14, 'kevin', 'salam', 'Male', '0911111', 'alicia', 'kebin123', 'logged_out'),
(15, 'attendant', 'user', 'Male', 'n/a', 'alicia', 'attendant123', 'logged_in'),
(16, 'torres', 'bryan', 'Male', '070769656745', 'everlasting', 'HUGOWILAB', 'logged_out');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  `slot_number` int(11) NOT NULL,
  `vehicle_company` varchar(50) DEFAULT NULL,
  `parking_attendant` varchar(25) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `vehicle_type` varchar(25) NOT NULL,
  `customer_type` enum('VIP','Member','Guest') NOT NULL,
  `time_in` varchar(50) NOT NULL,
  `date_in` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `fullname`, `plate_number`, `slot_number`, `vehicle_company`, `parking_attendant`, `contact_number`, `vehicle_type`, `customer_type`, `time_in`, `date_in`) VALUES
(204, 'kevin', 'bmw123', 3, 'ford', 'hugo', 'n/a', 'Four wheels', 'Guest', '05:58 PM', '2024-11-28'),
(205, 'HHJHJHJ', 'GGG', 2, 'YHUHJJ', 'attendant', 'HJHGGH', 'side car', 'VIP', '06:05 PM', '2024-11-28'),
(206, 'kevin', 'bmw123', 4, 'ford', 'hugo', 'n/a', 'side car', 'VIP', '11:04 AM', '2024-12-01'),
(207, 'marc', 'bmw123', 5, 'ford', 'hugo', 'n/a', 'side car', 'VIP', '11:51 AM', '2025-03-08');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_categories`
--

CREATE TABLE `vehicle_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_categories`
--

INSERT INTO `vehicle_categories` (`id`, `category_name`) VALUES
(46, 'side car'),
(48, 'Four wheels'),
(49, 'kariton'),
(51, 'habal habal'),
(52, 'hover board'),
(53, 'tricycle');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_slots`
--

CREATE TABLE `vehicle_slots` (
  `id` int(11) NOT NULL,
  `slot_number` int(11) NOT NULL,
  `status` enum('Occupied','Available','Pending') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_slots`
--

INSERT INTO `vehicle_slots` (`id`, `slot_number`, `status`) VALUES
(181, 1, 'Available'),
(592, 2, 'Occupied'),
(593, 3, 'Occupied'),
(645, 5, 'Occupied'),
(685, 4, 'Occupied'),
(686, 5, 'Occupied'),
(687, 6, 'Available'),
(688, 7, 'Available'),
(689, 8, 'Available'),
(690, 9, 'Available'),
(691, 10, 'Available');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_user`
--
ALTER TABLE `customer_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outgoing`
--
ALTER TABLE `outgoing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_categories`
--
ALTER TABLE `vehicle_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_slots`
--
ALTER TABLE `vehicle_slots`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_user`
--
ALTER TABLE `customer_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `outgoing`
--
ALTER TABLE `outgoing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `vehicle_categories`
--
ALTER TABLE `vehicle_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `vehicle_slots`
--
ALTER TABLE `vehicle_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=692;
--
-- Database: `librarydb`
--
CREATE DATABASE IF NOT EXISTS `librarydb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `librarydb`;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `quantity`) VALUES
(1, 'ALAMAT NG PINYA', 'Christine Bellen', 100),
(2, 'ALAMAT NG SAMPAGUITA', 'Virgilio Amalrio', 110),
(3, 'ALAMAT NG ARAW AT BUWAN', 'Rene Villanueva', 120),
(4, 'ALAMAT NG ROSAS', 'Lirio Sandoval', 130),
(5, 'ALAMAT NG BAHAGHARI', 'Reynaldo Alejandro', 140),
(6, 'ALAMAT NG PAGONG AT KUNEHO', 'Nino Apao', 150);

-- --------------------------------------------------------

--
-- Table structure for table `borrowed_books`
--

CREATE TABLE `borrowed_books` (
  `borrowed_id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `borrower_name` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowed_books`
--

INSERT INTO `borrowed_books` (`borrowed_id`, `book_id`, `borrower_name`, `contact_number`, `borrow_date`, `due_date`) VALUES
(17, 1, '230101267', '09094198446', '2025-05-23', '2025-05-30');

-- --------------------------------------------------------

--
-- Table structure for table `returned_books`
--

CREATE TABLE `returned_books` (
  `returned_id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `borrower_name` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `fine` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `returned_books`
--

INSERT INTO `returned_books` (`returned_id`, `book_id`, `borrower_name`, `contact_number`, `borrow_date`, `return_date`, `fine`) VALUES
(12, 3, '230101627', '09094198446', '2025-05-21', '2025-05-21', 250),
(13, 6, '230101297', '09094198446', '2025-05-23', '2025-05-23', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD PRIMARY KEY (`borrowed_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `returned_books`
--
ALTER TABLE `returned_books`
  ADD PRIMARY KEY (`returned_id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  MODIFY `borrowed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `returned_books`
--
ALTER TABLE `returned_books`
  MODIFY `returned_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD CONSTRAINT `borrowed_books_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);

--
-- Constraints for table `returned_books`
--
ALTER TABLE `returned_books`
  ADD CONSTRAINT `returned_books_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
--
-- Database: `mechanicxpress_db`
--
CREATE DATABASE IF NOT EXISTS `mechanicxpress_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mechanicxpress_db`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_name`, `email`, `password`, `created_at`) VALUES
(1, 'admin', 'admin1@gmail.com', '$2y$10$OOzJO0ybS1sD4/l0hPsXJunpRHMWOlqXdWXoIfuq8r98WB0fnOycS', '2025-03-31 01:57:53');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `comments` text DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_time` time NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `status` enum('pending','approved','completed','canceled') NOT NULL DEFAULT 'pending',
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `admin_share` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shop_share` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `shop_id`, `customer_name`, `email`, `customer_phone`, `comments`, `booking_date`, `booking_time`, `shop_name`, `status`, `latitude`, `longitude`, `address`, `admin_share`, `shop_share`) VALUES
(16, 4, 'marc', 'dabu@gmail.com', '0916 414 7532', '0', '2025-03-29', '23:56:00', 'Dabu\'s Detailing', 'completed', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 7.95, 71.55),
(17, 4, 'Xample2', 'dabu@gmail.com', '0916 414 7532', '0', '2024-01-30', '00:31:00', 'Dabu\'s Detailing', 'completed', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 7.95, 71.55),
(18, 17, 'Xample1', 'dabu@gmail.com', '0916 414 7532', '0', '2025-03-30', '01:43:00', 'neca@gmail.com', 'approved', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 13.90, 125.10),
(19, 4, 'padre', 'dabu@gmail.com', '0916 414 7532', '0', '2025-03-31', '17:22:00', 'Dabu\'s Detailing', 'canceled', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 7.95, 71.55),
(21, 17, 'Xampleuilit', 'dabu@gmail.com', '0916 414 7532', '0', '2025-04-01', '03:30:00', 'neca@gmail.com', 'pending', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 13.90, 125.10),
(23, 17, 'marc123', 'dabu@gmail.com', '0916 414 7532', '0', '2025-03-31', '03:36:00', 'neca@gmail.com', 'pending', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 13.90, 125.10),
(24, 17, 'marc', 'dabu@gmail.com', '0916 414 7532', '0', '2025-04-02', '03:41:00', 'neca@gmail.com', 'pending', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 13.90, 125.10),
(25, 17, 'marc', 'dabu@gmail.com', '0916 414 7532', '0', '2025-04-02', '03:41:00', 'neca@gmail.com', 'pending', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 13.90, 125.10),
(26, 17, 'Xample1', 'dabu@gmail.com', '0916 414 7532', '0', '2025-03-30', '03:44:00', 'neca@gmail.com', 'pending', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 13.90, 125.10),
(27, 17, 'Xample1', 'dabu@gmail.com', '0916 414 7532', 'just marc dabu', '2025-04-04', '03:48:00', 'neca@gmail.com', 'pending', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 13.90, 125.10),
(28, 4, 'marc', 'dabu@gmail.com', '0916 414 7532', 'dad', '2025-03-30', '23:10:00', 'Dabu\'s Detailing', 'canceled', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 7.95, 71.55),
(29, 4, 'marc', 'dabu@gmail.com', '0916 414 7532', 'ht', '2025-03-31', '00:21:00', 'Dabu\'s Detailing', 'canceled', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 7.95, 71.55),
(30, 4, 'marc', 'dabu@gmail.com', '0916 414 7532', 'gt', '2025-03-31', '00:22:00', 'Dabu\'s Detailing', 'canceled', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 7.95, 71.55),
(31, 4, 'marc', 'dabu@gmail.com', '04343232424', 'gt', '2025-03-31', '00:23:00', 'Dabu\'s Detailing', 'completed', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 7.95, 71.55),
(32, 4, 'marc', 'dabu@gmail.com', '04343232424', 'gh', '2025-03-31', '00:57:00', 'Dabu\'s Detailing', 'canceled', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 7.95, 71.55),
(33, 4, 'marc', 'dabu@gmail.com', '04343232424', 'gh', '2024-12-31', '00:58:00', 'Dabu\'s Detailing', 'completed', 14.6604032, 120.9991168, 'Iglesia ni Cristo, West Service Road, Barangay 154, Zone 13, Bagong Barrio West, District 1, Caloocan, Northern Manila District, Metro Manila, 1476, Philippines', 7.95, 71.55),
(34, 4, 'try', 'dabu@gmail.com', '099999999999', 'try123', '2025-05-19', '02:13:00', 'Dabu\'s Detailing', 'completed', 14.6112512, 121.0515456, 'Moms Manyaman, 36, Mariposa Street, Bagong Lipunan ng Crame, 4th District, Quezon City, Eastern Manila District, Metro Manila, 1111, Philippines', 12.17, 109.52),
(35, 4, 'dfsdf', 'dabu@gmail.com', '7456234252', '', '2025-05-19', '16:16:00', 'Dabu\'s Detailing', 'approved', 14.7268313, 121.0370033, 'Best link College MV, Topaz Street, San Agustin, 5th District, Quezon City, Eastern Manila District, Metro Manila, 1117, Philippines', 5.00, 45.00);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `email`, `password`, `status`) VALUES
(1, 'dabu', 'dabu@gmail.com', '$2y$10$.0DDz/2dW3uyS68NZoEWYOlhc.T4fyFadZO/8Vn31MF67tj4etIhe', 'active'),
(3, 'cyrus', 'cyrus@gmail.com', '$2y$10$SfOAaEmcP/ofR4hjssPPi.vzbSZr3H9zPEI2qCtIdJv9qjulPatm6', 'active'),
(6, 'marc', 'kaka@gmail.com', '$2y$10$x/ccB9t/woizpQF4MWRhKe6jJEtX845af9j6/whmYD/DD/kjSl5Ly', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `mechanics`
--

CREATE TABLE `mechanics` (
  `id` int(11) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `subscription` enum('un_subscribe','subscribed','expired') NOT NULL DEFAULT 'un_subscribe',
  `subscription_start` date DEFAULT NULL,
  `contact` varchar(20) NOT NULL,
  `services` text NOT NULL,
  `shop_logo` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mechanics`
--

INSERT INTO `mechanics` (`id`, `shop_name`, `email`, `password`, `latitude`, `longitude`, `address`, `subscription`, `subscription_start`, `contact`, `services`, `shop_logo`, `status`) VALUES
(4, 'Dabu\'s Detailing', 'best@gmail.com', '$2y$10$YguxxP.IyBBK/BaKkCpBLebb0t/wKDIo6IzJn3Q5NHv1fvM4wE/U6', 14.72009590449141, 121.03978788048147, 'Quirino Hwy, Novaliches, Quezon City, Metro Manila', 'subscribed', '2025-03-19', '09123456789', 'Check engine', 'uploads/shop_logo_682a7d5fe8a848.38896384.jpg', 'active'),
(23, 'All About Talyears', 'jona1@gmail.com', '$2y$10$6XdMcTZ3Ycg/Mxq9YlXt.eGFKlet/jC3AEYD1qZ3vIyxJRY9xTj0C', 14.666662631350809, 121.02052350721421, '6 Rd 12, Project 8, Quezon City, Metro Manila', 'subscribed', '2025-03-29', '0919294234324', 'Engine Works \r\n', 'uploads/shop_logo_682adca6b37e13.01109205.jfif', 'active'),
(24, 'jella@gmail.com', 'jella@gmail.com', '$2y$10$pF/Lo2MUySc9lwpULPouEezK5jUwtppQWuh7p7zpxJl6D95JW4OnS', 14.66037418369149, 121.00816623847145, '32A Eulogia Drive Balintawak Quezon City', 'subscribed', '2025-03-30', '', '', '', 'active'),
(25, 'abu\'s Detailing', 'marclloyd@gmail.com', '$2y$10$zLVW9mEDAwRTIsJS2c23ae2ImCMAOG35yHb72.u6UQKF8P8PG4hcS', 14.772537526794776, 121.0444244333558, 'Old Zabarte, Caloocan, Kalakhang Maynila', 'subscribed', '2025-03-30', '', '', '', 'active'),
(27, 'try', 'try@gmail.com', '$2y$10$xyYNAJZCXhPFoXzfmECn2eoHJLPnsrZc/R1OX135FpG.SvF36dOeq', 14.727197961364011, 121.03714939278206, 'San Agustin Elementary School, Heavenly Drive, San Agustin, 5th District, Quezon City, Eastern Manila District, Metro Manila, 1125, Philippines', 'un_subscribe', NULL, '', '', '', 'active'),
(28, 'try1', 'try1@gmail.com', '$2y$10$SUj4QgoZL9dnd8lRJlstDuejrs01L0S0P01g5o0omzA6tDqEVrU0q', 0, 0, 'san j', 'un_subscribe', NULL, '', '', '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `m_reports`
--

CREATE TABLE `m_reports` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `issue_description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `issue_description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `customer_name`, `shop_name`, `issue_description`, `created_at`) VALUES
(1, 'marc', 'Dabu\'s Detailing', 'xxxxxxxxxxxxxxxxxxxxxxx\nxxxxxxxxxxxxxxxxxxxxxxxxxxxxx\nxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx\nxxxxxxxxxxxxxxxxxxxxxxxx\n', '2025-04-01 17:58:26'),
(2, 'try', 'Dabu\'s Detailing', 'hahahhaa', '2025-05-19 08:08:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `mechanics`
--
ALTER TABLE `mechanics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `m_reports`
--
ALTER TABLE `m_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mechanics`
--
ALTER TABLE `mechanics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `m_reports`
--
ALTER TABLE `m_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Database: `noahs_ark`
--
CREATE DATABASE IF NOT EXISTS `noahs_ark` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `noahs_ark`;

-- --------------------------------------------------------

--
-- Table structure for table `adoption_form`
--

CREATE TABLE `adoption_form` (
  `id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `pet_name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `other_pets` enum('Yes','No') NOT NULL,
  `experience` text NOT NULL,
  `reason` text NOT NULL,
  `terms_accepted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `image`, `description`, `created_at`) VALUES
(1, 'Potpot', 'uploads/1744992807_12.jpg', 'siya ay mabait', '2025-04-18 15:29:54');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `created_at`, `image_path`) VALUES
(12, 'Potpot ang pinaka cute na aso', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '2025-04-18 16:13:27', 'uploads/1744992807_12.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `breed` varchar(100) NOT NULL,
  `age` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `vaccinated` varchar(5) NOT NULL,
  `neutered` varchar(5) NOT NULL,
  `about` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`id`, `name`, `breed`, `age`, `gender`, `type`, `status`, `vaccinated`, `neutered`, `about`, `image`, `created_at`) VALUES
(5, 'Potpot', 'shitsu', '3months', 'Male', 'Dog', 'Adopted', 'Yes', 'No', 'CUTE KUPAL PALA TAE', 'uploads/1744916793_12.jpg', '2025-04-17 19:06:33'),
(6, 'Tangol', 'Asphin', '2years', 'Male', 'Dog', 'Available', 'Yes', 'No', 'Ma angas', 'uploads/1744995651_13.jpg', '2025-04-18 17:00:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

--
-- Dumping data for table `pma__export_templates`
--

INSERT INTO `pma__export_templates` (`id`, `username`, `export_type`, `template_name`, `template_data`) VALUES
(1, 'root', 'database', 'mechmechanicxpress_db', '{\"quick_or_custom\":\"quick\",\"what\":\"sql\",\"structure_or_data_forced\":\"0\",\"table_select[]\":[\"bookings\",\"customers\",\"mechanics\"],\"table_structure[]\":[\"bookings\",\"customers\",\"mechanics\"],\"table_data[]\":[\"bookings\",\"customers\",\"mechanics\"],\"aliases_new\":\"\",\"output_format\":\"sendit\",\"filename_template\":\"admin_database\",\"remember_template\":\"on\",\"charset\":\"utf-8\",\"compression\":\"none\",\"maxsize\":\"\",\"codegen_structure_or_data\":\"data\",\"codegen_format\":\"0\",\"csv_separator\":\",\",\"csv_enclosed\":\"\\\"\",\"csv_escaped\":\"\\\"\",\"csv_terminated\":\"AUTO\",\"csv_null\":\"NULL\",\"csv_columns\":\"something\",\"csv_structure_or_data\":\"data\",\"excel_null\":\"NULL\",\"excel_columns\":\"something\",\"excel_edition\":\"win\",\"excel_structure_or_data\":\"data\",\"json_structure_or_data\":\"data\",\"json_unicode\":\"something\",\"latex_caption\":\"something\",\"latex_structure_or_data\":\"structure_and_data\",\"latex_structure_caption\":\"Structure of table @TABLE@\",\"latex_structure_continued_caption\":\"Structure of table @TABLE@ (continued)\",\"latex_structure_label\":\"tab:@TABLE@-structure\",\"latex_relation\":\"something\",\"latex_comments\":\"something\",\"latex_mime\":\"something\",\"latex_columns\":\"something\",\"latex_data_caption\":\"Content of table @TABLE@\",\"latex_data_continued_caption\":\"Content of table @TABLE@ (continued)\",\"latex_data_label\":\"tab:@TABLE@-data\",\"latex_null\":\"\\\\textit{NULL}\",\"mediawiki_structure_or_data\":\"structure_and_data\",\"mediawiki_caption\":\"something\",\"mediawiki_headers\":\"something\",\"htmlword_structure_or_data\":\"structure_and_data\",\"htmlword_null\":\"NULL\",\"ods_null\":\"NULL\",\"ods_structure_or_data\":\"data\",\"odt_structure_or_data\":\"structure_and_data\",\"odt_relation\":\"something\",\"odt_comments\":\"something\",\"odt_mime\":\"something\",\"odt_columns\":\"something\",\"odt_null\":\"NULL\",\"pdf_report_title\":\"\",\"pdf_structure_or_data\":\"structure_and_data\",\"phparray_structure_or_data\":\"data\",\"sql_include_comments\":\"something\",\"sql_header_comment\":\"\",\"sql_use_transaction\":\"something\",\"sql_compatibility\":\"NONE\",\"sql_structure_or_data\":\"structure_and_data\",\"sql_create_table\":\"something\",\"sql_auto_increment\":\"something\",\"sql_create_view\":\"something\",\"sql_procedure_function\":\"something\",\"sql_create_trigger\":\"something\",\"sql_backquotes\":\"something\",\"sql_type\":\"INSERT\",\"sql_insert_syntax\":\"both\",\"sql_max_query_size\":\"50000\",\"sql_hex_for_binary\":\"something\",\"sql_utc_time\":\"something\",\"texytext_structure_or_data\":\"structure_and_data\",\"texytext_null\":\"NULL\",\"xml_structure_or_data\":\"data\",\"xml_export_events\":\"something\",\"xml_export_functions\":\"something\",\"xml_export_procedures\":\"something\",\"xml_export_tables\":\"something\",\"xml_export_triggers\":\"something\",\"xml_export_views\":\"something\",\"xml_export_contents\":\"something\",\"yaml_structure_or_data\":\"data\",\"\":null,\"lock_tables\":null,\"as_separate_files\":null,\"csv_removeCRLF\":null,\"excel_removeCRLF\":null,\"json_pretty_print\":null,\"htmlword_columns\":null,\"ods_columns\":null,\"sql_dates\":null,\"sql_relation\":null,\"sql_mime\":null,\"sql_disable_fk\":null,\"sql_views_as_tables\":null,\"sql_metadata\":null,\"sql_create_database\":null,\"sql_drop_table\":null,\"sql_if_not_exists\":null,\"sql_simple_view_export\":null,\"sql_view_current_user\":null,\"sql_or_replace_view\":null,\"sql_truncate\":null,\"sql_delayed\":null,\"sql_ignore\":null,\"texytext_columns\":null}'),
(2, 'root', 'database', 'sms', '{\"quick_or_custom\":\"quick\",\"what\":\"sql\",\"structure_or_data_forced\":\"0\",\"table_select[]\":[\"academic_records\",\"document_requests\",\"file_storage\",\"guardians\",\"health_records\",\"login_audit\",\"masterlists\",\"masterlist_details\",\"roles\",\"students\",\"student_ids\",\"student_status_history\",\"subjects\",\"system_logs\",\"users\"],\"table_structure[]\":[\"academic_records\",\"document_requests\",\"file_storage\",\"guardians\",\"health_records\",\"login_audit\",\"masterlists\",\"masterlist_details\",\"roles\",\"students\",\"student_ids\",\"student_status_history\",\"subjects\",\"system_logs\",\"users\"],\"table_data[]\":[\"academic_records\",\"document_requests\",\"file_storage\",\"guardians\",\"health_records\",\"login_audit\",\"masterlists\",\"masterlist_details\",\"roles\",\"students\",\"student_ids\",\"student_status_history\",\"subjects\",\"system_logs\",\"users\"],\"aliases_new\":\"\",\"output_format\":\"sendit\",\"filename_template\":\"admin_database\",\"remember_template\":\"on\",\"charset\":\"utf-8\",\"compression\":\"none\",\"maxsize\":\"\",\"codegen_structure_or_data\":\"data\",\"codegen_format\":\"0\",\"csv_separator\":\",\",\"csv_enclosed\":\"\\\"\",\"csv_escaped\":\"\\\"\",\"csv_terminated\":\"AUTO\",\"csv_null\":\"NULL\",\"csv_columns\":\"something\",\"csv_structure_or_data\":\"data\",\"excel_null\":\"NULL\",\"excel_columns\":\"something\",\"excel_edition\":\"win\",\"excel_structure_or_data\":\"data\",\"json_structure_or_data\":\"data\",\"json_unicode\":\"something\",\"latex_caption\":\"something\",\"latex_structure_or_data\":\"structure_and_data\",\"latex_structure_caption\":\"Structure of table @TABLE@\",\"latex_structure_continued_caption\":\"Structure of table @TABLE@ (continued)\",\"latex_structure_label\":\"tab:@TABLE@-structure\",\"latex_relation\":\"something\",\"latex_comments\":\"something\",\"latex_mime\":\"something\",\"latex_columns\":\"something\",\"latex_data_caption\":\"Content of table @TABLE@\",\"latex_data_continued_caption\":\"Content of table @TABLE@ (continued)\",\"latex_data_label\":\"tab:@TABLE@-data\",\"latex_null\":\"\\\\textit{NULL}\",\"mediawiki_structure_or_data\":\"structure_and_data\",\"mediawiki_caption\":\"something\",\"mediawiki_headers\":\"something\",\"htmlword_structure_or_data\":\"structure_and_data\",\"htmlword_null\":\"NULL\",\"ods_null\":\"NULL\",\"ods_structure_or_data\":\"data\",\"odt_structure_or_data\":\"structure_and_data\",\"odt_relation\":\"something\",\"odt_comments\":\"something\",\"odt_mime\":\"something\",\"odt_columns\":\"something\",\"odt_null\":\"NULL\",\"pdf_report_title\":\"\",\"pdf_structure_or_data\":\"structure_and_data\",\"phparray_structure_or_data\":\"data\",\"sql_include_comments\":\"something\",\"sql_header_comment\":\"\",\"sql_use_transaction\":\"something\",\"sql_compatibility\":\"NONE\",\"sql_structure_or_data\":\"structure_and_data\",\"sql_create_table\":\"something\",\"sql_auto_increment\":\"something\",\"sql_create_view\":\"something\",\"sql_procedure_function\":\"something\",\"sql_create_trigger\":\"something\",\"sql_backquotes\":\"something\",\"sql_type\":\"INSERT\",\"sql_insert_syntax\":\"both\",\"sql_max_query_size\":\"50000\",\"sql_hex_for_binary\":\"something\",\"sql_utc_time\":\"something\",\"texytext_structure_or_data\":\"structure_and_data\",\"texytext_null\":\"NULL\",\"xml_structure_or_data\":\"data\",\"xml_export_events\":\"something\",\"xml_export_functions\":\"something\",\"xml_export_procedures\":\"something\",\"xml_export_tables\":\"something\",\"xml_export_triggers\":\"something\",\"xml_export_views\":\"something\",\"xml_export_contents\":\"something\",\"yaml_structure_or_data\":\"data\",\"\":null,\"lock_tables\":null,\"as_separate_files\":null,\"csv_removeCRLF\":null,\"excel_removeCRLF\":null,\"json_pretty_print\":null,\"htmlword_columns\":null,\"ods_columns\":null,\"sql_dates\":null,\"sql_relation\":null,\"sql_mime\":null,\"sql_disable_fk\":null,\"sql_views_as_tables\":null,\"sql_metadata\":null,\"sql_create_database\":null,\"sql_drop_table\":null,\"sql_if_not_exists\":null,\"sql_simple_view_export\":null,\"sql_view_current_user\":null,\"sql_or_replace_view\":null,\"sql_truncate\":null,\"sql_delayed\":null,\"sql_ignore\":null,\"texytext_columns\":null}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"sms\",\"table\":\"archived_academic_background\"},{\"db\":\"sms\",\"table\":\"archived_guardians\"},{\"db\":\"sms\",\"table\":\"archived_file_storage\"},{\"db\":\"sms\",\"table\":\"archived_students\"},{\"db\":\"sms\",\"table\":\"guardians\"},{\"db\":\"sms\",\"table\":\"students\"},{\"db\":\"sms\",\"table\":\"student_ids\"},{\"db\":\"sms\",\"table\":\"file_storage\"},{\"db\":\"sms\",\"table\":\"academic_background\"},{\"db\":\"sms\",\"table\":\"academic_records\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- Dumping data for table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'admin_dashboard', 'outgoing', '{\"sorted_col\":\"`id` ASC\"}', '2024-11-25 04:31:11'),
('root', 'admin_dashboard', 'users', '{\"sorted_col\":\"`users`.`username` ASC\"}', '2024-11-23 06:17:53'),
('root', 'admin_dashboard', 'vehicle_slots', '{\"sorted_col\":\"`slot_number` DESC\"}', '2024-12-01 03:09:15'),
('root', 'admin_dashboard', 'vehicles', '[]', '2024-11-14 05:11:18'),
('root', 'mechanicxpress_db', 'mechanics', '{\"sorted_col\":\"`mechanics`.`subscription` ASC\"}', '2025-05-19 04:46:03'),
('root', 'salon_db', 'bookings', '{\"sorted_col\":\"`bookings`.`balance` ASC\"}', '2025-03-12 18:52:29'),
('root', 'sms', 'students', '{\"sorted_col\":\"`students`.`photo_path` DESC\"}', '2025-10-11 16:13:44');

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2025-10-12 14:00:25', '{\"Console\\/Mode\":\"collapse\",\"Export\\/file_template_database\":\"admin_database\",\"NavigationWidth\":215}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `salon_db`
--
CREATE DATABASE IF NOT EXISTS `salon_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `salon_db`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `full_name`, `contact_number`, `created_at`) VALUES
(1, 'marclloyd@gmail.com', 'try123', 'Xample1', '0912345678', '2025-03-08 07:09:27');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_price` decimal(10,2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `booking_time` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `date` date DEFAULT NULL,
  `status` enum('pending','completed','canceled','approved') DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_number` varchar(20) DEFAULT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `service_name`, `service_price`, `name`, `email`, `booking_time`, `created_at`, `date`, `status`, `payment_method`, `payment_number`, `balance`) VALUES
(1, 'V cut x Burst faid', 200.00, 'padre', 'padre@gmail.com', '10:00 AM', '2025-03-12 15:27:33', '2025-03-12', 'completed', NULL, NULL, 0.00),
(2, 'Acrylic manicure', 700.00, 'padre', 'padre@gmail.com', '1:00 PM', '2025-03-12 15:28:32', '2025-03-12', 'completed', NULL, NULL, 0.00),
(3, 'V cut x Burst faid', 200.00, 'padre', 'padre@gmail.com', '10:00 AM', '2025-03-12 18:07:38', '2025-03-13', 'pending', '', '', 0.00),
(4, 'V cut x Burst faid', 200.00, 'padre', 'padre@gmail.com', '10:00 AM', '2025-03-12 18:07:48', '2025-03-13', 'pending', '', '', 0.00),
(5, 'V cut x Burst faid', 200.00, 'padre', 'padre@gmail.com', '10:00 AM', '2025-03-12 18:08:52', '2025-03-13', 'approved', '', '', 0.00),
(6, 'V cut x Burst faid', 200.00, 'padre', 'padre@gmail.com', '10:00 AM', '2025-03-12 18:11:07', '2025-03-13', 'approved', '', '', 0.00),
(7, 'V cut x Burst faid', 200.00, 'padre', 'padre@gmail.com', '10:00 AM', '2025-03-12 18:16:45', '2025-03-13', 'approved', '', '', 0.00),
(8, 'V cut x Burst faid', 200.00, 'padre', 'padre@gmail.com', '10:00 AM', '2025-03-12 18:18:20', '2025-03-13', 'pending', 'GCash', '01233333333', 0.00),
(9, 'V cut x Burst faid', 200.00, 'padre', 'padre@gmail.com', '10:00 AM', '2025-03-12 18:26:09', '2025-03-13', 'pending', 'GCash', '01233333333', 0.00),
(10, 'C Curl Rebonding', 1200.00, 'padre', 'padre@gmail.com', '10:00 AM', '2025-03-12 18:54:11', '2025-03-13', 'approved', 'GCash', '01233333333', 900.00),
(11, 'French manicure', 700.00, 'padre', 'padre@gmail.com', '10:00 AM', '2025-03-12 19:05:15', '2025-03-13', 'approved', 'GCash', '01233333333', 525.00),
(12, 'Volume Rebonding', 1200.00, 'marc', 'marclloyd@gmail.com', '10:00 AM', '2025-03-14 05:02:28', '2025-03-14', 'completed', 'GCash', '01233333333', 900.00),
(13, 'Light Matt Blond', 200.00, 'marc', 'marclloyd@gmail.com', '10:00 AM', '2025-03-17 10:36:47', '2025-03-19', 'approved', 'GCash', '01233333333', 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_description` text NOT NULL,
  `service_price` decimal(10,2) NOT NULL,
  `service_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `service_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`, `service_description`, `service_price`, `service_image`, `created_at`, `service_type`) VALUES
(1, 'V cut x Burst faid', 'Men\'s Cut', 200.00, 'uploads/1741429846_v.jpg', '2025-03-08 10:30:46', 'Haircut'),
(2, 'Intense Lightest Blond', 'Men & Women\'s colors', 200.00, 'uploads/1741442294_1.jpg', '2025-03-08 13:58:14', 'HairColor'),
(3, 'Light Matt Blond', 'Men & Women\'s Color', 200.00, 'uploads/1741442396_2.jpg', '2025-03-08 13:59:56', 'HairColor'),
(4, 'Medium Gold Yellow', 'Men & Women\'s Color', 200.00, 'uploads/1741442449_3.jpg', '2025-03-08 14:00:49', 'HairColor'),
(5, 'Volume Rebonding', 'Volume rebonding is a newer, more natural-looking type of hair rebonding.', 1200.00, 'uploads/1741443016_4.jpg', '2025-03-08 14:10:16', 'Rebond'),
(6, 'C Curl Rebonding', 'C Curl rebonding is a classic Korean rebonding style who likes to rebonding their hair but yet want abit more volume at the ends of the hair.', 1200.00, 'uploads/1741443123_5.jpg', '2025-03-08 14:12:03', 'Rebond'),
(7, 'Wave Rebonding', 'Wave Rebonding delivers light waves from mid lengths to the ends.', 1200.00, 'uploads/1741443194_6.jpg', '2025-03-08 14:13:14', 'Rebond'),
(8, 'Acrylic manicure', 'Acrylic manicure is the go-to style for people with short nails. It adds more length to your natural nails and can last as long as three weeks.', 700.00, 'uploads/1741443462_7.jpg', '2025-03-08 14:17:42', 'Manicure'),
(9, 'French manicure', 'painting the nails with a sheer or nude shade as the base, followed by carefully applying white polish to the tips, creating a subtle contrast.', 700.00, 'uploads/1741443587_8.jpg', '2025-03-08 14:19:47', 'Manicure'),
(10, 'Shellac manicure', 'Shellac manicure is a hybrid polish, made up of half gel and half regular nail polish.', 700.00, 'uploads/1741443669_9.jpg', '2025-03-08 14:21:09', 'Manicure'),
(11, 'mullet', 'maangas ', 250.00, 'uploads/1742196095_2.png', '2025-03-17 07:21:35', 'Haircut');

--
-- Triggers `services`
--
DELIMITER $$
CREATE TRIGGER `after_service_delete` AFTER DELETE ON `services` FOR EACH ROW BEGIN
    CALL reset_service_ids();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `contact`, `created_at`) VALUES
(1, 'padre@gmail.com', 'try123', 'padre', '0912345678', '2025-03-09 15:04:55'),
(2, 'marclloyd@gmail.com', 'try123', 'marc', '0912345678', '2025-03-09 15:22:36'),
(3, 'razoz@gmail.com', 'try123', 'razoz', '0912345678', '2025-03-09 16:51:39');

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
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Database: `schooldb`
--
CREATE DATABASE IF NOT EXISTS `schooldb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `schooldb`;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `program_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `program_id`) VALUES
(1, 'NET101', 1),
(2, 'NET102', 2),
(3, 'ROTC', 3),
(4, 'PATFIT', 3),
(5, 'PE1', 4),
(6, 'PE1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `course_id`) VALUES
(2, 1),
(1, 2),
(5, 4),
(3, 5),
(4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `id` int(11) NOT NULL,
  `student_email` varchar(100) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `score` int(11) DEFAULT 0,
  `status` enum('completed') DEFAULT 'completed',
  `taken_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_results`
--

INSERT INTO `exam_results` (`id`, `student_email`, `exam_id`, `score`, `status`, `taken_at`) VALUES
(10, 'try4@gmail.com', 4, 2, 'completed', '2025-05-09 02:25:35'),
(11, 'try6@gmail.com', 2, 4, 'completed', '2025-05-23 15:13:37');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `school_id` varchar(50) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `attendance` int(11) DEFAULT NULL,
  `quiz` int(11) DEFAULT NULL,
  `exam` int(11) DEFAULT NULL,
  `project` int(11) DEFAULT NULL,
  `activities` int(11) DEFAULT NULL,
  `final` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `school_id`, `course_id`, `email`, `attendance`, `quiz`, `exam`, `project`, `activities`, `final`) VALUES
(1, 'S357459428', 1, 'try6@gmail.com', 7, 100, 50, 100, 100, 100),
(2, 'S357459428', 5, 'try6@gmail.com', 50, 50, 50, 50, 50, 50),
(3, 'S945932913', 5, 'try7@gmail.com', 50, 50, 50, 50, 50, 50);

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `school_id` varchar(10) DEFAULT NULL,
  `program_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`id`, `email`, `password`, `school_id`, `program_id`, `year_id`) VALUES
(2, 'try@gmail.com', 'try123', 'S183808682', NULL, NULL),
(3, 'try1@gmail.com', 'try123', 'S510309824', NULL, NULL),
(4, 'try3@gmail.com', 'try123', 'S567493850', 2, 2),
(5, 'try4@gmail.com', 'try123', 'S426013218', 1, 1),
(6, 'try5@gmail.com', 'try123', 'S883442297', 1, 1),
(7, 'try6@gmail.com', 'try123', 'S357459428', 1, 1),
(8, 'try7@gmail.com', 'try123', 'S945932913', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `program_name` varchar(100) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `program_name`, `year_id`) VALUES
(1, 'BSIT', 1),
(2, 'BSIT', 2),
(3, 'CRIM', 1),
(4, 'BSHM', 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer1` varchar(255) NOT NULL,
  `answer2` varchar(255) NOT NULL,
  `answer3` varchar(255) NOT NULL,
  `answer4` varchar(255) NOT NULL,
  `correct_answer` varchar(255) NOT NULL,
  `exam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `answer1`, `answer2`, `answer3`, `answer4`, `correct_answer`, `exam_id`) VALUES
(38, '1+1', '2', '3', '4', '5', 'A', 2),
(39, '2+1', '3', '4', '5', '6', 'A', 2),
(40, '1+1', '2', '3', '4', '5', 'A', 5),
(41, '2+1', '3', '4', '5', '6', 'A', 5),
(42, '1+3', '3', '4', '5', '6', 'B', 2),
(43, '1+4', '5', '6', '7', '8', 'A', 2),
(44, '1+5', '6', '7', '8', '9', 'A', 2);

-- --------------------------------------------------------

--
-- Table structure for table `student_courses`
--

CREATE TABLE `student_courses` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_courses`
--

INSERT INTO `student_courses` (`id`, `student_id`, `course_id`) VALUES
(1, 7, 1),
(2, 7, 6),
(3, 8, 5);

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `super_admin`
--

INSERT INTO `super_admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_admin`
--

CREATE TABLE `teacher_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_admin`
--

INSERT INTO `teacher_admin` (`id`, `username`, `password`) VALUES
(1, 'teacher', 'teacher123');

-- --------------------------------------------------------

--
-- Table structure for table `year_levels`
--

CREATE TABLE `year_levels` (
  `id` int(11) NOT NULL,
  `year_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `year_levels`
--

INSERT INTO `year_levels` (`id`, `year_name`) VALUES
(1, '1ST YEAR'),
(2, '2ND YEAR');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_id` (`program_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_email` (`student_email`,`exam_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_course_id` (`course_id`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_program` (`program_id`),
  ADD KEY `fk_year` (`year_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `year_id` (`year_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `teacher_admin`
--
ALTER TABLE `teacher_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `year_levels`
--
ALTER TABLE `year_levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `year_name` (`year_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `student_courses`
--
ALTER TABLE `student_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teacher_admin`
--
ALTER TABLE `teacher_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `year_levels`
--
ALTER TABLE `year_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`);

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `fk_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `info`
--
ALTER TABLE `info`
  ADD CONSTRAINT `fk_program` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`),
  ADD CONSTRAINT `fk_year` FOREIGN KEY (`year_id`) REFERENCES `year_levels` (`id`);

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_ibfk_1` FOREIGN KEY (`year_id`) REFERENCES `year_levels` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`);

--
-- Constraints for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD CONSTRAINT `student_courses_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `info` (`id`),
  ADD CONSTRAINT `student_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);
--
-- Database: `sms`
--
CREATE DATABASE IF NOT EXISTS `sms` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sms`;

-- --------------------------------------------------------

--
-- Table structure for table `academic_background`
--

CREATE TABLE `academic_background` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `primary_school` varchar(255) DEFAULT NULL,
  `primary_year` varchar(10) DEFAULT NULL,
  `secondary_school` varchar(255) DEFAULT NULL,
  `secondary_year` varchar(10) DEFAULT NULL,
  `tertiary_school` varchar(255) DEFAULT NULL,
  `tertiary_year` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_background`
--

INSERT INTO `academic_background` (`id`, `student_id`, `primary_school`, `primary_year`, `secondary_school`, `secondary_year`, `tertiary_school`, `tertiary_year`) VALUES
(1, 'S2025-001', '', '', '', '', '', ''),
(2, 'S2025-004', 'Manila Elementary School', '2017', 'Manila Science High School', '2023', 'Bestlink College of the Philippines', '2023'),
(3, 'S2025-005', 'Taguig Elementary School', '2017', 'Taguig City High School', '2023', 'Bestlink College of the Philippines', '2023'),
(4, 'S2025-006', 'Makati Elementary School', '2017', 'Makati High School', '2023', 'Bestlink College of the Philippines', '2023'),
(5, 'S2025-007', 'Pasig Elementary School', '2017', 'Pasig City Science High School', '2023', 'Bestlink College of the Philippines', '2023'),
(6, 'S2025-008', 'Parañaque Elementary School', '2017', 'Parañaque National High School', '2023', 'Bestlink College of the Philippines', '2023'),
(7, 'S2025-009', 'Caloocan Elementary School', '2017', 'Caloocan High School', '2023', 'Bestlink College of the Philippines', '2023'),
(8, 'S2025-010', 'Malabon Elementary School', '2017', 'Malabon National High School', '2023', 'Bestlink College of the Philippines', '2023'),
(9, 'S2025-011', 'Valenzuela Elementary School', '2017', 'Valenzuela National High School', '2023', 'Bestlink College of the Philippines', '2023'),
(10, 'S2025-012', 'Marilao Elementary School', '2018', 'Marilao National High School', '2024', 'Bestlink College of the Philippines', '2024'),
(12, 'S2025-014', 'Sta. Maria Elementary School', '2018', 'Sta. Maria High School', '2024', 'Bestlink College of the Philippines', '2024'),
(13, 'S2025-015', 'Balagtas Elementary School', '2018', 'Balagtas National High School', '2024', 'Bestlink College of the Philippines', '2024'),
(14, 'S2025-016', 'Baliuag Elementary School', '2018', 'Baliuag National High School', '2024', 'Bestlink College of the Philippines', '2024'),
(15, 'S2025-017', 'Plaridel Elementary School', '2018', 'Plaridel National High School', '2024', 'Bestlink College of the Philippines', '2024'),
(16, 'S2025-018', 'Pandi Elementary School', '2018', 'Pandi National High School', '2024', 'Bestlink College of the Philippines', '2024'),
(17, 'S2025-019', 'Meycauayan Elementary School', '2019', 'Meycauayan National High School', '2025', 'Bestlink College of the Philippines', '2025'),
(18, 'S2025-020', 'Obando Elementary School', '2019', 'Obando National High School', '2025', 'Bestlink College of the Philippines', '2025'),
(19, 'S2025-021', 'San Rafael Elementary School', '2019', 'San Rafael National High School', '2025', 'Bestlink College of the Philippines', '2025'),
(20, 'S2025-022', 'San Jose Elementary School', '2019', 'San Jose National High School', '2025', 'Bestlink College of the Philippines', '2025'),
(23, 'S2025-025', 'Guiguinto Elementary School', '2019', 'Guiguinto National High School', '2025', 'Bestlink College of the Philippines', '2025'),
(26, 'S2025-013', 'Bocaue Elementary School', '2018', 'Bocaue National High School', '2024', 'Bestlink College of the Philippines', '2024');

-- --------------------------------------------------------

--
-- Table structure for table `academic_records`
--

CREATE TABLE `academic_records` (
  `record_id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `term` varchar(255) DEFAULT NULL,
  `school_year` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_records`
--

INSERT INTO `academic_records` (`record_id`, `student_id`, `subject_id`, `grade`, `term`, `school_year`, `remarks`) VALUES
(1, 'S2025-001', 1, '1.50', '1st Sem', '2025-2026', 'Passed'),
(2, 'S2025-001', 2, '1.75', '1st Sem', '2025-2026', 'Passed'),
(3, 'S2025-001', 3, '2.00', '1st Sem', '2025-2026', 'Passed');

-- --------------------------------------------------------

--
-- Table structure for table `archived_academic_background`
--

CREATE TABLE `archived_academic_background` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `primary_school` varchar(255) DEFAULT NULL,
  `primary_year` varchar(10) DEFAULT NULL,
  `secondary_school` varchar(255) DEFAULT NULL,
  `secondary_year` varchar(10) DEFAULT NULL,
  `tertiary_school` varchar(255) DEFAULT NULL,
  `tertiary_year` varchar(10) DEFAULT NULL,
  `archived_date` datetime DEFAULT current_timestamp(),
  `archived_reason` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archived_file_storage`
--

CREATE TABLE `archived_file_storage` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_path` text NOT NULL,
  `upload_date` datetime DEFAULT current_timestamp(),
  `archived_date` datetime DEFAULT current_timestamp(),
  `archived_reason` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archived_guardians`
--

CREATE TABLE `archived_guardians` (
  `guardian_id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `archived_date` datetime DEFAULT current_timestamp(),
  `archived_reason` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archived_students`
--

CREATE TABLE `archived_students` (
  `archive_id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `program` varchar(100) NOT NULL,
  `year_level` int(11) DEFAULT 0,
  `section` varchar(50) DEFAULT NULL,
  `student_status` enum('Enrolled','Dropped','Graduated') DEFAULT 'Enrolled',
  `contact_no` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `photo_path` text DEFAULT NULL,
  `archived_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archived_students`
--

INSERT INTO `archived_students` (`archive_id`, `student_id`, `first_name`, `last_name`, `program`, `year_level`, `section`, `student_status`, `contact_no`, `address`, `birthdate`, `gender`, `photo_path`, `archived_date`) VALUES
(3, 'S2025-024', 'Isabella', 'Lee', '0', 3, '31001', 'Dropped', '09123450024', NULL, '2003-09-01', NULL, 'S2025-024.jpg', '2025-10-09 05:14:02'),
(6, 'S2025-023', 'Richard', 'Uy', '0', 2, '21001', 'Dropped', NULL, NULL, NULL, NULL, 'S2025-023.jpg', '2025-10-09 05:32:05');

-- --------------------------------------------------------

--
-- Table structure for table `document_requests`
--

CREATE TABLE `document_requests` (
  `request_id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `document_type` varchar(255) DEFAULT NULL,
  `notes` text NOT NULL,
  `request_date` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_requests`
--

INSERT INTO `document_requests` (`request_id`, `student_id`, `document_type`, `notes`, `request_date`, `status`, `release_date`) VALUES
(1, 'S2025-001', 'Certificate of Enrollment', '', '2025-09-01', 'Released', '2025-09-05'),
(2, 'S2025-004', 'Receipt Records', 'NSTP - RECEIPT CERTIFICATE\r\n', '2025-10-01', 'Approved', '2025-10-10'),
(3, 'S2025-004', 'ID Replacement', '', '2025-10-01', 'Approved', '2025-10-08'),
(9, 'S2025-004', 'Receipt Records', '', '2025-10-03', 'Approved', '2025-10-10'),
(11, 'S2025-004', 'Certificate of Enrollment', '', '2025-10-05', 'Approved', '2025-10-12');

-- --------------------------------------------------------

--
-- Table structure for table `document_requests_archive`
--

CREATE TABLE `document_requests_archive` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `document_type` varchar(100) NOT NULL,
  `notes` text DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `deleted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_requests_archive`
--

INSERT INTO `document_requests_archive` (`id`, `student_id`, `document_type`, `notes`, `request_date`, `status`, `release_date`, `deleted_at`) VALUES
(0, 0, 'ID Replacement', '', '2025-10-04', 'Pending', NULL, '2025-10-05 00:58:57'),
(0, 0, 'ID Replacement', 'MY ID LOST', '2025-10-03', 'Declined', NULL, '2025-10-05 00:59:13');

-- --------------------------------------------------------

--
-- Table structure for table `file_storage`
--

CREATE TABLE `file_storage` (
  `file_id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `file_path` text DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_storage`
--

INSERT INTO `file_storage` (`file_id`, `student_id`, `file_type`, `file_path`, `uploaded_by`, `upload_date`) VALUES
(1, 'S2025-001', 'Enrollment Form', '/uploads/docs/enrollment_form.pdf', 2, '2025-09-28 22:13:17'),
(2, 'S2025-001', 'Form137', '/uploads/docs/1759646441_1.PNG', 2, '2025-10-05 06:40:41'),
(4, 'S2025-001', 'ID', '/uploads/docs/1759661396_ID.pdf', 2, '2025-10-05 10:49:56'),
(10, 'S2025-013', 'ID', '/uploads/docs/1760203678_ID.pdf', NULL, '2025-10-11 17:27:58');

-- --------------------------------------------------------

--
-- Table structure for table `guardians`
--

CREATE TABLE `guardians` (
  `guardian_id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guardians`
--

INSERT INTO `guardians` (`guardian_id`, `student_id`, `name`, `relation`, `contact_no`, `address`) VALUES
(1, 'S2025-001', 'Maria Dela Cruz', 'Mother', '09987654321', 'Quezon City, Metro Manila'),
(5, 'S2025-005', 'Maria Santos Sr.', NULL, '09171234505', 'Quezon City'),
(6, 'S2025-006', 'Carlos Reyes Sr.', NULL, '09171234506', 'Caloocan City'),
(7, 'S2025-007', 'Angelica Torres Sr.', NULL, '09171234507', 'Valenzuela City'),
(8, 'S2025-008', 'Mark Ramos Sr.', NULL, '09171234508', 'Bulacan'),
(9, 'S2025-009', 'Paula Garcia Sr.', NULL, '09171234509', 'Quezon City'),
(10, 'S2025-010', 'John Lim Sr.', NULL, '09171234510', 'Pasig City'),
(11, 'S2025-011', 'Rose Vergara Sr.', NULL, '09171234511', 'Manila'),
(12, 'S2025-012', 'Miguel Dela Cruz Sr.', NULL, '09171234512', 'Quezon City'),
(14, 'S2025-014', 'Patrick Gonzales Sr.', NULL, '09171234514', 'Bulacan'),
(15, 'S2025-015', 'Samantha Ong Sr.', NULL, '09171234515', 'Caloocan City'),
(16, 'S2025-016', 'Josephine Castro Sr.', NULL, '09171234516', 'Pasig City'),
(17, 'S2025-017', 'Edward Tan Sr.', NULL, '09171234517', 'Manila'),
(18, 'S2025-018', 'Maricar Roxas Sr.', NULL, '09171234518', 'Quezon City'),
(19, 'S2025-019', 'Kevin Mendoza Sr.', NULL, '09171234519', 'Caloocan City'),
(20, 'S2025-020', 'Grace Chua Sr.', NULL, '09171234520', 'Quezon City'),
(21, 'S2025-021', 'Paolo Cruz Sr.', NULL, '09171234521', 'Bulacan'),
(22, 'S2025-022', 'Liza Flores Sr.', NULL, '09171234522', 'Pasig City'),
(25, 'S2025-025', 'Roberto Morales Sr.', NULL, '09171234525', 'Quezon City'),
(29, 'S2025-013', 'Clarisse Bautista Sr.', NULL, '09171234513', 'Quezon City');

-- --------------------------------------------------------

--
-- Table structure for table `health_records`
--

CREATE TABLE `health_records` (
  `health_id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `checkup_date` date DEFAULT NULL,
  `health_status` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `referred_to_sps` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_records`
--

INSERT INTO `health_records` (`health_id`, `student_id`, `checkup_date`, `health_status`, `notes`, `referred_to_sps`) VALUES
(1, 'S2025-001', '2025-08-15', 'Healthy', 'Routine medical checkup. Cleared.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `login_audit`
--

CREATE TABLE `login_audit` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_type` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_audit`
--

INSERT INTO `login_audit` (`log_id`, `user_id`, `action_type`, `timestamp`) VALUES
(1, 2, 'logout', '2025-09-28 21:44:44'),
(2, 2, 'logout', '2025-09-28 21:51:06'),
(3, 2, 'logout', '2025-09-28 21:52:20'),
(4, 2, 'logout', '2025-09-28 22:09:14'),
(5, 3, 'login', '2025-09-28 22:13:17'),
(6, 3, 'logout', '2025-09-28 22:13:17'),
(7, 2, 'logout', '2025-09-29 06:46:49'),
(8, 4, 'logout', '2025-10-01 16:00:46'),
(9, 2, 'logout', '2025-10-01 16:02:10'),
(10, 2, 'logout', '2025-10-03 17:15:28'),
(11, 2, 'logout', '2025-10-03 18:48:48'),
(12, 2, 'logout', '2025-10-03 18:48:48'),
(13, 4, 'logout', '2025-10-03 18:53:06'),
(14, 4, 'logout', '2025-10-04 04:25:28'),
(15, 2, 'logout', '2025-10-04 05:38:02'),
(16, 4, 'logout', '2025-10-04 05:42:13'),
(17, 4, 'logout', '2025-10-04 05:46:25'),
(18, 2, 'logout', '2025-10-04 06:23:22'),
(19, 4, 'logout', '2025-10-04 06:28:53'),
(20, 4, 'logout', '2025-10-04 15:18:10'),
(21, 2, 'logout', '2025-10-04 16:54:31'),
(22, 4, 'logout', '2025-10-04 17:02:58'),
(23, 2, 'logout', '2025-10-04 18:21:53'),
(24, 2, 'logout', '2025-10-04 18:23:32'),
(25, 4, 'logout', '2025-10-04 18:24:21'),
(26, 2, 'logout', '2025-10-04 18:36:36'),
(27, 2, 'logout', '2025-10-05 10:40:33'),
(28, 2, 'logout', '2025-10-05 12:43:04'),
(29, 2, 'logout', '2025-10-05 16:07:33'),
(30, 4, 'logout', '2025-10-05 16:09:04'),
(31, 2, 'logout', '2025-10-09 04:36:12'),
(32, 1, 'logout', '2025-10-09 04:36:39'),
(33, 2, 'logout', '2025-10-09 05:14:05'),
(34, 4, 'logout', '2025-10-11 14:57:12'),
(35, 4, 'logout', '2025-10-11 17:47:16');

-- --------------------------------------------------------

--
-- Table structure for table `masterlists`
--

CREATE TABLE `masterlists` (
  `masterlist_id` int(11) NOT NULL,
  `term` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `program` varchar(255) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `year_level` int(11) DEFAULT NULL,
  `generated_by` int(11) DEFAULT NULL,
  `generation_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masterlists`
--

INSERT INTO `masterlists` (`masterlist_id`, `term`, `year`, `program`, `section`, `year_level`, `generated_by`, `generation_date`) VALUES
(14, '1st Sem', '2025-2026', 'BSIT', '11001', 1, 2, '2025-10-04 16:13:05');

-- --------------------------------------------------------

--
-- Table structure for table `masterlist_details`
--

CREATE TABLE `masterlist_details` (
  `id` int(11) NOT NULL,
  `masterlist_id` int(11) DEFAULT NULL,
  `student_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masterlist_details`
--

INSERT INTO `masterlist_details` (`id`, `masterlist_id`, `student_id`) VALUES
(22, 14, 'S2025-001'),
(23, 14, 'S2025-004'),
(24, 14, 'S2025-019'),
(25, 14, 'S2025-022'),
(26, 14, 'S2025-025');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `name`, `description`) VALUES
(1, 'Admin', 'Has full system access: manage users, view audit logs, system monitoring'),
(2, 'Employee', 'Registrar staff role: manage students, process requests, generate masterlists'),
(3, 'Student', 'Student role: view personal info, request documents, track status');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `program` varchar(50) NOT NULL,
  `year_level` int(11) DEFAULT NULL,
  `section` int(10) NOT NULL,
  `student_status` varchar(255) DEFAULT NULL,
  `photo_path` text DEFAULT NULL,
  `date_registered` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_id`, `first_name`, `last_name`, `birthdate`, `gender`, `program`, `year_level`, `section`, `student_status`, `photo_path`, `date_registered`, `email`, `contact_no`) VALUES
('S2025-001', 3, 'Juan Miguel', 'Dela Cruz', '2005-06-15', 'Male', 'BSIT', 1, 11001, 'Enrolled', '/components/img/ids/juan.jpg', '2025-06-01', 'student@example.com', '09123456789'),
('S2025-004', 4, 'Juan', 'Dela Cruz', '2005-03-14', 'Male', 'BSIT', 1, 11001, 'Enrolled', NULL, NULL, 'juan.dcruz@bcp.edu.ph', '09123450004'),
('S2025-005', 5, 'Maria', 'Santos', '2004-07-10', 'Female', 'BSA', 2, 21001, 'Enrolled', NULL, NULL, 'maria.santos@bcp.edu.ph', '09123450005'),
('S2025-006', 6, 'Carlos', 'Reyes', '2003-11-22', 'Male', 'BSBA', 3, 31001, 'Enrolled', '/components/img/ids/carlos.jpg', NULL, 'carlos.reyes@bcp.edu.ph', '09123450006'),
('S2025-007', 7, 'Angelica', 'Torres', '2005-02-05', 'Female', 'BSIT', 1, 11002, 'Enrolled', NULL, NULL, 'angelica.torres@bcp.edu.ph', '09123450007'),
('S2025-008', 8, 'Mark', 'Ramos', '2004-09-12', 'Male', 'BSA', 2, 21001, 'Enrolled', NULL, NULL, 'mark.ramos@bcp.edu.ph', '09123450008'),
('S2025-009', 9, 'Paula', 'Garcia', '2003-01-20', 'Female', 'BSIT', 3, 31001, 'Enrolled', 'S2025-009.jpeg', NULL, 'paula.garcia@bcp.edu.ph', '09123450009'),
('S2025-010', 10, 'John', 'Lim', '2005-05-14', 'Male', 'BSIT', 1, 11002, 'Enrolled', NULL, NULL, 'john.lim@bcp.edu.ph', '09123450010'),
('S2025-011', 11, 'Rose', 'Vergara', '2004-08-25', 'Female', 'BSA', 2, 21001, 'Enrolled', NULL, NULL, 'rose.vergara@bcp.edu.ph', '09123450011'),
('S2025-012', 12, 'Miguel', 'Dela Cruz', '2003-10-18', 'Male', 'BSBA', 3, 31001, 'Enrolled', NULL, NULL, 'miguel.delacruz@bcp.edu.ph', '09123450012'),
('S2025-013', NULL, 'Clarisse', 'Bautista', '2005-06-05', 'Female', 'BSIT', 1, 11002, 'Enrolled', 'S2025-013.png', NULL, NULL, NULL),
('S2025-014', 14, 'Patrick', 'Gonzales', '2004-01-15', 'Male', 'BSIT', 2, 21001, 'Enrolled', 'S2025-014.jpeg', NULL, 'patrick.gonzales@bcp.edu.ph', '09123450014'),
('S2025-015', 15, 'Samantha', 'Ong', '2003-08-09', 'Female', 'BSBA', 3, 31001, 'Enrolled', NULL, NULL, 'samantha.ong@bcp.edu.ph', '09123450015'),
('S2025-016', 16, 'Josephine', 'Castro', '2005-10-12', 'Female', 'BSCS', 1, 11002, 'Enrolled', 'S2025-016.jpg', NULL, 'josephine.castro@bcp.edu.ph', '09123450016'),
('S2025-017', 17, 'Edward', 'Tan', '2004-11-19', 'Male', 'BSHM', 2, 21001, 'Enrolled', 'S2025-017.jpeg', NULL, 'edward.tan@bcp.edu.ph', '09123450017'),
('S2025-018', 18, 'Maricar', 'Roxas', '2003-12-22', 'Female', 'BSBA', 3, 31001, 'Enrolled', NULL, NULL, 'maricar.roxas@bcp.edu.ph', '09123450018'),
('S2025-019', 19, 'Kevin', 'Mendoza', '2005-04-01', 'Male', 'BSIT', 1, 11001, 'Enrolled', NULL, NULL, 'kevin.mendoza@bcp.edu.ph', '09123450019'),
('S2025-020', 20, 'Grace', 'Chua', '2004-09-27', 'Female', 'BSIT', 2, 21001, 'Enrolled', NULL, NULL, 'grace.chua@bcp.edu.ph', '09123450020'),
('S2025-021', 21, 'Paolo', 'Cruz', '2003-03-30', 'Male', 'BSECE', 3, 31001, 'Enrolled', 'S2025-021.jpeg', NULL, 'paolo.cruz@bcp.edu.ph', '09123450021'),
('S2025-022', 22, 'Liza', 'Flores', '2005-06-14', 'Female', 'BSIT', 1, 11001, 'Enrolled', NULL, NULL, 'liza.flores@bcp.edu.ph', '09123450022'),
('S2025-025', 25, 'Roberto', 'Morales', '2005-12-05', 'Male', 'BSIT', 1, 11001, 'Enrolled', NULL, NULL, 'roberto.morales@bcp.edu.ph', '09123450025');

-- --------------------------------------------------------

--
-- Table structure for table `student_ids`
--

CREATE TABLE `student_ids` (
  `id_id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `qr_code` text DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `printed` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_ids`
--

INSERT INTO `student_ids` (`id_id`, `student_id`, `qr_code`, `issue_date`, `expiry_date`, `printed`) VALUES
(1, 'S2025-001', 'QR123456789', '2025-06-05', '2029-06-05', 1),
(4, 'S2025-020', 'ID: S2025-020\nName: Grace Chua\nProgram: 0\nYear: 2 Section: 21001\nGuardian: Paolo (092312132131)\nAddress: dtioasdas', '2025-10-04', '2026-10-04', 0),
(5, 'S2025-021', 'ID: S2025-021\nName: Paolo Cruz\nProgram: 0\nYear: 3 Section: 31001\nGuardian:  ()\nAddress: ', '2025-10-04', '2026-10-04', 0),
(6, 'S2025-004', 'ID: S2025-004\nName: Juan Dela Cruz\nProgram: BSIT\nYear: 1 Section: 11001\nGuardian:  ()\nAddress: ', '2025-10-04', '2026-10-04', 0),
(7, 'S2025-012', 'ID: S2025-012\nName: Miguel Dela Cruz\nProgram: BSBA\nYear: 3 Section: 31001\nGuardian:  ()\nAddress: ', '2025-10-04', '2026-10-04', 0),
(8, 'S2025-022', 'ID: S2025-022\nName: Liza Flores\nProgram: BSIT\nYear: 1 Section: 11001\nGuardian:  ()\nAddress: ', '2025-10-04', '2026-10-04', 0),
(9, 'S2025-009', 'ID: S2025-009\nName: Paula Garcia\nProgram: BSBA\nYear: 3 Section: 31001\nGuardian:  ()\nAddress: ', '2025-10-04', '2026-10-04', 0),
(10, 'S2025-014', 'ID: S2025-014\nName: Patrick Gonzales\nProgram: BSA\nYear: 2 Section: 21001\nGuardian:  ()\nAddress: ', '2025-10-04', '2026-10-04', 0),
(12, 'S2025-010', '../components/img/QR/S2025-010.png', '2025-10-04', '2026-10-04', 0),
(13, 'S2025-019', '../components/img/QR/S2025-019.png', '2025-10-04', '2026-10-04', 0),
(14, 'S2025-025', '../components/img/QR/S2025-025.png', '2025-10-04', '2026-10-04', 0),
(15, 'S2025-015', '../components/img/QR/S2025-015.png', '2025-10-04', '2026-10-04', 0),
(16, 'S2025-008', '../components/img/QR/S2025-008.png', '2025-10-04', '2026-10-04', 0),
(17, 'S2025-006', '../components/img/QR/S2025-006.png', '2025-10-04', '2026-10-04', 0),
(18, 'S2025-018', '../components/img/QR/S2025-018.png', '2025-10-04', '2026-10-04', 0),
(19, 'S2025-005', '../components/img/QR/S2025-005.png', '2025-10-04', '2026-10-04', 0),
(20, 'S2025-017', '../components/img/QR/S2025-017.png', '2025-10-04', '2026-10-04', 0),
(21, 'S2025-007', '../components/img/QR/S2025-007.png', '2025-10-04', '2026-10-04', 0),
(23, 'S2025-011', '../components/img/QR/S2025-011.png', '2025-10-04', '2026-10-04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_status_history`
--

CREATE TABLE `student_status_history` (
  `status_id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `status_type` varchar(255) DEFAULT NULL,
  `changed_by` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_status_history`
--

INSERT INTO `student_status_history` (`status_id`, `student_id`, `status_type`, `changed_by`, `timestamp`) VALUES
(1, 'S2025-001', 'Enrolled', 2, '2025-09-28 22:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `units` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `units`, `type`) VALUES
(1, 'Database Systems', 3, 'Major'),
(2, 'Web Development', 3, 'Major'),
(3, 'Physical Education 1', 2, 'Minor');

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `syslog_id` int(11) NOT NULL,
  `level` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`syslog_id`, `level`, `message`, `origin`, `user_id`, `timestamp`) VALUES
(1, 'INFO', 'Student record updated successfully.', 'staff/Enrollment.php', 2, '2025-09-28 22:13:17'),
(2, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-09 04:33:02'),
(3, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-09 04:35:35'),
(4, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-09 04:35:49'),
(5, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-09 04:44:11'),
(6, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-09 04:45:10'),
(7, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-09 04:45:24'),
(8, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-09 04:48:31'),
(9, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-09 04:48:40'),
(10, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-09 04:49:56'),
(11, 'INFO', 'Updated student photo for S2025-024', 'staff/StudentInfo.php', 2, '2025-10-09 04:50:28'),
(12, 'INFO', 'Updated personal details for Isabella Lee (ID: S2025-024)', 'staff/StudentInfo.php', 2, '2025-10-09 04:50:28'),
(13, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-09 04:50:57'),
(14, 'INFO', 'Updated student photo for S2025-021', 'staff/StudentInfo.php', 2, '2025-10-09 04:51:20'),
(15, 'INFO', 'Updated personal details for Paolo Cruz (ID: S2025-021)', 'staff/StudentInfo.php', 2, '2025-10-09 04:51:20'),
(16, 'INFO', 'Archived student Isabella Lee (ID: S2025-024) as Dropped', 'staff/StudentInfo.php', 2, '2025-10-09 05:14:02'),
(17, 'INFO', 'Updated personal details for Edward Tan (ID: S2025-017)', 'staff/StudentInfo.php', 1, '2025-10-09 05:23:39'),
(18, 'INFO', 'Updated student photo for S2025-017', 'staff/StudentInfo.php', 1, '2025-10-09 05:27:20'),
(19, 'INFO', 'Updated student photo for S2025-023', 'staff/StudentInfo.php', 1, '2025-10-09 05:27:54'),
(20, 'INFO', 'Updated personal details for Richard Uy (ID: S2025-023)', 'staff/StudentInfo.php', 1, '2025-10-09 05:27:54'),
(21, 'INFO', 'Archived student Richard Uy (ID: S2025-023) as Dropped', 'staff/StudentInfo.php', 1, '2025-10-09 05:32:05'),
(22, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-11 15:01:43'),
(23, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-11 15:15:41'),
(24, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-11 15:16:36'),
(25, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-11 15:19:12'),
(26, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-11 15:24:26'),
(27, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-11 15:29:48'),
(28, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-11 15:33:32'),
(29, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-11 15:44:15'),
(30, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-11 15:52:45'),
(31, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 2, '2025-10-11 15:58:34'),
(32, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 1, '2025-10-11 16:02:23'),
(33, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 1, '2025-10-11 16:02:25'),
(34, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 1, '2025-10-11 16:02:27'),
(35, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 1, '2025-10-11 16:02:29'),
(36, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 1, '2025-10-11 16:02:30'),
(37, 'INFO', 'Updated student photo for S2025-016', 'staff/StudentInfo.php', 1, '2025-10-11 16:02:31'),
(38, 'INFO', 'Updated student photo for S2025-009', 'staff/StudentInfo.php', 2, '2025-10-11 16:08:30'),
(39, 'INFO', 'Updated personal details for Paula Garcia (ID: S2025-009)', 'staff/StudentInfo.php', 2, '2025-10-11 16:08:30'),
(40, 'INFO', 'Updated student photo for S2025-014', 'staff/StudentInfo.php', 1, '2025-10-11 16:10:27'),
(41, 'INFO', 'Updated personal details for Patrick Gonzales (ID: S2025-014)', 'staff/StudentInfo.php', 1, '2025-10-11 16:10:27'),
(42, 'INFO', 'Updated student photo for S2025-017', 'staff/StudentInfo.php', 2, '2025-10-11 16:11:15'),
(43, 'INFO', 'Updated student photo for S2025-017', 'staff/StudentInfo.php', 2, '2025-10-11 16:13:28'),
(44, 'INFO', 'Uploaded new student photo for S2025-017', 'staff/StudentInfo.php', 2, '2025-10-11 16:16:50'),
(45, 'INFO', 'Uploaded document \'ID\' for Clarisse Bautista (ID: S2025-013)', 'staff/upload_student_file.php', 2, '2025-10-11 16:22:33'),
(46, 'INFO', 'Uploaded document \'Medical\' for Clarisse Bautista (ID: S2025-013)', 'staff/upload_student_file.php', 1, '2025-10-11 16:27:33'),
(47, 'INFO', 'Archived student Clarisse Bautista (ID: S2025-013) and all related records (status: Graduated).', 'staff/StudentInfo.php', 1, '2025-10-11 17:03:56'),
(48, 'INFO', 'Recovered archived student S2025-013 and all related records.', 'admin/ArchivedStudents.php', 1, '2025-10-11 17:15:00'),
(49, 'INFO', 'Archived student Clarisse Bautista (ID: S2025-013) and all related records (status: Graduated).', 'staff/StudentInfo.php', 1, '2025-10-11 17:15:35'),
(50, 'INFO', 'Recovered archived student S2025-013 and all related records.', 'admin/ArchivedStudents.php', 1, '2025-10-11 17:27:29'),
(51, 'INFO', 'Updated personal details for Clarisse Bautista (ID: S2025-013)', 'staff/StudentInfo.php', 1, '2025-10-11 17:27:41'),
(52, 'INFO', 'Uploaded document \'ID\' for Clarisse Bautista (ID: S2025-013)', 'staff/upload_student_file.php', 1, '2025-10-11 17:27:58'),
(53, 'INFO', 'Archived student Clarisse Bautista (S2025-013) as Graduated', 'staff/StudentInfo.php', 1, '2025-10-11 17:30:15'),
(54, 'INFO', 'Recovered archived student S2025-013 and all related records.', 'admin/ArchivedStudents.php', 1, '2025-10-11 17:36:14'),
(55, 'INFO', 'Archived student Clarisse Bautista (S2025-013) as Graduated', 'staff/StudentInfo.php', 1, '2025-10-11 17:38:04'),
(56, 'INFO', 'Recovered archived student S2025-013 and all related records.', 'admin/ArchivedStudents.php', 1, '2025-10-11 17:38:26'),
(57, 'INFO', 'Archived student Clarisse Bautista (S2025-013) as Graduated', 'staff/StudentInfo.php', 2, '2025-10-11 17:43:48'),
(58, 'INFO', 'Recovered archived student S2025-013 and all related records.', 'admin/ArchivedStudents.php', 1, '2025-10-11 17:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` text DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `role_id`, `active`) VALUES
(1, 'admin1', 'admin@example.com', '123456', 1, 1),
(2, 'employee1', 'employee@example.com', '123456', 2, 1),
(3, 'student1', 'student@example.com', '123456', 3, 1),
(4, 'juan.dcruz', 'juan.dcruz@bcp.edu.ph', '123456', 3, 1),
(5, 'maria.santos', 'maria.santos@bcp.edu.ph', '123456', 3, 1),
(6, 'carlos.reyes', 'carlos.reyes@bcp.edu.ph', '123456', 3, 1),
(7, 'angelica.torres', 'angelica.torres@bcp.edu.ph', '123456', 3, 1),
(8, 'mark.ramos', 'mark.ramos@bcp.edu.ph', '123456', 3, 1),
(9, 'paula.garcia', 'paula.garcia@bcp.edu.ph', '123456', 3, 1),
(10, 'john.lim', 'john.lim@bcp.edu.ph', '123456', 3, 1),
(11, 'rose.vergara', 'rose.vergara@bcp.edu.ph', '123456', 3, 1),
(12, 'miguel.delacruz', 'miguel.delacruz@bcp.edu.ph', '123456', 3, 1),
(13, 'clarisse.bautista', 'clarisse.bautista@bcp.edu.ph', '123456', 3, 1),
(14, 'patrick.gonzales', 'patrick.gonzales@bcp.edu.ph', '123456', 3, 1),
(15, 'samantha.ong', 'samantha.ong@bcp.edu.ph', '123456', 3, 1),
(16, 'josephine.castro', 'josephine.castro@bcp.edu.ph', '123456', 3, 1),
(17, 'edward.tan', 'edward.tan@bcp.edu.ph', '123456', 3, 1),
(18, 'maricar.roxas', 'maricar.roxas@bcp.edu.ph', '123456', 3, 1),
(19, 'kevin.mendoza', 'kevin.mendoza@bcp.edu.ph', '123456', 3, 1),
(20, 'grace.chua', 'grace.chua@bcp.edu.ph', '123456', 3, 1),
(21, 'paolo.cruz', 'paolo.cruz@bcp.edu.ph', '123456', 3, 1),
(22, 'liza.flores', 'liza.flores@bcp.edu.ph', '123456', 3, 1),
(23, 'richard.uy', 'richard.uy@bcp.edu.ph', '123456', 3, 1),
(24, 'isabella.lee', 'isabella.lee@bcp.edu.ph', '123456', 3, 1),
(25, 'roberto.morales', 'roberto.morales@bcp.edu.ph', '123456', 3, 1),
(26, 'andrea.soriano', 'andrea.soriano@bcp.edu.ph', '123456', 3, 1),
(27, 'gabriel.perez', 'gabriel.perez@bcp.edu.ph', '123456', 3, 1),
(28, 'christine.yap', 'christine.yap@bcp.edu.ph', '123456', 3, 1),
(29, 'darren.valdez', 'darren.valdez@bcp.edu.ph', '123456', 3, 1),
(30, 'roxanne.lopez', 'roxanne.lopez@bcp.edu.ph', '123456', 3, 1),
(31, 'samuel.villanueva', 'samuel.villanueva@bcp.edu.ph', '123456', 3, 1),
(32, 'kimberly.diaz', 'kimberly.diaz@bcp.edu.ph', '123456', 3, 1),
(33, 'jonathan.cruz', 'jonathan.cruz@bcp.edu.ph', '123456', 3, 1),
(34, 'micaela.alvarez', 'micaela.alvarez@bcp.edu.ph', '123456', 3, 1),
(35, 'ryan.santos', 'ryan.santos@bcp.edu.ph', '123456', 3, 1),
(36, 'nicole.gomez', 'nicole.gomez@bcp.edu.ph', '123456', 3, 1),
(37, 'leo.delosreyes', 'leo.delosreyes@bcp.edu.ph', '123456', 3, 1),
(38, 'sophia.manalo', 'sophia.manalo@bcp.edu.ph', '123456', 3, 1),
(39, 'francis.torralba', 'francis.torralba@bcp.edu.ph', '123456', 3, 1),
(40, 'danica.estrada', 'danica.estrada@bcp.edu.ph', '123456', 3, 1),
(41, 'victor.rivera', 'victor.rivera@bcp.edu.ph', '123456', 3, 1),
(42, 'roxan.santiago', 'roxan.santiago@bcp.edu.ph', '123456', 3, 1),
(43, 'camille.guevarra', 'camille.guevarra@bcp.edu.ph', '123456', 3, 1),
(44, 'adrian.navarro', 'adrian.navarro@bcp.edu.ph', '123456', 3, 1),
(45, 'karla.pascual', 'karla.pascual@bcp.edu.ph', '123456', 3, 1),
(46, 'jerome.francisco', 'jerome.francisco@bcp.edu.ph', '123456', 3, 1),
(47, 'trisha.cortez', 'trisha.cortez@bcp.edu.ph', '123456', 3, 1),
(48, 'allan.vargas', 'allan.vargas@bcp.edu.ph', '123456', 3, 1),
(49, 'helen.rosario', 'helen.rosario@bcp.edu.ph', '123456', 3, 1),
(50, 'cesar.montoya', 'cesar.montoya@bcp.edu.ph', '123456', 3, 1),
(51, 'alyssa.lorenzo', 'alyssa.lorenzo@bcp.edu.ph', '123456', 3, 1),
(52, 'dennis.quintos', 'dennis.quintos@bcp.edu.ph', '123456', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_background`
--
ALTER TABLE `academic_background`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student` (`student_id`);

--
-- Indexes for table `academic_records`
--
ALTER TABLE `academic_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `archived_academic_background`
--
ALTER TABLE `archived_academic_background`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student` (`student_id`);

--
-- Indexes for table `archived_file_storage`
--
ALTER TABLE `archived_file_storage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `archived_guardians`
--
ALTER TABLE `archived_guardians`
  ADD PRIMARY KEY (`guardian_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `archived_students`
--
ALTER TABLE `archived_students`
  ADD PRIMARY KEY (`archive_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `document_requests`
--
ALTER TABLE `document_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `file_storage`
--
ALTER TABLE `file_storage`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`guardian_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `health_records`
--
ALTER TABLE `health_records`
  ADD PRIMARY KEY (`health_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `login_audit`
--
ALTER TABLE `login_audit`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `masterlists`
--
ALTER TABLE `masterlists`
  ADD PRIMARY KEY (`masterlist_id`),
  ADD KEY `generated_by` (`generated_by`);

--
-- Indexes for table `masterlist_details`
--
ALTER TABLE `masterlist_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `masterlist_id` (`masterlist_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `fk_students_users` (`user_id`);

--
-- Indexes for table `student_ids`
--
ALTER TABLE `student_ids`
  ADD PRIMARY KEY (`id_id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `student_status_history`
--
ALTER TABLE `student_status_history`
  ADD PRIMARY KEY (`status_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `changed_by` (`changed_by`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`syslog_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_background`
--
ALTER TABLE `academic_background`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `academic_records`
--
ALTER TABLE `academic_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `archived_academic_background`
--
ALTER TABLE `archived_academic_background`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `archived_file_storage`
--
ALTER TABLE `archived_file_storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `archived_guardians`
--
ALTER TABLE `archived_guardians`
  MODIFY `guardian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `archived_students`
--
ALTER TABLE `archived_students`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `document_requests`
--
ALTER TABLE `document_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `file_storage`
--
ALTER TABLE `file_storage`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `guardian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `health_records`
--
ALTER TABLE `health_records`
  MODIFY `health_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login_audit`
--
ALTER TABLE `login_audit`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `masterlists`
--
ALTER TABLE `masterlists`
  MODIFY `masterlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `masterlist_details`
--
ALTER TABLE `masterlist_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_ids`
--
ALTER TABLE `student_ids`
  MODIFY `id_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `student_status_history`
--
ALTER TABLE `student_status_history`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `syslog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic_background`
--
ALTER TABLE `academic_background`
  ADD CONSTRAINT `academic_background_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;

--
-- Constraints for table `academic_records`
--
ALTER TABLE `academic_records`
  ADD CONSTRAINT `academic_records_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `academic_records_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

--
-- Constraints for table `archived_file_storage`
--
ALTER TABLE `archived_file_storage`
  ADD CONSTRAINT `archived_file_storage_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `archived_students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `document_requests`
--
ALTER TABLE `document_requests`
  ADD CONSTRAINT `document_requests_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `file_storage`
--
ALTER TABLE `file_storage`
  ADD CONSTRAINT `file_storage_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `file_storage_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `guardians`
--
ALTER TABLE `guardians`
  ADD CONSTRAINT `guardians_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `health_records`
--
ALTER TABLE `health_records`
  ADD CONSTRAINT `health_records_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `login_audit`
--
ALTER TABLE `login_audit`
  ADD CONSTRAINT `login_audit_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `masterlists`
--
ALTER TABLE `masterlists`
  ADD CONSTRAINT `masterlists_ibfk_1` FOREIGN KEY (`generated_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `masterlist_details`
--
ALTER TABLE `masterlist_details`
  ADD CONSTRAINT `masterlist_details_ibfk_1` FOREIGN KEY (`masterlist_id`) REFERENCES `masterlists` (`masterlist_id`),
  ADD CONSTRAINT `masterlist_details_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_students_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_ids`
--
ALTER TABLE `student_ids`
  ADD CONSTRAINT `student_ids_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_status_history`
--
ALTER TABLE `student_status_history`
  ADD CONSTRAINT `student_status_history_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `student_status_history_ibfk_2` FOREIGN KEY (`changed_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD CONSTRAINT `system_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
--
-- Database: `vpmsdb`
--
CREATE DATABASE IF NOT EXISTS `vpmsdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `vpmsdb`;

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` varchar(120) DEFAULT NULL,
  `UserName` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 7898799798, 'tester1@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2024-05-01 05:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `ID` int(10) NOT NULL,
  `VehicleCat` varchar(120) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`ID`, `VehicleCat`, `CreationDate`) VALUES
(1, 'Four Wheeler Vehicle', '2024-05-03 11:06:50'),
(2, 'Two Wheeler Vehicle', '2024-05-03 11:06:50'),
(4, 'Bicycles', '2024-05-03 11:06:50'),
(6, 'Electric Vehicle', '2024-08-16 06:41:40'),
(8, 'habal', '2024-09-13 13:16:26');

-- --------------------------------------------------------

--
-- Table structure for table `tblregusers`
--

CREATE TABLE `tblregusers` (
  `ID` int(5) NOT NULL,
  `FirstName` varchar(250) DEFAULT NULL,
  `LastName` varchar(250) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(250) DEFAULT NULL,
  `Password` varchar(250) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblregusers`
--

INSERT INTO `tblregusers` (`ID`, `FirstName`, `LastName`, `MobileNumber`, `Email`, `Password`, `RegDate`) VALUES
(2, 'Anuj', 'Kumar', 1234567890, 'ak@gmail.com', '', '2024-06-01 18:05:56'),
(3, 'marc', 'lloyd', 912800000, 'janinerfcastil0@gmail.com', '9bb5eea73305a524ed39c891c8edd015', '2024-09-21 05:35:39'),
(4, 'marc', 'lloyd', 911111111, 'kaka@gmail.com', 'e807f1fcf82d132f9bb018ca6738a19f', '2024-10-22 04:47:36');

-- --------------------------------------------------------

--
-- Table structure for table `tblvehicle`
--

CREATE TABLE `tblvehicle` (
  `ID` int(10) NOT NULL,
  `ParkingNumber` varchar(120) DEFAULT NULL,
  `VehicleCategory` varchar(120) NOT NULL,
  `VehicleCompanyname` varchar(120) DEFAULT NULL,
  `RegistrationNumber` varchar(120) DEFAULT NULL,
  `OwnerName` varchar(120) DEFAULT NULL,
  `OwnerContactNumber` bigint(10) DEFAULT NULL,
  `InTime` timestamp NULL DEFAULT current_timestamp(),
  `OutTime` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `ParkingCharge` varchar(120) NOT NULL,
  `Remark` mediumtext NOT NULL,
  `Status` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblvehicle`
--

INSERT INTO `tblvehicle` (`ID`, `ParkingNumber`, `VehicleCategory`, `VehicleCompanyname`, `RegistrationNumber`, `OwnerName`, `OwnerContactNumber`, `InTime`, `OutTime`, `ParkingCharge`, `Remark`, `Status`) VALUES
(1, '125061388', 'Electric Vehicle', 'Tata Nexon', 'DL8CAS1234', 'Amit', 1233211230, '2024-08-16 06:42:36', '2024-08-16 06:43:43', '50', 'NA', 'Out'),
(2, '787303637', 'Two Wheeler Vehicle', 'Honda Actvia', 'UP81AN4851', 'Anuj kumar', 1234567890, '2024-08-16 06:47:23', '2024-08-16 06:48:26', '20', 'NA', 'Out'),
(3, '901288727', 'Four Wheeler Vehicle', 'Hyundai i10', 'Dl6CAs1234', 'Anuj Kumar', 1234567890, '2024-08-16 06:58:34', '2024-08-19 15:26:24', '50', 'going out\r\n', 'Out'),
(4, '264544320', 'Four Wheeler Vehicle', 'suzuki', '23hr34', 'marc', 934019434, '2024-08-19 15:25:17', '2024-08-21 09:41:35', '50', 'd', 'Out'),
(5, '635506365', 'Four Wheeler Vehicle', 'ford', '546hda', 'lloyd', 93424532, '2024-08-19 15:27:46', '2024-08-21 10:44:16', '50', 'out', 'Out'),
(6, '587812705', 'Four Wheeler Vehicle', 'eqwre', '324ee', 'feqe', 123, '2024-09-12 03:00:21', '2024-09-12 03:02:45', '50', 'GA', 'Out'),
(9, '153109551', 'Four Wheeler Vehicle', 'suzuki', '546hda', 'marc', 934019434, '2024-10-12 05:58:03', '2024-10-12 05:59:40', '50', 'kupal', 'Out'),
(10, '705898486', 'Four Wheeler Vehicle', 'suzuki', '546hda', 'deleon', 934019434, '2024-10-12 06:11:34', '2024-10-12 08:48:14', '50', 'fe', 'Out'),
(11, '569879028', '0', 'suzuki', '546hda', 'deleon', 934019434, '2024-10-12 08:53:15', NULL, '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `VehicleCat` (`VehicleCat`);

--
-- Indexes for table `tblregusers`
--
ALTER TABLE `tblregusers`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `MobileNumber` (`MobileNumber`);

--
-- Indexes for table `tblvehicle`
--
ALTER TABLE `tblvehicle`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblregusers`
--
ALTER TABLE `tblregusers`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblvehicle`
--
ALTER TABLE `tblvehicle`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
