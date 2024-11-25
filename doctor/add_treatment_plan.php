<?php
session_start();

// Check if doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php"); // Redirect to doctor login page
    exit();
}

// Include database connection
include '../config/db.php';

// Get the logged-in doctor's ID
$doctor_id = $_SESSION['doctor_id'];

// Fetch patients who have appointments with the logged-in doctor
try {
    $patient_sql = "
        SELECT DISTINCT p.patient_id, p.first_name, p.last_name
        FROM patients p
        INNER JOIN appointments a ON p.patient_id = a.patient_id
        WHERE a.doctor_id = :doctor_id
    ";
    $stmt = $conn->prepare($patient_sql);
    $stmt->bindParam(':doctor_id', $doctor_id, PDO::PARAM_INT);
    $stmt->execute();
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching patients: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $diagnosis = $_POST['diagnosis'];
    $medicine_name = $_POST['medicine_name'];
    $dosage = $_POST['dosage'];
    $duration = $_POST['duration'];
    $tests = $_POST['tests'];
    $prescribed_date = date('Y-m-d');

    // Insert into database
    try {
        $sql = "
            INSERT INTO treatment_plans (
                patient_id, doctor_id, diagnosis, medicine_name, dosage, duration, tests, prescribed_date
            ) VALUES (
                :patient_id, :doctor_id, :diagnosis, :medicine_name, :dosage, :duration, :tests, :prescribed_date
            )
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
        $stmt->bindParam(':doctor_id', $doctor_id, PDO::PARAM_INT);
        $stmt->bindParam(':diagnosis', $diagnosis, PDO::PARAM_STR);
        $stmt->bindParam(':medicine_name', $medicine_name, PDO::PARAM_STR);
        $stmt->bindParam(':dosage', $dosage, PDO::PARAM_STR);
        $stmt->bindParam(':duration', $duration, PDO::PARAM_STR);
        $stmt->bindParam(':tests', $tests, PDO::PARAM_STR);
        $stmt->bindParam(':prescribed_date', $prescribed_date, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: view_treatment_plans.php?success=1");
            exit();
        } else {
            $error = "Failed to add treatment plan. Please try again.";
        }
    } catch (PDOException $e) {
        $error = "Error adding treatment plan: " . $e->getMessage();
    }
}
?>

<?php include '../includes/doctorNav.php'; ?>

<div class="form-container">
    <h1>Add Treatment Plan</h1>
    <?php if (isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST">
        <div>
            <label for="patient_id">Patient</label>
            <select name="patient_id" id="patient_id" required>
                <option value="">Select Patient</option>
                <?php foreach ($patients as $patient): ?>
                    <option value="<?= $patient['patient_id']; ?>">
                        <?= htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="diagnosis">Diagnosis</label>
            <textarea name="diagnosis" id="diagnosis" required></textarea>
        </div>
        <div>
            <label for="medicine_name">Medicine Name</label>
            <textarea name="medicine_name" id="medicine_name" required></textarea>
        </div>
        <div>
            <label for="dosage">Dosage</label>
            <textarea name="dosage" id="dosage" required></textarea>
        </div>
        <div>
            <label for="duration">Duration</label>
            <textarea name="duration" id="duration" required></textarea>
        </div>
        <div>
            <label for="tests">Tests</label>
            <textarea name="tests" id="tests"></textarea>
        </div>
        <button type="submit">Add Treatment Plan</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
