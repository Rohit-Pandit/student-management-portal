<?php
session_start();
require_once "../database/db.php"; // Include database connection

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch all subjects
$query = "SELECT * FROM subjects";
$result = $conn->query($query);

// Handle enrollment request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["subject_id"])) {
    $subject_id = $_POST["subject_id"];

    // Check if the student is already enrolled
    $check_query = "SELECT * FROM enrollments WHERE user_id = ? AND subject_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $user_id, $subject_id);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows == 0) {
        // Enroll the student
        $enroll_query = "INSERT INTO enrollments (user_id, subject_id) VALUES (?, ?)";
        $stmt = $conn->prepare($enroll_query);
        $stmt->bind_param("ii", $user_id, $subject_id);
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Enrollment successful!</p>";
        } else {
            echo "<p style='color: red;'>Error enrolling in subject.</p>";
        }
    } else {
        echo "<p style='color: red;'>You are already enrolled in this subject.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll in Subjects</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <div class="container">
        <h2>Enroll in Subjects</h2>
        <form method="POST">
            <label for="subject_id">Select a Subject:</label>
            <select name="subject_id" required>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?php echo $row["id"]; ?>">
                        <?php echo htmlspecialchars($row["name"]); ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit">Enroll</button>
        </form>
        <br>
        <a href="dashboard.php">Go Back to Dashboard</a>
    </div>
</body>
</html>
