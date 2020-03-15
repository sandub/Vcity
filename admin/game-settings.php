<?php
require("core.php");
head();

if (isset($_POST['save'])) {
    
    $title        = addslashes(strip_tags($_POST['title']));
    $description  = addslashes(strip_tags($_POST['description']));
    $keywords     = addslashes(strip_tags($_POST['keywords']));
    $start_money  = addslashes(strip_tags($_POST['start-money']));
    $start_gold   = addslashes(strip_tags($_POST['start-gold']));
    $paypal_email = addslashes(strip_tags($_POST['paypal-email']));
    
    $content = htmlentities($_POST['content']);
    
    $query = mysqli_query($connect, "UPDATE `settings` SET title='$title', description='$description', keywords='$keywords', startmoney='$start_money', startgold='$start_gold', paypal_email='$paypal_email', about='$content' WHERE id=1");
    
    echo '<meta http-equiv="refresh" content="0; url=game-settings.php" />';
    
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-cogs"></i> Game Settings</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Game Settings</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">

                <div class="row">
                    
				<div class="col-md-12">
<form class="form-horizontal" method="post">
				    <div class="box">
						<div class="box-header">
							<h3 class="box-title"><i class="fas fa-cog"></i> Game Settings</h3>
						</div>
						<div class="box-body">
<?php
$query = mysqli_query($connect, "SELECT * FROM `settings`");
$row   = mysqli_fetch_array($query);
?>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Title:</label>
												<div class="col-md-8">
                                                    <div class="input-group">
                                                    <span class="input-group-addon"><i class="fas fa-font"></i></span>
													<input type="text" class="form-control" name="title" value="<?php
echo $row['title'];
?>" required>
                                                    </div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Description:</label>
												<div class="col-md-8">
                                                    <div class="input-group">
                                                    <span class="input-group-addon"><i class="fas fa-align-justify"></i></span>
													<input type="text" class="form-control" name="description" value="<?php
echo $row['description'];
?>">
                                                    </div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Keywords:</label>
												<div class="col-md-8">
                                                    <div class="input-group">
                                                    <span class="input-group-addon"><i class="fab fa-searchengin"></i></span>
													<input type="text" class="form-control" name="keywords" value="<?php
echo $row['keywords'];
?>">
                                                    </div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Start Money:</label>
												<div class="col-md-8">
                                                    <div class="input-group">
                                                    <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
													<input type="number" class="form-control" name="start-money" value="<?php
echo $row['startmoney'];
?>" min="0" required>
                                                    </div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Start Gold:</label>
												<div class="col-md-8">
                                                    <div class="input-group">
                                                    <span class="input-group-addon"><i class="fas fa-inbox"></i></span>
													<input type="number" class="form-control" name="start-gold" value="<?php
echo $row['startgold'];
?>" min="0" required>
                                                    </div>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">PayPal:</label>
												<div class="col-md-8">
                                                    <div class="input-group">
                                                    <span class="input-group-addon"><i class="fab fa-paypal"></i></span>
													<input type="email" class="form-control" name="paypal-email" value="<?php
echo $row['paypal_email'];
?>">
                                                    </div>
												</div>
											</div>
											
											<br /><h4 class="box-title"><i class="far fa-file-alt"></i> About The Game</h4>
											
										    <div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Content:</label>
												<div class="col-md-8">
                                                    <div class="input-group">
                                                    <span class="input-group-addon"><i class="far fa-file-alt"></i></span>
													<textarea class="form-control" name="content" rows="20"><?php
echo $row['about'];
?></textarea>
                                                    </div>
												</div>
											</div>
											
                        </div>
                        <div class="panel-footer text-left">
							<button class="btn btn-flat btn-primary" name="save" type="submit">Save</button>
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