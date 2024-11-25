<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}
include '../config/db.php';

$sql = "SELECT a.appointment_id, p.first_name AS patient_first_name, p.last_name AS patient_last_name, 
        d.first_name AS doctor_first_name, d.last_name AS doctor_last_name, a.appointment_date, a.status
        FROM appointments a
        JOIN patients p ON a.patient_id = p.patient_id
        JOIN doctors d ON a.doctor_id = d.doctor_id";
$appointments = $conn->query($sql);
?>

<?php include '../includes/header.php'; ?>
<div class="common-container">
    <h2>View Appointments</h2>
    <table class="common-table">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $appointments->fetch()) : ?>
                <tr>
                    <td><?= $row['patient_first_name'] . ' ' . $row['patient_last_name'] ?></td>
                    <td><?= $row['doctor_first_name'] . ' ' . $row['doctor_last_name'] ?></td>
                    <td><?= $row['appointment_date'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td>
                        <a href="edit_appointment.php?appointment_id=<?= $row['appointment_id'] ?>" class="btn-edit">Edit</a>
                        <a href="delete_appointment.php?appointment_id=<?= $row['appointment_id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
