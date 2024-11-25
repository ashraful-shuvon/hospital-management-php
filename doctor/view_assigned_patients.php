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
    <h2>Assigned Patients</h2>
    <table class="common-table">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch patients assigned to this doctor
            $sql = "SELECT p.* 
                    FROM patients p
                    INNER JOIN appointments a ON p.patient_id = a.patient_id
                    WHERE a.doctor_id = :doctor_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['doctor_id' => $doctor_id]);

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['first_name']}</td>
                        <td>{$row['last_name']}</td>
                        <td>{$row['date_of_birth']}</td>
                        <td>{$row['gender']}</td>
                        <td>{$row['contact_number']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['address']}</td>
                        <td>
                            <a href='../doctor/view_records.php?patient_id={$row['patient_id']}' class='btn-edit'>View Records</a>
                            <a href='../doctor/add_treatment_plan.php?patient_id={$row['patient_id']}' class='btn-delete'>Add Treatment</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No patients assigned to you.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
