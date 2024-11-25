<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/db.php';

if (isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];

    // Delete related appointments first
    $deleteAppointments = "DELETE FROM appointments WHERE doctor_id = ?";
    $stmtAppointments = $conn->prepare($deleteAppointments);
    $stmtAppointments->execute([$doctor_id]);

    // Delete the doctor record
    $sql = "DELETE FROM doctors WHERE doctor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$doctor_id]);

    header("Location: view_doctors.php");
    exit();
}
?>
