<?php include '../config/db.php'; ?>
<?php include '../includes/header.php'; ?>

<div class="form-container">
    <h2>Login</h2>

    <!-- Role Selection -->
    <form action="login.php" method="GET">
        <label for="role">Select Role:</label>
        <select name="role" id="role" required>
            <option value="admin">Admin</option>
            <option value="doctor">Doctor</option>
            <option value="patient">Patient</option>
        </select>
        <button type="submit" class="button">Select Role</button>
    </form>

    <?php
    // Only show login form after role selection
    if (isset($_GET['role'])) {
        $role = $_GET['role'];
        ?>

        <form id="loginForm" action="login.php?role=<?php echo $role; ?>" method="POST" onsubmit="return validateLogin()">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button type="submit" name="login" class="button">Login</button>
        </form>

        <?php
        // Handle login for different roles
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($role == 'admin') {
                // Admin login
                $sql = "SELECT * FROM admins WHERE username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$username]);
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($admin && password_verify($password, $admin['password'])) {
                    $_SESSION['admin'] = $admin['username'];
                    header("Location: ../dashboard/index.php");
                } else {
                    echo "<p>Invalid admin credentials. Try again.</p>";
                }
            } elseif ($role == 'doctor') {
                // Doctor login
                $sql = "SELECT * FROM doctors WHERE username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$username]);
                $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($doctor && password_verify($password, $doctor['password'])) {
                    $_SESSION['doctor'] = $doctor['username'];
                    header("Location: ../doctor/dashboard.php");
                } else {
                    echo "<p>Invalid doctor credentials. Try again.</p>";
                }
            } elseif ($role == 'patient') {
                // Patient login
                $sql = "SELECT * FROM patients WHERE username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$username]);
                $patient = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($patient && password_verify($password, $patient['password'])) {
                    $_SESSION['patient'] = $patient['username'];
                    header("Location: ../patient/patient_dashboard.php");
                } else {
                    echo "<p>Invalid patient credentials. Try again.</p>";
                }
            }
        }
    }
    ?>
</div>

<?php include '../includes/footer.php'; ?>
