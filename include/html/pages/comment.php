<?php
  include "./include/database/connect_db.php";
  $conn = database();
  
  function print_comment($comment){
    global $conn;
    $sql = "SELECT Id,profileImage,firstName,lastName FROM Users WHERE Id=".$comment["author_id"];
    $result = mysqli_query($conn,$sql);
    if ($result) {
      $users = mysqli_fetch_all($result,MYSQLI_ASSOC);
      $user = $users[0];
      $comm = '
      <div class="comment_container">
        <div class="comment">
          <div class="comment_author">
            <a href="/profile.php?id='.$user["Id"].'"><img src="data:image;base64,'.$user["profileImage"].'" alt=""></a>
            <ul>
              <li>'.$user["firstName"]." ".$user["lastName"].'</li>
              <li><small>'.$comment['date'].'</small></li>
            </ul>
          </div>
          <div class="comment_content">
                '.$comment["comment"].'
          </div>
        </div>
      </div>';
      
      echo $comm;
      
    }
  }
  
  
  
  $pid = $_GET["id"];
  $sql = "SELECT * FROM Posts WHERE poster_id=$pid";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    header();
    exit();
  }else {
    $posts = mysqli_fetch_all($result,MYSQLI_ASSOC);
    $post = $posts[0];
    $get_author = "SELECT Id,firstName,lastName,profileImage FROM Users WHERE Id=".$post["author_id"];
    $result = mysqli_query($conn,$get_author);
    if($result){
    $users = mysqli_fetch_all($result,MYSQLI_ASSOC);
    $author = $users[0];
    }else{
      exit();
    }
  }
  
?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>make-comment</title>
  
  
  <link rel="stylesheet" href="./static/css/poster.css">
  <link rel="stylesheet" href="./static/css/comment.css" type="text/css" media="all" />
  
  
  <script src="./static/js/jquery.js" type="text/javascript" charset="utf-8"></script>
  <script src="./static/js/main.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript" charset="utf-8">
    let uid = <?php echo $_SESSION["Login"]["id"];?>;
    let pid = <?php echo $_GET["id"]; ?>;

    function find(target) {
      return document.querySelector(target);
    }

    function send() {
      $.ajax({
        url: 'app/index.php',
        type: 'POST',
        dataType: 'json',
        data: { "opration": "make-comment", "uid": uid, "pid": pid, "comment": find('input').value },
        success: function(respons) {
          //alert(JSON.stringify(respons));
          window.location.reload();
        },
        error: function(error) {
          alert(JSON.stringify(error));
        }
      })
    }
  </script>
</head>

<body>
  <header class="header">
    <img src="./static/icons/ic_back.png" onclick="history.back();" />
  </header>
  <div class="post">
    <header class="post-h">
      <div class="more"><img src="./static/icons/ic_more.png" alt=""></div>
      <div class="auther">
        <?php
          echo '<a href="/profile.php?id='.$author['Id'].'">
                <img src="data:image;base64,'.$author['profileImage'].'">
              </a>';
        ?>
        <ul>
          <li><strong><?php echo $author["firstName"]." ".$author["lastName"]; ?></strong></li>
          <li><small><?php echo $post["publish_date"]; ?></small></li>
        </ul>
      </div>
    </header>
    <main class="post-m">
      <div class="post-content">
      </div>
      <div onclick="ful_view_image(this);"><?php if(!empty($post["image"])){echo '<img src="data:image;base64,'.$post["image"].'" alt="" class="post-image">';}?></div>
    </main>
    <footer class="post-f">
      <ul>
        <li><a href="#"><img src="./static/icons/ic_reply.png" alt="" /></a></li>
        <li><img src="./static/icons/ic_comment_grey600_24dp.png" class="comment" alt="" /></li>
        <li><a href="/app/?opration=like&uid=&pid="><img src="./static/icons/like-icon-0.png" alt="" /></a></li>
      </ul>
    </footer>
  </div>
  <main class="main">
    <?php
      $get_comment_query = "SELECT * FROM Comments WHERE post_id=".$post["poster_id"];
      $result = mysqli_query($conn,$get_comment_query);
      if ($result) {
        $comments = mysqli_fetch_all($result,MYSQLI_ASSOC);
        foreach ($comments as $comment){
          print_comment($comment);
        }
      }else{
        
      }
    ?>
  </main>
  
  <footer class="footer">
    <input type="text" id="input" value="" placeholder="comment" />
    <button type="button" onclick="send();">send</button>
  </footer>
</body>
</html>