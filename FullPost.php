<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $SearchQueryParameter = $_GET["id"]; ?>
<?php
if(isset($_POST["Submit"])){
  $Name    = $_POST["CommenterName"];
  $Email   = $_POST["CommenterEmail"];
  $Comment = $_POST["CommenterThoughts"];
  date_default_timezone_set("Asia/Karachi");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($Name)||empty($Email)||empty($Comment)){
    $_SESSION["ErrorMessage"]= "يجب ملئ جميع الخانات";
    Redirect_to("FullPost.php?id={$SearchQueryParameter}");
  }elseif (strlen($Comment)>500) {
    $_SESSION["ErrorMessage"]= "التعليق أكثر من 500 حرف";
    Redirect_to("FullPost.php?id={$SearchQueryParameter}");
  }else{
    // Query to insert comment in DB When everything is fine
    global $ConnectingDB;
    $sql  = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
    $sql .= "VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromURL)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt -> bindValue(':dateTime',$DateTime);
    $stmt -> bindValue(':name',$Name);
    $stmt -> bindValue(':email',$Email);
    $stmt -> bindValue(':comment',$Comment);
    $stmt -> bindValue(':postIdFromURL',$SearchQueryParameter);
    $Execute = $stmt -> execute();
    //var_dump($Execute);
    if($Execute){
      $_SESSION["SuccessMessage"]="تم إضافة التعليق بنجاح";
      Redirect_to("FullPost.php?id={$SearchQueryParameter}");
    }else {
      $_SESSION["ErrorMessage"]="لم تتم إضافة التعليق , حاول مرة أخرى";
      Redirect_to("FullPost.php?id={$SearchQueryParameter}");
    }
  }
} //Ending of Submit Button If-Condition
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
      echo ErrorMessage();
      echo SuccessMessage();
       ?>
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
              <small class="text-muted">التصنيف:<span class="text-dark"> <a href="Blog.php?category=<?php echo$Category; ?>"> <?php echo $Category; ?> </a></span>كتب من قبل <?php echo $Admin; ?>في <?php echo $DateTime; ?></small>
              <span style="float:left;" class="badge badge-dark text-light">التعليقات
                 <?php  echo ApproveCommentsAccordingtoPost($PostId); ?>
              </span>
              <hr>
              <p class="card-text"><?php echo ($PostDescription); ?></p>


            </div>
          </div>
          <br>
<?php } ?>

<!-- Comment Part Start -->
<!-- fetching existing comment Start -->
<span class="FieldnInfo">التعليقات</span>
<br></br>
<?php
global $ConnectingDB;
$sql ="SELECT * FROM comments
 WHERE post_id='$SearchQueryParameter' AND status='on'";
$stmt =$ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
  $CommentDate = $DataRows['datetime'];
  $CommenterName = $DataRows['name'];
  $CommentContent =$DataRows['comment'];

 ?>

 <div>
   <div class="media CommentBlock">
     <img class="d-block img-fluid align-self-Start" src="images/images.png" alt="">
     <div class="media-body ml-2">
       <h6 class="lead"><?php echo $CommenterName; ?></h6>
       <p class="small"><?php echo $CommentDate; ?></p>
       <p><?php echo $CommentContent; ?></p>
     </div>
   </div>
 </div>
 <br>
<?php } ?>
<div class="">
  <form class="" action="FullPost.php?id=<?php echo $SearchQueryParameter ?>" method="post">
    <div class="card mb-3">
  <div class="card-header">
      <h5 class="FieldInfo">شارك افكارك حول هذا المنشور</h5>
    </div>
    <div class="card-body">
     <div class="form-group">
       <div class="input-group">
         <div class="input-group-prepend">
           <span class="input-group-text"><i class="fas fa-user"></i></span>
         </div>

       <input class="form-control" type="text" name="CommenterName" placeholder="إسمك" value="">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
              </div>

            <input class="form-control" type="email" name="CommenterEmail" placeholder="الإيميل" value="">
                 </div>
               </div>
               <div class="form-group">
                 <textarea name="CommenterThoughts" class="form-control" rows="6" cols="80"></textarea>
               </div>
               <div class="">
                 <button type="submit" name="Submit" class="btn btn-primary">إرسال</button>
               </div>
     </div>
    </div>
  </form>
</div>
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
