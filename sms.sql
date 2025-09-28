-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2025 at 12:21 AM
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
-- Table structure for table `document_requests`
--

CREATE TABLE `document_requests` (
  `request_id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `document_type` varchar(255) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_requests`
--

INSERT INTO `document_requests` (`request_id`, `student_id`, `document_type`, `request_date`, `status`, `release_date`) VALUES
(1, 'S2025-001', 'Certificate of Enrollment', '2025-09-01', 'Released', '2025-09-05');

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
(1, 'S2025-001', 'Enrollment Form', '/uploads/docs/enrollment_form.pdf', 2, '2025-09-28 22:13:17');

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
(1, 'S2025-001', 'Maria Dela Cruz', 'Mother', '09987654321', 'Quezon City, Metro Manila');

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
(6, 3, 'logout', '2025-09-28 22:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `masterlists`
--

CREATE TABLE `masterlists` (
  `masterlist_id` int(11) NOT NULL,
  `term` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `program` varchar(255) DEFAULT NULL,
  `generated_by` int(11) DEFAULT NULL,
  `generation_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masterlists`
--

INSERT INTO `masterlists` (`masterlist_id`, `term`, `year`, `program`, `generated_by`, `generation_date`) VALUES
(1, '1st Sem', '2025-2026', 'BSIT', 2, '2025-09-28 22:13:17');

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
(1, 1, 'S2025-001');

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
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `program` varchar(255) DEFAULT NULL,
  `year_level` int(11) DEFAULT NULL,
  `student_status` varchar(255) DEFAULT NULL,
  `photo_path` text DEFAULT NULL,
  `date_registered` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `birthdate`, `gender`, `program`, `year_level`, `student_status`, `photo_path`, `date_registered`, `email`, `contact_no`) VALUES
('S2025-001', 'Juan', 'Dela Cruz', '2005-06-15', 'Male', 'BSIT', 1, 'Enrolled', '/uploads/photos/juan.png', '2025-06-01', 'student1@example.com', '09123456789');

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
(1, 'S2025-001', 'QR123456789', '2025-06-05', '2029-06-05', 1);

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
(1, 'INFO', 'Student record updated successfully.', 'staff/Enrollment.php', 2, '2025-09-28 22:13:17');

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
(3, 'student1', 'student@example.com', '123456', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_records`
--
ALTER TABLE `academic_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

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
  ADD PRIMARY KEY (`student_id`);

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
-- AUTO_INCREMENT for table `academic_records`
--
ALTER TABLE `academic_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `document_requests`
--
ALTER TABLE `document_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `file_storage`
--
ALTER TABLE `file_storage`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `guardian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `health_records`
--
ALTER TABLE `health_records`
  MODIFY `health_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login_audit`
--
ALTER TABLE `login_audit`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `masterlists`
--
ALTER TABLE `masterlists`
  MODIFY `masterlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `masterlist_details`
--
ALTER TABLE `masterlist_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_ids`
--
ALTER TABLE `student_ids`
  MODIFY `id_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `syslog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `student_ids`
--
ALTER TABLE `student_ids`
  ADD CONSTRAINT `student_ids_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

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
