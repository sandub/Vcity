<?php
//Fill this information
$host     = "localhost"; // Database Host
$user     = ""; // Database Username
$password = ""; // Database's user Password
$database = ""; // Database Name

//------------------------------------------------------------

$connect = mysqli_connect($host, $user, $password, $database);

// Checking Connection
if (mysqli_connect_errno()) {
    echo "Failed to connect with MySQL: " . mysqli_connect_error();
}

mysqli_set_charset($connect, "utf8");

@session_start();

if (isset($_SESSION['username'])) {
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $count = mysqli_num_rows($suser);
    if ($count > 0) {
        //Set Online
        $prow    = mysqli_fetch_assoc($suser);
        $timenow = time();
        $update  = mysqli_query($connect, "UPDATE `players` SET timeonline='$timenow' WHERE username='$uname'");
        
        //Level Up
        $playerrespect = $prow['respect'];
        $playerlevel   = $prow['level'];
        $querylv       = mysqli_query($connect, "SELECT * FROM `levels` WHERE level='$playerlevel'");
        $lvrow         = mysqli_fetch_assoc($querylv);
        $minrespect    = $lvrow['min_respect'];
        $queryblv      = mysqli_query($connect, "SELECT * FROM levels WHERE level='$playerlevel'+1");
        $rowblv        = mysqli_fetch_assoc($queryblv);
        $blevel        = $rowblv['level'];
        $bminrespect   = $rowblv['min_respect'];
        
        if ($playerrespect > $bminrespect OR $playerrespect == $bminrespect) {
            $update = mysqli_query($connect, "UPDATE `players` SET level='$blevel', energy='100', money=money+'1000', gold=gold+'2' WHERE username='$uname'");
        }
        if ($playerrespect < $minrespect) {
            $update = mysqli_query($connect, "UPDATE `players` SET level=level-1 WHERE username='$uname'");
        }
        
        if ($prow['money'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET money=0 WHERE username='$uname'");
        }
        
        if ($prow['gold'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET gold=0 WHERE username='$uname'");
        }
        
        if ($prow['energy'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET energy=0 WHERE username='$uname'");
        }
        
        if ($prow['energy'] > 100) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET energy=100 WHERE username='$uname'");
        }
        
        if ($prow['health'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET health=0 WHERE username='$uname'");
        }
        
        if ($prow['health'] > 100) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET health=100 WHERE username='$uname'");
        }
        
        if ($prow['respect'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET respect=0 WHERE username='$uname'");
        }
        
        if ($prow['bank'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET bank=0 WHERE username='$uname'");
        }
        
        if ($prow['power'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET power=0 WHERE username='$uname'");
        }
        
        if ($prow['power'] > 250) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET power=250 WHERE username='$uname'");
        }
        
        if ($prow['agility'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET agility=0 WHERE username='$uname'");
        }
        
        if ($prow['agility'] > 250) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET agility=250 WHERE username='$uname'");
        }
        
        if ($prow['endurance'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET endurance=0 WHERE username='$uname'");
        }
        
        if ($prow['endurance'] > 250) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET endurance=250 WHERE username='$uname'");
        }
        
        if ($prow['intelligence'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET intelligence=0 WHERE username='$uname'");
        }
        
        if ($prow['intelligence'] > 250) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET intelligence=250 WHERE username='$uname'");
        }
    }
}
?>