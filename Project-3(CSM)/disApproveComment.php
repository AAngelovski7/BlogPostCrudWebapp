<?php
require_once('includes/DB.php');
require_once('includes/functions.php');
require_once('includes/sessions.php');
?>

<?php 
if(isset($_GET['id'])){
    $SearchQueryParameter = $_GET['id'];
    $Admin =  $_SESSION["AdminName"];
    $sql = "UPDATE comments SET status='OFF', approvedby='$Admin' WHERE id='$SearchQueryParameter'";
    global $ConnectingDB;

    $Execeute = $ConnectingDB->query($sql);

    if($Execeute){
        $_SESSION["SuccesMessage"]="Comment Dis-Approved Succesfully";
        Redirect_to("comments.php");
    }else{
        $_SESSION["ErrorMessage"]="Something went wrong";
        Redirect_to("comments.php");
    }

}

?>