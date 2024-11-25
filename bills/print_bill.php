<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit();
}

include '../config/db.php';

// Fetch admin name
$admin_name = $_SESSION['admin'];

// Validate and fetch bill details
if (isset($_GET['bill_id'])) {
    $bill_id = $_GET['bill_id'];

    // Fetch bill details
    $stmt = $conn->prepare("SELECT b.*, p.first_name, p.last_name 
                            FROM bills b
                            JOIN patients p ON b.patient_id = p.patient_id
                            WHERE b.bill_id = ?");
    $stmt->execute([$bill_id]);
    $bill = $stmt->fetch();

    // Fetch bill tests
    $stmt = $conn->prepare("SELECT t.test_name, t.test_fee 
                            FROM bill_tests bt 
                            JOIN tests t ON bt.test_id = t.test_id 
                            WHERE bt.bill_id = ?");
    $stmt->execute([$bill_id]);
    $tests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Invalid Bill ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        .bill-container {
            max-width: 600px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }
        .bill-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .bill-header h2 {
            margin: 0;
        }
        .bill-details, .admin-info {
            margin-bottom: 20px;
        }
        .bill-details p, .admin-info p {
            margin: 5px 0;
        }
        .bill-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .bill-table th, .bill-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .bill-table th {
            background-color: #f2f2f2;
        }
        .total-amount {
            text-align: right;
            font-size: 1.2em;
            font-weight: bold;
        }
        .print-button {
            text-align: center;
            margin-top: 20px;
        }
        .print-button button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .print-button button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="bill-container">
        <div class="bill-header">
            <h2>Hospital Management System</h2>
            <p>Bill Receipt</p>
        </div>

        <div class="bill-details">
            <p><strong>Bill ID:</strong> <?= htmlspecialchars($bill['bill_id']) ?></p>
            <p><strong>Patient:</strong> <?= htmlspecialchars($bill['first_name'] . ' ' . $bill['last_name']) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($bill['created_at']) ?></p>
        </div>

        <table class="bill-table">
            <thead>
                <tr>
                    <th>Test Name</th>
                    <th>Test Fee</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tests as $test): ?>
                    <tr>
                        <td><?= htmlspecialchars($test['test_name']) ?></td>
                        <td>$<?= number_format($test['test_fee'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><strong>Treatment Fee:</strong> $<?= number_format($bill['treatment_fee'], 2) ?></p>
        <p><strong>Service Charge:</strong> $<?= number_format($bill['service_charge'], 2) ?></p>
        <p class="total-amount">Total Amount: $<?= number_format($bill['total_amount'], 2) ?></p>

        <div class="admin-info">
            <p><strong>Bill Prepared By:</strong> <?= htmlspecialchars($admin_name) ?></p>
        </div>

        <div class="print-button">
            <button onclick="window.print()">Print Bill</button>
        </div>
    </div>
</body>
</html>
