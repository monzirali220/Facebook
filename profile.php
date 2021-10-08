<?php
  session_start();
  
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
  }elseif (isset($_SESSION['Login'])) {
    $id = $_SESSION['Login']['id'];
  }else{
    $id = 0;
  }
  
  if($id == 0){
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
    exit();
  }else{
    include './include/database/connect_db.php';
    $conn = database();
    $author_query = "SELECT * FROM Users WHERE Id=$id";
    $result = mysqli_query($conn,$author_query);
    if(!$result){
      header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
      exit();
    }else{
      $author = mysqli_fetch_all($result,MYSQLI_ASSOC)[0];
      include './include/html/pages/profile.php';
      
      
    }
  }
  
?>
