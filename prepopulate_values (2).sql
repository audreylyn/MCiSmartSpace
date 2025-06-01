

INSERT INTO student (FirstName, LastName, Department, Program, YearSection, Email, Password, AdminID) VALUES
('Kyle', 'Reyes', 'Education and Art', 'Bachelor of Arts in Psychology', 'AB-Psych 3A', 'kyle.reyes@student.mc.edu', '23953e0557d08064ff662a9de6ad633a98225b3b5f0a5031ce5bb75d9c8d61e3', 1),
('Laura', 'Dela Cruz', 'Criminal Justice', 'Bachelor of Science in Criminology', 'BS-Crim 2B', 'laura.dc@student.mc.edu', 'b40b922f16605892a3bb82ed234e9114e83339ce8ff390d26abca8d8916d1513', 2),
('Mark', 'Rivera', 'Hospitality Management', 'Bachelor of Science in Travel Management', 'BS-TM 1C', 'mark.rivera@student.mc.edu', 'a7b8bfa9cb5f391cb7b83a12e01a9297e841c011167582d8bda1ff58a89b3218', 3),
('Nina', 'Lopez', 'Business Administration', 'Bachelor of Science in Business Administration Major in Financial Manageemnt', 'BSBA-FM 4A', 'nina.lopez@student.mc.edu', '22e23249e6609241951acff8b6507754d9e9a7fa6cc30654827620c47de19f29', 1),
('Oscar', 'Tan', 'Education and Arts', 'Bachelor of Physical Education', 'BPE 2A', 'oscar.tan@student.mc.edu', '0e80e4ddfe1f65a59780c34374a41eb53ce34ec925bf4d9de758618e7ce1c69d', 5),
('Paula', 'Santiago', 'Accountancy', 'Bachelor of Science in Accountancy', 'BSA 3B', 'paula.santiago@student.mc.edu', '0ffae8f7d2284571b7cc95fa9f4d9f4c9c8f1cc9422642c697ee316b0e4cb0a5', 6),
('Quinn', 'Chan', 'Education and Art', 'Bachelor of Elementary Education', 'BEED 1A', 'quinn.chan@student.mc.edu', '1b2f14d3cc177938839e7df7494f7d1484e2a6ed01fcd9ef9e68c3e06d5b53e3', 1),
('Ralph', 'Torres', 'Accountancy', 'Bachelor of Science in Accounting Information Systems', 'BSAIS 3C', 'ralph.torres@student.mc.edu', 'cb067c41f5442ff3a08b4c4f28f39d136fe9df85e5a4c42136de4a9942c4cf30', 8),
('Samantha', 'Uy', 'Criminology', 'Bachelor of Science in Criminology', 'BS-Crim 2D', 'samantha.uy@student.mc.edu', '07ff96d65a3fa215ef0a409d85ef67b1fa6c3e4b7f90ea26578c4829ac4f07f1', 9),
('Tim', 'Villanueva', 'Business Administration', 'Bachelor of Science in Business Administration Major in Marketing Manageemnt', 'BSBA-MM 2B', 'tim.villanueva@student.mc.edu', 'e06c2786b4c25ae6834e1575b32f160416a4c23ad99a850a6a2b101ba6a2d7b6', 1);

INSERT INTO teacher (FirstName, LastName, Department, Email, Password) VALUES
('Allan', 'Zapata', 'Education and Art', 'allan.zapata@mc.edu.ph', '8123b594bb8fa1cbad41bfcfc2643c5f30f8f8f73e57f88e39ac31510e118376'),
('Bea', 'Navarro', 'Criminal Justice', 'bea.navarro@mc.edu.ph', '2a76100689b60d181ee0648b310ae1b3517c87deff16c0f2491a3a3fe30e5a0b'),
('Carlos', 'Mendoza', 'Hospitality Management', 'carlos.mendoza@mc.edu.ph', '9a4e95e0c3fa8c4b253dcb1cb3181424a705fbc6aa2aaab60d295f20514cd0d4'),
('Dina', 'Rosales', 'Business Administration', 'dina.rosales@mc.edu.ph', '4706b82064cd729e71ed38e3c2cd07c593fe80eb790663228530b38e012b028d'),
('Eric', 'Lopez', 'Accountancy', 'eric.lopez@mc.edu.ph', '7ebad7b9b6aa3db7c964aa91b01e5b2e86f2cb46de78a55d6b75d9c82c41f284'),
('Faith', 'Santos', 'Accountancy', 'faith.santos@mc.edu.ph', '85b7fc15a1bc2c1ab7c118d11900d8c26e06636d80bb4c5b8458e4c9632694f7'),
('Gerry', 'Domingo', 'Criminology', 'gerry.domingo@mc.edu.ph', 'f7f748d40d059a06a5e618afad15592f7ff2e0486d391240f850b0107d93486d'),
('Hannah', 'Ong', 'Education and Art', 'hannah.ong@mc.edu.ph', '05f18f9cfd6b0cc9d2823e489d08beed7e7de3b031126ef55c0e401ea0a730cb'),
('Ian', 'Fernandez', 'Criminal Justice', 'ian.fernandez@mc.edu.ph', '7f63c5d233e78be8efae24abf8f7b5f2f19dfb58f25de1a9c1fc5639783b36e3'),
('Jane', 'Velasco', 'Education and Art', 'jane.velasco@mc.edu.ph', 'c42b04e67e344c0104ed2a0e4a7f45b7c1f81364aa8d44b0624dd3d81b763e3f');

INSERT INTO room_requests (StudentID, TeacherID, RoomID, ActivityName, Purpose, ReservationDate, StartTime, EndTime, NumberOfParticipants, Status, RejectionReason)
VALUES
(1, NULL, 1, 'Org Meeting', 'Monthly meeting for  students.', '2025-05-15 10:00:00', '2025-05-15 10:00:00', '2025-05-15 12:00:00', 25, 'approved', NULL),
(NULL, 2, 2, 'Criminal Justice Seminar', 'Guest talk on microelectronics.', '2025-05-20 14:00:00', '2025-05-20 14:00:00', '2025-05-20 17:00:00', 50, 'approved', NULL),
(3, NULL, 1, 'Business Administration Plan Presentation', 'Final presentation for marketing class.', '2025-05-22 09:00:00', '2025-05-22 09:00:00', '2025-05-22 11:00:00', 10, 'pending', NULL),
(4, NULL, 3, 'Capstone Discussion', 'Group meeting for capstone planning.', '2025-05-17 13:00:00', '2025-05-17 13:00:00', '2025-05-17 15:00:00', 6, 'rejected', 'Room unavailable at the requested time.'),
(NULL, 5, 4, 'Faculty Training', 'Workshop on new grading system.', '2025-05-18 08:00:00', '2025-05-18 08:00:00', '2025-05-18 11:30:00', 20, 'approved', NULL),
(2, NULL, 2, 'Study Group', 'Review session for midterms.', '2025-05-19 16:00:00', '2025-05-19 16:00:00', '2025-05-19 18:00:00', 5, 'approved', NULL),
(NULL, 7, 1, 'Mock Trial', 'Simulation activity for law students.', '2025-05-21 10:00:00', '2025-05-21 10:00:00', '2025-05-21 12:00:00', 18, 'pending', NULL),
(5, NULL, 3, 'Project Defense', 'Final defense for Criminal Justice.', '2025-05-23 13:00:00', '2025-05-23 13:00:00', '2025-05-23 15:30:00', 7, 'approved', NULL),
(NULL, 1, 2, 'Faculty Meeting', 'Monthly faculty coordination meeting.', '2025-05-25 09:00:00', '2025-05-25 09:00:00', '2025-05-25 11:00:00', 12, 'approved', NULL),
(6, NULL, 1, 'Thesis Consultation', 'Meeting with thesis adviser.', '2025-05-16 14:00:00', '2025-05-16 14:00:00', '2025-05-16 15:00:00', 2, 'pending', NULL),
(7, NULL, 5, 'Workshop', 'Training on data visualization.', '2025-05-27 10:00:00', '2025-05-27 10:00:00', '2025-05-27 12:00:00', 30, 'approved', NULL),
(NULL, 6, 3, 'Review Session', 'Remedial session before finals.', '2025-05-28 08:00:00', '2025-05-28 08:00:00', '2025-05-28 10:00:00', 15, 'rejected', 'Room double-booked.'),
(8, NULL, 2, 'Film Viewing', 'Viewing and critique of documentary.', '2025-05-30 15:00:00', '2025-05-30 15:00:00', '2025-05-30 17:30:00', 22, 'approved', NULL),
(NULL, 4, 4, 'Lecture Recording', 'Recording content for online modules.', '2025-05-29 13:00:00', '2025-05-29 13:00:00', '2025-05-29 15:00:00', 1, 'approved', NULL),
(9, NULL, 3, 'General Assembly', 'Organization-wide announcement event.', '2025-06-01 09:00:00', '2025-06-01 09:00:00', '2025-06-01 11:00:00', 35, 'pending', NULL),
(NULL, 3, 5, 'Panel Discussion', 'Invited experts on current issues.', '2025-06-02 14:00:00', '2025-06-02 14:00:00', '2025-06-02 16:00:00', 40, 'approved', NULL),
(10, NULL, 2, 'Photography Session', 'Photoshoot for publication.', '2025-06-03 10:00:00', '2025-06-03 10:00:00', '2025-06-03 12:00:00', 8, 'approved', NULL),
(3, NULL, 1, 'Workshop', 'Practice on integrations.', '2025-06-04 13:00:00', '2025-06-04 13:00:00', '2025-06-04 15:30:00', 10, 'pending', NULL),
(NULL, 8, 4, 'Peer Evaluation', 'Instructor-led peer assessments.', '2025-06-05 09:00:00', '2025-06-05 09:00:00', '2025-06-05 11:00:00', 14, 'approved', NULL),
(4, NULL, 5, 'Capstone Rehearsal', 'Dry run for capstone defense.', '2025-06-06 08:00:00', '2025-06-06 08:00:00', '2025-06-06 10:00:00', 6, 'rejected', 'Conflict with reserved maintenance period.');

INSERT INTO equipment (name, description, category) VALUES
('ACC-101 Projector', 'Epson PowerLite Projector', 'Classroom Technology'),
('ACC-101 Smart Board', '75" Interactive Display', 'Classroom Technology'),
('ACC-102 Projector', 'Epson PowerLite Projector', 'Classroom Technology'),
('ACC-102 Document Camera', 'IPEVO V4K Ultra HD', 'Classroom Technology'),
('ACC-103 Desktop Computer', 'Dell OptiPlex 7090', 'Computer Hardware'),
('ACC-103 Network Switch', 'Cisco Catalyst 2960-X', 'Networking Equipment'),
('ACC-201 Projector', 'Epson PowerLite Projector', 'Classroom Technology'),
('ACC-201 Laptop Computer', 'Lenovo ThinkPad X1 Carbon', 'Computer Hardware'),
('ACC-202 Conference Speakerphone', 'Jabra Speak 710', 'Classroom Technology'),
('ACC-202 Smart Board', '75" Interactive Display', 'Classroom Technology'),
('ACC-301 Laser Printer', 'HP LaserJet Pro M404dn', 'Office Equipment'),
('ACC-302 Scanner', 'Epson WorkForce ES-400', 'Office Equipment'),
('BA-101 Projector', 'Epson PowerLite Projector', 'Classroom Technology'),
('BA-101 Smart Board', '75" Interactive Display', 'Classroom Technology'),
('BA-102 Desktop Computer', 'Dell OptiPlex 7090', 'Computer Hardware'),
('BA-102 Wireless Router', 'Cisco Business Administration Router', 'Networking Equipment'),
('BA-103 Projector', 'Epson PowerLite Projector', 'Classroom Technology'),
('BA-201 Video Camera', 'Sony HXR-NX80 4K', 'Audio Visual Equipment'),
('BA-201 Digital Mixer', 'Yamaha TF1 Console', 'Audio Visual Equipment'),
('BA-202 Conference Speakerphone', 'Jabra Speak 710', 'Classroom Technology'),
('BA-301 Laser Printer', 'HP LaserJet Pro M404dn', 'Office Equipment'),
('BA-302 Scanner', 'Epson WorkForce ES-400', 'Office Equipment'),
('BA-401 Microscope', 'OMAX Digital Microscope', 'Lab Equipment'),
('HM-101 Projector', 'Epson PowerLite Projector', 'Classroom Technology'),
('HM-102 Commercial Stove', 'Vulcan 60" Gas Range', 'Kitchen Equipment'),
('HM-102 Food Processor', 'Robot Coupe R2N', 'Kitchen Equipment'),
('HM-103 Smart Board', '75" Interactive Display', 'Classroom Technology'),
('HM-201 Projector', 'Epson PowerLite Projector', 'Classroom Technology'),
('HM-202 Conference Speakerphone', 'Jabra Speak 710', 'Classroom Technology'),
('HM-301 Laser Printer', 'HP LaserJet Pro M404dn', 'Office Equipment'),
('EA-101 Projector', 'Epson PowerLite Projector', 'Classroom Technology'),
('EA-102 Art Supplies Set', 'Professional Studio Tools', 'Art Equipment'),
('EA-103 Wireless Microphone', 'Shure BLX24/SM58 System', 'Audio Visual Equipment'),
('EA-201 Projector', 'Epson PowerLite Projector', 'Classroom Technology'),
('EA-202 Theater Lights', 'Stage Lighting System', 'Audio Visual Equipment'),
('EA-301 Laser Printer', 'HP LaserJet Pro M404dn', 'Office Equipment'),
('EA-302 Scanner', 'Epson WorkForce ES-400', 'Office Equipment'),
('CJ-101 Projector', 'Epson PowerLite Projector', 'Classroom Technology'),
('CJ-102 VR Headset', 'Oculus Quest 2', 'Educational Technology'),
('CJ-103 Desktop Computer', 'Dell OptiPlex 7090', 'Computer Hardware'),
('CJ-201 Smart Board', '75" Interactive Display', 'Classroom Technology'),
('CJ-202 Conference Speakerphone', 'Jabra Speak 710', 'Classroom Technology'),
('CJ-301 Laser Printer', 'HP LaserJet Pro M404dn', 'Office Equipment'),
('GYM-MAIN Basketball Hoop', 'Spalding Arena View', 'Sports Equipment'),
('GYM-MAIN Volleyball Net', 'Tandem Sports Net', 'Sports Equipment'),
('GYM-MAIN Gymnastic Mats', 'Resilite 2" Vinyl Mats', 'Sports Equipment');


Smart Tv
Tv Remote 
Projector
Electric Fan
Aircon


Speaker 
Microphone
Laphel



INSERT INTO room_equipment (room_id, equipment_id, quantity, notes, status, statusCondition, checked) VALUES
(1, 1, 1, 'Installed in ceiling', 'working', 'working', FALSE),
(1, 2, 1, '', 'working', 'working', FALSE),
(2, 3, 1, '', 'working', 'working', FALSE),
(2, 4, 1, '', 'working', 'working', FALSE),
(3, 5, 15, 'Lab computers', 'working', 'working', FALSE),
(3, 6, 1, '', 'working', 'working', FALSE),
(4, 7, 1, '', 'working', 'working', FALSE),
(4, 8, 1, '', 'working', 'working', FALSE),
(5, 9, 1, '', 'working', 'working', FALSE),
(5, 10, 1, '', 'working', 'working', FALSE),
(6, 11, 1, '', 'working', 'working', FALSE),
(7, 12, 1, '', 'working', 'working', FALSE),
(8, 13, 1, '', 'working', 'working', FALSE),
(8, 14, 1, '', 'working', 'working', FALSE),
(9, 15, 20, '', 'working', 'working', FALSE),
(9, 16, 1, '', 'working', 'working', FALSE),
(10, 17, 1, '', 'working', 'working', FALSE),
(11, 18, 1, '', 'working', 'working', FALSE),
(11, 19, 1, '', 'working', 'working', FALSE),
(12, 20, 1, '', 'working', 'working', FALSE),
(13, 21, 1, '', 'working', 'working', FALSE),
(14, 22, 1, '', 'working', 'working', FALSE),
(15, 23, 5, '', 'working', 'working', FALSE),
(16, 24, 1, '', 'working', 'working', FALSE),
(17, 25, 2, '', 'working', 'working', FALSE),
(17, 26, 1, '', 'working', 'working', FALSE),
(18, 27, 1, '', 'working', 'working', FALSE),
(19, 28, 1, '', 'working', 'working', FALSE),
(20, 29, 1, '', 'working', 'working', FALSE),
(21, 30, 1, '', 'working', 'working', FALSE),
(22, 31, 1, '', 'working', 'working', FALSE),
(23, 32, 1, '', 'working', 'working', FALSE),
(24, 33, 1, '', 'working', 'working', FALSE),
(25, 34, 1, '', 'working', 'working', FALSE),
(26, 35, 1, '', 'working', 'working', FALSE),
(27, 36, 1, '', 'working', 'working', FALSE),
(28, 37, 1, '', 'working', 'working', FALSE),
(29, 38, 1, '', 'working', 'working', FALSE),
(30, 39, 20, '', 'working', 'working', FALSE),
(31, 40, 1, '', 'working', 'working', FALSE),
(32, 41, 1, '', 'working', 'working', FALSE),
(33, 42, 1, '', 'working', 'working', FALSE),
(34, 43, 1, '', 'working', 'working', FALSE),
(35, 44, 1, '', 'working', 'working', FALSE),
(35, 45, 1, '', 'working', 'working', FALSE),
(35, 46, 6, '', 'working', 'working', FALSE);

INSERT INTO equipment_issues (
  equipment_id, student_id, teacher_id, issue_type, description,
  status, statusCondition, admin_response, reported_at, resolved_at, image_path
) VALUES
(3, 1, NULL, 'Display Issue', 'Projector does not display video.', 'pending', 'needs_repair', NULL, NOW(), NULL, 'images/issues/projector_display_101.jpg'),
(7, NULL, 1, 'No Power', 'Projector will not turn on despite multiple attempts.', 'in_progress', 'needs_repair', 'Technician has been notified.', NOW(), NULL, 'images/issues/no_power_201.jpg'),
(15, 2, NULL, 'Network Error', 'Cannot connect desktop to LAN.', 'resolved', 'working', 'Replaced the network cable.', NOW() - INTERVAL 7 DAY, NOW() - INTERVAL 6 DAY, NULL),
(25, NULL, 2, 'Heating Issue', 'Stove overheats rapidly.', 'pending', 'needs_repair', NULL, NOW() - INTERVAL 1 DAY, NULL, 'images/issues/stove_heat_202.jpg'),
(11, 3, NULL, 'Paper Jam', 'Printer consistently jams paper.', 'in_progress', 'maintenance', 'Cleaning scheduled.', NOW() - INTERVAL 2 DAY, NULL, NULL),
(2, NULL, 3, 'Calibration Error', 'Smart board touch calibration is off.', 'resolved', 'working', 'Recalibrated via settings.', NOW() - INTERVAL 10 DAY, NOW() - INTERVAL 9 DAY, NULL),
(36, 4, NULL, 'Mic Feedback', 'Wireless mic causes loud feedback.', 'pending', 'needs_repair', NULL, NOW(), NULL, 'images/issues/mic_feedback.jpg'),
(6, NULL, 4, 'No Connectivity', 'Switch not routing internet to lab PCs.', 'rejected', 'needs_repair', 'Found out network outage was external.', NOW() - INTERVAL 3 DAY, NOW() - INTERVAL 2 DAY, NULL),
(23, 5, NULL, 'Loose Lens', 'Microscope lens wobbly and loose.', 'pending', 'maintenance', NULL, NOW(), NULL, 'images/issues/microscope_lens.jpg'),
(29, NULL, 5, 'Low Ink', 'Printer running out of ink quickly.', 'resolved', 'working', 'Refilled toner cartridges.', NOW() - INTERVAL 5 DAY, NOW() - INTERVAL 3 DAY, NULL),
(4, 6, NULL, 'Image Flicker', 'Document camera flickers randomly.', 'in_progress', 'needs_repair', 'Replacement unit requested.', NOW(), NULL, NULL),
(13, NULL, 6, 'Bulb Burnt', 'Projector bulb likely burnt out.', 'resolved', 'working', 'Replaced bulb with new unit.', NOW() - INTERVAL 12 DAY, NOW() - INTERVAL 11 DAY, NULL),
(40, 7, NULL, 'VR Lag', 'VR headset lags severely during use.', 'pending', 'needs_repair', NULL, NOW(), NULL, 'images/issues/vr_lag.jpg'),
(27, NULL, 7, 'Audio Distortion', 'Speakerphone audio crackles.', 'in_progress', 'maintenance', 'Test scheduled this week.', NOW(), NULL, NULL),
(46, 8, NULL, 'Missing Mats', 'Half of the gym mats are missing.', 'pending', 'missing', NULL, NOW(), NULL, 'images/issues/missing_mats.jpg');
