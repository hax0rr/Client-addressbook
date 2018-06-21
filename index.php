<?php


$loginError = "";

if(isset($_POST['login'])){
    
    include('includes/functions.php');
    

    $formUser = validateFormData($_POST['username']);
    $formPass = validatePassword($_POST['password']);
    
    //connect to db
    include('includes/connections.php');
    
    //create qurery
    $query = "Select * from user where username = '$formUser'";
    
    //store result
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result)>0){
        //there are som rows
        
        if(mysqli_num_rows($result)>1){
            $loginError="<div class='alert alert-danger'>There is some issue Contact Admin<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
        else{
            //store the basic user data in variable
            
            if($row = mysqli_fetch_assoc($result)){
               $user = $row['username'];
               $hashedPass = $row['password']; 
            
            
                if($hashedPass==$formPass){
                    
                    session_start();
                    
                    $_SESSION['loggedInUser'] = $user;
                    $_SESSION['loggedInEmail'] = $email;
                    header("location: clients.php");
                }
                else
                {
                    ///password diddnt veriffy
                    $loginError = "<div class = 'alert alert-danger'>Wrong username n password combination</div>";

                }
        }
        }
    }
    
    else{
       $loginError="<div class='alert alert-danger'>NO such user found<a class='close' data-dismiss='alert'>&times;</a></div>" ;
    }
    //close connection
 mysqli_close($conn);   
}//end of isset if

include_once('includes/header.php');
?>
    <div class="container">
        <h1>Login</h1>
        <p class="lead">Use the form to login to account</p>
        <?php
            
                if($loginError){
                    echo $loginError;
                }
            
                
            ?>

            <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="POST">
                <div class="form-group">
                    <label for="login-username" class="sr-only">Username</label>

                    <input type="text" id="login-username" name="username" name="username" placeholder="Username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="login-password" class="sr-only">Password</label>

                    <input type="text" id="login-password" name="password" name="password" placeholder="Password" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary" name="login">Login!</button>
            </form>
    </div>
    <?php

include_once('includes/footer.php');
?>