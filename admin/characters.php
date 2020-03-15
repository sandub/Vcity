<?php
require("core.php");
head();


if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    $query = mysqli_query($connect, "DELETE FROM `characters` WHERE id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-street-view"></i> Characters</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Characters</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">

<?php
if (isset($_POST['add'])) {
    $name         = $_POST['name'];
    $image        = $_POST['image'];
    $category_id  = $_POST['category-id'];
    $power        = $_POST['power'];
    $agility      = $_POST['agility'];
    $endurance    = $_POST['endurance'];
    $intelligence = $_POST['intelligence'];
    
    $query = mysqli_query($connect, "INSERT INTO `characters` (name, image, category_id, power, agility, endurance, intelligence) VALUES('$name', '$image', '$category_id', '$power', '$agility', '$endurance', '$intelligence')");
}
?>
                    
                <div class="row">
				<div class="col-md-9">
				
				<?php
if (isset($_GET['edit-id'])) {
    $id  = (int) $_GET["edit-id"];
    $sql = mysqli_query($connect, "SELECT * FROM `characters` WHERE id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=characters.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=characters.php">';
    }
    
    if (isset($_POST['edit'])) {
        $name         = $_POST['name'];
        $image        = $_POST['image'];
        $category_id  = $_POST['category-id'];
        $power        = $_POST['power'];
        $agility      = $_POST['agility'];
        $endurance    = $_POST['endurance'];
        $intelligence = $_POST['intelligence'];
        
        $query = mysqli_query($connect, "UPDATE `characters` SET name='$name', `image`='$image', `category_id`='$category_id', `power`='$power', `agility`='$agility', `endurance`='$endurance', `intelligence`='$intelligence' WHERE id='$id'");
        echo '<meta http-equiv="refresh" content="0; url=characters.php">';
        
    }
?>
<form class="form-horizontal" action="" method="post">
                     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Character</h3>
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
											<label class="col-sm-2 control-label">Image: </label>
											<div class="col-sm-10">
												<input type="text" name="image" class="form-control" value="<?php
    echo $row['image'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">Category: </label>
											<div class="col-sm-10">
	<select name="category-id" class="form-control" required>
									<?php
    $crun = mysqli_query($connect, "SELECT * FROM `character_categories`");
    while ($rw = mysqli_fetch_assoc($crun)) {
        echo '
                                    <option value="' . $rw['id'] . '"';
        if ($rw['id'] == $row['category_id']) {
            echo 'selected';
        }
        echo '>' . $rw['category'] . '</option>
									';
    }
?>
    </select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Power: </label>
											<div class="col-sm-10">
	<select name="power" class="form-control" required>
        <option value="No" <?php
    if ($row['power'] == 'No') {
        echo 'selected';
    }
?>>No</option>
        <option value="Yes" <?php
    if ($row['power'] == 'Yes') {
        echo 'selected';
    }
?>>Yes</option>
    </select>
	                                         </div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Agility: </label>
											<div class="col-sm-10">
	<select name="agility" class="form-control" required>
        <option value="No" <?php
    if ($row['agility'] == 'No') {
        echo 'selected';
    }
?>>No</option>
        <option value="Yes" <?php
    if ($row['agility'] == 'Yes') {
        echo 'selected';
    }
?>>Yes</option>
    </select>
	                                         </div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Endurance: </label>
											<div class="col-sm-10">
	<select name="endurance" class="form-control" required>
        <option value="No" <?php
    if ($row['endurance'] == 'No') {
        echo 'selected';
    }
?>>No</option>
        <option value="Yes" <?php
    if ($row['endurance'] == 'Yes') {
        echo 'selected';
    }
?>>Yes</option>
    </select>
	                                         </div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Intelligence: </label>
											<div class="col-sm-10">
	<select name="intelligence" class="form-control" required>
        <option value="No" <?php
    if ($row['intelligence'] == 'No') {
        echo 'selected';
    }
?>>No</option>
        <option value="Yes" <?php
    if ($row['intelligence'] == 'Yes') {
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
							<h3 class="box-title">Characters</h3>
						</div>
						<div class="box-body">
<table id="dt-basic" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>Name</th>
											<th>Category</th>
											<th>Power</th>
											<th>Agility</th>
											<th>Endurance</th>
											<th>Intelligence</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = mysqli_query($connect, "SELECT * FROM `characters`");
while ($row = mysqli_fetch_assoc($query)) {
    $ccid  = $row['category_id'];
    $sqlcc = mysqli_query($connect, "SELECT * FROM `character_categories` WHERE id='$ccid' LIMIT 1");
    $rowcc = mysqli_fetch_assoc($sqlcc);
    echo '
										<tr>
											<td>' . $row['id'] . '</td>
                                            <td><img src="../' . $row['image'] . '" width="30px" height="30px"> ' . $row['name'] . '</td>
											<td>' . $rowcc['category'] . '</td>
											<td>' . $row['power'] . '</td>
											<td>' . $row['agility'] . '</td>
											<td>' . $row['endurance'] . '</td>
											<td>' . $row['intelligence'] . '</td>
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
							<h3 class="box-title">Add Character</h3>
						</div>
				        <div class="box-body">
								<div class="form-group">
											<label class="col-sm-4 control-label">Name: </label>
											<div class="col-sm-8">
												<input type="text" name="name" class="form-control" required>
											</div>
							    </div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Image: </label>
											<div class="col-sm-8">
												<input type="text" name="image" class="form-control" placeholder="images/characters/" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Category: </label>
											<div class="col-sm-8">
	<select name="category-id" class="form-control" required>
<?php
$crun = mysqli_query($connect, "SELECT * FROM `character_categories`");
while ($rw = mysqli_fetch_assoc($crun)) {
    echo '
                                    <option value="' . $rw['id'] . '">' . $rw['category'] . '</option>
									';
}
?>
    </select>
											</div>
										</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Power: </label>
											<div class="col-sm-8">
	<select name="power" class="form-control" required>
        <option value="No" selected>No</option>
        <option value="Yes">Yes</option>
    </select>
											</div>
										</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Agility: </label>
											<div class="col-sm-8">
	<select name="agility" class="form-control" required>
        <option value="No" selected>No</option>
        <option value="Yes">Yes</option>
    </select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">Endurance: </label>
											<div class="col-sm-8">
	<select name="endurance" class="form-control" required>
        <option value="No" selected>No</option>
        <option value="Yes">Yes</option>
    </select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">Intelligence: </label>
											<div class="col-sm-8">
	<select name="intelligence" class="form-control" required>
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