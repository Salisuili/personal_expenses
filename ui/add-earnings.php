<?php
session_start();
if(empty($_SESSION['admin'])){
  header('location:login.php');
}else{
    require_once('header.php');
    require_once('navbar.php');
    require_once("../database.php");

    $_SESSION['message'] = '';

    $dateErr = $sourceErr = $amountErr = "";
    $email = $date = $source = $amount = "";
    $email = $_SESSION['adminEmail'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["date"])) {
          $dateErr = "Date is required";
        } else {
          $date = $_POST["date"];
        }

        if (empty($_POST["source"])) {
            $sourceErr = "Source is required";
          } else {
            $source = $_POST["source"];
            if (!preg_match("/^[a-zA-Z ]*$/",$source)) {
                $sourceErr = "Only letters and white space allowed";
              }
          }

        if (empty($_POST["amount"])) {
            $amountErr = "Amount is required";
            } else {
              $amount = $_POST["amount"];
            } 

    if(empty($dateErr) && empty($sourceErr) && empty($amountErr)){
     $query = "INSERT INTO `earnings`(`email`, `date`, `source`, `amount`) VALUES ('$email','$date','$source','$amount')";
     $result = $conn->query($query);
        if($result){
           $_SESSION['message'] = "Earnings Registered Successfully";
           $email = $date = $source = $amount = "";
        }else{
           $_SESSION['message'] = "Unable to Register Earnings!";
            }
    }
}
}

?>

<form action="add-earnings.php" method="post">
<div class="w3-container w3-padding">
    <div class="earning w3-blue" style="width:70%; margin-left:15%;margin-top:3%;">
        <h3 style="margin-left:10px;">Add Earnings</h3>
        <center><span class="w3-red w3-text-white" id="error"><?= $_SESSION['message'] ?></span></center>
            <div class="w3-container w3-text-blue w3-white" style="width:100%;">
                <h5 class="r-text">Date</h5>
                <p class="error w3-text-red"><?= $dateErr?></p>
                <input class="w3-input w3-border" name="date" value="<?= $date ?>" type="text" placeholder="Date" required>
                <h5 class="r-text">Source</h5>
                <p class="error w3-text-red"><?= $sourceErr?></p>
                <input class="w3-input w3-border" name="source" value="<?= $source ?>" type="date" placeholder="Source" required>
                <h5 class="r-text">Amount</h5>
                <p class="error w3-text-red"><?= $amountErr?></p>
                <input class="w3-input w3-border" name="amount" value="<?= $amount ?>" type="number" placeholder="Amount" required><br>
                <center><input type="submit" name="submit" class="btn w3-button w3-red" value="Add"></center>
            </div> 
    </div>
</div>
</form>
<?php require_once("footer.php") ?>