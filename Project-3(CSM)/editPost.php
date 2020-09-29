<?php 
require_once('includes/DB.php');
require_once('includes/functions.php');
require_once('includes/sessions.php');
Confrim_Login();

$SearchQueryParameter = $_GET['id'];
if(isset($_POST['Submit'])){
//Grab data that we enter in the input fields
  $PostTitle = $_POST['PostTitle'];
  $Category = $_POST['Category'];
  $Image = $_FILES["Image"]["name"];  //$_FILES BECAUSE WE USE IMAGE , AND CAN NOT BE SAVE DIRECTLY INTO DB
  $Target = "uploads/".basename($_FILES["Image"]["name"]);//take base name of the image that user will enter
  $PostText = $_POST['PostDescription'];
  $Admin = "Antonio";
  date_default_timezone_set('Europe/Skopje');
  $CurrentTime = time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  //Validation if POST TITLE
  if(empty($PostTitle)){
    $_SESSION["ErrorMessage"]="Title can not be EMPTY"; //if this super globas variable
    Redirect_to("posts.php");
  }elseif(strlen($PostTitle) <5 ){
    $_SESSION["ErrorMessage"]="Post Title should be greater than 5 characters";
    Redirect_to("posts.php");
  }elseif(strlen($PostText) > 9999 ){
    $_SESSION["ErrorMessage"]="Post Description should be less than 10000 characters";
    Redirect_to("posts.php");
  }else{
    //Query to UPDATE POST into DataBaase when everything is okay 
    if(!empty($_FILES["Image"]["name"])){
      $sql = "UPDATE posts 
      SET title='$PostTitle', category='$Category', image='$Image', post='$PostText' 
      WHERE id='$SearchQueryParameter'";
         
    }else{
        $sql = "UPDATE posts 
        SET title='$PostTitle', category='$Category', post='$PostText' 
        WHERE id='$SearchQueryParameter'";
          
    }    
    
    $stmt=$ConnectingDB->query($sql);  
    var_dump($stmt);

    
         //php function from move image to uploads folder    - target is location where is image that we select 
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);//this tem name will be given by default and this file will be remembered
                    //tmp_name must be used no another name
                   
    // if($Execute){
    //   $_SESSION["SuccessMessage"]="Posst Updated Succesfully";
    //   Redirect_to("posts.php");
    // }else{
    //   $_SESSION["ErrorMessage"]="Something went wrong. Try Again !";
    //   Redirect_to("posts.php");
    // }
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
  <title>Edit Post</title>
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
    <h1> <i class="fas fa-edit"style="color:#27aae1"></i>  Edit Post</h1>
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
    
    //Fetching Existing Content according to our
    $sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
    $stmt = $ConnectingDB->query($sql);
        while($DataRows = $stmt->fetch()){
            $TitleToBeUpdated = $DataRows['title'];
            $CategoryToBeUpdated = $DataRows['category'];
            $ImageToBeUpdated = $DataRows['image'];
            $PostToBeUpdated = $DataRows['post'];
    }
    ?>

     <!-- enctype because we have image -->
      <form class="" action="editPost.php?id=<?php echo $SearchQueryParameter;?>" method="POST" enctype="multipart/form-data">
             <div class="card bg-secondary text-light mb-3">
            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="title"> <span class="Fieldinfo">Post Title</span></label> <br>
                <input class="form-control" type="text" name="PostTitle" id="title" value="<?php echo $TitleToBeUpdated;?>" placeholder="Type Title here">
              </div>
              <div class="form-group">
              <span class="Fieldinfo"> Existing Category : </span>
              <?php echo $CategoryToBeUpdated; ?> <br>
                <label for="CategoryTitle"> <span class="Fieldinfo">Choose Category</span></label> <br>
               <select class="form-control" name="Category" id="CategoryTitle">
                <?php 
                //Fetching all categories from category table
                $sql = "SELECT * FROM category";
                $stmt = $ConnectingDB ->query($sql);
                    while($DataRows = $stmt->fetch()){
                        $Id = $DataRows['id'];
                        $CategoryName = $DataRows['title']
                   
                  ?>
                  <option> <?php echo $CategoryName ?></option>

            <?php  } ?>            


               </select>
              </div>    

            <div class="form-group mb-1">
            <span class="Fieldinfo"> Existing Image : </span>
            <img class="mb-2" src="uploads/<?php echo $ImageToBeUpdated; ?>" width="170px"; height="70px"; alt="">
            <div class="custom-file">
            <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">   
            <label for="imageSelect" class="custom-file-label"> Select Image</label>
                <!-- for= and also id= of input need to be equal -->
           </div>
           </div>   

            <div class="form-group">
                <label for="Post"> <span class="Fieldinfo"> Post</span></label>
                <textarea class="form-control" name="PostDescription" id="" cols="80" rows="5">
                <?php echo $PostToBeUpdated; ?>
                </textarea>
            </div>


              <div class="row">
                <div class="col-lg-6 mb-2">
                  <a class="btn btn-warning btn-block " href="dashboard.php"><i class="fas fa-arrow-left"></i>Back To Dashboard</a>
                </div>
                <div class="col-lg-6 mb-2">
                  <button class="btn btn-success btn-block" type="submit" name="Submit"><i class="fas fa-check"></i>Update</button>
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
