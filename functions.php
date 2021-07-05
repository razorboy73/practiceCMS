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


function email_exists($email){
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    //confirmQuery($result);
    if(mysqli_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }
}

function redirection($location){
    return header("Location:" . $location);
}


function register_user($username, $email, $password){
    global $connection;

    $username = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password =$_POST['password'];



        $username = mysqli_real_escape_string($connection,$username);
        $user_email= mysqli_real_escape_string($connection,$user_email);
        $user_password = mysqli_real_escape_string($connection,$user_password );

        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));


        $query = "INSERT into users(user_role,username,user_email,user_password) ";
        $query .= "VALUE('subscriber','{$username}', '{$user_email}','{$user_password}') ";

        $register_user_query = mysqli_query($connection, $query);

        if (!$register_user_query){
            die("Query failed ". mysqli_error($connection) . " " .mysqli_errno($connection));

        }
           
        //$message = "Your Registration has been submitted";
       
    

}



/*function is_admin($username = ''){

    global $connection;
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    $row = mysqli_fetch_array($result);

    if($row['user_role'] == 'admin'){
        return true;
    }else{
        return false;
    }

    
}*/




?>