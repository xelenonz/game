<?php
include 'functions.php';
echo (user_exist($_POST['username'])?'0':'1');
?>