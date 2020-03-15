<?php
require("core.php");
head();


if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    $query = mysqli_query($connect, "DELETE FROM `gym` WHERE id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-futbol"></i> Gym</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Gym</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">

<?php
if (isset($_POST['add'])) {
    $workouttype = $_POST['workouttype'];
    $energy      = $_POST['energy'];
    $health      = $_POST['health'];
    $fee         = $_POST['fee'];
    $power       = $_POST['power'];
    $agility     = $_POST['agility'];
    $endurance   = $_POST['endurance'];
    $format      = $_POST['format'];
    $time        = $_POST['time'];
    
    $query = mysqli_query($connect, "INSERT INTO `gym` (workout_type, energy_cost, health_restore, fee, power, agility, endurance, format, time) VALUES ('$workouttype', '$energy', '$health', '$fee', '$power', '$agility', '$endurance', '$format', '$time')");
}
?>
                    
                <div class="row">
				<div class="col-md-8">
				
				<?php
if (isset($_GET['edit-id'])) {
    $id  = (int) $_GET["edit-id"];
    $sql = mysqli_query($connect, "SELECT * FROM `gym` WHERE id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=gym.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=gym.php">';
    }
    
    if (isset($_POST['edit'])) {
        $workouttype = $_POST['workouttype'];
        $energy      = $_POST['energy'];
        $health      = $_POST['health'];
        $fee         = $_POST['fee'];
        $power       = $_POST['power'];
        $agility     = $_POST['agility'];
        $endurance   = $_POST['endurance'];
        $format      = $_POST['format'];
        $time        = $_POST['time'];
        
        $query = mysqli_query($connect, "UPDATE `gym` SET `workout_type`='$workouttype', `energy_cost`='$energy', `health_restore`='$health', `fee`='$fee', `power`='$power', `agility`='$agility', `endurance`='$endurance', `format`='$format', `time`='$time' WHERE id='$id'");
        echo '<meta http-equiv="refresh" content="0; url=gym.php">';
        
    }
?>
<form class="form-horizontal" action="" method="post">
                     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Workout</h3>
						</div>
				        <div class="box-body">
						      <div class="form-group">
											<label class="col-sm-3 control-label">Workout Type: </label>
											<div class="col-sm-9">
												<input type="text" name="workouttype" class="form-control" value="<?php
    echo $row['workout_type'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Energy Cost: </label>
											<div class="col-sm-9">
												<input type="number" name="energy" min="0" max="100" class="form-control" value="<?php
    echo $row['energy_cost'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Health Restore: </label>
											<div class="col-sm-9">
												<input type="number" name="health" min="0" max="100" class="form-control" value="<?php
    echo $row['health_restore'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Money Fee: </label>
											<div class="col-sm-9">
												<input type="number" name="fee" min="0" class="form-control" value="<?php
    echo $row['fee'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Power Improvement: </label>
											<div class="col-sm-9">
												<input type="number" name="power" min="0" max="250" class="form-control" value="<?php
    echo $row['power'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Agility Improvement: </label>
											<div class="col-sm-9">
												<input type="number" name="agility" min="0" max="250" class="form-control" value="<?php
    echo $row['agility'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Endurance Improvement: </label>
											<div class="col-sm-9">
												<input type="number" name="endurance" min="0" max="250" class="form-control" value="<?php
    echo $row['endurance'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Workout Time Format: </label>
											<div class="col-sm-9">
	<select name="format" class="form-control" required>
        <option value="Hours"
<?php
    if ($row['format'] == 'Hours') {
        echo ' selected';
    }
?>>Hours</option>
        <option value="Minutes"
<?php
    if ($row['format'] == 'Minutes') {
        echo ' selected';
    }
?>>Minutes</option>
    </select>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Workout Duration: </label>
											<div class="col-sm-9">
												<input type="number" name="time" min="0" class="form-control" value="<?php
    echo $row['time'];
?>" required>
											</div>
								</div>
                        </div>
                        <div class="panel-footer">
							<button class="btn btn-flat btn-success" name="edit" type="submit">Save</button>
				            <button type="reset" class="btn btn-flat btn-default">Reset</button>
				        </div>
				     </div>
</form>
<?php
}
?>
				
				    <div class="box">
						<div class="box-header">
							<h3 class="box-title">Workouts</h3>
						</div>
						<div class="box-body">
<table id="dt-basic" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>Workout Type</th>
											<th>Energy Cost</th>
											<th>Health Restore</th>
											<th>Money Fee</th>
                                            <th>Power Improvement</th>
											<th>Agility Improvement</th>
											<th>Endurance Improvement</th>
                                            <th>Workout Duration</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = mysqli_query($connect, "SELECT * FROM `gym`");
while ($row = mysqli_fetch_assoc($query)) {
    echo '
										<tr>
											<td>' . $row['id'] . '</td>
                                            <td>' . $row['workout_type'] . '</td>
											<td>' . $row['energy_cost'] . '</td>
											<td>' . $row['health_restore'] . '</td>
											<td>' . $row['fee'] . '</td>
											<td>' . $row['power'] . '</td>
											<td>' . $row['agility'] . '</td>
											<td>' . $row['endurance'] . '</td>
											<td>' . $row['time'] . ' ' . $row['format'] . '</td>
											<td>
                                            <a href="?edit-id=' . $row['id'] . '" class="btn btn-flat btn-flat btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-flat btn-danger"><i class="fas fa-trash"></i> Delete</a>
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
                    
				<div class="col-md-4">
<form class="form-horizontal" action="" method="post">
				     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Add Workout</h3>
						</div>
				        <div class="box-body">
						        <div class="form-group">
											<label class="col-sm-4 control-label">Workout Type: </label>
											<div class="col-sm-8">
												<input type="text" name="workouttype" class="form-control" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Energy Cost: </label>
											<div class="col-sm-8">
												<input type="number" name="energy" min="0" max="100" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Health Restore: </label>
											<div class="col-sm-8">
												<input type="number" name="health" min="0" max="100" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Money Fee: </label>
											<div class="col-sm-8">
												<input type="number" name="fee" min="0" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Power Improvement: </label>
											<div class="col-sm-8">
												<input type="number" name="power" min="0" max="250" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Agility Improvement: </label>
											<div class="col-sm-8">
												<input type="number" name="agility" min="0" max="250" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Endurance Improvement: </label>
											<div class="col-sm-8">
												<input type="number" name="endurance" min="0" max="250" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Workout Time Format: </label>
											<div class="col-sm-8">
	<select name="format" class="form-control" required>
        <option value="Hours" selected>Hours</option>
        <option value="Minutes">Minutes</option>
    </select>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Workout Duration: </label>
											<div class="col-sm-8">
												<input type="number" name="time" min="0" class="form-control" value="" required>
											</div>
								</div>
                        </div>
                        <div class="panel-footer">
							<button class="btn btn-flat btn-primary" name="add" type="submit">Add</button>
							<button type="reset" class="btn btn-flat btn-default">Reset</button>
				        </div>
				     </div>
</form>

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