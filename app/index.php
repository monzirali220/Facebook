<?php
  session_start();
  include '../include/database/connect_db.php';
  include '../include/functions.php';
  $conn = database();
  
  function make_comment($data){
    global $conn;
    $pid = $data["pid"];
    $uid = $data["uid"];
    $comment = $data["comment"];
    $sql = "INSERT INTO Comments(post_id,author_id,comment) VALUES($pid,$uid,'$comment')";
    if(mysqli_query($conn,$sql)){
      return array(
        "anser"=>"done"
        );
    }else {
      return array(
        "anser"=>"fill"
        );
    }
  }
  
  
  
 if(isset($_POST['opration'])) {
    switch ($_POST['opration']) {
      case 'add friend':
        echo json_encode(add_friend($_POST));
        break;
      case 'friendship_requests':
        echo json_encode(friendship($_POST));
        break;
      case 'get-messages':
        echo json_encode(get_messages($_POST));
        break;
      case 'make-comment':
        echo json_encode(make_comment($_POST));
        break;
      case 'send-message':
        echo json_encode(send_message($_POST));
        break;
      default:
        echo 'fill';
        break;
    }
  }else{
    header("HTTP/1.0 404 Not Found");
  }
  