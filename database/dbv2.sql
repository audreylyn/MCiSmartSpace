SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS my_db;
CREATE DATABASE IF NOT EXISTS my_db;

-- Use the created database
USE my_db;

-- Create the roles table
CREATE TABLE `roles` (
  `RoleID` INT NOT NULL AUTO_INCREMENT,
  `RoleName` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`RoleID`)
);

-- Insert roles
INSERT INTO `roles` (`RoleID`, `RoleName`) VALUES
(1, 'Registrar'),
(2, 'Department Admin'),
(3, 'Teacher'),
(4, 'Student');

-- Create the registrar table
CREATE TABLE `registrar` (
  `regid` INT NOT NULL AUTO_INCREMENT,
  `Reg_Email` VARCHAR(50) NOT NULL,
  `Reg_Password` VARCHAR(255) NOT NULL, 
  PRIMARY KEY (`regid`)
);

-- Initial admin data for registrar
INSERT INTO `registrar` (`regid`, `Reg_Email`, `Reg_Password`) VALUES
(1, 'registrar@gmail.com', '1234'); 

-- Create the department admin table
CREATE TABLE `dept_admin` (
  `AdminID` INT NOT NULL AUTO_INCREMENT,
  `FirstName` VARCHAR(50) NOT NULL,
  `LastName` VARCHAR(50) NOT NULL,
  `Department` VARCHAR(50) NOT NULL,
  `Email` VARCHAR(50) NOT NULL,
  `Password` VARCHAR(255) NOT NULL, 
  PRIMARY KEY (`AdminID`)
);

-- Create buildings table (moved before rooms for proper referencing)
CREATE TABLE `buildings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `building_name` VARCHAR(255) NOT NULL,
    `department` VARCHAR(255) NOT NULL,
    `number_of_floors` INT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create rooms table
CREATE TABLE `rooms` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `room_name` VARCHAR(255) NOT NULL,
    `room_type` VARCHAR(255) NOT NULL,
    `capacity` INT NOT NULL,
    `RoomStatus` ENUM('available', 'occupied', 'maintenance') DEFAULT 'available',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `building_id` INT,
    FOREIGN KEY (`building_id`) REFERENCES `buildings`(`id`) ON DELETE SET NULL
);

-- Create equipment table (moved before room_equipment for proper referencing)
CREATE TABLE `equipment` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `category` VARCHAR(100), 
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the student table with AdminID and foreign key to department admin
CREATE TABLE `student` (
  `StudentID` INT NOT NULL AUTO_INCREMENT,
  `FirstName` VARCHAR(50) NOT NULL,
  `LastName` VARCHAR(50) NOT NULL,
  `Department` VARCHAR(50) NOT NULL,
  `Program` VARCHAR(50) NOT NULL,
  `YearSection` VARCHAR(50) NOT NULL,
  `Email` VARCHAR(50) NOT NULL,
  `Password` VARCHAR(255) NOT NULL, 
  `AdminID` INT NOT NULL,
  PRIMARY KEY (`StudentID`),
  FOREIGN KEY (`AdminID`) REFERENCES `dept_admin`(`AdminID`) ON DELETE CASCADE
);

-- Create the teacher table with AdminID and foreign key to department admin
CREATE TABLE `teacher` (
  `TeacherID` INT NOT NULL AUTO_INCREMENT,
  `FirstName` VARCHAR(50) NOT NULL,
  `LastName` VARCHAR(50) NOT NULL,
  `Department` VARCHAR(50) NOT NULL,
  `Email` VARCHAR(50) NOT NULL,
  `Password` VARCHAR(255) NOT NULL, 
  `AdminID` INT NOT NULL,
  PRIMARY KEY (`TeacherID`),
  FOREIGN KEY (`AdminID`) REFERENCES `dept_admin`(`AdminID`) ON DELETE CASCADE
);

-- Create room_requests table
CREATE TABLE `room_requests` (
    `RequestID` INT NOT NULL AUTO_INCREMENT,
    `StudentID` INT,
    `TeacherID` INT,
    `RoomID` INT NOT NULL,
    `ActivityName` VARCHAR(255) NOT NULL,
    `Purpose` TEXT NOT NULL,               
    `RequestDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    `ReservationDate` DATETIME NOT NULL,   
    `StartTime` DATETIME NOT NULL,   
    `EndTime` DATETIME NOT NULL,     
    `NumberOfParticipants` INT NOT NULL,   
    `Status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending', 
    `RejectionReason` TEXT,        
    PRIMARY KEY (`RequestID`),
    FOREIGN KEY (`StudentID`) REFERENCES `student`(`StudentID`) ON DELETE CASCADE,
    FOREIGN KEY (`TeacherID`) REFERENCES `teacher`(`TeacherID`) ON DELETE CASCADE,
    FOREIGN KEY (`RoomID`) REFERENCES `rooms`(`id`) ON DELETE CASCADE,
    -- Ensure either StudentID or TeacherID is provided, but not both
    CHECK ((`StudentID` IS NOT NULL AND `TeacherID` IS NULL) OR (`StudentID` IS NULL AND `TeacherID` IS NOT NULL))
);

-- Create room_equipment table
CREATE TABLE `room_equipment` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `room_id` INT NOT NULL,
    `equipment_id` INT NOT NULL,
    `quantity` INT DEFAULT 1,
    `notes` TEXT,
    `last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `status` ENUM('working', 'needs_repair', 'maintenance', 'missing') DEFAULT 'working',
    `statusCondition` ENUM('working', 'needs_repair', 'maintenance', 'missing') DEFAULT 'working',
    `checked` BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`equipment_id`) REFERENCES `equipment`(`id`) ON DELETE CASCADE
);

-- Create equipment_audit table
CREATE TABLE `equipment_audit` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `equipment_id` INT NOT NULL,
    `action` VARCHAR(50) NOT NULL,
    `action_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `notes` TEXT,
    FOREIGN KEY (`equipment_id`) REFERENCES `equipment`(`id`) ON DELETE CASCADE
);

-- Create equipment_issues table
CREATE TABLE `equipment_issues` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `equipment_id` INT NOT NULL,
  `student_id` INT DEFAULT NULL,
  `teacher_id` INT DEFAULT NULL,
  `issue_type` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `status` ENUM('pending','in_progress','resolved','rejected') DEFAULT 'pending',
  `statusCondition` ENUM('working','needs_repair','maintenance','missing') DEFAULT 'working',
  `admin_response` TEXT DEFAULT NULL,
  `reported_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `resolved_at` TIMESTAMP NULL DEFAULT NULL,
  `image_path` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`equipment_id`) REFERENCES `equipment`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`student_id`) REFERENCES `student`(`StudentID`) ON DELETE CASCADE,
  FOREIGN KEY (`teacher_id`) REFERENCES `teacher`(`TeacherID`) ON DELETE CASCADE,
  -- Ensure either student_id or teacher_id is provided, but not both
  CHECK ((`student_id` IS NOT NULL AND `teacher_id` IS NULL) OR (`student_id` IS NULL AND `teacher_id` IS NOT NULL))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create system_settings table
CREATE TABLE `system_settings` (
  `setting_key` VARCHAR(50) NOT NULL,
  `setting_value` TEXT DEFAULT NULL,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert system settings
INSERT INTO `system_settings` (`setting_key`, `setting_value`, `updated_at`) VALUES
('room_status_last_check', '2025-03-31 15:47:03', '2025-03-31 07:47:03');

COMMIT;