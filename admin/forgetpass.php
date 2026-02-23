<?php 
include '../lib/Database.php';
include '../config/config.php';
include '../helpers/Format.php';
include '../lib/Session.php';

Session::checkLogin();

$db = new Database();
$fm = new Format();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Password Recover</title>

<style>
body {
    margin: 0;
    padding: 0;
    background: #1f242d;
    font-family: Arial, sans-serif;
}

.login-box {
    width: 400px;
    padding: 40px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #2c313c;
    border-radius: 20px;
    box-shadow: 0 0 25px rgba(0,255,255,0.3);
    text-align: center;
}

.login-box h2 {
    color: #00f7ff;
    margin-bottom: 30px;
}

.input-box {
    margin-bottom: 20px;
    text-align: left;
}

.input-box label {
    color: #ccc;
    font-size: 14px;
}

.input-box input {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    border: none;
    border-radius: 25px;
    background: #444;
    color: #fff;
    outline: none;
}

.btn {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 25px;
    background: #00f7ff;
    color: #000;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 0 15px #00f7ff;
}

.btn:hover {
    background: #00c3cc;
    box-shadow: 0 0 25px #00f7ff;
}

.links {
    margin-top: 15px;
}

.links a {
    color: #ff00aa;
    text-decoration: none;
}

.links a:hover {
    text-decoration: underline;
}

.error {
    color: red;
    margin-bottom: 15px;
}

.success {
    color: #00ff99;
    margin-bottom: 15px;
    font-size: 16px;
}
</style>
</head>

<body>

<div class="login-box">
    <h2>Recover Password</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $fm->validation($_POST['email']);
    $email = mysqli_real_escape_string($db->link, $email);

    if (empty($email)) {

        echo "<div class='error'>Field must not be empty!</div>";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo "<div class='error'>Invalid Email Address!</div>";

    } else {

        $query = "SELECT * FROM tbl_user WHERE email='$email' LIMIT 1";
        $result = $db->select($query);

        if ($result && $result->num_rows > 0) {

            $user = $result->fetch_assoc();
            $userid   = $user['id'];
            $username = $user['username'];

            // Generate New Plain Password
            $newpass = rand(10000,99999);

            // Update Password (NO HASH)
            $update = "UPDATE tbl_user SET password='$newpass' WHERE id='$userid'";
            $updatePass = $db->update($update);

            if ($updatePass) {

                echo "<div class='success'>
                        Username: <b>$username</b><br><br>
                        Your New Password: <b>$newpass</b>
                      </div>";

            } else {

                echo "<div class='error'>Password Update Failed!</div>";
            }

        } else {

            echo "<div class='error'>Email does not exist!</div>";
        }
    }
}
?>

<form action="" method="post">

    <div class="input-box">
        <label>Email Address</label>
        <input type="text" name="email" placeholder="Enter your email" required>
    </div>

    <input type="submit" value="Recover Password" class="btn">

    <div class="links">
        <a href="login.php">Back to Login</a>
    </div>

</form>

</div>

</body>
</html>