<?php

function validateFormData($formData){
    $formData = trim(stripslashes(htmlspecialchars(strip_tags(str_replace(array('(',')'), '',$formData) ),ENT_QUOTES)));
    
    return $formData;
}

function validatePassword($formData){
    $formData = trim(stripslashes(htmlspecialchars($formData)));
    
    return $formData;
}
    
function checkUsername($conn,$name,$id){
    $count=0;

    $query1="Select * from clients where id <> $id";
    $result1 = mysqli_query($conn, $query1);
    if(mysqli_num_rows($result1)>0){
        while($row1 = mysqli_fetch_assoc($result1)){
            if($row1['name']==$name){
                $count++;
            }
        }
        if($count>0){
            return false;
        }
        return true;
    }
    return true;
}
function checkEmail($conn,$email,$id){
    $count=0;
    $query1="Select * from clients where id <> $id";
    $result1 = mysqli_query($conn, $query1);
    if(mysqli_num_rows($result1)>0){
        while($row1 = mysqli_fetch_assoc($result1)){
            if($row1['email']==$email){
                $count++;
            }
        }
        if($count>0){
            return false;
        }
        return true;
    }
    return true;
}

?>