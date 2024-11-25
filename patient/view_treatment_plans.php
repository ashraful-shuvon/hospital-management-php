<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';
include '../includes/patientNav.php';

$patient_id = $_SESSION['patient_id'];

$sql = "SELECT t.treatment_id, t.diagnosis, t.medicine_name, t.dosage, t.duration, t.tests, t.prescribed_date, 
        d.first_name AS doctor_first_name, d.last_name AS doctor_last_name
        FROM treatment_plans t
        JOIN doctors d ON t.doctor_id = d.doctor_id
        WHERE t.patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$patient_id]);
$treatment_plans = $stmt->fetchAll();
?>

<div class="common-container">
    <h2>Your Treatment Plans</h2>
    <table class="common-table">
        <thead>
            <tr>
                <th>Date Prescribed</th>
                <th>Doctor</th>
                <th>Diagnosis</th>
                <th>Medicine Name</th>
                <th>Dosage</th>
                <th>Duration</th>
                <th>Tests</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($treatment_plans as $treatment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($treatment['prescribed_date']); ?></td>
                    <td><?php echo htmlspecialchars($treatment['doctor_first_name'] . ' ' . $treatment['doctor_last_name']); ?></td>
                    <td><?php echo htmlspecialchars($treatment['diagnosis']); ?></td>
                    <td><?php echo htmlspecialchars($treatment['medicine_name']); ?></td>
                    <td><?php echo htmlspecialchars($treatment['dosage']); ?></td>
                    <td><?php echo htmlspecialchars($treatment['duration']); ?></td>
                    <td><?php echo htmlspecialchars($treatment['tests']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
