<?php

require 'engine/init.php';

$session = Session::instance();
$session->clear();

header("Location: /login.php");
