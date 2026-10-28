<?php
$db = new mysqli('localhost', 'root', '', 'school management');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (!isset($_GET['Pupil_ID'])) {
    header("Location: pupils.php");
    exit();
}

$pupil_id = (int) $_GET['Pupil_ID'];

// Delete the pupil
$sql = "DELETE FROM pupils WHERE Pupil_ID = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $pupil_id);
if ($stmt->execute()) {
    header("Location: pupils.php");
    exit();
} else {
    echo "Error deleting pupil: " . $stmt->error;
}
$stmt->close();
$db->close();
?>
