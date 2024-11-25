<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

// Include database connection and header
include '../config/db.php';
include '../includes/header.php';
?>

<div class="common-container">
    <h2>All Medical Records</h2>
    <a href="add_record.php" class="btn-edit">Add New Record</a>
    <table class="common-table">
        <thead>
            <tr>
                <th>Record ID</th>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Diagnosis</th>
                <th>Prescription</th>
                <th>Test Results</th>
                <th>Date Recorded</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT mr.record_id, 
                           CONCAT(p.first_name, ' ', p.last_name) AS patient_name, 
                           CONCAT(d.first_name, ' ', d.last_name) AS doctor_name, 
                           mr.diagnosis, mr.prescription, mr.test_results, mr.date_recorded 
                    FROM medical_records mr
                    JOIN patients p ON mr.patient_id = p.patient_id
                    JOIN doctors d ON mr.doctor_id = d.doctor_id
                    ORDER BY mr.date_recorded DESC";
            $stmt = $conn->query($sql);

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['record_id']}</td>
                        <td>{$row['patient_name']}</td>
                        <td>{$row['doctor_name']}</td>
                        <td>{$row['diagnosis']}</td>
                        <td>{$row['prescription']}</td>
                        <td>{$row['test_results']}</td>
                        <td>{$row['date_recorded']}</td>
                        <td>
                            <a href='edit_record.php?record_id={$row['record_id']}' class='btn-edit'>Edit</a>
                            <a href='delete_record.php?record_id={$row['record_id']}' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No medical records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
