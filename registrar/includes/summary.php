<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_db";

// Initialize result variable outside the try block to ensure it exists
$result = null;
$error_message = '';

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Set proper charset
    $conn->set_charset("utf8mb4");

    // Handle delete request
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_room'])) {
        $room_id = filter_input(INPUT_GET, 'delete_room', FILTER_VALIDATE_INT);

        if ($room_id) {
            // Start transaction to ensure data integrity
            $conn->begin_transaction();

            try {
                // First delete related records from room_equipment table
                $delete_equipment_sql = "DELETE FROM room_equipment WHERE room_id = ?";
                $delete_equipment_stmt = $conn->prepare($delete_equipment_sql);
                $delete_equipment_stmt->bind_param("i", $room_id);
                $delete_equipment_stmt->execute();
                $delete_equipment_stmt->close();

                // Now it's safe to delete the room
                $delete_sql = "DELETE FROM rooms WHERE id = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("i", $room_id);

                if ($delete_stmt->execute()) {
                    $conn->commit();
                    $_SESSION['success_message'] = "Room and its equipment assignments deleted successfully";
                } else {
                    throw new Exception("Error deleting room: " . $delete_stmt->error);
                }
                $delete_stmt->close();
            } catch (Exception $e) {
                // Rollback the transaction if any query fails
                $conn->rollback();
                $_SESSION['error_message'] = $e->getMessage();
            }

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }

    // Fetch buildings and rooms using prepared statement with ORDER BY
    $sql = "SELECT buildings.id AS building_id, buildings.building_name, buildings.department, buildings.number_of_floors, 
                   rooms.id AS room_id, rooms.room_name, rooms.room_type, rooms.capacity 
            FROM buildings 
            LEFT JOIN rooms ON buildings.id = rooms.building_id
            ORDER BY buildings.building_name ASC, rooms.room_name ASC";
    //dating INNER join
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Query preparation failed: " . $conn->error);
    }

    if (!$stmt->execute()) {
        throw new Exception("Query execution failed: " . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result === false) {
        throw new Exception("Failed to get result set: " . $stmt->error);
    }
    // Don't close the statement here as we need the result for display

    // Handle form submission for editing
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update') {
        $room_id = filter_input(INPUT_POST, 'room_id', FILTER_VALIDATE_INT);
        $room_name = trim(filter_input(INPUT_POST, 'room_name', FILTER_SANITIZE_STRING));
        $room_type = trim(filter_input(INPUT_POST, 'room_type', FILTER_SANITIZE_STRING));
        $capacity = filter_input(INPUT_POST, 'capacity', FILTER_VALIDATE_INT);
        $building_id = filter_input(INPUT_POST, 'building_id', FILTER_VALIDATE_INT);

        if ($room_id && $room_name && $room_type && $capacity !== false && $building_id !== false) {
            // Check if capacity exceeds maximum limit
            if ($capacity > 50) {
                $_SESSION['error_message'] = "Room capacity cannot exceed 50.";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }

            // Check for duplicate room name in the same building (excluding the current room)
            $check_sql = "SELECT id FROM rooms WHERE room_name = ? AND building_id = ? AND id != ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("sii", $room_name, $building_id, $room_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                $_SESSION['error_message'] = "A room with this name already exists in this building.";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
            $check_stmt->close();

            // Check if room exists before updating
            $check_sql = "SELECT id FROM rooms WHERE id = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("i", $room_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                $update_sql = "UPDATE rooms SET room_name = ?, room_type = ?, capacity = ?, building_id = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ssiii", $room_name, $room_type, $capacity, $building_id, $room_id);

                if ($update_stmt->execute()) {
                    $_SESSION['success_message'] = "Room updated successfully";
                } else {
                    $_SESSION['error_message'] = "Error updating room";
                }
                $update_stmt->close();
            }
            $check_stmt->close();

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
} catch (Exception $e) {
    // Log error and display user-friendly message
    error_log($e->getMessage());
    $error_message = "An error occurred: " . $e->getMessage();
}
