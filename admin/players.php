<?php
require("core.php");
head();

if (isset($_GET['delete-id'])) {
    $id     = (int) $_GET["delete-id"];
    $query  = mysqli_query($connect, "DELETE FROM `players` WHERE id='$id'");
    $query1 = mysqli_query($connect, "DELETE FROM `player_actions` WHERE player_id='$id'");
    $query2 = mysqli_query($connect, "DELETE FROM `players_comments` WHERE player_id='$id'");
    $query3 = mysqli_query($connect, "DELETE FROM `players_items` WHERE player_id='$id'");
    $query4 = mysqli_query($connect, "DELETE FROM `players_pets` WHERE player_id='$id'");
    $query5 = mysqli_query($connect, "DELETE FROM `players_properties` WHERE player_id='$id'");
    $query6 = mysqli_query($connect, "DELETE FROM `players_vehicles` WHERE player_id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-users"></i> Players</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Players</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">
                    
                <div class="row">                  
                
				<div class="col-md-12">
<?php
if (isset($_GET['edit-id'])) {
    $id  = (int) $_GET["edit-id"];
    $sql = mysqli_query($connect, "SELECT * FROM `players` WHERE id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=players.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=players.php">';
    }
?>
<form class="form-horizontal" action="" method="post">
                    <div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Player</h3>
						</div>
				        <div class="box-body">
                               <div class="form-group">
											<label class="col-sm-2 control-label">Username: </label>
											<div class="col-sm-10">
												<input type="text" name="username" class="form-control" value="<?php
    echo $row['username'];
?>" disabled>
											</div>
										</div>
                                        <div class="form-group">
											<label class="col-sm-2 control-label">E-Mail Address: </label>
											<div class="col-sm-10">
												<input type="email" name="email" class="form-control" value="<?php
    echo $row['email'];
?>" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Avatar: </label>
											<div class="col-sm-10">
												<input type="text" name="avatar" class="form-control" value="<?php
    echo $row['avatar'];
?>" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Role: </label>
											<div class="col-sm-10">
												<select name="role" class="form-control" required>
        <option value="Player" <?php
    if ($row['role'] == 'Player') {
        echo 'selected';
    }
?>>Player</option>
        <option value="Admin" <?php
    if ($row['role'] == 'Admin') {
        echo 'selected';
    }
?>>Admin</option>
    </select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Money: </label>
											<div class="col-sm-10">
												<input type="number" name="money" min="0" class="form-control" value="<?php
    echo $row['money'];
?>" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Gold: </label>
											<div class="col-sm-10">
												<input type="number" name="gold" min="0" class="form-control" value="<?php
    echo $row['gold'];
?>" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Respect: </label>
											<div class="col-sm-10">
												<input type="number" name="respect" min="0" class="form-control" value="<?php
    echo $row['respect'];
?>" required>
											</div>
										</div>
                                        <hr>
                        </div>
                        <div class="panel-footer">
							<button class="btn btn-flat btn-success" name="edit" type="submit">Save</button>
							<button type="reset" class="btn btn-flat btn-default">Reset</button>
				        </div>
				     </div>
</form>
<?php
    if (isset($_POST['edit'])) {
        $avatar  = $_POST['avatar'];
        $role    = $_POST['role'];
        $money   = $_POST['money'];
        $gold    = $_POST['gold'];
        $respect = $_POST['respect'];
        
        $query = mysqli_query($connect, "UPDATE `players` SET avatar='$avatar', role='$role', money='$money', gold='$gold', respect='$respect' WHERE id='$id'");
        
        echo '<meta http-equiv="refresh" content="0;url=players.php">';
    }
}
?>

				    <div class="box">
						<div class="box-header">
							<h3 class="box-title">Players</h3>
						</div>
						<div class="box-body">
<table id="dt-basic" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th><i class="fas fa-list-ul"></i> ID</th>
											<th><i class="fas fa-user"></i> Username</th>
                                            <th><i class="fas fa-envelope"></i> E-Mail</th>
											<th><i class="fas fa-bookmark"></i> Role</th>
											<th><i class="fas fa-server"></i> Level</th>
											<th><i class="fas fa-money"></i> Money</th>
											<th><i class="fas fa-inbox"></i> Gold</th>
											<th><i class="fas fa-star"></i> Respect</th>
											<th><i class="fas fa-cogs"></i> Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = mysqli_query($connect, "SELECT * FROM `players`");
while ($row = mysqli_fetch_assoc($query)) {
    echo '
										<tr>
											<td>' . $row['id'] . '</td>
                                            <td>' . $row['username'] . '</td>
                                            <td>' . $row['email'] . '</td>
											<td>' . $row['role'] . '</td>
											<td>' . $row['level'] . '</td>
											<td>' . $row['money'] . '</td>
											<td>' . $row['gold'] . '</td>
											<td>' . $row['respect'] . '</td>
											<td>
                                            <a href="?edit-id=' . $row['id'] . '" class="btn btn-flat btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-danger"><i class="fas fa-trash"></i> Delete</a>
											</td>
										</tr>
';
}
?>   
								</tbody>
								</table>
                        </div>
                     </div>
                </div>
                    
				</div>
                    
				</div>
				<!--===================================================-->
				<!--End page content-->


			</div>
			<!--===================================================-->
			<!--END CONTENT CONTAINER-->

<script>
$(document).ready(function() {

	$('#dt-basic').dataTable( {
		"responsive": true,
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
} );
</script>
<?php
footer();
?>