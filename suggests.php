<?php
$conn = mysqli_connect('localhost', 'root', '', 'mmda');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = $_POST['employeeId'];
    $suggestionText = $_POST['suggestionText'];

    $stmt = $conn->prepare("INSERT INTO suggestions (employee_id, suggestion_text) VALUES (?, ?)");
    $stmt->bind_param("ss", $employeeId, $suggestionText);

    if ($stmt->execute()) {
        echo "Suggestion submitted Successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
