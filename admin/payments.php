<?php
require("core.php");
head();
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-dollar-sign"></i> Payments</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Payments</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">

                <div class="row">
                    
				<div class="col-md-12">
                    <div class="box">
						<div class="box-header">
							<h3 class="box-title">Income Report</h3>
						</div>
						<div class="box-body">
						     
							 <table id="dt-basic" class="table table-bordered table-hover no-margin">
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
$sqlua = mysqli_query($connect, "SELECT * FROM `payments` ORDER BY id DESC");
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
					<td>' . $rowua['date'] . ' at ' . $rowua['time'] . '</td>
                  </tr>
';
}
?>				  
                  </tbody>
                </table>
							 
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