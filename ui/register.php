<?php
session_start();
if(!empty($_SESSION['admin'])){
  header('location:index.php');
}else{
    require_once('header.php');
    require_once("../database.php");
    $_SESSION['message'] = '';

    $fnameErr = $snameErr = $usernameErr = $passwordErr = $emailErr =  $rpasswordErr = "";
    $fname = $sname = $username = $password = $email = $rpassword = "";
    
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
          }
      
        if (empty($_POST["email"])) {
          $emailErr = "Email is required";
        } else {
          $email = test_input($_POST["email"]);
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
          }
        }
       
    
    
    if(empty($fnameErr) && empty($snameErr) && empty($emailErr) && empty($passwordErr) && empty($usernameErr)){
    $check = "select * from users where email = '$email'";
    $check = $conn->query($check);
    if ($check->num_rows > 0 ) {
        $_SESSION['message'] = "Email has Being Taken by Another User";
    }else{
     $query = "insert into users(fname,sname,username,password,email) values('$fname','$sname','$username','$password','$email')";
    $result = $conn->query($query);
        if($result){
           header('location:login.php');
        }
    }
}else{
    $_SESSION['message'] = "Unable to Register!";
}
}
}
?>

<form action="register.php" method="post" enctype="multipart/form-data">
<div  class="container w3-display-container w3-blue" style="height:470px;">
<center><div><h2 class="w3-text-white">Register</h2></div></center>
<div class="w3-text-blue w3-white" style="margin-bottom:20px;margin-top:10px; height:300px; width:100%;">
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
<center><input type="submit" class="btn w3-button w3-red" value="Register"></center>
<p style="margin-top:0px" >Already Have an Account? <a href="login.php">Login Here</a></p>
</div>
</form>

<?php require_once("footer.php") ?>