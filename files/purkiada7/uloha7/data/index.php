<?php 

session_start();

if(isset($_SESSION['loggedIn'])){
  $name = $_SESSION['nickname'] . '@pc' . $_SESSION['path'];
} else {
  $name = ">";
}

?>

<!doctype html>
<html lang="cs">
  <head>
    <!-- Title -->
    <title>Purkiáda - Console</title>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <!-- CSS includes -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <!-- JS includes -->
    <script src="./js/jquery-1.11.3.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/console.js"></script> 
  </head>
  <body>

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="console-wrapper" id="console-wrapper" onclick="focusConsole()">
            <div class="return">
              <span><?= $name ?></span>
              <input type="text" id="input" name="input" autofocus="1" >
            </div>
          </div>
        </div>
      </div>
    </div>  
  </body>  
</html>