<?php
  include '../include/init.php';
  include '../include/database/connect_db.php';
  
  $conn = database();
  
  if(isset($_POST['submit'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $image = file_get_contents($_SERVER['DOCUMENT_ROOT']."/static/icons/user_male.png");
    $profileImage = base64_encode($image);
    
    
    $set_query = "INSERT INTO Users(firstName,lastName,email,password,profileImage) VALUES('".$firstname."','".$lastname."','".$email."','".$password."','".$profileImage."')";
    $get_id = "SELECT * FROM Users WHERE email='".$email."' AND password='".$password."'";
    $result = mysqli_fetch_all(mysqli_query($conn,$get_id),MYSQLI_ASSOC);
    
    if(!isset($result[0]['Id'])){
      mysqli_query($conn,$set_query);
      $result = mysqli_fetch_all(mysqli_query($conn,$get_id),MYSQLI_ASSOC);
      if (isset($result)) {
        $_SESSION["Login"] = array(
          'id'=>$result[0]['Id'],
          'firstName'=>$result[0]['firstName'],
          'lastName'=>$result[0]['lastName'],
          'profileImage'=>$result[0]['profileImage']
          );
        header("Location:/");
        exit();
      }else{
        echo 'something wrong';
      }
    }
  }
    
    
  
  
  
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"  http-equiv="cache-control" content="no-cache ,width=device-width, initial-scale=1">
    <title></title>
</head>
<body>
  <form action="" method="POST" accept-charset="utf-8">
    <input type="text" name="firstname" placeholder="enter first name" />
    <input type="text" name="lastname" placeholder="enter last name" />
    <input type="text" name="email" placeholder="enter email" />
    <input type="password" name="password" placeholder="enter password">
    <input type="submit" name="submit" value="submit">
  </form>
</body>
</html>