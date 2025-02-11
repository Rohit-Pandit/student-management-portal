<?php
session_start();
require_once "database/db.php"; // Include database connection

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch subjects the student is enrolled in
$query = "SELECT subjects.name FROM subjects
          JOIN enrollments ON subjects.id = enrollments.subject_id
          WHERE enrollments.user_id = ?";
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
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION["user_name"]; ?>!</h2>
        <p>Your email: <?php echo $_SESSION["user_email"]; ?></p>
        <h3>Your Enrolled Subjects:</h3>
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>" . htmlspecialchars($row["name"]) . "</li>";
                }
            } else {
                echo "<p>You are not enrolled in any subjects.</p>";
            }
            ?>
        </ul>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
