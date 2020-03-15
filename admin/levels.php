<?php
require("core.php");
head();


if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    $query = mysqli_query($connect, "DELETE FROM `levels` WHERE id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-list-ul"></i> Levels</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Levels</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">

<?php
if (isset($_POST['add'])) {
    $level      = $_POST['level'];
    $minrespect = $_POST['minrespect'];
    
    $queryvalid = mysqli_query($connect, "SELECT * FROM `levels` WHERE level='$level' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
        echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> This <strong>Level</strong> is already added.</p>
        </div>
		';
    } else {
        
        $query = mysqli_query($connect, "INSERT INTO `levels` (level, min_respect) VALUES('$level', '$minrespect')");
    }
}
?>
                    
                <div class="row">
				<div class="col-md-9">
				
				<?php
if (isset($_GET['edit-id'])) {
    $id  = (int) $_GET["edit-id"];
    $sql = mysqli_query($connect, "SELECT * FROM `levels` WHERE id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=levels.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=levels.php">';
    }
    
    if (isset($_POST['edit'])) {
        $level      = $_POST['level'];
        $minrespect = $_POST['minrespect'];
        
        $queryvalid = mysqli_query($connect, "SELECT * FROM `levels` WHERE level='$level' AND id != '$id' LIMIT 1");
        $validator  = mysqli_num_rows($queryvalid);
        if ($validator > "0") {
            echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> This <strong>Level</strong> is already added.</p>
        </div>';
        } else {
            
            $query = mysqli_query($connect, "UPDATE `levels` SET level='$level', `min_respect`='$minrespect' WHERE id='$id'");
            echo '<meta http-equiv="refresh" content="0; url=levels.php">';
        }
    }
?>
<form class="form-horizontal" action="" method="post">
                     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Level</h3>
						</div>
				        <div class="box-body">
								<div class="form-group">
											<label class="col-sm-2 control-label">Level: </label>
											<div class="col-sm-10">
												<input type="number" name="level" min="0" class="form-control" value="<?php
    echo $row['level'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">Minimum Respect: </label>
											<div class="col-sm-10">
												<input type="number" name="minrespect" min="0" class="form-control" value="<?php
    echo $row['min_respect'];
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
							<h3 class="box-title">Levels</h3>
						</div>
						<div class="box-body">
<table id="dt-basic" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>Level</th>
											<th>Minimum Respect</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = mysqli_query($connect, "SELECT * FROM `levels`");
while ($row = mysqli_fetch_assoc($query)) {
    echo '
										<tr>
											<td>' . $row['level'] . '</td>
                                            <td>' . $row['min_respect'] . '</td>
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
											<label class="col-sm-4 control-label">Level: </label>
											<div class="col-sm-8">
												<input type="number" name="level" min="0" class="form-control" required>
											</div>
							    </div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Minimum Respect: </label>
											<div class="col-sm-8">
												<input type="number" name="minrespect" min="0" class="form-control" required>
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