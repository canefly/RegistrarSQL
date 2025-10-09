-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2025 at 07:34 AM
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
-- Database: `sms`
--

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
(11, 'S2025-013', 'Bocaue Elementary School', '2018', 'Bocaue National High School', '2024', 'Bestlink College of the Philippines', '2024'),
(12, 'S2025-014', 'Sta. Maria Elementary School', '2018', 'Sta. Maria High School', '2024', 'Bestlink College of the Philippines', '2024'),
(13, 'S2025-015', 'Balagtas Elementary School', '2018', 'Balagtas National High School', '2024', 'Bestlink College of the Philippines', '2024'),
(14, 'S2025-016', 'Baliuag Elementary School', '2018', 'Baliuag National High School', '2024', 'Bestlink College of the Philippines', '2024'),
(15, 'S2025-017', 'Plaridel Elementary School', '2018', 'Plaridel National High School', '2024', 'Bestlink College of the Philippines', '2024'),
(16, 'S2025-018', 'Pandi Elementary School', '2018', 'Pandi National High School', '2024', 'Bestlink College of the Philippines', '2024'),
(17, 'S2025-019', 'Meycauayan Elementary School', '2019', 'Meycauayan National High School', '2025', 'Bestlink College of the Philippines', '2025'),
(18, 'S2025-020', 'Obando Elementary School', '2019', 'Obando National High School', '2025', 'Bestlink College of the Philippines', '2025'),
(19, 'S2025-021', 'San Rafael Elementary School', '2019', 'San Rafael National High School', '2025', 'Bestlink College of the Philippines', '2025'),
(20, 'S2025-022', 'San Jose Elementary School', '2019', 'San Jose National High School', '2025', 'Bestlink College of the Philippines', '2025'),
(23, 'S2025-025', 'Guiguinto Elementary School', '2019', 'Guiguinto National High School', '2025', 'Bestlink College of the Philippines', '2025');

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
  `photo_path` text DEFAULT NULL,
  `archived_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archived_students`
--

INSERT INTO `archived_students` (`archive_id`, `student_id`, `first_name`, `last_name`, `program`, `year_level`, `section`, `student_status`, `contact_no`, `address`, `birthdate`, `photo_path`, `archived_date`) VALUES
(3, 'S2025-024', 'Isabella', 'Lee', '0', 3, '31001', 'Dropped', '09123450024', NULL, '2003-09-01', 'S2025-024.jpg', '2025-10-09 05:14:02'),
(6, 'S2025-023', 'Richard', 'Uy', '0', 2, '21001', 'Dropped', NULL, NULL, NULL, 'S2025-023.jpg', '2025-10-09 05:32:05');

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
(4, 'S2025-001', 'ID', '/uploads/docs/1759661396_ID.pdf', 2, '2025-10-05 10:49:56');

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
(13, 'S2025-013', 'Clarisse Bautista Sr.', NULL, '09171234513', 'Quezon City'),
(14, 'S2025-014', 'Patrick Gonzales Sr.', NULL, '09171234514', 'Bulacan'),
(15, 'S2025-015', 'Samantha Ong Sr.', NULL, '09171234515', 'Caloocan City'),
(16, 'S2025-016', 'Josephine Castro Sr.', NULL, '09171234516', 'Pasig City'),
(17, 'S2025-017', 'Edward Tan Sr.', NULL, '09171234517', 'Manila'),
(18, 'S2025-018', 'Maricar Roxas Sr.', NULL, '09171234518', 'Quezon City'),
(19, 'S2025-019', 'Kevin Mendoza Sr.', NULL, '09171234519', 'Caloocan City'),
(20, 'S2025-020', 'Grace Chua Sr.', NULL, '09171234520', 'Quezon City'),
(21, 'S2025-021', 'Paolo Cruz Sr.', NULL, '09171234521', 'Bulacan'),
(22, 'S2025-022', 'Liza Flores Sr.', NULL, '09171234522', 'Pasig City'),
(25, 'S2025-025', 'Roberto Morales Sr.', NULL, '09171234525', 'Quezon City');

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
(33, 2, 'logout', '2025-10-09 05:14:05');

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
('S2025-009', 9, 'Paula', 'Garcia', '2003-01-20', 'Female', 'BSBA', 3, 31001, 'Enrolled', NULL, NULL, 'paula.garcia@bcp.edu.ph', '09123450009'),
('S2025-010', 10, 'John', 'Lim', '2005-05-14', 'Male', 'BSIT', 1, 11002, 'Enrolled', NULL, NULL, 'john.lim@bcp.edu.ph', '09123450010'),
('S2025-011', 11, 'Rose', 'Vergara', '2004-08-25', 'Female', 'BSA', 2, 21001, 'Enrolled', NULL, NULL, 'rose.vergara@bcp.edu.ph', '09123450011'),
('S2025-012', 12, 'Miguel', 'Dela Cruz', '2003-10-18', 'Male', 'BSBA', 3, 31001, 'Enrolled', NULL, NULL, 'miguel.delacruz@bcp.edu.ph', '09123450012'),
('S2025-013', 13, 'Clarisse', 'Bautista', '2005-06-05', 'Female', 'BSIT', 1, 11002, 'Enrolled', 'S2025-013.png', NULL, 'clarisse.bautista@bcp.edu.ph', '09123450013'),
('S2025-014', 14, 'Patrick', 'Gonzales', '2004-01-15', 'Male', 'BSA', 2, 21001, 'Enrolled', NULL, NULL, 'patrick.gonzales@bcp.edu.ph', '09123450014'),
('S2025-015', 15, 'Samantha', 'Ong', '2003-08-09', 'Female', 'BSBA', 3, 31001, 'Enrolled', NULL, NULL, 'samantha.ong@bcp.edu.ph', '09123450015'),
('S2025-016', 16, 'Josephine', 'Castro', '2005-10-12', 'Female', 'BSCS', 1, 11002, 'Enrolled', NULL, NULL, 'josephine.castro@bcp.edu.ph', '09123450016'),
('S2025-017', 17, 'Edward', 'Tan', '2004-11-19', 'Male', 'BSHM', 2, 21001, 'Enrolled', '', NULL, 'edward.tan@bcp.edu.ph', '09123450017'),
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
(2, 'S2025-013', 'ID: S2025-013\nName: Clarisse Bautista\nProgram: 0\nYear: 1 Section: 11002\nGuardian:  ()\nAddress: ', '2025-10-04', '2026-10-04', 0),
(3, 'S2025-016', 'ID: S2025-016\nName: Josephine Castro\nProgram: BSIT\nYear: 1 Section: 11002\nGuardian:  ()\nAddress: ', '2025-10-04', '2026-10-04', 0),
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
(21, 'INFO', 'Archived student Richard Uy (ID: S2025-023) as Dropped', 'staff/StudentInfo.php', 1, '2025-10-09 05:32:05');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `academic_records`
--
ALTER TABLE `academic_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `archived_students`
--
ALTER TABLE `archived_students`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `document_requests`
--
ALTER TABLE `document_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `file_storage`
--
ALTER TABLE `file_storage`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `guardian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `health_records`
--
ALTER TABLE `health_records`
  MODIFY `health_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login_audit`
--
ALTER TABLE `login_audit`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
  MODIFY `syslog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
