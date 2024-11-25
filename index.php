<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>
<body>
    
<div class="welcome-container">
    <h1>Welcome to the Hospital Management System</h1>
    <p>Manage patient information, treatment records, and more with ease.</p>
    
    <div class="actions">
        <h2>Get Started</h2>
        <a href="admin/register.php" class="button">Admin Register</a>
        <a href="admin/login.php" class="button">Admin Login</a>
        <a href="doctor/login.php" class="button">Doctor login</a>
        <a href="patient/login.php" class="button">Patient login</a>


    </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>