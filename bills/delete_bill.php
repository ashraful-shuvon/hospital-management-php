<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include '../config/db.php';

if (isset($_GET['bill_id'])) {
    $bill_id = $_GET['bill_id'];

    $stmt = $conn->prepare("DELETE FROM bills WHERE bill_id = ?");
    if ($stmt->execute([$bill_id])) {
        $_SESSION['success'] = "Bill deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting bill.";
    }

    header("Location: view_bills.php");
    exit();
}
?>
