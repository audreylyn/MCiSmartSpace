<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_db";

header('Content-Type: application/json');

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
        $stmt->bind_param("si", $room_name, $building_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $exists = $result->num_rows > 0;

        echo json_encode(['exists' => $exists]);

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Missing required parameters']);
}
