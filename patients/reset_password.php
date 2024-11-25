<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include '../config/db.php';

if (isset($_POST['reset_password'])) {
    $patient_id = $_POST['patient_id'];
    $new_password = $_POST['new_password'];
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    $sql = "UPDATE patients SET password = ? WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$hashed_password, $patient_id])) {
        echo "<script>
                alert('Password reset successfully!');
                window.location.href = 'view_patients.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Error resetting password. Please try again.');
                window.history.back();
              </script>";
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="form-container">
    <h2>Reset Patient Password</h2>
    <form method="POST" action="reset_password.php">
        <input type="hidden" name="patient_id" value="<?php echo $_GET['patient_id']; ?>">
        <input type="password" name="new_password" placeholder="New Password" required>
        <button type="submit" name="reset_password">Reset Password</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
