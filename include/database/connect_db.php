<?php
function database(){
  $conn = mysqli_connect('localhost','monzir','0994284765','socail');
  if(!$conn){
    echo mysqli_connect_error($conn);
    exit();
  }else{
  return $conn;
  }
}