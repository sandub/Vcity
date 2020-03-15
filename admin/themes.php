<?php
require("core.php");
head();


if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    $query = mysqli_query($connect, "DELETE FROM `themes` WHERE id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-paint-brush"></i> Themes</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Themes</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">

<?php
if (isset($_POST['add'])) {
    $name    = $_POST['name'];
    $csspath = $_POST['csspath'];
    $default = $_POST['default'];
    
    $queryvalid = mysqli_query($connect, "SELECT * FROM `themes` WHERE csspath='$csspath' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
        echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> This <strong>Theme</strong> is already added.</p>
        </div>
		';
    } else {
        
        if ($default == 'Yes') {
            $queryud = mysqli_query($connect, "SELECT * FROM `themes` WHERE default_theme='Yes' LIMIT 1");
            $rowud   = mysqli_fetch_assoc($queryud);
            
            $tud_id = $rowud['id'];
            
            $query = mysqli_query($connect, "UPDATE `themes` SET `default_theme`='No' WHERE id='$tud_id'");
        }
        
        $query = mysqli_query($connect, "INSERT INTO `themes` (name, csspath, default_theme) VALUES('$name', '$csspath', '$default')");
    }
}
?>
                    
                <div class="row">
				<div class="col-md-9">
				
				<?php
if (isset($_GET['edit-id'])) {
    $id  = (int) $_GET["edit-id"];
    $sql = mysqli_query($connect, "SELECT * FROM `themes` WHERE id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=themes.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=themes.php">';
    }
    
    if (isset($_POST['edit'])) {
        $name    = $_POST['name'];
        $csspath = $_POST['csspath'];
        $default = $_POST['default'];
        
        $queryvalid = mysqli_query($connect, "SELECT * FROM `themes` WHERE csspath='$csspath' AND id != '$id' LIMIT 1");
        $validator  = mysqli_num_rows($queryvalid);
        if ($validator > "0") {
            echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> This <strong>Theme</strong> is already added.</p>
        </div>';
        } else {
            
            if ($default == 'Yes') {
                $queryud = mysqli_query($connect, "SELECT * FROM `themes` WHERE default_theme='Yes' LIMIT 1");
                $rowud   = mysqli_fetch_assoc($queryud);
                
                $tud_id = $rowud['id'];
                
                $query = mysqli_query($connect, "UPDATE `themes` SET `default_theme`='No' WHERE id='$tud_id'");
            }
            
            $query = mysqli_query($connect, "UPDATE `themes` SET name='$name', `csspath`='$csspath', `default_theme`='$default' WHERE id='$id'");
            echo '<meta http-equiv="refresh" content="0; url=themes.php">';
        }
    }
?>
<form class="form-horizontal" action="" method="post">
                     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Theme</h3>
						</div>
				        <div class="box-body">
								<div class="form-group">
											<label class="col-sm-2 control-label">Name: </label>
											<div class="col-sm-10">
												<input type="text" name="name" class="form-control" value="<?php
    echo $row['name'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">CSS Path: </label>
											<div class="col-sm-10">
												<input type="text" name="csspath" class="form-control" value="<?php
    echo $row['csspath'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">Default Theme: </label>
											<div class="col-sm-10">
	<select name="default" class="form-control" required>
        <option value="No" <?php
    if ($row['default_theme'] == 'No') {
        echo 'selected';
    }
?>>No</option>
        <option value="Yes" <?php
    if ($row['default_theme'] == 'Yes') {
        echo 'selected';
    }
?>>Yes</option>
    </select>
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
							<h3 class="box-title">Themes</h3>
						</div>
						<div class="box-body">
<div class="table-responsive"> 
<table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>Theme</th>
											<th>CSS Path</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = mysqli_query($connect, "SELECT * FROM `themes`");
while ($row = mysqli_fetch_assoc($query)) {
    echo '
										<tr>
											<td>' . $row['id'] . '</td>
                                            <td>' . $row['name'] . '';
    if ($row['default_theme'] == 'Yes') {
        echo '&nbsp;&nbsp;&nbsp;<span class="label label-primary">Default</span>';
    }
    echo '</td>
											<td>' . $row['csspath'] . '</td>
											<td>
                                            <a href="?edit-id=' . $row['id'] . '" class="btn btn-flat btn-flat btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-flat btn-danger"><i class="fas fa-trash"></i> Delete</a>
											</td>
										</tr>
';
}
?>
									</tbody>
								</table></div>
                        </div>
                     </div>
                </div>
                    
				<div class="col-md-3">
<form class="form-horizontal" action="" method="post">
				     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Add Theme</h3>
						</div>
				        <div class="box-body">
								<div class="form-group">
											<label class="col-sm-4 control-label">Name: </label>
											<div class="col-sm-8">
												<input type="text" name="name" class="form-control" required>
											</div>
							    </div>
								<div class="form-group">
											<label class="col-sm-4 control-label">CSS Path: </label>
											<div class="col-sm-8">
												<input type="text" name="csspath" class="form-control" placeholder="assets/css/skins/" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Default Theme: </label>
											<div class="col-sm-8">
	<select name="default" class="form-control" required>
        <option value="No" selected>No</option>
        <option value="Yes">Yes</option>
    </select>
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
  
<?php
footer();
?>