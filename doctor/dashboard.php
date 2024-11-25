<?php
session_start();

// Check if doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

// Include necessary files
include '../includes/doctorNav.php';

$doctor_name = $_SESSION['doctor_name'];
?>

<div class="dashboard-container">
    <h1>Doctor Dashboard</h1>
    <h1>Welcome, <?php echo htmlspecialchars($doctor_name); ?></h1>

    <div class="card-container">
        <div class="card">
            <h2>Assigned Patients</h2>
            <p>View and manage patients assigned to you by the admin.</p>
            <a href="../doctor/view_assigned_patients.php" class="btn-dashboard">View Patients</a>
        </div>
        <div class="card">
            <h2>Appointments</h2>
            <p>View and manage your appointments with patients.</p>
            <a href="../doctor/view_appointments.php" class="btn-dashboard">View Appointments</a>
        </div>
        <div class="card">
            <h2>Medical Records</h2>
            <p>Access medical records of your assigned patients.</p>
            <a href="../doctor/view_records.php" class="btn-dashboard">View Medical Records</a>
        </div>
        <div class="card">
            <h2>Treatment Plans</h2>
            <p>Create and update treatment plans for your patients.</p>
            <a href="../doctor/view_treatment_plans.php" class="btn-dashboard">View Treatments</a>
            <a href="../doctor/add_treatment_plan.php" class="btn-dashboard">Add Treatment</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
