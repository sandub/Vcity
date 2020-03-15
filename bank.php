<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if ($rowu['level'] <= 10) {
    $depositcapacity = 50000;
} elseif ($rowu['level'] <= 17) {
    $depositcapacity = 100000;
} else {
    $depositcapacity = 150000;
}


if (isset($_POST['deposit'])) {
    $dmoney = $_POST['dmoney'];
    if (!ctype_digit($dmoney)) {
        echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#deposit-problem").modal(\'show\');
            });
        </script>

        <div id="deposit-problem" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("depositing-money") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-danger">' . lang_key("invalid-amount") . '</span></h3><br /><br />
                            <button type="button" class="btn btn-primary btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> ' . lang_key("close") . '</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
    } elseif ($dmoney > $rowu['money']) {
        echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#deposit-problem").modal(\'show\');
            });
        </script>

        <div id="deposit-problem" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("depositing-money") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-danger">' . lang_key("noenough-money") . '</span></h3><br /><br />
                            <button type="button" class="btn btn-primary btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> ' . lang_key("close") . '</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
    } elseif ($dmoney < 99) {
        echo '
		<script type="text/javascript">
            $(document).ready(function() {
                $("#deposit-problem").modal(\'show\');
            });
        </script>

        <div id="deposit-problem" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("depositing-money") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-info">' . lang_key("minimum-amount") . ' $100</span></h3><br /><br />
                            <button type="button" class="btn btn-primary btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> ' . lang_key("close") . '</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
    } elseif ($rowu['bank'] == $depositcapacity || $rowu['bank'] > $depositcapacity) {
        echo '
		<script type="text/javascript">
            $(document).ready(function() {
                $("#deposit-problem").modal(\'show\');
            });
        </script>

        <div id="deposit-problem" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("depositing-money") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-warning">' . lang_key("bank-full") . '</span></h3><br /><br />
                            <button type="button" class="btn btn-primary btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> ' . lang_key("close") . '</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
    } else {
        if (($dmoney + $rowu['bank']) > $depositcapacity) {
            $moneyd      = $depositcapacity - $rowu['bank'];
            $moneyreturn = $dmoney - $moneyd;
            
            mysqli_query($connect, "UPDATE players SET money=money-$moneyreturn, bank=bank+$moneyd WHERE id='" . $player_id . "'");
        } else {
            mysqli_query($connect, "UPDATE players SET money=money-$dmoney, bank=bank+$dmoney WHERE id='" . $player_id . "'");
        }
        
        echo '
		<script type="text/javascript">
            $(document).ready(function() {
                $("#deposit-success").modal(\'show\');
            });
        </script>

        <div id="deposit-success" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("depositing-money") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-success">' . lang_key("success-deposit") . ' $' . $dmoney . '</span></h3><br />
							<img src="images/icons/money.png" width="20%" height="auto" /><br /><br />
                            <button type="button" class="btn btn-success btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> ' . lang_key("close") . '</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
    }
}

if (@$_POST['withdraw']) {
    $wmoney = $_POST['wmoney'];
    if ($wmoney > $rowu['bank']) {
        echo '
		<script type="text/javascript">
            $(document).ready(function() {
                $("#withdraw-problem").modal(\'show\');
            });
        </script>

        <div id="withdraw-problem" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("withdrawing-money") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-danger">' . lang_key("insuff-av") . '</span></h3><br /><br />
                            <button type="button" class="btn btn-primary btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> ' . lang_key("close") . '</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
    } elseif ($wmoney < 50) {
        echo '
		<script type="text/javascript">
            $(document).ready(function() {
                $("#withdraw-problem").modal(\'show\');
            });
        </script>

        <div id="withdraw-problem" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("withdrawing-money") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-info">' . lang_key("minimum-amount") . ' $100</span></h3><br /><br />
                            <button type="button" class="btn btn-primary btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> ' . lang_key("close") . '</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
    } else {
        mysqli_query($connect, "UPDATE players SET money=money+$wmoney, bank=bank-$wmoney WHERE id='" . $player_id . "'");
        echo '
		<script type="text/javascript">
            $(document).ready(function() {
                $("#withdraw-success").modal(\'show\');
            });
        </script>

        <div id="withdraw-success" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">' . lang_key("withdrawing-money") . '</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h3><span class="label label-success">' . lang_key("success-withdrawn") . ' $' . $wmoney . '</span></h3><br />
							<img src="images/icons/money.png" width="20%" height="auto" /><br /><br />
                            <button type="button" class="btn btn-success btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> ' . lang_key("close") . '</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
    }
}
?>
<div class="col-md-12 well">

    <center><h2><i class="fa fa-university"></i> <?php
echo lang_key("bank");
?></h2></center><br />

    <div class="row">
	<center>

<?php
$userb = mysqli_query($connect, "SELECT bank FROM `players` WHERE username='$uname' LIMIT 1");
$rowub = mysqli_fetch_assoc($userb);
?>
	<div class="col-md-1"></div>
	<div class="col-md-10">
        <h5><i class="fa fa-lock"></i> <?php
echo lang_key("deposited-money");
?></h5>
            <div class="progress progress-striped active">
                <div class="progress-bar progress-bar-info" style="width: <?php
echo percent($rowub['bank'], $depositcapacity);
?>%;">
                    <span>$ <?php
echo $rowub['bank'];
?> / $ <?php
echo $depositcapacity;
?></span>
                </div>
            </div><br /><br />
    </div>
    <div class="col-md-1"></div>
	
	<div class="col-md-6">
	    <div class="jumbotron">
		    <h3><i class="fa fa-upload"></i> <?php
echo lang_key("deposit-money");
?></h3>
			<hr /><br />
			
			<form method="post" action="">
			    <input name="dmoney" class="form-control" type="number" value="100" min="100" max="<?php
echo $depositcapacity;
?>" required><br>
			    <input value="<?php
echo lang_key("deposit");
?>" class="btn btn-primary btn-block" name="deposit" type="submit"><br /><br />
		    </form>
		</div>
	</div>
	
	<div class="col-md-6">
	    <div class="jumbotron">
		    <h3><i class="fa fa-download"></i>  <?php
echo lang_key("withdraw-money");
?></h3>
			<hr /><br />
			
			<form method="post">
			    <input name="wmoney" class="form-control" type="number" value="<?php
echo $rowub['bank'];
?>" min="100" max="<?php
echo $rowub['bank'];
?>" required><br>
			    <input value="<?php
echo lang_key("withdraw");
?>" class="btn btn-primary btn-block" name="withdraw" type="submit"><br /><br />
		    </form>
		</div>
	</div>

	</center>
    </div>
</div>
<?php
footer();
?>