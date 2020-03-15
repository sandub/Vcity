<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];
$levelu    = $rowu['level'];
$mlevel    = $levelu - 6;
$levelm    = $levelu + 6;

$date = date('d F Y');
$time = date('H:i');

if (isset($_GET['opponent'])) {
    
    $opponent_id = (int) $_GET['opponent'];
    
    $queryuo = mysqli_query($connect, "SELECT * FROM `players` WHERE username!='$uname' AND character_id>0 AND level>'$mlevel' AND level<'$levelm' AND health>=10 AND id='$opponent_id' LIMIT 1");
    
} else {
    $queryuo = mysqli_query($connect, "SELECT * FROM `players` WHERE username!='$uname' AND character_id>0 AND level>'$mlevel' AND level<'$levelm' AND health>=10 ORDER BY rand() LIMIT 1");
}

$rowuo   = mysqli_fetch_assoc($queryuo);
$countuo = mysqli_num_rows($queryuo);

$playero_id  = $rowuo['id'];
$characteru  = $rowu['character_id'];
$characteruo = $rowuo['character_id'];

$querypc  = mysqli_query($connect, "SELECT * FROM `characters` WHERE id='$characteru' LIMIT 1");
$rowpc    = mysqli_fetch_assoc($querypc);
$querypoc = mysqli_query($connect, "SELECT * FROM `characters` WHERE id='$characteruo' LIMIT 1");
$rowpoc   = mysqli_fetch_assoc($querypoc);

$querypac = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE player_id='$player_id' LIMIT 1");
$countpac = mysqli_num_rows($querypac);

$querypof = mysqli_query($connect, "SELECT * FROM `fights` WHERE playera_id='$player_id' AND playerb_id='$playero_id' AND date='$date'");
$countpof = mysqli_num_rows($querypof);

//Round 1 - Power
if ($rowu['power'] < $rowuo['power']) {
    $round1u  = 0;
    $round1uo = 1;
}
if ($rowu['power'] > $rowuo['power']) {
    $round1u  = 1;
    $round1uo = 0;
}
if ($rowu['power'] == $rowuo['power']) {
    $round1u  = 1;
    $round1uo = 1;
}

//Round 2 - Agility
if ($rowu['agility'] < $rowuo['agility']) {
    $round2u  = 0;
    $round2uo = 1;
}
if ($rowu['agility'] > $rowuo['agility']) {
    $round2u  = 1;
    $round2uo = 0;
}
if ($rowu['agility'] == $rowuo['agility']) {
    $round2u  = 1;
    $round2uo = 1;
}

//Round 3 - Endurance
if ($rowu['endurance'] < $rowuo['endurance']) {
    $round3u  = 0;
    $round3uo = 1;
}
if ($rowu['endurance'] > $rowuo['endurance']) {
    $round3u  = 1;
    $round3uo = 0;
}
if ($rowu['endurance'] == $rowuo['endurance']) {
    $round3u  = 1;
    $round3uo = 1;
}

//Round 4 - Intelligence
if ($rowu['intelligence'] < $rowuo['intelligence']) {
    $round4u  = 0;
    $round4uo = 1;
}
if ($rowu['intelligence'] > $rowuo['intelligence']) {
    $round4u  = 1;
    $round4uo = 0;
}
if ($rowu['intelligence'] == $rowuo['intelligence']) {
    $round4u  = 1;
    $round4uo = 1;
}

//Round 5 - Final (Calculations)
$round5u  = $round1u + $round2u + $round3u + $round4u;
$round5uo = $round1uo + $round2uo + $round3uo + $round4uo;

if ($round5u < $round5uo) {
    $winchance = 1;
}
if ($round5u == $round5uo) {
    $winchance = 2;
}
if ($round5u > $round5uo) {
    $winchance = 3;
}

if (isset($_GET['opponent'])) {
    
    if ($countpof > 2) {
        echo '
<div class="alert alert-danger">
  <center><strong><i class="fa fa-exclamation-circle"></i> ' . lang_key("cant-fightmore") . '</strong></center>
</div>';
    }
    
    if ($opponent_id != $player_id && $rowu['energy'] >= 10 && $rowu['health'] >= 10 && $rowuo['health'] >= 10 && $countuo > 0 && $countpac == 0 && $countpof < 3) {
        
        //Loss
        if ($winchance == 1) {
            $winner_id = $opponent_id;
        }
        
        //Last Chance
        if ($winchance == 2) {
            
            $lastchance = mt_rand(0, 1);
            
            if ($lastchance == 1) {
                $winner_id = $player_id;
            } else {
                $winner_id = $opponent_id;
            }
            
        }
        
        //Win
        if ($winchance == 3) {
            $winner_id = $player_id;
        }
        
        //Query
        if ($winner_id == $player_id) {
            
            $log_fight       = mysqli_query($connect, "INSERT INTO `fights` (playera_id, playerb_id, winner_id, date, time)
VALUES ('$player_id', '$opponent_id', '$winner_id', '$date', '$time')");
            $player_update   = mysqli_query($connect, "UPDATE `players` SET money=money+500, energy=energy-10, health=health-5, respect=respect+325 WHERE id='$player_id'");
            $opponent_update = mysqli_query($connect, "UPDATE `players` SET money=money-250, health=health-10 WHERE id='$opponent_id'");
            
            echo '
<div class="alert alert-success">
  <center><strong><i class="fa fa-trophy"></i> ' . lang_key("you-winf") . ' <br />' . lang_key("reward") . ': <span class="label label-success">$ 500</span> ' . lang_key("and") . ' <span class="label label-warning">2 ' . lang_key("gold") . '</label></strong></center>
</div>';
        } else {
            
            $log_fight       = mysqli_query($connect, "INSERT INTO `fights` (playera_id, playerb_id, winner_id, date, time)
VALUES ('$player_id', '$opponent_id', '$winner_id', '$date', '$time')");
            $player_update   = mysqli_query($connect, "UPDATE `players` SET money=money-250, energy=energy-10, health=health-10 WHERE id='$player_id'");
            $opponent_update = mysqli_query($connect, "UPDATE `players` SET money=money+500, health=health-5, respect=respect+325 WHERE id='$opponent_id'");
            
            echo '
<div class="alert alert-danger">
  <center><strong><i class="fa fa-trophy"></i> ' . lang_key("you-losef") . '</strong></center>
</div>';
        }
        
    }
}
?>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-crosshairs"></i> <?php
echo lang_key("fight-arena");
?></div>
	<div class="panel-body">
	
    <center><h2><i class="fa fa-crosshairs"></i> <?php
echo lang_key("fight-arena");
?></h2></center><br />
	
<?php
if ($rowu['energy'] < 10) {
    echo '
<div class="alert alert-info">
  <center><strong><i class="fa fa-exclamation-circle"></i> ' . lang_key("no-energytf") . '</strong></center>
</div>';
}

if ($rowu['health'] < 10) {
    echo '
<div class="alert alert-danger">
  <center><strong><i class="fa fa-exclamation-circle"></i> ' . lang_key("no-healthtf1") . ' <a href="hospital.php"><i class="fa fa-hospital"></i> ' . lang_key("hospital") . '</a> ' . lang_key("no-health2") . '</strong></center>
</div>';
}

if ($countuo <= 0) {
    echo '
<div class="alert alert-danger">
  <center><strong><i class="fa fa-exclamation-circle"></i> ' . lang_key("no-fighters") . '</strong></center>
</div>';
}
?>

    <div class="col-md-12">
	
	    <div class="row">
	        <div class="col-md-3">
			
			<center>
			<img src="<?php
echo $rowpc['image'];
?>" width="100%" style="border:8px solid #ccc; border-radius:15px;" />
			<br /><br />
			<div class="panel panel-primary">
            <div class="panel-heading"><i class="fa fa-archive"></i> <?php
echo lang_key("your-items");
?></div>
                <div class="panel-body">
<?php
$querypi  = mysqli_query($connect, "SELECT * FROM `player_items` WHERE player_id='$player_id' LIMIT 9");
$querypin = mysqli_query($connect, "SELECT * FROM `player_items` WHERE player_id='$player_id'");
$countpi  = mysqli_num_rows($querypi);

if ($countpi > 0) {
    while ($rowpi = mysqli_fetch_assoc($querypi)) {
        
        $item_id = $rowpi['item_id'];
        $queryi  = mysqli_query($connect, "SELECT * FROM `items` WHERE id='$item_id'");
        $rowi    = mysqli_fetch_assoc($queryi);
?>
                            <div class="col-md-4">
                                <center>
                                    <img src="<?php
        echo $rowi['image'];
?>" class="item-border" width="100%" data-toggle="tooltip" data-placement="top" title="<?php
        echo $rowi['item'];
?>" />
                                    <span class="label label-primary">+ <?php
        echo $rowi['bonusvalue'];
?> <?php
        echo $rowi['bonustype'];
?></span>
                                <hr /></center>
                            </div>
<?php
    }
    echo '
<div id="myitems" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-archive"></i> ' . lang_key("your-items") . '</h4>
      </div>
      <div class="modal-body">
	  <div class="row">
';
    while ($rowpin = mysqli_fetch_assoc($querypin)) {
        
        $itemn_id = $rowpin['item_id'];
        $queryin  = mysqli_query($connect, "SELECT * FROM `items` WHERE id='$itemn_id'");
        $rowin    = mysqli_fetch_assoc($queryin);
        echo '
                            <div class="col-md-3">
                                <center>
                                    <img src="' . $rowin['image'] . '" class="item-border" width="100%" data-toggle="tooltip" data-placement="top" title="' . $rowin['item'] . '" />
                                    <span class="label label-primary">+ ' . $rowin['bonusvalue'] . ' ' . $rowin['bonustype'] . '</span>
                                <hr /></center>
                            </div>
';
    }
    echo '
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> ' . lang_key("close") . '</button>
      </div>
    </div>

  </div>
</div>
	';
    echo '<br /><br /><a href="#" class="btn btn-default" data-toggle="modal" data-target="#myitems"><i class="fa fa-search"></i> ' . lang_key("view-all-items") . '</a>';
} else {
    echo '<div class="alert alert-info"><strong><i class="fa fa-info-circle"></i> ' . lang_key("yno-items") . '</strong></div>
          <div class="alert alert-success"><center><a href="shop.php" class="btn btn-success btn-md"><i class="fa fa-cart-plus"></i>&nbsp;&nbsp;' . lang_key("buy-items") . '</a></center></div>';
}
?>
			    </div>
            </div>
			</center>
			
			</div>
			<div class="col-md-6">
			
			<div class="row">
			    <div class="col-md-6">
				<div class="well">
				<center>
				    <h1><a href="player.php?id=<?php
echo $player_id;
?>" style="text-decoration: none;"><span class="label label-default"><img src="<?php
echo $rowu['avatar'];
?>" width="9%" />&nbsp; <?php
echo $rowu['username'];
?></span></a></h1><br />
					<h4><i class="fa fa-server"></i> <?php
echo lang_key("level");
?>: <span class="label label-primary"><?php
echo $levelu;
?></span></h4><hr /><br />
				</center><br />
				
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
                </div><br />
				
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
                </div><br />
				
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
                </div><br />
				
				<h5><i class="fa fa-heartbeat"></i> <?php
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
				
				<div class="col-md-6">
				<div class="well">
<?php
if ($countuo > 0) {
?>
				<center>
				    <h1><a href="player.php?id=<?php
    echo $playero_id;
?>" style="text-decoration: none;"><span class="label label-default"><img src="<?php
    echo $rowuo['avatar'];
?>" width="9%" />&nbsp; <?php
    echo $rowuo['username'];
?></span></a></h1><br />
					<h4><i class="fa fa-server"></i> <?php
    echo lang_key("level");
?>: <span class="label label-primary"><?php
    echo $rowuo['level'];
?></span></h4><hr /><br />
				</center><br />
				
				<h5><i class="fa fa-child"></i> <?php
    echo lang_key("power");
?></h5>
                <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-warning" style="width: <?php
    echo percent($rowuo['power'], 250);
?>%;">
                        <span><?php
    echo $rowuo['power'];
?> / 250</span>
                    </div>
                </div><br />
				
                <h5><i class="fa fa-retweet"></i> <?php
    echo lang_key("agility");
?></h5>
                <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-danger" style="width: <?php
    echo percent($rowuo['agility'], 250);
?>%;">
                        <span><?php
    echo $rowuo['agility'];
?> / 250</span>
                    </div>
                </div><br />
				
                <h5><i class="fa fa-heartbeat"></i> <?php
    echo lang_key("endurance");
?></h5>
                <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-success" style="width: <?php
    echo percent($rowuo['endurance'], 250);
?>%;">
                        <span><?php
    echo $rowuo['endurance'];
?> / 250</span>
                    </div>
                </div><br />
				
				<h5><i class="fa fa-heartbeat"></i> <?php
    echo lang_key("intelligence");
?></h5>
				<div class="progress progress-striped">
                    <div class="progress-bar progress-bar-info" style="width: <?php
    echo percent($rowuo['intelligence'], 250);
?>%;">
                        <span><?php
    echo $rowuo['intelligence'];
?> / 250</span>
                    </div>
                </div>
<?php
} else {
    echo '<center><i class="fa fa-question-circle fa-5x"></i></center>';
}
?>
				</div>
				</div>
			</div>
			
			<div class="row well">
			<div class="col-md-4">
			    <h4><i class="fa fa-cube fa-fw"></i> <?php
echo lang_key("chance-win");
?>:</h4>
			</div>
			<div class="col-md-8">
				<h3>
<?php
if ($winchance == 1) {
    echo '<label class="label label-danger">' . lang_key("little") . '</label> &nbsp;&nbsp;/&nbsp;&nbsp; ';
} else {
    echo '<label class="label label-default">' . lang_key("little") . '</label> &nbsp;&nbsp;/&nbsp;&nbsp; ';
}

if ($winchance == 2) {
    echo '<label class="label label-warning">' . lang_key("average") . '</label> &nbsp;&nbsp;/&nbsp;&nbsp; ';
} else {
    echo '<label class="label label-default">' . lang_key("average") . '</label> &nbsp;&nbsp;/&nbsp;&nbsp; ';
}

if ($winchance == 3) {
    echo '<label class="label label-success">' . lang_key("big") . '</label>';
} else {
    echo '<label class="label label-default">' . lang_key("big") . '</label>';
}
?>
				</h3>
			</div>
			</div>

			<div class="row well">
			<center>
			    <div class="col-md-6">
<?php
if ($rowu['energy'] < 10 || $rowu['health'] < 10 || $countuo <= 0 || $countpac > 0) {
    echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-bolt"></em>' . lang_key("fight") . '</button>';
} else {
    echo '<a href="?opponent=' . $rowuo['id'] . '" class="btn btn-danger btn-md btn-block"><i class="fa fa-bolt"></i> ' . lang_key("fight") . '</a>';
}
?>    
				</div>
				<div class="col-md-6">
				    <a href="fight-arena.php" class="btn btn-primary btn-md btn-block"><i class="fa fa-arrow-circle-right"></i> <?php
echo lang_key("find-another");
?></a>
				</div>
			</center>
			</div>
			
			</div>
			<div class="col-md-3">
			
			<center>
<?php
if ($countuo > 0) {
?>
			<img src="<?php
    echo $rowpoc['image'];
?>" width="100%" style="border:8px solid #ccc; border-radius:15px;" />
			<br /><br />
			<div class="panel panel-primary">
            <div class="panel-heading"><i class="fa fa-archive"></i> <?php
    echo $rowuo['username'];
?><?php
    echo lang_key("s-items");
?></div>
                <div class="panel-body">
<?php
    $queryoi  = mysqli_query($connect, "SELECT * FROM `player_items` WHERE player_id='$playero_id' LIMIT 9");
    $queryoin = mysqli_query($connect, "SELECT * FROM `player_items` WHERE player_id='$playero_id'");
    $countoi  = mysqli_num_rows($queryoi);
    
    if ($countoi > 0) {
        while ($rowoi = mysqli_fetch_assoc($queryoi)) {
            
            $itemo_id = $rowoi['item_id'];
            $queryio  = mysqli_query($connect, "SELECT * FROM `items` WHERE id='$itemo_id'");
            $rowio    = mysqli_fetch_assoc($queryio);
?>
                            <div class="col-md-4">
                                <center>
                                    <img src="<?php
            echo $rowio['image'];
?>" class="item-border" width="100%" data-toggle="tooltip" data-placement="top" title="<?php
            echo $rowio['item'];
?>" />
                                    <span class="label label-primary">+ <?php
            echo $rowio['bonusvalue'];
?> <?php
            echo $rowio['bonustype'];
?></span>
                                <hr /></center>
                            </div>
<?php
        }
        echo '
<div id="enemyitems" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-archive"></i> ' . $rowuo['username'] . '' . lang_key("s-items") . '</h4>
      </div>
      <div class="modal-body">
	  <div class="row">
';
        while ($rowoin = mysqli_fetch_assoc($queryoin)) {
            
            $itemno_id = $rowoin['item_id'];
            $queryino  = mysqli_query($connect, "SELECT * FROM `items` WHERE id='$itemno_id'");
            $rowino    = mysqli_fetch_assoc($queryino);
            echo '
                            <div class="col-md-3">
                                <center>
                                    <img src="' . $rowino['image'] . '" class="item-border" width="100%" data-toggle="tooltip" data-placement="top" title="' . $rowino['item'] . '" />
                                    <span class="label label-primary">+ ' . $rowino['bonusvalue'] . ' ' . $rowino['bonustype'] . '</span>
                                <hr /></center>
                            </div>
';
        }
        echo '
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> ' . lang_key("close") . '</button>
      </div>
    </div>

  </div>
</div>
	';
        echo '<br /><br /><a href="#" class="btn btn-default" data-toggle="modal" data-target="#enemyitems"><i class="fa fa-search"></i> ' . lang_key("view-all-items") . '</a>';
    } else {
        echo '<div class="alert alert-info"><strong><i class="fa fa-info-circle"></i> ' . lang_key("pno-items") . '</strong></div>';
    }
?>
			    </div>
            </div>
<?php
}
?>
			</center>
			
			</div>
		</div>
		
    </div>
	</div>
	
</div>
<?php
footer();
?>