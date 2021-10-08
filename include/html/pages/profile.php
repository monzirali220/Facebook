<?php
  // include importon functions
  include './include/functions.php';
  // check if the viewer is the owner of the acconte
  $is_the_owner = (isset($_SESSION['Login']) && $_SESSION['Login']['id'] == $id);
  
  if(isset($_POST['opration'])){
    $opration = $_POST['opration'];
    if ($opration == 'change-small-image' && $is_the_owner) {
      $file = file_get_contents(addslashes($_FILES['profile-image']['tmp_name']));
      $image = base64_encode($file);
      $query = "UPDATE Users SET profileImage='".$image."' WHERE Id=".$_SESSION['Login']['id'];
      $result = mysqli_query($conn,$query);
      header("Cache-Control: no-cache, must-revalidate");
      $_SESSION['Login']['profileImage']=$image;
      
      
    }elseif ($opration == 'change-big-image' && $is_the_owner) {
      $file = file_get_contents(addslashes($_FILES['big-profile-image']['tmp_name']));
      $image = base64_encode($file);
      $query = "UPDATE Users SET profileBigImage='".$image."' WHERE Id=".$_SESSION['Login']['id']." ORDER BY poster_id DESC";
      $result = mysqli_query($conn,$query);
      $_SESSION['Login']['profileBigImage']=$image;
      header("Cache-Control: no-cache, must-revalidate");
    }
  }
  
  
  
  
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="./static/js/main.js" type="text/javascript" charset="utf-8"></script>
  <script>
    function change(input){
      input.form.submit();
    }
  </script>
  <title><?php echo $author["firstName"]?> profile</title>
  <link rel="stylesheet" href="./static/css/profile.css">
  <link rel="stylesheet" href="./static/css/poster.css">
</head>

<body>
  <div class="profile-images">
    <?php
    if(isset($author['profileBigImage'])){
      echo '<img src="data:image;base64,'.$author['profileBigImage'].'" class="big" alt="">';
    }
    ?>
    <div class="img">
      <img src="data:image;base64,<?php echo $author['profileImage']?>" class="profile-image" alt="" />
      
      <?php
      if ($is_the_owner) {
        
      echo '
      <form action="" method="POST" onsubmit="history.back();" enctype="multipart/form-data" accept-charset="utf-8">
      <label for="small-profile-image-ch"><div class="change-image"><img src="/static/icons/ic_camera.png"></div></label>
      <input type="file" name="profile-image" hidden id="small-profile-image-ch" onchange="change(this);"/>
      <input type="hidden" name="opration" value="change-small-image">
    </form>
      
    </div>
    <form action="" method="POST" onsubmit="history.back();" enctype="multipart/form-data" accept-charset="utf-8">
      <label for="big-profile-image-ch"><div class="change-image"><img src="/static/icons/ic_camera.png"></div></label>
      <input type="file" id="big-profile-image-ch" name="big-profile-image" onchange="change(this);" hidden/>
      <input type="hidden" name="opration" value="change-big-image">
    </form>';
      }else{
        echo '</div>';
      }
    ?>
  </div>
  <div class="author-profile">
    <h3><?php echo $author["firstName"].' '.$author["lastName"];?></h3>
  </div>
  <div class="posts">
      <?php
      $get_posts_query = "SELECT * FROM Posts WHERE author_id=".$id;
      $get_author_query = 'SELECT Id ,firstName,lastName,profileImage FROM Users WHERE Id=';
      $result = mysqli_query($conn,$get_posts_query);
      $posts = mysqli_fetch_all($result,MYSQLI_ASSOC);
      foreach ($posts as $post){
        $author_id = $post['author_id'];
        $result = mysqli_fetch_all(mysqli_query($conn,$get_author_query.$author_id),MYSQLI_ASSOC);
        $author = $result[0];
        print_post($post,$author);
      }
      
      ?>
  </div>
</body>
</html>