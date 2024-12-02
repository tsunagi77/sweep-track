<?php
header('Content-Type: application/json');
$conn = mysqli_connect('localhost', 'root', '', 'mmda');

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => $conn->connect_error]));
}

$result = $conn->query("
    SELECT question_number, answer, COUNT(*) AS count
    FROM healthform_responses
    GROUP BY question_number, answer
");

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();
echo json_encode($data);
?>
