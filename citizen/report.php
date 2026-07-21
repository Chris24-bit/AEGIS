<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] != "citizen") {
    header("Location: ../login.php");
    exit();
}

$success = "";

if (isset($_POST['submit_report'])) {

    $user_id = $_SESSION['user_id'];
    $emergency_type = $_POST['emergency_type'];
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);

    $sql = "INSERT INTO reports (user_id, emergency_type, location, description)
            VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $user_id,
        $emergency_type,
        $location,
        $description
    ]);

    $success = "Emergency report submitted successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Report Emergency</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#f4f4f4;
}

.container{
    width:700px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,.15);
}

h2{
    text-align:center;
    margin-bottom:25px;
}

label{
    font-weight:bold;
}

input,
select,
textarea{
    width:100%;
    padding:12px;
    margin-top:8px;
    margin-bottom:20px;
}

textarea{
    height:150px;
    resize:none;
}

button{
    width:100%;
    padding:15px;
    background:#dc3545;
    color:white;
    border:none;
    font-size:18px;
    cursor:pointer;
}

button:hover{
    background:#bb2d3b;
}

.back{
    display:inline-block;
    margin-bottom:20px;
    text-decoration:none;
}

.toast{
    position:fixed;
    top:20px;
    right:20px;
    background:#198754;
    color:white;
    padding:15px 25px;
    border-radius:8px;
    box-shadow:0 5px 15px rgba(0,0,0,.2);
}

</style>
</head>

<body>

<?php if($success!=""){ ?>

<div class="toast" id="toast">
    ✅ <?php echo $success; ?>
</div>

<script>
setTimeout(function(){

    let toast=document.getElementById("toast");

    toast.style.opacity="0";

    setTimeout(function(){

        toast.remove();

    },500);

},3000);
</script>

<?php } ?>

<div class="container">

<a href="dashboard.php" class="back">⬅ Back to Dashboard</a>

<h2>🚨 Report Emergency</h2>

<form method="POST">

<label>Emergency Type</label>

<select name="emergency_type" required>

<option value="">Select Emergency</option>

<option>Fire</option>

<option>Flood</option>

<option>Medical</option>

<option>Crime</option>

<option>Earthquake</option>

<option>Landslide</option>

</select>

<label>Location</label>

<input
type="text"
name="location"
placeholder="Enter location"
required>

<label>Description</label>

<textarea
name="description"
placeholder="Describe the emergency..."
required></textarea>

<button
type="submit"
name="submit_report">

🚨 Submit Report

</button>

</form>

</div>

</body>
</html>