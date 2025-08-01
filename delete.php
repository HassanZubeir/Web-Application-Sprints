<?php
session_start();
require_once "database.php";

// Ensure the user is logged in
if (!isset($_SESSION['email_address'])) {
    $_SESSION['message'] = "❌ You must be logged in to delete reports.";
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email_address'];

// Get report ID from the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['message'] = "❌ Invalid report ID.";
    header("Location: submitreport.php");
    exit();
}

$reportId = intval($_GET['id']);

try {
    // Verify the report belongs to the logged-in user
    $stmt = $pdo->prepare("SELECT * FROM DiscriminationReport WHERE DiscriminationID = :id AND email_address = :email");
    $stmt->execute([':id' => $reportId, ':email' => $email]);
    $report = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$report) {
        $_SESSION['message'] = "❌ Report not found or you're not authorized.";
        header("Location: submitreport.php");
        exit();
    }

    // Delete the report
    $stmt = $pdo->prepare("DELETE FROM DiscriminationReport WHERE DiscriminationID = :id");
    $stmt->execute([':id' => $reportId]);

    $_SESSION['message'] = "✅ Report deleted successfully.";
    header("Location: submitreport.php");
    exit();

} catch (PDOException $e) {
    $_SESSION['message'] = "❌ Database error: " . $e->getMessage();
    header("Location: submitreport.php");
    exit();
}
?>
