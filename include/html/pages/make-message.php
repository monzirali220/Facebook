<?php
include './include/database/connect_db.php';
include './include/functions.php';
if(!isset($_GET['id'])){
  exit();
}
$conn = database();
$id = $_GET['id'];
$sql = "SELECT Id,profileImage,firstName,lastName FROM Users WHERE Id=".$id;
$result = mysqli_query($conn,$sql);
if (!$result) {
  exit();
}
$user = mysqli_fetch_all($result,MYSQLI_ASSOC);
$friend = $user[0];

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./static/css/init.css" type="text/css" media="all" />
    <link rel="stylesheet" href="./static/css/messages.css" type="text/css" media="all" />
    <title></title>
    <script src="./static/js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8">
      let myid = <?php echo $_SESSION['Login']['id'];?>;
      let hisid = <?php echo $friend['Id'];?>;
      
      function find(target){
        return document.querySelector(target);
      }
      
      function create_massage(data){
        massage = "";
        return massage;
      }
      /*function get_messages(){
        $.ajax({
          url:"/app/index.php",
          type:"POST",
          dataType:"json",
          data:{"opration":"get-messages","user1":myid,"user2":hisid},
          success:function(respons){
            var opjects = JSON.parse(JSON.stringify(respons));
            var massages = ""!
            for(var i = 0; i < opjects.length ; i++){
              massages += create_massage(messages[i]['message'])
            }
            find("#all-massage").innerHTML = massages;
          },
          error:function(error){
            alert(JSON.stringify(error))
          }
        })
      }*/
      function send(){
        $.ajax({
          url:'/app/index.php',
          type:'POST',
          dataType:'json',
          data:{"opration":"send-message","sender_id": myid ,"receiver_id": hisid,"message":find('#input').value},
          success:function(respons){
            document.location.reload();
          },
          error:function(error){
            alert("Error : \n"+JSON.stringify(error));
          }
        })
      }
    </script>
</head>
<body>
<header class="">
  <div class="User">
    <a href="/profile.php?id=<?php echo $friend['Id'];?>"><img src="data:image;base64,<?php echo $friend['profileImage'];?>"></a>
    <ul>
      <li><?php echo $friend['firstName'].' '.$friend['lastName'];?></li>
    </ul>
  </div>
</header>
<main >
  <pre id="all-messages">
  </pre>
  
  <?php
  $messages = get_messages(array(
    "user1"=>$_SESSION['Login']['id'],
    "user2"=>$id
    ));
  
  
  foreach ($messages as $message){
    $me = '<div class="message">
          <ul class="';
      if($message["sender_id"] == $_SESSION["Login"]["id"]){
        $me .= 'me';
      }else{
        $me .= 'him';
      }
          
          $me .='">
            <li><small>
              ';
          if($message['sender_id'] == $friend["Id"]){
          $me .=$friend["firstName"].' '.$friend["lastName"];
          }else{
            $me .=$_SESSION["Login"]["firstName"].' '.$_SESSION["Login"]["lastName"];
          }
          $me .='
            </small></li>
            <li class="content">
              '.$message["message"].'
            </li>
            <li><small>'.$message["date"].'</small></li>
          </ul>
        </div>';
      echo $me;
    
  }
  ?>
  
</main>
<footer>
  <input type="text" id="input" value="" /><button type="button" onclick="send()">send</button>
</footer>
</body>
</html>