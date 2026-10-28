<?php
$db = new mysqli('localhost', 'root', '', 'school management');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (!isset($_GET['DinnerMoneyID'])) {
    header("Location: Dinner_money.php");
    exit();
}

$dinnerMoneyID = (int) $_GET['DinnerMoneyID'];

$sql = "DELETE FROM dinner_money WHERE DinnerMoneyID = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $dinnerMoneyID);

if ($stmt->execute()) {
    header("Location: Dinner_money.php");
    exit();
} else {
    echo "Error deleting record: " . $stmt->error;
}

$stmt->close();
$db->close();
?>
