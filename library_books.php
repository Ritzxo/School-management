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

// Handle Delete Request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM library_books WHERE Book_ID = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    header("Location: library_books.php");
    exit();
}

// Handle New Book Addition
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookTitle  = $conn->real_escape_string($_POST['Book_Title']);
    $author     = $conn->real_escape_string($_POST['Author']);
    $pupilID    = !empty($_POST['Pupil_ID']) ? intval($_POST['Pupil_ID']) : NULL;
    $issueDate  = $conn->real_escape_string($_POST['IssueDate']);
    $returnDate = $conn->real_escape_string($_POST['ReturnDate']);

    $stmt = $conn->prepare("INSERT INTO library_books (BookTitle, Author, Pupil_ID, IssueDate, ReturnDate)
                            VALUES (?, ?, ?, ?, ?)");
    // Bind pupilID as integer; if NULL, pass as null value
    if ($pupilID === NULL) {
        $stmt->bind_param("sssss", $bookTitle, $author, $pupilID, $issueDate, $returnDate);
    } else {
        $stmt->bind_param("ssiss", $bookTitle, $author, $pupilID, $issueDate, $returnDate);
    }

    if ($stmt->execute()) {
        header("Location: library_books.php");
        exit();
    } else {
        echo "Error adding book: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch all books for display
$result = $conn->query("SELECT * FROM library_books");

// Fetch pupils for dropdown in the form
$pupilsDropdown = $conn->query("SELECT Pupil_ID, Name FROM pupils");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Books</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <li class="nav-item"><a class="nav-link" href="teachers.php">Teachers</a></li>
                    <li class="nav-item"><a class="nav-link" href="Dinner_money.php">Dinner</a></li>
                    <li class="nav-item"><a class="nav-link active" href="library_books.php">Library</a></li>
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
                <h2>Borrow Book</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="Book_Title" class="form-label">Book Title:</label>
                        <input type="text" name="Book_Title" id="Book_Title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="Author" class="form-label">Author:</label>
                        <input type="text" name="Author" id="Author" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="Pupil_ID" class="form-label">Pupil (Borrower):</label>
                        <select name="Pupil_ID" id="Pupil_ID" class="form-select">
                            <option value="">Select Pupil</option>
                            <?php while ($pupil = $pupilsDropdown->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($pupil['Pupil_ID']) ?>">
                                    <?= htmlspecialchars($pupil['Pupil_ID'] . " - " . $pupil['Name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="IssueDate" class="form-label">Issue Date:</label>
                        <input type="date" name="IssueDate" id="IssueDate" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="ReturnDate" class="form-label">Return Date:</label>
                        <input type="date" name="ReturnDate" id="ReturnDate" class="form-control">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Borrow Book</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-lg">
            <div class="card-header bg-info text-white text-center">
                <h2>Borrowed Books</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Book ID</th>
                                <th>Book Title</th>
                                <th>Author</th>
                                <th>Pupil ID</th>
                                <th>Issue Date</th>
                                <th>Return Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['Book_ID']) ?></td>
                                        <td><?= htmlspecialchars($row['BookTitle']) ?></td>
                                        <td><?= htmlspecialchars($row['Author']) ?></td>
                                        <td><?= htmlspecialchars($row['Pupil_ID']) ?></td>
                                        <td><?= htmlspecialchars(date('d-m-Y', strtotime($row['IssueDate']))) ?></td>
                                        <td><?= htmlspecialchars(date('d-m-Y', strtotime($row['ReturnDate']))) ?></td>
                                        <td>
                                            <a href="edit_book.php?Book_ID=<?= urlencode($row['Book_ID']) ?>" 
                                               class="btn btn-warning btn-sm">Edit</a>
                                            <a href="?delete_id=<?= urlencode($row['Book_ID']) ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Are you sure you want to delete this book?');">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No books found</td>
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

<?php $conn->close(); ?>
       
