<?php
require_once('includes/DB.php');
require_once('includes/functions.php');
require_once('includes/sessions.php');

$_SESSION["UserId"]=null;
$_SESSION["Username"]=null;
$_SESSION["AdminName"] = null;

session_destroy();
Redirect_to("login.php");
//by clicking on logout button we execute this page
?>

