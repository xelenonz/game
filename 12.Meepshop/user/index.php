<?php
include '../function.php';
if(!isset($_SESSION['role']) || $_SESSION['role']!='user'){
  header("Location: ../index.php");die();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>Sticky Footer Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="sticky-footer.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Wrap all page content here -->
    <div id="wrap">

      <!-- Begin page content -->
      <div class="container">
        <div class="page-header">
          <h1>Welcome to Weed shop</h1>
        </div>
        <p class="lead">Hi <?=$_SESSION['username']?>, We have finest weed for sale do you want some?</p>
      </div>
      <div class="col-md-12 column">
      <div class="row clearfix">
        <div class="col-md-4 column">
          <div class="media well">
             <a href="#" class="pull-left"><img src="1.jpg" class="media-object" alt='' width="150px" height="150px" /></a>
            <div class="media-body">
              <h4 class="media-heading">
                Europe Weed
              </h4>
              
              
              <div class="media">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 column">
          <div class="media well">
             <a href="#" class="pull-left"><img src="2.jpg" class="media-object" alt='' width="150px" height="150px"/></a>
            <div class="media-body">
              <h4 class="media-heading">
                African Weed
              </h4>
              <div class="media">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 column">
          <div class="media well">
             <a href="#" class="pull-left"><img src="3.jpg" class="media-object" alt='' width="150px" height="150px"/></a>
            <div class="media-body">
              <h4 class="media-heading">
                Asia Weed
              </h4>
              <div class="media">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>

    <div id="footer">
      <div class="container">
        <p class="text-primary"><a href="../logout.php">Logout Here</a></p>
      </div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
