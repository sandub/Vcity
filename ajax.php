<?php
require "config.php";

$_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

function percent($num_amount, $num_total)
{
    @$count1 = $num_amount / $num_total;
    $count2 = $count1 * 100;
    $count  = number_format($count2, 0);
    return $count;
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

if (isset($_SESSION['username'])) {
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $rowu  = mysqli_fetch_assoc($suser);
    $count = mysqli_num_rows($suser);
    if ($count <= 0) {
        exit;
    }
    
    include 'languages/' . $rowu['language'] . '.php';
    
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
?>

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
?>: </strong><a href="messages"><?php
    echo $countum;
?></a></h5>
</div>

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

<?php
    $timeon  = time() - 60;
    $queryop = mysqli_query($connect, "SELECT * FROM `players` WHERE timeonline>$timeon");
    $countop = mysqli_num_rows($queryop);
?>

                <div id="online">
                    <a href="leaderboard.php?tab=onlineplayers" class="btn btn-success btn-block pull-right"><i class="fa fa-users"></i> <?php
    echo lang_key("online-players");
?> &nbsp;&nbsp;<span class="badge badge-primary"><?php
    echo $countop;
?></span></a>
                </div>

<?php
    
    //Global Chat - Message Insert
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $chat_message = $_POST['chatmessage'];
        $player_id    = $rowu['id'];
        $date         = date('d F Y');
        $time         = date('H:i');
        
        $querygcm = mysqli_query($connect, "SELECT * FROM `global_chat` WHERE player_id='$player_id' AND message='$chat_message' AND date='$date' LIMIT 1");
        $countgcm = mysqli_num_rows($querygcm);
        if ($countgcm == 0 && $chat_message != "") {
            $post_gcmessage = mysqli_query($connect, "INSERT INTO `global_chat` (player_id, message, date, time) VALUES ('$player_id', '$chat_message', '$date', '$time')");
        }
    }
    
    //Get Prize
    if (isset($_POST['prize'])) {
        
        $player_id = $rowu['id'];
        $fullprize = $_POST['prize'];
        $sprize    = explode(" ", $fullprize);
        $prize     = $sprize[1];
        $value     = $sprize[0];
        
        $querycpc = mysqli_query($connect, "SELECT * FROM `casino_prizes` WHERE prizetype='$prize' AND value='$value' LIMIT 1");
        $countcpc = mysqli_num_rows($querycpc);
        
        if ($countcpc > 0) {
            $rowcpc = mysqli_fetch_assoc($querycpc);
            
            if ($prize == "Money") {
                $player_update = mysqli_query($connect, "UPDATE `players` SET money=money+'$value', spins=spins-1 WHERE id='$player_id'");
            }
            if ($prize == "Gold") {
                $player_update = mysqli_query($connect, "UPDATE `players` SET gold=gold+'$value', spins=spins-1 WHERE id='$player_id'");
            }
            if ($prize == "Respect") {
                $player_update = mysqli_query($connect, "UPDATE `players` SET respect=respect+'$value', spins=spins-1 WHERE id='$player_id'");
            }
            if ($prize == "Energy") {
                $player_update = mysqli_query($connect, "UPDATE `players` SET energy=energy+'$value', spins=spins-1 WHERE id='$player_id'");
            }
            if ($prize == "Health") {
                $player_update = mysqli_query($connect, "UPDATE `players` SET health=health+'$value', spins=spins-1 WHERE id='$player_id'");
            }
        }
        
    }
    
}
?>