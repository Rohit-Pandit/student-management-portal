<?php
session_start();
require_once "../database/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch subjects for dropdown
$query = "SELECT subjects.id, subjects.name FROM subjects 
          INNER JOIN enrollments ON subjects.id = enrollments.subject_id 
          WHERE enrollments.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["assignment"])) {
    $subject_id = $_POST["subject_id"];
    $file_name = $_FILES["assignment"]["name"];
    $file_tmp = $_FILES["assignment"]["tmp_name"];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

    // Ensure the file is a PDF
    if ($file_ext != "pdf") {
        echo "<p style='color: red;'>Only PDF files are allowed.</p>";
    } else {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_path = $upload_dir . time() . "_" . $file_name;
        if (move_uploaded_file($file_tmp, $file_path)) {
            $insert_query = "INSERT INTO assignments (student_id, subject_id, file_name, file_path) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("iiss", $user_id, $subject_id, $file_name, $file_path);
            if ($stmt->execute()) {
                echo "<p style='color: green;'>Assignment uploaded successfully!</p>";
            } else {
                echo "<p style='color: red;'>Error uploading assignment.</p>";
            }
        } else {
            echo "<p style='color: red;'>Failed to upload file.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Assignment</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <div class="container">
        <h2>Upload Assignment</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="subject_id">Select Subject:</label>
            <select name="subject_id" required>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?php echo $row["id"]; ?>">
                        <?php echo htmlspecialchars($row["name"]); ?>
                    </option>
                <?php } ?>
            </select>

            <label for="assignment">Upload PDF:</label>
            <input type="file" name="assignment" accept=".pdf" required>

            <button type="submit">Upload</button>
        </form>
        <br>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
