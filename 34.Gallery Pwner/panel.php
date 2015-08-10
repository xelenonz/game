<?php
session_start();
include 'conn.php';

if(isset($_SESSION['admin']) !== True){
	echo 'Access Denied';
	die();
}

if(isset($_POST['delfile'])){
	$del = array();
	if(unlink("imgs/".$_POST['delfile'])){
		$del['status'] = 'success';
	}else{
		$del['status'] = 'fail';
	}
}

if(isset($_FILES['file'])){
 
    $target_path = "imgs/";
    $upload = array();
   	if (!exif_imagetype($_FILES['file']['tmp_name'])) {  

        $upload['status'] = 'Incorrect File type !';

    } else {   

        if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path.$_FILES['file']['name'])) {   
            $upload['status'] = 'Uploaded !'; 
        } else{   
            $upload['status'] = 'Error !';
        }   
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
             <!-- Panel -->
            <center>
            	<?php if(isset($del)) echo $del['status'] ;?>
            	<?php if(isset($upload)) echo $upload['status'] ;?>
            <form action="panel.php" method="post" enctype="multipart/form-data">
				<label for="file">Upload new image:</label>
				<input type="file" name="file"><br>
				<input type="submit" name="submit" class="btn btn-success navbar-btn" value="Upload">
			</form></center>
            <table class="table table-hover">
		      <thead>
		        <tr>
		          <th>#</th>
		          <th>File Name</th>
		          <th>Size</th>
		          <th>Editing</th>
		        </tr>
		      </thead>
		      <tbody>
		      	<?php
		            $list = glob('imgs/*.jpg');

		            $i = 1;

		            foreach ($list as $f) {
				?>
					<tr>
				        <td><?php echo $i ?></td>
				        <td><?php echo $f ?></td>
				        <td><?php echo number_format(filesize($f) /1024,2).' KB'?></td>
				        <td>
				        	<a href="<?php echo $f ?>"><button class="btn btn-default" type="submit">View</button></a>
				        	<form action="panel.php" method="post">
				        		<input type="hidden" name="delfile" value="<?php echo $f ?>">
				        		<button class="btn btn-default" type="submit">Delete</button>
				        	</form>
				        </td>
			        </tr>
				<?php
					$i++;	
					}
				?>
		      </tbody>
		    </table>
		  </div>
	
    	</div>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>


