<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "config/database.php";

session_start();

$message = "";

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    if($stmt->rowCount() > 0){

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];

            $message = "✅ Login Successful!";

            // Temporary redirect
            header("refresh:2; url=index.php");
            exit();

        }else{

            $message = "❌ Incorrect password.";

        }

    }else{

        $message = "❌ Email not found.";

    }

}
?>

<!DOCTYPE html>
<html>
<head>

<title>AEGIS | Login</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#f4f4f4;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.container{

    width:400px;
    background:#fff;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,.2);

}

h2{
    text-align:center;
    margin-bottom:20px;
}

input,button{

    width:100%;
    padding:12px;
    margin-bottom:15px;

}

button{

    background:#007BFF;
    color:white;
    border:none;
    cursor:pointer;
    font-size:16px;

}

button:hover{

    background:#0056b3;

}

.message{

    text-align:center;
    margin-bottom:15px;
    color:red;
    font-weight:bold;

}

</style>

</head>
<body>

<div class="container">

<h2>Login</h2>

<?php
if($message != ""){
    echo "<div class='message'>$message</div>";
}
?>

<form method="POST">

<input type="email"
name="email"
placeholder="Email"
required>

<input type="password"
name="password"
placeholder="Password"
required>

<button type="submit"
name="login">
Login
</button>

</form>

</div>

</body>
</html>