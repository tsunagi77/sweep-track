<?php
$conn = mysqli_connect('localhost', 'root', '', 'mmda');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if (!$employee_id || !$action) {
        echo "Employee ID and action are required!";
        exit;
    }

    $checkEmployee = $conn->prepare("SELECT employeeID FROM sweepers WHERE employeeID = ?");
    $checkEmployee->bind_param("i", $employee_id);
    $checkEmployee->execute();
    $result = $checkEmployee->get_result();

    if ($result->num_rows === 0) {
        echo "Invalid Employee ID!";
        exit;
    }

    $date = date('Y-m-d');
    $time = date('H:i:s');

    if ($action === 'time_in') {
        $stmt = $conn->prepare("INSERT INTO attendance (employee_id, date, time_in, status) VALUES (?, ?, ?, 'Checked')");
        $stmt->bind_param("iss", $employee_id, $date, $time);
    } else if ($action === 'time_out') {
        $stmt = $conn->prepare("UPDATE attendance SET time_out = ? WHERE employee_id = ? AND date = ?");
        $stmt->bind_param("sis", $time, $employee_id, $date);
    } else {
        echo "Invalid action!";
        exit;
    }

    if ($stmt->execute()) {
        echo ucfirst($action) . " recorded successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
