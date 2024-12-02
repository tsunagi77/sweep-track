<?php
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'mmda');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

$result = $conn->query("SELECT image_path FROM announcements ORDER BY created_at DESC LIMIT 1");
if ($result) {
    $row = $result->fetch_assoc();
    echo json_encode(['success' => true, 'imagePath' => $row['image_path'] ?? null]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error fetching announcement: ' . $conn->error]);
}

$conn->close();
?>
