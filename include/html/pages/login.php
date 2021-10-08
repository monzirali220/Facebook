<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../static/css/custam.css" type="text/css" media="all" />
  <title>Facebook</title>
</head>

<body>
  <header>
    <h4>Facebook</h4>
    
  </header>
  <main>
    <div class="form-container w-90 m-auto pt-3">
      <form action="" method="POST" accept-charset="utf-8">
        <?php
        if(isset($_POST["submit"])) {
        $Errors = validaty()["Errors"];
        }
        if(!empty($Errors["all"])){
          echo '<div class="form-contral" style="background-color: #333; height:30px; text-align:center; padding:5px">
          <span style="color: rgb(255,10,0)">
            '.$Errors["all"].'
          </span>
        </div>';
        }
        ?>
        <div class="form-contral">
          <label for="Email">Email :</label>
          <input type="text" name="email" id="Email" placeholder=" Enter your email" />
        </div>
        <?php
          if(!empty($Errors["email"])){
                  echo '<div class="form-contral" style="background-color: #333; height:30px; text-align:center; padding:5px">
                  <span style="color: rgb(255,10,0)">
                    '.$Errors["email"].'
                  </span>
          </div>';
          }
        ?>
        <div class="form-contral mt-1">
          <label for="Password">Password :</label>
          <input type="password" name="password" id="Password" placeholder=" Enter your email password" />
        </div>
        <?php
          if(!empty($Errors["password"])){
            echo '<div class="form-contral" style="background-color: #333; height:30px; text-align:center; padding:5px">
                  <span style="color: rgb(255,10,0)">
                    '.$Errors["password"].'
                  </span>
                </div>';
          }
        ?>
        <div class="form-contral mt-1">
          <label for="Remember">Remember-password :</label>
          <input type="checkbox" name="re-password" class="w-" id="Remember" />
        </div>
        <div class="form-contral mt-1">
          <button type="submit" name="submit" class="btn btn-primary w-50 m-auto" > submit</button>
        </div>
      </form>
      <span><a href="/signup">signup</a></span>
    </div>
  </main>
</body>
</html>