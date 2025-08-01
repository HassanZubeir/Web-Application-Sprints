<?php
session_start();
require_once "database.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $id = $_POST['report_id'];
    $newStatus = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE DiscriminationReport SET Status = :status WHERE DiscriminationID = :id");
    $stmt->execute([':status' => $newStatus, ':id' => $id]);
    header("Location: admin.php");
    exit();
}

// Fetch all reports
$stmt = $pdo->query("SELECT * FROM DiscriminationReport ORDER BY Date_occurred DESC");
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
            max-width: 100%;
            box-sizing: border-box;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }
        .btn {
            padding: 6px 10px;
            background-color: #0f1010;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

    </style>
</head>
<body>

<header>
    <h1>Admin Dashboard</h1>
    <p>Welcome, Administrator</p>
</header>

<nav>
    <a href="view_users.php">User Details</a>
    <a href="logout.php">Logout</a>
</nav>

<main class="container">
    <h2>Submitted Discrimination Reports</h2>

    <?php if (count($reports) > 0): ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Offender</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Mode</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Export</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td><?= htmlspecialchars($report['fullname']) ?></td>
                            <td><?= htmlspecialchars($report['email_address']) ?></td>
                            <td><?= htmlspecialchars($report['Department']) ?></td>
                            <td><?= htmlspecialchars($report['Offender_name']) ?></td>
                            <td><?= htmlspecialchars($report['Discrimination_type']) ?></td>
                            <td><?= htmlspecialchars($report['Date_occurred']) ?></td>
                            <td><?= htmlspecialchars($report['Communication_mode']) ?></td>
                            <td><?= nl2br(htmlspecialchars($report['Description_incident'])) ?></td>
                            <td>
                                <form class="inline-form" method="POST" action="admin.php">
                                    <input type="hidden" name="report_id" value="<?= $report['DiscriminationID'] ?>">
                                    <select name="status">
                                        <option value="Pending" <?= $report['Status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="Under Investigation" <?= $report['Status'] === 'Under Investigation' ? 'selected' : '' ?>>Under Investigation</option>
                                        <option value="Response Sent" <?= $report['Status'] === 'Response Sent' ? 'selected' : '' ?>>Response Sent</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn">Update</button>
                                </form>
                            </td>
                            <td>
                                <a href="print_pdf.php?email=<?= urlencode($report['email_address']) ?>" target="_blank" class="btn">Export</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No reports submitted yet.</p>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; <?= date("Y") ?> EquiSafe. All rights reserved.</p>
</footer>

</body>
</html>
