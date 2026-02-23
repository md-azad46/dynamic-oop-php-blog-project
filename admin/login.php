<?php 
include '../lib/Session.php';
Session::checkLogin();
include '../config/config.php';
include '../lib/Database.php';
include '../helpers/Format.php';

$db = new Database();
$fm = new Format();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Login</title>

<style>
body{
    margin:0;
    padding:0;
    font-family: Arial, Helvetica, sans-serif;
    background:#1f2029;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

#content{
    width:350px;
    padding:40px;
    background:#24243e;
    border-radius:20px;
    box-shadow:0 0 20px rgba(0,255,255,0.4);
    text-align:center;
}

#content h1{
    color:#00f2fe;
    margin-bottom:25px;
}

#content input{
    width:100%;
    padding:12px;
    margin:12px 0;
    border:none;
    border-radius:20px;
    background:#2d2f4a;
    color:white;
    outline:none;
}

#content input[type="submit"]{
    background:#00f2fe;
    color:black;
    font-weight:bold;
    cursor:pointer;
}

#content input[type="submit"]:hover{
    background:#4facfe;
}

.link{
    margin-top:15px;
}

.link a{
    color:#ccc;
    text-decoration:none;
    font-size:14px;
}

.link a:hover{
    color:#00f2fe;
}

.error{
    color:red;
    margin-bottom:10px;
}
</style>

</head>
<body>

<div id="content">

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $fm->validation($_POST['username']);
    $password = $fm->validation($_POST['password']);

    $username = mysqli_real_escape_string($db->link, $username);
    $password = mysqli_real_escape_string($db->link, $password);

    $query = "SELECT * FROM tbl_user 
              WHERE username='$username' 
              AND password='$password' 
              LIMIT 1";

    $result = $db->select($query);

    if ($result != false) {

        $value = $result->fetch_assoc();

        Session::set("login", true);
        Session::set("username", $value['username']);
        Session::set("userId", $value['id']);
        Session::set("userRole", $value['role']);

        header("Location:index.php");
        exit();

    } else {
        echo "<div class='error'>Username or Password not matched!</div>";
    }
}
?>

<form action="" method="post">
    <h1>Admin Login</h1>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Login">
</form>

<div class="link">
    <a href="forgetpass.php">Forgot Password?</a>
</div>

</div>

</body>
</html>