<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $file = $_FILES['announcement'];
    $targetFile = $uploadDir . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        $conn = new mysqli('localhost', 'root', '', 'mmda');
        if ($conn->connect_error) {
            echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO announcements (image_path) VALUES (?)");
        $stmt->bind_param('s', $targetFile);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Image uploaded successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        }
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload image.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
