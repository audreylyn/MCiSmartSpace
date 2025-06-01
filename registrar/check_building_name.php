<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_db";

header('Content-Type: application/json');

// Debug logging removed

if (isset($_GET['name'])) {
    $building_name = trim($_GET['name']);

    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Check if building name exists
        $stmt = $conn->prepare("SELECT id FROM buildings WHERE building_name = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $building_name);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;

        // Debug logging removed

        echo json_encode(['exists' => $exists]);

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        // Debug logging removed
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    // Debug logging removed
    echo json_encode(['error' => 'No name parameter provided']);
}
