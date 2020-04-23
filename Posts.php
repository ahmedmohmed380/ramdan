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
    <title>المقلات</title>
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
    <h1><i class="fas fa-blog" style="color:#27aae1;"></i>المقالات</h1>
</div>
<div class="col-lg-3 mb-2">
  <a href="AddNewPost.php" class="btn btn-primary btn-block">
   <i class="fas fa-edit"></i> أضف مقال جديد
  </a>
</div>
<div class="col-lg-3 mb-2">
  <a href="Categories.php" class="btn btn-info btn-block">
   <i class="fas fa-folder-plus"></i>أضف تصنيف جديد
  </a>
</div>
<div class="col-lg-3 mb-2">
  <a href="Admins.php" class="btn btn-warning btn-block">
   <i class="fas fa-user-plus"></i>أضف مستخدم جديد
  </a>
</div>
<div class="col-lg-3 mb-2">
  <a href="Comments.php" class="btn btn-success btn-block">
   <i class="fas fa-check"></i> الموافقة على التعليقات
  </a>
</div>
</div>
</div>
</header>

<!-- Main Area -->
<section class="container py-2 mb-4">
  <div class="row">
    <div class="col-lg-12">
      <?php
      echo ErrorMessage();
      echo SuccessMessage();

       ?>
      <table class="table table-striped table-hover">
        <thead class="thead-dark">
      <tr>
        <th>#</th>
        <th>العنوان</th>
        <th>التصنيف</th>
        <th>الوقت</th>
        <th>المستخدم</th>
        <th>الصورة</th>
        <th>التعليقات</th>
        <th>التحرير</th>
        <th>معاينة</th>
      </tr>
    </thead>
      <?php
           global $ConnectingDB;
           $sql = "SELECT * FROM posts";
           $stmt = $ConnectingDB->query($sql);
           $Sr = 0;
           while ($DataRows = $stmt->fetch()) {
             $Id = $DataRows["id"];
             $DateTime = $DataRows["datetime"];
             $PostTitle = $DataRows["title"];
             $Category = $DataRows["category"];
             $Admin = $DataRows["author"];
             $Image = $DataRows["image"];
             $PostText = $DataRows["post"];
             $Sr++;
       ?>
       <tbody>
       <tr>
         <td><?php echo $Sr; ?></td>
         <td>
           <?php
             if (strlen($PostTitle)>20){$PostTitle= substr($PostTitle,0,18).'..';}
            echo $PostTitle;
            ?>
          </td>
         <td>
           <?php
           if (strlen($Category)>10){$Category= substr($Category,0,10).'..';}
            echo $Category;
             ?>
           </td>
         <td>
           <?php
           if (strlen($DateTime)>11){$DateTime= substr($DateTime,0,11).'..';}
            echo $DateTime;
             ?>
           </td>
         <td>
           <?php
           if (strlen($Admin)>8){$Admin= substr($Admin,0,8).'..';}
            echo $Admin;
            ?>
          </td>
         <td><img src="Uploads/<?php echo $Image; ?>" width="170px;" height="50px;"</td>
         <td>التعليقات</td>
         <td>
           <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">التعديل</span></a>
           <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">الحذف</span></a>
         </td>
         <td><a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">المعاينة</span></a></td>
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
