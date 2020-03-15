<?php
require("core.php");
head();


if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    $query = mysqli_query($connect, "DELETE FROM `jobs` WHERE id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-briefcase"></i> Jobs</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Jobs</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">

<?php
if (isset($_POST['add'])) {
    $jobtype = $_POST['jobtype'];
    $energy  = $_POST['energy'];
    $health  = $_POST['health'];
    $money   = $_POST['money'];
    $gold    = $_POST['gold'];
    $format  = $_POST['format'];
    $time    = $_POST['time'];
    
    $query = mysqli_query($connect, "INSERT INTO `jobs` (job_type, energy_cost, health_loss, money, gold, format, time) VALUES ('$jobtype', '$energy', '$health', '$money', '$gold', '$format', '$time')");
}
?>
                    
                <div class="row">
				<div class="col-md-8">
				
				<?php
if (isset($_GET['edit-id'])) {
    $id  = (int) $_GET["edit-id"];
    $sql = mysqli_query($connect, "SELECT * FROM `jobs` WHERE id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=jobs.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=jobs.php">';
    }
    
    if (isset($_POST['edit'])) {
        $jobtype = $_POST['jobtype'];
        $energy  = $_POST['energy'];
        $health  = $_POST['health'];
        $money   = $_POST['money'];
        $gold    = $_POST['gold'];
        $format  = $_POST['format'];
        $time    = $_POST['time'];
        
        $query = mysqli_query($connect, "UPDATE `jobs` SET `job_type`='$jobtype', `energy_cost`='$energy', `health_loss`='$health', `money`='$money', `gold`='$gold', `format`='$format', `time`='$time' WHERE id='$id'");
        echo '<meta http-equiv="refresh" content="0; url=jobs.php">';
        
    }
?>
<form class="form-horizontal" action="" method="post">
                     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Job</h3>
						</div>
				        <div class="box-body">
						      <div class="form-group">
											<label class="col-sm-3 control-label">Job Type: </label>
											<div class="col-sm-9">
												<input type="text" name="jobtype" class="form-control" value="<?php
    echo $row['job_type'];
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
											<label class="col-sm-3 control-label">Health Loss: </label>
											<div class="col-sm-9">
												<input type="number" name="health" min="0" max="100" class="form-control" value="<?php
    echo $row['health_loss'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Money Salary: </label>
											<div class="col-sm-9">
												<input type="number" name="money" min="0" class="form-control" value="<?php
    echo $row['money'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Gold Salary: </label>
											<div class="col-sm-9">
												<input type="number" name="gold" min="0" class="form-control" value="<?php
    echo $row['gold'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Work Time Format: </label>
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
											<label class="col-sm-3 control-label">Work Time: </label>
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
							<h3 class="box-title">Jobs</h3>
						</div>
						<div class="box-body">
<table id="dt-basic" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>Job Type</th>
											<th>Energy Cost</th>
											<th>Health Loss</th>
											<th>Money Salary</th>
                                            <th>Gold Salary</th>
                                            <th>Work Time Period</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = mysqli_query($connect, "SELECT * FROM `jobs`");
while ($row = mysqli_fetch_assoc($query)) {
    echo '
										<tr>
											<td>' . $row['id'] . '</td>
                                            <td>' . $row['job_type'] . '</td>
											<td>' . $row['energy_cost'] . '</td>
											<td>' . $row['health_loss'] . '</td>
											<td>' . $row['money'] . '</td>
											<td>' . $row['gold'] . '</td>
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
							<h3 class="box-title">Add Job</h3>
						</div>
				        <div class="box-body">
						        <div class="form-group">
											<label class="col-sm-4 control-label">Job Type: </label>
											<div class="col-sm-8">
												<input type="text" name="jobtype" class="form-control" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Energy Cost: </label>
											<div class="col-sm-8">
												<input type="number" name="energy" min="0" max="100" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Health Loss: </label>
											<div class="col-sm-8">
												<input type="number" name="health" min="0" max="100" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Money Salary: </label>
											<div class="col-sm-8">
												<input type="number" name="money" min="0" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Gold Salary: </label>
											<div class="col-sm-8">
												<input type="number" name="gold" min="0" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Work Time Format: </label>
											<div class="col-sm-8">
	<select name="format" class="form-control" required>
        <option value="Hours" selected>Hours</option>
        <option value="Minutes">Minutes</option>
    </select>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Work Time: </label>
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