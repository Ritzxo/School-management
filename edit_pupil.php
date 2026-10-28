<?php
$conn = new mysqli("localhost", "root", "", "school management");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (isset($_GET['Pupil_ID'])) {
    $pupil_id = intval($_GET['Pupil_ID']);
    $sql = "SELECT * FROM pupils WHERE Pupil_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pupil_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pupil = $result->fetch_assoc();
    $stmt->close();
}

$classes = $conn->query("SELECT classID FROM classes");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pupil_id = intval($_POST['Pupil_ID']);
    $classID = intval($_POST['classID']);
    $name = $conn->real_escape_string($_POST['name']);
    $address = $conn->real_escape_string($_POST['address']);
    $medical_info = intval($_POST['medical_info']);

    $update_sql = "UPDATE pupils SET classID = ?, Name = ?, Address = ?, Medical_INFO = ? WHERE Pupil_ID = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("issii", $classID, $name, $address, $medical_info, $pupil_id);

    if ($update_stmt->execute()) {
        header("Location: pupils.php");
        exit();
    } else {
        echo "Error updating pupil: " . $update_stmt->error;
    }
    $update_stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center"> 
                <h2>Edit Pupil</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="Pupil_ID" value="<?php echo htmlspecialchars($pupil['Pupil_ID']); ?>">

                    <div class="mb-3">
                        <label for="classID" class="form-label">Class ID:</label>
                        <select name="classID" class="form-select" required>
                            <?php while ($class = $classes->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($class['classID']) ?>"
                                    <?= $class['classID'] == $pupil['classID'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($class['classID']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" name="name" id="name" 
                               value="<?php echo htmlspecialchars($pupil['Name']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address:</label>
                        <input type="text" class="form-control" name="address" id="address" 
                               value="<?php echo htmlspecialchars($pupil['Address']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="medical_info" class="form-label">Medical Info:</label>
                        <input type="number" class="form-control" name="medical_info" id="medical_info" 
                               value="<?php echo htmlspecialchars($pupil['Medical_info']); ?>" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="pupils.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
