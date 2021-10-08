<?php
  include '../include/init.php';
  include '../include/database/connect_db.php';
  
  $conn = database();
  $Errors = array(
    "all"=>"Email or password is wrong",
    "email"=>"",
    "password"=>""
    );
  $no_error = true;
  $MIN_PASSWORD_LEN = 4;
  
  function validaty(){
    global $Errors,$MIN_PASSWORD_LEN ,$no_error;
    $password = $_POST["password"];
    $email = $_POST["email"];
    
    // validation password
    if(empty($password)){
      $Errors["password"] = "Password shold not be empty";
      $no_error = false;
    }elseif (strlen($password) < $MIN_PASSWORD_LEN) {
      $Errors["password"] = "Password to small";
      $no_error = false;
    }
    
    // validation email
    if (empty($email)) {
      $Errors["email"] = "Email shold not be empty ";
      $no_error = false;
    }elseif (!empty(filter_var($email,FILTER_SANITIZE_NUMBER_INT)) && !filter_var($email,FILTER_VALIDATE_EMAIL) && empty($Errors["password"])) {
      $email = filter_var($email,FILTER_SANITIZE_NUMBER_INT);
    }elseif ((!filter_var($email,FILTER_VALIDATE_EMAIL)) or (!empty(filter_var($email,FILTER_SANITIZE_NUMBER_INT)) && !filter_var($email,FILTER_VALIDATE_EMAIL) && !empty($Errors["password"]))){
      $Errors["email"] = "Enter valid email";
      $no_error = false;
    }else{
      $Errors["all"] = "";
    }
    return array(
      "Errors"=>$Errors,
      "no_error"=>$no_error,
      "email"=>$email,
      "password"=>$password
      );
  }
  
  function go_to_html(){
    include '../include/html/pages/login.php';
  }
  
  
  if(isset($_POST['submit'])){
    
    // Update Errors and no_error
    $validate = validaty();
    $Errors = $validate["Errors"];
    $no_error = $validate["no_error"];
    $email = $validate["email"];
    $password = $validate["password"];
    if (!$no_error) {
      // Go to html page
      go_to_html();
      exit();
    }
    
    $check_query = "SELECT Id , firstName , lastName , profileImage,password FROM Users WHERE (email='$email' OR Id='$email' )";
    $result = mysqli_query($conn,$check_query);
    if ($result) {
      $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
      if(isset($data[0])){
        if (!password_verify($password,$data[0]["password"])) {
          $no_error = false;
          go_to_html();
        }else{
        $_SESSION['Login'] = array(
          'id' => $data[0]['Id'],
          'firstName' => $data[0]['firstName'],
          'lastName' => $data[0]['lastName'],
          'profileImage' => $data[0]['profileImage']
          );
        header('location: /?page=home&&opr=view-posts');
        exit();
        }
      }
    }else{
      $Errors["all"] = 'Email or password is wrong';
      $no_error = true;
    }
  }
  if($no_error){
    go_to_html();
  }
  
?>