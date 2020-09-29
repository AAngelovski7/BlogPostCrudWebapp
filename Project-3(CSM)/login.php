<?php 
require_once('includes/DB.php');
require_once('includes/functions.php');
require_once('includes/sessions.php');

if(isset($_SESSION["UserId"])){
  Redirect_to("dashboard.php"); //ko ke sme logirani da ne mojme na ta str da ojme da ne prefrlat na dashboard.php page
}
//ako sme logirani ovaj kod nema da se izvrsuavat ke ne redirect to dashboard.php 
if(isset($_POST["Submit"])){
    $Username=$_POST["Username"];
    $Password=$_POST["Password"];
    
    if(empty($Username)||empty($Password)){
        $_SESSION["ErrorMessage"]="All Fields must be filled out";
        Redirect_to("login.php");
        
    }else{
       $Found_Account =Login_Attempt($Username,$Password);
       
        if($Found_Account){
            $_SESSION["UserId"]=$Found_Account["id"];    // put id of user in session
            $_SESSION["Username"]=$Found_Account["username"];
            $_SESSION["AdminName"] = $Found_Account["aname"];

            $_SESSION["SuccesMessage"]="Wellcome ".$_SESSION["AdminName"];

            if (isset($_SESSION["TrackingURL"])) {
              Redirect_to($_SESSION["TrackingURL"]);
            }else{
              Redirect_to("dashboard.php");
            }
              
        }else{
            $_SESSION["ErrorMessage"]="Incorrect Username/Password"; //if this super globas variable
            Redirect_to("login.php");
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <!-- Font awsome stylesheet -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.1/css/all.css" integrity="sha384-wxqG4glGB3nlqX0bi23nmgwCSjWIW13BdLUEYC4VIMehfbcro/ATkyDsF/AbIOVe" crossorigin="anonymous">
  <!-- Bootstrap stylesheet -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styles.css" />
  <title>Categories</title>
</head>



<body>

  <!-- Navbar Start-->
  <div style="height:10px; background:#27aae1;"> </div>
  <nav class="navbar navbar-expand-lg bg-dark navbar-dark ">
    <div class="container">
      <a class="navbar-brand" href="#">Antonio</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarcollapseCMS">
       
      </div>
    </div>
  </nav>
  <div style="height:10px; background:#27aae1;"> </div>
</body>
<!-- Navbar end -->


<!-- Header Start -->
<header class="bg-dark text-white py-3">
<div class="container">
  <div class="row">
    <div class="col-md-12">
    
    </div>
  </div>
</div>
</header>
<!-- Header End -->



<!-- Main Area Start -->
<section class="container py-2 mb-4">
    <div class="row">
        <div class="offset-sm-3 col-sm-6" style="min-height:500px;">
        
        <br><br>
        <?php echo ErrorMessage();
          echo SuccessMessage();      
    ?>

            <div class="card bg-secondary text-light">
                <div class="card-header">
                    <h4>Welcome BACK! </h4>
                    </div>
                    <div class="card-body bg-dark">
                 
                        <form action="login.php" method="post">
                            <div class="form-group">
                                <label for="username"> <span class="Fieldinfo">Username</span></label>
                                   <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                                    </div>
                                <input class="form-control" type="text" name="Username" id="username">
                            </div>
                          </div>  

                          <div class="form-group">
                                <label for="password"> <span class="Fieldinfo">Password</span></label>
                                   <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                                    </div>
                                <input class="form-control" type="password" name="Password" id="password">
                            </div>
                          </div>  
                            <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
                        </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Main Area End -->



<!-- Footer Start -->
<footer class="bg-dark text-white">
  <div class="container">
    <div class="row">
      <div class="col">
        <p class="lead text-center">Theme By |Antonio Angelovski| <span id="year"></span> &copy --All right Reserved.</p>
      </div>
    </div>
  </div>
</footer>
<div style="height:10px; background:#27aae1;"> </div>
<!-- Footer End -->



<!-- Bootstrap scripts  -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
  $('#year').text(new Date().getFullYear()); //on id year add today date in year only
</script>

</html>
