<?php
session_start();
require_once "database.php";

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user_id"])) {
    $userId = $_POST["user_id"];

    // Prepare and execute delete query
    $stmt = $pdo->prepare("DELETE FROM User WHERE UserID = ?");
    if ($stmt->execute([$userId])) {
        $_SESSION['message'] = "User deleted successfully.";
    } else {
        $_SESSION['message'] = "Failed to delete user.";
    }
}

header("Location: view_users.php");
exit();
?>
