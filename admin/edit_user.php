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

// Check if ID exists
if (!isset($_GET['id'])) {
    header("Location: manage_users.php");
    exit();
}

$id = $_GET['id'];

// Get user information
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

// Save changes
if (isset($_POST['update'])) {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];

    $sql = "UPDATE users
            SET fullname=?, email=?, role=?
            WHERE id=?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $fullname,
        $email,
        $role,
        $id
    ]);

    header("Location: manage_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Edit User</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial;
}

body{

background:#f4f4f4;

}

.container{

width:500px;
margin:60px auto;
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 0 10px rgba(0,0,0,.15);

}

h2{

margin-bottom:20px;

}

label{

display:block;
margin-top:15px;
margin-bottom:5px;

}

input,
select{

width:100%;
padding:12px;

}

button{

margin-top:25px;

width:100%;
padding:12px;

background:#198754;

color:white;

border:none;

cursor:pointer;

font-size:16px;

}

button:hover{

background:#157347;

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

<a class="back" href="manage_users.php">

← Back

</a>

<h2>✏ Edit User</h2>

<form method="POST">

<label>Full Name</label>

<input
type="text"
name="fullname"
value="<?= htmlspecialchars($user['fullname']) ?>"
required>

<label>Email</label>

<input
type="email"
name="email"
value="<?= htmlspecialchars($user['email']) ?>"
required>

<label>Role</label>

<select name="role">

<option value="admin"
<?= $user['role']=="admin"?"selected":"" ?>>
Admin
</option>

<option value="citizen"
<?= $user['role']=="citizen"?"selected":"" ?>>
Citizen
</option>

<option value="responder"
<?= $user['role']=="responder"?"selected":"" ?>>
Responder
</option>

</select>

<button
type="submit"
name="update">

Save Changes

</button>

</form>

</div>

</body>

</html>