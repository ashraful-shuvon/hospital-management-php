<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/db.php';

// Update patient details if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_patient'])) {
    try {
        $patient_id = $_POST['patient_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $username = $_POST['username'];

        // Update query
        $sql = "UPDATE patients 
                SET first_name = ?, last_name = ?, date_of_birth = ?, gender = ?, contact_number = ?, email = ?, address = ?, username = ?
                WHERE patient_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$first_name, $last_name, $date_of_birth, $gender, $contact_number, $email, $address, $username, $patient_id]);

        echo "<script>
                window.location.href = 'view_patients.php';
              </script>";
        exit();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

// Fetch patient details to display in the form
if (isset($_GET['patient_id'])) {
    try {
        $patient_id = $_GET['patient_id'];
        $sql = "SELECT * FROM patients WHERE patient_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$patient_id]);
        $patient = $stmt->fetch();

        if (!$patient) {
            echo "<script>
                    alert('Patient not found!');
                    window.location.href = 'view_patients.php';
                  </script>";
            exit();
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: view_patients.php");
    exit();
}
?>

<?php include '../includes/header.php'; ?>

<div class="form-container">
    <h2>Edit Patient</h2>
    <form method="POST" action="edit_patient.php">
        <input type="hidden" name="patient_id" value="<?php echo $patient['patient_id']; ?>">

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($patient['first_name']); ?>" required>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($patient['last_name']); ?>" required>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $patient['date_of_birth']; ?>" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male" <?php if ($patient['gender'] === 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($patient['gender'] === 'Female') echo 'selected'; ?>>Female</option>
        </select>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($patient['contact_number']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>" required>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required><?php echo htmlspecialchars($patient['address']); ?></textarea>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($patient['username']); ?>" required>

        <button type="submit" name="update_patient">Update Patient</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
