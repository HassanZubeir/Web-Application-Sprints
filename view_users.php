<?php
session_start();
require_once "database.php";

// Redirect if not logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all users excluding password
$stmt = $pdo->query("SELECT UserID, First_name, Last_name, email_address, Department FROM User ORDER BY UserID ASC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Registered Users</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .delete-btn {
            background-color: #e60000;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        .delete-btn:hover {
            background-color: #cc0000;
        }

        .message {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #888;
            background-color: #f9f9f9;
            color: #333;
        }
    </style>
</head>
<body>

<header>
    <h1>Registered Users</h1>
    <p>Administrator View</p>
</header>

<nav>
    <a href="admin.php">Dashboard</a>
    <a href="logout.php">Logout</a>
</nav>

<main class="container">
    <h2>All Users</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="message"><?= $_SESSION['message'] ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (count($users) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['UserID']) ?></td>
                        <td><?= htmlspecialchars($user['First_name']) ?></td>
                        <td><?= htmlspecialchars($user['Last_name']) ?></td>
                        <td><?= htmlspecialchars($user['email_address']) ?></td>
                        <td><?= htmlspecialchars($user['Department']) ?></td>
                        <td>
                            <form action="delete_user.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <input type="hidden" name="user_id" value="<?= $user['UserID'] ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No users registered yet.</p>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; <?= date("Y") ?> EquiSafe. All rights reserved.</p>
</footer>

</body>
</html>
