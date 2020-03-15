<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu  = mysqli_fetch_assoc($suser);
$uid   = $rowu['id'];

if (isset($_GET['sell-id'])) {
    $player_id    = $rowu['id'];
    $vehiclefs_id = (int) $_GET["sell-id"];
    
    $querysvv = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE vehicle_id='$vehiclefs_id' and player_id='$uid' LIMIT 1");
    $countsvv = mysqli_num_rows($querysvv);
    
    if ($countsvv > 0) {
        
        $queryvfsc = mysqli_query($connect, "SELECT * FROM `vehicles` WHERE id='$vehiclefs_id' LIMIT 1");
        $rowvfsc   = mysqli_fetch_assoc($queryvfsc);
        
        $money_back = $rowvfsc['money'] / 2;
        $gold_back  = $rowvfsc['gold'] / 2;
        
        $sell_vehicle = mysqli_query($connect, "DELETE FROM `player_vehicles` WHERE vehicle_id='$vehiclefs_id' AND player_id='$player_id'");
        
        $values_back = mysqli_query($connect, "UPDATE `players` SET money=money+'$money_back', gold=gold+'$gold_back' WHERE id='$player_id'");
        
        echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#sell-vehicle").modal(\'show\');
            });
        </script>

        <div id="sell-vehicle" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("selling-vehicle") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-info">' . lang_key("success-soldv") . '</span></h3>
                                <img src="' . $rowvfsc['image'] . '" width="75%"><br />
                            <br /><br />
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="images/icons/money.png" width="25%"><br />
                                    <h4>Money: <br /><hr /><span class="label label-default">+ ' . $money_back . '</span></h4>
                                </div>
                                <div class="col-md-6">
                                    <img src="images/icons/gold1.png" width="25%"><br />
                                    <h4>Gold: <br /><hr /><span class="label label-default">+ ' . $gold_back . '</span></h4>
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

if (isset($_GET['delcomment_id'])) {
    $player_id = $rowu['id'];
    $id        = (int) $_GET["delcomment_id"];
    $query     = mysqli_query($connect, "DELETE FROM `player_comments` WHERE id='$id' AND player_id='$player_id'");
}

if (isset($_POST['postcomment'])) {
    $comment   = $_POST['comment'];
    $player_id = $rowu['id'];
    $author_id = $rowu['id'];
    $date      = date('d F Y');
    $time      = date('H:i');
    
    $querycpc = mysqli_query($connect, "SELECT * FROM `player_comments` WHERE author_id='$author_id' AND player_id='$player_id' AND comment='$comment' AND date='$date' LIMIT 1");
    $countcpc = mysqli_num_rows($querycpc);
    if ($countcpc == 0) {
        $post_comment = mysqli_query($connect, "INSERT INTO `player_comments` (player_id, author_id, comment, date, time) VALUES ('$player_id', '$author_id', '$comment', '$date', '$time')");
    }
}
?>
        <div class="col-md-12 well">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart"></i> <?php
echo lang_key("your-statistics");
?></h3>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <img src="<?php
echo $rowu['avatar'];
?>" width="100%" />
                                </div>
                                <div class="col-md-8">
                                    <h2><i class="fa fa-user"></i> <?php
echo $rowu['username'];
?> <font size="4px">
<?php
if ($rowu['role'] == "Admin") {
    echo '<span class="label label-danger"><i class="fa fa-bookmark"></i> ' . $rowu['role'] . '</span> ';
}

if ($rowu['role'] == "VIP") {
    echo '<span class="label label-warning"><i class="fa fa-star"></i> ' . $rowu['role'] . '</span> ';
}
?>
<?php
$timeonline = time() - 60;
if ($rowu['timeonline'] > $timeonline) {
    echo '<span class="label label-success"><i class="fa fa-circle"></i> ' . lang_key("online") . '</span>';
}
?>
</font></h2>
                                    <hr />
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
                                    <h5><strong><i class="fa fa-star"></i> <?php
echo lang_key("respect");
?>: </strong><span class="label label-primary"><?php
echo $rowu['respect'];
?></span></h5>
                                </div>
                            </div>
                            <hr />

                            <b><i class="fa fa-star"></i> <?php
echo lang_key("level");
?>:</b> <?php
echo $rowu['level'];
?>
<?php
$level   = $rowu['level'];
$querycl = mysqli_query($connect, "SELECT min_respect FROM `levels` WHERE level='$level'");
$rowcl   = mysqli_fetch_assoc($querycl);
$querynl = mysqli_query($connect, "SELECT min_respect FROM `levels` WHERE level='$level'+1");
$rownl   = mysqli_fetch_assoc($querynl);

$levelpercent = (($rowu['respect'] - $rowcl['min_respect']) / ($rownl['min_respect'] - $rowcl['min_respect'])) * 100;
?>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-primary" style="width: <?php
echo '' . round($levelpercent) . '';
?>%"></div>
                            </div>
                            <hr>
<?php
$querypfw = mysqli_query($connect, "SELECT * FROM `fights` WHERE winner_id='$uid'");
$countpfw = mysqli_num_rows($querypfw);
$queryprw = mysqli_query($connect, "SELECT * FROM `races` WHERE winner_id='$uid'");
$countprw = mysqli_num_rows($queryprw);
$queryppt = mysqli_query($connect, "SELECT * FROM `player_properties` WHERE player_id='$uid'");
$countppt = mysqli_num_rows($queryppt);
$income   = 0;
while ($rowppt = mysqli_fetch_assoc($queryppt)) {
    $property_id = $rowppt['property_id'];
    $queryppi    = mysqli_query($connect, "SELECT * FROM `properties` WHERE id='$property_id'");
    $rowppi      = mysqli_fetch_assoc($queryppi);
    $income      = $income + $rowppi['income'];
}
?>
                            <div class="row">
                                <div class="col-md-3"><b><i class="fa fa-bolt"></i> <?php
echo $countpfw;
?></b>
                                    <br/><small><?php
echo lang_key("fight-wins");
?></small>
                                </div>
                                <div class="col-md-3"><b><i class="fa fa-flag-checkered"></i> <?php
echo $countprw;
?></b>
                                    <br/><small><?php
echo lang_key("race-wins");
?></small>
                                </div>
                                <div class="col-md-3"><b><i class="fa fa-building"></i> <?php
echo $countppt;
?></b>
                                    <br/><small><?php
echo lang_key("properties");
?></small>
                                </div>
                                <div class="col-md-3"><b><i class="fa fa-dollar-sign"></i> <?php
echo $income;
?></b>
                                    <br/><small><?php
echo lang_key("income");
?></small>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-wrench"></i> <?php
echo lang_key("characters-skills");
?></h3>
                        </div>
                        <div class="panel-body">
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

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="far fa-hand-paper"></i> <?php
echo lang_key("your-items");
?></h3>
                        </div>
                        <div class="panel-body">
<?php
$player_id = $rowu['id'];
$querypi   = mysqli_query($connect, "SELECT * FROM `player_items` WHERE player_id='$player_id' LIMIT 12");
$querypin  = mysqli_query($connect, "SELECT * FROM `player_items` WHERE player_id='$player_id'");
$countpi   = mysqli_num_rows($querypi);

if ($countpi > 0) {
    while ($rowpi = mysqli_fetch_assoc($querypi)) {
        
        $item_id = $rowpi['item_id'];
        $queryi  = mysqli_query($connect, "SELECT * FROM `items` WHERE id='$item_id'");
        $rowi    = mysqli_fetch_assoc($queryi);
?>
                            <div class="col-md-3">
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
    echo '<br /><br /><center><a href="#" class="btn btn-default" data-toggle="modal" data-target="#myitems"><i class="fa fa-search"></i> ' . lang_key("view-all-items") . '</a></center>';
} else {
    echo '<div class="alert alert-info"><strong><i class="fa fa-info-circle"></i> ' . lang_key("yno-items") . '</strong></div>
          <div class="alert alert-success"><center><a href="shop.php" class="btn btn-success btn-md"><i class="fa fa-cart-plus"></i>&nbsp;&nbsp;' . lang_key("buy-items") . '</a></center></div>';
}
?>
                        </div>
                    </div>
                    
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-comments"></i> <?php
echo lang_key("comments");
?></h3>
                        </div>
                        <div class="panel-body">
<?php
$tday   = date("d");
$tmonth = date("n");
$tyear  = date("Y");

$thour   = date("H");
$tminute = date("i");

$querycp = mysqli_query($connect, "SELECT * FROM `player_comments` WHERE player_id='$player_id' ORDER BY id DESC LIMIT 6");
$countcp = mysqli_num_rows($querycp);
if ($countcp > 0) {
    while ($rowcp = mysqli_fetch_assoc($querycp)) {
        $author_id = $rowcp['author_id'];
        $querycpd  = mysqli_query($connect, "SELECT * FROM `players` WHERE id='$author_id' LIMIT 1");
        $rowcpd    = mysqli_fetch_assoc($querycpd);
?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <img src="<?php
        echo $rowcpd['avatar'];
?>" width="8%">&nbsp;&nbsp;<strong><a href="player.php?id=<?php
        echo $author_id;
?>"><?php
        echo $rowcpd['username'];
?></a></strong>
                                    <a href="?delcomment_id=<?php
        echo $rowcp['id'];
?>" class="btn btn-danger btn-sm pull-right" title="<?php
        echo lang_key("delete-this-comment");
?>"><i class="fa fa-trash"></i></a>
                                </div>
                                <div class="panel-body comment-emoticons">
                                    <?php
        echo emoticons($rowcp['comment']);
?>
                                </div>
                                <div class="panel-footer">
                                    <i class="fas fa-clock"></i> 
<?php
        $getdate = date_parse_from_format("d F Y", $rowcp['date']);
        $gettime = date_parse_from_format("H:i", $rowcp['time']);
        $day     = $getdate["day"];
        $month   = $getdate["month"];
        $year    = $getdate["year"];
        $hour    = $gettime["hour"];
        $minute  = $gettime["minute"];
        
        if ($year != $tyear) {
            $c_year = $tyear - $year;
            if ($c_year == 1) {
                $ssymbol = '';
            } else {
                $ssymbol = 's';
            }
            echo '' . $c_year . ' year' . $ssymbol . ' ago';
        } else {
            if ($month != $tmonth) {
                $c_month = $tmonth - $month;
                if ($c_month == 1) {
                    $ssymbol = '';
                } else {
                    $ssymbol = 's';
                }
                echo '' . $c_month . ' month' . $ssymbol . ' ago';
            } else {
                if ($day != $tday) {
                    $c_day = $tday - $day;
                    if ($c_day == 1) {
                        $ssymbol = '';
                    } else {
                        $ssymbol = 's';
                    }
                    echo '' . $c_day . ' day' . $ssymbol . ' ago';
                } else {
                    if ($hour != $thour) {
                        $c_hour = $thour - $hour;
                        if ($c_hour == 1) {
                            $ssymbol = '';
                        } else {
                            $ssymbol = 's';
                        }
                        echo '' . $c_hour . ' hour' . $ssymbol . ' ago';
                    } else {
                        if ($minute != $tminute) {
                            $c_minute = $tminute - $minute;
                            if ($c_minute == 1) {
                                $ssymbol = '';
                            } else {
                                $ssymbol = 's';
                            }
                            echo '' . $c_minute . ' minute' . $ssymbol . ' ago';
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
} else {
    echo '<div class="alert alert-info"><strong><i class="fa fa-info-circle"></i> ' . lang_key("no-comments") . '</strong></div>';
}
?>
				            <form action="" method="post">
								<textarea placeholder="<?php
echo lang_key("write-a-comment");
?>" name="comment" class="form-control" required></textarea>
								<br /><button type="submit" name="postcomment" class="btn btn-success pull-right"><i class="fa fa-share"></i> <?php
echo lang_key("comment");
?></button>
				            </form>
                            
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="btn-group btn-group-xs pull-right">
                                <a href="home-upgrades.php" class="btn btn-success"><em class="fa fa-fw fa-arrow-circle-up"></em><span class="hidden-xs"><?php
echo lang_key("home-upgrades");
?></span></a>
                            </div>
                            <h3 class="panel-title"><i class="fa fa-home"></i> <?php
echo lang_key("your-home");
?></h3>
                        </div>
<?php
$home_id = $rowu['home_id'];
$queryh  = mysqli_query($connect, "SELECT * FROM `homes` WHERE id='$home_id' LIMIT 1");
$counth  = mysqli_num_rows($queryh);
$rowh    = mysqli_fetch_assoc($queryh);
if ($counth > 0) {
    echo '<div class="panel-body" style="background-image: url(' . $rowh['image'] . ');  background-size: 100% 100%; background-repeat: no-repeat; height: auto;">';
} else {
    echo '<div class="panel-body">
             <div class="alert alert-info"><strong><i class="fa fa-info-circle"></i> ' . lang_key("yno-home") . '</strong></div>
             <div class="alert alert-success"><center><a href="home-upgrades.php" class="btn btn-success btn-md"><i class="fa fa-home"></i>&nbsp;&nbsp;' . lang_key("buy-home") . '</a></center></div>';
}
?>
                            <center>
<?php
if ($counth > 0) {
    $character_id = $rowu['character_id'];
    $queryc       = mysqli_query($connect, "SELECT * FROM `characters` WHERE id='$character_id' LIMIT 1");
    $countc       = mysqli_num_rows($queryc);
    $rowc         = mysqli_fetch_assoc($queryc);
    if ($countc > 0) {
        echo '<img src="' . $rowc['image'] . '" width="32%" />';
    }
    
    $querypp = mysqli_query($connect, "SELECT pet_id FROM `player_pets` WHERE player_id='$uid'");
    while ($rowpp = mysqli_fetch_assoc($querypp)) {
        $pet_id  = $rowpp['pet_id'];
        $querypt = mysqli_query($connect, "SELECT * FROM `pets` WHERE id='$pet_id' LIMIT 1");
        $countpt = mysqli_num_rows($querypt);
        if ($countpt > 0) {
            $rowpt = mysqli_fetch_assoc($querypt);
            echo '<img src="' . $rowpt['image'] . '" width="20%" style="padding-top: 28%;" />';
        }
    }
}
?>
                            </center>
                        </div>
                    </div>

<?php
$garage_id = $rowu['garage_id'];
$queryg    = mysqli_query($connect, "SELECT * FROM `garages` WHERE id='$garage_id' LIMIT 1");
$countg    = mysqli_num_rows($queryg);
$rowg      = mysqli_fetch_assoc($queryg);
if ($countg > 0) {
?>
                    <div class="panel panel-primary">   
                        <div class="panel-heading">
                            <div class="btn-group btn-group-xs pull-right">
                                <a href="garage-upgrades.php" class="btn btn-success"><em class="fa fa-fw fa-arrow-circle-up"></em><span class="hidden-xs"><?php
    echo lang_key("garage-upgrades");
?></span></a>
                            </div>
                            <h3 class="panel-title"><i class="fa fa-car"></i> <?php
    echo lang_key("your-garage");
?></h3>
                        </div>
<?php
    $countergv = 0;
    $querypv   = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id='$player_id'");
    while ($rowpv = mysqli_fetch_assoc($querypv)) {
        
        $vehicle_id = $rowpv['vehicle_id'];
        $querygv    = mysqli_query($connect, "SELECT * FROM `vehicles` WHERE id='$vehicle_id' AND NOT category_id='4' OR NOT category_id='5' LIMIT 1");
        $countgv    = mysqli_num_rows($querygv);
        
        if ($countgv > 0) {
            $countergv = $countergv + 1;
        }
        
    }
?>
                        <div id="cars" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" role="listbox">
<?php
    $firstv   = true;
    $querypgv = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id='$player_id' ORDER BY speed DESC");
    while ($rowpgv = mysqli_fetch_assoc($querypgv)) {
        
        $gvehicle_id = $rowpgv['vehicle_id'];
        $querygvc    = mysqli_query($connect, "SELECT * FROM `vehicles` WHERE id='$gvehicle_id'");
        $rowgvc      = mysqli_fetch_assoc($querygvc);
        
        if ($rowgvc['category_id'] != 4 && $rowgvc['category_id'] != 5) {
?>
                                <div class="item <?php
            if ($firstv) {
                $firstv = false;
                echo 'active';
            }
?>">
                                    <div class="panel-body" style="background-image: url(<?php
            echo $rowg['image'];
?>); background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
                                        <center><img src="<?php
            echo $rowgvc['image'];
?>" width="60%" style="position: absolute; left: 19%; bottom: 12%;" /></center>
                                    </div>
                                    <div class="panel-footer">
                                        <a href="vehicle-upgrades.php#<?php
            echo $rowpgv['id'];
?>" class="btn btn-success"><em class="fa fa-fw fa-arrow-circle-up"></em><span class="hidden-xs"><?php
            echo lang_key("upgrade");
?></span></a>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("speed");
?>: <span class="label label-primary"><?php
            echo $rowpgv['speed'];
?></span>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("acceleration");
?>: <span class="label label-danger"><?php
            echo $rowpgv['acceleration'];
?></span>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("stability");
?>: <span class="label label-warning"><?php
            echo $rowpgv['stability'];
?></span> 

                                        <a href="?sell-id=<?php
            echo $rowpgv['vehicle_id'];
?>" class="btn btn-danger pull-right"><em class="fa fa-fw fa-dollar-sign"></em><span class="hidden-xs"><?php
            echo lang_key("sell");
?></span></a>
                                    </div>
                                </div>
<?php
        }
    }
?>

                            </div>

                            <a class="left carousel-control" href="#cars" role="button" data-slide="prev" style="height: 90%;">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            </a>
                            <a class="right carousel-control" href="#cars" role="button" data-slide="next" style="height: 90%;">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            </a>
<?php
    if ($countergv == 0) {
?>
    <div class="panel-body" style="background-image: url(<?php
        echo $rowg['image'];
?>); background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
        <div class="alert alert-info"><strong><i class="fa fa-info-circle"></i> <?php
        echo lang_key("yno-vehicles");
?></strong></div>
        <br /><br /><br /><br /><br /><br /><center><a href="vehicles.php" class="btn btn-primary btn-md"><i class="fa fa-car"></i>&nbsp;&nbsp;<?php
        echo lang_key("buy-vehicle");
?></a></center>
    </div>
<?php
    }
?>
                        </div>
                    </div>
<?php
} else {
    echo '<div class="alert alert-success"><center><a href="garage-upgrades.php" class="btn btn-success btn-md btn-block"><i class="fa fa-car"></i>&nbsp;&nbsp;' . lang_key("buy-garage") . '</a></center></div>';
}
?>
                
<?php
$hangar_id = $rowu['hangar_id'];
$queryh    = mysqli_query($connect, "SELECT * FROM `hangars` WHERE id='$hangar_id' LIMIT 1");
$counth    = mysqli_num_rows($queryh);
$rowh      = mysqli_fetch_assoc($queryh);
if ($counth > 0) {
?>
                    <div class="panel panel-primary">   
                        <div class="panel-heading">
                            <div class="btn-group btn-group-xs pull-right">
                                <a href="hangar-upgrades.php" class="btn btn-success"><em class="fa fa-fw fa-arrow-circle-up"></em><span class="hidden-xs"><?php
    echo lang_key("hangar-upgrades");
?></span></a>
                            </div>
                            <h3 class="panel-title"><i class="fa fa-plane"></i> <?php
    echo lang_key("your-hangar");
?></h3>
                        </div>
<?php
    $counterhv = 0;
    $querypvh  = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id='$player_id'");
    while ($rowpvh = mysqli_fetch_assoc($querypvh)) {
        
        $vehicle_id = $rowpvh['vehicle_id'];
        $queryhv    = mysqli_query($connect, "SELECT * FROM `vehicles` WHERE id='$vehicle_id' AND category_id='4' LIMIT 1");
        $counthv    = mysqli_num_rows($queryhv);
        
        if ($counthv > 0) {
            $counterhv = $counterhv + 1;
        }
        
    }
?>
                        <div id="planes" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" role="listbox">
<?php
    $firstp   = true;
    $queryphv = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id='$player_id' ORDER BY speed DESC");
    while ($rowphv = mysqli_fetch_assoc($queryphv)) {
        
        $hvehicle_id = $rowphv['vehicle_id'];
        $queryhvc    = mysqli_query($connect, "SELECT * FROM `vehicles` WHERE id='$hvehicle_id'");
        $rowhvc      = mysqli_fetch_assoc($queryhvc);
        
        if ($rowhvc['category_id'] == 4) {
?>
                                <div class="item <?php
            if ($firstp) {
                $firstp = false;
                echo 'active';
            }
?>">
                                    <div class="panel-body" style="background-image: url(<?php
            echo $rowh['image'];
?>); background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
                                        <center><img src="<?php
            echo $rowhvc['image'];
?>" width="90%" style="position: absolute; left: 7%; bottom: 13%;" /></center>
                                    </div>
                                    <div class="panel-footer">
                                        <a href="vehicle-upgrades.php#<?php
            echo $rowphv['id'];
?>" class="btn btn-success"><em class="fa fa-fw fa-arrow-circle-up"></em><span class="hidden-xs"><?php
            echo lang_key("upgrade");
?></span></a>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("speed");
?>: <span class="label label-primary"><?php
            echo $rowphv['speed'];
?></span>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("acceleration");
?>: <span class="label label-danger"><?php
            echo $rowphv['acceleration'];
?></span>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("stability");
?>: <span class="label label-warning"><?php
            echo $rowphv['stability'];
?></span> 

                                        <a href="?sell-id=<?php
            echo $rowphv['vehicle_id'];
?>" class="btn btn-danger pull-right"><em class="fa fa-fw fa-dollar-sign"></em><span class="hidden-xs"><?php
            echo lang_key("sell");
?></span></a>
                                    </div>
                                </div>
<?php
        }
    }
?>

                            </div>

                            <a class="left carousel-control" href="#planes" role="button" data-slide="prev" style="height: 90%;">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            </a>
                            <a class="right carousel-control" href="#planes" role="button" data-slide="next" style="height: 90%;">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            </a>
<?php
    if ($counterhv == 0) {
?>
    <div class="panel-body" style="background-image: url(<?php
        echo $rowh['image'];
?>); background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
        <div class="alert alert-info"><strong><i class="fa fa-info-circle"></i> <?php
        echo lang_key("yno-planes");
?></strong></div>
        <br /><br /><br /><br /><br /><br /><center><a href="vehicles.php" class="btn btn-primary btn-md"><i class="fa fa-plane"></i>&nbsp;&nbsp;Buy a Plane</a></center>
    </div>
<?php
    }
?>
                        </div>
                    </div>
<?php
} else {
    echo '<div class="alert alert-info"><center><a href="hangar-upgrades.php" class="btn btn-info btn-md btn-block"><i class="fa fa-plane"></i>&nbsp;&nbsp;' . lang_key("buy-hangar") . '</a></center></div>';
}
?>

<?php
$quay_id = $rowu['quay_id'];
$queryq  = mysqli_query($connect, "SELECT * FROM `quays` WHERE id='$quay_id' LIMIT 1");
$countq  = mysqli_num_rows($queryq);
$rowq    = mysqli_fetch_assoc($queryq);
if ($countq > 0) {
?>
                    <div class="panel panel-primary">   
                        <div class="panel-heading">
                            <div class="btn-group btn-group-xs pull-right">
                                <a href="quay-upgrades.php" class="btn btn-success"><em class="fa fa-fw fa-arrow-circle-up"></em><span class="hidden-xs"><?php
    echo lang_key("quay-upgrades");
?></span></a>
                            </div>
                            <h3 class="panel-title"><i class="fa fa-ship"></i> <?php
    echo lang_key("your-quay");
?></h3>
                        </div>
<?php
    $counterqv = 0;
    $querypvq  = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id='$player_id'");
    while ($rowpvq = mysqli_fetch_assoc($querypvq)) {
        
        $vehicle_id = $rowpvq['vehicle_id'];
        $queryqv    = mysqli_query($connect, "SELECT * FROM `vehicles` WHERE id='$vehicle_id' AND category_id='5' LIMIT 1");
        $countqv    = mysqli_num_rows($queryqv);
        
        if ($countqv > 0) {
            $counterqv = $counterqv + 1;
        }
        
    }
?>
                        <div id="boats" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" role="listbox">
<?php
    $firstq   = true;
    $querypqv = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id='$player_id' ORDER BY speed DESC");
    while ($rowpqv = mysqli_fetch_assoc($querypqv)) {
        
        $qvehicle_id = $rowpqv['vehicle_id'];
        $queryqvc    = mysqli_query($connect, "SELECT * FROM `vehicles` WHERE id='$qvehicle_id'");
        $rowqvc      = mysqli_fetch_assoc($queryqvc);
        
        if ($rowqvc['category_id'] == 5) {
?>
                                <div class="item <?php
            if ($firstq) {
                $firstq = false;
                echo 'active';
            }
?>">
                                    <div class="panel-body" style="background-image: url(<?php
            echo $rowq['image'];
?>); background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
                                        <center><img src="<?php
            echo $rowqvc['image'];
?>" width="70%" style="position: absolute; left: 15%; bottom: 20%;" /></center>
                                    </div>
                                    <div class="panel-footer">
                                        <a href="vehicle-upgrades.php#<?php
            echo $rowpqv['id'];
?>" class="btn btn-success"><em class="fa fa-fw fa-arrow-circle-up"></em><span class="hidden-xs"><?php
            echo lang_key("upgrade");
?></span></a>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("speed");
?>: <span class="label label-primary"><?php
            echo $rowpqv['speed'];
?></span>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("acceleration");
?>: <span class="label label-danger"><?php
            echo $rowpqv['acceleration'];
?></span>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("stability");
?>: <span class="label label-warning"><?php
            echo $rowpqv['stability'];
?></span> 

                                        <a href="?sell-id=<?php
            echo $rowpqv['vehicle_id'];
?>" class="btn btn-danger pull-right"><em class="fa fa-fw fa-dollar-sign"></em><span class="hidden-xs"><?php
            echo lang_key("sell");
?></span></a>
                                    </div>
                                </div>
<?php
        }
    }
?>

                            </div>

                            <a class="left carousel-control" href="#boats" role="button" data-slide="prev" style="height: 90%;">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            </a>
                            <a class="right carousel-control" href="#boats" role="button" data-slide="next" style="height: 90%;">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            </a>
<?php
    if ($counterqv == 0) {
?>
    <div class="panel-body" style="background-image: url(<?php
        echo $rowq['image'];
?>); background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
        <div class="alert alert-info"><strong><i class="fa fa-info-circle"></i> <?php
        echo lang_key("yno-boats");
?></strong></div>
        <br /><br /><br /><br /><br /><br /><center><a href="vehicles.php" class="btn btn-primary btn-md"><i class="fa fa-ship"></i>&nbsp;&nbsp;<?php
        echo lang_key("buy-boat");
?></a></center>
    </div>
<?php
    }
?>
                        </div>
                    </div>
<?php
} else {
    echo '<div class="alert alert-warning"><center><a href="quay-upgrades.php" class="btn btn-warning btn-md btn-block"><i class="fa fa-ship"></i>&nbsp;&nbsp;' . lang_key("buy-quay") . '</a></center></div>';
}
?>

                </div>
            </div>

        </div>
<?php
footer();
?>