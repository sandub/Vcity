<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['buyquay-id'])) {
    
    $buyquay_id = (int) $_GET['buyquay-id'];
    
    $queryqc = mysqli_query($connect, "SELECT * FROM `quays` WHERE id = '$buyquay_id' LIMIT 1");
    $countqc = mysqli_num_rows($queryqc);
    if ($countqc > 0) {
        $rowqc = mysqli_fetch_assoc($queryqc);
        
        if ($rowu['quay_id'] == $buyquay_id) {
            $owned = 'Yes';
        } else {
            $owned = 'No';
        }
        
        $money   = $rowqc['money'];
        $gold    = $rowqc['gold'];
        $respect = $rowqc['respect'];
        
        if ($rowu['money'] >= $rowqc['money'] && $rowu['gold'] >= $rowqc['gold'] && $rowu['level'] >= $rowqc['min_level'] && $owned == 'No') {
            
            $quay_upgrade = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', quay_id = $buyquay_id WHERE id='$player_id'");
            
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#quay-upgrade").modal(\'show\');
            });
        </script>

        <div id="quay-upgrade" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("quay-up") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-info">' . lang_key("success-upquay") . '</span></h3><br /><br />
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
<div class="col-md-12 well">

    <center><h2><i class="fa fa-arrow-circle-up"></i> <?php
echo lang_key("quay-upgrades");
?></h2></center><br />

<?php
$queryqu = mysqli_query($connect, "SELECT * FROM quays ORDER BY money ASC");
while ($rowqu = mysqli_fetch_assoc($queryqu)) {
?>
    <div class="row">
        <div class="col-md-4">
		    <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-ship"></i> <?php
    echo lang_key("quay");
?> #<?php
    echo $rowqu['id'];
?> <?php
    if ($rowqu['vip'] == 'Yes') {
        echo '<span class="label label-warning pull-right"><i class="fa fa-star" aria-hidden="true"></i>  ' . lang_key("vip-only") . '</span>';
    }
?></h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="badge badge-primary">- <?php
    echo $rowqu['money'];
?></span>
                            <i class="fa fa-dollar-sign"></i>&nbsp;&nbsp; <?php
    echo lang_key("money");
?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-warning">- <?php
    echo $rowqu['gold'];
?></span>
                            <i class="fa fa-inbox"></i>&nbsp;&nbsp; <?php
    echo lang_key("gold");
?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-info"><?php
    echo $rowqu['min_level'];
?></span>
                            <i class="fa fa-server"></i>&nbsp;&nbsp; <?php
    echo lang_key("min-level");
?>
                        </li>
						<li class="list-group-item">
                            <span class="badge badge-success">+ <?php
    echo $rowqu['respect'];
?></span>
                            <i class="fa fa-star"></i>&nbsp;&nbsp; <?php
    echo lang_key("respect");
?>
                        </li>
						<li class="list-group-item">
                            <span class="badge badge-danger"><?php
    echo $rowqu['max_vehicles'];
?></span>
                            <i class="fa fa-plane"></i>&nbsp;&nbsp; <?php
    echo lang_key("max-vehicles");
?>
                        </li>
                    </ul>
<?php
    if ($rowu['quay_id'] == $rowqu['id']) {
        echo '<button class="btn btn-primary btn-md btn-block" disabled><em class="fa fa-fw fa-check"></em>' . lang_key("owned") . '</button>';
    } else if ($rowu['money'] < $rowqu['money'] || $rowu['gold'] < $rowqu['gold'] || $rowu['level'] < $rowqu['min_level'] || $rowqu['vip'] == 'Yes' && $rowu['role'] != 'VIP') {
        echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-dollar-sign"></em>' . lang_key("buy") . '</button>';
    } else {
        echo '<a href="?buyquay-id=' . $rowqu['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-dollar-sign"></i> ' . lang_key("buy") . '</a>';
    }
?>
					
                </div>
            </div>
		</div>
		
		<div class="col-md-8">
		    <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-eye"></i> <?php
    echo lang_key("preview");
?></h3>
                </div>
<div class="panel-body" style="background-image: url(<?php
    echo $rowqu['image'];
?>);  background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
                
                </div>
            </div>
		</div>
    </div>
<?php
}
?>
</div>
<?php
footer();
?>