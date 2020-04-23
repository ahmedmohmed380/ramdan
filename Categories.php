<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>


<?php
if(isset($_POST["Submit"])){
  $Category = $_POST["CategoryTitle"];
  $Admin = "Ahmed";
  date_default_timezone_set("Asia/Riyadh");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);


  if(empty($Category)){
    $_SESSION["ErrorMessage"]= "يجب ملء جميع الحقول";
    Redirect_to("Categories.php");
  }elseif (strlen($Category)<2) {
    $_SESSION["ErrorMessage"]= "يجب أن يكون عنوان التصنيف أكثر من حرفين";
    Redirect_to("Categories.php");
  }elseif (strlen($Category)>49) {
    $_SESSION["ErrorMessage"]= "يجب أن يكون العنوان أقل من 50 حرف";
    Redirect_to("Categories.php");
}else {
  //Query to insert category in DB when everything is fine
  global $ConnectingDB;
  $sql = "INSERT INTO category(title,author,datetime)";
  $sql .= "VALUES(:categoryName,:adminName,:dateTime)";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':categoryName',$Category);
  $stmt->bindValue(':adminName',$Admin);
  $stmt->bindValue(':dateTime',$DateTime);
  $Execute=$stmt->execute();
  if($Execute){
    $_SESSION["SuccessMessage"]="تم إضافة التصنيف بنجاح";
    Redirect_to("Categories.php");
  }else {
    $_SESSION["ErrorMessage"]="لم تتم الإضافة. حاول مرة أخرى";
    Redirect_to("Categories.php");
  }
}
}  //Ending of Submit Button if_Condition

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
    <title>التصنيفات</title>
  </head>
  <body>
<!-- NAVBAR -->
<div align=right dir=rtl>

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
        <a class="nav-link" href="MyProfile.php"><i class="fas fa-user text-success"></i>  الملف الشخصي</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="DashBoard.php">لوحة التحكم</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Posts.php">المقالات</a>
        <li class="nav-item">
          <a class="nav-link" href="Categories.php">التصنيفات</a>
        </li>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Admins.php">إدارة المستخدمين</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Comments.php">التعليقات</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Blog.php">المدونة</a>
      </li>
            </ul>
            <ul class="navbar-nav ml-auto">
              <li class="nav-item"><a href="Logout.php" class="nav-link text-danger"><i class="fas fa-user"></i>  تسجيل الخروج</a></li>
            </ul>
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
    <h1><i class="fas fa-edit" style="color:#27aae1;"></i>إدارة التصنيفات</h1>
</div>
</div>
</div>
</header>
<!-- HEADER END -->

<!-- Main Area -->
<section class="container py-2 mb-4">
  <div class="row">
    <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
      <?php
      echo ErrorMessage();
      echo SuccessMessage();




       ?>
      <form class="" action="Categories.php" method="post">
        <div class="card bg-secondary text-light mb-3">
           <div class="card-header">
             <h1>أضف تصنيف جديد</h1>
           </div>
           <div class="card-body bg-dark">
             <div class="form-group">
               <label for="title"><span class="FieldInfo">عنوان التصنيف: </span></label>
               <input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="إكتب العنوان" value=""></input>
             </div>
             <div class="row">
               <div class="col-lg-6 mb-2">
                 <a href="Dashbord.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>العودة للصفحة الرئسية</a>
               </div>
               <div class="col-lg-6 mb-2">
                 <button type="submit" name="Submit" class="btn btn-success btn-block">
                   <i class="fas fa-check"></i>إضافة
                 </button>
               </div>
           </div>
           </div>
        </div>
      </form>
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

</div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
$('#year').text(new Date().getFullYear());
</script>
  </body>
</html>
