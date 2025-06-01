<?php
require 'auth/middleware.php';

// Get the current user's role
$userRole = '';
if (isset($_SESSION['role'])) {
    $userRole = $_SESSION['role'];
}

// Get equipment details from the URL
$equipmentId = isset($_GET['id']) ? $_GET['id'] : '';
$equipmentName = isset($_GET['name']) ? $_GET['name'] : '';
$roomName = isset($_GET['room']) ? $_GET['room'] : '';
$buildingName = isset($_GET['building']) ? $_GET['building'] : '';

// Build the query string to pass to the appropriate page
$queryString = http_build_query([
    'id' => $equipmentId,
    'name' => $equipmentName,
    'room' => $roomName,
    'building' => $buildingName,
    'source' => 'qr_redirect'
]);

// Redirect based on user role
if ($userRole == 'Teacher') {
    header("Location: teacher/report-equipment-issue.php?$queryString");
    exit;
} else if ($userRole == 'Student') {
    header("Location: student/report-equipment-issue.php?$queryString");
    exit;
} else {
    exit;
}
