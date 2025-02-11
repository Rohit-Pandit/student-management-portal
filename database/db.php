<?php
$host = "localhost";
$user = "root";
$password = ""; // Leave it empty since there's no password
$database = "student_portal";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connected successfully!";
}
?>
