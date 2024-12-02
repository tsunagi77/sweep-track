<?php
$conn = mysqli_connect('localhost', 'root', '', 'mmda');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, employee_id, suggestion_text, submitted_at FROM suggestions ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggestions View</title>
</head>
<body>
    <h1>Submitted Suggestions</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Employee ID</th>
            <th>Suggestion</th>
            <th>Submitted At</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['employee_id']}</td>
                    <td>{$row['suggestion_text']}</td>
                    <td>{$row['submitted_at']}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No suggestions found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
