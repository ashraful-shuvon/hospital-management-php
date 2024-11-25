<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/patientNav.php'; 

$patient_name = $_SESSION['patient_name'];
?>

<div class="dashboard-container">
    <h1>Welcome, <?php echo htmlspecialchars($patient_name); ?></h1>

    <div class="card-container">
        <div class="card">
            <h2>Appointments</h2>
            <p>Check your upcoming and past appointments.</p>
            <a href="view_appointments.php" class="btn-dashboard">View Appointments</a>
        </div>
        <div class="card">
            <h2>Medical Records</h2>
            <p>Access your medical records and test results.</p>
            <a href="view_records.php" class="btn-dashboard">View Medical Records</a>
        </div>
        <div class="card">
            <h2>Treatment Plan</h2>
            <p>Access your Treatment plan and prescripsion.</p>
            <a href="view_treatment_plans.php" class="btn-dashboard">View Treatment Plan</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
