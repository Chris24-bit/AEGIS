<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] != "responder") {
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT reports.*, users.fullname
        FROM reports
        INNER JOIN users ON reports.user_id = users.id
        ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>

<title>Responder Dashboard</title>

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
width:95%;
margin:auto;
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
background:#f8f8f8;
}

button{
padding:8px 15px;
background:#198754;
color:white;
border:none;
cursor:pointer;
border-radius:5px;
}

button:hover{
background:#157347;
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

</style>

</head>

<body>

<div class="container">

<h2>🚑 Responder Dashboard</h2>

<br>

<table>

<tr>

<th>Citizen</th>
<th>Emergency</th>
<th>Location</th>
<th>Description</th>
<th>Status</th>
<th>Action</th>

</tr>

<?php foreach($reports as $report){ ?>

<tr>

<td><?= htmlspecialchars($report['fullname']) ?></td>

<td><?= htmlspecialchars($report['emergency_type']) ?></td>

<td><?= htmlspecialchars($report['location']) ?></td>

<td><?= htmlspecialchars($report['description']) ?></td>

<td class="<?= strtolower($report['status']) ?>">
<?= htmlspecialchars($report['status']) ?>
</td>

<td>

<?php if($report['status']=="Pending"){ ?>

<form method="POST" action="accept_report.php">

<input type="hidden" name="report_id" value="<?= $report['id'] ?>">

<button type="submit">
✅ Accept
</button>

</form>

<?php }elseif($report['status']=="Accepted"){ ?>

<form method="POST" action="resolve_report.php">

<input type="hidden" name="report_id" value="<?= $report['id'] ?>">

<button
style="background:#dc3545;"
type="submit">

✔ Resolve

</button>

</form>

<?php }else{ ?>

✅ Done

<?php } ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>