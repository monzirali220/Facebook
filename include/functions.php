<?php
function print_post($post,$author){
  $poster = '<div class="post"><header class="post-h"><div class="more"><img src="./static/icons/ic_more.png"></div>
            <div class="auther">
              <a href="/profile.php?id='.$author['Id'].'"><img src="data:image;base64, '.$author["profileImage"].'"></a>
              <ul>
              <li><strong>'.$author['firstName'].' '.$author['lastName'].'</strong></li>
              <li><small>'.$post["publish_date"].'</small></li>
              </ul>
            </div>
          </header>
          <main class="post-m">
            <div class="post-content">
              '.$post['content'].'
            </div>';
  
  if (!empty($post['image'])){
      $poster .= '<div onclick="ful_view_image(this);"><img src="data:image;base64,'.$post["image"].'" alt="" class="post-image media"></div>';
  }
  $poster .='</main>
          <footer class="post-f">
          <ul>
            <li><a href="#"><img src="./static/icons/ic_reply.png" alt="" /></a></li>
            <li><a href="/?page=make-comment&&id='.$post["poster_id"].'"><img src="./static/icons/ic_comment_grey600_24dp.png" class="comment"/></a></li>
            <li><img src="./static/icons/like-icon-0.png" data-pid="'.$post["poster_id"].'" onclick="make-like(this)"/></li>
          </ul>
          </footer>
        </div>';
  echo $poster;
}

function print_user($author){
  global $conn;
  
  $my_id = $_SESSION["Login"]['id'];
  $his_id = $author['Id'];
  $sql = "SELECT is_friend FROM Friendship WHERE sender_id IN ($my_id,$his_id) AND receiver_id IN ($my_id,$his_id)";
  $result = mysqli_query($conn,$sql);
  if($result){
    $users = mysqli_fetch_all($result,MYSQLI_ASSOC);
    if(!empty($users)){
      $is_frind = $users[0]['is_friend'];
    }else{
      $is_frind = 0;
    }
  }else{
    $is_frind = 0;
  }
  $user =     '<div class="User">
        <a href="/profile.php?id='.$author['Id'].'"><img src="data:image;base64,'.$author["profileImage"].'" />
        <ul>
          <li><h4>'.$author["firstName"].' '.$author["lastName"].'</h4></li></a>';
  if (!$is_frind && $my_id != $his_id) {
    $user .= '<img class="add_friend" data-id="'.$author["Id"].'" onclick="add_friend(this);" src="./static/icons/add_friend-512.png" alt="">';
  }
  $user  .= '</ul>
      </div>
    </div>';
  
  echo $user;
}

// prossass functions
function add_friend ($data){
    global $conn ;
    $user = $data['user'];
    $friend = $data['friend'];
    
    $check_query = "SELECT * FROM Friendship WHERE sender_id IN ('$user','$friend') AND receiver_id IN ('$user','$friend')";
    $add_friend_query = 'INSERT INTO Friendship(sender_id,receiver_id) VALUES('.$user.','.$friend.')';
    $be_friend_query = "UPDATE Friendship SET is_friend=1 WHERE friendship_id=";
    $delet_friendship_query = "DELETE FROM Friendship WHERE friendship_id=";
    
    $result = mysqli_query($conn,$check_query);
    
    if ($result) {
      $friendships = mysqli_fetch_all($result,MYSQLI_ASSOC);
      $friendship = $friendships[0];
      $id = $friendship['friendship_id'];
      $sender = $friendship['sender_id'];
      $receiver = $friendship['receiver_id'];
      if($receiver == $user){
        mysqli_query($conn,$be_friend_query.$id);
      }else{
        mysqli_query($conn,$delet_friendship_query.$id);
        mysqli_query($conn,$add_friend_query);
        return array('result'=>true);
      }
    }else{
    mysqli_query($conn,$add_friend_query);
    return array('result'=>true);
    }
  }
  
  function friendship($data){
    global $conn;
    $friendship = $data['friendship'];
    $anser = $data['anser'];
    if($anser == 'confairm'){
      $sql = "UPDATE Friendship SET is_friend=1 WHERE friendship_id=".$friendship;
      $result = mysqli_query($conn,$sql);
      if($result){
        return array(
              "result"=>'confairmed'
              );
      }
    }elseif($anser == 'delete'){
      $sql = "DELETE FROM Friendship WHERE friendship_id=".$friendship;
      $result = mysqli_query($conn,$sql);
      if($result){
        return array(
              "result"=>'Deleted'
        );
      }
    }else{
      return array('result'=>'unknowing anser');
    }
  }
  function send_message ($data){
    global $conn;
    $sender = $data['sender_id'];
    $receiver = $data['receiver_id'];
    $message = $data['message'];
    $sql = "INSERT INTO Messages(sender_id,receiver_id,message) VALUES($sender,$receiver,'$message')";
    $result = mysqli_query($conn,$sql);
    if ($result) {
      return array(
        "anser"=>"done",
        "sender_id"=>$sender,
        "receiver_id"=>$receiver,
        "message"=>$message
        );
    }else{
      return array(
        "anser"=>"fill"
        );
    }
  }
  
  function get_messages($data){
    global $conn;
    $user1 = $data["user1"];
    $user2 = $data['user2'];
    $sql = "SELECT * FROM Messages WHERE sender_id IN ($user1,$user2) AND receiver_id IN ($user1,$user2)";
    $result = mysqli_query($conn,$sql);
    if ($result) {
      return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }else{
      return array();
    }
  }