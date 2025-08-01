<?php
session_start();
require_once "database.php";

// Ensure user is logged in
if (!isset($_SESSION['email_address'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email_address'];

// Handle delete request
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM DiscriminationReport WHERE DiscriminationID = :id AND email_address = :email");
        $stmt->execute([':id' => $deleteId, ':email' => $email]);
        header("Location: submitreports.php");
        exit();
    } catch (PDOException $e) {
        die("❌ Error deleting report: " . $e->getMessage());
    }
}

// Fetch all reports submitted by the logged-in user
try {
    $stmt = $pdo->prepare("SELECT * FROM DiscriminationReport WHERE email_address = :email");
    $stmt->execute([':email' => $email]);
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("❌ Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Reports | EquiSafe</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    .btn {
      padding: 5px 10px;
      text-decoration: none;
      border-radius: 4px;
      margin: 2px;
      font-size: 0.9em;
    }

    .edit-btn {
      background-color: #4CAF50;
      color: white;
    }

    .delete-btn {
      background-color: #f44336;
      color: white;
    }

  </style>
</head>
<body>

<header>
  <h1>My Reports EquiSafe</h1>
</header>

<nav>
  <a href="home.php">Home</a>
  <a href="submitreport.php">Submit Report</a>
  <a href="logout.php">Logout</a>
</nav>

<main class="container">
  <h2>Reports submitted by <?= htmlspecialchars($email) ?></h2>

  <?php if (count($reports) === 0): ?>
    <p>No reports submitted yet.</p>
  <?php else: ?>
    <table border="1">
      <tr>
        <th>#</th>
        <th>Department</th>
        <th>Offender</th>
        <th>Type</th>
        <th>Date</th>
        <th>Mode</th>
        <th>Description</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
      <?php foreach ($reports as $index => $report): ?>
        <tr>
          <td><?= $index + 1 ?></td>
          <td><?= htmlspecialchars($report['Department']) ?></td>
          <td><?= htmlspecialchars($report['Offender_name']) ?></td>
          <td><?= htmlspecialchars($report['Discrimination_type']) ?></td>
          <td><?= htmlspecialchars($report['Date_occurred']) ?></td>
          <td><?= htmlspecialchars($report['Communication_mode']) ?></td>
          <td><?= nl2br(htmlspecialchars($report['Description_incident'])) ?></td>
          <td><?= htmlspecialchars($report['Status'] ?? 'Pending') ?></td>
          <td>
            <a class="btn edit-btn" href="editreports.php?id=<?= $report['DiscriminationID'] ?>">Modify</a>
            <a href="delete.php?id=<?= $report['DiscriminationID'] ?>" 
               class="btn delete-btn"
               onclick="return confirm('Are you sure you want to delete this report?')">
               Delete
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
</main>

<footer>
  <p>&copy; 2025 EquiSafe. All rights reserved.</p>
</footer>

</body>
</html>
