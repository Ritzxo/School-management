<?php 
?>
<script>
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

// Check for the ParentID parameter in the URL
if (!isset($_GET['ParentID'])) {
    header("Location: parents.php");
    exit();
}
$parent_id = intval($_GET['ParentID']);

// Fetch parent details
$stmt = $conn->prepare("SELECT * FROM parents_guardians WHERE ParentID = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$result = $stmt->get_result();
$parent = $result->fetch_assoc();
$stmt->close();

// Fetch associated pupils for this parent from the linking table (pupils_parents)
$associated_pupils = [];
$stmt_assoc = $conn->prepare("SELECT pupil_id FROM pupils_parents WHERE parent_id = ?");
if ($stmt_assoc) {
    $stmt_assoc->bind_param("i", $parent_id);
    $stmt_assoc->execute();
    $result_assoc = $stmt_assoc->get_result();
    while ($row_assoc = $result_assoc->fetch_assoc()) {
        $associated_pupils[] = $row_assoc['pupil_id'];
    }
    $stmt_assoc->close();
}

// Fetch all pupils for the dropdown
$pupilsResult = $conn->query("SELECT Pupil_ID, Name FROM pupils");
if (!$pupilsResult) {
    die("Dropdown query failed: " . $conn->error);
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $conn->real_escape_string($_POST['name']);
    $address = $conn->real_escape_string($_POST['address']);
    $email   = $conn->real_escape_string($_POST['email']);
    $phone   = intval($_POST['phone']);
    
    // Update parent's details
    $stmt = $conn->prepare("UPDATE parents_guardians SET Name = ?, Address = ?, Email = ?, phone = ? WHERE ParentID = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sssii", $name, $address, $email, $phone, $parent_id);
    if ($stmt->execute()) {
        $stmt->close();
        
        // First, remove all existing pupil associations for this parent.
        $stmt_del = $conn->prepare("DELETE FROM pupils_parents WHERE parent_id = ?");
        if ($stmt_del) {
            $stmt_del->bind_param("i", $parent_id);
            $stmt_del->execute();
            $stmt_del->close();
        }
        
        // Insert new associations (if any)
        if (isset($_POST['pupils']) && is_array($_POST['pupils'])) {
            $pupil_ids = $_POST['pupils'];
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
        header("Location: parents.php");
        exit();
    } else {
        echo "Error updating parent: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Parent</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap & FontAwesome (same design as main page) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Select2 CSS (for enhanced dropdown) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container { width: 100% !important; }
    </style>
</head>
<body>
    <!-- Navbar (same as main page) -->
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
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Edit Parent Form -->
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h2>Edit Parent</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <!-- Parent details -->
                    <div class="mb-3">
                        <label class="form-label">Name:</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($parent['Name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address:</label>
                        <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($parent['Address']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($parent['Email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone:</label>
                        <input type="number" name="phone" class="form-control" value="<?= htmlspecialchars($parent['phone']) ?>" required>
                    </div>
                    <!-- Associated Pupils Dropdown -->
                    <div class="mb-3">
                        <label class="form-label">Associated Pupils:</label>
                        <select name="pupils[]" id="pupils" class="form-select" multiple="multiple">
                            <?php while ($row = $pupilsResult->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($row['Pupil_ID']) ?>" <?= in_array($row['Pupil_ID'], $associated_pupils) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['Name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <small class="form-text text-muted">Select one or more pupils.</small>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="parents.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer (same as main page) -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p>&copy; 2024-25 St Alphonsus Primary School. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts: Bootstrap, jQuery and Select2 for enhanced dropdown -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

        // Initialize Select2 for pupil selection
        $(document).ready(function() {
            $('#pupils').select2({
                placeholder: "Select one or more pupils",
                allowClear: true
            });
        });
    </script>
</body>
</html>
