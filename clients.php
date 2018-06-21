<?php
session_start();
if(!isset($_SESSION['loggedInUser'])){
    header("location: index.php");
}
include('includes/connections.php');
     if(isset($_POST['delbtn'])){
       
     if(isset($_POST['id'])){
         $id = $_POST['id'];

        $query="delete from clients where id=$id";

            $result = mysqli_query($conn, $query);
       
           if(!$result){
             //  die('Could not up data: ' . mysql_error());
           }
         else{
             echo "<div class='alert alert-success'>Record deleted successfully </div>"; 
             
         }
            
    } }
if(isset($_GET['alert'])){
    if(isset($_GET['alert'])=="success"){
        echo "<div class='alert alert-success'>Record inserted successfully </div>"; 
    }
}

$query = "Select * from clients";
$result = mysqli_query($conn, $query);

include_once('includes/header.php');
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
                    <th>Delete</th>
                </tr>

                <?php
        
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo 
                        "<td>".$row['name']."</td><td>".$row['email']."</td><td>".$row['phone']."</td><td>".$row['address']."</td><td>".$row['company']."</td><td>".$row['notes']."</td>";
                    
                    echo '<td>
                    <a href="edit.php?id='.$row['id'].'" name="editbtn" type="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-edit"></span></a></td>';
                    ?>
                
                    <td><form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"><input type="hidden" name="id" value="<?php echo $row['id']?>"><button class="btn btn-primary btn-sm" name="delbtn"><span class="glyphicon glyphicon-trash"></span></button></form></td>
                <?php
                
                    echo"</tr>";
                }
            }
        else{
            echo"<div class='alert alert-warning'>You have no client</div>";
        }
                
        ?>
            </table>
           
            <tr>
                <td colspan="8 ">
                    <div class="text-center ">
                        <a href="add.php " type="button " class="btn btn-success btn-sm ">
                            <span class="glyphicon glyphicon-plus "></span>
                        </a>
                    </div>
                </td>
            </tr>

    </div>

    <?php

include_once('includes/footer.php');
?>