<?php
$adminEmail = $_SESSION['adminEmail'];
require_once("../database.php");
require_once("header.php");
$query = "SELECT * FROM `users` WHERE email = '$adminEmail'";
$result = $conn->query($query);
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      $username = $row['username'];
      $prof_pic = $row['prof_pic'];
}
?>

<ul class="w3-blue">
  <li><a class="a adrop" href="index.php"><img class="spendwise" src="images/spendwise.png" alt="Home"></a></li> 
  <li class="dropdown">
    <a href="javascript:void(0)" class="a">Earnings</a>
    <div class="dropdown-content">
      <a href="earnings.php">View Earnings</a>
      <a href="add-earnings.php">Add Earnings</a>
    </div>
  </li> 

  <li class="dropdown">
    <a href="javascript:void(0)" class="a">Savings</a>
    <div class="dropdown-content">
      <a href="savings.php">View Savings</a>
      <a href="add-savings.php">Add Savings</a>
    </div>
  </li> 

  <li class="dropdown">
    <a href="javascript:void(0)" class="a">Expenses</a>
    <div class="dropdown-content">
      <a href="expenses.php">View Expenses</a>
      <a href="add-expenses.php">Add Expenses</a>
    </div>
  </li> 

  <li class="dropdown">
    <a href="javascript:void(0)" class="a">Debts</a>
    <div class="dropdown-content">
      <a href="debts.php">View Debts</a>
      <a href="add-debts.php">Add Debts</a>
    </div>
  </li> 

  
  <li class="dropdown" id="dropdown2">
    <a class="adrop" href="javascript:void(0)" > <img class="pic w3-circle" src="<?= $prof_pic?>" alt="pic"> &nbsp;&nbsp;<?= ucfirst($username)?></a>
    <div class="dropdown-content">
      <a href="profile.php">View Profile</a>
      <a href="edit-profile.php">Edit Profile</a>
      <form action="../logout.php" methdod="post">
        <input type="submit" name="submit" class="logbtn w3-button w3-hover-blue" value="Logout" name="submit">
    </form>
    </div>
  </li>
</ul>