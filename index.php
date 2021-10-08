<?php
  include './include/init.php';
?>
<?php
  if((!isset($_GET['page']) || $_GET['page'] == 'home') && isset($_SESSION['Login'])){
    include './include/html/base/header.html';
    include './include/html/pages/home.php';
    include './include/html/base/footer.html';
  }elseif(isset($_GET['page'])){
    switch ($_GET['page']) {
      case 'search':
        if (!isset($_GET["query"])) {
        include './include/html/base/header.html';
        }
        include './include/html/pages/search.php';
        break;
      case 'make-post':
        include './include/html/pages/make-post.php';
        break;
      case 'make-comment':
        include './include/html/pages/comment.php';
        break;
      case 'friends':
        include './include/html/base/header.html';
        include './include/html/pages/friendsip_reqests.php';
        break;
      case 'message':
        include './include/html/base/header.html';
        include './include/html/pages/messages.php';
        break;
      case 'make-message':
        include './include/html/pages/make-message.php';
        break;
      case 'logout':
        //include 'logout.php';
        header("location: /logout.php");
        exit();
        break;
      case '':
        header('location: /login');
        exit();
        break;
    }
  }else{
    header('location: /login');
  }
  
?>