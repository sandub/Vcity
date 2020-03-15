<?php
require("core.php");
head();


if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    $query = mysqli_query($connect, "DELETE FROM `hospital` WHERE id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-hospital"></i> Hospital</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Hospital</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">

<?php
if (isset($_POST['add'])) {
    $treatmenttype = $_POST['treatmenttype'];
    $faicon        = $_POST['faicon'];
    $health        = $_POST['health'];
    $cost          = $_POST['cost'];
    $format        = $_POST['format'];
    $time          = $_POST['time'];
    
    $query = mysqli_query($connect, "INSERT INTO `hospital` (treatment_type, health_restore, fa_icon, cost, format, time) VALUES ('$treatmenttype', '$health', '$faicon', '$cost', '$format', '$time')");
}
?>
                    
                <div class="row">
				<div class="col-md-8">
				
				<?php
if (isset($_GET['edit-id'])) {
    $id  = (int) $_GET["edit-id"];
    $sql = mysqli_query($connect, "SELECT * FROM `hospital` WHERE id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=hospital.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=hospital.php">';
    }
    
    if (isset($_POST['edit'])) {
        $treatmenttype = $_POST['treatmenttype'];
        $faicon        = $_POST['faicon'];
        $health        = $_POST['health'];
        $cost          = $_POST['cost'];
        $format        = $_POST['format'];
        $time          = $_POST['time'];
        
        $query = mysqli_query($connect, "UPDATE `hospital` SET `treatment_type`='$treatmenttype', `fa_icon`='$faicon', `health_restore`='$health', `cost`='$cost', `format`='$format', `time`='$time' WHERE id='$id'");
        echo '<meta http-equiv="refresh" content="0; url=hospital.php">';
        
    }
?>
<form class="form-horizontal" action="" method="post">
                     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Treatment</h3>
						</div>
				        <div class="box-body">
						      <div class="form-group">
											<label class="col-sm-3 control-label">Treatment Type: </label>
											<div class="col-sm-9">
												<input type="text" name="treatmenttype" class="form-control" value="<?php
    echo $row['treatment_type'];
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
											<label class="col-sm-3 control-label">Health Restore: </label>
											<div class="col-sm-9">
												<input type="number" name="health" min="0" max="100" class="form-control" value="<?php
    echo $row['health_restore'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Treatment Costs (Money): </label>
											<div class="col-sm-9">
												<input type="number" name="cost" min="0" class="form-control" value="<?php
    echo $row['cost'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">Treatment Time Format: </label>
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
											<label class="col-sm-3 control-label">Treatment Duration: </label>
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
							<h3 class="box-title">Treatments</h3>
						</div>
						<div class="box-body">
<table id="dt-basic" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>Treatment Type</th>
											<th>Health Restore</th>
											<th>Treatment Costs</th>
                                            <th>Treatment Duration</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = mysqli_query($connect, "SELECT * FROM `hospital`");
while ($row = mysqli_fetch_assoc($query)) {
    echo '
										<tr>
											<td>' . $row['id'] . '</td>
                                            <td>' . $row['treatment_type'] . '</td>
											<td>' . $row['health_restore'] . '</td>
											<td>' . $row['cost'] . '</td>
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
							<h3 class="box-title">Add Treatment</h3>
						</div>
				        <div class="box-body">
						        <div class="form-group">
											<label class="col-sm-4 control-label">Treatment Type: </label>
											<div class="col-sm-8">
												<input type="text" name="treatmenttype" class="form-control" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Font Awesome Icon: </label>
											<div class="col-sm-8">
												<input type="text" name="faicon" class="form-control" placeholder="fa-icon" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Health Restore: </label>
											<div class="col-sm-8">
												<input type="number" name="health" min="0" max="100" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Treatment Costs (Money): </label>
											<div class="col-sm-8">
												<input type="number" name="cost" min="0" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Treatment Time Format: </label>
											<div class="col-sm-8">
	<select name="format" class="form-control" required>
        <option value="Hours" selected>Hours</option>
        <option value="Minutes">Minutes</option>
    </select>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Treatment Duration: </label>
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