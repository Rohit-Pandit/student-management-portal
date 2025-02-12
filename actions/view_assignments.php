<?php
session_start();
require_once "../database/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch submitted assignments
$query = "SELECT assignments.id, subjects.name AS subject_name, assignments.file_name, assignments.file_path, assignments.remarks 
          FROM assignments
          INNER JOIN subjects ON assignments.subject_id = subjects.id
          WHERE assignments.student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Assignments</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <div class="container">
        <h2>Your Submitted Assignments</h2>
        <table>
            <tr>
                <th>Subject</th>
                <th>File</th>
                <th>Remarks</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["subject_name"]); ?></td>
                    <td><a href="<?php echo $row["file_path"]; ?>" target="_blank"><?php echo htmlspecialchars($row["file_name"]); ?></a></td>
                    <td><?php echo $row["remarks"] ? htmlspecialchars($row["remarks"]) : "No remarks yet"; ?></td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
