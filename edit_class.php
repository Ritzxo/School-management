<?php
$conn = new mysqli("localhost", "root", "", "school management");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (isset($_GET['classID'])) {
    $classID = intval($_GET['classID']);
    $sql = "SELECT * FROM classes WHERE classID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $classID);
    $stmt->execute();
    $result = $stmt->get_result();
    $class = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classID = intval($_POST['classID']);
    $className = $conn->real_escape_string($_POST['className']);
    $capacity = intval($_POST['capacity']);

    $update_sql = "UPDATE classes SET className = ?, capacity = ? WHERE classID = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sii", $className, $capacity, $classID);
    if ($update_stmt->execute()) {
        header("Location: classes.php");
        exit();
    } else {
        echo "Error updating class: " . $update_stmt->error;
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
                <h2>Edit Class</h2>
            </div>
            <div class="card-body">
                <form action="edit_class.php" method="POST">
                    <input type="hidden" name="classID" value="<?php echo htmlspecialchars($class['classID']); ?>">
                    <div class="mb-3">
                        <label for="className" class="form-label">Class Name:</label>
                        <input type="text" class="form-control" name="className" id="className" value="<?php echo htmlspecialchars($class['className']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Capacity:</label>
                        <input type="number" class="form-control" name="capacity" id="capacity" value="<?php echo htmlspecialchars($class['capacity']); ?>" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
