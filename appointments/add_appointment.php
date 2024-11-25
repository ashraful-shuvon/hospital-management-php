<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$patient_id, $doctor_id, $appointment_date, $status]);

    header("Location: view_appointments.php");
    exit();
}

$sqlPatients = "SELECT patient_id, first_name, last_name FROM patients";
$patients = $conn->query($sqlPatients);

$sqlDoctors = "SELECT doctor_id, first_name, last_name FROM doctors";
$doctors = $conn->query($sqlDoctors);
?>

<?php include '../includes/header.php'; ?>
<div class="form-container">
    <h2>Add Appointment</h2>
    <form method="POST">
        <label for="patient_id">Select Patient:</label>
        <select name="patient_id" id="patient_id" required>
            <option value="">--Select Patient--</option>
            <?php while ($row = $patients->fetch()) : ?>
                <option value="<?= $row['patient_id'] ?>"><?= $row['first_name'] . ' ' . $row['last_name'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="doctor_id">Select Doctor:</label>
        <select name="doctor_id" id="doctor_id" required>
            <option value="">--Select Doctor--</option>
            <?php while ($row = $doctors->fetch()) : ?>
                <option value="<?= $row['doctor_id'] ?>"><?= $row['first_name'] . ' ' . $row['last_name'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="appointment_date">Appointment Date:</label>
        <input type="datetime-local" name="appointment_date" id="appointment_date" required>

        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="Scheduled">Scheduled</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
        </select>

        <button type="submit" class="btn-primary">Add Appointment</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
