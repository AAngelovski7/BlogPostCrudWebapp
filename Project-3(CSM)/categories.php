<?php 
require_once('includes/DB.php');
require_once('includes/functions.php');
require_once('includes/sessions.php');
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];

Confrim_Login();


if(isset($_POST['Submit'])){
  $Category = $_POST['CategoryTitle'];
  $Admin = $_SESSION['Username'];
  date_default_timezone_set('Europe/Skopje');
  $CurrentTime = time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($Category)){
    $_SESSION["ErrorMessage"]="All fields must be filled out"; //if this super globas variable
    Redirect_to("categories.php");
  }elseif(strlen($Category) <3 ){
    $_SESSION["ErrorMessage"]="Category Title should be greater than 3 characters";
    Redirect_to("categories.php");
  }elseif(strlen($Category) > 49 ){
    $_SESSION["ErrorMessage"]="Category Title should be less than 50 characters";
    Redirect_to("categories.php");
  }else{
    //Query to insert category in DB 
    $sql = "INSERT INTO category(title, author, datetime) VALUES(:categoryName, :adminName, :dateTime)";// pass by PDO using dummy names
    $stmt = $ConnectingDB -> prepare($sql); //-> mean PDO object notation

    //binding values      dummy name     , actual value
    $stmt -> bindValue (":categoryName",$Category);
    $stmt -> bindValue (":adminName",$Admin);
    $stmt -> bindValue (":dateTime",$DateTime);

    $Execute = $stmt->execute();

    if($Execute){
      $_SESSION["SuccesMessage"]="Category Added Succesfully";
      Redirect_to("categories.php"); //if inserted data redirect to this page
    }else{
      $_SESSION["ErrorMessage"]="Something went wrong. Try Again !";
      Redirect_to("categories.php");
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
    <h1> <i class="fas fa-edit"style="color:#27aae1"></i>  Manage Categories</h1>
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

      <form class="" action="categories.php" method="POST">
             <div class="card bg-secondary text-light mb-3">
            <div class="card-header">
              <h1>Add new Category</h1>
            </div>
            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="title"> <span class="Fieldinfo">Category Title</span></label> <br>
                <input class="form-control" type="text" name="CategoryTitle" id="title" value="" placeholder="Type Title here">
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

      <h2>Existing Categories</h2>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Category Name</th>
                    <th>Date&Time</th>
                    <th>Creator Name</th>
                    <th>Action</th>
                  </tr>
            </thead>
       
        
            <?php 
                $sql = "SELECT * FROM category ORDER BY id desc";
                $Execute = $ConnectingDB->query($sql);
                $SrNo = 0;

                while($DataRows=$Execute->fetch()){
                    $CategoryId=$DataRows['id'];
                    $CategoryDate = $DataRows['datetime'];
                    $CategoryName = $DataRows['title'];
                    $CreatorName = $DataRows['author'];
                    $SrNo++;
                   
            ?>
                <tbody>
                    <tr>
                    <td><?php echo $SrNo; ?></td>
                    <td><?php echo htmlentities($CategoryDate) ; ?></td>
                    <td><?php echo htmlentities( $CategoryName); ?></td>
                    <td  ><?php echo htmlentities($CreatorName); ?></td>
                    <td><a class="btn btn-danger" href="deleteCategory.php?id=<?php echo $CategoryId; ?>">Delete</a></td>
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
