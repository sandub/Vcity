<?php
include '../config.php';

if (isset($_SESSION['username'])) {
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' AND role='Yes'");
    $count = mysqli_num_rows($suser);
    if ($count < 0) {
        echo '<meta http-equiv="refresh" content="0; url=index.php" />';
        exit;
    }
} else {
    echo '<meta http-equiv="refresh" content="0; url=index.php" />';
    exit;
}

if (basename($_SERVER['SCRIPT_NAME']) != 'game-settings.php') {
    $_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
}

function head()
{
    include '../config.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <title>vCity &rsaquo; Admin Panel</title>


    <!--STYLESHEET-->
    <!--=================================================-->

	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	
    <!--Bootstrap Stylesheet-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/red-skin.min.css">

	<!--Font Awesome-->
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
	
	<!--Stylesheet-->
    <link href="assets/css/admin.min.css" rel="stylesheet">

    <!--DataTables-->
    <link href="assets/plugins/datatables/datatables.min.css" rel="stylesheet">
    
	<!--DatePicker-->
    <link href="assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
	
    <!--SCRIPT-->
    <!--=================================================-->

    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

</head>

<body class="hold-transition skin-red sidebar-mini" onload="startTime()">
<div class="wrapper">

  <header class="main-header">

    <a href="dashboard.php" class="logo">
      <span class="logo-mini"><i class="fas fa-heart"></i> v<strong>City</strong></span>
      <span class="logo-lg"><i class="fas fa-heart"></i> v<strong>City</strong></span>
    </a>

    <nav class="navbar navbar-static-top">

      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
	    <i class="fas fa-bars"></i>
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li>
             <a href="../" target="_blank">
			 <span><i class="fas fa-desktop"></i>&nbsp;&nbsp;View Game</span>
			 </a>
          </li>
          <li>
             <a href="game-settings.php"><span><i class="fas fa-cogs"></i>&nbsp;&nbsp;Settings</span></a>
          </li>
<?php
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' AND role='Admin'");
    $urow  = mysqli_fetch_array($suser);
?>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="assets/img/avatar.png" class="user-image" alt="Admin Image">
              <span class="hidden-xs"><?php
    echo $_SESSION['username'];
?></span>
            </a>
            <ul class="dropdown-menu">

              <li class="user-header">
                <img src="assets/img/avatar.png" class="img-circle" alt="Admin Image">

                <p>
                  <i class="fas fa-user"></i> <?php
    echo $_SESSION['username'];
?>
                  <small><i class="fas fa-envelope"></i> <?php
    echo $urow['email'];
?></small>
                </p>
              </li>

              <li class="user-footer">
                <div class="pull-left">
                  <a href="players.php?edit-id=<?php
    echo $urow['id'];
?>" class="btn btn-default btn-flat"><i class="fas fa-edit fa-fw fa-lg"></i> Edit Profile</a>
                </div>
                <div class="pull-right">
                  <a href="../logout.php" class="btn btn-default btn-flat"><i class="fas fa-sign-out-alt fa-fw"></i> Logout</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <aside class="main-sidebar">

    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="assets/img/avatar.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php
    echo $_SESSION['username'];
?></p>
          <a href="#"><i class="fas fa-envelope"></i> <?php
    echo $urow['email'];
?></a>
        </div>
      </div>

      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">NAVIGATION</li>
        
        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'dashboard.php') {
        echo 'class="active"';
    }
?>>
           <a href="dashboard.php">
              <i class="fas fa-home"></i>&nbsp; <span>Dashboard</span>
           </a>
        </li>
          
        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'game-settings.php') {
        echo 'class="active"';
    }
?>>
           <a href="game-settings.php">
              <i class="fas fa-cogs"></i>&nbsp; <span>Game Settings</span>
           </a>
        </li>
          
        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'themes.php') {
        echo 'class="active"';
    }
?>>
           <a href="themes.php">
              <i class="fas fa-paint-brush"></i>&nbsp; <span>Themes</span>
           </a>
        </li>
          
        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'languages.php') {
        echo 'class="active"';
    }
?>>
           <a href="languages.php">
              <i class="fas fa-globe"></i>&nbsp; <span>Languages</span>
           </a>
        </li>

        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'payments.php') {
        echo 'class="active"';
    }
?>>
           <a href="payments.php">
              <i class="fas fa-dollar-sign"></i>&nbsp; <span>Payments</span>
           </a>
        </li>
		
		<li class="header">Game Modules</li>
          
        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'players.php') {
        echo 'class="active"';
    }
?>>
           <a href="players.php">
              <i class="fas fa-users"></i>&nbsp; <span>Players</span>
           </a>
        </li>
          
        <li class="treeview  <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'characters.php' OR basename($_SERVER['SCRIPT_NAME']) == 'character-categories.php') {
        echo 'active';
    }
?>">
           <a href="#">
              <i class="fas fa-street-view"></i>&nbsp; <span>Characters</span> <i class="fas fa-angle-right pull-right"></i>
           </a>
           <ul class="treeview-menu">
               <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'characters.php') {
        echo 'class="active"';
    }
?>><a href="characters.php"><i class="fas fa-street-view"></i>&nbsp; Characters</a></li>
               <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'character-categories.php') {
        echo 'class="active"';
    }
?>><a href="character-categories.php"><i class="fas fa-list-ul"></i>&nbsp; Character Categories</a></li>
           </ul>
        </li>
          
        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'levels.php') {
        echo 'class="active"';
    }
?>>
           <a href="levels.php">
              <i class="fas fa-star"></i>&nbsp; <span>Levels</span>
           </a>
        </li>
          
        <li class="treeview  <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'vehicles.php' OR basename($_SERVER['SCRIPT_NAME']) == 'vehicle-categories.php') {
        echo 'active';
    }
?>">
           <a href="#">
              <i class="fas fa-car"></i>&nbsp; <span>Vehicles</span> <i class="fas fa-angle-right pull-right"></i>
           </a>
           <ul class="treeview-menu">
               <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'vehicles.php') {
        echo 'class="active"';
    }
?>><a href="vehicles.php"><i class="fas fa-car"></i>&nbsp; Vehicles</a></li>
               <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'vehicle-categories.php') {
        echo 'class="active"';
    }
?>><a href="vehicle-categories.php"><i class="fas fa-list-ul"></i>&nbsp; Vehicle Categories</a></li>
           </ul>
        </li>
          
        <li class="treeview  <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'items.php' OR basename($_SERVER['SCRIPT_NAME']) == 'item-categories.php') {
        echo 'active';
    }
?>">
           <a href="#">
              <i class="fas fa-shopping-cart"></i>&nbsp; <span>Items</span> <i class="fas fa-angle-right pull-right"></i>
           </a>
           <ul class="treeview-menu">
               <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'items.php') {
        echo 'class="active"';
    }
?>><a href="items.php"><i class="fas fa-shopping-cart"></i>&nbsp; Items</a></li>
               <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'item-categories.php') {
        echo 'class="active"';
    }
?>><a href="item-categories.php"><i class="fas fa-list-ul"></i>&nbsp; Item Categories</a></li>
           </ul>
        </li>
          
		<li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'properties.php') {
        echo 'class="active"';
    }
?>>
           <a href="properties.php">
              <i class="fas fa-building"></i>&nbsp; <span>Properties</span>
           </a>
        </li>
		  
        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'pets.php') {
        echo 'class="active"';
    }
?>>
           <a href="pets.php">
              <i class="fas fa-paw"></i>&nbsp; <span>Pets</span>
           </a>
        </li>
		
		<li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'jobs.php') {
        echo 'class="active"';
    }
?>>
           <a href="jobs.php">
              <i class="fas fa-briefcase"></i>&nbsp; <span>Jobs</span>
           </a>
        </li>
		
		<li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'gym.php') {
        echo 'class="active"';
    }
?>>
           <a href="gym.php">
              <i class="fas fa-futbol"></i>&nbsp; <span>Gym</span>
           </a>
        </li>
		
		<li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'school.php') {
        echo 'class="active"';
    }
?>>
           <a href="school.php">
              <i class="fas fa-graduation-cap"></i>&nbsp; <span>School</span>
           </a>
        </li>
		
		<li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'hospital.php') {
        echo 'class="active"';
    }
?>>
           <a href="hospital.php">
              <i class="fas fa-hospital"></i>&nbsp; <span>Hospital</span>
           </a>
        </li>
		
		<li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'homes.php') {
        echo 'class="active"';
    }
?>>
           <a href="homes.php">
              <i class="fas fa-home"></i>&nbsp; <span>Homes</span>
           </a>
        </li>
		
		<li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'garages.php') {
        echo 'class="active"';
    }
?>>
           <a href="garages.php">
              <i class="fas fa-car"></i>&nbsp; <span>Garages</span>
           </a>
        </li>
		
		<li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'hangars.php') {
        echo 'class="active"';
    }
?>>
           <a href="hangars.php">
              <i class="fas fa-plane"></i>&nbsp; <span>Hangars</span>
           </a>
        </li>
		
		<li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'quays.php') {
        echo 'class="active"';
    }
?>>
           <a href="quays.php">
              <i class="fas fa-ship"></i>&nbsp; <span>Quays</span>
           </a>
        </li>
		
		<li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'casino-prizes.php') {
        echo 'class="active"';
    }
?>>
           <a href="casino-prizes.php">
              <i class="fas fa-gem"></i>&nbsp; <span>Casino Prizes</span>
           </a>
        </li>
		
		<li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'resources.php') {
        echo 'class="active"';
    }
?>>
           <a href="resources.php">
              <i class="fas fa-dollar-sign"></i>&nbsp; <span>Resources</span>
           </a>
        </li>
          
      </ul>
    </section>

  </aside>
<?php
}

function footer()
{
    include '../config.php';
?>
<footer class="main-footer">
    <strong>&copy; <?php
    echo date("Y");
?> <a href="https://codecanyon.net/user/antonov_web?ref=Antonov_WEB" target="_blank">vCity</a></strong>
	
</footer>

</div>

    <!--JAVASCRIPT-->
    <!--=================================================-->

    <!--Bootstrap-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<!--Admin-->
    <script src="assets/js/admin.min.js"></script>

    <!--DataTables-->
    <script src="assets/plugins/datatables/datatables.min.js"></script>
	
	<!--DatePicker-->
	<script src="assets/plugins/datepicker/datepicker.min.js"></script>
    <script src="assets/plugins/datepicker/datepicker.en.js"></script>

</body>
</html>
<?php
}
?>