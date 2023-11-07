<?php
session_start();
if(empty($_SESSION['admin'])){
  header('location:login.php');
}else{
    require_once('header.php');
    require_once('navbar.php');
    require_once("../database.php");
    $email = $id = $date = $spent_on = $amount = '';
    $email = $_SESSION['adminEmail'];

    if(isset($_POST['delete'])){
        $delId = $_SESSION['delid'];
        $query = "DELETE FROM `expenses` WHERE id = '$delId'";
        $result = $conn->query($query);
        if($result){
            $_SESSION['message'] = "Record Deleted Successfully";
        }else{
            $_SESSION['message'] = "Unable to Delete Record";
        }
    }

}
?>

<div class="w3-container w3-padding">
    <div class="earning w3-blue" style="width:70%; margin-left:15%;margin-top:3%;">
        <h3 style="margin-left:10px;">Expenses Details</h3>
        <table border="1px" class="w3-table w3-white w3-card-4 w3-center" style="width:100%;">
            <tr>
                <th>SN</th>
                <th>Date</th>
                <th>Spent On</th>
                <th>Amount</th>
            </tr>
            <?php
            $query = "SELECT * FROM `expenses` WHERE email = '$email'";
            $result = $conn->query($query);
            while($row = $result->fetch_assoc()){
                if(empty($row)){
                    $message = "No Expenses Available";
                    echo "<tr>
                    <td>$message</td>
                    </tr>";
                }else{
                    $_SESSION['delid'] = $row['id'];
                    $id = $row['id'];
                    $date = $row['date'];
                    $spent_on = ucfirst($row['spenton']);
                    $amount = $row['amount'];
                    echo "<tr>
                    <td>$id</td>
                    <td>$date</td>
                    <td>$spent_on</td>
                    <td>$amount</td>
                    <form action='expenses.php' method='post'>
                    <td colspan='2' ><button name='edit' class='w3-button w3-green'>Edit</button><button name='delete' class='w3-button w3-red'style='margin-left:5px;'>Delete</button></td>
                    </form>
                    </tr>";
                }
        }
    ?>
        </table>
    </div>
</div>

<?php require_once("footer.php") ?>