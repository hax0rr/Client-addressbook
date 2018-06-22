<?php
session_start();
if(!isset($_SESSION['loggedInUser'])){
    header("location: index.php");
}
$user_id=$_SESSION['loggedInID'];
include_once('includes/connections.php');
include_once('includes/functions.php');
include_once('includes/header.php');

    
$result = $idgot="";
$fillName = $fillCompany = $fillNotes = $fillPhone = $fillEmail = $fillAddress = "";
//IF USER CLICKED ON EDIT BUTTON OF A CLIENT
if(isset($_GET['id']))
{
    if($_GET['id']>-1)
    {
        $idgot = $_GET['id'];
        $query="Select * from clients where id=$idgot";
        $result = mysqli_query($conn, $query);
            
        if(mysqli_num_rows($result)>0)
        {   //FILLING DETAILS OF THAT CLIENT IN INPUTBOX
            $row = mysqli_fetch_assoc($result);
            $fillName = $row['name'];
            $fillPhone = $row['phone'];
            $fillEmail = $row['email'];
            $fillCompany = $row['company'];
            $fillNotes = $row['notes'];
            $fillAddress = $row['address'];
        }
    }
}
//IF CLICKED ON UPDATE    
if(isset($_POST['updatebtn'])){
    if(isset($_GET['id'])){
        $getid = $_GET['id'];
        $name = $_POST['clientName']; 
        $email = $_POST['clientEmail'];
        //CHECK IF UPDATED USERNAME AND EMAIL DOESN'T ALREADY EXIST!
        if(checkUsername($conn,$name,$getid,$user_id) && checkEmail($conn,$email,$getid,$user_id)){

            $phone = $_POST['clientPhone'];
            $address = $_POST['clientAddress'];
            $notes = $_POST['clientNotes'];
            $company = $_POST['clientCompany'];
            $query="update clients set name= '$name',email= '$email', phone= '$phone', address= '$address', notes= '$notes' , company= '$company' where id=$getid";
            $result = mysqli_query($conn, $query);
            if(!$result){
               die('Could not update data: ' . mysql_error());
            }
            else{
                echo "<div class='alert alert-success'>Record updated successfully </div>"; 
            }
         }
         else{
             echo "<div class='alert alert-danger'>Record coudnt be updated!  Duplicate entry for username or email</div>"; 
         }
     }
 }
    
//IF CLICKED ON DELETE
if(isset($_POST['deletebtn'])){
    if(isset($_GET['id'])){
         $getid = $_GET['id'];
        $query="delete from clients where id= $getid";
            
        $result = mysqli_query($conn, $query);
        if($result){
            echo "<div class='alert alert-success'>Record deleted successfully </div>"; 
        }
        else{
            die('Could not delete data: ' . mysql_error());
        }
            
    } 
}

//TO SHOW THE RECORDS OF CLIENTS
$query = "select * from clients where user_id=$user_id";
$result = mysqli_query($conn, $query);

?>

<div class="container">
    <h1>Client Address Book</h1>
    <table class="table table-striped table-hover table-responsive">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Company</th>
            <th>Notes</th>
            <th>Edit</th>
        </tr>

        <?php
        
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo 
                        "<td>".$row['name']."</td><td>".$row['email']."</td><td>".$row['phone']."</td><td>".$row['address']."</td><td>".$row['company']."</td><td>".$row['notes']."</td>";
                    
                    echo '<td>
                    <a href="edit.php?id='.$row['id'].'"type"="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-edit"></span></a></td>';
                   
                    echo"</tr>";
                }
            }
        else{
            echo"<div class='alert alert-warning'>You have no client</div>";
        }
        
        ?>
    </table>
</div>
<!--FORM FOR EDITING CLIENTS DETAILS-->
<div class="container">

    <h1>Edit client</h1>
    <form action="" method="POST">
        <div class="form-group col-md-6 ">
            <label for="client-name">Name</label>
            <input type="text" class="form-control input-lg" id="client-name" name="clientName" value=<?php echo "$fillName" ?>>
        </div>
        <div class="form-group col-md-6">
            <label for="client-email">Email</label>
            <input type="email" class="form-control input-lg" id="client-email" name="clientEmail" value=<?php echo "$fillEmail" ?>>
        </div>
        <div class="form-group col-md-6">
            <label for="client-phone">Phone</label>
            <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value=<?php echo "$fillPhone" ?>>
        </div>
        <div class="form-group col-md-6">
            <label for="client-address">Address</label>
            <textarea class="form-control input-lg" id="client-address" name="clientAddress" row="5">
                        <?php echo "$fillAddress"?>
            </textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="client-company">Company</label>
            <input type="text" class="form-control input-lg" id="client-company" name="clientCompany" value=<?php echo "$fillCompany" ?>>
        </div>
        <div class="form-group col-md-6">
            <label for="client-notes">Notes</label>
            <input type="text" class="form-control input-lg" id="client-notes" name="clientNotes" value=<?php echo "$fillNotes" ?>>
        </div>
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <div class="col-md-12">
                <div class="pull-right">
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-lg btn-success pull-right" name="updatebtn">Update</button>
                    </div>
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-lg btn-success pull-right" name="deletebtn">Delete</button>
                    </div>
                </div>
            </div>
    </form>
</div>

<?php 
    mysqli_close($conn);

?>