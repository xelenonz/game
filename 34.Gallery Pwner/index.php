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
            <div class="row">
            <h2> PnP Gallery.</h2><br>
            <!-- Gallery -->
            <?php
            $list = glob('imgs/*.jpg');


            foreach ($list as $f) {
            ?>
                <div class="col-md-4 thumb">
                    <a class="thumbnail" href="#">
                        <img class="img-responsive" src="<?php echo $f ?>">
                    </a>
                </div>
            <?php
            }
            ?>
            </div>
        </div>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>

