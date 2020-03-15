<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

$query = mysqli_query($connect, "SELECT * FROM `settings` WHERE id='1' LIMIT 1");
$row   = mysqli_fetch_assoc($query);

$dirname   = $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
$vcity_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$dirname";

if (isset($_GET['pserv-id'])) {
    
    $resource_id = (int) $_GET['pserv-id'];
    
    $queryps = mysqli_query($connect, "SELECT * FROM `paid_services` WHERE id = '$resource_id' LIMIT 1");
    $countps = mysqli_num_rows($queryps);
    if ($countps > 0) {
        $rowps = mysqli_fetch_assoc($queryps);
        
        $query                  = array();
        $query['notify_url']    = $vcity_url . '/paypal-ipn.php';
        $query['cmd']           = '_xclick';
        $query['business']      = $row['paypal_email'];
        $query['email']         = $row['paypal_email'];
        $query['item_name']     = $rowps['service'] . ' - ' . $rowu['username'];
        $query['currency_code'] = $rowps['currency'];
        $query['amount']        = $rowps['cost'];
        
        $query_string = http_build_query($query);
        
        echo '<meta http-equiv="refresh" content="0; url=https://www.paypal.com/cgi-bin/webscr?' . $query_string . '" />';
        
    }
}
?>
<div class="col-md-12 well">

    <center><h2><i class="fa fa-dollar-sign"></i> <?php
echo lang_key("resources");
?></h2></center><br />

    <div class="row">
<?php
$query = mysqli_query($connect, "SELECT * FROM `paid_services`");
while ($row = mysqli_fetch_assoc($query)) {
?>
        <div class="col-md-6">
	    <div class="jumbotron">
		    <h3><i class="fa fa-server"></i> <?php
    echo $row['service'];
?></h3>
			<hr /><br />
			
			<div class="row">
                <div class="col-md-8">
                    <center><img src="<?php
    echo $row['image'];
?>" width="40%"></center>
                </div>
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item active">
                            <center><?php
    echo lang_key("resource-details");
?></center>
                        </li>
                        <li class="list-group-item"><span class="badge badge-info"><?php
    if ($row['type'] == 'getmoney') {
        echo lang_key("money");
    } elseif ($row['type'] == 'getgold') {
        echo lang_key("gold");
    } elseif ($row['type'] == 'energyrefill') {
        echo lang_key("energy-refill");
    } elseif ($row['type'] == 'vip') {
        echo lang_key("vip-status");
    }
?></span><i class="fa fa-star"></i> <?php
    echo lang_key("type");
?></li>
                        <li class="list-group-item"><span class="badge badge-danger"><?php
    echo $row['amount'];
?></span><i class="fa fa-inbox"></i> <?php
    echo lang_key("amount");
?></li>
                        <li class="list-group-item"><span class="badge badge-success"><?php
    echo $row['cost'];
?> <?php
    echo $row['currency'];
?></span><i class="fa fa-dollar-sign"></i> <?php
    echo lang_key("price");
?></li>
                    </ul>
			    </div>
            </div>
            <hr />

			<a href="?pserv-id=<?php
    echo $row['id'];
?>" class="btn btn-block btn-success"><i class="far fa-money-bill-alt"></i>&nbsp; <?php
    echo lang_key("purchase");
?></a>

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