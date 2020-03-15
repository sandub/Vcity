<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['buyhangar-id'])) {
    
    $buyhangar_id = (int) $_GET['buyhangar-id'];
    
    $queryhc = mysqli_query($connect, "SELECT * FROM `hangars` WHERE id = '$buyhangar_id' LIMIT 1");
    $counthc = mysqli_num_rows($queryhc);
    if ($counthc > 0) {
        $rowhc = mysqli_fetch_assoc($queryhc);
        
        if ($rowu['hangar_id'] == $buyhangar_id) {
            $owned = 'Yes';
        } else {
            $owned = 'No';
        }
        
        $money   = $rowhc['money'];
        $gold    = $rowhc['gold'];
        $respect = $rowhc['respect'];
        
        if ($rowu['money'] >= $rowhc['money'] && $rowu['gold'] >= $rowhc['gold'] && $rowu['level'] >= $rowhc['min_level'] && $owned == 'No') {
            
            $hangar_upgrade = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', hangar_id = $buyhangar_id WHERE id='$player_id'");
            
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#hangar-upgrade").modal(\'show\');
            });
        </script>

        <div id="hangar-upgrade" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("hangar-up") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-info">' . lang_key("success-uphangar") . '</span></h3><br /><br />
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="images/icons/money.png" width="45%"><br />
                                    <h2>' . lang_key("money") . ': <br /><hr /><span class="label label-default">- ' . $money . '</span></h2>
                                </div>
                                <div class="col-md-4">
                                    <img src="images/icons/gold1.png" width="45%"><br />
                                    <h2>' . lang_key("gold") . ': <br /><hr /><span class="label label-default">- ' . $gold . '</span></h2>
                                </div>
                                <div class="col-md-4">
                                    <img src="images/icons/respect.png" width="45%"><br />
                                    <h2>' . lang_key("respect") . ': <br /><hr /><span class="label label-default">+ ' . $respect . '</span></h2>
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
echo lang_key("hangar-upgrades");
?></h2></center><br />

<?php
$queryhu = mysqli_query($connect, "SELECT * FROM hangars ORDER BY money ASC");
while ($rowhu = mysqli_fetch_assoc($queryhu)) {
?>
    <div class="row">
        <div class="col-md-4">
		    <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-plane"></i> <?php
    echo lang_key("hangar");
?> #<?php
    echo $rowhu['id'];
?> <?php
    if ($rowhu['vip'] == 'Yes') {
        echo '<span class="label label-warning pull-right"><i class="fa fa-star" aria-hidden="true"></i>  ' . lang_key("vip-only") . '</span>';
    }
?></h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="badge badge-primary">- <?php
    echo $rowhu['money'];
?></span>
                            <i class="fa fa-dollar-sign"></i>&nbsp;&nbsp; <?php
    echo lang_key("money");
?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-warning">- <?php
    echo $rowhu['gold'];
?></span>
                            <i class="fa fa-inbox"></i>&nbsp;&nbsp; <?php
    echo lang_key("gold");
?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-info"><?php
    echo $rowhu['min_level'];
?></span>
                            <i class="fa fa-server"></i>&nbsp;&nbsp; <?php
    echo lang_key("min-level");
?>
                        </li>
						<li class="list-group-item">
                            <span class="badge badge-success">+ <?php
    echo $rowhu['respect'];
?></span>
                            <i class="fa fa-star"></i>&nbsp;&nbsp; <?php
    echo lang_key("respect");
?>
                        </li>
						<li class="list-group-item">
                            <span class="badge badge-danger"><?php
    echo $rowhu['max_vehicles'];
?></span>
                            <i class="fa fa-plane"></i>&nbsp;&nbsp; <?php
    echo lang_key("max-vehicles");
?>
                        </li>
                    </ul>
<?php
    if ($rowu['hangar_id'] == $rowhu['id']) {
        echo '<button class="btn btn-primary btn-md btn-block" disabled><em class="fa fa-fw fa-check"></em>' . lang_key("owned") . '</button>';
    } else if ($rowu['money'] < $rowhu['money'] || $rowu['gold'] < $rowhu['gold'] || $rowu['level'] < $rowhu['min_level'] || $rowhu['vip'] == 'Yes' && $rowu['role'] != 'VIP') {
        echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-dollar-sign"></em>' . lang_key("buy") . '</button>';
    } else {
        echo '<a href="?buyhangar-id=' . $rowhu['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-dollar-sign"></i> ' . lang_key("buy") . '</a>';
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
    echo $rowhu['image'];
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