<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET["tab"]) == 'onlineplayers') {
    $tabonline = 'Yes';
} else {
    $tabonline = 'No';
}
?>
<div class="col-md-12 well">

    <center><h2><i class="fa fa-trophy"></i> <?php
echo lang_key("leaderboard");
?></h2></center><br />

    <div class="row">
    <div class="col-md-1"></div>
	
	<div class="col-md-10">
	<div class="jumbotron">

    <ul class="nav nav-tabs nav-justified">
        <li <?php
if ($tabonline == 'No')
    echo 'class="active"';
?>><a data-toggle="tab" href="#all_players"><i class="fa fa-users"></i>&nbsp; <?php
echo lang_key("all-players");
?></a></li>
        <li <?php
if ($tabonline == 'Yes')
    echo 'class="active"';
?>><a data-toggle="tab" href="#online_players"><i class="far fa-dot-circle"></i>&nbsp; <?php
echo lang_key("online-players");
?></a></li>
    </ul><br />
	
	<div class="tab-content">
	
        <div id="all_players" class="tab-pane fade <?php
if ($tabonline == 'No')
    echo 'in active';
?>">
		    <center><h3><i class="fa fa-users"></i> <?php
echo lang_key("all-players");
?></h3></center><br />
            
			<table id="dt-basic" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><i class="fa fa-list-ol"></i></th>
						<th><i class="fa fa-user"></i> <?php
echo lang_key("player");
?></th>
						<th><i class="fa fa-star"></i> <?php
echo lang_key("respect");
?></th>
						<th><i class="far fa-money-bill-alt"></i> <?php
echo lang_key("money");
?></th>
						<th><i class="fa fa-inbox"></i> <?php
echo lang_key("gold");
?></th>
						<th><i class="fa fa-server"></i> <?php
echo lang_key("level");
?></th>
						<th><i class="fa fa-cog"></i> <?php
echo lang_key("actions");
?></th>
						</tr>
					</thead>
					<tbody>
<?php
$querygp = mysqli_query($connect, "SELECT * FROM players ORDER BY respect DESC");
$i       = 1;
while ($rowgp = mysqli_fetch_assoc($querygp)) {
?>
                        <tr>
                            <td><?php
    if ($i == '1') {
        echo '<i class="fa fa-trophy" style="color: #C98910; font-size: 20px;"></i> ';
    }
    if ($i == '2') {
        echo '<i class="fa fa-trophy" style="color: #A8A8A8; font-size: 20px;"></i> ';
    }
    if ($i == '3') {
        echo '<i class="fa fa-trophy" style="color: #965A38; font-size: 20px;"></i> ';
    }
    echo $i++;
?>
							</td>
						    <td><a href="player.php?id=<?php
    echo $rowgp['id'];
?>" style="text-decoration: none;"><img src="<?php
    echo $rowgp['avatar'];
?>" width="15%" />&nbsp; <?php
    echo $rowgp['username'];
?></a>&nbsp;
<?php
    $timeonline = time() - 60;
    if ($rowgp['timeonline'] > $timeonline) {
        echo '<span class="label label-success" title="' . lang_key("online") . '"><i class="fa fa-circle"></i></span>';
    }
    echo '&nbsp;';
    if ($rowgp['role'] == "Admin") {
        echo '<span class="label label-danger"><i class="fa fa-bookmark"></i> ' . $rowgp['role'] . '</span> ';
    }
    if ($rowgp['role'] == "VIP") {
        echo '<span class="label label-warning"><i class="fa fa-star"></i> ' . $rowgp['role'] . '</span> ';
    }
?>
</td>
						    <td><?php
    echo $rowgp['respect'];
?></td>
							<td><?php
    echo $rowgp['money'];
?></td>
							<td><?php
    echo $rowgp['gold'];
?></td>
							<td><?php
    echo $rowgp['level'];
?></td>
							<td>
                                <a href="player.php?id=<?php
    echo $rowgp['id'];
?>" class="btn btn-flat btn-success"><i class="fa fa-map-marker"></i> <?php
    echo lang_key("visit-player");
?></a>
								<a href="fight-arena.php?opponent=<?php
    echo $rowgp['id'];
?>" class="btn btn-flat btn-danger"><i class="fa fa-crosshairs"></i> <?php
    echo lang_key("fight");
?></a>
							</td>
						</tr>
<?php
}
?>
					</tbody>
				</table>

        </div>
  
        <div id="online_players" class="tab-pane fade <?php
if ($tabonline == 'Yes')
    echo 'in active';
?>">
		    <center><h3><i class="far fa-dot-circle"></i> <?php
echo lang_key("online-players");
?></h3></center><br />
			
			<table id="dt-basic2" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><i class="fa fa-list-ol"></i></th>
						<th><i class="fa fa-user"></i> <?php
echo lang_key("player");
?></th>
						<th><i class="fa fa-star"></i> <?php
echo lang_key("respect");
?></th>
						<th><i class="far fa-money-bill-alt"></i> <?php
echo lang_key("money");
?></th>
						<th><i class="fa fa-inbox"></i> <?php
echo lang_key("gold");
?></th>
						<th><i class="fa fa-server"></i> <?php
echo lang_key("level");
?></th>
						<th><i class="fa fa-cog"></i> <?php
echo lang_key("actions");
?></th>
						</tr>
					</thead>
					<tbody>
<?php
$querygpo = mysqli_query($connect, "SELECT * FROM players WHERE timeonline>$timeonline ORDER BY respect DESC");
$e        = 1;
while ($rowgpo = mysqli_fetch_assoc($querygpo)) {
?>
                        <tr>
                            <td><?php
    if ($e == '1') {
        echo '<i class="fa fa-trophy" style="color: #C98910; font-size: 20px;"></i> ';
    }
    if ($e == '2') {
        echo '<i class="fa fa-trophy" style="color: #A8A8A8; font-size: 20px;"></i> ';
    }
    if ($e == '3') {
        echo '<i class="fa fa-trophy" style="color: #965A38; font-size: 20px;"></i> ';
    }
    echo $e++;
?>
							</td>
						    <td><a href="player.php?id=<?php
    echo $rowgpo['id'];
?>" style="text-decoration: none;"><img src="<?php
    echo $rowgpo['avatar'];
?>" width="15%" />&nbsp; <?php
    echo $rowgpo['username'];
?></a>&nbsp;
<?php
    if ($rowgpo['timeonline'] > $timeonline) {
        echo '<span class="label label-success" title="' . lang_key("online") . '"><i class="fa fa-circle"></i></span>';
    }
    echo '&nbsp;';
    if ($rowgpo['role'] == "Admin") {
        echo '<span class="label label-danger"><i class="fa fa-bookmark"></i> ' . $rowgpo['role'] . '</span> ';
    }
    if ($rowgpo['role'] == "VIP") {
        echo '<span class="label label-warning"><i class="fa fa-star"></i> ' . $rowgpo['role'] . '</span> ';
    }
?>
</td>
						    <td><?php
    echo $rowgpo['respect'];
?></td>
							<td><?php
    echo $rowgpo['money'];
?></td>
							<td><?php
    echo $rowgpo['gold'];
?></td>
							<td><?php
    echo $rowgpo['level'];
?></td>
							<td>
                                <a href="player.php?id=<?php
    echo $rowgpo['id'];
?>" class="btn btn-flat btn-success"><i class="fa fa-map-marker"></i> <?php
    echo lang_key("visit-player");
?></a> 
								<a href="fight-arena.php?opponent=<?php
    echo $rowgpo['id'];
?>" class="btn btn-flat btn-danger"><i class="fa fa-crosshairs"></i> <?php
    echo lang_key("fight");
?></a>
							</td>
						</tr>
<?php
}
?>
					</tbody>
				</table>
        </div>
  
    </div>
	</div>
	</div>
	
	<div class="col-md-1"></div>
    </div>
</div>

<script>
$(document).ready(function() {

	$('#dt-basic').dataTable( {
		"responsive": true,
        "order": [[ 0, "asc" ]],
		"language": {
			"paginate": {
			  "previous": '<i class="fa fa-angle-left"></i>',
			  "next": '<i class="fa fa-angle-right"></i>'
			}
		}
	} );
	
	$('#dt-basic2').dataTable( {
		"responsive": true,
        "order": [[ 0, "asc" ]],
		"language": {
			"paginate": {
			  "previous": '<i class="fa fa-angle-left"></i>',
			  "next": '<i class="fa fa-angle-right"></i>'
			}
		}
	} );
} );
</script>   
<?php
footer();
?>