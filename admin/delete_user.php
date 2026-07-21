<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_users.php");
    exit();
}

$id = $_GET['id'];

// Prevent admin from deleting themselves
if ($id == $_SESSION['user_id']) {
    echo "<script>
            alert('You cannot delete your own account.');
            window.location='manage_users.php';
          </script>";
    exit();
}

// Check if user exists
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);

if ($stmt->rowCount() == 0) {
    echo "<script>
            alert('User not found.');
            window.location='manage_users.php';
          </script>";
    exit();
}

// Check if user has emergency reports
$stmt = $pdo->prepare("SELECT COUNT(*) FROM reports WHERE user_id = ?");
$stmt->execute([$id]);

$totalReports = $stmt->fetchColumn();

if ($totalReports > 0) {
    echo "<script>
            alert('Cannot delete this user because they have emergency reports.');
            window.location='manage_users.php';
          </script>";
    exit();
}

// Delete user
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);

echo "<script>
        alert('User deleted successfully.');
        window.location='manage_users.php';
      </script>";

exit();
?>