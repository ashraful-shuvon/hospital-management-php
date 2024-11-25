<?php
session_start();

// Check if the doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection and header
include '../config/db.php';
include '../includes/doctorNav.php';

// Get the logged-in doctor's ID
$doctor_id = $_SESSION['doctor_id'];
?>

<div class="common-container">
    <h2>My Appointments</h2>
    <table class="common-table">
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch appointments for the logged-in doctor
            $sql = "SELECT a.appointment_id, p.first_name, p.last_name, a.appointment_date, a.status 
                    FROM appointments a
                    INNER JOIN patients p ON a.patient_id = p.patient_id
                    WHERE a.doctor_id = :doctor_id
                    ORDER BY a.appointment_date DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['doctor_id' => $doctor_id]);

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['appointment_id']}</td>
                        <td>{$row['first_name']} {$row['last_name']}</td>
                        <td>{$row['appointment_date']}</td>
                        <td>{$row['status']}</td>
                        <td>
                            <a href='../doctor/view_records.php?appointment_id={$row['appointment_id']}' class='btn-edit'>View Medical Record</a>
                            <a href='../doctor/add_treatment_plan.php?appointment_id={$row['appointment_id']}' class='btn-delete'>Add Treatment Plan</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No appointments available.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
