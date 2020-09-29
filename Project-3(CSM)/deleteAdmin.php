<?php
require_once('includes/DB.php');
require_once('includes/functions.php');
require_once('includes/sessions.php');
?>

<?php 
if(isset($_GET['id'])){
    $SearchQueryParameter = $_GET['id'];
    
    $sql = "DELETE FROM admins  WHERE id='$SearchQueryParameter'";
    global $ConnectingDB;

    $Execeute = $ConnectingDB->query($sql);

    if($Execeute){
        $_SESSION["SuccesMessage"]="Admin Deleted Succesfully";
        Redirect_to("admins.php");
    }else{
        $_SESSION["ErrorMessage"]="Something went wrong";
        Redirect_to("admins.php");
    }

}

?>