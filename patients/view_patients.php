<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include '../config/db.php';

try {
    $sql = "SELECT * FROM patients";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<?php include '../includes/header.php'; ?>

<div class="common-container">
    <h1>View Patients</h1>
    <a href="add_patient.php" class="btn-edit">Add Patient</a>
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
                <th>Username</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($patients): ?>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?= htmlspecialchars($patient['first_name']); ?></td>
                        <td><?= htmlspecialchars($patient['last_name']); ?></td>
                        <td><?= htmlspecialchars($patient['date_of_birth']); ?></td>
                        <td><?= htmlspecialchars($patient['gender']); ?></td>
                        <td><?= htmlspecialchars($patient['contact_number']); ?></td>
                        <td><?= htmlspecialchars($patient['email']); ?></td>
                        <td><?= htmlspecialchars($patient['address']); ?></td>
                        <td><?= htmlspecialchars($patient['username']); ?></td>
                        <td>
                            <a href="edit_patient.php?patient_id=<?= $patient['patient_id']; ?>" class="btn-edit">Edit</a>
                            <a href="delete_patient.php?patient_id=<?= $patient['patient_id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this patient?');">Delete</a>
                            <a href="reset_password.php?patient_id=<?= $patient['patient_id']; ?>" class="btn-reset">Reset Password</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No patients found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
