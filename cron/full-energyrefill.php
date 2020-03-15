<?php
include "../config.php";

//Full Energy Refill (by default every 24 hours)
$sqlusers = mysqli_query($connect, "SELECT * FROM `players`");
while ($rowuser = mysqli_fetch_assoc($sqlusers)) {
    if ($rowuser['energy'] < 100) {
        $userfullenergyrefill = mysqli_query($connect, "UPDATE `players` SET energy='100' WHERE id='$rowuser[id]'");
    }
}
?>