<?php
session_start();
require_once "class.user.php";

$user = new USER();

if($user->adminlogout()) {

    header("location: login.php");
    exit;
}


?>