<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Citizen Dashboard</title>

<style>

body{
    font-family:Arial;
    background:#f4f4f4;
    text-align:center;
    margin-top:100px;
}

.box{

    width:500px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.2);

}

a{

    display:inline-block;
    margin-top:20px;
    text-decoration:none;
    background:red;
    color:white;
    padding:10px 20px;
    border-radius:5px;

}

</style>

</head>

<body>

<div class="box">

<h1>🚨 Citizen Dashboard</h1>

<h2>Welcome</h2>

<h3><?php echo $_SESSION['fullname']; ?></h3>

<p>Role :
<b><?php echo $_SESSION['role']; ?></b>
</p>

<a href="../logout.php">Logout</a>

</div>

</body>
</html>