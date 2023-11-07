<?php
session_start();
if(!empty($_SESSION['admin'])){
  header('location:index.php');
}else{
  require_once("header.php");
  require_once("../database.php");
  
  $_SESSION['message'] = '';

  if(!empty($_POST['username'])){
  $username = $_POST['username'];
  }
  if(!empty($_POST['password'])){
  $password = $_POST['password'];
  }

    $query = "select username, password, email from users where username = '$username' and password = '$password'";
    $result = $conn->query($query);
    if($result){
      if($result->num_rows > 0){
        $result = $result->fetch_assoc();
        $admin = $result['username'];
        $adminEmail = $result['email'];
        $_SESSION['adminEmail'] = $adminEmail;
        $_SESSION['admin'] = $admin;
        header('location:index.php');
    }else{
      $_SESSION["message"] = "Invalid Credentials!";
    }
    }
}
?>


<form action="login.php" method="post">
<div  class="container w3-display-container w3-blue" style="height:400px;">
    
    <div class="card1 w3-padding w3-display-left w3-center" style="margin-left:5%;height:300px">
        <h3>Welcome to Spend Wise</h3>
        <img class="w3-circle" style="width:70%; height:60%;" src="images/logo.jpg" alt="Logo">
    </div>
    
    <div class="card2 w3-padding w3-text-blue w3-display-right w3-white" style="margin-right:5%;height:300px; width:35%;">
        <center><h2>Login</h2></center>
        <center><p style="color:red; margin-top:0px;margin-bottom:0px;"><?= $_SESSION["message"]?></p></center>
        <input class="w3-input" name="username" type="text" placeholder="Username" required><br>
        <input class="w3-input" name="password" type="password" placeholder="Password" required><br>
        <input class="w3-button w3-blue" name="submit" type="submit" value="Login" style="width:100%;">
        <p>Don't Have Account? <a href="register.php">Click Here</a></p>
    </div>
    
</div>
</form>
<?php require_once("footer.php") ?>