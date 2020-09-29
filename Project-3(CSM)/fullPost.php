<?php 
require_once('includes/DB.php');
require_once('includes/functions.php');
require_once('includes/sessions.php');

$SearchQueryParameter = $_GET['id'];
?>

<?php
if(isset($_POST['Submit'])){
  $Name = $_POST['CommenterName'];
  $Email = $_POST['CommenterEmail'];
  $Comment = $_POST['CommenterThoughts'];
  date_default_timezone_set('Europe/Skopje');
  $CurrentTime = time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($Name)|| empty($Email) || empty($Comment) ){
    $_SESSION["ErrorMessage"]="All fields must be filled out"; //if this super globas variable
    Redirect_to("fullPost.php?id={$SearchQueryParameter}");
  }elseif(strlen($Comment) > 500 ){
    $_SESSION["ErrorMessage"]="Comment length should be less than 500 characters";
    Redirect_to("fullPost.php?id={$SearchQueryParameter}");
  }else{
    //Query to insert COMMENT in DB 
    $sql = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id) 
    VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromUrl)";// pass by PDO using dummy names
    $stmt = $ConnectingDB -> prepare($sql); //-> mean PDO object notation
    //binding values      dummy name     , actual value
    
    $stmt -> bindValue (":dateTime",$DateTime);
    $stmt -> bindValue (":name",$Name);
    $stmt -> bindValue (":email",$Email);
    $stmt -> bindValue (":comment",$Comment);
    $stmt -> bindValue (":postIdFromUrl",$SearchQueryParameter);

    $Execute = $stmt->execute();

    if($Execute){
      $_SESSION["SuccesMessage"]="Comment Submitted Succesfully";
      Redirect_to("fullPost.php?id={$SearchQueryParameter}"); //if inserted data redirect to this page
    }else{
      $_SESSION["ErrorMessage"]="Something went wrong. Try Again !";
      Redirect_to("fullPost.php?id={$SearchQueryParameter}");
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
  <title>Blog Page</title>
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
    
          <li class="nav-item">
            <a class="nav-link" href="blog.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="blog.php">Blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="liveblog.php?page=1">Live Blog</a>
          </li>
        </ul>
       <ul class="navbar-nav ml-auto">
        <form class="form-inline d-none d-sm-block" action="blog.php" >
            <div class="form-group">
                <input  class="form-control mr-2" type="text" name="Search" placeholder="Search here" value="" >
                <button class="btn btn-primary" name="SearchButton" type="submit">Go</button> 
                


            </div>
        </form>
       </ul>
      </div>
    </div>
  </nav>
  <div style="height:10px; background:#27aae1;"> </div>
</body>
<!-- Navbar end -->


<!-- Main Area Start -->
<div class="container">
    <div class="row mt-4">
        <div class="col-sm-8 ">
            <h1>The Complete Responsive CMS Blog</h1>
            <h1 class="lead">The Complete blog by using PHP</h1>
            <?php echo ErrorMessage();
          echo SuccessMessage();      ?>


        <?php  
          
          if(isset($_GET['SearchButton'])){
            $Search = $_GET['Search']; 
            $sql="SELECT * FROM posts WHERE datetime LIKE :search OR category LIKE :search OR post LIKE :search";
            $stmt = $ConnectingDB->prepare($sql);
            
            $stmt->bindValue(':search','%'.$Search.'%');
            $Execute = $stmt ->execute();

        }    
        
            //Default sql query      
            else
            {
                $PostIdFromUrl = $_GET['id']; 
                if(!isset($PostIdFromUrl)){
                    $_SESSION['ErrorMessage']="Bad Request";
                    Redirect_to("blog.php");
                }
                $sql = "SELECT * FROM posts WHERE id='$PostIdFromUrl'"; //last post entered to be first
                $stmt = $ConnectingDB -> query($sql);
            }
        
            while($DataRows = $stmt->fetch()){
                $PostId= $DataRows['id'];
                $DateTime = $DataRows['datetime'];
                $PostTitle = $DataRows['title'];
                $Category = $DataRows['category'];
                $Admin = $DataRows['author'];
                $Image = $DataRows['image'];
                $PostDescription = $DataRows['post'];
                ?>

            <div class="card">
            <img src="uploads/<?php echo htmlentities($Image);  ?>"style="max-height:450px;" class="img-fluid card-img"   alt="">
                <div class="card-body">
                    <h4 class="card-title"> <?php echo  htmlentities($PostTitle); ?></h4>
                    <small class="text-muted" >Category: <span class="text-dark"><?php echo $Category; ?> </span>& Writen by <span class="text-dark"> <?php echo htmlentities($Admin); ?> </span>On <?php echo htmlentities($DateTime); ?></small>
                       <hr>
                    <p class="card-text">
                     <?php echo htmlentities($PostDescription) ?> 
                    </p>
                    
                </div>
             </div>
      
          <?php } ?>
          
        <!-- Comment Part Start -->
              <!-- Fetching existing comment START -->
              <span class="Fieldinfo " style="color:black;">Comments</span>
               <?php 
                  $sql= "SELECT * FROM comments WHERE post_id='$SearchQueryParameter'
                  AND status='ON'";
                  $stmt = $ConnectingDB->query($sql);

                  while($DataRows = $stmt->fetch()){
                    $CommentDate = $DataRows['datetime'];
                    $CommenterName = $DataRows['name'];
                    $CommentContent = $DataRows['comment'];
                  ?>
                
                    <div> 
                        <div class="media CommentBlock">
                          <img class="d-block img-fluid align-self-start" src="images/comment.png" alt="">
                          <div class="media-body ml-2">
                            <h6 class="lead"><?php echo $CommenterName ?></h6>
                            <p class="small"><?php echo $CommentDate?> </p>
                            <p> <?php echo $CommentContent ?></p>
                          </div>
                        </div>
                    </div>
                    <hr>
                <?php  
                }
                ?>
               <!-- Fetching existing comment END -->

           <div class=""> 
              <form action="fullPost.php?id=<?php echo $SearchQueryParameter; ?>" method="POST">
                <div class="card my-3">
                    <div class="card-header">
                      <h5 class="Fieldinfo" style="color:black;">Share your thoughts about this post</h5>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fas fa-user"></i> </span>
                          </div>
                          <input class="form-control" type="text" name="CommenterName" placeholder="Name" id="">
                        </div>
                      </div> 
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fas fa-envelope"></i> </span>
                          </div>
                          <input class="form-control" type="email" name="CommenterEmail" placeholder="Email" id="">
                        </div>
                      </div> 
                      <div class="form-group"> 
                        <textarea class="form-control" name="CommenterThoughts" id="" cols="80" rows="5"></textarea>
                      </div>
                        <div class="">
                          <button class="btn btn-primary" type="submit" name="Submit">Submit</button>
                        </div>


                      
                    </div>
                </form>
           </div> 
           </div>    
        <!-- Comment Part End -->

      </div>

      <div class="col-sm-4">
        <div class="card mt-4">
          <div class="card-body">
            <img src="images/Laptop.png" class="d-block img-fluid mb-3" alt="">
            <div class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
          </div>
        </div> <br>
          <div class="card">
            <div class="card-header bg-dark text-light">
              <h2 class="lead">Sign Up!</h2>
            </div>
            <div class="card-body">
              <button class="btn btn-success btn-block text-center text-white mb-2" type="button" name="button">Join the Forum</button> 
              <button class="btn btn-danger btn-block text-center text-white mb-2" type="button" name="button">Login</button>
              <div class="input-group mb-3">
                  <input type="text" class="form-control" name="" id="" placeholder="Enter your email" value="" >
                  <div class="input-group-append">
                      <button class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Now</button>
                  </div>
              </div>
            </div>
          </div>
            <br>
            <div class="card">
              <div class="card-header bg-primary text-light">
                  <h2 class="lead">Categories</h2>
              </div>    
                  <div class="card-body">
                      <?php 
                        global $ConnectingDB;
                        $sql="SELECT * FROM category ORDER BY id desc";
                        $stmt=$ConnectingDB->query($sql);
                        while($DataRows = $stmt->fetch()){
                          $CategoryId = $DataRows['id'];
                          $CategoryName = $DataRows['title'];
                       ?>
                     <a href="blog.php?category=<?php echo $CategoryName; ?>"> <span class="heading"> <?php  echo $CategoryName; ?> </span> </a> <br>
                        <?php } ?>
                
              </div>
            </div>            
            <br>

            <div class="card">
              <div class="card-header bg-info text-white">
                <h2 class="lead">Recent Posts</h2>
              </div>
              <div class="card-body">
                <?php 
                  $sql="SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                  $stmt = $ConnectingDB->query($sql);
                  while($DataRows = $stmt->fetch()){
                    $Id = $DataRows['id'];
                    $Title = $DataRows['title'];
                    $DateTime = $DataRows['datetime'];
                    $Image = $DataRows['image'];
               ?>
                  <div class="media">
                     <img src="uploads/<?php echo $Image; ?>" class="d-block img-fluid align-self-start mb-2" width="110px" style="height:90px" alt="">
                     <div class="media-body ml-2 ">
                       <a href="fullPost.php?id=<?php echo $Id; ?>" target="_blanc"> <h6 class="lead"><?php echo $Title;?></h6> </a>
                        <p class="small"><?php echo $DateTime; ?></p>
                     </div>
                  </div>
                <?php } ?>
              </div>
            </div>


      </div>       


    </div>
</div>

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
