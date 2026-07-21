<?php

session_start();

require_once "../config/database.php";

if(!isset($_POST['report_id'])){

    header("Location: dashboard.php");
    exit();

}

$id=$_POST['report_id'];

$sql="UPDATE reports
SET status='Resolved'
WHERE id=?";

$stmt=$pdo->prepare($sql);

$stmt->execute([$id]);

header("Location: dashboard.php");

exit();

?>