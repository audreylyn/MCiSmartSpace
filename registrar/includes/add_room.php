<?php

// Database connection and main logic remains the same
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_db";

// Initialize messages
$error_message = '';
$success_message = '';

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_room'])) {
        // Sanitize and validate inputs
        $room_name = trim(htmlspecialchars($_POST['room_name'] ?? '', ENT_QUOTES, 'UTF-8'));
        $room_type = trim(htmlspecialchars($_POST['room_type'] ?? '', ENT_QUOTES, 'UTF-8'));
        $capacity = filter_input(INPUT_POST, 'capacity', FILTER_VALIDATE_INT);
        $building_id = filter_input(INPUT_POST, 'building_id', FILTER_VALIDATE_INT);

        if ($room_name && $room_type && $capacity !== false && $capacity > 0 && $building_id !== false) {
            // Check if capacity exceeds maximum limit
            if ($capacity > 50) {
                $_SESSION['error_message'] = "Room capacity cannot exceed 50.";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }

            // Check for duplicate room name in the same building
            $check_stmt = $conn->prepare("SELECT id FROM rooms WHERE room_name = ? AND building_id = ?");
            if (!$check_stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $check_stmt->bind_param("si", $room_name, $building_id);
            if (!$check_stmt->execute()) {
                throw new Exception("Execute failed: " . $check_stmt->error);
            }

            $result = $check_stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION['error_message'] = "A room with this name already exists in this building.";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
            $check_stmt->close();

            $stmt = $conn->prepare("INSERT INTO rooms (room_name, room_type, capacity, building_id) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("ssii", $room_name, $room_type, $capacity, $building_id);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Room added successfully!";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $_SESSION['error_message'] = "Error adding room: " . $stmt->error;
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
            $stmt->close();
        } else {
            $_SESSION['error_message'] = "Please fill all fields with valid values.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }

    // Fetch rooms with building names
    $stmt = $conn->prepare("SELECT rooms.*, buildings.building_name 
                           FROM rooms 
                           JOIN buildings ON rooms.building_id = buildings.id 
                           ORDER BY rooms.created_at ASC");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $requests = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} catch (Exception $e) {
    $error_message = $e->getMessage();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
