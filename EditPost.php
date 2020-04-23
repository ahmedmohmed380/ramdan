<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$SarchQueryParameter = $_GET['id'];
if(isset($_POST["Submit"])){
  $PostTitle = $_POST["PostTitle"];
  $Category = $_POST["Category"];
  $Image = $_FILES["Image"]["name"];
  $PostText = $_POST["PostDescription"];
  $Target = "Uploads/".basename($_FILES["Image"]["name"]);
  $Admin = "Ahmed";
  date_default_timezone_set("Asia/Riyadh");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);


  if(empty($PostTitle)){
    $_SESSION["ErrorMessage"]= "يجب ملء جميع الحقول";
    Redirect_to("Posts.php");
  }elseif (strlen($PostTitle)<2) {
    $_SESSION["ErrorMessage"]= "يجب أن يكون عنوان المقال أكثر من حرفين";
    Redirect_to("ِPosts.php");
  }elseif (strlen($PostTitle)>1999) {
    $_SESSION["ErrorMessage"]= "يجب أن يكون المقال أقل من 2000 حرف";
    Redirect_to("Posts.php");
}else {
  //Query to Update Post in DB when everything is fine
  global $ConnectingDB;
  if (!empty($_FILES["Image"]["name"])) {
    $sql = "UPDATE posts
         SET title='$PostTitle', category='$Category', image='$Image', post='$PostText'
         WHERE id='$SarchQueryParameter'";
  }else {
    $sql = "UPDATE posts
         SET title='$PostTitle', category='$Category', post='$PostText'
         WHERE id='$SarchQueryParameter'";
  }

       $Execute =$ConnectingDB->query($sql);
  move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
  if($Execute){
    $_SESSION["SuccessMessage"]="تم التعديل بنجاح";
    Redirect_to("Posts.php");
  }else {
    $_SESSION["ErrorMessage"]="لم يتم التعديل , حاول مرة أخرى";
    Redirect_to("Posts.php");
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
    <title>تعديل الم</title>
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
    <h1><i class="fas fa-edit" style="color:#27aae1;"></i>تعديل المقال</h1>
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
      //Fetching Existing Content according to our
      global $ConnectingDB;
      $sql = "SELECT * FROM posts WHERE id='$SarchQueryParameter'";
      $stmt = $ConnectingDB->query($sql);
      while ($DataRows=$stmt->fetch()) {
        $TitleToBeUpdated = $DataRows['title'];
        $CategoryToBeUpdated = $DataRows['category'];
        $ImageToBeUpdated = $DataRows['image'];
        $PostToBeUpdated = $DataRows['post'];
      }




       ?>
      <form class="" action="EditPost.php?id=<?php echo $SarchQueryParameter; ?>" method="post" enctype="multipart/form-data">
        <div class="card bg-secondary text-light mb-3">

           <div class="card-body bg-dark">
             <div class="form-group">
               <label for="title"><span class="FieldInfo">عنوان المقال: </span></label>
               <input class="form-control" type="text" name="PostTitle" id="title" placeholder="إكتب العنوان" value="<?php echo $TitleToBeUpdated; ?>"></input>
             </div>
             <div class="form-group">
               <span class="FieldInfo"> التصنيف الحالي :</span>
               <?php echo $CategoryToBeUpdated; ?>
               <br>
               <label for="CategoryTitle"><span class="FieldInfo"> اختر التصنيف الجديد : </span></label>
               <select class="form-control" id="CategoryTitle" name="Category">
                 <?php
                 //Fetching all the categories from category table
                     global $ConnectingDB;
                     $sql = "SELECT id,title FROM category";
                     $stmt = $ConnectingDB->query($sql);
                     while ($DateRows = $stmt->fetch()) {
                       $Id = $DateRows["id"];
                       $CategoryName = $DateRows["title"];
                      ?>

                      <option> <?php echo $CategoryName; ?></option>
                  <?php  }  ?>

             </select>
             </div>
             <div class="form-group mb-1">
               <span class="FieldInfo"> الصورة الحالية :</span>
               <img class="mb-1" src="Uplodas/<?php echo $ImageToBeUpdated; ?>" width="170px"; height="70px"; >
               <label for="imageSelect"> <span class="FieldInfo"></span></label>
                 <div class="custom-file">
                   <input class="custom-file-input" type="File" name="Image" id="imageSelect"value="">
                   <label for="imageSelect" class="custom-file-label">قم بتحديد الصورة</label>
                 </div>
           </div>
           <div class="form-group">
             <label for="Post"><span class="FieldInfo">المقال :</span></label>
             <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80">
               <?php echo $PostToBeUpdated; ?>
             </textarea>
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
