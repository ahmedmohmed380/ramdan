<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>

<!DOCTYPE html>
<html lang="ar">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link rel="stylesheet" href="Css/styles.css">
    <title>المدونة</title>
  </head>
  <body>
    <div align=right dir=rtl>
<!-- NAVBAR -->
<div style="height:10px; background:#27aae1;"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
  <a class="navbar-brand ml-auto" href="#"> AhmedZakan.com</a>
  <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
    <span class="navbar-toggler-icon"></span>
  </button>
    <div class="collapse navbar-collapse" id="navbarcollapseCMS">
    <ul class="navbar-nav ml-auto">


      <li class="nav-item">
        <a class="nav-link" href="Biog.php">الصفحة الرئيسية</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">من نحن</a>
        <li class="nav-item">
          <a class="nav-link" href="Blog.php">المدونة</a>
        </li>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">إتصل بنا</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">الخصائص</a>
                </ul>
            <ul class="navbar-nav ml-auto">
              <form class="form-inline d-none d-sm-block" action="Blog.php">
                <div class="form-group">
                  <input class="form-control ml-2" type="text" name="Search"  placeholder="البحث"value="">
                  <button class="btn btn-primary" name="SearchButton">هنا</button>
                </div>
              </form>
            </ul>
          </div>
      </div>
</nav>
<div style="height:10px; background:#27aae1;"></div>

<!-- NAVBAR END -->
<!-- Header -->
<div class="container">
  <div class="row mt-4">


    <!-- Main Area Start-->
    <div class="col-sm-8 ">
      <h1>The Complete Responsive Ahmed Blog</h1>
      <h1 class="lead">The Complete blog by using PHP by Ahmed Zakan</h1>
         <?php
         global $ConnectingDB;
         if(isset($_GET["SearchButton"])){
           $Search = $_GET["Search"];
           $sql = "SELECT * FROM posts
          WHERE datetime LIKE :search
          OR title LIKE :search
          OR category LIKE :search
          OR post LIKE :search";
          $stmt = $ConnectingDB->prepare($sql);
          $stmt->bindValue(':search','%'.$Search.'%');
          $stmt->execute();

         }

         // The defult SQL qurey
          else{
            $PostIdFromURL = $_GET["id"];
            if (!isset($PostIdFromURL)) {
              $_SESSION["ErrorMessage"]="لا توجد الصفحة !";
              Redirect_to("Blog.php");
            }
            $sql = "SELECT * FROM posts WHERE id= '$PostIdFromURL'";
            $stmt = $ConnectingDB->query($sql);
            }
          while ($DataRows = $stmt->fetch()) {
          $PostId = $DataRows["id"];
          $DateTime = $DataRows["datetime"];
          $PostTitle = $DataRows["title"];
          $Category = $DataRows["category"];
          $Admin = $DataRows["author"];
          $Image = $DataRows["image"];
          $PostDescription = $DataRows["post"];

            ?>
          <div class="card">
            <img src="Uploads/<?php echo ($Image); ?>" style="max-height:450px;" class="img-fluid card-img-top" />
            <div class="card-body">
              <h4 class="card-title"><?php echo ($PostTitle); ?></h4>
              <small class="text-muted">كتب من قبل <?php echo ($Admin); ?>في <?php echo ($DateTime); ?></small>
              <span style="float:left;" class="badge badge-dark text-light">التعليقات</span>
              <hr>
              <p class="card-text"><?php echo ($PostDescription); ?></p>


            </div>
          </div>
<?php } ?>
    </div>
    <!-- Main Area End-->





    <!-- Side Area Start-->

    <div class="col-sm-4" style="min-height:40px; background:green;">

    </div>
    <!-- side Area End-->

  </div>
</div>
<!-- FOOTER -->
<footer class="bg-dark text-white">
  <div class="container">
<div class="row">
  <div class="col">
  <p class="lead text-center">Them By | Ahmed Zakan | <span id="yaer"></span>  جميع الحقوق محفوظة---&copy;</p>
</div>
</div>
  </div>
</footer>
<div style="height:10px; background:#27aae1;"></div>



    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
$('#year').text(new Date().getFullYear());
</script>
</div>
  </body>
</html>
