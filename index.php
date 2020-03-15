<?php
require "config.php";

$lang = isset($_GET['lang']) ? $_GET['lang'] : "";

if (!empty($lang)) {
    $curr_lang = $_SESSION['curr_lang'] = $lang;
} else if (isset($_SESSION['curr_lang'])) {
    $curr_lang = $_SESSION['curr_lang'];
} else {
    $curr_lang = "en";
}

if (file_exists("languages/" . $curr_lang . ".php")) {
    include "languages/" . $curr_lang . ".php";
} else {
    include "languages/en.php";
}

// Returns language key
function lang_key($key)
{
    global $arrLang;
    $output = "";
    
    if (isset($arrLang[$key])) {
        $output = $arrLang[$key];
    } else {
        $output = str_replace("_", " ", $key);
    }
    return $output;
}

if (isset($_SESSION['username'])) {
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $count = mysqli_num_rows($suser);
    if ($count > 0) {
        echo '<meta http-equiv="refresh" content="0; url=home.php" />';
        exit;
    }
}

$_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$dirname   = $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
$vcity_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$dirname";

$query = mysqli_query($connect, "SELECT * FROM `settings` LIMIT 1");
$row   = mysqli_fetch_assoc($query);

$timeon  = time() - 60;
$queryop = mysqli_query($connect, "SELECT * FROM `players` WHERE timeonline>$timeon");
$countop = mysqli_num_rows($queryop);

$querytp = mysqli_query($connect, "SELECT * FROM `players`");
$counttp = mysqli_num_rows($querytp);

$querybp = mysqli_query($connect, "SELECT * FROM `players` ORDER BY respect DESC LIMIT 1");
$countbp = mysqli_num_rows($querybp);
if ($countbp > 0) {
    $rowbp       = mysqli_fetch_assoc($querybp);
    $best_player = $rowbp['username'];
} else {
    $best_player = "-";
}

$querynp = mysqli_query($connect, "SELECT * FROM `players` ORDER BY id DESC LIMIT 1");
$countnp = mysqli_num_rows($querynp);
if ($countnp > 0) {
    $rownp         = mysqli_fetch_assoc($querynp);
    $newest_player = $rownp['username'];
} else {
    $newest_player = "-";
}

if (isset($_GET['theme'])) {
    $id      = (int) $_GET["theme"];
    $queryts = mysqli_query($connect, "SELECT * FROM `themes` WHERE id='$id'");
    $rowts   = mysqli_fetch_assoc($queryts);
    $countts = mysqli_num_rows($queryts);
    if ($countts > 0) {
        $_SESSION["csspath"] = $rowts['csspath'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="<?php
echo $row['description'];
?>">
    <meta name="keywords" content="<?php
echo $row['keywords'];
?>">
    <meta name="author" content="Antonov_WEB">
    <link rel="icon" href="assets/img/favicon.png">

    <title><?php
echo $row['title'];
?></title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Skin -->
<?php
if (isset($_SESSION["csspath"])) {
?>
    <link href="<?php
    echo $_SESSION["csspath"];
?>" rel="stylesheet">
<?php
} else {
    $querytd = mysqli_query($connect, "SELECT * FROM `themes` WHERE `default_theme`='Yes'");
    $rowtd   = mysqli_fetch_assoc($querytd);
?>
    <link href="<?php
    echo $rowtd["csspath"];
?>" rel="stylesheet">
<?php
}
?>

    <!-- Game CSS -->
    <link href="assets/css/game.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
</head>

<body>

    <center>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                      <span class="sr-only"><?php
echo lang_key("navigation");
?></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand visible-xs" href="#"><?php
echo $row['title'];
?></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#home"><i class="fa fa-home fa-2x"></i><br /> <?php
echo lang_key("home");
?></a></li>
                        <li><a href="#about"><i class="fa fa-info-circle fa-2x"></i><br /> <?php
echo lang_key("about");
?></a></li>
                        <li><a href="#screenshots"><i class="fa fa-images fa-2x"></i><br /> <?php
echo lang_key("screenshots");
?></a></li>
                        <li><a href="#gamelogin"><i class="fa fa-sign-in-alt fa-2x"></i><br /> <?php
echo lang_key("signin");
?></a></li>
                        <li><a href="#join"><i class="fa fa-user-plus fa-2x"></i><br /> <?php
echo lang_key("register");
?></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </center>


    <div class="container-fluid">

        <div class="jumbotron">
            <div class="row">
                <div class="col-md-9">
                    <h1><i class="fa fa-building"></i> <i class="fa fa-car"></i> <i class="fa fa-users"></i> <?php
echo $row['title'];
?></h1>
                    <p><?php
echo $row['description'];
?></p>
                    <hr><br />
                    <h4><i class="fas fa-check-circle"></i> <?php
echo lang_key("online_players");
?>: <span class="label label-success"><?php
echo $countop;
?></span></h4>
                    <h4><i class="fa fa-users"></i> <?php
echo lang_key("total_players");
?>: <span class="label label-primary"><?php
echo $counttp;
?></span></h4>
                    <h4><i class="fa fa-trophy"></i> <?php
echo lang_key("best_player");
?>: <span class="label label-danger"><?php
echo $best_player;
?></span></h4>
                    <h4><i class="fa fa-user-plus"></i> <?php
echo lang_key("newest_player");
?>: <span class="label label-warning"><?php
echo $newest_player;
?></span></h4>
                </div>
                <div class="col-md-3 col-xs-12" id="gamelogin">
                    <div class="well">
                        <center>
                            <h4><i class="fa fa-sign-in-alt"></i> <?php
echo lang_key("signin");
?></h4>
                            <hr />
                        </center>
<?php
$error = "No";

if (isset($_POST['signin'])) {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = hash('sha256', $_POST['password']);
    $check    = mysqli_query($connect, "SELECT username, password FROM `players` WHERE `username`='$username' AND password='$password'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['username'] = $username;
        echo '<meta http-equiv="refresh" content="0;url=home.php">';
    } else {
        echo '<br />
		<div class="alert alert-danger">
              <i class="fa fa-exclamation-circle"></i> ' . lang_key("userpass_incorrect") . '
        </div>';
        $error = "Yes";
    }
}
?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label><?php
echo lang_key("username");
?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><em class="fa fa-fw fa-user"></em></span>
                                    <input name="username" type="text" placeholder="<?php
echo lang_key("username");
?>" class="form-control" <?php
if ($error == "Yes") {
    echo 'autofocus';
}
?> required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?php
echo lang_key("password");
?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><em class="fa fa-fw fa-key"></em></span>
                                    <input name="password" type="password" placeholder="<?php
echo lang_key("password");
?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="btn-toolbar">
                                <button type="submit" name="signin" class="btn btn-info btn-md btn-block"><i class="fa fa-sign-in-alt"></i> <?php
echo lang_key("signin");
?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary panel-portlet">
            <div class="panel-heading">
                <h3 class="panel-title"><?php
echo $row['title'];
?></h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-4" id="screenshots">
                        <div class="well">
                            <center>
                                <h3><i class="fa fa-images"></i> <?php
echo lang_key("screenshots_full");
?></h3>
                                <hr />
                            </center>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="well">
                                        <a href="images/screenshots/1.png" target="_blank">
                                            <img src="images/screenshots/1.png" width="100%" height="150" style="border:1px solid #BFBFBF;" />
                                        </a>
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <div class="well">
                                        <a href="images/screenshots/2.png" target="_blank">
                                            <img src="images/screenshots/2.png" width="100%" height="150" style="border:1px solid #BFBFBF;" />
                                        </a>
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">
                                    <div class="well">
                                        <a href="images/screenshots/3.png" target="_blank">
                                            <img src="images/screenshots/3.png" width="100%" height="150" style="border:1px solid #BFBFBF;" />
                                        </a>
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <div class="well">
                                        <a href="images/screenshots/4.png" target="_blank">
                                            <img src="images/screenshots/4.png" width="100%" height="150" style="border:1px solid #BFBFBF;" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" id="join">
                        <div class="well">
                            <center>
                                <h3><i class="fa fa-user-plus"></i> <?php
echo lang_key("register_full");
?></h3>
                                <hr />
<?php
$querytd = mysqli_query($connect, "SELECT * FROM `themes` WHERE default_theme='Yes'");
$rowtd   = mysqli_fetch_assoc($querytd);

$queryld = mysqli_query($connect, "SELECT * FROM `languages` WHERE default_language='Yes'");
$rowld   = mysqli_fetch_assoc($queryld);

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']);
    $email    = $_POST['email'];
    
    $sql = mysqli_query($connect, "SELECT username FROM `players` WHERE username='$username'");
    if (mysqli_num_rows($sql) > 0) {
        echo '<br /><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' . lang_key("username_taken") . '</div>';
    } else {
        $sql2 = mysqli_query($connect, "SELECT email FROM `players` WHERE email='$email'");
        if (mysqli_num_rows($sql2) > 0) {
            echo '<br /><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>  ' . lang_key("email_taken") . '</div>';
        } else {
            $money    = $row['startmoney'];
            $gold     = $row['startgold'];
            $themeid  = $rowtd['id'];
            $langcode = $rowld['langcode'];
            
            $insert = mysqli_query($connect, "INSERT INTO `players` (username, password, email, money, gold, theme, language) VALUES ('$username', '$password', '$email', '$money', '$gold', '$themeid', '$langcode')");
            
            $subject = 'Welcome at ' . $row['title'] . '';
            $message = '
                    <center>
					<a href="' . $vcity_url . '" title="Visit ' . $row['title'] . '" target="_blank">
					<h1>' . $row['title'] . '</h1>
					</a><br />
					
					<h2>You have successfully registered at ' . $row['title'] . '</h2><br /><br />
					
					<b>Registration details:</b><br />
					Username: ' . $username . '<b></b><br />
					E-Mail Addess: ' . $email . '<b></b><br />
					</center>
				    ';
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= 'To: ' . $email . ' <' . $email . '>' . "\r\n";
            $headers .= 'From: vcity@mail.com <vcity@mail.com>' . "\r\n";
            @mail($to, $subject, $message, $headers);
            
            $_SESSION['username'] = $username;
            echo '<meta http-equiv="refresh" content="0;url=home.php">';
        }
    }
}
?>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label><?php
echo lang_key("username");
?></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><em class="fa fa-fw fa-user"></em></span>
                                            <input name="username" type="text" placeholder="<?php
echo lang_key("username");
?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><?php
echo lang_key("email");
?></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><em class="fa fa-fw fa-user"></em></span>
                                            <input name="email" type="email" placeholder="<?php
echo lang_key("email");
?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><?php
echo lang_key("password");
?></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><em class="fa fa-fw fa-key"></em></span>
                                            <input name="password" type="password" placeholder="<?php
echo lang_key("password");
?>" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="btn-toolbar">
                                        <button type="submit" name="register" class="btn btn-success btn-md btn-block"><i class="fa fa-pen-square"></i> <?php
echo lang_key("register");
?></button>
                                    </div>
                                </form>
                            </center>
                        </div>
                    </div>

                    <div class="col-md-4" id="about">
                        <div class="well">
                            <center>
                                <h3><i class="far fa-file-alt"></i> <?php
echo lang_key("about");
?></h3>
                                <hr />
                            </center>
                            <?php
echo html_entity_decode($row['about']);
?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-footer">
                <?php
echo $row['title'];
?>
            </div>
        </div>

    </div>
    <!-- /container -->

    <footer class="footer">
        <div class="container-fluid">
		<div class="row">
            <div class="col-md-6">
		
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php
echo lang_key("languages");
?> <span class="caret caret-up"></span></button>
                <ul class="dropdown-menu drop-up" role="menu">
                    <li><a href="?lang=<?php
echo $rowld['langcode'];
?>"><?php
echo $rowld['language'];
?> [<?php
echo lang_key("default");
?>]</a></li>
                    <li class="divider"></li>
<?php
$queryl = mysqli_query($connect, "SELECT * FROM `languages`");
while ($rowl = mysqli_fetch_assoc($queryl)) {
?>
                    <li><a href="?lang=<?php
    echo $rowl['langcode'];
?>"><?php
    echo $rowl['language'];
?></a></li>
<?php
}
?>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php
echo lang_key("themes");
?> <span class="caret caret-up"></span></button>
                <ul class="dropdown-menu drop-up" role="menu">
                    <li><a href="?theme=<?php
echo $rowtd['id'];
?>"><?php
echo $rowtd['name'];
?> [<?php
echo lang_key("default");
?>]</a></li>
                    <li class="divider"></li>
<?php
$queryt = mysqli_query($connect, "SELECT * FROM `themes`");
while ($rowt = mysqli_fetch_assoc($queryt)) {
?>
                    <li><a href="?theme=<?php
    echo $rowt['id'];
?>"><?php
    echo $rowt['name'];
?></a></li>
<?php
}
?>
                </ul>
            </div>
			
			</div>
			<div class="col-md-6">
			
            <div class="pull-right">&copy; <?php
echo date("Y");
?> <?php
echo $row['title'];
?></div>
            <a href="#" class="go-top"><i class="fa fa-arrow-up"></i></a>
			
			</div>
		</div>
        </div>
    </footer>

    <!-- JavaScript Libraries
    ================================================== -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Game JS -->
    <script src="assets/js/game.js"></script>

</body>
</html>