<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include '../config/db.php';

$record_id = $_GET['record_id'];
$sql = "DELETE FROM medical_records WHERE record_id = :record_id";
$stmt = $conn->prepare($sql);
$stmt->execute([':record_id' => $record_id]);

header("Location: view_records.php");
exit();
?>
