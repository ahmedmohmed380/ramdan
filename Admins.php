<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];

 Confirm_Login(); ?>


<?php
if(isset($_POST["Submit"])){
  $UserName = $_POST["Username"];
  $Name = $_POST["Name"];
  $Password = $_POST["Password"];
  $ConfirmPassword = $_POST["ConfirmPassword"];
  $Admin = $_SESSION["UserName"];
  date_default_timezone_set("Asia/Riyadh");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);


  if(empty($UserName)||empty($Password)||empty($ConfirmPassword)){
    $_SESSION["ErrorMessage"]= "يجب تعبئة جميع الخانات";
    Redirect_to("Admins.php");
  }elseif (strlen($Password)<4) {
    $_SESSION["ErrorMessage"]= "كلمة المرور يجب أن تكون أكثر من ثلاث خانات";
    Redirect_to("Admins.php");
  }elseif ($Password !== $ConfirmPassword) {
    $_SESSION["ErrorMessage"]= "تأكيد كلمة المرور وكلمة المرور غير متطابقتين";
    Redirect_to("Admins.php");
  }elseif (CheckUserNameExistsOrNot($UserName)) {
    $_SESSION["ErrorMessage"]= "إسم المستخدم موجود !";
    Redirect_to("Admins.php");
  }else{
  //Query to insert new admin in DB when everything is fine
  global $ConnectingDB;
  $sql = "INSERT INTO admins(datetime,username,password,aname,addedby)";
  $sql .= "VALUES(:dateTime,:userName,:password,:aName,:adminName)";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':dateTime',$DateTime);
  $stmt->bindValue(':userName',$UserName);
  $stmt->bindValue(':password',$Password);
  $stmt->bindValue(':aName',$Name);
  $stmt->bindValue(':adminName',$Admin);
  $Execute=$stmt->execute();
  if($Execute){
    $_SESSION["SuccessMessage"]="تم إضافة المستخدم ".$Name." ";
    Redirect_to("Admins.php");
  }else {
    $_SESSION["ErrorMessage"]="لم تتم الإضافة. حاول مرة أخرى";
    Redirect_to("Admins.php");
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
    <title>المشرفين</title>
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
    <h1><i class="fas fa-user" style="color:#27aae1;"></i>إدارةالمشرفين</h1>
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
      <form class="" action="Admins.php" method="post">
        <div class="card bg-secondary text-light mb-3">
           <div class="card-header">
             <h1>أضف مستخدم جديد</h1>
           </div>
           <div class="card-body bg-dark">
             <div class="form-group">
               <label for="username"><span class="FieldInfo">إسم المستخدم </span></label>
               <input class="form-control" type="text" name="Username" id="username"value=""></input>
             </div>
             <div class="form-group">
               <label for="Name"><span class="FieldInfo">الأسم </span></label>
               <input class="form-control" type="text" name="Name" id="Name"value=""></input>
               <small class="text-warning text-muted">إختياري</small>
             </div>
             <div class="form-group">
               <label for="Password"><span class="FieldInfo">كلمة المرور </span></label>
               <input class="form-control" type="Password" name="Password" id="Password"value=""></input>
             </div>
             <div class="form-group">
               <label for="ConfirmPassword"><span class="FieldInfo">تأكيد كلمة المرور </span></label>
               <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword" value=""></input>
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
      <h2>جميع المستخدمين</h2>
      <table class="table table-stri-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>الرقم</th>
            <th>الوقت</th>
            <th>إسم المستخدم</th>
            <th>الإسم</th>
            <th>أضيف من قبل</th>
            <th>حذف</th>
          </tr>
        </thead>
      <?php
       global $ConnectingDB;
       $sql = "SELECT * FROM admins ORDER BY id desc";
       $Execute =$ConnectingDB->query($sql);
       $SrNo = 0;
       while ($DateRows=$Execute->fetch()) {
         $AdminId = $DateRows["id"];
         $DateTime = $DateRows["datetime"];
         $AdminUsername = $DateRows["username"];
         $AdminName = $DateRows["aname"];
         $AddedBy = $DateRows["addedby"];
         $SrNo++;
             ?>
       <tbody>
         <tr>
           <td><?php echo $SrNo; ?></td>
            <td><?php echo $DateTime; ?></td>
           <td><?php echo $AdminUsername; ?></td>
           <td><?php echo $AdminName; ?></td>
           <td><?php echo $AddedBy; ?></td>
           <td><a href="DeleteAdmin.php?id=<?php echo $AdminId;?>" class="btn btn-danger">حذف</a></td>
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

</div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
$('#year').text(new Date().getFullYear());
</script>
  </body>
</html>
