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


function login_user($username, $password){
    global $connection;

    //$username = $_POST['username'];
    //$password = $_POST['password'];

    $username = trim($username);
    $password = trim($password);
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '$username' ";
    $select_user_query = mysqli_query($connection, $query);

    if(!$select_user_query){
        die("Connection Error: " . mysqli_error($connection) );
    }

    while($row = mysqli_fetch_array($select_user_query)){
        //print_r($row);
        $db_id = $row['user_id'];
        $db_username = $row['username'];
        $db_password = $row['user_password'];
        $db_firstname = $row['user_firstname'];
        $db_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
        $db_randSalt = $row['randSalt'];

        if (password_verify($password,$db_password)){
    
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
    
            if($db_user_role == 'admin'){
    
            header("Location: /cms/admin");
    
            } else {
            //header("Location: /cms/index.php");
            return false;
            }
        }   
    }


    
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