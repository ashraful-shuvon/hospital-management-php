<?php
session_start();

// Check if doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php"); // Redirect to doctor login page
    exit();
}

// Include database connection
include '../config/db.php';

// Get the logged-in doctor's ID
$doctor_id = $_SESSION['doctor_id'];

// Fetch treatment plans assigned by this doctor
try {
    $sql = "
        SELECT tp.treatment_id, tp.patient_id, p.first_name, p.last_name, tp.diagnosis, 
               tp.medicine_name, tp.dosage, tp.duration, tp.tests, tp.prescribed_date
        FROM treatment_plans tp
        INNER JOIN patients p ON tp.patient_id = p.patient_id
        WHERE tp.doctor_id = :doctor_id
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':doctor_id', $doctor_id, PDO::PARAM_INT);
    $stmt->execute();
    $treatment_plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching treatment plans: " . $e->getMessage());
}
?>

<?php include '../includes/doctorNav.php'; ?>

<div class="common-container">
    <h1>View Treatment Plans</h1>
    <table class="common-table">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Diagnosis</th>
                <th>Medicines</th>
                <th>Dosage</th>
                <th>Duration</th>
                <th>Tests</th>
                <th>Prescribed Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($treatment_plans): ?>
                <?php foreach ($treatment_plans as $plan): ?>
                    <tr>
                        <td><?= htmlspecialchars($plan['first_name'] . ' ' . $plan['last_name']); ?></td>
                        <td><?= htmlspecialchars($plan['diagnosis']); ?></td>
                        <td><?= htmlspecialchars($plan['medicine_name']); ?></td>
                        <td><?= htmlspecialchars($plan['dosage']); ?></td>
                        <td><?= htmlspecialchars($plan['duration']); ?></td>
                        <td><?= htmlspecialchars($plan['tests']); ?></td>
                        <td><?= htmlspecialchars($plan['prescribed_date']); ?></td>
                        <td>
                            <a href="edit_treatment_plan.php?treatment_id=<?= $plan['treatment_id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="delete_treatment_plan.php?treatment_id=<?= $plan['treatment_id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this treatment plan?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No treatment plans found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
