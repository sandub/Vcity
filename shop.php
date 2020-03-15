<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['buy-id'])) {
    
    $item_id = (int) $_GET['buy-id'];
    
    $queryis = mysqli_query($connect, "SELECT * FROM `items` WHERE id = '$item_id' LIMIT 1");
    $countis = mysqli_num_rows($queryis);
    if ($countis > 0) {
        $rowis = mysqli_fetch_assoc($queryis);
        
        $querypicc = mysqli_query($connect, "SELECT * FROM `player_items` WHERE item_id = '$item_id' AND player_id='$player_id' LIMIT 1");
        $countpicc = mysqli_num_rows($querypicc);
        if ($countpicc > 0) {
            $owned = 'Yes';
        } else {
            $owned = 'No';
        }
        
        $money      = $rowis['money'];
        $gold       = $rowis['gold'];
        $respect    = $rowis['respect'];
        $bonustype  = $rowis['bonustype'];
        $bonusvalue = $rowis['bonusvalue'];
        
        if ($rowu['money'] >= $rowis['money'] && $rowu['gold'] >= $rowis['gold'] && $rowu['level'] >= $rowis['min_level'] && $owned == 'No') {
            
            if ($bonustype == 'power') {
                $item_pay = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', power=power+'$bonusvalue' WHERE id='$player_id'");
            }
            if ($bonustype == 'agility') {
                $item_pay = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', agility=agility+'$bonusvalue' WHERE id='$player_id'");
            }
            if ($bonustype == 'endurance') {
                $item_pay = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', endurance=endurance+'$bonusvalue' WHERE id='$player_id'");
            }
            if ($bonustype == 'intelligence') {
                $item_pay = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', intelligence=intelligence+'$bonusvalue' WHERE id='$player_id'");
            }
            if ($bonustype == 'energy') {
                $item_pay = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', energy=energy+'$bonusvalue' WHERE id='$player_id'");
            }
            if ($bonustype == 'health') {
                $item_pay = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', health=health+'$bonusvalue' WHERE id='$player_id'");
            }
            
            if ($bonustype != 'energy' && $bonustype != 'health') {
                $item_buy = mysqli_query($connect, "INSERT INTO `player_items` (player_id, item_id)
VALUES ('$player_id', '$item_id')");
            }
            
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#buy-item").modal(\'show\');
            });
        </script>

        <div id="buy-item" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . $rowis['item'] . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-info">' . lang_key("item-spurchase") . '</span></h3><br /><br />
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <img src="' . $rowis['image'] . '" width="45%"><br />
                                    <h4>' . ucfirst($bonustype) . ': <br /><hr /><span class="label label-default">+ ' . $bonusvalue . '</span></h4>
                                </div>                               
                                <div class="col-md-2"></div>
                            </div><br /><br />
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

if (isset($_GET['sell-id'])) {
    $itemfs_id = (int) $_GET["sell-id"];
    
    $queryspi = mysqli_query($connect, "SELECT * FROM `player_items` WHERE item_id='$itemfs_id' and player_id='$player_id' LIMIT 1");
    $countspi = mysqli_num_rows($queryspi);
    
    if ($countspi > 0) {
        
        $queryifsc = mysqli_query($connect, "SELECT * FROM `items` WHERE id='$itemfs_id' LIMIT 1");
        $rowifsc   = mysqli_fetch_assoc($queryifsc);
        
        $money_back  = $rowifsc['money'] / 2;
        $gold_back   = $rowifsc['gold'] / 2;
        $bonustypeg  = $rowifsc['bonustype'];
        $bonusvalueg = $rowifsc['bonusvalue'];
        
        $sell_item = mysqli_query($connect, "DELETE FROM `player_items` WHERE item_id='$itemfs_id' AND player_id='$player_id'");
        
        if ($bonustypeg == 'power') {
            $values_back = mysqli_query($connect, "UPDATE `players` SET money=money+'$money_back', gold=gold+'$gold_back', power=power-'$bonusvalueg' WHERE id='$player_id'");
        }
        if ($bonustypeg == 'agility') {
            $values_back = mysqli_query($connect, "UPDATE `players` SET money=money+'$money_back', gold=gold+'$gold_back', agility=agility-'$bonusvalueg' WHERE id='$player_id'");
        }
        if ($bonustypeg == 'endurance') {
            $values_back = mysqli_query($connect, "UPDATE `players` SET money=money+'$money_back', gold=gold+'$gold_back', endurance=endurance-'$bonusvalueg' WHERE id='$player_id'");
        }
        if ($bonustypeg == 'intelligence') {
            $values_back = mysqli_query($connect, "UPDATE `players` SET money=money+'$money_back', gold=gold+'$gold_back', intelligence=intelligence-'$bonusvalueg' WHERE id='$player_id'");
        }
        if ($bonustypeg == 'energy') {
            $values_back = mysqli_query($connect, "UPDATE `players` SET money=money+'$money_back', gold=gold+'$gold_back', energy=energy-'$bonusvalueg' WHERE id='$player_id'");
        }
        if ($bonustypeg == 'health') {
            $values_back = mysqli_query($connect, "UPDATE `players` SET money=money+'$money_back', gold=gold+'$gold_back', health=health-'$bonusvalueg' WHERE id='$player_id'");
        }
        
        echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#sell-item").modal(\'show\');
            });
        </script>

        <div id="sell-item" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . $rowifsc['item'] . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-info">' . lang_key("item-ssold") . '</span></h3><br /><br />
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <img src="' . $rowifsc['image'] . '" width="45%"><br />
                                    <h4>' . ucfirst($bonustypeg) . ': <br /><hr /><span class="label label-default">- ' . $bonusvalueg . '</span></h4>
                                </div>                               
                                <div class="col-md-2"></div>
                            </div><br /><br />
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="images/icons/money.png" width="20%"><br />
                                    <h4>' . lang_key("money") . ': <br /><hr /><span class="label label-default">+ ' . $money_back . '</span></h4>
                                </div>
                                <div class="col-md-6">
                                    <img src="images/icons/gold1.png" width="20%"><br />
                                    <h4>' . lang_key("gold") . ': <br /><hr /><span class="label label-default">+ ' . $gold_back . '</span></h4>
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
?>
        <div class="col-md-12 well">
            
            <center><h2><i class="fa fa-shopping-cart"></i> <?php
echo lang_key("shop");
?></h2></center><br />
            
                <ul class="nav nav-tabs nav-justified">
<?php
$first   = true;
$queryic = mysqli_query($connect, "SELECT * FROM `item_categories`");
while ($rowic = mysqli_fetch_assoc($queryic)) {
?>
                    <li <?php
    if ($first) {
        echo 'class="active"';
        $first = false;
    }
?></l><a data-toggle="tab" href="#<?php
    echo $rowic['id'];
?>"><i class="fa <?php
    echo $rowic['fa_icon'];
?>"></i> <?php
    echo $rowic['category'];
?></a></li>
<?php
}
?>
                </ul>

                <div class="tab-content">
<?php
$firsta   = true;
$queryicc = mysqli_query($connect, "SELECT * FROM `item_categories`");
while ($rowicc = mysqli_fetch_assoc($queryicc)) {
    $category_id = $rowicc['id'];
?>
                        <div id="<?php
    echo $category_id;
?>" class="tab-pane fade in <?php
    if ($firsta) {
        echo 'active';
        $firsta = false;
    }
?>">
                    <br />
                    <div class="row">
<?php
    $queryi = mysqli_query($connect, "SELECT * FROM `items` WHERE category_id = '$category_id'");
    while ($rowi = mysqli_fetch_assoc($queryi)) {
        
        $item_id  = $rowi['id'];
        $querypic = mysqli_query($connect, "SELECT * FROM `player_items` WHERE item_id='$item_id' AND player_id='$player_id' LIMIT 1");
        $rowpic   = mysqli_fetch_assoc($querypic);
        $countpic = mysqli_num_rows($querypic);
?>
        <div class="col-md-4">
            <center>
                <ul class="breadcrumb"><li class="active"><h4><?php
        echo $rowi['item'];
?> <?php
        if ($rowi['bonustype'] == 'health' || $rowi['bonustype'] == 'energy') {
            echo '<span class="label label-primary">' . lang_key("single-use") . '</span>';
        }
?> <?php
        if ($rowi['vip'] == 'Yes') {
            echo '<span class="label label-warning">' . lang_key("vip-only") . '</span>';
        }
?></h4></li></ul>
            </center>
            <div class="row">
                <div class="col-md-7">
                    <center><img src="<?php
        echo $rowi['image'];
?>" width="85%"></center>
                </div>
                <div class="col-md-5">
                    <ul class="list-group">
                        <li class="list-group-item active">
                            <center><?php
        echo lang_key("item-details");
?></center>
                        </li>
                        <li class="list-group-item"><span class="badge badge-success"><?php
        echo $rowi['money'];
?></span><i class="far fa-money-bill-alt"></i> <?php
        echo lang_key("money");
?></li>
                        <li class="list-group-item"><span class="badge badge-warning"><?php
        echo $rowi['gold'];
?></span><i class="fa fa-inbox"></i> <?php
        echo lang_key("gold");
?></li>
                        <li class="list-group-item"><span class="badge badge-info"><?php
        echo $rowi['min_level'];
?></span><i class="fa fa-server"></i> <?php
        echo lang_key("required-level");
?></li>
                        <li class="list-group-item"><span class="badge badge-danger">+ <?php
        echo $rowi['bonusvalue'];
?></span><?php
        echo ucfirst($rowi['bonustype']);
?></li>
                    </ul>
<?php
        if ($countpic > 0) {
            echo '<a href="?sell-id=' . $rowi['id'] . '"class="btn btn-danger btn-md btn-block"><em class="fa fa-fw fa-dollar-sign"></em> ' . lang_key("sell") . '</a>';
        } else if ($rowu['money'] < $rowi['money'] || $rowu['gold'] < $rowi['gold'] || $rowu['level'] < $rowi['min_level'] || $rowi['vip'] == 'Yes' && $rowu['role'] != 'VIP') {
            if ($rowi['bonustype'] == 'health' || $rowi['bonustype'] == 'energy') {
                echo '<button class="btn btn-warning btn-md btn-block" disabled><em class="fa fa-fw fa-cart-arrow-down"></em>' . lang_key("buy-use") . '</button>';
            } else {
                echo '<button class="btn btn-warning btn-md btn-block" disabled><em class="fa fa-fw fa-cart-arrow-down"></em>' . lang_key("buy") . '</button>';
            }
        } else {
            if ($rowi['bonustype'] == 'health' || $rowi['bonustype'] == 'energy') {
                echo '<a href="?buy-id=' . $rowi['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-cart-arrow-down"></i> ' . lang_key("buy-use") . '</a>';
            } else {
                echo '<a href="?buy-id=' . $rowi['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-cart-arrow-down"></i> ' . lang_key("buy") . '</a>';
            }
        }
?>
                </div>
            </div>
            <hr />
        </div>
<?php
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