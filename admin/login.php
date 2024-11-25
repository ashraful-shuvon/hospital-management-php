<?php include '../config/db.php'; ?>
<?php include '../includes/header.php'; ?>
<div class="form-container">
    <h2>Admin Login</h2>
    <form id="loginForm" action="login.php" method="POST" onsubmit="return validateLogin()">
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <button type="submit" name="login" class="button">Login</button>
    </form>

    <?php
    session_start();

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM admins WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin['username'];
            header("Location: ../dashboard/index.php");
        } else {
            echo "<p>Invalid credentials. Try again.</p>";
        }
    }
    ?>
</div>

<?php include '../includes/footer.php'; ?>