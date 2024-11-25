<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';
include '../includes/patientNav.php';

$patient_id = $_SESSION['patient_id'];

$sql = "SELECT a.appointment_id, a.appointment_date, a.status, 
        d.first_name AS doctor_first_name, d.last_name AS doctor_last_name 
        FROM appointments a 
        JOIN doctors d ON a.doctor_id = d.doctor_id 
        WHERE a.patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$patient_id]);
$appointments = $stmt->fetchAll();
?>

<div class="common-container">
    <h2>Your Appointments</h2>
    <table class="common-table">
        <thead>
            <tr>
                <th>Appointment Date</th>
                <th>Doctor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['doctor_first_name'] . ' ' . $appointment['doctor_last_name']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
