
INSERT INTO `dept_admin` (`AdminID`, `FirstName`, `LastName`, `Department`, `Email`, `Password`) VALUES
(1, 'Audrey', 'Morana', 'Hospitality Management', 'audrey@gmail.com', '$2y$12$Zcd7dCZC8S9DmErTkYcTOea9dV7/v5ptOF6qZJ5yyjVbRFQ2jgcrC'),
(2, 'Anna', 'Santos', 'Accountancy', 'anna.santos@mc.edu.ph', '$2y$12$fLeFSoGOkPBU.klMQ3XWHO.nlXfueRP8FbgzEn901nhUr/l9gNJHi'),
(3, 'Brian', 'Lopez', 'Criminal Justice Education', 'brian.lopez@mc.edu.ph', '$2y$12$LasXmlNjd.TWW.bq/xNtqueWGM9zyUasjGCoytxqmHqYkESPEmVYC'),
(4, 'Clara', 'Reyes', 'Business Administration', 'clara.reyes@mc.edu.ph', '$2y$12$gKI0DKi3fr.Q4vtyx7raHOFB/0sVOgQC8YXiueobJ2BqoI7Mxt5lG'),
(5, 'David', 'Tan', 'Education, Arts, and Sciences', 'david.tan@mc.edu.ph', '$2y$12$9/9GzXGRDotHmIqARMGBju48PqmUX3GUW1zu7Hfrw3Jna4AfwNx2q');


-- Buildings
INSERT INTO buildings (building_name, department, number_of_floors) VALUES 
('Accountancy Building', 'Accountancy', 4),
('Business Administration Complex', 'Business Administration', 5),
('Hospitality Management Building', 'Hospitality Management', 3),
('Education and Arts Center', 'Education, Arts, and Sciences', 4),
('Criminal Justice Building', 'Criminal Justice Education', 3);

-- Rooms 
INSERT INTO rooms (room_name, room_type, capacity, building_id) VALUES 
-- Accountancy Building (ID 1)
('ACC-101', 'Classroom', 40, 1),
('ACC-102', 'Classroom', 35, 1),
('ACC-201', 'Classroom', 45, 1),
('ACC-202', 'Classroom', 30, 1),
('ACC-301', 'Classroom', 30, 1),

-- Business Administration Complex (ID 2)
('BA-101', 'Classroom', 50, 2),
('BA-103', 'Classroom', 45, 2),
('BA-201', 'Classroom', 60, 2),
('BA-202', 'Classroom', 40, 2),
('BA-301', 'Classroom', 35, 2),

-- Hospitality Management Building (ID 3)
('HM-101', 'Classroom', 35, 3),
('HM-201', 'Classroom', 40, 3),
('HM-202', 'Classroom', 30, 3),
('HM-301', 'Classroom', 25, 3),
('HM-302', 'Classroom', 30, 3),

-- Education and Arts Center (ID 4)
('EA-101', 'Classroom', 45, 4),
('EA-201', 'Classroom', 40, 4),
('EA-202', 'Classroom', 50, 4),
('EA-301', 'Classroom', 35, 4),
('EA-302', 'Classroom', 30, 4),

-- Criminal Justice Building (ID 5)
('CJ-101', 'Classroom', 40, 5),
('CJ-201', 'Classroom', 45, 5),
('CJ-202', 'Classroom', 30, 5),
('CJ-301', 'Classroom', 25, 5),
('CJ-302', 'Classroom', 30, 5);


-- Equipments
INSERT INTO equipment (name, description, category) VALUES 
('Smart TV', 'A smart television with internet capabilities', 'Electronics'),
('TV Remote', 'Remote control compatible with smart TVs', 'Accessories'),
('Projector', 'Digital projector for presentations', 'Electronics'),
('Electric Fan', 'Oscillating electric fan for ventilation', 'Appliances'),
('Aircon', 'Air conditioning unit for room cooling', 'Appliances'),
('Speaker', 'Audio speaker system for sound output', 'Audio Equipment'),
('Microphone', 'Handheld microphone for voice amplification', 'Audio Equipment'),
('Lapel', 'Clip-on lapel microphone for presentations', 'Audio Equipment');



INSERT INTO `student` (`StudentID`, `FirstName`, `LastName`, `Department`, `Program`, `YearSection`, `Email`, `Password`, `AdminID`) VALUES
(1, 'Ivy', 'Nava', 'Accountancy', 'BSA', 'BSA 3 - 2', 'ivy@gmail.com', '$2y$12$.5nQBdr.PH2Nz26XsUr3JOPHM75zAxhdWcKdMbsvfeL8ZbjrLXgeq', 2),
(2, 'Juliana', 'Macaranas', 'Accountancy', 'BSMA', 'BSMA 3- 1', 'juliana@gmail.com', '$2y$12$JASfLFT2S/r/tN6IM4eXRO7G3DJcX1xynRkLpcspKNPik6vZwAy5.', 2),
(3, 'Marco', 'Ramos', 'Accountancy', 'BSA', 'BSA 4 - 1', 'marco.ramos3@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(4, 'Chloe', 'Torres', 'Accountancy', 'BSLM', 'BSLM 4 - 2', 'chloe.torres4@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(5, 'Sofia', 'Cruz', 'Accountancy', 'BSA', 'BSA 3 - 3', 'sofia.cruz5@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(6, 'Adrian', 'Gomez', 'Accountancy', 'BSLM', 'BSLM 3 - 1', 'adrian.gomez6@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(7, 'Alyssa', 'Valdez', 'Accountancy', 'BSMA', 'BSMA 3 - 3', 'alyssa.valdez7@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(8, 'Bianca', 'Mendoza', 'Accountancy', 'BSA', 'BSA 3 - 2', 'bianca.mendoza8@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(9, 'Miguel', 'Santos', 'Accountancy', 'BSMA', 'BSMA 4 - 1', 'miguel.santos9@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(10, 'Kevin', 'Villanueva', 'Accountancy', 'BSMA', 'BSMA 3 - 2', 'kevin.villanueva10@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(11, 'Darren', 'Cruz', 'Accountancy', 'BSMA', 'BSMA 3 - 1', 'darren.cruz11@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(12, 'Luis', 'Lopez', 'Accountancy', 'BSLM', 'BSLM 3 - 3', 'luis.lopez12@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(13, 'Lance', 'Garcia', 'Accountancy', 'BSAIS', 'BSAIS 3 - 1', 'lance.garcia13@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(14, 'Carlos', 'Aquino', 'Accountancy', 'BSA', 'BSA 4 - 2', 'carlos.aquino14@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(15, 'Nathan', 'Reyes', 'Accountancy', 'BSLM', 'BSLM 4 - 1', 'nathan.reyes15@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(16, 'Diego', 'Morales', 'Accountancy', 'BSAIS', 'BSAIS 3 - 2', 'diego.morales16@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(17, 'Isabella', 'Flores', 'Accountancy', 'BSMA', 'BSMA 4 - 2', 'isabella.flores17@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(18, 'Faith', 'Rivera', 'Accountancy', 'BSLM', 'BSLM 3 - 2', 'faith.rivera18@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(19, 'Gabriel', 'Hernandez', 'Accountancy', 'BSAIS', 'BSAIS 3 - 3', 'gabriel.hernandez19@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(20, 'Samuel', 'Reyes', 'Accountancy', 'BSA', 'BSA 3 - 1', 'samuel.reyes20@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(21, 'Trisha', 'Dela Cruz', 'Accountancy', 'BSAIS', 'BSAIS 4 - 1', 'trisha.delacruz21@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(22, 'Andrea', 'Diaz', 'Accountancy', 'BSAIS', 'BSAIS 4 - 2', 'andrea.diaz22@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2);


INSERT INTO `teacher` (`TeacherID`, `FirstName`, `LastName`, `Department`, `Email`, `Password`, `AdminID`) VALUES
(1, 'Marianne', 'Saquez', 'Accountancy', 'marianne@gmail.com', '$2y$12$ENFSxDBeRJVn5TUUXvt29egHwX9jXClo/Lj/tEdkv00Tx./st05Wy', 2),
(2, 'Roberto', 'Martinez', 'Accountancy', 'roberto.martinez@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(3, 'Catherine', 'Del Rosario', 'Accountancy', 'catherine.delrosario@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(4, 'Jonathan', 'Bautista', 'Accountancy', 'jonathan.bautista@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(5, 'Maria Elena', 'Castillo', 'Accountancy', 'mariaelena.castillo@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(6, 'Ferdinand', 'Gutierrez', 'Accountancy', 'ferdinand.gutierrez@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(7, 'Josephine', 'Mercado', 'Accountancy', 'josephine.mercado@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(8, 'Alexander', 'Pascual', 'Accountancy', 'alexander.pascual@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(9, 'Veronica', 'Espinoza', 'Accountancy', 'veronica.espinoza@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(10, 'Ricardo', 'Navarro', 'Accountancy', 'ricardo.navarro@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(11, 'Angelica', 'Fernandez', 'Accountancy', 'angelica.fernandez@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(12, 'Dennis', 'Velasco', 'Accountancy', 'dennis.velasco@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(13, 'Rosemarie', 'Cabrera', 'Accountancy', 'rosemarie.cabrera@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(14, 'Benjamin', 'Soriano', 'Accountancy', 'benjamin.soriano@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2),
(15, 'Melody', 'Aguilar', 'Accountancy', 'melody.aguilar@gmail.com', '$2y$12$samplehashedpasswordfortesting1234567890abcd', 2);




INSERT INTO `room_requests` (`RequestID`, `StudentID`, `TeacherID`, `RoomID`, `ActivityName`, `Purpose`, `RequestDate`, `ReservationDate`, `StartTime`, `EndTime`, `NumberOfParticipants`, `Status`, `RejectionReason`) VALUES
(1, 2, NULL, 1, 'Regular Class', 'Regular Class at Basic Finance', '2025-05-22 12:11:31', '0000-00-00 00:00:00', '2025-05-23 10:30:00', '2025-05-23 13:00:00', 40, 'pending', NULL),
(2, NULL, 1, 1, 'Regular Class', 'Business and Transfer Taxes', '2025-05-22 12:14:42', '0000-00-00 00:00:00', '2025-05-23 10:30:00', '2025-05-23 12:00:00', 40, 'pending', NULL),
(3, NULL, 2, 2, 'Regular Class', 'Financial Accounting 1', '2025-05-22 14:30:15', '0000-00-00 00:00:00', '2025-05-24 08:00:00', '2025-05-24 10:00:00', 35, 'pending', NULL),
(4, NULL, 3, 3, 'Regular Class', 'Cost Accounting', '2025-05-22 15:45:22', '0000-00-00 00:00:00', '2025-05-25 09:00:00', '2025-05-25 12:00:00', 45, 'pending', NULL),
(5, NULL, 4, 4, 'Regular Class', 'Management Accounting', '2025-05-22 16:20:10', '0000-00-00 00:00:00', '2025-05-26 13:00:00', '2025-05-26 15:00:00', 30, 'pending', NULL),
(6, NULL, 5, 5, 'Regular Class', 'Auditing Theory and Practice', '2025-05-22 17:15:35', '0000-00-00 00:00:00', '2025-05-27 10:00:00', '2025-05-27 13:00:00', 30, 'pending', NULL),
(7, NULL, 6, 1, 'Regular Class', 'Advanced Financial Accounting', '2025-05-22 18:05:42', '0000-00-00 00:00:00', '2025-05-28 15:30:00', '2025-05-28 18:00:00', 40, 'pending', NULL),
(8, NULL, 7, 2, 'Regular Class', 'Taxation Law and Practice', '2025-05-22 19:30:18', '0000-00-00 00:00:00', '2025-05-29 08:00:00', '2025-05-29 11:00:00', 35, 'pending', NULL),
(9, NULL, 8, 3, 'Regular Class', 'Financial Statement Analysis', '2025-05-22 20:12:55', '0000-00-00 00:00:00', '2025-05-30 16:00:00', '2025-05-30 18:30:00', 45, 'pending', NULL),
(10, NULL, 9, 4, 'Regular Class', 'Internal Auditing', '2025-05-23 08:45:20', '0000-00-00 00:00:00', '2025-05-31 13:00:00', '2025-05-31 16:00:00', 30, 'pending', NULL),
(11, NULL, 10, 5, 'Regular Class', 'Government Accounting', '2025-05-23 09:30:44', '0000-00-00 00:00:00', '2025-06-01 09:00:00', '2025-06-01 12:00:00', 30, 'pending', NULL),
(12, NULL, 11, 1, 'Regular Class', 'Corporate Finance', '2025-05-23 10:15:33', '0000-00-00 00:00:00', '2025-06-02 14:00:00', '2025-06-02 17:00:00', 40, 'pending', NULL),
(13, NULL, 12, 2, 'Regular Class', 'Accounting Information Systems', '2025-05-23 11:25:17', '0000-00-00 00:00:00', '2025-06-03 10:30:00', '2025-06-03 13:30:00', 35, 'pending', NULL),
(14, NULL, 13, 3, 'Regular Class', 'International Accounting Standards', '2025-05-23 13:40:29', '0000-00-00 00:00:00', '2025-06-04 15:00:00', '2025-06-04 18:00:00', 45, 'pending', NULL),
(15, NULL, 14, 4, 'Regular Class', 'Forensic Accounting', '2025-05-23 14:55:12', '0000-00-00 00:00:00', '2025-06-05 11:00:00', '2025-06-05 14:00:00', 30, 'pending', NULL),
(16, NULL, 15, 5, 'Regular Class', 'Public Finance and Budgeting', '2025-05-23 16:20:45', '0000-00-00 00:00:00', '2025-06-06 16:30:00', '2025-06-06 18:30:00', 30, 'pending', NULL),
(17, NULL, 1, 1, 'Regular Class', 'Business Ethics in Accounting', '2025-05-23 17:35:28', '0000-00-00 00:00:00', '2025-06-07 13:30:00', '2025-06-07 15:30:00', 40, 'pending', NULL),
(18, NULL, 2, 2, 'Regular Class', 'Financial Accounting 2', '2025-05-23 18:50:36', '0000-00-00 00:00:00', '2025-06-08 09:30:00', '2025-06-08 12:30:00', 35, 'pending', NULL),
(19, NULL, 3, 3, 'Regular Class', 'Advanced Cost Accounting', '2025-05-23 19:45:21', '0000-00-00 00:00:00', '2025-06-09 08:00:00', '2025-06-09 12:00:00', 45, 'pending', NULL),
(20, NULL, 4, 4, 'Regular Class', 'Strategic Management Accounting', '2025-05-24 08:30:15', '0000-00-00 00:00:00', '2025-06-10 14:00:00', '2025-06-10 17:30:00', 30, 'pending', NULL);