<?php 
require_once('includes/DB.php');
require_once('includes/functions.php');
require_once('includes/sessions.php');
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];

Confrim_Login();

if(isset($_POST['Submit'])){
  $UserName= $_POST['Username'];
  $Password = $_POST['Password'];
  $Name = $_POST['Name'];
  $Admin = $_SESSION["Username"];
  $ConfirmPassword = $_POST['ConfirmPassword'];
  date_default_timezone_set('Europe/Skopje');
  $CurrentTime = time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($UserName)||empty($Password)|| empty($ConfirmPassword)){
    $_SESSION["ErrorMessage"]="All fields must be filled out"; //if this super globas variable
    Redirect_to("admins.php");
  }elseif(strlen($Password) <4 ){
    $_SESSION["ErrorMessage"]="Password should be greater than 3 characters";
    Redirect_to("admins.php");
  }elseif($Password !== $ConfirmPassword){
    $_SESSION["ErrorMessage"]="Password and Confirm Password should match";
    Redirect_to("admins.php");
  }elseif(CheckUserNameExistsOrNot($UserName)){
    $_SESSION["ErrorMessage"]="Username exist. Try another one.";
    Redirect_to("admins.php");
  }else{
    //Query to insert category in DB 
    $sql = "INSERT INTO admins(datetime, username, password, aname, addedby)
     VALUES(:dateTime, :userName, :password, :aName, :adminName)";// pass by PDO using dummy names
    $stmt = $ConnectingDB -> prepare($sql); //-> mean PDO object notation

    //binding values      dummy name     , actual value
    $stmt -> bindValue (":dateTime",$DateTime);
    $stmt -> bindValue (":userName",$UserName);
    $stmt -> bindValue (":password",$Password);
    $stmt -> bindValue (":aName",$Name);
    $stmt -> bindValue (":adminName",$Admin);

    $Execute = $stmt->execute();

    if($Execute){
      $_SESSION["SuccesMessage"]="New Admin Added Succesfully";
      Redirect_to("admins.php"); //if inserted data redirect to this page
    }else{
      $_SESSION["ErrorMessage"]="Something went wrong. Try Again !";
      Redirect_to("admins.php");
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
  <title>Admin Page</title>
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
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="myprofile.php"> <i class="fas fa-user text-success"></i> My Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="posts.php">Posts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="categories.php">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="manageadmins.php">Manage Admins</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="comments.php">Comments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="liveblog.php?page=1">Live Blog</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-danger" href="logout.php"><i class="fas fa-user-times"></i> Logout</a>
          </li>
        </ul>
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
    <h1> <i class="fas fa-user"style="color:#27aae1"></i>  Manage Admin</h1>
    </div>
  </div>
</div>
</header>
<!-- Header End -->



<!-- Main Area Start -->
<section class="container py-2 mb-4">
  <div class="row">
    <div class="offset-lg-1 col-lg-10" style="min-height:400px;">

    <?php echo ErrorMessage();
          echo SuccessMessage();      
    ?>

      <form class="" action="admins.php" method="POST">
             <div class="card bg-secondary text-light mb-3">
            <div class="card-header">
              <h1>Add new Admin</h1>
            </div>
            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="username"> <span class="Fieldinfo">Username</span></label> <br>
                <input class="form-control" type="text" name="Username" id="username" value="" >
              </div>
              <div class="form-group">
                <label for="name"> <span class="Fieldinfo">Name</span></label> <br>
                <input class="form-control" type="text" name="Name" id="name" value="" >
                <small class="text-muted"> *Optional</small>
              </div>
              <div class="form-group">
                <label for="password"> <span class="Fieldinfo">Password</span></label> <br>
                <input class="form-control" type="password" name="Password" id="password" value="" >
               
              </div>
              <div class="form-group">
                <label for="confirmPassword"> <span class="Fieldinfo">Confirm Password</span></label> <br>
                <input class="form-control" type="password" name="ConfirmPassword" id="confirmPassword" value="" >
              </div>

              <div class="row">
                <div class="col-lg-6 mb-2">
                  <a class="btn btn-warning btn-block " href="dashboard.php"><i class="fas fa-arrow-left"></i>Back To Dashboard</a>
                </div>
                <div class="col-lg-6 mb-2">
                  <button class="btn btn-success btn-block" type="submit" name="Submit"><i class="fas fa-check"></i>Publish</button>
                </div>
              </div>
            </div>
        </div>
      </form>

      <h2>Existing Admins</h2>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Date&Time</th>
                    <th>Username</th>
                    <th>Admin Name</th>
                    <th>Added by</th>
                    <th>Action</th>
                  </tr>
            </thead>
       
        
            <?php 
                $sql = "SELECT * FROM admins ORDER BY id desc";
                $Execute = $ConnectingDB->query($sql);
                $SrNo = 0;

                while($DataRows=$Execute->fetch()){
                    $AdminId=$DataRows['id'];
                    $DateTime = $DataRows['datetime'];
                    $AdminUserName = $DataRows['username'];
                    $AdminName = $DataRows['aname'];
                    $AddedBy = $DataRows['addedby'];
                    $SrNo++;
                   
            ?>
                <tbody>
                    <tr>
                    <td><?php echo $SrNo; ?></td>
                    <td><?php echo htmlentities($DateTime) ; ?></td>
                    <td><?php echo htmlentities( $AdminUserName); ?></td>
                    <td  ><?php echo htmlentities($AdminName); ?></td>
                    <td  ><?php echo htmlentities($AddedBy); ?></td>
                    <td><a class="btn btn-danger" href="deleteAdmin.php?id=<?php echo $AdminId; ?>">Delete</a></td>
                    </tr>
                </tbody>
                <?php } ?>
            </table>

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
