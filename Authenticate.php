<?php
session_start();
$conn = new mysqli("localhost", "root", "", "school management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Verify user
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        
        if (hash("sha256", $password) === $hashed_password) {
            $_SESSION["username"] = $username;
            header("Location: dashboard.php");
            exit();
        }
    }

    header("Location: login.php?error=1");
    exit();
}
?>
