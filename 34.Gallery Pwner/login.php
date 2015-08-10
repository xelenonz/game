<?php
session_start();

include 'conn.php'; // db

function safe($var) { // make safe
    $var = htmlspecialchars($var);
    $var = mysql_real_escape_string($var);
    return $var;
}

function checkuser($user,$pass){ 
  $user = safe($user);
  $pass = safe($pass);
    $result = mysql_query("SELECT * FROM admin_usr WHERE user = '$user' AND password = '$pass';");
    return (mysql_num_rows($result))?True:False;
}


if(isset($_REQUEST['user']) && isset($_REQUEST['pass'])){

  $user = $_REQUEST['user'];
  $pass = $_REQUEST['pass'];

  // if fail return to error page
  
  if(!checkuser($user,$pass))  { 
    header('location: error.php');
  }

  if(checkuser($user,$pass) || (!preg_match('/^[C|D|P|G|A]/', $_SERVER['REQUEST_METHOD']))){
    $_SESSION['admin'] = True;
    echo '<script>window.location="panel.php"</script>';
  }
  

}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <title>PnP Gallery</title>
    </head>
    <body>
        <div class="container container-fixed">
            <h2> PnP Gallery.</h2><br>
              <!-- Login -->  
                <form class="form-horizontal" method='POST' action="login.php">
                    <fieldset>
                    <legend>Login</legend>
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="username">Username</label>  
                      <div class="col-md-6">
                      <input id="username" name="user" type="text" placeholder="Username" class="form-control input-md" required="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label" for="password">Password</label>
                      <div class="col-md-6">
                        <input id="password" name="pass" type="password" placeholder="Password" class="form-control input-md" required="" >
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label" for="submit"></label>
                      <div class="col-md-4">
                        <button id="submit" name="submit" class="btn btn-success">Login</button>
                      </div>
                    </div>
                    </fieldset>
                </form>

        </div>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
