<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'mmda');

    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
        exit();
    }

$stmt = $conn->prepare("INSERT INTO healthform_responses (question_number, answer) VALUES (?, ?)");

    foreach ($_POST as $question => $answer) {
        if (strpos($question, 'q') === 0) {
            $questionNumber = intval(substr($question, 1));
            $stmt->bind_param("is", $questionNumber, $answer);
            $stmt->execute();
        }
    }
    $stmt->close();
    $conn->close();

    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Error"]);
}
?>
