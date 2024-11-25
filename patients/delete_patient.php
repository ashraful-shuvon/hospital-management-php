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

if (isset($_GET['patient_id']) && is_numeric($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];
    $sql = "DELETE FROM patients WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$patient_id])) {
        header("Location: view_patients.php");
        exit();
    } else {
        echo "Error deleting patient. Please try again.";
    }
} else {
    echo "Invalid patient ID.";
}
?>
