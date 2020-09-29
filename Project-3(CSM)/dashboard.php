<?php 
require_once('includes/DB.php');
require_once('includes/functions.php');
require_once('includes/sessions.php');

$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];

Confrim_Login();


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
  <title>Dashboard</title>
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
    <h1> <i class="fas fa-cog"style="color:#27aae1"></i>  Dashboard</h1>
    </div>
    <div class="col-lg-3 mb-2">
        <a href="addNewPost.php" class="btn btn-primary btn-block">
            <i class="fas fa-edit"></i>  Add New Post
        </a>    
    </div>
    
    <div class="col-lg-3 mb-2">
        <a href="categories.php" class="btn btn-info btn-block">
            <i class="fas fa-folder-plus"></i>  Add New Category
        </a>     
    </div>
    <div class="col-lg-3 mb-2">
        <a href="#" class="btn btn-warning btn-block">
            <i class="fas fa-user-plus"></i>  Add New Admin
        </a>     
    </div>
    <div class="col-lg-3 mb-2">
        <a href="comments.php" class="btn btn-success btn-block">
            <i class="fas fa-check"></i> Aprove Comment
        </a>     
    </div>

  </div>
</div>
</header>
<!-- Header End -->



<!-- Main Area Start -->
<section class="py-3 px-5 mb-4">

<div class="row">
<?php echo ErrorMessage();
          echo SuccessMessage();      
    ?>
    <!-- Left Side Area Start -->
    <div class="col-lg-2 d-none d-md-block">   <!-- d-none and d-md-block to not appear on medium screen -->
        
        <div class="card text-center bg-dark text-white mb-3">
            <div class="card-body">
                <h1 class="lead">Posts</h1>
                    <h4 class="display-5">
                        <i class="fab fa-readme"></i>
                       <?php 
                       TotalPosts();
                       ?>
                    </h4>
            </div>
        </div>
        <div class="card text-center bg-dark text-white mb-3">
            <div class="card-body">
                <h1 class="lead">Categories</h1>
                    <h4 class="display-5">
                        <i class="fas fa-folder"></i>
                        <?php 
                       TotalCategories();
                       ?>
                    </h4>
            </div>
        </div>
        <div class="card text-center bg-dark text-white mb-3">
            <div class="card-body">
                <h1 class="lead">Admins</h1>
                    <h4 class="display-5">
                        <i class="fas fa-user"></i>
                        <?php 
                        TotalAdmins();
                       ?>
                    </h4>
            </div>
        </div>
        <div class="card text-center bg-dark text-white mb-3">
            <div class="card-body">
                <h1 class="lead">Comments</h1>
                    <h4 class="display-5">
                        <i class="fas fa-comments"></i>
                        <?php 
                      TotalComments();
                       ?>
                    </h4>
            </div>
        </div>
    </div>
      <!-- Left Side Area End -->

    <!-- Right Side Area Start -->
        <div class="col-lg-10">
            <h2>Top Posts</h2>
            <table class="table table-striped table">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Date&Time</th>
                        <th>Author</th>
                        <th>Comments</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <?php 
                    $SrNo = 0;
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                    $stmt = $ConnectingDB->query($sql);
                        while ($DataRows = $stmt->fetch() ){
                            $PostId=$DataRows['id'];
                            $DateTime = $DataRows['datetime'];
                            $Author = $DataRows['author'];
                            $Title = $DataRows['title'];
                            $SrNo++;
                        
                ?>
                <tbody>
                    <tr>
                    <td><?php echo htmlentities($SrNo); ?></td>
                    <td><?php echo htmlentities($Title); ?></td>
                    <td><?php echo htmlentities($DateTime); ?></td>
                    <td><?php echo htmlentities($Author); ?></td>
                    <td>
                       
                            <?php 
                             $Total =  ApproveCommentsAccordingtoPost($PostId);
                                    if($Total>0){ ?>
                                        <span class="badge badge-success">
                                      <?php  echo $Total; ?>
                                      </span>
                                     <?php } ?>
                                   
                               <?php
                               $Total = DisApproveCommentsAccordingtoPost($PostId);
                                    if($Total>0){ ?>
                                        <span class="badge badge-danger">
                                      <?php  echo $Total; ?>
                                      </span>
                                     <?php } ?>
                    </td>
                    <td>
                       <a href="fullPost.php?id=<?php echo $PostId ?>"> <span class="btn btn-info">Preview</span></a>
                    </td>

                    </tr>
                </tbody>
                <?php } ?>
            </table>
        </div>
    <!-- Right Side Area End -->



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
