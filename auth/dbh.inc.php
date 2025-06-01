<?php
// database configuration
require_once __DIR__ . '/../database/config.php';

// database connection
$conn = get_db_connection();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
