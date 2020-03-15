<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['start-workout'])) {
    
    $workout_id = (int) $_GET['start-workout'];
    
    $queryws = mysqli_query($connect, "SELECT * FROM `gym` WHERE id = '$workout_id' LIMIT 1");
    $countws = mysqli_num_rows($queryws);
    if ($countws > 0) {
        $rowws = mysqli_fetch_assoc($queryws);
        
        $queryauc = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE player_id='$player_id' LIMIT 1");
        $countauc = mysqli_num_rows($queryauc);
        if ($countauc > 0) {
            $busy = 'Yes';
        } else {
            $busy = 'No';
        }
        
        $type        = $rowws['workout_type'];
        $energy_cost = $rowws['energy_cost'];
        $fee         = $rowws['fee'];
        
        if ($rowws['format'] == "Hours") {
            $finishtime = time() + ($rowws['time'] * 3600);
        }
        if ($rowws['format'] == "Minutes") {
            $finishtime = time() + ($rowws['time'] * 60);
        }
        
        if ($rowu['energy'] >= $energy_cost && $rowu['money'] >= $fee && $busy == 'No') {
            
            $workout_start = mysqli_query($connect, "INSERT INTO `player_actions` (player_id, type, finishtime)
VALUES ('$player_id', '$type', '$finishtime')");
            $player_update = mysqli_query($connect, "UPDATE `players` SET energy=energy-'$energy_cost', money=money-'$fee' WHERE id='$player_id'");
            
        }
    }
}

if (isset($_GET['interrupt-training'])) {
    $workout_id = (int) $_GET["interrupt-training"];
    
    $queryws = mysqli_query($connect, "SELECT * FROM `gym` WHERE id='$workout_id' LIMIT 1");
    $countws = mysqli_num_rows($queryws);
    
    if ($countws > 0) {
        $rowws = mysqli_fetch_assoc($queryws);
        
        $type        = $rowws['workout_type'];
        $energy_cost = $rowws['energy_cost'] / 2;
        $fee         = $rowws['fee'] / 2;
        
        $querypws = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type='$type' AND player_id='$player_id' LIMIT 1");
        $countpws = mysqli_num_rows($querypws);
        
        if ($countpws > 0) {
            $interrupt_workout = mysqli_query($connect, "DELETE FROM `player_actions` WHERE type='$type' AND player_id='$player_id'");
            $player_update     = mysqli_query($connect, "UPDATE `players` SET energy=energy+'$energy_cost', money=money+'$fee' WHERE id='$player_id'");
        }
    }
}

if (isset($_GET['finish-workout'])) {
    
    $workout_id = (int) $_GET['finish-workout'];
    
    $queryws = mysqli_query($connect, "SELECT * FROM `gym` WHERE id = '$workout_id' LIMIT 1");
    $countws = mysqli_num_rows($queryws);
    if ($countws > 0) {
        $rowws = mysqli_fetch_assoc($queryws);
        
        $type = $rowws['workout_type'];
        
        $querypws = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type = '$type' AND player_id='$player_id' LIMIT 1");
        $countpws = mysqli_num_rows($querypws);
        $rowpws   = mysqli_fetch_assoc($querypws);
        if ($countpws > 0) {
            $correct = 'Yes';
        } else {
            $correct = 'No';
        }
        
        $health_restore = $rowws['health_restore'];
        $power          = $rowws['power'];
        $agility        = $rowws['agility'];
        $endurance      = $rowws['endurance'];
        
        if ($correct == 'Yes' && time() >= $rowpws['finishtime']) {
            
            $training_finish = mysqli_query($connect, "DELETE FROM `player_actions` WHERE type='$type' AND player_id='$player_id'");
            $finish_training = mysqli_query($connect, "UPDATE `players` SET health=health+'$health_restore', power=power+'$power', agility=agility+'$agility', endurance=endurance+'$endurance' WHERE id='$player_id'");
            
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#finish-workout").modal(\'show\');
            });
        </script>

        <div id="finish-workout" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("end-workout") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-info">' . lang_key("finish-workout") . '</span></h3><br /><br /><br />
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="images/icons/health.png" width="15%"><br />
                                    <h4>' . lang_key("health") . ': <br /><hr /><span class="label label-default">+ ' . $health_restore . '</span></h4>
                                </div>
                            </div><br /><br />
                            <div class="row">
                                <div class="col-md-4">
                                    <h4>' . lang_key("power") . ': <br /><hr /><span class="label label-default">+ ' . $power . '</span></h4>
                                </div>
                                <div class="col-md-4">
                                    <h4>' . lang_key("agility") . ': <br /><hr /><span class="label label-default">+ ' . $agility . '</span></h4>
                                </div>
                                <div class="col-md-4">
                                    <h4>' . lang_key("endurance") . ': <br /><hr /><span class="label label-default">+ ' . $endurance . '</span></h4>
                                </div>
                            </div><br /><br />
                            <button type="button" class="btn btn-success btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fab fa-get-pocket"></i> ' . lang_key("okay") . '</button>
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
        <h3 class="panel-title"><i class="fa fa-male"></i> <?php
echo lang_key("gym");
?></h3>
    </div>
    <div class="panel-body">
        
        <center><h2><i class="fa fa-male"></i> <?php
echo lang_key("gym");
?></h2></center><br />

<?php
$queryg = mysqli_query($connect, "SELECT * FROM `gym` ORDER BY power ASC");
while ($rowg = mysqli_fetch_assoc($queryg)) {
    
    $workout_id = $rowg['id'];
    $querypac   = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE player_id='$player_id' LIMIT 1");
    $rowpac     = mysqli_fetch_assoc($querypac);
    $countpac   = mysqli_num_rows($querypac);
?>
    <div class="col-md-12 jumbotron">
        <center><h3>
            <span class="fa-stack fa-md"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-male fa-stack-1x fa-inverse"></i></span>
            <?php
    echo $rowg['workout_type'];
?></h3></center><hr /><br />
        
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group"><br />
                    <li class="list-group-item">
                        <span class="badge badge-danger"><?php
    echo $rowg['time'];
?> <?php
    echo $rowg['format'];
?></span>
                        <i class="fas fa-clock"></i>&nbsp;&nbsp; <?php
    echo lang_key("training-duration");
?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge badge-warning"><i class="fa fa-dollar-sign"></i> <?php
    echo $rowg['fee'];
?></span>
                        <i class="fa fa-credit-card"></i>&nbsp;&nbsp; <?php
    echo lang_key("fitness-fee");
?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge badge-primary"><?php
    echo $rowg['energy_cost'];
?></span>
                        <i class="fa fa-bolt"></i>&nbsp;&nbsp; <?php
    echo lang_key("energy-cost");
?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge badge-success">+ <?php
    echo $rowg['health_restore'];
?></span>
                        <i class="fa fa-heartbeat"></i>&nbsp;&nbsp; <?php
    echo lang_key("health-restore");
?>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5><i class="fa fa-child"></i> <?php
    echo lang_key("power");
?> &nbsp;&nbsp; [+ <?php
    echo $rowg['power'];
?>]</h5>
                <div class="progress">
                    <div class="progress-bar progress-bar-warning" style="width: <?php
    echo percent($rowu['power'], 250);
?>%;">
                        <span><?php
    echo $rowu['power'];
?> / 250</span>
                    </div><div class="progress-bar progress-bar-info" style="width: <?php
    echo percent($rowg['power'] + 1, 250);
?>%;"></div>
                </div>
                <h5><i class="fa fa-retweet"></i> <?php
    echo lang_key("agility");
?> &nbsp;&nbsp; [+ <?php
    echo $rowg['agility'];
?>]</h5>
                <div class="progress">
                    <div class="progress-bar progress-bar-danger" style="width: <?php
    echo percent($rowu['agility'], 250);
?>%;">
                        <span><?php
    echo $rowu['agility'];
?> / 250</span>
                    </div><div class="progress-bar progress-bar-info" style="width: <?php
    echo percent($rowg['agility'] + 1, 250);
?>%;"></div>
                </div>
                <h5><i class="fa fa-heartbeat"></i> <?php
    echo lang_key("endurance");
?> &nbsp;&nbsp; [+ <?php
    echo $rowg['endurance'];
?>]</h5>
                <div class="progress">
                    <div class="progress-bar progress-bar-success" style="width: <?php
    echo percent($rowu['endurance'], 250);
?>%;">
                        <span><?php
    echo $rowu['endurance'];
?> / 250</span>
                    </div>
                    <div class="progress-bar progress-bar-info" style="width: <?php
    echo percent($rowg['endurance'] + 1, 250);
?>%;"></div>
                </div>
            </div>
        </div><br />
<?php
    if ($countpac > 0 && $rowpac['type'] == $rowg['workout_type'] && time() >= $rowpac['finishtime']) {
        echo '<a href="?finish-workout=' . $rowg['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-street-view"></i> ' . lang_key("finish-workoutn") . '</a>';
    } else if ($countpac > 0 && $rowpac['type'] == $rowg['workout_type'] && time() < $rowpac['finishtime']) {
        $timeleft = secondsToWords($rowpac['finishtime'] - time());
        
        echo '<div class="row"><div class="col-md-6"><button class="btn btn-warning btn-md btn-block disabled"><em class="fas fa-fw fa-clock"></em> ' . $timeleft . '</button></div><div class="col-md-6"><a href="?interrupt-training=' . $rowg['id'] . '" class="btn btn-info btn-md btn-block"><i class="fa fa-sign-out-alt"></i>&nbsp; ' . lang_key("interrupt-training") . '</a></div></div>';
    } else if ($rowu['energy'] < $rowg['energy_cost'] || $rowu['money'] < $rowg['fee'] || $countpac > 0) {
        echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-street-view"></em>' . lang_key("start-workout") . '</button>';
    } else {
        echo '<a href="?start-workout=' . $rowg['id'] . '" class="btn btn-primary btn-md btn-block"><i class="fa fa-street-view"></i> ' . lang_key("start-workout") . '</a>';
    }
?>
    </div>
<?php
}
?>
    </div>
</div>
<?php
footer();
?>