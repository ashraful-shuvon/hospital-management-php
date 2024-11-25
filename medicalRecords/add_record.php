<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include '../config/db.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $diagnosis = $_POST['diagnosis'];
    $prescription = $_POST['prescription'];
    $test_results = $_POST['test_results'];

    $sql = "INSERT INTO medical_records (patient_id, doctor_id, diagnosis, prescription, test_results)
            VALUES (:patient_id, :doctor_id, :diagnosis, :prescription, :test_results)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':patient_id' => $patient_id,
        ':doctor_id' => $doctor_id,
        ':diagnosis' => $diagnosis,
        ':prescription' => $prescription,
        ':test_results' => $test_results,
    ]);

    header("Location: view_records.php");
    exit();
}

$patients = $conn->query("SELECT * FROM patients")->fetchAll(PDO::FETCH_ASSOC);
$doctors = $conn->query("SELECT * FROM doctors")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="form-container">
    <h2>Add Medical Record</h2>
    <form method="POST">
        <label>Patient:</label>
        <select name="patient_id" required>
            <option value="">Select Patient</option>
            <?php foreach ($patients as $patient): ?>
                <option value="<?= $patient['patient_id']; ?>"><?= $patient['first_name'] . " " . $patient['last_name']; ?></option>
            <?php endforeach; ?>
        </select>

        <label>Doctor:</label>
        <select name="doctor_id" required>
            <option value="">Select Doctor</option>
            <?php foreach ($doctors as $doctor): ?>
                <option value="<?= $doctor['doctor_id']; ?>"><?= $doctor['first_name'] . " " . $doctor['last_name']; ?></option>
            <?php endforeach; ?>
        </select>

        <label>Diagnosis:</label>
        <textarea name="diagnosis" required></textarea>

        <label>Prescription:</label>
        <textarea name="prescription" required></textarea>

        <label>Test Results:</label>
        <textarea name="test_results"></textarea>

        <button type="submit" class="btn-submit">Add Record</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
