<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['start-education'])) {
    
    $subject_id = (int) $_GET['start-education'];
    
    $queryws = mysqli_query($connect, "SELECT * FROM `school` WHERE id = '$subject_id' LIMIT 1");
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
        
        $type        = $rowws['subject'];
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

if (isset($_GET['interrupt-education'])) {
    $subject_id = (int) $_GET["interrupt-education"];
    
    $queryws = mysqli_query($connect, "SELECT * FROM `school` WHERE id='$subject_id' LIMIT 1");
    $countws = mysqli_num_rows($queryws);
    
    if ($countws > 0) {
        $rowws = mysqli_fetch_assoc($queryws);
        
        $type        = $rowws['subject'];
        $energy_cost = $rowws['energy_cost'] / 2;
        $fee         = $rowws['fee'] / 2;
        
        $querypws = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type='$type' AND player_id='$player_id' LIMIT 1");
        $countpws = mysqli_num_rows($querypws);
        
        if ($countpws > 0) {
            $interrupt_education = mysqli_query($connect, "DELETE FROM `player_actions` WHERE type='$type' AND player_id='$player_id'");
            $player_update       = mysqli_query($connect, "UPDATE `players` SET energy=energy+'$energy_cost', money=money+'$fee' WHERE id='$player_id'");
        }
    }
}

if (isset($_GET['finish-education'])) {
    
    $subject_id = (int) $_GET['finish-education'];
    
    $queryws = mysqli_query($connect, "SELECT * FROM `school` WHERE id = '$subject_id' LIMIT 1");
    $countws = mysqli_num_rows($queryws);
    if ($countws > 0) {
        $rowws = mysqli_fetch_assoc($queryws);
        
        $type = $rowws['subject'];
        
        $querypws = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type = '$type' AND player_id='$player_id' LIMIT 1");
        $countpws = mysqli_num_rows($querypws);
        $rowpws   = mysqli_fetch_assoc($querypws);
        if ($countpws > 0) {
            $correct = 'Yes';
        } else {
            $correct = 'No';
        }
        
        $intelligence = $rowws['intelligence'];
        
        if ($correct == 'Yes' && time() >= $rowpws['finishtime']) {
            
            $education_finish = mysqli_query($connect, "DELETE FROM `player_actions` WHERE type='$type' AND player_id='$player_id'");
            $finish_training  = mysqli_query($connect, "UPDATE `players` SET intelligence=intelligence+'$intelligence' WHERE id='$player_id'");
            
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#finish-education").modal(\'show\');
            });
        </script>

        <div id="finish-education" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("end-education") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-info">' . lang_key("finish-edu") . '</span></h3><br /><br /><br />
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <h4><i class="fa fa-graduation-cap"></i>  Intelligence: <br /><hr /><span class="label label-default">+ ' . $intelligence . '</span></h4>
                                </div>
                                <div class="col-md-4"></div>
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
        <h3 class="panel-title"><i class="fa fa-graduation-cap"></i> <?php
echo lang_key("school");
?></h3>
    </div>
    <div class="panel-body">
        
        <center><h2><i class="fa fa-graduation-cap"></i> <?php
echo lang_key("school");
?></h2></center><br />

<?php
$querys = mysqli_query($connect, "SELECT * FROM `school` ORDER BY intelligence ASC");
while ($rowsc = mysqli_fetch_assoc($querys)) {
    
    $querypac = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE player_id='$player_id' LIMIT 1");
    $rowpac   = mysqli_fetch_assoc($querypac);
    $countpac = mysqli_num_rows($querypac);
?>
    <div class="col-md-6">
        <div class="jumbotron">
        <center><h3>
            <span class="fa-stack fa-md"><i class="fa fa-circle fa-stack-2x"></i><i class="fa <?php
    echo $rowsc['fa_icon'];
?> fa-stack-1x fa-inverse"></i></span>
            <?php
    echo $rowsc['subject'];
?></h3></center><hr /><br />

        <div class="row">
            <div class="col-md-12">
                <ul class="list-group"><br />
                    <li class="list-group-item">
                        <span class="badge badge-danger"><?php
    echo $rowsc['time'];
?> <?php
    echo $rowsc['format'];
?></span>
                        <i class="fas fa-clock"></i>&nbsp;&nbsp; <?php
    echo lang_key("lesson-duration");
?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge badge-success"><i class="fa fa-dollar-sign"></i> <?php
    echo $rowsc['fee'];
?></span>
                        <i class="fa fa-dollar-sign"></i>&nbsp;&nbsp; <?php
    echo lang_key("education-fee");
?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge badge-primary"><?php
    echo $rowsc['energy_cost'];
?></span>
                        <i class="fa fa-bolt"></i>&nbsp;&nbsp; <?php
    echo lang_key("energy-cost");
?>
                    </li>
                </ul>
                
                <h5><i class="fa fa-child"></i> <?php
    echo lang_key("intelligence");
?> &nbsp;&nbsp; [+ <?php
    echo $rowsc['intelligence'];
?>]</h5>
                <div class="progress">
                    <div class="progress-bar progress-bar-info" style="width: <?php
    echo percent($rowu['intelligence'], 250);
?>%;">
                        <span><?php
    echo $rowu['intelligence'];
?> / 250</span>
                    </div><div class="progress-bar progress-bar-success" style="width: <?php
    echo percent($rowsc['intelligence'] + 1, 250);
?>%;"></div>
                </div>
            </div>
        </div><br />
<?php
    if ($countpac > 0 && $rowpac['type'] == $rowsc['subject'] && time() >= $rowpac['finishtime']) {
        echo '<a href="?finish-education=' . $rowsc['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-graduation-cap"></i> ' . lang_key("finish-education") . '</a>';
    } else if ($countpac > 0 && $rowpac['type'] == $rowsc['subject'] && time() < $rowpac['finishtime']) {
        $timeleft = secondsToWords($rowpac['finishtime'] - time());
        
        echo '<div class="row"><div class="col-md-6"><button class="btn btn-warning btn-md btn-block disabled"><em class="fas fa-fw fa-clock"></em> ' . $timeleft . '</button></div><div class="col-md-6"><a href="?interrupt-education=' . $rowsc['id'] . '" class="btn btn-info btn-md btn-block"><i class="fa fa-sign-out-alt"></i>&nbsp; ' . lang_key("interrupt-education") . '</a></div></div>';
    } else if ($rowu['energy'] < $rowsc['energy_cost'] || $rowu['money'] < $rowsc['fee'] || $countpac > 0) {
        echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-graduation-cap"></em> ' . lang_key("start-education") . '</button>';
    } else {
        echo '<a href="?start-education=' . $rowsc['id'] . '" class="btn btn-warning btn-md btn-block"><i class="fa fa-graduation-cap"></i> ' . lang_key("start-education") . '</a>';
    }
?>
        </div>
    </div>
<?php
}
?>
    </div>
</div>
<?php
footer();
?>