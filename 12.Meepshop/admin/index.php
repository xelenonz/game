<?php
include '../function.php';
if(!isset($_SESSION['role']) || $_SESSION['role']!='admin'){
  header("Location: ../index.php");die();
}
$key = "exploit me and find this key on the server";
?>
<html>
<head><title>Admin</title></head>
<body>
<pre>	
Welcome my dear hacker..

	Key is Fuck you I don't give you any shit..

	stay away from my place dude..

With love,
Fuckin Real Admin
</pre>
<a href="../logout.php">Go to Heaven</a>
</body>
<html>
