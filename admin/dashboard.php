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

// Dashboard Statistics
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalCitizens = $pdo->query("SELECT COUNT(*) FROM users WHERE role='citizen'")->fetchColumn();
$totalResponders = $pdo->query("SELECT COUNT(*) FROM users WHERE role='responder'")->fetchColumn();

$totalReports = $pdo->query("SELECT COUNT(*) FROM reports")->fetchColumn();
$pending = $pdo->query("SELECT COUNT(*) FROM reports WHERE status='Pending'")->fetchColumn();
$accepted = $pdo->query("SELECT COUNT(*) FROM reports WHERE status='Accepted'")->fetchColumn();
$resolved = $pdo->query("SELECT COUNT(*) FROM reports WHERE status='Resolved'")->fetchColumn();

// Recent Reports
$sql = "SELECT reports.*, users.fullname
        FROM reports
        INNER JOIN users ON reports.user_id = users.id
        ORDER BY reports.created_at DESC
        LIMIT 5";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>AEGIS | Admin Dashboard</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,Helvetica,sans-serif;
}

body{
background:#f4f4f4;
padding:40px;
}

.container{
width:95%;
margin:auto;
}

h1{
margin-bottom:10px;
}

.cards{

display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
margin-top:25px;

}

.card{

background:white;
padding:25px;
border-radius:10px;
box-shadow:0 0 10px rgba(0,0,0,.15);
text-align:center;

}

.card h2{

font-size:18px;
margin-bottom:10px;

}

.card h1{

font-size:35px;
color:#0d6efd;

}

table{

width:100%;
margin-top:40px;
background:white;
border-collapse:collapse;
box-shadow:0 0 10px rgba(0,0,0,.15);

}

th{

background:#0d6efd;
color:white;
padding:15px;

}

td{

padding:15px;
text-align:center;
border-bottom:1px solid #ddd;

}

.pending{
color:orange;
font-weight:bold;
}

.accepted{
color:#0d6efd;
font-weight:bold;
}

.resolved{
color:green;
font-weight:bold;
}

.logout{

display:inline-block;
margin-top:30px;

background:red;
color:white;

padding:12px 20px;

text-decoration:none;

border-radius:8px;

}

.logout:hover{

background:darkred;

}

</style>

</head>

<body>

<div class="container">

<h1>👑 Admin Dashboard</h1>

<p>

Welcome,

<br><br>

<a href="manage_users.php"
style="
background:#0d6efd;
color:white;
padding:12px 20px;
text-decoration:none;
border-radius:8px;
">

👥 Manage Users

</a>

<strong><?= htmlspecialchars($_SESSION['fullname']); ?></strong>

</p>

<div class="cards">

<div class="card">
<h2>Total Users</h2>
<h1><?= $totalUsers ?></h1>
</div>

<div class="card">
<h2>Citizens</h2>
<h1><?= $totalCitizens ?></h1>
</div>

<div class="card">
<h2>Responders</h2>
<h1><?= $totalResponders ?></h1>
</div>

<div class="card">
<h2>Total Reports</h2>
<h1><?= $totalReports ?></h1>
</div>

<div class="card">
<h2>Pending</h2>
<h1><?= $pending ?></h1>
</div>

<div class="card">
<h2>Accepted</h2>
<h1><?= $accepted ?></h1>
</div>

<div class="card">
<h2>Resolved</h2>
<h1><?= $resolved ?></h1>
</div>

</div>

<h2 style="margin-top:40px;">📋 Recent Emergency Reports</h2>

<table>

<tr>

<th>Citizen</th>
<th>Emergency</th>
<th>Location</th>
<th>Status</th>
<th>Date</th>

</tr>

<?php foreach($reports as $report){ ?>

<tr>

<td><?= htmlspecialchars($report['fullname']) ?></td>

<td><?= htmlspecialchars($report['emergency_type']) ?></td>

<td><?= htmlspecialchars($report['location']) ?></td>

<td class="<?= strtolower($report['status']) ?>">
<?= htmlspecialchars($report['status']) ?>
</td>

<td><?= htmlspecialchars($report['created_at']) ?></td>

</tr>

<?php } ?>

</table>

<a class="logout" href="../logout.php">

Logout

</a>

</div>

</body>
</html>