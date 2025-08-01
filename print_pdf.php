<?php
require_once "database.php";

// Get the email from the URL
$email = $_GET['email'] ?? '';

if (empty($email)) {
    die("No email address provided.");
}

// Fetch the report using the email address
$stmt = $pdo->prepare("SELECT * FROM DiscriminationReport WHERE email_address = ? ORDER BY Date_occurred DESC LIMIT 1");
$stmt->execute([$email]);
$report = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$report) {
    die("No report found for this email address.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Export Report <?= htmlspecialchars($report['email_address']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f9f9f9;
            color: #333;
        }
        h1, h2 {
            text-align: center;
        }
        .report-container {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .report-row {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 200px;
        }
        .print-button {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .print-button:hover {
            background-color: #0056b3;
        }
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="report-container">
    <h1>Discrimination Report</h1>
    <h2><?= htmlspecialchars($report['email_address']) ?></h2>

    <div class="report-row"><span class="label">Full Name:</span> <?= htmlspecialchars($report['fullname']) ?></div>
    <div class="report-row"><span class="label">Department:</span> <?= htmlspecialchars($report['Department']) ?></div>
    <div class="report-row"><span class="label">Offender Name:</span> <?= htmlspecialchars($report['Offender_name']) ?></div>
    <div class="report-row"><span class="label">Discrimination Type:</span> <?= htmlspecialchars($report['Discrimination_type']) ?></div>
    <div class="report-row"><span class="label">Date Occurred:</span> <?= htmlspecialchars($report['Date_occurred']) ?></div>
    <div class="report-row"><span class="label">Communication Mode:</span> <?= htmlspecialchars($report['Communication_mode']) ?></div>
    <div class="report-row"><span class="label">Description:</span><?= nl2br(htmlspecialchars($report['Description_incident'])) ?></div>
    <div class="report-row"><span class="label">Status:</span> <?= htmlspecialchars($report['Status']) ?></div>

    <button class="print-button" onclick="window.print()"> Print / Save as PDF</button>
</div>

</body>
</html>
