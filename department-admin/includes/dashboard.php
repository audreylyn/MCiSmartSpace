<?php
// Get admin ID and department
$admin_id = $_SESSION['user_id'];
$department = $_SESSION['department'] ?? '';

// If department is not set in session, try to get it from database for backward compatibility
if (empty($department)) {
    $stmt = $conn->prepare("SELECT Department FROM dept_admin WHERE AdminID = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $department = $row['Department'];
        // Store in session for future use
        $_SESSION['department'] = $department;
    }
}

// For testing/debugging: Use a default department if none is found
if (empty($department)) {
    $department = 'Business Administration'; // Replace with one from your database
    // Uncomment this line to see the user_id issue
    // echo "Warning: No department found for admin ID: " . $admin_id;
}

// Get teacher count - based on AdminID (teachers added by this admin)
$teacher_count = 0;
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM teacher WHERE AdminID = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $teacher_count = $row['count'];
}

// Get student count - based on AdminID (students added by this admin)
$student_count = 0;
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM student WHERE AdminID = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $student_count = $row['count'];
}

// Get room count - direct count from buildings and rooms
$room_count = 0;
$stmt = $conn->prepare("
    SELECT COUNT(*) as count 
    FROM rooms r
    JOIN buildings b ON r.building_id = b.id
    WHERE b.department = ?
");
$stmt->bind_param("s", $department);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $room_count = $row['count'];
}

// Get equipment count - direct count from equipments in rooms of the department
$equipment_count = 0;
$stmt = $conn->prepare("
    SELECT COUNT(*) as count 
    FROM room_equipment re
    JOIN rooms r ON re.room_id = r.id
    JOIN buildings b ON r.building_id = b.id
    WHERE b.department = ?
");
$stmt->bind_param("s", $department);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $equipment_count = $row['count'];
}

// Calculate pending room requests count from students and teachers managed by this admin
$pending_requests = 0;
$stmt = $conn->prepare("
    SELECT COUNT(*) as count 
    FROM room_requests rr
    LEFT JOIN student s ON rr.StudentID = s.StudentID
    LEFT JOIN teacher t ON rr.TeacherID = t.TeacherID
    WHERE rr.Status = 'pending'
    AND (s.AdminID = ? OR t.AdminID = ?)
");
$stmt->bind_param("ii", $admin_id, $admin_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $pending_requests = $row['count'];
}

// Calculate unresolved equipment issues from students and teachers managed by this admin
$unresolved_issues = 0;
$stmt = $conn->prepare("
    SELECT COUNT(*) as count 
    FROM equipment_issues ei
    LEFT JOIN student s ON ei.student_id = s.StudentID
    LEFT JOIN teacher t ON ei.teacher_id = t.TeacherID
    WHERE (ei.status = 'pending' OR ei.status = 'in_progress')
    AND (s.AdminID = ? OR t.AdminID = ?)
");
$stmt->bind_param("ii", $admin_id, $admin_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $unresolved_issues = $row['count'];
}

// Get equipment status statistics
$equipment_stats = [];
$stmt = $conn->prepare("
    SELECT re.status, COUNT(*) as count 
    FROM room_equipment re
    JOIN rooms r ON re.room_id = r.id
    JOIN buildings b ON r.building_id = b.id
    WHERE b.department = ?
    GROUP BY re.status
");
$stmt->bind_param("s", $department);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $equipment_stats[$row['status']] = $row['count'];
}

// Get equipment issues statistics
$issue_stats = [];
$stmt = $conn->prepare("
    SELECT ei.status, COUNT(*) as count 
    FROM equipment_issues ei
    JOIN room_equipment re ON ei.equipment_id = re.equipment_id
    JOIN rooms r ON re.room_id = r.id
    JOIN buildings b ON r.building_id = b.id
    WHERE b.department = ?
    GROUP BY ei.status
");
$stmt->bind_param("s", $department);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $issue_stats[$row['status']] = $row['count'];
}

// Get monthly room request trends (last 6 months)
$monthly_stats = [];
$stmt = $conn->prepare("
    SELECT 
        DATE_FORMAT(RequestDate, '%Y-%m') as month,
        COUNT(*) as count 
    FROM room_requests r
    JOIN rooms rm ON r.RoomID = rm.id
    JOIN buildings b ON rm.building_id = b.id
    WHERE b.department = ?
    AND RequestDate >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY DATE_FORMAT(RequestDate, '%Y-%m')
    ORDER BY month ASC
");
$stmt->bind_param("s", $department);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $monthly_stats[$row['month']] = $row['count'];
}

// Get recent equipment issues
$recent_issues = [];
$stmt = $conn->prepare("
    SELECT ei.id, e.name as equipment_name, ei.issue_type, ei.status, ei.reported_at
    FROM equipment_issues ei
    JOIN equipment e ON ei.equipment_id = e.id
    JOIN room_equipment re ON ei.equipment_id = re.equipment_id
    JOIN rooms r ON re.room_id = r.id
    JOIN buildings b ON r.building_id = b.id
    WHERE b.department = ?
    ORDER BY ei.reported_at DESC
    LIMIT 5
");
$stmt->bind_param("s", $department);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $recent_issues[] = $row;
}

// Get room request statistics filtered by admin's students and teachers
$room_stats = [];
$stmt = $conn->prepare("
    SELECT rr.Status, COUNT(*) as count 
    FROM room_requests rr
    LEFT JOIN student s ON rr.StudentID = s.StudentID
    LEFT JOIN teacher t ON rr.TeacherID = t.TeacherID
    WHERE (s.AdminID = ? OR t.AdminID = ?)
    GROUP BY rr.Status
");
$stmt->bind_param("ii", $admin_id, $admin_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $room_stats[$row['Status']] = $row['count'];
}

// Get equipment issues statistics filtered by admin's students and teachers
$issue_stats = [];
$stmt = $conn->prepare("
    SELECT ei.status, COUNT(*) as count 
    FROM equipment_issues ei
    LEFT JOIN student s ON ei.student_id = s.StudentID
    LEFT JOIN teacher t ON ei.teacher_id = t.TeacherID
    WHERE (s.AdminID = ? OR t.AdminID = ?)
    GROUP BY ei.status
");
$stmt->bind_param("ii", $admin_id, $admin_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $issue_stats[$row['status']] = $row['count'];
}

// Get monthly room request trends (last 6 months) filtered by admin's students and teachers
$monthly_stats = [];
$stmt = $conn->prepare("
    SELECT 
        DATE_FORMAT(rr.RequestDate, '%Y-%m') as month,
        COUNT(*) as count 
    FROM room_requests rr
    LEFT JOIN student s ON rr.StudentID = s.StudentID
    LEFT JOIN teacher t ON rr.TeacherID = t.TeacherID
    WHERE (s.AdminID = ? OR t.AdminID = ?)
    AND rr.RequestDate >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY DATE_FORMAT(rr.RequestDate, '%Y-%m')
    ORDER BY month ASC
");
$stmt->bind_param("ii", $admin_id, $admin_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $monthly_stats[$row['month']] = $row['count'];
}

// Get recent equipment issues filtered by admin's students and teachers
$recent_issues = [];
$stmt = $conn->prepare("
    SELECT 
        ei.id, 
        e.name as equipment_name, 
        ei.issue_type, 
        ei.status, 
        ei.reported_at,
        COALESCE(s.FirstName, t.FirstName) as first_name,
        COALESCE(s.LastName, t.LastName) as last_name,
        CASE 
            WHEN s.StudentID IS NOT NULL THEN 'Student' 
            WHEN t.TeacherID IS NOT NULL THEN 'Teacher' 
            ELSE 'Unknown' 
        END as user_type
    FROM equipment_issues ei
    JOIN equipment e ON ei.equipment_id = e.id
    LEFT JOIN student s ON ei.student_id = s.StudentID
    LEFT JOIN teacher t ON ei.teacher_id = t.TeacherID
    WHERE (s.AdminID = ? OR t.AdminID = ?)
    ORDER BY ei.reported_at DESC
    LIMIT 5
");
$stmt->bind_param("ii", $admin_id, $admin_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $recent_issues[] = $row;
}
