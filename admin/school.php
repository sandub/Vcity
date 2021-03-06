<?php
require("core.php");
head();


if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    $query = mysqli_query($connect, "DELETE FROM `school` WHERE id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-graduation-cap"></i> School</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">School</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">

<?php
if (isset($_POST['add'])) {
    $subject      = $_POST['subject'];
    $faicon       = $_POST['faicon'];
    $energy       = $_POST['energy'];
    $fee          = $_POST['fee'];
    $intelligence = $_POST['intelligence'];
    $format       = $_POST['format'];
    $time         = $_POST['time'];
    
    $query = mysqli_query($connect, "INSERT INTO `school` (subject, energy_cost, fa_icon, fee, intelligence, format, time) VALUES ('$subject', '$energy', '$faicon', '$fee', '$intelligence', '$format', '$time')");
}
?>
                    
                <div class="row">
				<div class="col-md-8">
				
				<?php
if (isset($_GET['edit-id'])) {
    $id  = (int) $_GET["edit-id"];
    $sql = mysqli_query($connect, "SELECT * FROM `school` WHERE id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=school.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=school.php">';
    }
    
    if (isset($_POST['edit'])) {
        $subject      = $_POST['subject'];
        $faicon       = $_POST['faicon'];
        $energy       = $_POST['energy'];
        $fee          = $_POST['fee'];
        $intelligence = $_POST['intelligence'];
        $format       = $_POST['format'];
        $time         = $_POST['time'];
        
        $query = mysqli_query($connect, "UPDATE `school` SET `subject`='$subject', `fa_icon`='$faicon', `energy_cost`='$energy', `fee`='$fee', `intelligence`='$intelligence', `format`='$format', `time`='$time' WHERE id='$id'");
        echo '<meta http-equiv="refresh" content="0; url=school.php">';
        
    }
?>
<form class="form-horizontal" action="" method="post">
                     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Lesson</h3>
						</div>
				        <div class="box-body">
						      <div class="form-group">
											<label class="col-sm-3 control-label">Lesson Subject: </label>
											<div class="col-sm-9">
												<input type="text" name="subject" class="form-control" value="<?php
    echo $row['subject'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Font Awesome Icon: </label>
											<div class="col-sm-9">
												<input type="text" name="faicon" class="form-control" value="<?php
    echo $row['fa_icon'];
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
											<label class="col-sm-3 control-label">Money Fee: </label>
											<div class="col-sm-9">
												<input type="number" name="fee" min="0" class="form-control" value="<?php
    echo $row['fee'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Intelligence Improvement: </label>
											<div class="col-sm-9">
												<input type="number" name="intelligence" min="0" max="250" class="form-control" value="<?php
    echo $row['intelligence'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Lesson Time Format: </label>
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
											<label class="col-sm-3 control-label">Lesson Duration: </label>
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
											<th>Lesson Subject</th>
											<th>Energy Cost</th>
											<th>Money Fee</th>
                                            <th>Intelligence Improvement</th>
                                            <th>Workout Duration</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = mysqli_query($connect, "SELECT * FROM `school`");
while ($row = mysqli_fetch_assoc($query)) {
    echo '
										<tr>
											<td>' . $row['id'] . '</td>
                                            <td>' . $row['subject'] . '</td>
											<td>' . $row['energy_cost'] . '</td>
											<td>' . $row['fee'] . '</td>
											<td>' . $row['intelligence'] . '</td>
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
							<h3 class="box-title">Add Lesson</h3>
						</div>
				        <div class="box-body">
						        <div class="form-group">
											<label class="col-sm-4 control-label">Lesson Subject: </label>
											<div class="col-sm-8">
												<input type="text" name="subject" class="form-control" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Font Awesome Icon: </label>
											<div class="col-sm-8">
												<input type="text" name="faicon" class="form-control" placeholder="fa-icon" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Energy Cost: </label>
											<div class="col-sm-8">
												<input type="number" name="energy" min="0" max="100" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Money Fee: </label>
											<div class="col-sm-8">
												<input type="number" name="fee" min="0" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Intelligence Improvement: </label>
											<div class="col-sm-8">
												<input type="number" name="intelligence" min="0" max="250" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Lesson Time Format: </label>
											<div class="col-sm-8">
	<select name="format" class="form-control" required>
        <option value="Hours" selected>Hours</option>
        <option value="Minutes">Minutes</option>
    </select>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Lesson Duration: </label>
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