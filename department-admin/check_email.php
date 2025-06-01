<?php
// Include database configuration
require_once __DIR__ . '/../database/config.php';

header('Content-Type: application/json');

if (isset($_GET['email']) && isset($_GET['type'])) {
    $email = trim($_GET['email']);
    $type = trim($_GET['type']); // 'student' or 'teacher'

    try {
        // Get database connection
        $conn = get_db_connection();

        if ($type === 'student') {
            // Check if email exists in student table
            $stmt = $conn->prepare("SELECT COUNT(*) FROM student WHERE Email = ?");
        } else if ($type === 'teacher') {
            // Check if email exists in teacher table
            $stmt = $conn->prepare("SELECT COUNT(*) FROM teacher WHERE Email = ?");
        } else {
            echo json_encode(['error' => 'Invalid type parameter']);
            exit;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        $exists = ($count > 0);

        echo json_encode(['exists' => $exists]);

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Missing required parameters']);
}
