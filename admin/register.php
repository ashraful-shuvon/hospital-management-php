<?php include '../config/db.php'; ?>
<?php include '../includes/header.php'; ?>

<div class="form-container">
    <h2>Admin Registration</h2>
    <form id="registerForm" action="register.php" method="POST" onsubmit="return validateRegistration()">
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <button type="submit" name="register" class="btn-primary">Register</button>
    </form>

    <?php
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO admins (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $password]);

        echo "<p>Registration successful! <a href='login.php'>Login here</a></p>";
    }
    ?>
</div>

<?php include '../includes/footer.php'; ?>
