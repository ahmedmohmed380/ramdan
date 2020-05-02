<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
if (isset($_POST["Submit"])) {
  $UserName = $_POST["Username"];
  $Password = $_POST["Password"];
  if (empty($UserName)||empty($Password)) {
    $_SESSION["ErrorMessage"]= "الرجاء تعبئة جميع الخانات";
    Redirect_to("Login.php");
  }else {
   $Found_Account=Login_Attempt($UserName,$Password);
    if ($Found_Account) {
      $_SESSION["UserId"]=$Found_Account["id"];
      $_SESSION["UserName"]=$Found_Account["username"];
      $_SESSION["AdminName"]=$Found_Account["aname"];
      $_SESSION["SuccessMessage"]="هلا بك يا ".$_SESSION["AdminName"];
      if( isset($_SESSION["TrackingURL"])) {
        Redirect_to($_SESSION["TrackingURL"]);
      }else{
      Redirect_to("Dashboard.php");
    }
    }else {
      $_SESSION["ErrorMessage"]="خطأ في اسم المستخدم أو كلمة المرور";
      Redirect_to("Login.php");
    }
  }
}


 ?>
<!DOCTYPE html>
<html lang="ar">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link rel="stylesheet" href="Css/styles.css">
    <title>تسجيل الدخول</title>
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


          </div>
      </div>
</nav>
<div style="height:10px; background:#27aae1;"></div>

<!-- NAVBAR END -->
<!-- HEADER  -->
<header class="bg-dark text-white py-3">
<div class="container">
<div class="row">
  <div class="col-md-12">
</div>
</div>
</div>
</header>
<!-- Hedar End-->
<!--Main Area Start -->
<section class="container py-2 mb-4">
  <div class="offset-sm-3 col-sm-6" style="min-height:500px;">
    <br><br><br>
    <?php
    echo ErrorMessage();
    echo SuccessMessage();
     ?>
    <div class="card bg-secondary text-light">
      <div class="card-header">
        <h4>أهلا بك</h4>
      </div>

        <div class="card-body bg-dark">
        <form class="" action="Login.php" method="post">
          <div class="form-group">
            <label for="username"><span class="fieldInfo">إسم المستخدم:</span></label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text text-white bg-info"> <i class="fas fa-user"></i></span>
              </div>
              <input type="text" class="form-control" name="Username" id="username" value="">
            </div>
          </div>
          <div class="form-group">
            <label for="password"><span class="fieldInfo">كلمة المرور:</span></label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text text-white bg-info"> <i class="fas fa-lock"></i></span>
              </div>
              <input type="password" class="form-control" name="Password" id="password" value="">
            </div>
          </div>
          <input type="submit" name="Submit" class="btn btn-info btn-block" value="تسجيل الدخول">
        </form>
      </div>
    </div>
  </div>
</section>
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
