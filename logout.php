<?php
session_start();

//clearing session variables
session_unset();
//destroying the session
session_destroy();

include_once('includes/header.php');
?>
<div class="container">
    <p class="lead">You have been logged out!</p>
    <p>
        <a href="index.php" typr="button" class ="btn btn-success"><span classs="glyphicon gltyphicon-user"></span>Login!</a>
    </p>
</div>
<?php
include_once('includes/footer.php');

?>
