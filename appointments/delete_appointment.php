<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include '../config/db.php';

if (isset($_GET['appointment_id'])) {
    $appointment_id = $_GET['appointment_id'];
    $sql = "DELETE FROM appointments WHERE appointment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$appointment_id]);
}

header("Location: view_appointments.php");
exit();
?>
