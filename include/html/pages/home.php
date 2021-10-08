<?php
include 'include/database/connect_db.php';
include './include/functions.php';
$conn = database();

function get_posts($id){
  global $conn;
  $get_posts_query = "SELECT * FROM Posts WHERE author_id=".$id." ORDER BY poster_id DESC";
  $get_author_query = 'SELECT Id, firstName,lastName,profileImage FROM Users WHERE Id=';
  $result = mysqli_query($conn,$get_posts_query);
  $posts = mysqli_fetch_all($result,MYSQLI_ASSOC);
  foreach ($posts as $post){
    $author_id = $post['author_id'];
    $result = mysqli_fetch_all(mysqli_query($conn,$get_author_query.$author_id),MYSQLI_ASSOC);
    $author = $result[0];
    print_post($post,$author);
  }
}
?>


<link rel="stylesheet" href="static/css/home.css" type="text/css" media="all" />
<script href="/static/js/main.js"></script>
<div class="profile">
  <a href="/profile.php"><img src="data:image;base64,<?php echo $_SESSION['Login']['profileImage']; ?>" class="profile" alt="profile"></a>
  <a href="/?page=make-post"><div class="make-post" onclick="set_opr('make-post')">what did you think ?</div><a>
</div>
<div class="posts">
  <?php
  $sql = "SELECT * FROM Friendship WHERE (sender_id=".$_SESSION["Login"]["id"]." OR receiver_id=".$_SESSION["Login"]["id"].") AND is_friend=1";
  $result  = mysqli_query($conn,$sql);
  if ($result) {
    $friends = mysqli_fetch_all($result,MYSQLI_ASSOC);
    foreach ($friends as $friend){
      if($friend["sender_id"] == $_SESSION["Login"]["id"]){
        $id = $friend["receiver_id"];
      }else{
        $id = $friend["sender_id"];
      }
      get_posts($id);
    }
  }
  
  ?>
  
</div>