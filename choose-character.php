<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
$rowu  = mysqli_fetch_assoc($suser);

if (isset($_POST['start'])) {
    $character_id = $_POST['character'];
    
    $querycs = mysqli_query($connect, "SELECT * FROM `characters` WHERE id = '$character_id' LIMIT 1");
    $countcs = mysqli_num_rows($querycs);
    if ($countcs > 0) {
        $rowcs = mysqli_fetch_assoc($querycs);
        if ($rowcs['power'] == 'Yes') {
            $power = 10;
        } else {
            $power = 0;
        }
        if ($rowcs['agility'] == 'Yes') {
            $agility = 10;
        } else {
            $agility = 0;
        }
        if ($rowcs['endurance'] == 'Yes') {
            $endurance = 10;
        } else {
            $endurance = 0;
        }
        if ($rowcs['intelligence'] == 'Yes') {
            $intelligence = 10;
        } else {
            $intelligence = 0;
        }
        
        $character_set = mysqli_query($connect, "UPDATE `players` SET character_id='$character_id', power=power+'$power', agility=agility+'$agility', endurance=endurance+'$endurance', intelligence=intelligence+'$intelligence' WHERE username='$uname'");
        echo '<meta http-equiv="refresh" content="0; url=home.php" />';
        exit;
    }
}
?>
        
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-male"></i> <?php
echo lang_key("choose-your-character");
?></h3>
            </div>
            <div class="panel-body">
                <center><h2><i class="far fa-hand-pointer"></i> <?php
echo lang_key("choose-your-character");
?></h2></center><br />
           
                <ul class="nav nav-tabs nav-justified">
<?php
$first   = true;
$querycc = mysqli_query($connect, "SELECT * FROM `character_categories`");
while ($rowcc = mysqli_fetch_assoc($querycc)) {
?>
                    <li <?php
    if ($first) {
        echo 'class="active"';
        $first = false;
    }
?></l><a data-toggle="tab" href="#<?php
    echo $rowcc['id'];
?>"><i class="fa <?php
    echo $rowcc['fa_icon'];
?>"></i> <?php
    echo $rowcc['category'];
?></a></li>
<?php
}
?>
                </ul>

                <form role="form" action="" method="post">
                    <div class="tab-content">
<?php
$firsta   = true;
$queryccs = mysqli_query($connect, "SELECT * FROM `character_categories`");
while ($rowccs = mysqli_fetch_assoc($queryccs)) {
    $category_id = $rowccs['id'];
?>
                        <div id="<?php
    echo $category_id;
?>" class="tab-pane fade in <?php
    if ($firsta) {
        echo 'active';
        $firsta = false;
    }
?>">
                            <div class="row">
<?php
    $queryc = mysqli_query($connect, "SELECT * FROM `characters` WHERE category_id = '$category_id'");
    while ($rowc = mysqli_fetch_assoc($queryc)) {
?>
                                <div class="col-md-3">
                                    <center>
                                        <h2><br /><span class="label label-default"><?php
        echo $rowc['name'];
?></span></h2>
                                    </center><br />
                                    <label class="btn btn-default">
                                        <input type="radio" name="character" value="<?php
        echo $rowc['id'];
?>" required />
                                        <img src="<?php
        echo $rowc['image'];
?>" width="80%" />
                                    </label>
                                    <center>
<?php
        if ($rowc['power'] == 'Yes') {
            echo '<h3>' . lang_key("power") . ': <span class="label label-warning">+10</span></h3>';
        }
        if ($rowc['agility'] == 'Yes') {
            echo '<h3>' . lang_key("agility") . ': <span class="label label-danger">+10</span></h3>';
        }
        if ($rowc['endurance'] == 'Yes') {
            echo '<h3>' . lang_key("endurance") . ': <span class="label label-success">+10</span></h3>';
        }
        if ($rowc['intelligence'] == 'Yes') {
            echo '<h3>' . lang_key("intelligence") . ': <span class="label label-info">+10</span></h3>';
        }
?>
                                    </center><hr />
                                </div>
<?php
    }
?>
                            </div>
                            
                        </div>
<?php
}
?>
                    </div>

                    <br />
                    <input type="submit" name="start" value="<?php
echo lang_key("start-the-game");
?>" class="btn btn-success btn-md btn-block">
                </form>

            </div>
        </div>
<?php
footer();
?>