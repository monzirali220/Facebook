<?php
include './include/functions.php';
include './include/database/connect_db.php';
?>
<head>
    <meta charset="UTF-8" dir="rtl">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./static/css/search.css" type="text/css" media="all" />
    <link rel="stylesheet" href="./static/css/Users.css" type="text/css" media="all" />
    <link rel="stylesheet" href="./static/css/poster.css" type="text/css" media="all" />
    <title>search</title>
  <script src="static/js/jquery.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript" charset="utf-8">
    function add_friend(friend){
      let user = <?php echo $_SESSION['Login']['id']?>;
      $.ajax({
        url:"app/index.php",
        type:"POST",
        dataType:"json",
        data:{'opration':'add friend','user':user,'friend':friend.dataset.id},
        success:function (respons){
          friend.style.display='none';
        },
        error:function(error){
        }
      });
    }
  </script>
</head>
<body>
<main class="body">
  <?php
  if(!isset($_GET["query"])){
  echo '<form action="" method="GET" accept-charset="utf-8">
    <div class="form">
    <input type="hidden" name="page" value="search">
    <input type="search" name="query" value="" />
    <button type="submit" >search</button>
    </div>
  </form>';
  }
  ?>
  <div class="Users">
    <?php
      if(isset($_GET['query']) && !empty($_GET['query'])){
        $conn = database();
        $ser = $_GET['query'];
        // serch for user
        $query = 'SELECT Id,firstName,lastName,profileImage FROM Users WHERE ((Id = "'.$ser.'") OR (firstName = "'.$ser.'") OR (lastName = "'.$ser.'") OR (email ="'.$ser.'"))';
        $result = mysqli_query($conn,$query);
        if($result){
        $users = mysqli_fetch_all($result,MYSQLI_ASSOC);
        foreach ($users as $user){
          print_user($user);
        }
        }
        // search for post
        $query = 'SELECT * FROM Posts WHERE content LIKE "%'.$ser.'%"';
        $result = mysqli_query($conn,$query);
        if($result){
          $posts = mysqli_fetch_all($result,MYSQLI_ASSOC);
          foreach ($posts as $post){
            $author_id = $post["author_id"];
            $sql = "SELECT Id,firstName,lastName,profileImage FROM Users WHERE Id=".$author_id;
            $users = mysqli_fetch_all(mysqli_query($conn,$sql),MYSQLI_ASSOC);
            print_post($post,$users[0]);
          }
        }
      }
  ?>
</main>
</body>
</html>