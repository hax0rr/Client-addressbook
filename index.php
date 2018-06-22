<?php
include('includes/functions.php');

include('includes/connections.php');
include_once('includes/header.php');
//IF CLICKED ON SIGNUP
if(isset($_POST['signup'])){
    $formUser = validateFormData($_POST['username']);
    $formPass = validatePassword($_POST['password']);
    
    $que="Select * from user where username= '$formUser'";
    $res = mysqli_query($conn, $que);
    if(mysqli_num_rows($res)>0){
        echo "<div class='alert alert-danger'>Username is taken!<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
    else{
        $quer="insert into user(username,password) values('$formUser','$formPass')";
        $resu = mysqli_query($conn, $quer);
        if(!$resu){
            echo "<div class='alert alert-danger'>There is some issue.. Try again!<a class='close' data-dismiss='alert'>&times;</a></div>";
        }else{
            echo "<div class='alert alert-success'>SignUp Success! You can now log in.<a class='close' data-dismiss='alert'>&times;</a></div>";

        }
    }
}
//IF CLICKED ON LOGIN
if(isset($_POST['login'])){

    $formUser = validateFormData($_POST['username']);
    $formPass = validatePassword($_POST['password']);

    $query = "select * from user where username = '$formUser'";
    $result = mysqli_query($conn, $query);
    //If username matches
    if(mysqli_num_rows($result)>0){ 
        //If there are 2 same username: if inserted explicitly
        if(mysqli_num_rows($result)>1){
            echo "<div class='alert alert-danger'>There is some issue Contact Admin<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
        else{            
            if($row = mysqli_fetch_assoc($result)){
                $user = $row['username'];
                $pass = $row['password']; 
                //if password match
                if($pass==$formPass){
                    //session start and making session variables
                    session_start();
                    $_SESSION['loggedInUser'] = $user;
                    $_SESSION['loggedInID'] = $row['user_id'];
                    header("location: clients.php");
                }
                else
                {
                    echo "<div class='alert alert-danger'>Wrong username n password combination</div>";

                }
            }
        }
    }
    else{
      echo "<div class='alert alert-danger'>NO such user found<a class='close' data-dismiss='alert'>&times;</a></div>" ;
    }
}//end of isset if

?>
<!--FORM FOR LOGIN AND SIGNUP-->
<div class="container">
    <!--    LOGIN    -->
    <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="POST">
        <h1>Login</h1>
        <p class="lead">Use the form to login to account</p>
        <div class="form-group">
            <label for="login-username" class="sr-only">Username</label>
            <input type="text" id="login-username" name="username" name="username" placeholder="Username" class="form-control">
        </div>
        <div class="form-group">
            <label for="login-password" class="sr-only">Password</label>
            <input type="text" id="login-password" name="password" name="password" placeholder="Password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary" name="login">Login</button>
    </form>
        
    <!--    SIGNUP  -->
    <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="POST">
        <h1>SignUp</h1>
        <p class="lead">Use the form to create a new account</p>
        <div class="form-group">
            <label for="signup-username" class="sr-only">Username</label>
            <input type="text" id="signup-username" name="username" name="username" placeholder="Username" class="form-control">
        </div>
        <div class="form-group">
            <label for="signup-password" class="sr-only">Password</label>
            <input type="text" id="signup-password" name="password" name="password" placeholder="Password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary" name="signup">Signup</button>
    </form> 
</div>
<?php

include_once('includes/footer.php');
mysqli_close($conn);

?>