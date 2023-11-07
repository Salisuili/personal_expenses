<?php
session_start();
if(empty($_SESSION['admin'])){
  header('location:login.php');
}else{
    require_once('header.php');
    require_once('navbar.php');
    require_once("../database.php");
    $fname = $sname = $username = $password = $email = $rpassword = "";
    $_SESSION['message'] = '';
    $adminEmail = $_SESSION['adminEmail'];
    $query = "SELECT * FROM `users` WHERE email = '$adminEmail'";
    $result = $conn->query($query);
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      $fname = $row['fname'];
      $sname = $row['sname'];
      $username = $row['username'];
      $password = $row['password'];
      $email = $row['email'];
      $prof_pic = $row['prof_pic'];
}
}
 ?>

<div class="w3-blue" style="width:70%; padding-top:5px; margin-left:15%; margin-top:3%;">
        <h3 style="margin-left:10px;"><img class="w3-circle" src="<?= $prof_pic ?>" alt="pic" style="width:60px; height:60px;"> Profile Details</h3>
        <div class="w3-container w3-text-blue w3-padding w3-white">
            <h4>First Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= ucfirst($fname) ?></h4>
            <h4>Second Name: &nbsp;&nbsp;&nbsp;&nbsp;<?= ucfirst($sname) ?></h4>
            <h4>User Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= ucfirst($username) ?></h4>
            <h4>Email Address: &nbsp;&nbsp;&nbsp;&nbsp;<?= $email ?></h4>
            <h4>Password: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;********</h4>
            <a href="edit-profile.php"><center><input type="submit" name="submit" class="btn w3-button w3-red" value="Edit Profile"></center></a>
        </div>
    </div>

<?php require_once("footer.php") ?>