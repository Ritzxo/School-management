<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school management";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Validate inputs
if (empty($_POST['classID']) || empty($_POST['className']) || empty($_POST['capacity'])) {
    die("All fields are required!");
}

$classID = intval($_POST['classID']);
$className = $conn->real_escape_string($_POST['className']);
$capacity = intval($_POST['capacity']);

// Check for existing class ID
$check_sql = "SELECT classID FROM classes WHERE classID = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $classID);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    // Redirect back with error message
    header("Location: classes.php?error=duplicate");
    exit();
}

// Insert new class if no duplicate found
$insert_sql = "INSERT INTO classes (classID, className, capacity) VALUES (?, ?, ?)";
$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param("isi", $classID, $className, $capacity);

if ($insert_stmt->execute()) {
    header("Location: classes.php");
    exit();
} else {
    echo "Error inserting class: " . $insert_stmt->error;
}

// Close connections
$check_stmt->close();
$insert_stmt->close();
$conn->close();
?>