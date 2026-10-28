<script>
    if (sessionStorage.getItem("loggedIn") !== "true") {
        window.location.href = "login.html"; // redirect if not logged in
    }
</script>

<?php
session_start();

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "school management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$editMode = false;
$editID = "";
$name = "";
$address = "";
$classID = "";
$phone = "";
$salary = "";  
$message = "";

// Handle delete request
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delID = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM `teaching assistants` WHERE AssistantID = ?");
    $stmt->bind_param("i", $delID);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Record deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting record.";
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle edit request
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $editID = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM `teaching assistants` WHERE AssistantID = ?");
    $stmt->bind_param("i", $editID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $name = $row['Name'];
        $address = $row['Address'];
        $classID = $row['ClassID'];
        $phone = $row['Phone'];
        $salary = $row['Salary'];  
        $editMode = true;
    }
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $_POST['Name'];
    $address = $_POST['Address'];
    $classID = $_POST['ClassID'];
    $phone   = $_POST['Phone'];
    $salary  = $_POST['Salary']; 

    if (!empty($_POST['AssistantID'])) {
        // Update existing record
        $assistantID = intval($_POST['AssistantID']);
        $stmt = $conn->prepare("UPDATE `teaching assistants` SET Name = ?, Address = ?, ClassID = ?, Phone = ?, Salary = ? WHERE AssistantID = ?");
        // Assuming ClassID and AssistantID are integers, Phone is string, and Salary is a numeric value (double)
        $stmt->bind_param("ssisdi", $name, $address, $classID, $phone, $salary, $assistantID);
    } else {
        // Insert new record
        $stmt = $conn->prepare("INSERT INTO `teaching assistants` (Name, Address, ClassID, Phone, Salary) VALUES (?, ?, ?, ?, ?)");
        // Binding: Name (s), Address (s), ClassID (i), Phone (s), Salary (d)
        $stmt->bind_param("ssisd", $name, $address, $classID, $phone, $salary);
    }

    if ($stmt->execute()) {
        $_SESSION['message'] = $editMode ? "Record updated successfully!" : "Record added successfully!";
    } else {
        $_SESSION['message'] = "Error saving record.";
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Get classes for dropdown
$classes = [];
$result = $conn->query("SELECT ClassID, ClassName FROM classes");
while ($row = $result->fetch_assoc()) {
    $classes[] = $row;
}

// Get teaching assistants list 
$assistants = $conn->query("
    SELECT ta.AssistantID, ta.Name, ta.Address, ta.ClassID, ta.Phone, ta.Salary, c.ClassName
    FROM `teaching assistants` ta
    LEFT JOIN classes c ON ta.ClassID = c.ClassID
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>St Alphonsus - Teaching Assistants</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .max-width-800 { max-width: 800px; }
    </style>
</head>
<body>
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
                    <li class="nav-item"><a class="nav-link" href="parents.php">Parents</a></li>
                    <li class="nav-item"><a class="nav-link" href="teachers.php">Teachers</a></li>
                    <li class="nav-item"><a class="nav-link" href="Dinner_money.php">Dinner</a></li>
                    <li class="nav-item"><a class="nav-link" href="library_books.php">Library</a></li>
                    <li class="nav-item"><a class="nav-link active" href="TA.php">Teaching Assistants</a></li>
                    <li class="nav-item" id="logoutBtn" style="display: none;">
                        <a class="nav-link" href="#" onclick="logout()">Logout</a>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <?php if (!empty($_SESSION['message'])): ?>
            <div class="alert alert-info text-center"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>

        <div class="card shadow-lg mb-5">
            <div class="card-header bg-primary text-white text-center">
                <h2><?php echo $editMode ? "Edit Teaching Assistant" : "Add New Teaching Assistant"; ?></h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <?php if ($editMode): ?>
                        <input type="hidden" name="AssistantID" value="<?php echo $editID; ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Name:</label>
                        <input type="text" class="form-control" name="Name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address:</label>
                        <input type="text" class="form-control" name="Address" value="<?php echo htmlspecialchars($address); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Class:</label>
                        <select class="form-select" name="ClassID" required>
                            <option value="">Select Class</option>
                            <?php foreach ($classes as $cls): ?>
                                <option value="<?php echo $cls['ClassID']; ?>" <?php echo ($cls['ClassID'] == $classID) ? 'selected' : ''; ?>>
                                    <?php echo $cls['ClassName']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone:</label>
                        <input type="text" class="form-control" name="Phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Salary:</label>
                        <input type="number" step="0.01" class="form-control" name="Salary" value="<?php echo htmlspecialchars($salary); ?>" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success"><?php echo $editMode ? "Update Assistant" : "Submit"; ?></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-lg">
            <div class="card-header bg-info text-white text-center">
                <h2>Existing Teaching Assistants</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Class</th>
                            <th>Phone</th>
                            <th>Salary</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $assistants->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['AssistantID']; ?></td>
                                <td><?php echo $row['Name']; ?></td>
                                <td><?php echo $row['Address']; ?></td>
                                <td><?php echo $row['ClassName']; ?></td>
                                <td><?php echo $row['Phone']; ?></td>
                                <td><?php echo $row['Salary']; ?></td>
                                <td>
                                    <a href="?action=edit&id=<?php echo $row['AssistantID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="?action=delete&id=<?php echo $row['AssistantID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
