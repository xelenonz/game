<?php
include 'function.php';
$user = (isset($_POST['username'])?$_POST['username']:"");
$pass = (isset($_POST['password'])?$_POST['password']:"");
if($user && $pass){
	$result = register($user,$pass);
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="xelenonz">

    <title>Meed Shop</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="row clearfix">
				<div class="col-md-4 column">
				</div>
				<div class="col-md-4 column">
					<h3 class="text-primary">
						Register form
					</h3>
					<?php if(isset($result) && $result){?>
					<div class="alert alert-dismissable alert-success">
						 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4>
							Nice!
						</h4> Welcome new member <br><a href="index.php" class="alert-link"><< Go Back</a>
					</div><? } ?>
					<form role="form" action="register.php" method="POST">
						<div class="form-group">
							 <label for="Username">Username</label><input name="username" type="text" class="form-control" />
						</div>
						<div class="form-group">
							 <label for="Password">Password</label><input name="password" type="password" class="form-control" />
						</div>
					<button type="submit" class="btn btn-default">Register!</button>
					</form>
				</div>
				<div class="col-md-4 column">
				</div>
			</div>
		</div>
	</div>
</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>