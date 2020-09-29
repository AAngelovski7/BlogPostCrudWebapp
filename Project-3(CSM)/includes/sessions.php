<?php
session_start();

function ErrorMessage(){
    if(isset($_SESSION["ErrorMessage"])){ //categories page 
        $Output = "<div class=\"alert alert-danger\">";
        $Output .= htmlentities($_SESSION["ErrorMessage"]);    //html entites always use when outpit some data 
        $Output .= "</div>";
         $_SESSION["ErrorMessage"] = null; //at the end clear the seesion when refresh page
        return $Output;
    }
}

function SuccessMessage(){
    if(isset($_SESSION["SuccesMessage"])){ //from categories page
        $Output = "<div class=\"alert alert-success\">";
        $Output .= htmlentities($_SESSION["SuccesMessage"]);    //html entites always use when outpit some data 
        $Output .= "</div>";
        $_SESSION["SuccesMessage"]= null; //at the end clear the seesion
        return $Output;
    }
}



?>