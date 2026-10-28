<script>
    // Redirect to login if not logged in
    if (sessionStorage.getItem("loggedIn") !== "true") {
        window.location.href = "login.html";
    }
</script>

<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "school management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle deletion of a parent record
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM parents_guardians WHERE ParentID = ?");
    if (!$stmt) {
        die("Prepare failed (delete): " . $conn->error);
    }
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    // Optionally, you might also want to delete the related linking records:
    $stmt2 = $conn->prepare("DELETE FROM pupils_parents WHERE parent_id = ?");
    if ($stmt2) {
        $stmt2->bind_param("i", $delete_id);
        $stmt2->execute();
        $stmt2->close();
    }
    header("Location: parents.php");
    exit();
}

// Handle form submission to add a new parent
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $conn->real_escape_string($_POST['name']);
    $address = $conn->real_escape_string($_POST['address']);
    $email   = $conn->real_escape_string($_POST['email']);
    $phone   = intval($_POST['phone']);
    $pupil_ids = isset($_POST['pupils']) ? $_POST['pupils'] : [];

    // Insert new parent into parents_guardians table
    $stmt = $conn->prepare("INSERT INTO parents_guardians (Name, Address, Email, phone) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed (insert): " . $conn->error);
    }
    $stmt->bind_param("sssi", $name, $address, $email, $phone);
    if ($stmt->execute()) {
        $parent_id = $conn->insert_id;
        // Link selected pupils via the pupils_parents table
        if (!empty($pupil_ids)) {
            $stmt_link = $conn->prepare("INSERT INTO pupils_parents (parent_id, pupil_id) VALUES (?, ?)");
            if (!$stmt_link) {
                die("Prepare failed for linking: " . $conn->error);
            }
            foreach ($pupil_ids as $pupil_id) {
                $pupil_id = intval($pupil_id);
                $stmt_link->bind_param("ii", $parent_id, $pupil_id);
                $stmt_link->execute();
            }
            $stmt_link->close();
        }
        $stmt->close();
        header("Location: parents.php");
        exit();
    } else {
        echo "Error adding parent: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch parents with their associated pupils
$sql = "SELECT p.ParentID, p.Name, p.Address, p.Email, p.phone, 
               GROUP_CONCAT(pl.Name SEPARATOR ', ') AS Pupils
        FROM parents_guardians p
        LEFT JOIN pupils_parents pp ON p.ParentID = pp.parent_id
        LEFT JOIN pupils pl ON pp.pupil_id = pl.Pupil_ID
        GROUP BY p.ParentID";
$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Fetch pupils for the dropdown in the add form
$pupilsDropdown = $conn->query("SELECT Pupil_ID, Name FROM pupils");
if (!$pupilsDropdown) {
    die("Dropdown query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parents Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .table-responsive { overflow-x: auto; }
        .actions a.btn { margin-right: 5px; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-school"></i> St Alphonsus Primary School</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="classes.php">Classes</a></li>
                    <li class="nav-item"><a class="nav-link" href="pupils.php">Pupils</a></li>
                    <li class="nav-item"><a class="nav-link active" href="parents.php">Parents</a></li>
                    <li class="nav-item"><a class="nav-link" href="teachers.php">Teachers</a></li>
                    <li class="nav-item"><a class="nav-link" href="Dinner_money.php">Dinner</a></li>
                    <li class="nav-item"><a class="nav-link" href="library_books.php">Library</a></li>
                    <li class="nav-item"><a class="nav-link" href="TA.php">Teaching Assistants</a></li>
                    <li class="nav-item" id="logoutBtn" style="display: none;">
                        <a class="nav-link" href="#" onclick="logout()">Logout</a>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <!-- Add Parent Form -->
        <div class="card shadow-lg mb-5">
            <div class="card-header bg-primary text-white text-center">
                <h2>Add New Parent/Guardian</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address:</label>
                        <input type="text" name="address" id="address" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone:</label>
                        <input type="number" name="phone" id="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="pupils" class="form-label">Associated Pupils:</label>
                        <select name="pupils[]" id="pupils" class="form-select" multiple required>
                            <?php while ($pupil = $pupilsDropdown->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($pupil['Pupil_ID']) ?>">
                                    <?= htmlspecialchars($pupil['Name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <small class="form-text text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple pupils.</small>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Add Parent</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Existing Parents Table -->
        <div class="card shadow-lg">
            <div class="card-header bg-info text-white text-center">
                <h2>Existing Parents/Guardians</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Parent ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Pupils</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['ParentID']) ?></td>
                                    <td><?= htmlspecialchars($row['Name']) ?></td>
                                    <td><?= htmlspecialchars($row['Address']) ?></td>
                                    <td><?= htmlspecialchars($row['Email']) ?></td>
                                    <td><?= htmlspecialchars($row['phone']) ?></td>
                                    <td><?= htmlspecialchars($row['Pupils']) ?></td>
                                    <td class="actions">
                                        <a href="edit_parent.php?ParentID=<?= urlencode($row['ParentID']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="?delete_id=<?= urlencode($row['ParentID']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this parent?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            <?php if ($result->num_rows === 0): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No parents found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p>&copy; 2024-25 St Alphonsus Primary School. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

<?php $conn->close(); ?>
