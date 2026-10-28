<script>
    if (sessionStorage.getItem("loggedIn") !== "true") {
        window.location.href = "login.html"; // redirect if not logged in
    }
</script>

<?php
$db_host = 'localhost';
$db_user = 'root'; 
$db_pass = '';
$db_name = 'school management';

$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($db->connect_error) die("Connection failed: " . $db->connect_error);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_pupil'])) {
        $classID = (int)$_POST['classID'];
        $name = $db->real_escape_string($_POST['name']);
        $address = $db->real_escape_string($_POST['address']);
        // Get medical info from dropdown: 1 for Yes, 0 for No.
        $medical_info = (int)$_POST['medical_info'];
        
        $db->query("INSERT INTO pupils (classID, Name, Address, Medical_INFO) 
                   VALUES ($classID, '$name', '$address', $medical_info)");
        
        header("Location: pupils.php");
        exit();
    }
    
    if (isset($_POST['update_class'])) {
        $pupil_id = (int)$_POST['pupil_id'];
        $new_class = (int)$_POST['classID'];
        $db->query("UPDATE pupils SET classID = $new_class WHERE Pupil_ID = $pupil_id");
        
        header("Location: pupils.php");
        exit();
    }
}

// Fetch data for display
$classes = $db->query("SELECT classID FROM classes");
$pupils = $db->query("SELECT * FROM pupils");
$classesForDropdown = $db->query("SELECT classID FROM classes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pupils Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="classes.php">Classes</a></li>
                    <li class="nav-item"><a class="nav-link active" href="pupils.php">Pupils</a></li>
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

    <div class="container mt-5 max-width-800">
        <div class="card shadow-lg mb-5">
            <div class="card-header bg-primary text-white text-center">
                <h2>Add New Pupil</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="classID" class="form-label">Class ID:</label>
                        <select name="classID" id="classID" class="form-select" required>
                            <?php while($class = $classesForDropdown->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($class['classID']) ?>">
                                    <?= htmlspecialchars($class['classID']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address:</label>
                        <input type="text" name="address" id="address" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="medical_info" class="form-label">Medical Info:</label>
                        <select name="medical_info" id="medical_info" class="form-select" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    
                    <div class="text-center">
                        <input type="submit" name="add_pupil" value="Submit" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-lg">
            <div class="card-header bg-info text-white text-center">
                <h2>Existing Pupils</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Pupil ID</th>
                                <th>Class ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Medical Info</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($pupil = $pupils->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($pupil['Pupil_ID']) ?></td>
                                <td><?= htmlspecialchars($pupil['classID']) ?></td>
                                <td><?= htmlspecialchars($pupil['Name']) ?></td>
                                <td><?= htmlspecialchars($pupil['Address']) ?></td>
                                <td><?= $pupil['Medical_info'] == 1 ? 'Yes' : 'No' ?></td>
                                <td>
                                    <a href="edit_pupil.php?Pupil_ID=<?= urlencode($pupil['Pupil_ID']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_pupil.php?Pupil_ID=<?= urlencode($pupil['Pupil_ID']) ?>" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this pupil?');">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
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
<?php $db->close(); ?>
