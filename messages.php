<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['delete'])) {
    
    $delete_id = (int) $_GET["delete"];
    
    $delete_pm = mysqli_query($connect, "DELETE FROM `messages` WHERE id='$delete_id' AND toid='$player_id' LIMIT 1");
}

if (isset($_GET['view'])) {
    $message_id = (int) $_GET["view"];
    
    $queryvpm = mysqli_query($connect, "SELECT * FROM messages WHERE id='$message_id' AND toid='$player_id' LIMIT 1");
    $rowvpm   = mysqli_fetch_assoc($queryvpm);
    
    $countvpm = mysqli_num_rows($queryvpm);
    if ($countvpm > 0) {
        
        $querympmr = mysqli_query($connect, "UPDATE `messages` SET viewed='Yes' WHERE id='$message_id'");
        
        $from_id = $rowvpm['fromid'];
        $queryvs = mysqli_query($connect, "SELECT * FROM players WHERE id='$from_id' LIMIT 1");
        $rowvs   = mysqli_fetch_assoc($queryvs);
        
        echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#view").modal(\'show\');
            });
        </script>

        <div id="view" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title"><i class="fa fa-envelope"></i> ' . lang_key("message") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
						    <div class="well">
							    <form class="form-inline">
 							        <label for="rg-from"><i class="fa fa-user"></i> ' . lang_key("sender") . ': </label>&nbsp;
  							        <div class="form-group">
 							            <input type="text" id="rg-from" name="rg-from" value="' . $rowvs['username'] . '" class="form-control" disabled>
 							        </div>
									<br /><br />
									<label for="rg-fromd"><i class="far fa-calendar-alt"></i> ' . lang_key("date") . ': </label>&nbsp;
  							        <div class="form-group">
 							            <input type="text" id="rg-fromd" name="rg-from" value="' . $rowvpm['date'] . ' ' . lang_key("at") . ' ' . $rowvpm['time'] . '" class="form-control" disabled>
 							        </div>
									<br /><br />
									<label><i class="far fa-file-alt"></i> ' . lang_key("message") . ': </label><br />
 							            <textarea class="form-control" id="content" name="content" rows="4" style="min-width: 100%" disabled>' . $rowvpm['content'] . '</textarea>
							    </form>
							</div>
                            <button type="button" class="btn btn-primary btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> ' . lang_key("close") . '</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
    }
}

if (isset($_POST['sendm'])) {
    $toid    = $_POST['toid'];
    $fromid  = $player_id;
    $content = $_POST['content'];
    $date    = date('d F Y');
    $time    = date('H:i');
    
    $send_message = mysqli_query($connect, "INSERT INTO `messages` (toid, fromid, content, date, time) VALUES ('$toid', '$fromid', '$content', '$date', '$time')");
    
    echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#sent").modal(\'show\');
            });
        </script>

        <div id="sent" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title"><i class="fa fa-envelope"></i> ' . lang_key("sending-message") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-success"><i class="far fa-paper-plane"></i>&nbsp; ' . lang_key("success-sent") . '</span></h3><br /><br />
                            <button type="button" class="btn btn-primary btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fab fa-get-pocket"></i> ' . lang_key("okay") . '</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
}
?>
<div class="col-md-12 well">

    <center><h2><i class="fa fa-envelope"></i> <?php
echo lang_key("messages");
?></h2></center><br />

    <div class="row">
    
	<div class="col-md-12">
	<div class="col-md-1"></div>
	<div class="col-md-10">
        <ul class="nav nav-tabs nav-justified">
          <li class="active"><a data-toggle="tab" href="#home"><i class="far fa-envelope"></i>&nbsp; <?php
echo lang_key("inbox");
?></a></li>
          <li><a data-toggle="tab" href="#menu1"><i class="far fa-paper-plane"></i>&nbsp; <?php
echo lang_key("send-message");
?></a></li>
        </ul>

        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
            
			   <br />
			
			   <table id="dt-basic" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><i class="fa fa-user"></i> <?php
echo lang_key("sender");
?></th>
						<th><i class="far fa-calendar-alt"></i> <?php
echo lang_key("date");
?></th>
						<th><i class="fa fa-cog"></i> <?php
echo lang_key("actions");
?></th>
						</tr>
					</thead>
					<tbody>
<?php
$querypm = mysqli_query($connect, "SELECT * FROM messages WHERE toid='$player_id' ORDER BY date, time DESC");
while ($rowpm = mysqli_fetch_assoc($querypm)) {
    $from_id  = $rowpm['fromid'];
    $querypms = mysqli_query($connect, "SELECT * FROM players WHERE id='$from_id' LIMIT 1");
    $rowpms   = mysqli_fetch_assoc($querypms);
?>
                        <tr>
						    <td><a href="player.php?id=<?php
    echo $rowpm['fromid'];
?>" style="text-decoration: none;"><img src="<?php
    echo $rowpms['avatar'];
?>" width="10%" />&nbsp; <?php
    echo $rowpms['username'];
?></a>&nbsp;
<?php
    $timeonline = time() - 60;
    if ($rowpms['timeonline'] > $timeonline) {
        echo '<span class="label label-success" title="' . lang_key("online") . '"><i class="fa fa-circle"></i></span>';
    }
    echo '&nbsp;';
    if ($rowpms['role'] == "Admin") {
        echo '<span class="label label-danger"><i class="fa fa-bookmark"></i> ' . $rowpms['role'] . '</span> ';
    }
    if ($rowpms['role'] == "VIP") {
        echo '<span class="label label-warning"><i class="fa fa-star"></i> ' . $rowpms['role'] . '</span> ';
    }
?>
</td>
							<td><i class="fa fa-calendar"></i> <b><?php
    echo $rowpm['date'];
?></b> <?php
    echo lang_key("at");
?> <i class="fas fa-clock"></i> <b><?php
    echo $rowpm['time'];
?></b></td>
							<td>
<?php
    if ($rowpm['viewed'] == "Yes") {
        echo '<a href="?view=' . $rowpm['id'] . '" class="btn btn-flat btn-primary"><i class="fa fa-envelope-open"></i>&nbsp; ' . lang_key("view") . '</a>';
    } else {
        echo '<a href="?view=' . $rowpm['id'] . '" class="btn btn-flat btn-success"><i class="fa fa-envelope"></i>&nbsp; ' . lang_key("view") . '</a>';
    }
?>
								<a href="?delete=<?php
    echo $rowpm['id'];
?>" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i> <?php
    echo lang_key("delete");
?></a>
							</td>
						</tr>
<?php
}
?>
					</tbody>
				</table>

			
          </div>
          <div id="menu1" class="tab-pane fade">
            
			    <br />
			
			    <form action="" method="post">
			      <div class="form-group">
 			       <label for="toid"><i class="fa fa-user"></i> <?php
echo lang_key("recipient");
?></label>
			        <select class="form-control select2" name="toid" id="toid" required>
<?php
$queryap = mysqli_query($connect, "SELECT * FROM players WHERE id!='$player_id' ORDER BY username");
while ($rowap = mysqli_fetch_assoc($queryap)) {
?>
 			         <option value="<?php
    echo $rowap['id'];
?>"><?php
    echo $rowap['username'];
?></option>
<?php
}
?>
 			       </select>
 			     </div>
				 <div class="form-group">
 				    <label for="content"><i class="far fa-file-text"></i> <?php
echo lang_key("message");
?></label>
 				    <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
 				  </div>
 			     <button type="submit" name="sendm" class="btn btn-primary"><i class="fa fa-paper-plane"></i> <?php
echo lang_key("send");
?></button>
			    </form>
			
          </div>
        </div>
	</div>
	<div class="col-md-1"></div>
	</div>

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
	
    $(".select2").select2({width: '100%'});

} );
</script>   

<?php
footer();
?>