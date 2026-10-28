<script>
    if (sessionStorage.getItem("loggedIn") !== "true") {
        window.location.href = "login.html"; // redirect if not logged in
    }
</script>

<?php
$conn = new mysqli("localhost", "root", "", "school management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM teachers WHERE TeacherID = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    header("Location: teachers.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name             = $conn->real_escape_string($_POST['Name']);
    $address          = $conn->real_escape_string($_POST['Address']);
    $salary           = floatval($_POST['Salary']);
    $backgroundCheck  = $conn->real_escape_string($_POST['BackgroundCheck']);
    $classID          = intval($_POST['ClassID']);

    $stmt = $conn->prepare(
        "INSERT INTO teachers (Name, Address, Salary, BackgroundCheck, ClassID)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("ssssi", $name, $address, $salary, $backgroundCheck, $classID);

    if ($stmt->execute()) {
        header("Location: teachers.php");
        exit();
    } else {
        echo "Error adding teacher: " . $stmt->error;
    }
    $stmt->close();
}

$result = $conn->query("SELECT * FROM teachers ORDER BY TeacherID ASC");

$classes = $conn->query("SELECT classID, ClassName FROM classes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teaching Assistants Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .max-width-800 { max-width: 800px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-school"></i> St Alphonsus Primary School
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="classes.php">Classes</a></li>
                    <li class="nav-item"><a class="nav-link" href="pupils.php">Pupils</a></li>
                    <li class="nav-item"><a class="nav-link" href="parents.php">Parents</a></li>
                    <li class="nav-item"><a class="nav-link active" href="teachers.php">Teachers</a></li>
                    <li class="nav-item"><a class="nav-link" href="Dinner_money.php">Dinner</a></li>
                    <li class="nav-item"><a class="nav-link" href="library_books.php">Library</a></li>
                    <li class="nav-item"><a class="nav-link active" href="TA.php">Teaching Assistants</a></li>
                    <li class="nav-item" id="logoutBtn" style="display: none;">
                        <a class="nav-link" href="#" onclick="logout()">Logout</a>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5 max-width-800">
        <div class="card shadow-lg mb-5">
            <div class="card-header bg-primary text-white text-center">
                <h2>Add New Teacher</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="Name" class="form-label">Name:</label>
                        <input type="text" name="Name" id="Name" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="Address" class="form-label">Address:</label>
                        <input type="text" name="Address" id="Address" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="Salary" class="form-label">Salary:</label>
                        <input type="number" step="0.01" name="Salary" id="Salary" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="BackgroundCheck" class="form-label">Background Check:</label>
                        <select name="BackgroundCheck" id="BackgroundCheck" class="form-select" required>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="ClassID" class="form-label">Class:</label>
                        <select name="ClassID" id="ClassID" class="form-select" required>
                            <option value="">Select Class</option>
                            <?php if ($classes && $classes->num_rows > 0): ?>
                                <?php while($class = $classes->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($class['classID']) ?>">
                                        <?= htmlspecialchars($class['ClassName']) ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <option value="">No classes found</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Add Teacher</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card shadow-lg">
            <div class="card-header bg-info text-white text-center">
                <h2>Existing Teachers</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Teacher ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Salary</th>
                                <th>Background Check</th>
                                <th>Class</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <?php
                                    // Fetch class name based on ClassID
                                    $classResult = $conn->query("SELECT ClassName FROM classes WHERE classID = " . $row['ClassID']);
                                    $className = $classResult->fetch_assoc()['ClassName'];
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['TeacherID']) ?></td>
                                        <td><?= htmlspecialchars($row['Name']) ?></td>
                                        <td><?= htmlspecialchars($row['Address']) ?></td>
                                        <td><?= htmlspecialchars($row['Salary']) ?></td>
                                        <td><?= htmlspecialchars($row['BackgroundCheck']) ?></td>
                                        <td><?= htmlspecialchars($className) ?></td>
                                        <td>
                                            <a href="edit_teacher.php?TeacherID=<?= urlencode($row['TeacherID']) ?>" 
                                               class="btn btn-warning btn-sm">Edit</a>
                                            <a href="?delete_id=<?= urlencode($row['TeacherID']) ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Are you sure you want to delete this teacher?');">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No teachers found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p>&copy; 2024-25 St Alphonsus Primary School. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script>
    // Show logout if logged in
    if (sessionStorage.getItem("loggedIn") === "true") {
        document.getElementById("logoutBtn").style.display = "block";
    }

    // Logout function
    function logout() {
        sessionStorage.removeItem("loggedIn");
        window.location.href = "login.html";
    }
</script>
</body>
</html>

<?php
$conn->close();
?>
