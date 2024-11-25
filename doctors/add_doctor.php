<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $specialization = trim($_POST['specialization']);
    $contact_number = trim($_POST['contact_number']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Input validation
    if (empty($first_name) || empty($last_name) || empty($specialization) || empty($contact_number) || empty($email) || empty($username) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Check for duplicate username
        $check_user_sql = "SELECT * FROM doctors WHERE username = ?";
        $stmt = $conn->prepare($check_user_sql);
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $error = "Username already exists. Please choose another.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert into database
            $sql = "INSERT INTO doctors (first_name, last_name, specialization, contact_number, email, username, password)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt->execute([$first_name, $last_name, $specialization, $contact_number, $email, $username, $hashed_password])) {
                // Redirect to view doctors page with success message
                $_SESSION['success'] = "Doctor added successfully!";
                header("Location: view_doctors.php");
                exit();
            } else {
                $error = "Error: Could not add doctor. Please try again.";
            }
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="form-container">
    <h2>Add Doctor</h2>
    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="add_doctor.php">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="text" name="specialization" placeholder="Specialization" required>
        <input type="text" name="contact_number" placeholder="Contact Number" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="add_doctor">Add Doctor</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
