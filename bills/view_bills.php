<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include '../config/db.php';

// Fetch bills
$sql = "SELECT b.bill_id, b.treatment_fee, b.service_charge, b.total_amount, b.created_at, 
               p.first_name, p.last_name
        FROM bills b
        JOIN patients p ON b.patient_id = p.patient_id";
$bills = $conn->query($sql)->fetchAll();

// Fetch bill tests
$bill_tests = [];
foreach ($bills as $bill) {
    $stmt = $conn->prepare("SELECT t.test_name FROM bill_tests bt 
                            JOIN tests t ON bt.test_id = t.test_id 
                            WHERE bt.bill_id = ?");
    $stmt->execute([$bill['bill_id']]);
    $bill_tests[$bill['bill_id']] = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>

<?php include '../includes/header.php'; ?>

<div class="common-container">
    <h2>View Bills</h2>
    <table class="common-table">
        <thead>
            <tr>
                <th>Bill ID</th>
                <th>Patient</th>
                <th>Treatment Fee</th>
                <th>Service Charge</th>
                <th>Tests</th>
                <th>Total Amount</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bills as $bill): ?>
                <tr>
                    <td><?= $bill['bill_id'] ?></td>
                    <td><?= $bill['first_name'] . ' ' . $bill['last_name'] ?></td>
                    <td>$<?= number_format($bill['treatment_fee'], 2) ?></td>
                    <td>$<?= number_format($bill['service_charge'], 2) ?></td>
                    <td>
                        <ul>
                            <?php foreach ($bill_tests[$bill['bill_id']] as $test): ?>
                                <li style="list-style-type:decimal;padding:0px"><?= $test ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td>$<?= number_format($bill['total_amount'], 2) ?></td>
                    <td><?= $bill['created_at'] ?></td>
                    <td>
                        <a href="delete_bill.php?bill_id=<?= $bill['bill_id'] ?>" onclick="return confirm('Are you sure want to delete this bill?')" class="btn btn-delete">Delete</a>
                        <a href="print_bill.php?bill_id=<?= $bill['bill_id'] ?>" target="_blank" class="btn btn-primary" >Print</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
