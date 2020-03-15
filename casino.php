<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_POST['buy-spins'])) {
    
    $quantity = $_POST['quantity'];
    
    $sum = $quantity * 850;
    
    if ($rowu['money'] >= $sum) {
        
        $spin_pay = mysqli_query($connect, "UPDATE `players` SET money=money-'850', spins=spins+'$quantity' WHERE id='$player_id'");
        
        echo '<meta http-equiv="refresh" content="0;url=casino.php">';
        
    } else {
        echo '<div class="alert alert-danger"><strong><i class="fa fa-times-circle"></i> ' . lang_key("no-moneyts") . ' ' . $quantity . ' ' . lang_key("spins") . '</strong></div>';
    }
}
?>

<div class="col-md-12 well">

    <center><h2><i class="fa fa-gem"></i> <?php
echo lang_key("casino");
?></h2></center><br />

    <div class="row">
		
		<div class="col-md-1"></div>
		<div class="col-md-10 jumbotron">
		<center>
		
		<center><h2><?php
echo lang_key("wheel-fortune");
?> &nbsp;
<?php
if ($rowu['spins'] > 0) {
    echo '<span class="label label-success"><i class="fa fa-sync"></i> ' . $rowu['spins'] . ' ' . lang_key("spins") . '</span>';
} else {
    echo '<span class="label label-danger"><i class="fa fa-sync"></i> ' . $rowu['spins'] . ' ' . lang_key("spins") . '</span>';
}
?>
		&nbsp;<button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#buyspins"><i class="fa fa-plus-square"></i> <?php
echo lang_key("buy-spins");
?></button>
		</h2></center><hr /><br />
		
<form action="" method="post">
<div id="buyspins" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus-square"></i> <?php
echo lang_key("buy-spins");
?></h4>
      </div>
      <div class="modal-body">
        <p><?php
echo lang_key("spin-prize1");
?>: <span class="label label-primary">$ 850</span></p>
		    <?php
echo lang_key("quantity");
?>: <input type="number" class="form-control" name="quantity" value="1" min="1" max="10" required>
      </div>
      <div class="modal-footer">
	    <input type="submit" class="btn btn-success" name="buy-spins" value="<?php
echo lang_key("buy");
?>" />
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php
echo lang_key("close");
?></button>
      </div>
    </div>

  </div>
</div>
</form>
		
		<table cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td>
                    <div class="power_controls">
                        <br />
                        <br />
                        <table class="power" cellpadding="10" cellspacing="0">
                            <tr>
                                <th align="center"><?php
echo lang_key("power");
?></th>
                            </tr>
                            <tr>
                                <td width="100" align="center" id="pw3" onClick="powerSelected(3);"><?php
echo lang_key("high");
?></td>
                            </tr>
                            <tr>
                                <td align="center" id="pw2" onClick="powerSelected(2);"><?php
echo lang_key("medium");
?></td>
                            </tr>
                            <tr>
                                <td align="center" id="pw1" onClick="powerSelected(1);"><?php
echo lang_key("low");
?></td>
                            </tr>
                        </table>
                        <br />
<?php
if ($rowu['spins'] > 0) {
    echo '<a href="#/" class="btn btn-success btn-block" id="spin_button" alt="Spin" onClick="startSpin();">' . lang_key("spin") . '</a>';
} else {
    echo '<a href="#/" class="btn btn-danger btn-block disabled">' . lang_key("spin") . '</a>';
}
?>
                    </div>
                </td>
				<td width="438" height="582" class="the_wheel" align="center" valign="center">
                    <canvas id="canvas" width="434" height="434"></canvas>
                </td>
				
				<div id="prize"></div>
            </tr>
        </table>
		</center>
		</div>
		<div class="col-md-1"></div>

    </div>
</div>
<?php
$querycp = mysqli_query($connect, "SELECT * FROM `casino_prizes` ORDER BY rand()");
$countcp = mysqli_num_rows($querycp);
?>
<script>
            var theWheel = new Winwheel({
                'numSegments'  : <?php
echo $countcp;
?>,
                'outerRadius'  : 212,
                'textFontSize' : 28,
                'segments'     :
                [
<?php
$i = 0;
while ($rowcp = mysqli_fetch_assoc($querycp)) {
    ++$i;
?>
                   {'fillStyle' : '<?php
    echo $rowcp['color'];
?>', 'text' : '<?php
    echo $rowcp['value'];
?> <?php
    echo $rowcp['prizetype'];
?>'}
<?php
    if ($i == $countcp) {
        echo '';
    } else {
        echo ',';
    }
}
?>
                ],
                'animation' :
                {
                    'type'     : 'spinToStop',
                    'duration' : 5,
                    'spins'    : 8,
                    'callbackFinished' : 'alertPrize()'
                }
            });
            
            var wheelPower    = 0;
            var wheelSpinning = false;

            function powerSelected(powerLevel)
            {
                if (wheelSpinning == false)
                {
                    document.getElementById('pw1').className = "";
                    document.getElementById('pw2').className = "";
                    document.getElementById('pw3').className = "";
                    
                    if (powerLevel >= 1)
                    {
                        document.getElementById('pw1').className = "pw1";
                    }
                        
                    if (powerLevel >= 2)
                    {
                        document.getElementById('pw2').className = "pw2";
                    }
                        
                    if (powerLevel >= 3)
                    {
                        document.getElementById('pw3').className = "pw3";
                    }
                    
                    wheelPower = powerLevel;
                    
                    document.getElementById('spin_button').className = "btn btn-success btn-block";
                }
            }
            
            function startSpin()
            {
                if (wheelSpinning == false)
                {
                    if (wheelPower == 1)
                    {
                        theWheel.animation.spins = 3;
                    }
                    else if (wheelPower == 2)
                    {
                        theWheel.animation.spins = 8;
                    }
                    else if (wheelPower == 3)
                    {
                        theWheel.animation.spins = 15;
                    }
                    
                    document.getElementById('spin_button').className = "btn btn-danger btn-block disabled";
                    
                    theWheel.startAnimation();
                    wheelSpinning = true;
                }
            }
            
            function alertPrize()
            {
                var winningSegment = theWheel.getIndicatedSegment();
                
				var winmsg = "<div class='alert alert-dismissible alert-success'><strong><?php
echo lang_key("spin-prize");
?>: " + winningSegment.text + ".</strong><br /> <?php
echo lang_key("refresh-tospin");
?></div>";
				document.getElementById('prize').innerHTML = winmsg;
				
				$.ajax({
   			        data: 'prize=' + winningSegment.text,
   			        url: 'ajax.php',
                    method: 'POST',
  			        success: function(result) {
  			            <!-- Received -->
   			        }
                });
            }
</script>
<?php
footer();
?>