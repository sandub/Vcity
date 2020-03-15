<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['buygarage-id'])) {
    
    $buygarage_id = (int) $_GET['buygarage-id'];
    
    $querygc = mysqli_query($connect, "SELECT * FROM `garages` WHERE id = '$buygarage_id' LIMIT 1");
    $countgc = mysqli_num_rows($querygc);
    if ($countgc > 0) {
        $rowgc = mysqli_fetch_assoc($querygc);
        
        if ($rowu['garage_id'] == $buygarage_id) {
            $owned = 'Yes';
        } else {
            $owned = 'No';
        }
        
        $money   = $rowgc['money'];
        $gold    = $rowgc['gold'];
        $respect = $rowgc['respect'];
        
        if ($rowu['money'] >= $rowgc['money'] && $rowu['gold'] >= $rowgc['gold'] && $rowu['level'] >= $rowgc['min_level'] && $owned == 'No') {
            
            $garage_upgrade = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', garage_id = $buygarage_id WHERE id='$player_id'");
            
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#garage-upgrade").modal(\'show\');
            });
        </script>

        <div id="garage-upgrade" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("garage-up") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-info">' . lang_key("success-upgarage") . '</span></h3><br /><br />
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
echo lang_key("garage-upgrades");
?></h2></center><br />

<?php
$querygu = mysqli_query($connect, "SELECT * FROM garages ORDER BY money ASC");
while ($rowgu = mysqli_fetch_assoc($querygu)) {
?>
    <div class="row">
        <div class="col-md-4">
		    <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-car"></i> <?php
    echo lang_key("garage");
?> #<?php
    echo $rowgu['id'];
?> <?php
    if ($rowgu['vip'] == 'Yes') {
        echo '<span class="label label-warning pull-right"><i class="fa fa-star" aria-hidden="true"></i>  ' . lang_key("vip-only") . '</span>';
    }
?></h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="badge badge-primary">- <?php
    echo $rowgu['money'];
?></span>
                            <i class="fa fa-dollar-sign"></i>&nbsp;&nbsp; <?php
    echo lang_key("money");
?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-warning">- <?php
    echo $rowgu['gold'];
?></span>
                            <i class="fa fa-inbox"></i>&nbsp;&nbsp; <?php
    echo lang_key("gold");
?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-info"><?php
    echo $rowgu['min_level'];
?></span>
                            <i class="fa fa-server"></i>&nbsp;&nbsp; <?php
    echo lang_key("min-level");
?>
                        </li>
						<li class="list-group-item">
                            <span class="badge badge-success">+ <?php
    echo $rowgu['respect'];
?></span>
                            <i class="fa fa-star"></i>&nbsp;&nbsp; <?php
    echo lang_key("respect");
?>
                        </li>
						<li class="list-group-item">
                            <span class="badge badge-danger"><?php
    echo $rowgu['max_vehicles'];
?></span>
                            <i class="fa fa-car"></i>&nbsp;&nbsp; <?php
    echo lang_key("max-vehicles");
?>
                        </li>
                    </ul>
<?php
    if ($rowu['garage_id'] == $rowgu['id']) {
        echo '<button class="btn btn-primary btn-md btn-block" disabled><em class="fa fa-fw fa-check"></em>' . lang_key("owned") . '</button>';
    } else if ($rowu['money'] < $rowgu['money'] || $rowu['gold'] < $rowgu['gold'] || $rowu['level'] < $rowgu['min_level'] || $rowgu['vip'] == 'Yes' && $rowu['role'] != 'VIP') {
        echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-dollar-sign"></em>' . lang_key("buy") . '</button>';
    } else {
        echo '<a href="?buygarage-id=' . $rowgu['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-dollar-sign"></i> ' . lang_key("buy") . '</a>';
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
    echo $rowgu['image'];
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