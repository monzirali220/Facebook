<?php
  include './include/database/connect_db.php';
  $conn = database();
  if(isset($_FILES['image'])){
  $file_dir = addslashes($_FILES['image']['tmp_name']);
  $file = file_get_contents($file_dir);
  $image = base64_encode($file);
  }if(isset($_POST['submit'])){
  $content = $_POST['content'];
  $author = $_SESSION['Login']["id"];
  if (isset($_FILES['image'])) {
  $set_post_query = "INSERT INTO Posts(author_id,publish_date,content,image) VALUES($author,NOW(),'$content','$image')";
  }else{
  $set_post_query = "INSERT INTO Posts(author_id,publish_date,content) VALUES($author,NOW(),'$content')";
  }
  $result = mysqli_query($conn,$set_post_query);
  if ($result) {
    header('location: /');
    die();
  }
  }
?>


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"  http-equiv="cache-control" content="no-cache, width=device-width, initial-scale=1">
    <link rel="stylesheet" href="static/css/init.css" type="text/css" media="all" />
    <link rel="stylesheet" href="./static/css/make-post.css">
    <title>Make post</title>
</head>
<body>
  <header>
    <span><img src="./static/icons/ic_back.png" class="back" onclick="history.back();"></span>
    </header>
    <form action="" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      <ul>
      <li><textarea name="content" id=content rows="8" cols="40"></textarea></li>
      <li>
        <label for="image"><img src="./static/icons/multimedia-photo-icon-31.png"> Add image</label>
        <input type="file" id="image" name="image" hidden accept="image/png" />
        </li>
      <li><input type="submit" name="submit" id="" value="publish" /></li>
      </ul>
    </form>
</body>
</html>