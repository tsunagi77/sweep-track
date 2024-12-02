<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'mmda');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM announcements ORDER BY created_at DESC LIMIT 1");
    if ($stmt->execute()) {
        echo "Announcement deleted successfully.";
    } else {
        echo "Error deleting announcement: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>