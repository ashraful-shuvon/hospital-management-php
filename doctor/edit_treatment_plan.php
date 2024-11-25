<?php
session_start();

// Check if doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include '../config/db.php';

// Get treatment plan ID
if (!isset($_GET['treatment_id'])) {
    die("Invalid treatment ID.");
}

$treatment_id = $_GET['treatment_id'];
$doctor_id = $_SESSION['doctor_id'];

// Fetch treatment plan details
try {
    $sql = "
        SELECT * 
        FROM treatment_plans 
        WHERE treatment_id = :treatment_id AND doctor_id = :doctor_id
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':treatment_id', $treatment_id, PDO::PARAM_INT);
    $stmt->bindParam(':doctor_id', $doctor_id, PDO::PARAM_INT);
    $stmt->execute();
    $treatment_plan = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$treatment_plan) {
        die("Treatment plan not found.");
    }
} catch (PDOException $e) {
    die("Error fetching treatment plan: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $diagnosis = $_POST['diagnosis'];
    $medicine_name = $_POST['medicine_name'];
    $dosage = $_POST['dosage'];
    $duration = $_POST['duration'];
    $tests = $_POST['tests'];

    try {
        $sql = "
            UPDATE treatment_plans 
            SET diagnosis = :diagnosis, medicine_name = :medicine_name, 
                dosage = :dosage, duration = :duration, tests = :tests 
            WHERE treatment_id = :treatment_id AND doctor_id = :doctor_id
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':diagnosis', $diagnosis, PDO::PARAM_STR);
        $stmt->bindParam(':medicine_name', $medicine_name, PDO::PARAM_STR);
        $stmt->bindParam(':dosage', $dosage, PDO::PARAM_STR);
        $stmt->bindParam(':duration', $duration, PDO::PARAM_STR);
        $stmt->bindParam(':tests', $tests, PDO::PARAM_STR);
        $stmt->bindParam(':treatment_id', $treatment_id, PDO::PARAM_INT);
        $stmt->bindParam(':doctor_id', $doctor_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: view_treatment_plans.php?success=edit");
            exit();
        } else {
            $error = "Failed to update treatment plan.";
        }
    } catch (PDOException $e) {
        $error = "Error updating treatment plan: " . $e->getMessage();
    }
}
?>

<?php include '../includes/doctorNav.php'; ?>

<div class="form-container">
    <h1>Edit Treatment Plan</h1>
    <?php if (isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST">
        <div>
            <label for="diagnosis">Diagnosis</label>
            <textarea name="diagnosis" id="diagnosis" required><?= htmlspecialchars($treatment_plan['diagnosis']); ?></textarea>
        </div>
        <div>
            <label for="medicine_name">Medicine Name</label>
            <textarea name="medicine_name" id="medicine_name" required><?= htmlspecialchars($treatment_plan['medicine_name']); ?></textarea>
        </div>
        <div>
            <label for="dosage">Dosage</label>
            <textarea name="dosage" id="dosage" required><?= htmlspecialchars($treatment_plan['dosage']); ?></textarea>
        </div>
        <div>
            <label for="duration">Duration</label>
            <textarea name="duration" id="duration" required><?= htmlspecialchars($treatment_plan['duration']); ?></textarea>
        </div>
        <div>
            <label for="tests">Tests</label>
            <textarea name="tests" id="tests"><?= htmlspecialchars($treatment_plan['tests']); ?></textarea>
        </div>
        <button type="submit">Update Treatment Plan</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
