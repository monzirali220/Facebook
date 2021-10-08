<?php
include './include/database/connect_db.php';
  function print_friend($friend){
    $user = '<div class="User ';
    if((time() - $friend["lastLogin"]) <= 300){
      $user .= 'active';
    }
    $user .='" data-author_id="'.$friend['Id'].'" onclick="messages(this)">
          <a><img src="data:image;base64,'.$friend['profileImage'].'" alt="" /></a>
          <ul>
            <li>'.$friend['firstName'].' '.$friend['lastName'].'</li>
            <li><small></small></li>
          </ul>
        </div>';
    echo $user;
  }
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Message</title>
  
  <!-- HTML -->
  

  <link rel="stylesheet" href="/static/css/friend.css" type="text/css" media="all" />
  <link rel="stylesheet" href="style.css">
  <script type="text/javascript" charset="utf-8">
  console.log(location.pathname)
    function messages(author){
      window.location = location.protocol+'//'+location.host+'/?page=make-message&&id='+author.dataset.author_id;
    }
  </script>
</head>

<body>
  
  <?php
  $conn = database();
  $myid = $_SESSION['Login']['id'];
  $sql = "SELECT * FROM Friendship WHERE (sender_id=$myid OR receiver_id=$myid) AND is_friend=1";
  $result = mysqli_query($conn,$sql);
  if($result){
    $friendships = mysqli_fetch_all($result,MYSQLI_ASSOC);
    foreach ($friendships as $friendship){
      $sql = "SELECT Id , profileImage , firstName,lastName FROM Users WHERE Id=";
      if ($friendship["sender_id"] != $_SESSION['Login']['id']) {
        $sql .= $friendship["sender_id"];
      }else{
        $sql .= $friendship["receiver_id"];
      }
      $result = mysqli_query($conn,$sql);
      if($result){
        $friend = mysqli_fetch_all($result,MYSQLI_ASSOC)[0];
        print_friend($friend);
      }
    }
  }
  
  ?>

  <script src="main.js"></script>
</body>
</html>