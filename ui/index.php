<?php
session_start();
if(empty($_SESSION['admin'])){
  header('location:login.php');
}else{
    require_once('header.php');
    require_once('navbar.php');
    require_once("../database.php");

    $earnings = $debts = $expenses = $savings = 0.00;
    $_SESSION['message'] = '';
    $adminEmail = $_SESSION['adminEmail'];
    $query = "SELECT * FROM `earnings` WHERE email = '$adminEmail'";
    $result = $conn->query($query);
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
      $earnings += $row['amount'];
        }
    }

    $query = "SELECT * FROM `savings` WHERE email = '$adminEmail'";
    $result = $conn->query($query);
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
      $savings += $row['amount'];
        }
    }

    $query = "SELECT * FROM `expenses` WHERE email = '$adminEmail'";
    $result = $conn->query($query);
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
      $expenses += $row['amount'];
        }
    }

    $query = "SELECT * FROM `debts` WHERE email = '$adminEmail'";
    $result = $conn->query($query);
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
      $debts += $row['amount'];
        }
    }
}
?>

<div class="e-container w3-container">
  
<a href="earnings.php"> 
      <div class="cards w3-panel w3-center w3-blue w3-card-2">
        <h1>#<?= $earnings ?></h1>
        <p>Total Earnings</p>
        <p class="p">Click for Details</p>
    </div>
</a>
<a href="savings.php"> 
      <div class="cards w3-panel w3-center w3-orange w3-card-2">
        <h1>#<?= $savings ?></h1>
        <p>Total Savings</p>
        <p class="p">Click for Details</p>
    </div>
</a>
<a href="expenses.php"> 
      <div class="cards w3-panel w3-center w3-deep-orange w3-card-2">
        <h1>#<?= $expenses ?></h1>
        <p>Total Expenses</p>
        <p class="p">Click for Details</p>
    </div>
</a>
<a href="debts.php"> 
      <div class="cards w3-panel w3-center w3-teal w3-card-2">
        <h1>#<?= $debts ?></h1>
        <p>Total Debts</p>
        <p class="p">Click for Details</p>
    </div>
</a>
  
</div>





<?php require_once("footer.php") ?>
