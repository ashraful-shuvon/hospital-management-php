<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include '../config/db.php';
include '../includes/header.php';
?>

<div class="common-container">
    <h2>View Doctors</h2>
    <table class="common-table">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Specialization</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM doctors";
            $stmt = $conn->query($sql);
            while ($row = $stmt->fetch()) {
                echo "<tr>
                    <td>{$row['first_name']}</td>
                    <td>{$row['last_name']}</td>
                    <td>{$row['specialization']}</td>
                    <td>{$row['contact_number']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['username']}</td>
                    <td>
                        <a href='edit_doctor.php?doctor_id={$row['doctor_id']}' class='btn-edit'>Edit</a>
                        <a href='delete_doctor.php?doctor_id={$row['doctor_id']}' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this doctor?\")'>Delete</a>
                        <a href='reset_password.php?doctor_id={$row['doctor_id']}' class='btn-reset'>Reset Password</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
