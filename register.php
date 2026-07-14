<?php

require_once "config/database.php";

$success = "";
$error = "";

if (isset($_POST['register'])) {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Password Validation
    if ($password !== $confirm_password) {

        $error = "Passwords do not match.";

    } else {

        // Check if Email Exists
        $sql = "SELECT id FROM users WHERE email = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {

            $error = "Email already exists.";

        } else {

            // Hash Password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert User
            $sql = "INSERT INTO users (fullname, email, password, role)
                    VALUES (?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);

            if ($stmt->execute([
                $fullname,
                $email,
                $hashedPassword,
                $role
            ])) {

                $success = "Registration Successful!";

            } else {

                $error = "Something went wrong.";

            }

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>AEGIS | Register</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#f4f4f4;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.container{

    background:#fff;
    width:400px;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,.2);

}

h2{

    text-align:center;
    margin-bottom:25px;

}

label{

    display:block;
    margin-bottom:5px;

}

input,
select,
button{

    width:100%;
    padding:10px;
    margin-bottom:15px;
    font-size:15px;

}

button{

    background:#007BFF;
    color:#fff;
    border:none;
    cursor:pointer;
    transition:.3s;

}

button:hover{

    background:#0056b3;

}

.toast{

    position:fixed;
    top:20px;
    right:20px;

    padding:15px 25px;

    color:white;
    font-weight:bold;

    border-radius:8px;

    box-shadow:0 5px 15px rgba(0,0,0,.2);

    animation:fadeIn .4s;

    z-index:999;

}

.success{

    background:#28a745;

}

.error{

    background:#dc3545;

}

@keyframes fadeIn{

    from{

        opacity:0;
        transform:translateY(-20px);

    }

    to{

        opacity:1;
        transform:translateY(0);

    }

}

</style>

</head>

<body>

<?php if($success): ?>

<div id="toast" class="toast success">
    ✅ <?= $success ?>
</div>

<?php endif; ?>

<?php if($error): ?>

<div id="toast" class="toast error">
    ❌ <?= $error ?>
</div>

<?php endif; ?>

<div class="container">

<h2>Create Account</h2>

<form method="POST">

<label>Full Name</label>
<input
type="text"
name="fullname"
value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>"
required>

<label>Email</label>
<input
type="email"
name="email"
value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
required>

<label>Password</label>
<input
type="password"
name="password"
required>

<label>Confirm Password</label>
<input
type="password"
name="confirm_password"
required>

<label>Role</label>

<select name="role" required>

<option value="">-- Select Role --</option>

<option value="citizen"
<?= (($_POST['role'] ?? '') == 'citizen') ? 'selected' : '' ?>>
Citizen
</option>

<option value="responder"
<?= (($_POST['role'] ?? '') == 'responder') ? 'selected' : '' ?>>
Responder
</option>

</select>

<button type="submit" name="register">
Register
</button>

</form>

</div>

<script>

const toast = document.getElementById("toast");

if(toast){

    setTimeout(function(){

        toast.style.transition=".5s";
        toast.style.opacity="0";

        setTimeout(function(){

            toast.remove();

        },500);

    },3000);

}

<?php if($success): ?>

setTimeout(function(){

    window.location.href="login.php";

},3000);

<?php endif; ?>

</script>

</body>
</html>