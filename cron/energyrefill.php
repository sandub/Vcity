<?php
include "../config.php";

//Energy Refill (by default every 10 minutes)
$sqlusers = mysqli_query($connect, "SELECT * FROM `players`");
while ($rowuser = mysqli_fetch_assoc($sqlusers)) {
    if ($rowuser['energy'] < 100) {
        $userenergyrefill = mysqli_query($connect, "UPDATE `players` SET energy=energy+10 WHERE id='$rowuser[id]'");
    }
}
?>