<?php
  include './include/database/connect_db.php';
  $conn = database();
  $sql = "SELECT Id , password FROM Users";
  $result = mysqli_query($conn,$sql);
  if ($result) {
  $result = mysqli_fetch_all($result,MYSQLI_ASSOC);
  foreach ($result as $user){
    $sql = "UPDATE Users SET password='".password_hash("0000",PASSWORD_DEFAULT)."' WHERE Id=".$user["Id"];
    mysqli_query($conn,$sql);
    echo "done ".$user["Id"]."</br>";
  }
  }else {
    echo 'some signup';
  }
  
  
  
  