<?php 

include('includes/connections.php');
include_once('includes/header.php');
 
     if(isset($_GET['id'])){
         $getid = $_GET['id'];
         echo $getid;
            $query="delete from clients where id= $getid";
            
            $result = mysqli_query($conn, $query);
       // echo "delete query ".$query1;
           if($result){
                   

              echo "<div class='alert alert-success'>Record deleted successfully </div>"; 
           }
         else{
             die('Could not delete data: ' . mysqli_error());
         }
//         header('Location: ' . $_SERVER['HTTP_REFERER']);
            
    } 
    
include_once('includes/footer.php');

?>