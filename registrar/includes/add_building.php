<?php

// Database connection
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
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_building'])) {
        // Sanitize and validate inputs
        $building_name = trim(htmlspecialchars($_POST['building_name'] ?? '', ENT_QUOTES, 'UTF-8'));
        $department = trim(htmlspecialchars($_POST['department'] ?? '', ENT_QUOTES, 'UTF-8'));
        $number_of_floors = filter_input(INPUT_POST, 'number_of_floors', FILTER_VALIDATE_INT);

        if ($building_name && $department && $number_of_floors !== false && $number_of_floors > 0) {
            // Check if number of floors exceeds maximum limit
            if ($number_of_floors > 6) {
                $_SESSION['error_message'] = "Number of floors cannot exceed 6.";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }

            // Check for duplicate building name
            $check_stmt = $conn->prepare("SELECT id FROM buildings WHERE building_name = ?");
            if (!$check_stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $check_stmt->bind_param("s", $building_name);
            if (!$check_stmt->execute()) {
                throw new Exception("Execute failed: " . $check_stmt->error);
            }

            $result = $check_stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION['error_message'] = "A building with this name already exists.";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
            $check_stmt->close();

            $stmt = $conn->prepare("INSERT INTO buildings (building_name, department, number_of_floors) VALUES (?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("ssi", $building_name, $department, $number_of_floors);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Building added successfully!";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $_SESSION['error_message'] = "Error adding building: " . $stmt->error;
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

    // Fetch buildings
    $stmt = $conn->prepare("SELECT * FROM buildings ORDER BY created_at ASC");
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
