<?php
session_start();
if(empty($_SESSION['admin'])){
  header('location:login.php');
}else{
    require_once('header.php');
    require_once('navbar.php');
    require_once("../database.php");

    $_SESSION['message'] = '';

    $dateErr = $saved_forErr = $amountErr = "";
    $email = $date = $saved_for = $amount = "";
    $email = $_SESSION['adminEmail'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (empty($_POST["date"])) {
          $dateErr = "Date is required";
        } else {
          $date = $_POST["date"];
        }

        if (empty($_POST["saved_for"])) {
            $saved_forErr = "This Field is required";
          } else {
            $saved_for = $_POST["saved_for"];
            if (!preg_match("/^[a-zA-Z ]*$/",$saved_for)) {
                $saved_forErr = "Only letters and white space allowed";
              }
          }

        if (empty($_POST["amount"])) {
            $amountErr = "Amount is required";
            } else {
              $amount = $_POST["amount"];
            } 

    if(empty($dateErr) && empty($saved_forErr) && empty($amountErr)){
     $query = "INSERT INTO `savings`(`email`, `date`, `saved_for`, `amount`) VALUES ('$email','$date','$saved_for','$amount')";
     $result = $conn->query($query);
     
        if($result){
           $_SESSION['message'] = "Savings Registered Successfully";
           $email = $date = $saved_for = $amount = "";
        }else{
           $_SESSION['message'] = "Unable to Register Savings!";
            }
    }
}
}

?>

<form action="add-savings.php" method="post">
<div class="w3-container w3-padding">
    <div class="earning w3-blue" style="width:70%; margin-left:15%;margin-top:3%;">
        <h3 style="margin-left:10px;">Add Savings</h3>
        <center><span class="w3-red w3-text-white" id="error"><?= $_SESSION['message'] ?></span></center>
            <div class="w3-container w3-text-blue w3-white" style="width:100%;">
                <h5 class="r-text">Date</h5>
                <p class="error w3-text-red"><?= $dateErr?></p>
                <input class="w3-input w3-border" name="date" value="<?= $date ?>" type="date" placeholder="Date" required>
                <h5 class="r-text">Saved For</h5>
                <p class="error w3-text-red"><?= $saved_forErr?></p>
                <input class="w3-input w3-border" name="saved_for" value="<?= $saved_for ?>" type="text" placeholder="Saved for" required>
                <h5 class="r-text">Amount</h5>
                <p class="error w3-text-red"><?= $amountErr?></p>
                <input class="w3-input w3-border" name="amount" value="<?= $amount ?>" type="number" placeholder="Amount" required><br>
                <center><input type="submit" name="submit" class="btn w3-button w3-red" value="Add"></center>
            </div> 
    </div>
</div>
</form>
<?php require_once("footer.php") ?>