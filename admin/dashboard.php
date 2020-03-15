<?php
require("core.php");
head();
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-home"></i> Dashboard</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Dashboard</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">
                    
<h3 class="text-thin">Game Statistics</h3>
<?php
$date    = date('d F Y');
$query   = mysqli_query($connect, "SELECT * FROM `players`");
$count   = mysqli_num_rows($query);
$query2  = mysqli_query($connect, "SELECT * FROM `levels`");
$count2  = mysqli_num_rows($query2);
$query3  = mysqli_query($connect, "SELECT * FROM `characters`");
$count3  = mysqli_num_rows($query3);
$query4  = mysqli_query($connect, "SELECT * FROM `vehicles`");
$count4  = mysqli_num_rows($query4);
$query5  = mysqli_query($connect, "SELECT * FROM `items`");
$count5  = mysqli_num_rows($query5);
$query6  = mysqli_query($connect, "SELECT * FROM `properties`");
$count6  = mysqli_num_rows($query6);
$query7  = mysqli_query($connect, "SELECT * FROM `pets`");
$count7  = mysqli_num_rows($query7);
$query8  = mysqli_query($connect, "SELECT * FROM `jobs`");
$count8  = mysqli_num_rows($query8);
$query9  = mysqli_query($connect, "SELECT * FROM `gym`");
$count9  = mysqli_num_rows($query9);
$query10 = mysqli_query($connect, "SELECT * FROM `school`");
$count10 = mysqli_num_rows($query10);
$query11 = mysqli_query($connect, "SELECT * FROM `hospital`");
$count11 = mysqli_num_rows($query11);
$query12 = mysqli_query($connect, "SELECT * FROM `homes`");
$count12 = mysqli_num_rows($query12);
$query13 = mysqli_query($connect, "SELECT * FROM `garages`");
$count13 = mysqli_num_rows($query13);
$query14 = mysqli_query($connect, "SELECT * FROM `hangars`");
$count14 = mysqli_num_rows($query14);
$query15 = mysqli_query($connect, "SELECT * FROM `quays`");
$count15 = mysqli_num_rows($query15);
$query16 = mysqli_query($connect, "SELECT * FROM `paid_services`");
$count16 = mysqli_num_rows($query16);
?>
                <div class="row">
                
					    <div class="col-sm-6 col-lg-3">
                            <div class="small-box bg-green">
                               <div class="inner">
                                   <h3><?php
echo $count;
?></h3>
                                   <p>Players</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-users"></i>
                               </div>
                               <a href="players.php" class="small-box-footer">View Players <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
					    <div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-green">
                               <div class="inner">
                                   <h3><?php
echo $count2;
?></h3>
                                   <p>Levels</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-star"></i>
                               </div>
                               <a href="levels.php" class="small-box-footer">View Levels <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
					    <div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-green">
                               <div class="inner">
                                   <h3><?php
echo $count3;
?></h3>
                                   <p>Characters</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-street-view"></i>
                               </div>
                               <a href="characters.php" class="small-box-footer">View Characters <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
						<div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-green">
                               <div class="inner">
                                   <h3><?php
echo $count16;
?></h3>
                                   <p>Resources</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-dollar-sign"></i>
                               </div>
                               <a href="resources.php" class="small-box-footer">View Resources <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
					    <div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-aqua">
                               <div class="inner">
                                   <h3><?php
echo $count4;
?></h3>
                                   <p>Vehicles</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-car"></i>
                               </div>
                               <a href="vehicles.php" class="small-box-footer">View Vehicle <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
						<div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-aqua">
                               <div class="inner">
                                   <h3><?php
echo $count5;
?></h3>
                                   <p>Items</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-shopping-cart"></i>
                               </div>
                               <a href="items.php" class="small-box-footer">View Items <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
						<div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-aqua">
                               <div class="inner">
                                   <h3><?php
echo $count6;
?></h3>
                                   <p>Properties</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-building"></i>
                               </div>
                               <a href="properties.php" class="small-box-footer">View Properties <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
						<div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-aqua">
                               <div class="inner">
                                   <h3><?php
echo $count7;
?></h3>
                                   <p>Pets</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-paw"></i>
                               </div>
                               <a href="pets.php" class="small-box-footer">View Pets <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
						<div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-aqua">
                               <div class="inner">
                                   <h3><?php
echo $count12;
?></h3>
                                   <p>Home Upgrades</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-home"></i>
                               </div>
                               <a href="homes.php" class="small-box-footer">View Homes <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
						<div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-aqua">
                               <div class="inner">
                                   <h3><?php
echo $count13;
?></h3>
                                   <p>Garage Upgrades</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-car"></i>
                               </div>
                               <a href="garages.php" class="small-box-footer">View Garages <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
						<div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-aqua">
                               <div class="inner">
                                   <h3><?php
echo $count14;
?></h3>
                                   <p>Hangar Upgrades</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-plane"></i>
                               </div>
                               <a href="hangars.php" class="small-box-footer">View Hangars <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
						<div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-aqua">
                               <div class="inner">
                                   <h3><?php
echo $count15;
?></h3>
                                   <p>Quay Upgrades</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-ship"></i>
                               </div>
                               <a href="quays.php" class="small-box-footer">View Quays <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
					</div>

				<div class="row">
				
				<div class="col-md-7">
				     <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fas fa-dollar-sign"></i> Income Report</h3>
            </div>

            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover no-margin">
                  <thead>
                  <tr>
				    <th><i class="fas fa-list-ul"></i> ID</th>
                    <th><i class="fas fa-list-ul"></i> Transaction ID</th>
                    <th><i class="fas fa-user"></i> Player</th>
                    <th><i class="fas fa-star"></i> Resource</th>
					<th><i class="fas fa-dollar-sign"></i> Earnings</th>
                    <th><i class="fas fa-calendar"></i> Date</th>
                  </tr>
                  </thead>
                  <tbody>
<?php
$sqlua = mysqli_query($connect, "SELECT * FROM `payments` ORDER BY id DESC LIMIT 4");
while ($rowua = mysqli_fetch_assoc($sqlua)) {
    $pid   = $rowua['player_id'];
    $rid   = $rowua['service_id'];
    $sqlsu = mysqli_query($connect, "SELECT * FROM `players` WHERE id='$pid' LIMIT 1");
    $rowsu = mysqli_fetch_assoc($sqlsu);
    $sqlsr = mysqli_query($connect, "SELECT * FROM `paid_services` WHERE id='$rid' LIMIT 1");
    $rowsr = mysqli_fetch_assoc($sqlsr);
    echo '
                  <tr>
				    <td>' . $rowua['id'] . '</td>
                    <td>' . $rowua['txn_id'] . '</td>
                    <td>' . $rowsu['username'] . '</td>
                    <td>' . $rowsr['service'] . '</td>
					<td>' . $rowsr['cost'] . ' ' . $rowsr['currency'] . '</td>
					<td>' . $rowua['date'] . '</td>
                  </tr>
';
}
?>				  
                  </tbody>
                </table>
              </div>
            </div>

            <div class="box-footer clearfix">
              <a href="payments.php" class="btn btn-sm btn-default btn-flat pull-right"><i class="fas fa-arrow-circle-right"></i> View All Payments</a>
            </div>

          </div>
		  </div>
		  
		  <div class="col-md-5">
				     <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fas fa-users"></i> Last Registered Players</h3>
            </div>

            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover no-margin">
                  <thead>
                  <tr>
                    <th><i class="fas fa-list-ul"></i> ID</th>
                    <th><i class="fas fa-user"></i> Username</th>
					<th><i class="fas fa-envelope"></i> E-Mail Address</th>
                  </tr>
                  </thead>
                  <tbody>
<?php
$sqlua = mysqli_query($connect, "SELECT * FROM `players` ORDER BY id DESC LIMIT 6");
while ($rowua = mysqli_fetch_assoc($sqlua)) {
    echo '
                  <tr>
                    <td>' . $rowua['id'] . '</td>
                    <td>' . $rowua['username'] . '</td>
					<td>' . $rowua['email'] . '</td>
                  </tr>
';
}
?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="box-footer clearfix">
              <a href="players.php" class="btn btn-sm btn-default btn-flat pull-right"><i class="fas fa-arrow-circle-right"></i> View All Players</a>
            </div>

          </div>
		  </div>
				</div>
					
				<div class="row">
				   
				    <div class="col-md-6">
				    <div class="box">
						<div class="box-header">
							<h3 class="box-title"><i class="fas fa-clock"></i> Time</h3>
						</div>
						<div class="box-body">
                            <center><h4 id="clock"></h4></center>
                        </div>
                    </div>
                    </div>
					
					<div class="col-md-6">
				    <div class="box">
						<div class="box-header">
							<h3 class="box-title"><i class="fas fa-calendar"></i> Date</h3>
						</div>
						<div class="box-body">
                            <center><div class="datepicker-here" data-language='en'></div></center>
                        </div>
                    </div>
                    </div>
					
				</div>
                    
				</div>
				<!--===================================================-->
				<!--End page content-->


			</div>
			<!--===================================================-->
			<!--END CONTENT CONTAINER-->

<!--Time-->
<script>
	function startTime() {
	   var today = new Date();
	   var h = today.getHours();
 	   var m = today.getMinutes();
 	   var s = today.getSeconds();
 	   m = checkTime(m);
 	   s = checkTime(s);
 	   document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
 	   var t = setTimeout(startTime, 500);
	}
	
	function checkTime(i) {
 	   if (i < 10) {i = "0" + i};
 	   return i;
	}
</script>
<?php
footer();
?>