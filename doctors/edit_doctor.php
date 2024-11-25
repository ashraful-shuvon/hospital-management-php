<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include '../config/db.php';
if (isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];
    $sql = "SELECT * FROM doctors WHERE doctor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$doctor_id]);
    $doctor = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $specialization = $_POST['specialization'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];

    $sql = "UPDATE doctors SET first_name = ?, last_name = ?, specialization = ?, contact_number = ?, email = ? WHERE doctor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$first_name, $last_name, $specialization, $contact_number, $email, $doctor_id]);
    header("Location: view_doctors.php");
    exit();
}

include '../includes/header.php';
?>

<div class="form-container">
    <h2>Edit Doctor</h2>
    <form action="edit_doctor.php" method="POST">
        <input type="hidden" name="doctor_id" value="<?php echo $doctor['doctor_id']; ?>">
        <input type="text" name="first_name" value="<?php echo $doctor['first_name']; ?>" required>
        <input type="text" name="last_name" value="<?php echo $doctor['last_name']; ?>" required>
        <input type="text" name="specialization" value="<?php echo $doctor['specialization']; ?>" required>
        <input type="text" name="contact_number" value="<?php echo $doctor['contact_number']; ?>" required>
        <input type="email" name="email" value="<?php echo $doctor['email']; ?>" required>
        <button type="submit">Update Doctor</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
