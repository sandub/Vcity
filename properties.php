<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['buy-id'])) {
    
    $property_id = (int) $_GET['buy-id'];
    
    $queryps = mysqli_query($connect, "SELECT * FROM `properties` WHERE id = '$property_id' LIMIT 1");
    $countps = mysqli_num_rows($queryps);
    if ($countps > 0) {
        $rowps = mysqli_fetch_assoc($queryps);
        
        $querypuc = mysqli_query($connect, "SELECT * FROM `player_properties` WHERE property_id = '$property_id' AND player_id='$player_id' LIMIT 1");
        $countpuc = mysqli_num_rows($querypuc);
        if ($countpuc > 0) {
            $owned = 'Yes';
        } else {
            $owned = 'No';
        }
        
        $money   = $rowps['money'];
        $gold    = $rowps['gold'];
        $respect = $rowps['respect'];
        
        if ($rowps['format'] == "Hours") {
            $profittime = time() + ($rowps['time'] * 3600);
        }
        if ($rowps['format'] == "Minutes") {
            $profittime = time() + ($rowps['time'] * 60);
        }
        
        if ($rowu['money'] >= $rowps['money'] && $rowu['gold'] >= $rowps['gold'] && $rowu['level'] >= $rowps['min_level'] && $owned == 'No') {
            
            $property_pay = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect' WHERE id='$player_id'");
            $property_buy = mysqli_query($connect, "INSERT INTO `player_properties` (player_id, property_id, profittime)
VALUES ('$player_id', '$property_id', '$profittime')");
            
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#buy-property").modal(\'show\');
            });
        </script>

        <div id="buy-property" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("buying-property") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-info">' . lang_key("success-ppurchase") . '</span></h3><br /><br />
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="images/icons/money.png" width="30%"><br />
                                    <h4>' . lang_key("money") . ': <br /><hr /><span class="label label-default">- ' . $money . '</span></h4>
                                </div>
                                <div class="col-md-4">
                                    <img src="images/icons/gold1.png" width="30%"><br />
                                    <h4>' . lang_key("gold") . ': <br /><hr /><span class="label label-default">- ' . $gold . '</span></h4>
                                </div>
                                <div class="col-md-4">
                                    <img src="images/icons/respect.png" width="30%"><br />
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

if (isset($_GET['take-profit'])) {
    
    $property_id = (int) $_GET['take-profit'];
    
    $queryps = mysqli_query($connect, "SELECT * FROM `properties` WHERE id = '$property_id' LIMIT 1");
    $countps = mysqli_num_rows($queryps);
    if ($countps > 0) {
        $rowps = mysqli_fetch_assoc($queryps);
        
        $querypuc = mysqli_query($connect, "SELECT * FROM `player_properties` WHERE property_id = '$property_id' AND player_id='$player_id' LIMIT 1");
        $countpuc = mysqli_num_rows($querypuc);
        $rowpuc   = mysqli_fetch_assoc($querypuc);
        if ($countpuc > 0) {
            $owned = 'Yes';
        } else {
            $owned = 'No';
        }
        
        $income = $rowps['income'];
        
        if ($rowps['format'] == "Hours") {
            $profittime = time() + ($rowps['time'] * 3600);
        }
        if ($rowps['format'] == "Minutes") {
            $profittime = time() + ($rowps['time'] * 60);
        }
        
        if ($owned == 'Yes' && time() >= $rowpuc['profittime']) {
            
            $profit_pay = mysqli_query($connect, "UPDATE `players` SET money=money+'$income' WHERE id='$player_id'");
            $new_pay    = mysqli_query($connect, "UPDATE `player_properties` SET profittime='$profittime' WHERE property_id='$property_id' AND player_id='$player_id'");
            
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#property-profit").modal(\'show\');
            });
        </script>

        <div id="property-profit" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("property-profit") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <img src="' . $rowps['image'] . '" width="80%"><br />
                                </div>                               
                                <div class="col-md-2"></div>
                            </div><br /><br />
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="images/icons/money.png" width="10%"><br />
                                    <h4>' . lang_key("money") . ': <br /><hr /><span class="label label-default">+ ' . $income . '</span></h4>
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
<div class="col-md-12 well">

    <center><h2><i class="fa fa-building"></i> <?php
echo lang_key("properties");
?></h2></center><br />

    <div class="row">
<?php
$querypb = mysqli_query($connect, "SELECT * FROM `properties` ORDER BY min_level ASC");
while ($rowpb = mysqli_fetch_assoc($querypb)) {
    
    $property_id = $rowpb['id'];
    $querypbc    = mysqli_query($connect, "SELECT * FROM `player_properties` WHERE property_id='$property_id' AND player_id='$player_id' LIMIT 1");
    $rowpbc      = mysqli_fetch_assoc($querypbc);
    $countpbc    = mysqli_num_rows($querypbc);
?>
        <div class="col-md-6">
            <center>
                <ul class="breadcrumb"><li class="active"><h4><?php
    echo $rowpb['property'];
?></h4></li></ul>
            </center>
            <div class="row">
                <div class="col-md-8">
                    <center><img src="<?php
    echo $rowpb['image'];
?>" width="60%"></center>
                </div>
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item active">
                            <center><?php
    echo lang_key("property-details");
?></center>
                        </li>
                        <li class="list-group-item"><span class="badge badge-success"><?php
    echo $rowpb['money'];
?></span><i class="far fa-money-bill-alt"></i> <?php
    echo lang_key("money");
?></li>
                        <li class="list-group-item"><span class="badge badge-warning"><?php
    echo $rowpb['gold'];
?></span><i class="fa fa-inbox"></i> <?php
    echo lang_key("gold");
?></li>
                        <li class="list-group-item"><span class="badge badge-info"><?php
    echo $rowpb['min_level'];
?></span><i class="fa fa-server"></i> <?php
    echo lang_key("required-level");
?></li>
                        <li class="list-group-item"><span class="badge badge-danger"><?php
    echo $rowpb['income'];
?></span><i class="fa fa-dollar-sign"></i> <?php
    echo lang_key("income");
?> (<?php
    echo lang_key("money");
?>)</li>
                        <li class="list-group-item"><span class="badge badge-primary"><?php
    echo lang_key("every");
?> <?php
    echo $rowpb['time'];
?> <?php
    echo $rowpb['format'];
?></span><i class="fas fa-clock"></i> <?php
    echo lang_key("income-period");
?></li>
                       <li class="list-group-item"><span class="badge badge-warning"><?php
    echo $rowpb['vip'];
?></span><i class="fa fa-star"></i> <?php
    echo lang_key("vip-only");
?></li>
                    </ul>
<?php
    if ($countpbc > 0 && time() >= $rowpbc['profittime']) {
        echo '<a href="?take-profit=' . $rowpb['id'] . '"class="btn btn-warning btn-md btn-block"><em class="fa fa-fw fa-check"></em> ' . lang_key("take-profit") . '</a>';
    } else if ($countpbc > 0 && time() < $rowpbc['profittime']) {
        $timeleft = secondsToWords($rowpbc['profittime'] - time());
        
        echo '<button class="btn btn-warning btn-md btn-block disabled"><em class="fas fa-fw fa-clock"></em> ' . $timeleft . '</button>';
    } else if ($rowu['money'] < $rowpb['money'] || $rowu['gold'] < $rowpb['gold'] || $rowu['level'] < $rowpb['min_level'] || $rowpb['vip'] == 'Yes' && $rowu['role'] != 'VIP') {
        echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-dollar-sign"></em>' . lang_key("buy") . '</button>';
    } else {
        echo '<a href="?buy-id=' . $rowpb['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-dollar-sign"></i> ' . lang_key("buy") . '</a>';
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
footer();
?>