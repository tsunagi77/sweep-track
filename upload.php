<?php
header('Content-Type: application/json');

$conn = mysqli_connect('localhost', 'root', '', 'mmda');
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeID = trim($_POST['employeeID'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($employeeID)) {
        echo json_encode(['success' => false, 'message' => 'Employee ID is required.']);
        exit;
    }

    if (!isset($_FILES['file'])) {
        echo json_encode(['success' => false, 'message' => 'No files uploaded.']);
        exit;
    }

    $docsDir = "Docs/";
    if (!is_dir($docsDir) && !mkdir($docsDir, 0777, true)) {
        echo json_encode(['success' => false, 'message' => 'Failed to create upload directory.']);
        exit;
    }

    $uploadedFiles = [];
    $errors = [];

    foreach ($_FILES['file']['name'] as $key => $name) {
        if ($_FILES['file']['error'][$key] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['file']['tmp_name'][$key];
            $safeName = uniqid() . '-' . basename($name);
            $filePath = $docsDir . $safeName;

            if (move_uploaded_file($tmpName, $filePath)) {
                $uploadedFiles[] = $filePath;

                $stmt = $conn->prepare("INSERT INTO Docs (employeeID, file_path, description) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $employeeID, $filePath, $description);

                if (!$stmt->execute()) {
                    $errors[] = "Database error for file $name: " . $stmt->error;
                }

                $stmt->close();
            } else {
                $errors[] = "Failed to move uploaded file: $name";
            }
        } else {
            $errors[] = "Error uploading file $name: Code " . $_FILES['file']['error'][$key];
        }
    }

    if (count($uploadedFiles) > 0) {
        echo json_encode(['success' => true, 'uploadedFiles' => $uploadedFiles, 'errors' => $errors]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No files were successfully uploaded.', 'errors' => $errors]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();
?>
