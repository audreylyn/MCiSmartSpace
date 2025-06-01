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

if (isset($_GET['name']) && isset($_GET['building_id'])) {
    $room_name = trim($_GET['name']);
    $building_id = (int)$_GET['building_id'];

    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Check if room name exists in the specified building
        $stmt = $conn->prepare("SELECT id FROM rooms WHERE room_name = ? AND building_id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("si", $room_name, $building_id);
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
    echo json_encode(['error' => 'Missing required parameters']);
}
