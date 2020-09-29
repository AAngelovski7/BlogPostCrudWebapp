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
  <title>Comments</title>
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
    <h1> <i class="fas fa-comments"style="color:#27aae1"></i>  Manage Comments</h1>
    </div>
  </div>
</div>
</header>
<!-- Header End -->



<!-- Main Area Start -->
<section class="container py-2 mb-4">
  <div class="row" style="min-height:30px;">
    <div class="col-lg-12" style="min-height:400px;">
    <?php echo ErrorMessage();
          echo SuccessMessage();      
    ?>
    <h2>Un-Approved Comments</h2>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Date&Time</th>
                    <th>Comment</th>
                    <th>Aprove</th>
                    <th>Delete</th>
                    <th>Details</th>
                </tr>
            </thead>
       
        
            <?php 
                $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
                $Execute = $ConnectingDB->query($sql);
                $SrNo = 0;

                while($DataRows=$Execute->fetch()){
                    $CommentId=$DataRows['id'];
                    $DateTimeOfComment = $DataRows['datetime'];
                    $CommenterName = $DataRows['name'];
                    $CommentContent = $DataRows['comment'];
                    $CommenterPostId= $DataRows['post_id'];
                    $SrNo++;
                    if(strlen($CommenterName)>10){
                        $CommenterName=substr($CommenterName,0,10)."...";
                    }
                    if(strlen($DateTimeOfComment)>11){
                        $DateTimeOfComment=substr($DateTimeOfComment,0,11)."...";
                    }
                
            ?>
                <tbody>
                    <tr>
                    <td><?php echo $SrNo; ?></td>
                    <td><?php echo htmlentities($CommenterName) ; ?></td>
                    <td><?php echo htmlentities( $DateTimeOfComment); ?></td>
                    <td  ><?php echo htmlentities($CommentContent); ?></td>
                    <td ><a class="btn btn-success" href="approveComment.php?id=<?php echo $CommentId; ?>">Approve</a></td>
                    <td><a class="btn btn-danger" href="deleteComment.php?id=<?php echo $CommentId; ?>">Delete</a></td>

                    <td style="min-width:140px"><a class="btn btn-primary" href="fullPost.php?id=<?php echo $CommenterPostId;?>" target="_blank">Live Preview</a></td>
                    </tr>
                </tbody>
                <?php } ?>
            </table>


            <h2>Approved Comments</h2>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Date&Time</th>
                    <th>Comment</th>
                    <th>Revert</th>
                    <th>Delete</th>
                    <th>Details</th>
                </tr>
            </thead>
       
        
            <?php 
                $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
                $Execute = $ConnectingDB->query($sql);
                $SrNo = 0;

                while($DataRows=$Execute->fetch()){
                    $CommentId=$DataRows['id'];
                    $DateTimeOfComment = $DataRows['datetime'];
                    $CommenterName = $DataRows['name'];
                    $CommentContent = $DataRows['comment'];
                    $CommenterPostId= $DataRows['post_id'];
                    $SrNo++;
                    if(strlen($CommenterName)>10){
                        $CommenterName=substr($CommenterName,0,10)."...";
                    }
                    if(strlen($DateTimeOfComment)>11){
                        $DateTimeOfComment=substr($DateTimeOfComment,0,11)."...";
                    }
                
            ?>
                <tbody>
                    <tr>
                    <td><?php echo $SrNo; ?></td>
                    <td><?php echo htmlentities($CommenterName) ; ?></td>
                    <td><?php echo htmlentities( $DateTimeOfComment); ?></td>
                    <td  ><?php echo htmlentities($CommentContent); ?></td>
                    <td style="min-width:140px"><a class="btn btn-warning" href="disApproveComment.php?id=<?php echo $CommentId; ?>">Dis-Approve</a></td>
                    <td><a class="btn btn-danger" href="deleteComment.php?id=<?php echo $CommentId; ?>">Delete</a></td>

                    <td style="min-width:140px"><a class="btn btn-primary" href="fullPost.php?id=<?php echo $CommenterPostId;?>" target="_blank">Live Preview</a></td>
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
