<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['start-treatment'])) {
    
    $treatment_id = (int) $_GET['start-treatment'];
    
    $queryht = mysqli_query($connect, "SELECT * FROM `hospital` WHERE id = '$treatment_id' LIMIT 1");
    $countht = mysqli_num_rows($queryht);
    if ($countht > 0) {
        $rowht = mysqli_fetch_assoc($queryht);
        
        $queryauc = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE player_id='$player_id' LIMIT 1");
        $countauc = mysqli_num_rows($queryauc);
        if ($countauc > 0) {
            $busy = 'Yes';
        } else {
            $busy = 'No';
        }
        
        $type = $rowht['treatment_type'];
        $cost = $rowht['cost'];
        
        if ($rowht['format'] == "Hours") {
            $finishtime = time() + ($rowht['time'] * 3600);
        }
        if ($rowht['format'] == "Minutes") {
            $finishtime = time() + ($rowht['time'] * 60);
        }
        
        if ($rowu['energy'] < 100 && $rowu['money'] >= $cost && $busy == 'No') {
            
            $treatment_start = mysqli_query($connect, "INSERT INTO `player_actions` (player_id, type, finishtime)
VALUES ('$player_id', '$type', '$finishtime')");
            $player_update   = mysqli_query($connect, "UPDATE `players` SET money=money-'$cost' WHERE id='$player_id'");
            
        }
    }
}

if (isset($_GET['interrupt-treatment'])) {
    $treatment_id = (int) $_GET["interrupt-treatment"];
    
    $queryht = mysqli_query($connect, "SELECT * FROM `hospital` WHERE id='$treatment_id' LIMIT 1");
    $countht = mysqli_num_rows($queryht);
    
    if ($countht > 0) {
        $rowht = mysqli_fetch_assoc($queryht);
        
        $type = $rowht['treatment_type'];
        $cost = $rowht['cost'] / 2;
        
        $querypht = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type='$type' AND player_id='$player_id' LIMIT 1");
        $countpht = mysqli_num_rows($querypht);
        
        if ($countpht > 0) {
            $interrupt_treatment = mysqli_query($connect, "DELETE FROM `player_actions` WHERE type='$type' AND player_id='$player_id'");
            $player_update       = mysqli_query($connect, "UPDATE `players` SET money=money+'$cost' WHERE id='$player_id'");
        }
    }
}

if (isset($_GET['finish-treatment'])) {
    
    $treatment_id = (int) $_GET['finish-treatment'];
    
    $queryht = mysqli_query($connect, "SELECT * FROM `hospital` WHERE id = '$treatment_id' LIMIT 1");
    $countht = mysqli_num_rows($queryht);
    if ($countht > 0) {
        $rowht = mysqli_fetch_assoc($queryht);
        
        $type = $rowht['treatment_type'];
        
        $querypht = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type = '$type' AND player_id='$player_id' LIMIT 1");
        $countpht = mysqli_num_rows($querypht);
        $rowpht   = mysqli_fetch_assoc($querypht);
        if ($countpht > 0) {
            $correct = 'Yes';
        } else {
            $correct = 'No';
        }
        
        $health_restore = $rowht['health_restore'];
        
        if ($correct == 'Yes' && time() >= $rowpht['finishtime']) {
            
            $treatment_finish = mysqli_query($connect, "DELETE FROM `player_actions` WHERE type='$type' AND player_id='$player_id'");
            $player_update    = mysqli_query($connect, "UPDATE `players` SET health=health+'$health_restore' WHERE id='$player_id'");
            
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#finish-treatment").modal(\'show\');
            });
        </script>

        <div id="finish-treatment" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("end-treatment") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-info"><i class="fa fa-user-md"></i> ' . lang_key("finished-treatment") . '</span></h3><br /><br /><br />
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <h4><i class="fa fa-heartbeat"></i>  Health: <br /><hr /><span class="label label-default">+ ' . $health_restore . '</span></h4>
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
<div class="col-md-12 well">

    <center><h2><i class="fa fa-hospital"></i> <?php
echo lang_key("hospital");
?></h2></center><br />

    <div class="row">
	
	<center>
	    <div class="col-md-1"></div>
	    <div class="col-md-10">
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
                </div><br /><br />
        </div>
		<div class="col-md-1"></div>
    </center>

<?php
$queryh = mysqli_query($connect, "SELECT * FROM `hospital` ORDER BY health_restore ASC");
while ($rowh = mysqli_fetch_assoc($queryh)) {
    
    $querypac = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE player_id='$player_id' LIMIT 1");
    $rowpac   = mysqli_fetch_assoc($querypac);
    $countpac = mysqli_num_rows($querypac);
?>
        <div class="col-md-6">
		    <div class="jumbotron">
			    <center><h2><i class="fa <?php
    echo $rowh['fa_icon'];
?>"></i> <?php
    echo $rowh['treatment_type'];
?></h2><hr /></center>
				<ul class="list-group">
				    <li class="list-group-item"><i class="fa fa-heart"></i> <?php
    echo lang_key("health");
?> <span class="badge badge-success">+ <?php
    echo $rowh['health_restore'];
?></span></li>
				    <li class="list-group-item"><i class="fas fa-clock"></i> <?php
    echo lang_key("treatment-duration");
?> <span class="badge badge-info"><?php
    echo $rowh['time'];
?> <?php
    echo $rowh['format'];
?></span></li>
					<li class="list-group-item"><i class="fa fa-dollar-sign"></i> <?php
    echo lang_key("treatment-cost");
?> <span class="badge badge-warning">$ <?php
    echo $rowh['cost'];
?></span></li>
				</ul>
                <br />
				<center>
<?php
    if ($countpac > 0 && $rowpac['type'] == $rowh['treatment_type'] && time() >= $rowpac['finishtime']) {
        echo '<a href="?finish-treatment=' . $rowh['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-check-square"></i> ' . lang_key("finish-treatment") . '</a>';
    } else if ($countpac > 0 && $rowpac['type'] == $rowh['treatment_type'] && time() < $rowpac['finishtime']) {
        $timeleft = secondsToWords($rowpac['finishtime'] - time());
        
        echo '<div class="row"><div class="col-md-6"><button class="btn btn-warning btn-md btn-block disabled"><em class="fas fa-fw fa-clock"></em> ' . $timeleft . '</button></div><div class="col-md-6"><a href="?interrupt-treatment=' . $rowh['id'] . '" class="btn btn-info btn-md btn-block"><i class="fa fa-sign-out-alt"></i>&nbsp; ' . lang_key("interrupt-treatment") . '</a></div></div>';
    } else if ($rowu['energy'] == 100 || $rowu['money'] < $rowh['cost'] || $countpac > 0) {
        echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-user-md"></em> ' . lang_key("start-treatment") . '</button>';
    } else {
        echo '<a href="?start-treatment=' . $rowh['id'] . '" class="btn btn-primary btn-md btn-block"><i class="fa fa-user-md"></i> ' . lang_key("start-treatment") . '</a>';
    }
?>
				</center>
			</div>
		</div>
<?php
}
?>

	</center>
    </div>
</div>
<?php
footer();
?>