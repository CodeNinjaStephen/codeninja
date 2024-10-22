<?php
include_once "../php/db.php";
$song_id = $_GET["song_id"];

$delete_user = mysqli_query($conn, "DELETE FROM `song` WHERE id = '$song_id'");
if ($delete_user){
    echo "<script>alert('You have Successfully Deleted This song');window.history.back();</script>";
}

