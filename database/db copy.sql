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

CREATE TABLE `dept_admin` (
  `AdminID` INT NOT NULL AUTO_INCREMENT,
  `FirstName` VARCHAR(50) NOT NULL,
  `LastName` VARCHAR(50) NOT NULL,
  `Department` VARCHAR(50) NOT NULL,
  `Email` VARCHAR(50) NOT NULL,
  `Password` VARCHAR(255) NOT NULL, 
  PRIMARY KEY (`AdminID`)
);

-- Create the student table with AdminID
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
  PRIMARY KEY (`StudentID`)
);

-- Create the teacher table
CREATE TABLE `teacher` (
  `TeacherID` INT NOT NULL AUTO_INCREMENT,
  `FirstName` VARCHAR(50) NOT NULL,
  `LastName` VARCHAR(50) NOT NULL,
  `Department` VARCHAR(50) NOT NULL,
  `Email` VARCHAR(50) NOT NULL,
  `Password` VARCHAR(255) NOT NULL, 
  PRIMARY KEY (`TeacherID`)
);

ALTER TABLE teacher ADD COLUMN AdminID INT NOT NULL;

-- Create buildings table
CREATE TABLE buildings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    building_name VARCHAR(255) NOT NULL,
    department VARCHAR(255) NOT NULL,
    number_of_floors INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create rooms table
CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_name VARCHAR(255) NOT NULL,
    room_type VARCHAR(255) NOT NULL,
    capacity INT NOT NULL,
    RoomStatus ENUM('available', 'occupied', 'maintenance') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    building_id INT,
    FOREIGN KEY (building_id) REFERENCES buildings(id)
);

CREATE TABLE room_requests (
    RequestID INT NOT NULL AUTO_INCREMENT,
    StudentID INT,
    TeacherID INT,
    RoomID INT NOT NULL,
    ActivityName VARCHAR(255) NOT NULL,
    Purpose TEXT NOT NULL,               
    RequestDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    ReservationDate DATETIME NOT NULL,   
    StartTime DATETIME NOT NULL,   
    EndTime DATETIME NOT NULL,     
    NumberOfParticipants INT NOT NULL,   
    Status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending', 
    RejectionReason TEXT,        
    PRIMARY KEY (RequestID),
    FOREIGN KEY (StudentID) REFERENCES student(StudentID) ON DELETE CASCADE,
    FOREIGN KEY (TeacherID) REFERENCES teacher(TeacherID) ON DELETE CASCADE,
    FOREIGN KEY (RoomID) REFERENCES rooms(id)
);

-- Create room_equipment table
CREATE TABLE room_equipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT NOT NULL,
    equipment_id INT NOT NULL,
    quantity INT DEFAULT 1,
    notes TEXT,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('working', 'needs_repair', 'maintenance', 'missing') DEFAULT 'working',
    statusCondition ENUM('working', 'needs_repair', 'maintenance', 'missing') DEFAULT 'working',
    checked BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (room_id) REFERENCES rooms(id),
    FOREIGN KEY (equipment_id) REFERENCES equipment(id)
);

-- Create equipment table
CREATE TABLE equipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(100), 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS equipment_audit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipment_id INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    action_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    notes TEXT,
    FOREIGN KEY (equipment_id) REFERENCES equipment(id) 
);

CREATE TABLE `equipment_issues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipment_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `issue_type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` enum('pending','in_progress','resolved','rejected') DEFAULT 'pending',
  `statusCondition` enum('working','needs_repair','maintenance','missing') DEFAULT 'working',
  `admin_response` text DEFAULT NULL,
  `reported_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `resolved_at` timestamp NULL DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (student_id) REFERENCES student(StudentID) ON DELETE CASCADE,
  FOREIGN KEY (teacher_id) REFERENCES teacher(TeacherID) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


  CREATE TABLE `system_settings` (
    `setting_key` varchar(50) NOT NULL,
    `setting_value` text DEFAULT NULL,
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`setting_key`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  INSERT INTO `system_settings` (`setting_key`, `setting_value`, `updated_at`) VALUES
  ('room_status_last_check', '2025-03-31 15:47:03', '2025-03-31 07:47:03');

COMMIT;
