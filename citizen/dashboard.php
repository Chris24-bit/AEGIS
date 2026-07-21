<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] != "citizen") {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>AEGIS | Citizen Dashboard</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    display:flex;
    background:#f4f4f4;
}

/* Sidebar */

.sidebar{
    width:250px;
    height:100vh;
    background:#0d6efd;
    color:white;
    position:fixed;
}

.sidebar h2{
    text-align:center;
    padding:25px;
    border-bottom:1px solid rgba(255,255,255,.2);
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:15px 25px;
    transition:.3s;
}

.sidebar a:hover{
    background:#084298;
}

/* Main */

.main{
    margin-left:250px;
    width:100%;
}

/* Header */

.header{
    background:white;
    padding:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

/* Content */

.content{
    padding:30px;
}

.card{
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.1);
}

.card h2{
    margin-bottom:15px;
}

/* Quick Menu */

.quick{
    margin-top:25px;
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
}

.box{
    background:white;
    padding:30px;
    text-align:center;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.1);
    transition:.3s;
    cursor:pointer;
    text-decoration:none;
    color:#333;
}

.box:hover{
    transform:translateY(-5px);
    background:#0d6efd;
    color:white;
}

.box h1{
    font-size:45px;
}

.box h3{
    margin-top:15px;
}

</style>

</head>

<body>

<!-- Sidebar -->
<div class="sidebar">

    <h2>AEGIS</h2>

    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="report.php">🚨 Report Emergency</a>
    <a href="my_reports.php">📄 My Reports</a>
    <a href="profile.php">👤 Profile</a>
    <a href="../logout.php">🚪 Logout</a>

</div>

<!-- Main -->
<div class="main">

    <div class="header">

        <h2>Citizen Dashboard</h2>

        <div>
            Welcome,
            <strong><?php echo htmlspecialchars($_SESSION['fullname']); ?></strong>
        </div>

    </div>

    <div class="content">

        <div class="card">

            <h2>Hello <?php echo htmlspecialchars($_SESSION['fullname']); ?> 👋</h2>

            <p>
                Welcome to the
                <b>AEGIS Emergency Response System.</b>
            </p>

            <br>

            <p>
                Use the menu on the left to report emergencies, monitor reports, and manage your profile.
            </p>

        </div>

        <div class="quick">

            <a href="report.php" class="box">
                <h1>🚨</h1>
                <h3>Report Emergency</h3>
            </a>

            <a href="my_reports.php" class="box">
                <h1>📄</h1>
                <h3>My Reports</h3>
            </a>

            <a href="profile.php" class="box">
                <h1>👤</h1>
                <h3>Profile</h3>
            </a>

        </div>

    </div>

</div>

</body>
</html>