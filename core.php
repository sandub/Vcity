<?php
require "config.php";

$_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if (isset($_SESSION['username'])) {
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $rowu  = mysqli_fetch_assoc($suser);
    $count = mysqli_num_rows($suser);
    if ($count <= 0) {
        echo '<meta http-equiv="refresh" content="0; url=index.php" />';
        exit;
    }
} else {
    echo '<meta http-equiv="refresh" content="0; url=index.php" />';
    exit;
}

if (isset($_GET['lang'])) {
    $langcode = $_GET["lang"];
    $queryls  = mysqli_query($connect, "SELECT * FROM `languages` WHERE langcode='$langcode'");
    $rowls    = mysqli_fetch_assoc($queryls);
    $countls  = mysqli_num_rows($queryls);
    if ($countls > 0) {
        $querytu = mysqli_query($connect, "UPDATE `players` SET language='$langcode' WHERE username='$uname'");
        echo '<meta http-equiv="refresh" content="0; url=home.php" />';
    }
}

@include 'languages/' . $rowu['language'] . '.php';

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


if (isset($_GET['theme'])) {
    $id      = (int) $_GET["theme"];
    $queryts = mysqli_query($connect, "SELECT * FROM `themes` WHERE id='$id'");
    $rowts   = mysqli_fetch_assoc($queryts);
    $themeid = $rowts['id'];
    $countts = mysqli_num_rows($queryts);
    if ($countts > 0) {
        $querytu = mysqli_query($connect, "UPDATE `players` SET theme='$themeid' WHERE username='$uname'");
    }
}

function percent($num_amount, $num_total)
{
    @$count1 = $num_amount / $num_total;
    $count2 = $count1 * 100;
    $count  = number_format($count2, 0);
    return $count;
}

function secondsToWords($seconds)
{
    $ret = "";
    
    //Days
    $mdays = intval(intval($seconds) / (3600 * 24));
    if ($mdays > 0) {
        $ret .= "$mdays days ";
    }
    
    //Hours
    $mhours = (intval($seconds) / 3600) % 24;
    if ($mhours > 0) {
        $ret .= "$mhours hours ";
    }
    
    //Minutes
    $mminutes = (intval($seconds) / 60) % 60;
    if ($mminutes > 0) {
        $ret .= "$mminutes minutes ";
    }
    
    /*
    //Seconds
    $seconds = intval($seconds) % 60;
    if ($seconds > 0) {
    $ret .= "$seconds seconds";
    }*/
    
    return $ret;
}

function emoticons($text)
{
    $icons = array(
        ':)' => '🙂',
        ':-)' => '🙂',
        ':}' => '🙂',
        ':D' => '😀',
        ':d' => '😁',
        ':-D ' => '😂',
        ';D' => '😂',
        ';d' => '😂',
        ';)' => '😉',
        ';-)' => '😉',
        ':P' => '😛',
        ':-P' => '😛',
        ':-p' => '😛',
        ':p' => '😛',
        ':-b' => '😛',
        ':-Þ' => '😛',
        ':(' => '🙁',
        ';(' => '😓',
        ':\'(' => '😓',
        ':o' => '😮',
        ':O' => '😮',
        ':0' => '😮',
        ':-O' => '😮',
        ':|' => '😐',
        ':-|' => '😐',
        ' :/' => ' 😕',
        ':-/' => '😕',
        ':X' => '😷',
        ':x' => '😷',
        ':-X' => '😷',
        ':-x' => '😷',
        '8)' => '😎',
        '8-)' => '😎',
        'B-)' => '😎',
        ':3' => '😊',
        '^^' => '😊',
        '^_^' => '😊',
        '<3' => '😍',
        ':*' => '😘',
        'O:)' => '😇',
        '3:)' => '😈',
        'o.O' => '😵',
        'O_o' => '😵',
        'O_O' => '😵',
        'o_o' => '😵',
        '0_o' => '😵',
        'T_T' => '😵',
        '-_-' => '😑',
        '>:O' => '😆',
        '><' => '😆',
        '>:(' => '😣',
        ':v' => '🙃',
        '(y)' => '👍',
        ':poop:' => '💩',
        ':|]' => '🤖'
    );
    return strtr($text, $icons);
}

function head()
{
    require "config.php";
    
    $query = mysqli_query($connect, "SELECT * FROM `settings` WHERE id='1' LIMIT 1");
    $row   = mysqli_fetch_assoc($query);
    
    $uname     = $_SESSION['username'];
    $suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $rowu      = mysqli_fetch_assoc($suser);
    $player_id = $rowu['id'];
    
    $querypc      = mysqli_query($connect, "SELECT character_id FROM `players` WHERE username='$uname' LIMIT 1");
    $rowpc        = mysqli_fetch_assoc($querypc);
    $character_id = $rowpc['character_id'];
    $queryc       = mysqli_query($connect, "SELECT * FROM `characters` WHERE id='$character_id' LIMIT 1");
    $countc       = mysqli_num_rows($queryc);
    $rowc         = mysqli_fetch_assoc($queryc);
    if ($countc == 0 && basename($_SERVER['SCRIPT_NAME']) != 'choose-character.php') {
        echo '<meta http-equiv="refresh" content="0; url=choose-character.php" />';
        exit;
    }
    if ($countc > 0 && basename($_SERVER['SCRIPT_NAME']) == 'choose-character.php') {
        echo '<meta http-equiv="refresh" content="0; url=home.php" />';
        exit;
    }
    
    @include 'languages/' . $rowu['language'] . '.php';
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

<?php
    $themeid = $rowu['theme'];
    $querytg = mysqli_query($connect, "SELECT * FROM `themes` WHERE id='$themeid'");
    $rowtg   = mysqli_fetch_assoc($querytg);
?>
    <!-- Skin -->
    <link href="<?php
    echo $rowtg['csspath'];
?>" rel="stylesheet">

    <!-- Game CSS -->
    <link href="assets/css/game.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    <!-- Right Sidebar - Chat -->
    <link href="assets/css/sidebar.css" rel="stylesheet">
	
<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'leaderboard.php' OR basename($_SERVER['SCRIPT_NAME']) == 'messages.php') {
        echo '
	<!-- DataTables -->
    <link href="assets/css/datatables.min.css" rel="stylesheet">';
    }
?>

<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'messages.php') {
        echo '
	<!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet">';
    }
?>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    
<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'casino.php') {
        echo '
	<!-- WinWheel -->
    <link href="assets/css/winwheel.css" rel="stylesheet">
	<script src="assets/js/winwheel.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js">';
    }
?>
	
<script>
setInterval(function () {
    $("#playerstats").load("ajax.php #stats");
    $("#playerstats2").load('ajax.php #stats2');
    $("#playerskills").load('ajax.php #skills');
    $("#globalchat").load('ajax.php #chat');
    $("#onlineplayers").load('ajax.php #online');
}, 2000);
</script>
    
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
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'home.php') {
        echo 'class="active"';
    }
?>><a href="home.php"><i class="fa fa-home fa-2x"></i><br /> <?php
    echo lang_key("home");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'vehicles.php') {
        echo 'class="active"';
    }
?>><a href="vehicles.php"><i class="fa fa-car fa-2x"></i><br /> <?php
    echo lang_key("vehicles");
?></span></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'properties.php') {
        echo 'class="active"';
    }
?>><a href="properties.php"><i class="fa fa-building fa-2x"></i><br /> <?php
    echo lang_key("properties");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'pets.php') {
        echo 'class="active"';
    }
?>><a href="pets.php"><i class="fa fa-paw fa-2x"></i><br /> <?php
    echo lang_key("pets");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'shop.php') {
        echo 'class="active"';
    }
?>><a href="shop.php"><i class="fa fa-shopping-cart fa-2x"></i><br /> <?php
    echo lang_key("shop");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'jobs.php') {
        echo 'class="active"';
    }
?>><a href="jobs.php"><i class="fa fa-briefcase fa-2x"></i><br /> <?php
    echo lang_key("work");
?> 
<?php
    $querygt = mysqli_query($connect, "SELECT `job_type` FROM `jobs`");
    while ($rowgt = mysqli_fetch_assoc($querygt)) {
        $type = $rowgt['job_type'];
        
        $querypas = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type = '$type' AND player_id='$player_id' LIMIT 1");
        $countpas = mysqli_num_rows($querypas);
        $rowpas   = mysqli_fetch_assoc($querypas);
        
        if ($countpas > 0) {
            if (time() >= $rowpas['finishtime']) {
                echo '<span class="badge"><i class="fa fa-check"></i></span>';
            } else {
                echo '<span class="badge"><i class="fas fa-clock"></i></span>';
            }
        }
    }
?>
</a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'gym.php') {
        echo 'class="active"';
    }
?>><a href="gym.php"><i class="fa fa-male fa-2x"></i><br /> <?php
    echo lang_key("gym");
?> 
<?php
    $querygt = mysqli_query($connect, "SELECT `workout_type` FROM `gym`");
    while ($rowgt = mysqli_fetch_assoc($querygt)) {
        $type = $rowgt['workout_type'];
        
        $querypas = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type = '$type' AND player_id='$player_id' LIMIT 1");
        $countpas = mysqli_num_rows($querypas);
        $rowpas   = mysqli_fetch_assoc($querypas);
        
        if ($countpas > 0) {
            if (time() >= $rowpas['finishtime']) {
                echo '<span class="badge"><i class="fa fa-check"></i></span>';
            } else {
                echo '<span class="badge"><i class="fas fa-clock"></i></span>';
            }
        }
    }
?>
</a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'school.php') {
        echo 'class="active"';
    }
?>><a href="school.php"><i class="fa fa-graduation-cap fa-2x"></i><br /> <?php
    echo lang_key("school");
?> 
<?php
    $querygt = mysqli_query($connect, "SELECT `subject` FROM `school`");
    while ($rowgt = mysqli_fetch_assoc($querygt)) {
        $type = $rowgt['subject'];
        
        $querypas = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type = '$type' AND player_id='$player_id' LIMIT 1");
        $countpas = mysqli_num_rows($querypas);
        $rowpas   = mysqli_fetch_assoc($querypas);
        
        if ($countpas > 0) {
            if (time() >= $rowpas['finishtime']) {
                echo '<span class="badge"><i class="fa fa-check"></i></span>';
            } else {
                echo '<span class="badge"><i class="fas fa-clock"></i></span>';
            }
        }
    }
?>
</a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bank.php') {
        echo 'class="active"';
    }
?>><a href="bank.php"><i class="fa fa-university fa-2x"></i><br /> <?php
    echo lang_key("bank");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'hospital.php') {
        echo 'class="active"';
    }
?>><a href="hospital.php"><i class="fa fa-hospital fa-2x"></i><br /> <?php
    echo lang_key("hospital");
?> 
<?php
    $querygt = mysqli_query($connect, "SELECT `treatment_type` FROM `hospital`");
    while ($rowgt = mysqli_fetch_assoc($querygt)) {
        $type = $rowgt['treatment_type'];
        
        $querypas = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type = '$type' AND player_id='$player_id' LIMIT 1");
        $countpas = mysqli_num_rows($querypas);
        $rowpas   = mysqli_fetch_assoc($querypas);
        
        if ($countpas > 0) {
            if (time() >= $rowpas['finishtime']) {
                echo '<span class="badge"><i class="fa fa-check"></i></span>';
            } else {
                echo '<span class="badge"><i class="fas fa-clock"></i></span>';
            }
        }
    }
?>
</a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'street-races.php') {
        echo 'class="active"';
    }
?>><a href="races.php"><i class="fa fa-flag-checkered fa-2x"></i><br /> <?php
    echo lang_key("street-races");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'fight-arena.php') {
        echo 'class="active"';
    }
?>><a href="fight-arena.php"><i class="fa fa-crosshairs fa-2x"></i><br /> <?php
    echo lang_key("fights");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'leaderboard.php') {
        echo 'class="active"';
    }
?>><a href="leaderboard.php"><i class="fa fa-trophy fa-2x"></i><br /> <?php
    echo lang_key("leaderboard");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'casino.php') {
        echo 'class="active"';
    }
?>><a href="casino.php"><i class="fa fa-gem fa-2x"></i><br /> <?php
    echo lang_key("casino");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'resources.php') {
        echo 'class="active"';
    }
?>><a href="resources.php"><i class="fa fa-dollar-sign fa-2x"></i><br /> <?php
    echo lang_key("resources");
?></a></li>
                    </ul> 
                </div>
            </div>
        </nav>
    </center>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-3 user-stats">
                <div class="well">
                    <h4><i class="fa fa-user"></i> <?php
    echo $rowu['username'];
?> 
<?php
    if ($rowu['role'] == "Admin") {
        echo '<span class="label label-danger"><i class="fa fa-bookmark"></i> ' . $rowu['role'] . '</span> ';
    }
    
    if ($rowu['role'] == "VIP") {
        echo '<span class="label label-warning"><i class="fa fa-star"></i> ' . $rowu['role'] . '</span> ';
    }
?>
                    </h4>
                    <hr />
                    <div class="row">
                        <div class="col-md-5">
                            <center><img src="<?php
    echo $rowu['avatar'];
?>" width="100%" /></center>
                        </div>
                        <div class="col-md-7" id="playerstats">
                            <div id="stats">
<h5><strong><i class="far fa-money-bill-alt"></i> <?php
    echo lang_key("money");
?>: </strong><span class="label label-success"><?php
    echo $rowu['money'];
?></span></h5>
                            <h5><strong><i class="fa fa-inbox"></i> <?php
    echo lang_key("gold");
?>: </strong><span class="label label-warning"><?php
    echo $rowu['gold'];
?></span></h5>
                            <h5><strong><i class="fa fa-server"></i> <?php
    echo lang_key("level");
?>: </strong><span class="label label-default"><?php
    echo $rowu['level'];
?></span></h5>
                            <h5><strong><i class="fa fa-star"></i> <?php
    echo lang_key("respect");
?>: </strong><span class="label label-primary"><?php
    echo $rowu['respect'];
?></span></h5>
<?php
    $userid  = $rowu['id'];
    $queryum = mysqli_query($connect, "SELECT * FROM `messages` WHERE toid='$rowu[id]' AND viewed='No'");
    $countum = mysqli_num_rows($queryum);
?>
                            <h5><strong><i class="fa fa-envelope"></i> <?php
    echo lang_key("messages");
?>: </strong><a href="messages.php"><?php
    echo $countum;
?></a></h5>
</div>
                        </div>
                    </div>
                    <hr />
                    <h5>
                    <a href="settings.php" class="btn btn-primary pull-left"><i class="fa fa-user"></i> <span class="hidden-xs"><?php
    echo lang_key("my-account");
?></span></a>&nbsp;
                    <a href="messages.php" class="btn btn-success"><i class="fa fa-envelope"></i> <span class="hidden-xs"><?php
    echo lang_key("messages");
?></span></a>
<?php
    if ($rowu['role'] == 'Admin') {
?>
                    <a href="admin" class="btn btn-info"><i class="fa fa-cogs"></i> <span class="hidden-xs"><?php
        echo lang_key("admin-panel");
?></span></a>
<?php
    }
?>
                    <a href="logout.php" class="btn btn-danger pull-right"><i class="fa fa-sign-out-alt"></i> <span class="hidden-xs"><?php
    echo lang_key("logout");
?></span></a>
                    <div class="clearfix"></div>
                </h5>
                </div>
            </div>

            <div class="col-md-6 text-center page-header">
                <h1 class="game-name">
                <i class="fa fa-building"></i> <i class="fa fa-car"></i> <i class="fa fa-users"></i> <?php
    echo $row['title'];
?>
                <small><br /><?php
    echo $row['description'];
?></small>
                </h1>
                <hr />
                <div class="row" id="playerstats2">
                    <div id="stats2">
                    <div class="col-md-6">
                        <h5><i class="fa fa-heart"></i> <?php
    echo lang_key("health");
?></h5>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-success" style="width: <?php
    echo $rowu['health'];
?>%;">
                                <span><?php
    echo $rowu['health'];
?> / 100</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5><i class="fa fa-bolt"></i> <?php
    echo lang_key("energy");
?></h5>
                        <div class="progress progress-striped active">
                            <div class="progress-bar" style="width: <?php
    echo $rowu['energy'];
?>%;">
                                <span><?php
    echo $rowu['energy'];
?> / 100</span>
                            </div>
                        </div>
                    </div>
</div>
                </div>
            </div>

            <div class="col-md-3 user-stats">
                <div class="well" id="playerskills">
                    <div id="skills">
                <h5><i class="fa fa-child"></i> <?php
    echo lang_key("power");
?></h5>
                <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-warning" style="width: <?php
    echo percent($rowu['power'], 250);
?>%;">
                        <span><?php
    echo $rowu['power'];
?> / 250</span>
                    </div>
                </div>
                <h5><i class="fa fa-retweet"></i> <?php
    echo lang_key("agility");
?></h5>
                <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-danger" style="width: <?php
    echo percent($rowu['agility'], 250);
?>%;">
                        <span><?php
    echo $rowu['agility'];
?> / 250</span>
                    </div>
                </div>
                <h5><i class="fa fa-heartbeat"></i> <?php
    echo lang_key("endurance");
?></h5>
                <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-success" style="width: <?php
    echo percent($rowu['endurance'], 250);
?>%;">
                        <span><?php
    echo $rowu['endurance'];
?> / 250</span>
                    </div>
                </div>
                <h5><i class="fab fa-usb"></i> <?php
    echo lang_key("intelligence");
?></h5>
                <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-info" style="width: <?php
    echo percent($rowu['intelligence'], 250);
?>%;">
                        <span><?php
    echo $rowu['intelligence'];
?> / 250</span>
                    </div>
                </div>
</div>
                </div>
            </div>
        </div>
        
    <div class="container-fluid">
        <div class="row well">
            <div class="col-md-1">
                <h4><span class="label label-danger"><i class="fa fa-info-circle"></i> <?php
    echo lang_key("useful-tips");
?>: </span></h4>
            </div>
            <div class="col-md-8">
                <marquee behavior="scroll" direction="left" scrollamount="12">
                    <h4>
<?php
    $querygt = mysqli_query($connect, "SELECT * FROM `tips` ORDER BY rand()");
    while ($rowgt = mysqli_fetch_assoc($querygt)) {
        echo $rowgt['tip'];
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    }
?>
                    </h4>
                </marquee>
            </div>
<?php
    $timeon  = time() - 60;
    $queryop = mysqli_query($connect, "SELECT * FROM `players` WHERE timeonline>$timeon");
    $countop = mysqli_num_rows($queryop);
?>
            <div class="col-md-2" id="onlineplayers">
                <div id="online">
                    <a href="leaderboard.php?tab=onlineplayers" class="btn btn-success btn-block pull-right"><i class="fa fa-users"></i> <?php
    echo lang_key("online-players");
?> &nbsp;&nbsp;<span class="badge badge-primary"><?php
    echo $countop;
?></span></a>
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-primary btn-block pull-right" data-toggle="sidebar" data-target=".sidebar-right"><i class="fa fa-comments"></i> <?php
    echo lang_key("chat");
?></button>
            </div>
        </div>
    </div>

    <div class="col-md-2 sidebar sidebar-right sidebar-animate">
        <div class="row">
            <div class="col-md-10">
                <h2><i class="fa fa-comments"></i> <?php
    echo lang_key("chat");
?> </h2>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger pull-right" data-toggle="sidebar" data-target=".sidebar-right"><i class="fa fa-times"></i></button>&nbsp;
            </div>
        </div>
        <hr /><br />
        
        <form id="gchat" action="ajax.php" method="post">
            <textarea placeholder="Write a message" name="chatmessage" class="form-control" required></textarea>
            <br /><button type="submit" name="post_chatmessage" class="btn btn-primary btn-md btn-block pull-right"><i class="fa fa-paper-plane"></i>&nbsp; <?php
    echo lang_key("send");
?></button>
        </form><br /><br /><br />
        
<script type="text/javascript">
    var frm = $('#gchat');
    frm.submit(function (ev) {
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                document.getElementById("gchat").reset();
            }
        });

        ev.preventDefault();
    });
</script>

<div id="globalchat">
<div id="chat">
<?php
    $gtday   = date("d");
    $gtmonth = date("n");
    $gtyear  = date("Y");
    
    $gthour   = date("H");
    $gtminute = date("i");
    
    $querygc = mysqli_query($connect, "SELECT * FROM `global_chat` ORDER BY id DESC LIMIT 15");
    while ($rowgc = mysqli_fetch_assoc($querygc)) {
        $author_id = $rowgc['player_id'];
        $querygcp  = mysqli_query($connect, "SELECT * FROM `players` WHERE id='$author_id' LIMIT 1");
        $rowgcp    = mysqli_fetch_assoc($querygcp);
?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <img src="<?php
        echo $rowgcp['avatar'];
?>" width="8%">&nbsp;&nbsp;<strong><a href="player?id=<?php
        echo $author_id;
?>"><?php
        echo $rowgcp['username'];
?></a></strong>
            </div>
            <div class="panel-body"><?php
        echo emoticons($rowgc['message']);
?></div>
            <div class="panel-footer">
                <i class="fas fa-clock"></i> 
<?php
        $mgetdate = date_parse_from_format("d F Y", $rowgc['date']);
        $mgettime = date_parse_from_format("H:i", $rowgc['time']);
        $mday     = $mgetdate["day"];
        $mmonth   = $mgetdate["month"];
        $myear    = $mgetdate["year"];
        $mhour    = $mgettime["hour"];
        $mminute  = $mgettime["minute"];
        
        if ($myear != $gtyear) {
            $d_year = $gtyear - $myear;
            if ($d_year == 1) {
                $gsymbol = '';
            } else {
                $gsymbol = 's';
            }
            echo '' . $d_year . ' year' . $gsymbol . ' ago';
        } else {
            if ($mmonth != $gtmonth) {
                $d_month = $gtmonth - $mmonth;
                if ($d_month == 1) {
                    $gsymbol = '';
                } else {
                    $gsymbol = 's';
                }
                echo '' . $d_month . ' month' . $gsymbol . ' ago';
            } else {
                if ($mday != $gtday) {
                    $d_day = $gtday - $mday;
                    if ($d_day == 1) {
                        $gsymbol = '';
                    } else {
                        $gsymbol = 's';
                    }
                    echo '' . $d_day . ' day' . $gsymbol . ' ago';
                } else {
                    if ($mhour != $gthour) {
                        $d_hour = $gthour - $mhour;
                        if ($d_hour == 1) {
                            $gsymbol = '';
                        } else {
                            $gsymbol = 's';
                        }
                        echo '' . $d_hour . ' hour' . $gsymbol . ' ago';
                    } else {
                        if ($mminute != $gtminute) {
                            $d_minute = $gtminute - $mminute;
                            if ($d_minute == 1) {
                                $gsymbol = '';
                            } else {
                                $gsymbol = 's';
                            }
                            echo '' . $d_minute . ' minute' . $gsymbol . ' ago';
                        } else {
                            echo 'Just Now';
                        }
                    }
                }
            }
        }
        
?>
            </div>
        </div>
<?php
    }
?> 
</div>
</div>

    </div>
<?php
}

function footer()
{
    require "config.php";
    
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $rowu  = mysqli_fetch_assoc($suser);
    
    @include 'languages/' . $rowu['language'] . '.php';
    
    $query = mysqli_query($connect, "SELECT * FROM `settings` WHERE id='1'");
    $row   = mysqli_fetch_assoc($query);
    
    $querytd = mysqli_query($connect, "SELECT * FROM `themes` WHERE default_theme='Yes'");
    $rowtd   = mysqli_fetch_assoc($querytd);
    
    $queryld = mysqli_query($connect, "SELECT * FROM `languages` WHERE default_language='Yes'");
    $rowld   = mysqli_fetch_assoc($queryld);
?>
    </div>
    <!-- /container -->

    <footer class="footer clearfix">
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

    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <!-- Right Sidebar - Chat -->
    <script src="assets/js/sidebar.js"></script>
    
    <!-- Game JS -->
    <script src="assets/js/game.js"></script>
	
<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'leaderboard.php' OR basename($_SERVER['SCRIPT_NAME']) == 'messages.php') {
        echo '
	<!-- DataTables -->
    <script src="assets/js/datatables.min.js"></script>';
    }
?>

<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'messages.php') {
        echo '
	<!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>';
    }
?>

</body>
</html>
<?php
}
?>