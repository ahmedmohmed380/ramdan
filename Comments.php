<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
 Confirm_Login(); ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link rel="stylesheet" href="Css/styles.css">
    <title>التعليقات</title>
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
    <h1><i class="fas fa-comments" style="color:#27aae1;"></i>إدارة التعليقات</h1>
</div>
</div>
</div>
</header>
<!-- Main Area Start -->
<section class="container py-2 mb-4">
  <div class="row" style="min-height:30px;">
    <div class="col-lg-12" style="min-height:400px;">
      <?php
       echo ErrorMessage();
       echo SuccessMessage();
       ?>
      <h2>تعليقات غير معتمدة</h2>
      <table class="table table-stri-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>الرقم</th>
            <th>الوقت</th>
            <th>الأسم</th>
            <th>التعليق</th>
            <th>إضافة</th>
            <th>حذف</th>
            <th>معاينة</th>
          </tr>
        </thead>
      <?php
       global $ConnectingDB;
       $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
       $Execute =$ConnectingDB->query($sql);
       $SrNo = 0;
       while ($DateRows=$Execute->fetch()) {
         $CommentId = $DateRows["id"];
         $DateTimeOfComment = $DateRows["datetime"];
         $CommenterName = $DateRows["name"];
         $CommentContent = $DateRows["comment"];
         $CommentPostId = $DateRows["post_id"];
         $SrNo++;
             ?>
       <tbody>
         <tr>
           <td><?php echo $SrNo; ?></td>
            <td><?php echo $DateTimeOfComment; ?></td>
           <td><?php echo $CommenterName; ?></td>
           <td><?php echo $CommentContent; ?></td>
           <td><a href="ApproveComments.php?id=<?php echo $CommentId;?>" class="btn btn-success">إضافة</a></td>
           <td><a href="DeleteComments.php?id=<?php echo $CommentId;?>" class="btn btn-danger">حذف</a></td>
           <td><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">إستعراض</a></td>
         </tr>
       </tbody>
       <?php } ?>
         </table>
         <h2>التعليقات المعتمدة</h2>
         <table class="table table-stri-striped table-hover">
           <thead class="thead-dark">
             <tr>
               <th>الرقم</th>
               <th>الوقت</th>
               <th>الأسم</th>
               <th>التعليق</th>
               <th>إخفاء التعليق</th>
               <th>حذف</th>
               <th>معاينة</th>
             </tr>
           </thead>
         <?php
          global $ConnectingDB;
          $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
          $Execute =$ConnectingDB->query($sql);
          $SrNo = 0;
          while ($DateRows=$Execute->fetch()) {
            $CommentId = $DateRows["id"];
            $DateTimeOfComment = $DateRows["datetime"];
            $CommenterName = $DateRows["name"];
            $CommentContent = $DateRows["comment"];
            $CommentPostId = $DateRows["post_id"];
            $SrNo++;
                ?>
          <tbody>
            <tr>
              <td><?php echo $SrNo; ?></td>
               <td><?php echo $DateTimeOfComment; ?></td>
              <td><?php echo $CommenterName; ?></td>
              <td><?php echo $CommentContent; ?></td>
              <td><a href="DisApproveComments.php?id=<?php echo $CommentId;?>" style="min-width:100px;" class="btn btn-warning">إخفاء</a></td>
              <td><a href="DeleteComments.php?id=<?php echo $CommentId;?>" class="btn btn-danger">حذف</a></td>
              <td><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">إستعراض</a></td>
            </tr>
          </tbody>
          <?php } ?>
            </table>
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
