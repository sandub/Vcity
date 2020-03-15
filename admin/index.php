<?php
include "../config.php";

if (isset($_SESSION['username'])) {
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' AND role='Admin'");
    $count = mysqli_num_rows($suser);
    if ($count > 0) {
        echo '<meta http-equiv="refresh" content="0; url=dashboard.php" />';
        exit;
    }
}

$_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$error = "No";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <title>vCity &rsaquo; Admin Panel</title>

        <!-- CSS -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
        <link rel="stylesheet" href="assets/css/admin.min.css">

        <!-- Favicon -->
        <link rel="shortcut icon" href="../assets/img/favicon.png">
    </head>

    <body class="hold-transition login-page">
        
<div class="login-box">
    <div class="login-logo">
        <a href="index.php"><i class="fas fa-heart"></i> v<strong>City</strong></a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Admin Panel</p>
<?php
if (isset($_POST['signin'])) {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = hash('sha256', $_POST['password']);
    $check    = mysqli_query($connect, "SELECT username, password FROM `players` WHERE `username`='$username' AND password='$password' AND role='Admin'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['username'] = $username;
        echo '<meta http-equiv="refresh" content="0;url=dashboard.php">';
    } else {
        echo '<br />
		<div class="callout callout-danger">
              <i class="fas fa-exclamation-circle"></i> The entered <strong>Username</strong> or <strong>Password</strong> is incorrect.
        </div>';
        $error = "Yes";
    }
}
?> 
        <form action="" method="post">
            <div class="form-group has-feedback <?php
if ($error == 1) {
    echo 'has-error';
}
?>">
                <input type="username" name="username" class="form-control" placeholder="Username" <?php
if ($error == 1) {
    echo 'autofocus';
}
?> required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" name="signin" class="btn btn-primary btn-block btn-flat btn-lg"><i class="fas fa-sign-in-alt"></i>
&nbsp;Sign In</button>
                </div>
            </div>
        </form> 
    </div>
</div>

        <!-- Javascript -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </body>
</html>