<script>
    if (sessionStorage.getItem("loggedIn") !== "true") {
        window.location.href = "login.html"; // redirect if not logged in
    }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dinner Money Management</title>
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
          <li class="nav-item"><a class="nav-link" href="classes.php">Classes</a></li>
          <li class="nav-item"><a class="nav-link" href="pupils.php">Pupils</a></li>
          <li class="nav-item"><a class="nav-link" href="parents.php">Parents</a></li>
          <li class="nav-item"><a class="nav-link" href="teachers.php">Teachers</a></li>
          <li class="nav-item"><a class="nav-link active" href="Dinner_money.php">Dinner</a></li>
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
        <h2>Add Dinner Money Entry</h2>
      </div>
      <div class="card-body">
        <form action="add_dinner_money.php" method="POST">
          <div class="row g-3">
            <div class="col-md-4">
              <label for="pupil_id" class="form-label">Pupil ID</label>
              <select class="form-select" name="pupil_id" required>
                <option value="">Select Pupil</option>
                <?php
                $conn = new mysqli("localhost", "root", "", "school management");
                if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
                $pupils = $conn->query("SELECT Pupil_ID FROM pupils");
                while($pupil = $pupils->fetch_assoc()) {
                  echo "<option value='{$pupil['Pupil_ID']}'>{$pupil['Pupil_ID']}</option>";
                }
                $conn->close();
                ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="amount" class="form-label">Amount (£)</label>
              <input type="number" class="form-control" name="amount" step="1" required>
            </div>
            <div class="col-md-4">
              <label for="payment_date" class="form-label">Payment Date</label>
              <input type="date" class="form-control" name="payment_date" placeholder="DD/MM/YY" required>
            </div>
          </div>
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Add Entry</button>
          </div>
        </form>
      </div>
    </div>

    <div class="card shadow-lg">
      <div class="card-header bg-info text-white text-center">
        <h2>Dinner Money Records</h2>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Entry ID</th>
                <th>Pupil ID</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $conn = new mysqli("localhost", "root", "", "school management");
              if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
              
              $sql = "SELECT * FROM dinner_money";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td>{$row['DinnerMoneyID']}</td>
                          <td>{$row['Pupil_ID']}</td>
                          <td>£{$row['Amount']}</td>
                          <td>" . date('d/m/Y', strtotime($row['PaymentDate'])) . "</td>
                          <td>
                            <a href='edit_dinner_money.php?DinnerMoneyID={$row['DinnerMoneyID']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete_dinner_money.php?DinnerMoneyID={$row['DinnerMoneyID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this entry?\");'>Delete</a>
                          </td>
                        </tr>";
                }
              } else {
                echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
              }
              $conn->close();
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

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
