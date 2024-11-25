<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $treatment_fee = $_POST['treatment_fee'];
    $service_charge = $_POST['service_charge'];
    $test_ids = $_POST['test_ids'] ?? []; // Array of selected test IDs

    // Calculate total test fees
    $total_test_fee = 0;
    foreach ($test_ids as $test_id) {
        $stmt = $conn->prepare("SELECT test_fee FROM tests WHERE test_id = ?");
        $stmt->execute([$test_id]);
        $test_fee = $stmt->fetchColumn();
        $total_test_fee += $test_fee;
    }

    // Calculate total amount
    $total_amount = $treatment_fee + $service_charge + $total_test_fee;

    // Insert into bills table
    $stmt = $conn->prepare("INSERT INTO bills (patient_id, treatment_fee, service_charge, total_amount) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$patient_id, $treatment_fee, $service_charge, $total_amount])) {
        $bill_id = $conn->lastInsertId();

        // Insert into bill_tests table
        foreach ($test_ids as $test_id) {
            $stmt = $conn->prepare("INSERT INTO bill_tests (bill_id, test_id) VALUES (?, ?)");
            $stmt->execute([$bill_id, $test_id]);
        }

        $_SESSION['success'] = "Bill added successfully!";
        header("Location: view_bills.php");
        exit();
    } else {
        $error = "Error adding the bill. Please try again.";
    }
}

// Fetch patients and tests
$patients = $conn->query("SELECT patient_id, first_name, last_name FROM patients")->fetchAll();
$tests = $conn->query("SELECT test_id, test_name, test_fee FROM tests")->fetchAll();
?>

<?php include '../includes/header.php'; ?>

<div class="form-container">
    <h2>Add Bill</h2>
    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="add_bill.php">
        <label>Patient:</label>
        <select name="patient_id" required>
            <option value="">Select Patient</option>
            <?php foreach ($patients as $patient): ?>
                <option value="<?= $patient['patient_id'] ?>"><?= $patient['first_name'] . ' ' . $patient['last_name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Treatment Fee:</label>
        <input type="number" name="treatment_fee" step="0.01" required>

        <label>Service Charge:</label>
        <input type="number" name="service_charge" step="0.01" required>

        <label>Tests:</label>
        <?php foreach ($tests as $test): ?>
            <div>
                <input type="checkbox" name="test_ids[]" value="<?= $test['test_id'] ?>">
                <?= $test['test_name'] ?> ($<?= number_format($test['test_fee'], 2) ?>)
            </div>
        <?php endforeach; ?>

        <button type="submit">Add Bill</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
