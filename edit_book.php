<?php
$conn = new mysqli("localhost", "root", "", "school management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['Book_ID'])) {
    header("Location: library_books.php");
    exit();
}

$book_id = intval($_GET['Book_ID']);

// Handle form submission for updating the record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookTitle = $conn->real_escape_string($_POST['Book_Title']);
    $author = $conn->real_escape_string($_POST['Author']);
    // If no pupil selected, store as NULL
    $pupilID = !empty($_POST['Pupil_ID']) ? intval($_POST['Pupil_ID']) : NULL;
    $issueDate = $conn->real_escape_string($_POST['IssueDate']);
    $returnDate = $conn->real_escape_string($_POST['ReturnDate']);

    $stmt = $conn->prepare("UPDATE library_books SET Book_Title = ?, Author = ?, Pupil_ID = ?, IssueDate = ?, ReturnDate = ? WHERE Book_ID = ?");
    $stmt->bind_param("ssissi", $bookTitle, $author, $pupilID, $issueDate, $returnDate, $book_id);
    if ($stmt->execute()) {
        header("Location: library_books.php");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}

// Retrieve the current book record
$stmt = $conn->prepare("SELECT * FROM library_books WHERE Book_ID = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "Book not found.";
    exit();
}
$book = $result->fetch_assoc();
$stmt->close();

// Fetch pupils for dropdown
$pupilsDropdown = $conn->query("SELECT Pupil_ID, Name FROM pupils");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
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
                    <li class="nav-item"><a class="nav-link" href="#">Teachers</a></li>
                    <li class="nav-item"><a class="nav-link" href="Dinner_money.php">Dinner</a></li>
                    <li class="nav-item"><a class="nav-link active" href="library_books.php">Library</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 max-width-800">
        <div class="card shadow-lg mb-5">
            <div class="card-header bg-primary text-white text-center">
                <h2>Edit Book</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="Book_Title" class="form-label">Book Title:</label>
                        <input type="text" name="BookTitle" id="BookTitle" class="form-control" required value="<?= htmlspecialchars($book['BookTitle']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="Author" class="form-label">Author:</label>
                        <input type="text" name="Author" id="Author" class="form-control" required value="<?= htmlspecialchars($book['Author']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="Pupil_ID" class="form-label">Pupil (Borrower):</label>
                        <select name="Pupil_ID" id="Pupil_ID" class="form-select">
                            <option value="">Select Pupil</option>
                            <?php while($pupil = $pupilsDropdown->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($pupil['Pupil_ID']) ?>" <?= ($book['Pupil_ID'] == $pupil['Pupil_ID']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($pupil['Pupil_ID'] . " - " . $pupil['Name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="IssueDate" class="form-label">Issue Date:</label>
                        <input type="date" name="IssueDate" id="IssueDate" class="form-control" value="<?= htmlspecialchars($book['IssueDate']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="ReturnDate" class="form-label">Return Date:</label>
                        <input type="date" name="ReturnDate" id="ReturnDate" class="form-control" value="<?= htmlspecialchars($book['ReturnDate']) ?>">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Update Book</button>
                        <a href="library_books.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
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
</body>
</html>

<?php $conn->close(); ?>
