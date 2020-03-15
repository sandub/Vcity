<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['job-id'])) {
    
    $job_id = (int) $_GET['job-id'];
    
    $queryjs = mysqli_query($connect, "SELECT * FROM `jobs` WHERE id = '$job_id' LIMIT 1");
    $countjs = mysqli_num_rows($queryjs);
    if ($countjs > 0) {
        $rowjs = mysqli_fetch_assoc($queryjs);
        
        $queryauc = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE player_id='$player_id' LIMIT 1");
        $countauc = mysqli_num_rows($queryauc);
        if ($countauc > 0) {
            $busy = 'Yes';
        } else {
            $busy = 'No';
        }
        
        $type        = $rowjs['job_type'];
        $energy_cost = $rowjs['energy_cost'];
        $health_loss = $rowjs['health_loss'];
        
        if ($rowjs['format'] == "Hours") {
            $finishtime = time() + ($rowjs['time'] * 3600);
        }
        if ($rowjs['format'] == "Minutes") {
            $finishtime = time() + ($rowjs['time'] * 60);
        }
        
        if ($rowu['energy'] >= $energy_cost && $rowu['health'] >= $health_loss && $busy == 'No') {
            
            $job_start     = mysqli_query($connect, "INSERT INTO `player_actions` (player_id, type, finishtime)
VALUES ('$player_id', '$type', '$finishtime')");
            $player_update = mysqli_query($connect, "UPDATE `players` SET energy=energy-'$energy_cost', health=health-'$health_loss' WHERE id='$player_id'");
            
        }
    }
}

if (isset($_GET['leave-work'])) {
    $jobl_id = (int) $_GET["leave-work"];
    
    $queryjs = mysqli_query($connect, "SELECT * FROM `jobs` WHERE id='$jobl_id' LIMIT 1");
    $countjs = mysqli_num_rows($queryjs);
    
    if ($countjs > 0) {
        $rowjs = mysqli_fetch_assoc($queryjs);
        
        $type        = $rowjs['job_type'];
        $energy_cost = $rowjs['energy_cost'] / 2;
        $health_loss = $rowjs['health_loss'] / 2;
        
        $querypjs = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type='$type' AND player_id='$player_id' LIMIT 1");
        $countpjs = mysqli_num_rows($querypjs);
        
        if ($countpjs > 0) {
            $leave_work    = mysqli_query($connect, "DELETE FROM `player_actions` WHERE type='$type' AND player_id='$player_id'");
            $player_update = mysqli_query($connect, "UPDATE `players` SET energy=energy+'$energy_cost', health=health+'$health_loss' WHERE id='$player_id'");
        }
    }
}

if (isset($_GET['finish-work'])) {
    
    $job_id = (int) $_GET['finish-work'];
    
    $queryjs = mysqli_query($connect, "SELECT * FROM `jobs` WHERE id = '$job_id' LIMIT 1");
    $countjs = mysqli_num_rows($queryjs);
    if ($countjs > 0) {
        $rowjs = mysqli_fetch_assoc($queryjs);
        
        $type = $rowjs['job_type'];
        
        $querypjs = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type = '$type' AND player_id='$player_id' LIMIT 1");
        $countpjs = mysqli_num_rows($querypjs);
        $rowpjs   = mysqli_fetch_assoc($querypjs);
        if ($countpjs > 0) {
            $correct = 'Yes';
        } else {
            $correct = 'No';
        }
        
        $money = $rowjs['money'];
        $gold  = $rowjs['gold'];
        
        if ($correct == 'Yes' && time() >= $rowpjs['finishtime']) {
            
            $leave_work = mysqli_query($connect, "DELETE FROM `player_actions` WHERE type='$type' AND player_id='$player_id'");
            $get_salary = mysqli_query($connect, "UPDATE `players` SET money=money+'$money', gold=gold+'$gold' WHERE id='$player_id'");
            
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#get-salary").modal(\'show\');
            });
        </script>

        <div id="get-salary" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("wday-end") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-info">' . lang_key("work-finish") . '</span></h3><br /><br /><br />
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="images/icons/money.png" width="20%"><br />
                                    <h4>' . lang_key("money") . ': <br /><hr /><span class="label label-default">+ ' . $money . '</span></h4>
                                </div>
                                <div class="col-md-6">
                                    <img src="images/icons/gold1.png" width="20%"><br />
                                    <h4>' . lang_key("gold") . ': <br /><hr /><span class="label label-default">+ ' . $gold . '</span></h4>
                                </div>
                            </div><br /><br />
                            <button type="button" class="btn btn-success btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fab fa-get-pocket"></i> ' . lang_key("claim") . '</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
            
        }
        
    }
}
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-briefcase"></i> <?php
echo lang_key("work");
?></h3>
    </div>
    <div class="panel-body">
        <center><h2><i class="fa fa-list-ul"></i> <?php
echo lang_key("jobs");
?></h2></center><br />

        <div class="row">
<?php
$queryj = mysqli_query($connect, "SELECT * FROM `jobs` ORDER BY money ASC");
while ($rowj = mysqli_fetch_assoc($queryj)) {
    
    $job_id   = $rowj['id'];
    $querypac = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE player_id='$player_id' LIMIT 1");
    $rowpac   = mysqli_fetch_assoc($querypac);
    $countpac = mysqli_num_rows($querypac);
?>
            <div class="col-md-6">
                <div class="jumbotron">
                    <center>
                        <h2><i class="fa fa-briefcase"></i> <?php
    echo $rowj['job_type'];
?></h2>
                        <hr />
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <h4><i class="fa fa-bolt"></i> <?php
    echo lang_key("energy-cost");
?>: <span class="label label-primary"><?php
    echo $rowj['energy_cost'];
?></span></h4>
                            </div>
                            <div class="col-md-5">
                                <h4><i class="fa fa-heartbeat"></i> <?php
    echo lang_key("health-loss");
?>: <span class="label label-danger"><?php
    echo $rowj['health_loss'];
?></span></h4>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <br />
                    </center>

                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span class="badge badge-danger"><?php
    echo $rowj['time'];
?> <?php
    echo $rowj['format'];
?></span>
                                    <i class="fas fa-clock"></i>&nbsp;&nbsp; <?php
    echo lang_key("work-time");
?>
                                </li>
                                <li class="list-group-item">
                                    <span class="badge badge-success">+ <?php
    echo $rowj['money'];
?></span>
                                    <i class="fa fa-dollar-sign"></i>&nbsp;&nbsp; <?php
    echo lang_key("salary");
?>
                                </li>
                                <li class="list-group-item">
                                    <span class="badge badge-warning">+ <?php
    echo $rowj['gold'];
?></span>
                                    <i class="fa fa-plus-circle"></i>&nbsp;&nbsp; <?php
    echo lang_key("gold");
?> <?php
    echo lang_key("reward");
?>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-2"></div>
                    </div>

                    <center>
                        <br /><hr />
<?php
    if ($countpac > 0 && $rowpac['type'] == $rowj['job_type'] && time() >= $rowpac['finishtime']) {
        echo '<a href="?finish-work=' . $rowj['id'] . '" class="btn btn-success btn-md btn-block"><i class="far fa-money-bill-alt"></i>&nbsp; ' . lang_key("get-salary") . '</a>';
    } else if ($countpac > 0 && $rowpac['type'] == $rowj['job_type'] && time() < $rowpac['finishtime']) {
        $timeleft = secondsToWords($rowpac['finishtime'] - time());
        
        echo '<div class="row"><div class="col-md-6"><button class="btn btn-warning btn-md btn-block disabled"><em class="fas fa-fw fa-clock"></em> ' . $timeleft . '</button></div><div class="col-md-6"><a href="?leave-work=' . $rowj['id'] . '" class="btn btn-info btn-md btn-block"><i class="fa fa-sign-out-alt"></i>&nbsp; ' . lang_key("leave-work") . '</a></div></div>';
    } else if ($rowu['energy'] < $rowj['energy_cost'] || $rowu['health'] < $rowj['health_loss'] || $countpac > 0) {
        echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-cogs"></em> ' . lang_key("start-work") . '</button>';
    } else {
        echo '<a href="?job-id=' . $rowj['id'] . '" class="btn btn-info btn-md btn-block"><i class="fa fa-cogs"></i>&nbsp; ' . lang_key("start-work") . '</a>';
    }
?>               
                    </center>
                </div>
            </div>
<?php
}
?>
        </div>

    </div>
</div>
<?php
footer();
?>