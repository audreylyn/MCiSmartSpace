<?php
header('Content-Type: application/json');

try {
    $conn = new mysqli('localhost', 'root', '', 'my_db');

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $data = json_decode(file_get_contents('php://input'), true);
    $equipment_id = $data['equipment_id'];
    $checked = $data['checked'];

    $stmt = $conn->prepare("UPDATE room_equipment SET checked = ? WHERE id = ?");
    $stmt->bind_param("ii", $checked, $equipment_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception("Error updating status: " . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    $conn->close();
}
