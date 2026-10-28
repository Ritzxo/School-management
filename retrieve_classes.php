<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sql = "SELECT * FROM classes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $classes = array();
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($classes);
} else {
    echo json_encode(array("message" => "No classes found."));
}

$conn->close();
?>