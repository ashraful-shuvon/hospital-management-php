<?php
session_start();

// Check if doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php"); // Redirect to doctor login page
    exit();
}

// Include database connection
include '../config/db.php';

// Fetch records assigned to the logged-in doctor
$doctor_id = $_SESSION['doctor_id'];
$sql = "SELECT medical_records.record_id, patients.first_name, patients.last_name, medical_records.diagnosis, medical_records.prescription, medical_records.test_results, medical_records.date_recorded 
        FROM medical_records
        JOIN patients ON medical_records.patient_id = patients.patient_id
        WHERE medical_records.doctor_id = :doctor_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':doctor_id', $doctor_id, PDO::PARAM_INT);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../includes/doctorNav.php'; ?>

<div class="common-container">
    <h1>View Medical Records</h1>
    <table class="common-table">
        <thead>
            <tr>
                <th>Record ID</th>
                <th>Patient Name</th>
                <th>Diagnosis</th>
                <th>Prescription</th>
                <th>Test Results</th>
                <th>Date Recorded</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($records) > 0): ?>
                <?php foreach ($records as $record): ?>
                    <tr>
                        <td><?= htmlspecialchars($record['record_id']); ?></td>
                        <td><?= htmlspecialchars($record['first_name'] . ' ' . $record['last_name']); ?></td>
                        <td><?= htmlspecialchars($record['diagnosis']); ?></td>
                        <td><?= htmlspecialchars($record['prescription']); ?></td>
                        <td><?= htmlspecialchars($record['test_results']); ?></td>
                        <td><?= htmlspecialchars($record['date_recorded']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No medical records found for your patients.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
