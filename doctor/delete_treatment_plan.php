<?php
session_start();

// Check if doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include '../config/db.php';

// Get treatment plan ID
if (!isset($_GET['treatment_id'])) {
    die("Invalid treatment ID.");
}

$treatment_id = $_GET['treatment_id'];
$doctor_id = $_SESSION['doctor_id'];

// Delete treatment plan
try {
    $sql = "
        DELETE FROM treatment_plans 
        WHERE treatment_id = :treatment_id AND doctor_id = :doctor_id
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':treatment_id', $treatment_id, PDO::PARAM_INT);
    $stmt->bindParam(':doctor_id', $doctor_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: view_treatment_plans.php?success=delete");
        exit();
    } else {
        die("Failed to delete treatment plan.");
    }
} catch (PDOException $e) {
    die("Error deleting treatment plan: " . $e->getMessage());
}
?>
