<?php
session_start();
require_once "database.php"; // Include your PDO connection

// Check if user is logged in
if (!isset($_SESSION['email_address'])) {
    echo "❌ You must be logged in to edit reports.";
    exit();
}

$error = '';
$report = null;

// 1️⃣ Handle form submission for updating a report
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_report"])) {
    $DiscriminationID = $_POST["DiscriminationID"];
    $Offender_name = htmlspecialchars(trim($_POST["Offender_name"]));
    $Discrimination_type = htmlspecialchars(trim($_POST["Discrimination_type"]));
    $Date_occurred = $_POST["Date_occurred"];
    $Communication_mode = $_POST["Communication_mode"];
    $Description_incident = htmlspecialchars(trim($_POST["Description_incident"]));

    try {
        // Update report for the logged-in user's email only
        $stmt = $pdo->prepare("UPDATE DiscriminationReport 
                               SET Offender_name = :offender, 
                                   Discrimination_type = :type, 
                                   Date_occurred = :date, 
                                   Communication_mode = :mode, 
                                   Description_incident = :desc 
                               WHERE DiscriminationID = :id 
                                 AND email_address = :email");

        $stmt->execute([
            ':offender' => $Offender_name,
            ':type' => $Discrimination_type,
            ':date' => $Date_occurred,
            ':mode' => $Communication_mode,
            ':desc' => $Description_incident,
            ':id' => $DiscriminationID,
            ':email' => $_SESSION['email_address']
        ]);

        // ✅ Redirect to submitted reports after update
        header("Location: reports.php");
        exit();

    } catch (PDOException $e) {
        $error = "❌ Error updating report: " . $e->getMessage();
    }
}

// 2️⃣ Fetch the report to edit
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $DiscriminationID = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM DiscriminationReport 
                               WHERE DiscriminationID = :id 
                                 AND email_address = :email");
        $stmt->execute([
            ':id' => $DiscriminationID,
            ':email' => $_SESSION['email_address']
        ]);
        $report = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$report) {
            $error = "❌ Report not found or you are not authorized.";
        }
    } catch (PDOException $e) {
        $error = "❌ Error fetching report: " . $e->getMessage();
    }
} else {
    $error = "❌ Invalid report ID.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Report</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <h1>Edit Discrimination Report</h1>
</header>

<main class="container">
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php elseif ($report): ?>
        <form method="POST" action="editreports.php">
            <!-- Hidden field to pass the ID -->
            <input type="hidden" name="DiscriminationID" value="<?= $report['DiscriminationID'] ?>">

            <label>Offender Name:</label>
            <input type="text" name="Offender_name" required value="<?= htmlspecialchars($report['Offender_name']) ?>">

            <label>Discrimination Type:</label>
            <input type="text" name="Discrimination_type" required value="<?= htmlspecialchars($report['Discrimination_type']) ?>">

            <label>Date Occurred:</label>
            <input type="date" name="Date_occurred" required value="<?= $report['Date_occurred'] ?>">

            <label>Communication Mode:</label>
            <select name="Communication_mode" required>
                <option value="Email" <?= $report['Communication_mode'] === 'Email' ? 'selected' : '' ?>>Email</option>
                <option value="In Person" <?= $report['Communication_mode'] === 'In Person' ? 'selected' : '' ?>>In Person</option>
                <option value="Mobile" <?= $report['Communication_mode'] === 'Mobile' ? 'selected' : '' ?>>Mobile</option>
            </select>

            <label>Description of Incident:</label>
            <textarea name="Description_incident" rows="5" required><?= htmlspecialchars($report['Description_incident']) ?></textarea>

            <input type="submit" name="update_report" value="Update Report">
        </form>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; 2025 EquiSafe. All rights reserved.</p>
</footer>

</body>
</html>
