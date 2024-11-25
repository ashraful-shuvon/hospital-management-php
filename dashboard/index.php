<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>

<?php include '../includes/header.php'; ?>

<div class="dashboard-container">
    <h1>Admin Dashboard</h1>

    <div class="card-container">
        <div class="card">
            <h2>Patient Management</h2>
            <p>Manage patient details and medical history.</p>
            <a href="../patients/view_patients.php" class="btn-dashboard">View Patients</a>
            <a href="../patients/add_patient.php" class="btn-dashboard">Add Patient</a>
        </div>
        <div class="card">
            <h2>Doctor Management</h2>
            <p>Manage doctor details and specializations.</p>
            <a href="../doctors/view_doctors.php" class="btn-dashboard">View Doctors</a>
            <a href="../doctors/add_doctor.php" class="btn-dashboard">Add Doctor</a>
        </div>

        <div class="card">
            <h2>Nurse Management</h2>
            <p>Manage nurse details and specializations.</p>
            <a href="../treatments/view_treatments.php" class="btn-dashboard">View Treatments</a>
            <a href="../treatments/add_treatment.php" class="btn-dashboard">Add Treatment</a>
        </div>
        <div class="card">
            <h2>Appointments</h2>
            <p>Schedule and manage doctor appointments.</p>
            <a href="../appointments/view_appointments.php" class="btn-dashboard">View Appointments</a>
            <a href="../appointments/add_appointment.php" class="btn-dashboard">Add Appointment</a>
        </div>
        <div class="card">
            <h2>Medical Records</h2>
            <p>Maintain detailed patient medical records.</p>
            <a href="../medicalRecords/view_records.php" class="btn-dashboard">View Medical Records</a>
            <a href="../medicalRecords/add_record.php" class="btn-dashboard">Add Record</a>
        </div>
        <div class="card">
            <h2>Billing System</h2>
            <p>Generate bills based on treatments, tests, and services.</p>
            <a href="../bills/view_bills.php" class="btn-dashboard">View Bills</a>
            <a href="../bills/add_bill.php" class="btn-dashboard">Add Bill</a>
        </div>
    </div>


</div>

<?php include '../includes/footer.php'; ?>