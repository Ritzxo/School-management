<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate inputs
$required = ['pupil_id', 'amount', 'payment_date'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        die("Error: All fields are required!");
    }
}

// Sanitize inputs
$pupil_id = intval($_POST['pupil_id']);
$amount = intval($_POST['amount']);
$payment_date = date('Y-m-d', strtotime($_POST['payment_date']));

// Prepare and execute insert
$sql = "INSERT INTO dinner_money (Pupil_ID, Amount, PaymentDate) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $pupil_id, $amount, $payment_date);

if ($stmt->execute()) {
    header("Location: dinner_money.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>