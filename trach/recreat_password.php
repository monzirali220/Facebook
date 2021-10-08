<?php
include "../include/database/connect_db.php";
$conn = database();
$password = password_hash($_GET["id"],PASSWORD_DEFAULT);
$sql = "UPDATE Users SET password='$password'";
if(mysqli_query($conn,$sql)){
  echo('done');
}