<?php
$conn = new mysqli("localhost", "root", "", "school management");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (isset($_GET['classID'])) {
    $classID = intval($_GET['classID']);
    $sql = "DELETE FROM classes WHERE classID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $classID);
    if ($stmt->execute()) {
        header("Location: classes.php");
        exit();
    } else {
        echo "Error deleting class: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
