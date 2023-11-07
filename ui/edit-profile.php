<?php
session_start();
if(empty($_SESSION['admin'])){
  header('location:login.php');
}else{
    require_once('header.php');
    require_once('navbar.php');
    require_once("../database.php");
    $prof_pic = $fname = $sname = $username = $password = $email = $rpassword = "";
    $_SESSION['message'] = '';
    $adminEmail = $_SESSION['adminEmail'];
    $query = "SELECT * FROM `users` WHERE email = '$adminEmail'";
    $result = $conn->query($query);
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      $fname = $row['fname'];
      $sname = $row['sname'];
      $username = $row['username'];
      $password2 = $row['password'];
      $email = $row['email'];
      $prof_pic = $row['prof_pic'];
}

    $profileErr = $fnameErr = $snameErr = $usernameErr = $passwordErr = $emailErr =  $rpasswordErr = "";
        
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["fname"])) {
          $fnameErr = "Name is required";
        } else {
          $fname = test_input($_POST["fname"]);
          
          if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
            $fnameErr = "Only letters and white space allowed";
          }
        }
        
        $sname = $_POST["sname"];
        $username = $_POST["username"];

          if($_POST["password"] != $_POST["rpassword"]){
              $passwordErr = "Two Passwords Does Not Match";
          }else{
              $password = $_POST["password"];
              if($password != $password2){
                $passwordErr = "Invalid Password!";
              }
          }
      
        if (empty($_POST["email"])) {
          $emailErr = "Email is required";
        } else {
          $email = test_input($_POST["email"]);
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
          }
        }
      
    $prof_pic = $conn->real_escape_string('images/'.$_FILES['profile']['name']);
        if(preg_match("!image!", $_FILES['profile']['type'])){
          if($_FILES['profile']['size'] > 200000){
            if(move_uploaded_file($_FILES['profile']['tmp_name'], $prof_pic)){
              if(empty($profileErr) && empty($fnameErr) && empty($snameErr) && empty($emailErr) && empty($passwordErr) && empty($usernameErr)){
                $query = "UPDATE `users` SET `prof_pic`='$prof_pic',`fname`='$fname',`sname`='$sname',`username`='$username',`email`='$email',`password`='$password' WHERE email = '$adminEmail'"; 
                $result = $conn->query($query);
                  if($result){
                    $_SESSION["message"] = "Updated Successfully.";
                  }else{
                    $_SESSION["message"] = "Unable to Update!";
                  }
              }
        }else{
          $profileErr = "Unable to Copy Image!";
        }
      }else{
        $profileErr = "Image Size is too Large";
      }
      }else{
        $profileErr = "Invalid Image Type!";
    }
  }
  }
?>

<form action="edit-profile.php" method="post" enctype="multipart/form-data">

<div  class="prof-container w3-display-container w3-blue" style="height:500px;">
<center><div><h2 class="w3-text-white">Register</h2></div></center>
<div class="w3-text-blue w3-white" style="margin-bottom:20px;margin-top:10px; height:330px; width:100%;">
<center><span class="w3-red w3-text-white" id="error"><?= $_SESSION['message'] ?></span></center>
    <div class="card w3-padding w3-text-blue w3-display-left w3-white">
        <h5 class="r-text">First Name</h5>
        <p class="error w3-text-red"><?= $fnameErr?></p>
        <input class="w3-input w3-border" name="fname" type="text" value="<?= $fname ?>" placeholder="First Name" required>
        <h5 class="r-text">Username</h5>
        <p class="error w3-text-red"><?= $usernameErr?></p>
        <input class="w3-input w3-border" name="username" type="text" value="<?= $username ?>" placeholder="Username" required>
        <h5 class="r-text">Password</h5>
        <p class="error w3-text-red"><?= $passwordErr?></p>
        <input class="w3-input w3-border" name="password" type="password" placeholder="Password" required><br>
    </div> 
    
    <div class="card w3-padding w3-text-blue w3-display-right w3-white">
        <h5 class="r-text">Second Name</h5>
        <p class="error w3-text-red"><?= $snameErr?></p>
        <input class="w3-input w3-border" name="sname" type="text" value="<?= $sname ?>" placeholder="Second Name" required>
        <h5 class="r-text">Email Address</h5>
        <p class="error w3-text-red"><?= $emailErr?></p>
        <input class="w3-input w3-border" name="email" type="text" value="<?= $email ?>" placeholder="Email" required>
        <h5 class="r-text">Re-Type Password</h5>
        <p class="error w3-text-red"><?= $passwordErr?></p>
        <input class="w3-input w3-border" name="rpassword" type="password" placeholder="Re-Type Password" required>
    </div> 
</div>
 <center><input type="submit" class="btn w3-button w3-red" value="Save"></center>
 <p class="error w3-text-red"><?= $profileErr?></p>
 Select Picture <input class="input" name="profile" type="file">
</div>
</form>

<?php require_once("footer.php") ?>