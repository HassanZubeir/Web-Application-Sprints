<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $status = $_POST["status"];

    $stmt = $pdo->prepare("UPDATE DiscriminationReport SET Status = ? WHERE email_address = ?");
    $stmt->execute([$status, $email]);

    header("Location: admin.php");
    exit();
}
?>
