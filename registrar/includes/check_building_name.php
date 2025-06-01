<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_db";

header('Content-Type: application/json');

if (isset($_GET['name'])) {
    $building_name = trim($_GET['name']);

    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Check if building name exists
        $stmt = $conn->prepare("SELECT id FROM buildings WHERE building_name = ?");
        $stmt->bind_param("s", $building_name);
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
    echo json_encode(['error' => 'No name parameter provided']);
}
