<?php 
require_once('includes/DB.php');
require_once('includes/functions.php');
require_once('includes/sessions.php');
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confrim_Login();
?>

<?php 
//Fetching the existing Admin DATA
$AdminId =  $_SESSION["UserId"];
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt=$ConnectingDB->query($sql);
    while($DataRows = $stmt->fetch()){
        $ExistingName = $DataRows['aname'];
    }
//Fetching the existing Admin DATA END
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
  <title>My Profile</title>
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
    <h1> <i class="fas fa-user mr-2"style="color:#27aae1"></i>  My Profile</h1>
    </div>
  </div>
</div>
</header>
<!-- Header End -->



<!-- Main Area Start -->

<section class="container py-2 mb-4">
  <div class="row">
  <!-- Left Area -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-dark text-light">
                <h3><?php echo $ExistingName;?></h3>
            </div>
            <div class="card-body">
                <img src="images/comment.png" class="block img-fluid mb-3" alt="">
                <div class=>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
            </div>
        </div>
    
    </div>


  <!-- Right Area -->
    <div class="col-md-9" style="min-height:400px;">

    <?php echo ErrorMessage();
          echo SuccessMessage();      
    ?>
     <!-- enctype because we have image -->
      <form class="" action="myProfile.php" method="POST" enctype="multipart/form-data">
             <div class="card bg-dark text-light">
                <div class="card-header bg-secondary text-light">
                    <h4>Edit Profile</h4>
                </div>
            <div class="card-body">
            <div class="form-group">
                <input class="form-control" type="text" name="Name" id="title" value="" placeholder="Your name">
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="Headline" id="title" value="" placeholder="Headline">
                <small class="text-muted">Add a professional headline like, 'Enginer' at XYZ or 'Architect'</small>
                <span class="text-danger">Not more than 12 characters</span>
            </div>

     `       <div class="form-group">
                <textarea class="form-control" name="Bio" id="" cols="80" rows="5" placeholder="Bio"></textarea>
            </div>`
           <div class="form-group">
              <div class="custom-file">
                 <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">   
                 <label for="imageSelect" class="custom-file-label"> Select Image</label>
                <!-- for= and also id= of input need to be equal -->
           </div>
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
