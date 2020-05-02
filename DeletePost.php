<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php Confirm_Login(); ?>

<?php
$SearchQueryParameter = $_GET['id'];
//Fetching Existing Content according to our
global $ConnectingDB;
$sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows=$stmt->fetch()) {
  $TitleToBeDeleted = $DataRows['title'];
  $CategoryToBeDeleted = $DataRows['category'];
  $ImageToBeDeleted = $DataRows['image'];
  $PostToBeDeleted = $DataRows['post'];
}
//echo $ImageToBeUpdated;
if(isset($_POST["Submit"])){



  //Query to delet Post in DB when everything is fine
  global $ConnectingDB;
  $sql = "DELETE FROM posts WHERE id='$SearchQueryParameter'";
       $Execute =$ConnectingDB->query($sql);
  if($Execute){
    $Target_Path_To_DELETE_Image = "Uploads/$ImageToBeDeleted";
    unlink($Target_Path_To_DELETE_Image);
    $_SESSION["SuccessMessage"]="تم الحذف بنجاح";
    Redirect_to("Posts.php");
  }else {
    $_SESSION["ErrorMessage"]="لم يتم الحذف";
    Redirect_to("Posts.php");
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
    <title>حذف المقال</title>
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
    <h1><i class="fas fa-edit" style="color:#27aae1;"></i>حذف المقال</h1>
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
      <form class="" action="DeletePost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
        <div class="card bg-secondary text-light mb-3">

           <div class="card-body bg-dark">
             <div class="form-group">
               <label for="title"><span class="FieldInfo">عنوان المقال: </span></label>
               <input disabled class="form-control" type="text" name="PostTitle" id="title" placeholder="إكتب العنوان" value="<?php echo $TitleToBeDeleted; ?>"></input>
             </div>
             <div class="form-group">
               <span class="FieldInfo"> التصنيف الحالي :</span>
               <?php echo $CategoryToBeDeleted; ?>
               <br>

             </div>
             <div class="form-group">
               <span class="FieldInfo"> الصورة الحالية :</span>
               <img class="mb-1" src="Uploads/<?php echo $ImageToBeDeleted; ?>" width="170px"; height="70px"; >
               <label for="imageSelect"><span class="FieldInfo"></span></label>

           </div>
           <div class="form-group">
             <label for="Post"><span class="FieldInfo">المقال :</span></label>
             <textarea disabled class="form-control" id="Post" name="PostDescription" rows="8" cols="80">
               <?php echo $PostToBeDeleted; ?>
             </textarea>
         </div>
             <div class="row">
               <div class="col-lg-6 mb-2">
                 <a href="Dashbord.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>العودة للصفحة الرئسية</a>
               </div>
               <div class="col-lg-6 mb-2">
                 <button type="submit" name="Submit" class="btn btn-danger btn-block">
                   <i class="fas fa-trash"></i>حذف
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
