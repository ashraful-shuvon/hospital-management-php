<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include '../config/db.php';

// Fetch the appointment details
if (isset($_GET['appointment_id'])) {
    $appointment_id = $_GET['appointment_id'];

    $sql = "SELECT * FROM appointments WHERE appointment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$appointment_id]);
    $appointment = $stmt->fetch();

    if (!$appointment) {
        echo "Appointment not found.";
        exit();
    }
}

// Update appointment details
if (isset($_POST['update_appointment'])) {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $status = $_POST['status'];

    $sql = "UPDATE appointments 
            SET patient_id = ?, doctor_id = ?, appointment_date = ?, status = ? 
            WHERE appointment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$patient_id, $doctor_id, $appointment_date, $status, $appointment_id]);

    header("Location: view_appointments.php");
    exit();
}
?>

<?php include '../includes/header.php'; ?>
<div class="form-container">
    <h2>Edit Appointment</h2>
    <form action="edit_appointment.php?appointment_id=<?= $appointment_id ?>" method="POST">
        <label for="patient_id">Patient ID</label>
        <input type="number" name="patient_id" id="patient_id" value="<?= $appointment['patient_id'] ?>" required>

        <label for="doctor_id">Doctor ID</label>
        <input type="number" name="doctor_id" id="doctor_id" value="<?= $appointment['doctor_id'] ?>" required>

        <label for="appointment_date">Appointment Date</label>
        <input type="date" name="appointment_date" id="appointment_date" value="<?= $appointment['appointment_date'] ?>" required>

        <label for="status">Status</label>
        <select name="status" id="status" required>
            <option value="Scheduled" <?= $appointment['status'] === 'Scheduled' ? 'selected' : '' ?>>Scheduled</option>
            <option value="Completed" <?= $appointment['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
            <option value="Cancelled" <?= $appointment['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>

        <button type="submit" name="update_appointment" class="btn-primary">Update Appointment</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
