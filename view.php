<?php
$conn = mysqli_connect('localhost', 'root', '', 'mmda');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$employee_id = $_GET['employee_id'] ?? null;

if (!$employee_id) {
    echo json_encode(["error" => "Employee ID is required!"]);
    exit;
}

$checkEmployee = $conn->prepare("SELECT employeeID FROM sweepers WHERE employeeID = ?");
$checkEmployee->bind_param("i", $employee_id);
$checkEmployee->execute();
$result = $checkEmployee->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "Invalid Employee ID!"]);
    exit;
}

$sql = "SELECT date, time_in, time_out, status FROM attendance WHERE employee_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();

$attendance = [];
while ($row = $result->fetch_assoc()) {
    $attendance[] = $row;
}
$stmt->close();

header('Content-Type: application/json');
echo json_encode($attendance);
?>
