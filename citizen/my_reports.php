<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM reports
        WHERE user_id = ?
        ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);

$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>

<title>My Reports</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#f4f4f4;
    padding:40px;
}

.container{

    width:90%;
    margin:auto;

}

h2{

    margin-bottom:20px;

}

table{

    width:100%;
    border-collapse:collapse;
    background:white;

}

th{

    background:#0d6efd;
    color:white;
    padding:15px;

}

td{

    padding:15px;
    border-bottom:1px solid #ddd;

}

tr:hover{

    background:#f1f1f1;

}

.pending{

    color:orange;
    font-weight:bold;

}

.accepted{

    color:blue;
    font-weight:bold;

}

.resolved{

    color:green;
    font-weight:bold;

}

.back{

    display:inline-block;
    margin-bottom:20px;
    text-decoration:none;

}

</style>

</head>

<body>

<div class="container">

<a href="dashboard.php" class="back">⬅ Back to Dashboard</a>

<h2>📄 My Emergency Reports</h2>

<table>

<tr>

<th>ID</th>

<th>Emergency</th>

<th>Location</th>

<th>Description</th>

<th>Status</th>

<th>Date</th>

</tr>

<?php foreach($reports as $report){ ?>

<tr>

<td><?= $report['id']; ?></td>

<td><?= htmlspecialchars($report['emergency_type']); ?></td>

<td><?= htmlspecialchars($report['location']); ?></td>

<td><?= htmlspecialchars($report['description']); ?></td>

<td class="<?= strtolower($report['status']); ?>">
<?= htmlspecialchars($report['status']); ?>
</td>

<td><?= $report['created_at']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>