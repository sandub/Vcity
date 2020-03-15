<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_POST['save'])) {
    $email    = $_POST['email'];
    $avatar   = $_POST['avatar'];
    $password = $_POST['password'];
    
    $emused = 'No';
    
    $susere  = mysqli_query($connect, "SELECT * FROM `players` WHERE email='$email' && id != $player_id LIMIT 1");
    $countue = mysqli_num_rows($susere);
    if ($countue > 0) {
        $emused = 'Yes';
    }
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && $emused == 'No') {
        
        if ($password != null) {
            $password = hash('sha256', $_POST['password']);
            $querysd  = mysqli_query($connect, "UPDATE `players` SET email='$email', avatar='$avatar', password='$password' WHERE id='$player_id'");
        } else {
            $querysd = mysqli_query($connect, "UPDATE `players` SET email='$email', avatar='$avatar' WHERE id='$player_id'");
        }
        
    }
    
    echo '<meta http-equiv="refresh" content="0;url=settings.php">';
}
?>
<div class="col-md-12 well">

    <center><h2><i class="fa fa-cog"></i> <?php
echo lang_key("account-settings");
?></h2></center><br />

    <div class="row">

        <div class="col-md-1"></div>
		<div class="col-md-10">
		    
			<form action="" method="post">
			    <div class="form-group">
 			       <label for="email"><i class="fa fa-user"></i> <?php
echo lang_key("email-address");
?></label>
                   <input type="email" class="form-control" id="email" name="email" value="<?php
echo $rowu['email'];
?>">
 			    </div>
				<div class="form-group">
 			       <label for="avatar"><i class="fa fa-user"></i> <?php
echo lang_key("avatar");
?></label>
                   <input type="text" class="form-control" id="avatar" name="avatar" value="<?php
echo $rowu['avatar'];
?>"><br />
				   <center><div class="well" style="width: 15%;"><img src="<?php
echo $rowu['avatar'];
?>" width="100%"></div></center>
 			    </div>
				<div class="form-group">
 			       <label for="password"><i class="fa fa-user"></i> <?php
echo lang_key("new-password");
?></label>
                   <input type="password" class="form-control" id="password" name="password" value="">
				   <i><?php
echo lang_key("password-message");
?></i><br /><br />
 			    </div>
 			    <button type="submit" name="save" class="btn btn-primary btn-block"><i class="far fa-floppy"></i>&nbsp; <?php
echo lang_key("save");
?></button>
			</form>
			
		</div>
		<div class="col-md-1"></div>

    </div>
</div>
<?php
footer();
?>