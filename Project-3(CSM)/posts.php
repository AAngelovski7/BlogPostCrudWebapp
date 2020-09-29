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
    <h1> <i class="fas fa-blog"style="color:#27aae1"></i>  Blog Post</h1>
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
    <div class="col-lg-12">
    <?php echo ErrorMessage();
          echo SuccessMessage();      
    ?>
        <table class="table table-striped table-hover">
           <thead class="thead-dark">
              <tr>
                <th> </th>
                <th>Title </th>
                <th>Category </th>
                <th>Date&Time </th>
                <th>Author </th>
                <th>Banner </th>
                <th>Comments </th>
                <th>Action </th>
                <th>Live Preview </th>
              </tr>  
            </thead>
            <?php 
            $sql = "SELECT * FROM posts";
            $stmt = $ConnectingDB->query($sql);
            $Sr=0;
                while($DataRows = $stmt->fetch()){
                    $Id = $DataRows['id'];
                    $DateTime = $DataRows['datetime'];
                    $PostTitle = $DataRows['title'];
                    $Category = $DataRows['category'];
                    $Admin = $DataRows['author'];
                    $Image = $DataRows['image'];
                    $PostText = $DataRows['post'];
                    $Sr++;
                   
            ?>
      <tbody>     
        <tr>
               <td><?php echo $Sr?></td>
               <td> <?php if(strlen($PostTitle)>20){
                   $PostTitle = substr($PostTitle,0,14);
                   echo $PostTitle."...";
               }else{
                echo $PostTitle;
               } ?></td>
               <td><?php if(strlen($Category)>8){
                   $Category = substr($Category,0,7)."...";
               }echo $Category ?></td>
               <td><?php echo $DateTime ?></td>
               <td><?php if(strlen($Admin) > 6){
                   $Admin = substr($Admin,0,6) ."...";
               } echo $Admin ?></td>
               <td><img src="uploads/<?php echo $Image; ?>" width="170px;" height="50px;"  alt=""></td>
               <td>
                       
                       <?php 
                        $Total =  ApproveCommentsAccordingtoPost($Id);
                               if($Total>0){ ?>
                                   <span class="badge badge-success">
                                 <?php  echo $Total; ?>
                                 </span>
                                <?php } ?>
                              
                          <?php
                          $Total = DisApproveCommentsAccordingtoPost($Id);
                               if($Total>0){ ?>
                                   <span class="badge badge-danger">
                                 <?php  echo $Total; ?>
                                 </span>
                                <?php } ?>
               </td>
               <td>
               <a href="editPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning ">Edit</span></a>
               <a href="deletePost.php?id=<?php echo $Id ;?>"><span class="btn btn-danger">Delete</span></a>
               </td>
               
               <td> <a href="fullPost.php?id=<?php echo $Id; ?>"><span class="btn btn-primary">Live Preview</span></a></td>
               
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
