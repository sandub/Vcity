<?php
require("core.php");
head();


if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    $query = mysqli_query($connect, "DELETE FROM `languages` WHERE id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-globe"></i> Languages</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Languages</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">

<?php
if (isset($_POST['add'])) {
    $language = $_POST['language'];
    $langcode = $_POST['langcode'];
    $default  = $_POST['default'];
    
    $queryvalid = mysqli_query($connect, "SELECT * FROM `languages` WHERE langcode='$langcode' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
        echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> This <strong>Language</strong> is already added.</p>
        </div>
		';
    } else {
        
        if ($default == 'Yes') {
            $queryud = mysqli_query($connect, "SELECT * FROM `languages` WHERE default_language='Yes' LIMIT 1");
            $rowud   = mysqli_fetch_assoc($queryud);
            
            $tud_id = $rowud['id'];
            
            $query = mysqli_query($connect, "UPDATE `languages` SET `default_language`='No' WHERE id='$tud_id'");
        }
        
        $file    = '../languages/en.php';
        $newfile = '../languages/' . $langcode . '.php';
        
        if (!copy($file, $newfile)) {
            echo "Failed to create language $file";
        }
        
        $query = mysqli_query($connect, "INSERT INTO `languages` (language, langcode, default_language) VALUES('$language', '$langcode', '$default')");
    }
}
?>
                    
                <div class="row">
				<div class="col-md-9">
				
				<?php
if (isset($_GET['edit-id'])) {
    $id  = (int) $_GET["edit-id"];
    $sql = mysqli_query($connect, "SELECT * FROM `languages` WHERE id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=languages.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=languages.php">';
    }
    
    if (isset($_POST['edit'])) {
        $language = $_POST['language'];
        $langcode = $_POST['langcode'];
        $default  = $_POST['default'];
        
        $queryvalid = mysqli_query($connect, "SELECT * FROM `languages` WHERE langcode='$langcode' AND id != '$id' LIMIT 1");
        $validator  = mysqli_num_rows($queryvalid);
        if ($validator > "0") {
            echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> This <strong>Language</strong> is already added.</p>
        </div>';
        } else {
            
            if ($default == 'Yes') {
                $queryud = mysqli_query($connect, "SELECT * FROM `languages` WHERE default_language='Yes' LIMIT 1");
                $rowud   = mysqli_fetch_assoc($queryud);
                
                $tud_id = $rowud['id'];
                
                $query = mysqli_query($connect, "UPDATE `languages` SET `default_language`='No' WHERE id='$tud_id'");
            }
            
            $query = mysqli_query($connect, "UPDATE `languages` SET language='$language', `langcode`='$langcode', `default_language`='$default' WHERE id='$id'");
            echo '<meta http-equiv="refresh" content="0; url=languages.php">';
        }
    }
?>
<form class="form-horizontal" action="" method="post">
                     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Language</h3>
						</div>
				        <div class="box-body">
								<div class="form-group">
											<label class="col-sm-2 control-label">Language: </label>
											<div class="col-sm-10">
												<input type="text" name="language" class="form-control" value="<?php
    echo $row['language'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">Language Code: </label>
											<div class="col-sm-10">
												<input type="text" name="langcode" class="form-control" value="<?php
    echo $row['langcode'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">Default Language: </label>
											<div class="col-sm-10">
	<select name="default" class="form-control" required>
        <option value="No" <?php
    if ($row['default_language'] == 'No') {
        echo 'selected';
    }
?>>No</option>
        <option value="Yes" <?php
    if ($row['default_language'] == 'Yes') {
        echo 'selected';
    }
?>>Yes</option>
    </select>
											</div>
								</div><hr />
								<p>To translate the strings in the file you should open & edit the following file via File Manager software: 
								<pre><?php
    echo '../languages/' . $row['langcode'] . '.php';
?></pre></p>
								<div class="form-group">
											<label class="col-sm-2 control-label">Translation Preview: </label>
											<div class="col-sm-10">
<?php
    $file = file('../languages/' . $row['langcode'] . '.php');
    echo '<textarea name="translate" class="form-control" rows="30" disabled>';
    foreach ($file as $text) {
        echo $text;
    }
    echo "</textarea><br />";
?>
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
							<h3 class="box-title">Languages</h3>
						</div>
						<div class="box-body">
<table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>Language</th>
											<th>Language Code</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = mysqli_query($connect, "SELECT * FROM `languages`");
while ($row = mysqli_fetch_assoc($query)) {
    echo '
										<tr>
											<td>' . $row['id'] . '</td>
                                            <td>' . $row['language'] . '';
    if ($row['default_language'] == 'Yes') {
        echo '&nbsp;&nbsp;&nbsp;<span class="label label-primary">Default</span>';
    }
    echo '</td>
											<td>' . $row['langcode'] . '</td>
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
							<h3 class="box-title">Add Language</h3>
						</div>
				        <div class="box-body">
								<div class="form-group">
											<label class="col-sm-4 control-label">Language: </label>
											<div class="col-sm-8">
												<input type="text" name="language" class="form-control" required>
											</div>
							    </div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Language Code: </label>
											<div class="col-sm-8">
												<input type="text" name="langcode" class="form-control" placeholder="en" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Default Language: </label>
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