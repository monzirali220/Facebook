<?php
include './include/database/connect_db.php';
include './include/functions.php';

$conn = database();
function print_frindship_request($request){
    global $conn;
    $id = $request['friendship_id'];
    $get_sender_query = "SELECT Id,firstName,lastName,profileImage FROM Users WHERE Id=".$request['sender_id'];
    $result = mysqli_query($conn,$get_sender_query);
    if ($result) {
      $sender =mysqli_fetch_all($result,MYSQLI_ASSOC)[0];
      
      $friend = '<div class="friend">
        <a href="/profile.php?id='.$sender['Id'].'"><img src="data:image;base64,'.$sender['profileImage'].'" alt="" /></a>
        <ul>
          <li>'.$sender['firstName'].' '.$sender['lastName'].'</li>
          <li></li>
          <li><span>
            <button type="button" data-id="'.$id.'" data-anser="confairm" onclick="send_anser(this);" class="confairm">confairm</button>
            <button type="button" data-id="'.$id.'" data-anser="delete" onclick="send_anser(this);" class="deleat">deleat</button>
          </span></li>
        </ul>
      </div>';
      echo $friend;
    }
    
}
?>
<link rel="stylesheet" href="/static/css/friendship_requests.css" type="text/css" media="all">
<script src="/static/js/jquery.js"></script>
<script>
  function send_anser(button){
    $.ajax({
      url:'app/index.php',
      type:'POST',
      dataType:'json',
      data:{'opration':'friendship_requests','anser':button.dataset.anser,'friendship':button.dataset.id},
      success:function(respons){
        button.parentNode.style.display = 'none';
      },
      error:function(error){
        alert(JSON.stringify(error));
      }
    })
  }
</script>
<?php
  $friend_requests_query = "SELECT * FROM Friendship WHERE is_friend=0 AND receiver_id=".$_SESSION['Login']['id'];
  $result = mysqli_query($conn,$friend_requests_query);
  if ($result) {
    $requests = mysqli_fetch_all($result,MYSQLI_ASSOC);
    foreach ($requests as $request){
      print_frindship_request($request);
    }
  }
?>
    
