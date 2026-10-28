<script>
    // Redirect to login if not logged in
    if (sessionStorage.getItem("loggedIn") !== "true") {
        window.location.href = "login.html";
    }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>St Alphonsus - Classes</title>
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Classes</a></li>
                    <li class="nav-item"><a class="nav-link" href="pupils.php">Pupils</a></li>
                    <li class="nav-item"><a class="nav-link" href="parents.php">Parents</a></li>
                    <li class="nav-item"><a class="nav-link" href="teachers.php">Teachers</a></li>
                    <li class="nav-item"><a class="nav-link" href="Dinner_money.php">Dinner</a></li>
                    <li class="nav-item"><a class="nav-link" href="library_books.php">Library</a></li>
                    <li class="nav-item"><a class="nav-link active" href="TA.php">Teaching Assistants</a></li>
                    <li class="nav-item" id="logoutBtn" style="display: none;">
                        <a class="nav-link" href="#" onclick="logout()">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card shadow-lg mb-5">
            <div class="card-header bg-primary text-white text-center">
                <h2>Add New Class</h2>
            </div>
            <div class="card-body">
                <form action="add_class.php" method="POST" id="addClassForm">
                    <div class="mb-3">
                        <label for="classID" class="form-label">Class ID:</label>
                        <input type="number" class="form-control" name="classID" id="classID" required>
                    </div>
                    <div class="mb-3">
                        <label for="className" class="form-label">Class Name:</label>
                        <input type="text" class="form-control" name="className" id="className" required>
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Capacity:</label>
                        <input type="number" class="form-control" name="capacity" id="capacity" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-lg">
            <div class="card-header bg-info text-white text-center">
                <h2>Existing Classes</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Class ID</th>
                                <th>Class Name</th>
                                <th>Capacity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $conn = new mysqli("localhost", "root", "", "school management");
                            if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
                            
                            $sql = "SELECT * FROM classes";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['classID']}</td>
                                            <td>{$row['className']}</td>
                                            <td>{$row['capacity']}</td>
                                            <td>
                                                <a href='edit_class.php?classID={$row['classID']}' class='btn btn-warning btn-sm'>Edit</a>
                                                <a href='delete_class.php?classID={$row['classID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this class?\");'>Delete</a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>No classes found</td></tr>";
                            }
                            $conn->close();
                            ?>
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

    <!-- Bootstrap and FontAwesome -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script>
        if (sessionStorage.getItem("loggedIn") === "true") {
            document.getElementById("logoutBtn").style.display = "block";
        }

        function logout() {
            sessionStorage.removeItem("loggedIn");
            window.location.href = "login.html";
        }
    </script>
</body>
</html>
