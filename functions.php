<?php

function username_exists($username){
    global $connection;
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    //confirmQuery($result);
    if(mysqli_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }
}

?>