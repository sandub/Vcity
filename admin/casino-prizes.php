<?php
require("core.php");
head();


if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    $query = mysqli_query($connect, "DELETE FROM `casino_prizes` WHERE id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-gem"></i> Casino Prizes</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Casino Prizes</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">

<?php
if (isset($_POST['add'])) {
    $prizetype = $_POST['prizetype'];
    $value     = $_POST['value'];
    $color     = $_POST['color'];
    
    $query = mysqli_query($connect, "INSERT INTO `casino_prizes` (prizetype, value, color) VALUES('$prizetype', '$value', '$color')");
}
?>
                    
                <div class="row">
				<div class="col-md-9">
				
				<?php
if (isset($_GET['edit-id'])) {
    $id  = (int) $_GET["edit-id"];
    $sql = mysqli_query($connect, "SELECT * FROM `casino_prizes` WHERE id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=casino-prizes.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=casino-prizes.php">';
    }
    
    if (isset($_POST['edit'])) {
        $prizetype = $_POST['prizetype'];
        $value     = $_POST['value'];
        $color     = $_POST['color'];
        
        $query = mysqli_query($connect, "UPDATE `casino_prizes` SET prizetype='$prizetype', `value`='$value', `color`='$color' WHERE id='$id'");
        echo '<meta http-equiv="refresh" content="0; url=casino-prizes.php">';
    }
?>
<form class="form-horizontal" action="" method="post">
                     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Prize</h3>
						</div>
				        <div class="box-body">
								<div class="form-group">
											<label class="col-sm-2 control-label">Prize Type: </label>
											<div class="col-sm-10">
	<select name="prizetype" class="form-control" required>
        <option value="Money"
<?php
    if ($row['prizetype'] == 'Money') {
        echo ' selected';
    }
?>>Money</option>
        <option value="Gold"
<?php
    if ($row['prizetype'] == 'Gold') {
        echo ' selected';
    }
?>>Gold</option>
		<option value="Respect"
<?php
    if ($row['prizetype'] == 'Respect') {
        echo ' selected';
    }
?>>Respect</option>
		<option value="Energy
<?php
    if ($row['prizetype'] == 'Energy') {
        echo ' selected';
    }
?>">Energy</option>
		<option value="Health"
<?php
    if ($row['prizetype'] == 'Health') {
        echo ' selected';
    }
?>>Health</option>
    </select>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">Value: </label>
											<div class="col-sm-10">
												<input type="number" name="value" min="0" class="form-control" value="<?php
    echo $row['value'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">Color: </label>
											<div class="col-sm-10">
												<input type="text" name="color" class="form-control" value="<?php
    echo $row['color'];
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
							<h3 class="box-title">Casino Prizes</h3>
						</div>
						<div class="box-body">
<table id="dt-basic" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										    <th>ID</th>
											<th>Prize Type</th>
											<th>Value</th>
											<th>Color</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = mysqli_query($connect, "SELECT * FROM `casino_prizes`");
while ($row = mysqli_fetch_assoc($query)) {
    echo '
										<tr>
										    <td>' . $row['id'] . '</td>
											<td>' . $row['prizetype'] . '</td>
                                            <td>' . $row['value'] . '</td>
											<td><font color="' . $row['color'] . '">' . $row['color'] . '</font></td>
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
                    
				<div class="col-md-3">
<form class="form-horizontal" action="" method="post">
				     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Add Level</h3>
						</div>
				        <div class="box-body">
								<div class="form-group">
											<label class="col-sm-4 control-label">Prize Type: </label>
											<div class="col-sm-8">
	<select name="prizetype" class="form-control" required>
        <option value="Money" selected>Money</option>
        <option value="Gold">Gold</option>
		<option value="Respect">Respect</option>
		<option value="Energy">Energy</option>
		<option value="Health">Health</option>
    </select>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Value: </label>
											<div class="col-sm-8">
												<input type="number" name="value" min="0" class="form-control" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Color: </label>
											<div class="col-sm-8">
												<input type="text" name="color" placeholder="Example: blue / #4286f4" class="form-control" required>
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