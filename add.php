<?php
session_start();
if(!isset($_SESSION['loggedInUser'])){
    header("location: index.php");
}
//Storing user_id of user session
$id=$_SESSION['loggedInID'];

include_once('includes/connections.php');
include_once('includes/functions.php');
include_once('includes/header.php');

$nameError= $emailError=$samename =$sameemail="";
    
if(isset($_POST['add'])){
    $clientName = $clientEmail = $clientPhone= $clientAddress = $clientNotes= $clientCompany = "";
    //Check if user has entered the values. If not, display message
    if(!$_POST['clientName']){    
        $nameError="<div class='alert alert-danger'>Enter  Username<a class='close' data-dismiss='alert'>&times;</a></div>";
    }else{
        //Storing entered username 
        $clientName = validateFormData($_POST['clientName']);
    }
    if(!$_POST['clientEmail']){
        $emailError="<div class='alert alert-danger'>Enter Email <a class='close' data-dismiss='alert'>&times;</a></div>";
    }else{
        $clientEmail = validateFormData($_POST['clientEmail']);
    }
    //Storing entered optional values
    $clientPhone = validateFormData($_POST['clientPhone']);
    $clientCompany = validateFormData($_POST['clientCompany']);               
    $clientAddress = validateFormData($_POST['clientAddress']);       
    $clientNotes = validateFormData($_POST['clientNotes']);
    if($_POST['clientName'] && $_POST['clientEmail']){
        //Checking if the username and email already exist 
       
        $get_username = mysqli_query($conn,"SELECT * FROM clients where user_id=$id AND name='$clientName'");
        $get_rows = mysqli_affected_rows($conn);
        $get_usermail = mysqli_query($conn,"SELECT * FROM clients where user_id=$id AND email='$clientEmail'");
        $get_rows_formail = mysqli_affected_rows($conn);
            
        if($get_rows > 0) {
            $samename="<div class='alert alert-danger'>Username is taken.Try different username<a class='close' data-dismiss='alert'>&times;</a></div>"; 
        }
        else if($get_rows_formail >0) {
            $sameemail="<div class='alert alert-danger'>Email id already exist<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
        //If username and email doesn't exist in users addressbook
        else{
            $query = "INSERT into clients(user_id, name, email, phone, address, company, notes, created_at, updated_at) values('$id','$clientName','$clientEmail','$clientPhone','$clientAddress','$clientCompany','$clientNotes',CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
          
            $result = mysqli_query($conn, $query);
            if($result){
                header("Location: clients.php?alert=success");
            }
            else{
                echo "Error:".$query."<br>".mysqli_error($conn);
            }   
        }
    }      
}//END of isset(_POST['add'])
       
?>

<div class="container">
<?php
    if($nameError){
        echo $nameError;
    }       
    if($samename){
        echo $samename; 
    }        
    if($emailError){
        echo $emailError; 
    }
    if($sameemail){
        echo $sameemail; 
    }   
?>
<!-- FORM FOR ADDING CLIENTS-->
    <h1>Add client</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="form-group col-md-6 ">
            <label for="client-name">Username</label>
            <input type="text" class="form-control input-lg" id="client-name" name="clientName">
        </div>
        <div class="form-group col-md-6">
            <label for="client-email">Email</label>
            <input type="email" class="form-control input-lg" id="client-email" name="clientEmail">
        </div>
        <div class="form-group col-md-6">
            <label for="client-phone">Phone</label>
            <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone">
        </div>
        <div class="form-group col-md-6">
                <label for="client-address">Address</label>
                <textarea class="form-control input-lg" id="client-address" name="clientAddress" row="5"></textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="client-company">Company</label>
            <input type="text" class="form-control input-lg" id="client-company" name="clientCompany">
        </div>
        <div class="form-group col-md-6">
            <label for="client-notes">Notes</label>
            <input type="text" class="form-control input-lg" id="client-notes" name="clientNotes">
        </div>
        <div class="col-md-12">
            <a href="clients.php" type="button" class="btn btn-lg btn-warning">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="add">Add Clients</button>
        </div>
    </form>
</div>