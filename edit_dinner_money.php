<?php
$db = new mysqli('localhost', 'root', '', 'school management');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Ensure DinnerMoneyID is provided
if (!isset($_GET['DinnerMoneyID'])) {
    header("Location: Dinner_money.php");
    exit();
}

$dinnerMoneyID = (int) $_GET['DinnerMoneyID'];

// Retrieve the current dinner money record
$sql = "SELECT * FROM dinner_money WHERE DinnerMoneyID = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $dinnerMoneyID);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();
$stmt->close();

if (!$record) {
    echo "Dinner money entry not found!";
    exit();
}

// Retrieve pupils for the dropdown
$pupils = $db->query("SELECT Pupil_ID FROM pupils");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pupil_id = (int) $_POST['pupil_id'];
    $amount = (float) $_POST['amount'];
    $payment_date = $db->real_escape_string($_POST['payment_date']);
    
    $update_sql = "UPDATE dinner_money SET Pupil_ID = ?, Amount = ?, PaymentDate = ? WHERE DinnerMoneyID = ?";
    $update_stmt = $db->prepare($update_sql);
    $update_stmt->bind_param("idsi", $pupil_id, $amount, $payment_date, $dinnerMoneyID);
    
    if ($update_stmt->execute()) {
        header("Location: Dinner_money.php");
        exit();
    } else {
        echo "Error updating record: " . $update_stmt->error;
    }
    $update_stmt->close();
}
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Dinner Money Entry</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2>Edit Dinner Money Entry</h2>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="pupil_id" class="form-label">Pupil ID</label>
                    <select class="form-select" name="pupil_id" required>
                        <?php while($pupil = $pupils->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($pupil['Pupil_ID']) ?>"
                                <?= $pupil['Pupil_ID'] == $record['Pupil_ID'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($pupil['Pupil_ID']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount (£)</label>
                    <input type="number" step="0.01" class="form-control" name="amount" 
                           value="<?= htmlspecialchars($record['Amount']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" class="form-control" name="payment_date" 
                           value="<?= htmlspecialchars(date('Y-m-d', strtotime($record['PaymentDate']))) ?>" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Update Entry</button>
                    <a href="Dinner_money.php" class="btn btn-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
