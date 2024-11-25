<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include '../config/db.php';
include '../includes/header.php';

$record_id = $_GET['record_id'];
$record = $conn->query("SELECT * FROM medical_records WHERE record_id = $record_id")->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $diagnosis = $_POST['diagnosis'];
    $prescription = $_POST['prescription'];
    $test_results = $_POST['test_results'];

    $sql = "UPDATE medical_records SET diagnosis = :diagnosis, prescription = :prescription, 
            test_results = :test_results WHERE record_id = :record_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':diagnosis' => $diagnosis,
        ':prescription' => $prescription,
        ':test_results' => $test_results,
        ':record_id' => $record_id,
    ]);

    header("Location: view_records.php");
    exit();
}
?>

<div class="form-container">
    <h2>Edit Medical Record</h2>
    <form method="POST">
        <label>Diagnosis:</label>
        <textarea name="diagnosis" required><?= $record['diagnosis']; ?></textarea>

        <label>Prescription:</label>
        <textarea name="prescription" required><?= $record['prescription']; ?></textarea>

        <label>Test Results:</label>
        <textarea name="test_results"><?= $record['test_results']; ?></textarea>

        <button type="submit" class="btn-submit">Update Record</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
