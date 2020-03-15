<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu  = mysqli_fetch_assoc($suser);

if (isset($_GET['buy-id'])) {
    
    $vehicle_id = (int) $_GET['buy-id'];
    $player_id  = $rowu['id'];
    
    $queryvs = mysqli_query($connect, "SELECT * FROM `vehicles` WHERE id = '$vehicle_id' LIMIT 1");
    $countvs = mysqli_num_rows($queryvs);
    if ($countvs > 0) {
        $rowvs = mysqli_fetch_assoc($queryvs);
        
        $money        = $rowvs['money'];
        $gold         = $rowvs['gold'];
        $respect      = $rowvs['respect'];
        $speed        = $rowvs['speed'];
        $acceleration = $rowvs['acceleration'];
        $stability    = $rowvs['stability'];
        
        $owned = 'No';
        if ($rowvs['category_id'] != 4 AND $rowvs['category_id'] != 5) {
            $garage_id = $rowu['garage_id'];
            
            $queryfs = mysqli_query($connect, "SELECT * FROM `garages` WHERE id='$garage_id' LIMIT 1");
            $rowfs   = mysqli_fetch_assoc($queryfs);
            
            $pvehicles = 0;
            $querypv   = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id = '$player_id'");
            while ($rowpv = mysqli_fetch_assoc($querypv)) {
                $vh_id    = $rowpv['vehicle_id'];
                $queryvcc = mysqli_query($connect, "SELECT category_id FROM `vehicles` WHERE id='$vh_id' LIMIT 1");
                $rowvcc   = mysqli_fetch_assoc($queryvcc);
                if ($rowvcc['category_id'] != 4 AND $rowvcc['category_id'] != 5) {
                    $pvehicles = $pvehicles + 1;
                }
                
                if ($vehicle_id == $vh_id) {
                    $owned = 'Yes';
                }
            }
            
        }
        if ($rowvs['category_id'] == 4) {
            $hangar_id = $rowu['hangar_id'];
            
            $queryfs = mysqli_query($connect, "SELECT * FROM `hangars` WHERE id='$hangar_id' LIMIT 1");
            $rowfs   = mysqli_fetch_assoc($queryfs);
            
            $pvehicles = 0;
            $querypv   = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id = '$player_id'");
            while ($rowpv = mysqli_fetch_assoc($querypv)) {
                $vh_id    = $rowpv['vehicle_id'];
                $queryvcc = mysqli_query($connect, "SELECT category_id FROM `vehicles` WHERE id='$vh_id' LIMIT 1");
                $rowvcc   = mysqli_fetch_assoc($queryvcc);
                if ($rowvcc['category_id'] == 5) {
                    $pvehicles = $pvehicles + 1;
                }
                
                if ($vehicle_id == $vh_id) {
                    $owned = 'Yes';
                }
            }
        }
        if ($rowvs['category_id'] == 5) {
            $quay_id = $rowu['quay_id'];
            
            $queryfs = mysqli_query($connect, "SELECT * FROM `quays` WHERE id='$quay_id' LIMIT 1");
            $rowfs   = mysqli_fetch_assoc($queryfs);
            
            $pvehicles = 0;
            $querypv   = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id = '$player_id'");
            while ($rowpv = mysqli_fetch_assoc($querypv)) {
                $vh_id    = $rowpv['vehicle_id'];
                $queryvcc = mysqli_query($connect, "SELECT category_id FROM `vehicles` WHERE id='$vh_id' LIMIT 1");
                $rowvcc   = mysqli_fetch_assoc($queryvcc);
                if ($rowvcc['category_id'] == 5) {
                    $pvehicles = $pvehicles + 1;
                }
                
                if ($vehicle_id == $vh_id) {
                    $owned = 'Yes';
                }
            }
        }
        
        $max_vehicles = $rowfs['max_vehicles'];
        $free_slots   = $max_vehicles - $pvehicles;
        
        if ($free_slots == 0) {
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#no-space").modal(\'show\');
            });
        </script>

        <div id="no-space" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Vehicle Showroom</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-danger">' . lang_key("vno-freeslots") . '</span></h3>
                            <img src="' . $rowvs['image'] . '" width="80%"><br />
                            <br /><br />
                            <button type="button" class="btn btn-primary btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fab fa-get-pocket"></i> ' . lang_key("okay") . '</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
        }
        
        if ($rowu['money'] >= $rowvs['money'] && $rowu['gold'] >= $rowvs['gold'] && $rowu['level'] >= $rowvs['min_level'] && $free_slots > 0 && $owned == 'No') {
            
            $vehicle_pay = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect' WHERE id='$player_id'");
            $vehicle_buy = mysqli_query($connect, "INSERT INTO `player_vehicles` (player_id, vehicle_id, speed, acceleration, stability)
VALUES ('$player_id', '$vehicle_id', '$speed', '$acceleration', '$stability')");
            
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#buy-vehicle").modal(\'show\');
            });
        </script>

        <div id="buy-vehicle" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("vehicle-showroom") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-info">' . lang_key("success-vpurchase") . '</span></h3>
                            <img src="' . $rowvs['image'] . '" width="80%"><br />
                            <br /><br />
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="images/icons/money.png" width="25%"><br />
                                    <h4>' . lang_key("money") . ': <br /><hr /><span class="label label-default">- ' . $money . '</span></h4>
                                </div>
                                <div class="col-md-4">
                                    <img src="images/icons/gold1.png" width="25%"><br />
                                    <h4>' . lang_key("gold") . ': <br /><hr /><span class="label label-default">- ' . $gold . '</span></h4>
                                </div>
                                <div class="col-md-4">
                                    <img src="images/icons/respect.png" width="25%"><br />
                                    <h4>' . lang_key("respect") . ': <br /><hr /><span class="label label-default">+ ' . $respect . '</span></h4>
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
<div class="panel with-nav-tabs panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">
                <h3 class="panel-title"><i class="fa fa-car"></i> <?php
echo lang_key("vehicles");
?></h3>
            </div>
            <div class="col-md-10">
                <span class="pull-right">
                    <ul class="nav nav-tabs">
<?php
$first    = true;
$queryvct = mysqli_query($connect, "SELECT * FROM `vehicle_categories`");
while ($rowvct = mysqli_fetch_assoc($queryvct)) {
?>
                        <li <?php
    if ($first) {
        echo 'class="active"';
        $first = false;
    }
?>><a href="#tab<?php
    echo $rowvct['id'];
?>" data-toggle="tab"><i class="fa <?php
    echo $rowvct['fa_icon'];
?>"></i> <?php
    echo $rowvct['category'];
?></a></li>
<?php
}
?>
                    </ul>
                </span>
            </div>
        </div>
    </div>

    <div class="tab-content">
<?php
$firstc  = true;
$queryvc = mysqli_query($connect, "SELECT * FROM `vehicle_categories`");
while ($rowvc = mysqli_fetch_assoc($queryvc)) {
    $category_id = $rowvc['id'];
?>
        <div id="tab<?php
    echo $rowvc['id'];
?>" class="tab-pane fade in <?php
    if ($firstc) {
        echo 'active';
        $firstc = false;
    }
?>">
            
    <div id="category<?php
    echo $rowvc['id'];
?>" class="carousel slide" data-interval="false" data-wrap="false">
        <div class="carousel-inner" role="listbox">

<?php
    $firstv = true;
    $queryv = mysqli_query($connect, "SELECT * FROM `vehicles` WHERE category_id='$category_id' AND active='Yes' ORDER BY min_level ASC, money ASC");
    $countv = mysqli_num_rows($queryv);
    if ($countv > 0) {
        while ($rowv = mysqli_fetch_assoc($queryv)) {
?>
            <div class="item <?php
            if ($firstv) {
                echo 'active';
                $firstv = false;
            }
?>">
                <div class="panel-body" 
<?php
            if ($rowv['category_id'] != 4 AND $rowv['category_id'] != 5) {
                echo 'style="background-image: url(images/backgrounds/showroom/1.jpg);  background-size: 100% 100%; background-repeat: no-repeat; height: auto;"';
            }
?>>
                    <center>
                        <img src="<?php
            echo $rowv['image'];
?>" <?php
            if ($rowv['category_id'] != 4 AND $rowv['category_id'] != 5) {
                echo 'width="45%"';
            } else {
                echo 'width="70%"';
            }
?>>
                    </center>
                </div>

                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-4">
                            <?php
            echo lang_key("speed");
?>: <span class="label label-primary"><?php
            echo $rowv['speed'];
?></span>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("acceleration");
?>: <span class="label label-danger"><?php
            echo $rowv['acceleration'];
?></span>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("stability");
?>: <span class="label label-warning"><?php
            echo $rowv['stability'];
?></span>
                        </div>
                        <div class="col-md-4">
                            <center>
<?php
            $vehicle_id = $rowv['id'];
            $player_id  = $rowu['id'];
            $querypvc   = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE vehicle_id='$vehicle_id' && id='$player_id' LIMIT 1");
            $countpvc   = mysqli_num_rows($querypvc);
            if ($countpvc > 0) {
                echo '<button class="btn btn-success btn-md btn-block" disabled><em class="fa fa-fw fa-check"></em> ' . lang_key("owned") . '</button>';
            } else if ($rowu['money'] < $rowv['money'] || $rowu['gold'] < $rowv['gold'] || $rowu['level'] < $rowv['min_level'] || $rowv['vip'] == 'Yes' && $rowu['role'] != 'VIP') {
                echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-dollar-sign"></em>' . lang_key("buy") . '</button>';
            } else {
                echo '<a href="?buy-id=' . $rowv['id'] . '" class="btn btn-success btn-md btn-block"><em class="fa fa-fw fa-dollar-sign"></em>' . lang_key("buy") . '</a>';
            }
?>
                            </center>
                        </div>
                        <div class="col-md-4">
                            <div class="pull-right"><i class="far fa-money-bill-alt"></i> <?php
            echo lang_key("money");
?> <span class="label label-success"><?php
            echo $rowv['money'];
?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-inbox"></i> <?php
            echo lang_key("gold");
?>: <span class="label label-warning"><?php
            echo $rowv['gold'];
?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-server"></i> <?php
            echo lang_key("required-level");
?>: <span class="label label-danger"><?php
            echo $rowv['min_level'];
?></span><?php
            if ($rowv['vip'] == 'Yes') {
                echo '&nbsp;&nbsp;&nbsp; <span class="label label-primary"><i class="fa fa-star"></i> ' . lang_key("vip-only") . '</span>';
            }
?></div>
                        </div>

                    </div>
                </div>
            </div>
<?php
        }
    } else {
        echo '<div class="panel-body">
        <center><div class="alert alert-info alert-dismissable"><strong><i class="fa fa-info-circle"></i> ' . lang_key("cno-vehicles") . '</strong></div></center>
      </div>';
    }
?>
            
            <a class="left carousel-control" href="#category<?php
    echo $rowvc['id'];
?>" role="button" data-slide="prev" style="height: 90%;">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only"><?php
    echo lang_key("previous");
?></span>
            </a>
            <a class="right carousel-control" href="#category<?php
    echo $rowvc['id'];
?>" role="button" data-slide="next" style="height: 90%;">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only"><?php
    echo lang_key("next");
?></span>
            </a>

        </div>
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