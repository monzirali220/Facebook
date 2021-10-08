<?php
  session_start();
  include("database/connect_db.php");
  function Update_connection(){
    $conn = database();
    $id = $_SESSION["Login"]["id"];
    $now = time();
    $query = "UPDATE Users SET lastLogin=$now WHERE Id=".$id;
    mysqli_query($conn,$query);
  }
  
  
  header("Cache-Control: no-cache, must-revalidate");
  if(isset($_SESSION['Login']) && !empty($_SESSION['Login']) && $_SERVER['SCRIPT_NAME'] != "/" && $_SERVER['SCRIPT_NAME'] != "/index.php"){
    header("location: /?page=home&&opr=view-post");
    
    exit();
  }
  if ((!isset($_SESSION["Login"]) || empty($_SESSION['Login'])) && ($_SERVER['SCRIPT_NAME'] == "/index.php")) {
    header("location: /login");
    exit();
  }