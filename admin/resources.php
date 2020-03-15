<?php
require("core.php");
head();


if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    $query = mysqli_query($connect, "DELETE FROM `paid_services` WHERE id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-dollar-sign"></i> Resources</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Resources</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">

<?php
if (isset($_POST['add'])) {
    $service  = $_POST['service'];
    $image    = $_POST['image'];
    $type     = $_POST['type'];
    $amount   = $_POST['amount'];
    $cost     = $_POST['cost'];
    $currency = $_POST['currency'];
    
    $query = mysqli_query($connect, "INSERT INTO `paid_services` (service, type, image, amount, cost, currency) VALUES('$service', '$type', '$image', '$amount', '$cost', '$currency')");
}
?>
                    
                <div class="row">
				<div class="col-md-8">
				
				<?php
if (isset($_GET['edit-id'])) {
    $id  = (int) $_GET["edit-id"];
    $sql = mysqli_query($connect, "SELECT * FROM `paid_services` WHERE id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=resources.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=resources.php">';
    }
    
    if (isset($_POST['edit'])) {
        $service  = $_POST['service'];
        $image    = $_POST['image'];
        $type     = $_POST['type'];
        $amount   = $_POST['amount'];
        $cost     = $_POST['cost'];
        $currency = $_POST['currency'];
        
        $query = mysqli_query($connect, "UPDATE `paid_services` SET service='$service', type='$type', `image`='$image', `amount`='$amount', `cost`='$cost', `currency`='$currency' WHERE id='$id'");
        echo '<meta http-equiv="refresh" content="0; url=resources.php">';
    }
?>
<form class="form-horizontal" action="" method="post">
                     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Resource</h3>
						</div>
				        <div class="box-body">
						        <div class="form-group">
											<label class="col-sm-2 control-label">Resource Name: </label>
											<div class="col-sm-10">
												<input type="text" name="service" class="form-control" value="<?php
    echo $row['service'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">Resource Type: </label>
											<div class="col-sm-10">
	<select name="type" class="form-control" required>
        <option value="getmoney"
<?php
    if ($row['type'] == 'getmoney') {
        echo ' selected';
    }
?>>Money</option>
        <option value="getgold"
<?php
    if ($row['type'] == 'getgold') {
        echo ' selected';
    }
?>>Gold</option>
		<option value="energyrefill
<?php
    if ($row['type'] == 'energyrefill') {
        echo ' selected';
    }
?>">Energy Refill</option>
		<option value="vip"
<?php
    if ($row['type'] == 'vip') {
        echo ' selected';
    }
?>>VIP Status</option>
    </select>
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
											<label class="col-sm-2 control-label">Amount: </label>
											<div class="col-sm-10">
												<input type="number" name="amount" min="0" class="form-control" value="<?php
    echo $row['amount'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">Cost: </label>
											<div class="col-sm-10">
												<input type="number" name="cost" min="0" class="form-control" value="<?php
    echo $row['cost'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">Currency: </label>
											<div class="col-sm-10">
	<select name="currency" class="form-control" required>
        <option value="USD"
<?php
    if ($row['currency'] == 'USD') {
        echo ' selected';
    }
?>>USD</option>
        <option value="EUR"
<?php
    if ($row['currency'] == 'EUR') {
        echo ' selected';
    }
?>>EUR</option>
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
							<h3 class="box-title">Resources</h3>
						</div>
						<div class="box-body">
<table id="dt-basic" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										    <th>ID</th>
											<th>Resource Type</th>
											<th>Resource Type</th>
											<th>Amount</th>
											<th>Cost</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = mysqli_query($connect, "SELECT * FROM `paid_services`");
while ($row = mysqli_fetch_assoc($query)) {
    echo '
										<tr>
										    <td>' . $row['id'] . '</td>
											<td><center><img src="../' . $row['image'] . '" width="60px" height="60px"> ' . $row['service'] . '</center></td>
											<td>';
    if ($row['type'] == 'getmoney') {
        echo 'Money';
    }
    if ($row['type'] == 'getgold') {
        echo 'Gold';
    }
    if ($row['type'] == 'energyrefill') {
        echo 'Energy Refill';
    }
    if ($row['type'] == 'vip') {
        echo 'VIP Status';
    }
    echo '</td>
                                            <td>' . $row['amount'] . '</td>
											<td>' . $row['cost'] . ' ' . $row['currency'] . '</td>
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
							<h3 class="box-title">Add Resource</h3>
						</div>
				        <div class="box-body">
						        <div class="form-group">
											<label class="col-sm-4 control-label">Resource Name: </label>
											<div class="col-sm-8">
												<input type="text" name="service" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Resource Type: </label>
											<div class="col-sm-8">
	<select name="type" class="form-control" required>
        <option value="getmoney" selected>Money</option>
        <option value="getgold">Gold</option>
		<option value="energyrefill">Energy Refill</option>
		<option value="vip">VIP Status</option>
    </select>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Image: </label>
											<div class="col-sm-8">
												<input type="text" name="image" class="form-control" placeholder="images/icons/" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Amount: </label>
											<div class="col-sm-8">
												<input type="number" name="amount" min="0" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Cost: </label>
											<div class="col-sm-8">
												<input type="number" name="cost" min="0" class="form-control" value="" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Currency: </label>
											<div class="col-sm-8">
	<select name="currency" class="form-control" required>
        <option value="USD" selected>USD</option>
        <option value="EUR">EUR</option>
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