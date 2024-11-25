<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';
include '../includes/patientNav.php';

$patient_id = $_SESSION['patient_id'];

$sql = "SELECT r.record_id, r.diagnosis, r.prescription, r.test_results, 
        d.first_name AS doctor_first_name, d.last_name AS doctor_last_name, r.date_recorded
        FROM medical_records r
        JOIN doctors d ON r.doctor_id = d.doctor_id
        WHERE r.patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$patient_id]);
$records = $stmt->fetchAll();
?>

<div class="common-container">
    <h2>Your Medical Records</h2>
    <table class="common-table">
        <thead>
            <tr>
                <th>Date Recorded</th>
                <th>Doctor</th>
                <th>Diagnosis</th>
                <th>Prescription</th>
                <th>Test Results</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($records as $record): ?>
                <tr>
                    <td><?php echo htmlspecialchars($record['date_recorded']); ?></td>
                    <td><?php echo htmlspecialchars($record['doctor_first_name'] . ' ' . $record['doctor_last_name']); ?></td>
                    <td><?php echo htmlspecialchars($record['diagnosis']); ?></td>
                    <td><?php echo htmlspecialchars($record['prescription']); ?></td>
                    <td><?php echo htmlspecialchars($record['test_results']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
