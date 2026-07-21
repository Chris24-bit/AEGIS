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

$sql = "SELECT * FROM users ORDER BY id ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Manage Users</title>

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

h1{

margin-bottom:25px;

}

table{

width:100%;
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
border-bottom:1px solid #ddd;
text-align:center;

}

tr:hover{

background:#f9f9f9;

}

a{

text-decoration:none;
padding:8px 15px;
border-radius:5px;
color:white;

}

.edit{

background:#198754;

}

.delete{

background:#dc3545;

}

.back{

display:inline-block;
margin-bottom:20px;
background:#6c757d;
padding:10px 18px;

}

</style>

</head>

<body>

<div class="container">

<a class="back" href="dashboard.php">
← Back to Dashboard
</a>

<h1>👥 Manage Users</h1>

<table>

<tr>

<th>ID</th>

<th>Full Name</th>

<th>Email</th>

<th>Role</th>

<th>Action</th>

</tr>

<?php foreach($users as $user){ ?>

<tr>

<td><?= $user['id'] ?></td>

<td><?= htmlspecialchars($user['fullname']) ?></td>

<td><?= htmlspecialchars($user['email']) ?></td>

<td><?= ucfirst($user['role']) ?></td>

<td>

<a class="edit"
href="edit_user.php?id=<?= $user['id'] ?>">
Edit
</a>

<a class="delete"
href="delete_user.php?id=<?= $user['id'] ?>"
onclick="return confirm('Delete this user?')">
Delete
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>