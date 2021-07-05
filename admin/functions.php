<?php



//===DATABASE HELPERS =====//

function redirect($location){
    header("Location:" . $location);
    exit;
}



function query($query){
    global $connection;
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;

}

function fetchRecords($result){
    return mysqli_fetch_array($result);

}


//===End Database HELPERS ===//

//==General Helpers ==//

function get_user_name(){
    return (isset($_SESSION['username']) ? $_SESSION['username']: null); 
      
}

// ==== AUTHENTICATION HELPERS =====//
function is_admin($username = ''){

   
    if(isLoggedIn()){
        $result = query("SELECT user_role FROM users WHERE user_id= ".$_SESSION['user_id']."");
        $row = fetchRecords($result);
        if($row['user_role'] == 'admin'){
        return true;
        }else{
        return false;
        }
    }
    return false;
}


// ==== END AUTHENTICATION HELPERS =====//

function currentUser(){
    if(isset($_SESSION['username'])){
        return $_SESSION['username'];
    }
}


function imagePlaceholder($image){
    if(!$image){
        return 'smashed%20computer.jpg';
    }else{
        return $image;
   
    }
}



function confirmQuery($result){

        global $connection;

        if(!$result){
            die('Query Failed: ' . mysqli_error($connection));
    }
   
}

function loggedInUserID(){

    if(isLoggedIn()){
        //$result =  query("SELECT * FROM users WHERE username='razorboy'");
    
        $result =  query("SELECT * FROM users WHERE username='$_SESSION[username]'");
        confirmQuery($result);
        $user = mysqli_fetch_array($result);
        
        return mysqli_num_rows($result) >=1 ? $user['user_id']: false;
        //if(mysqli_num_rows($result) >=1){
       //     return $user['user_id'];
       // }
    }
    return false;
}

function userLikedThisPost($post_id = ""){
    $result = query("SELECT * FROM likes where user_id = " . loggedInUserID() . " AND post_id={$post_id}");
    confirmQuery($result);
    return mysqli_num_rows($result) >=1 ? true : false;
    
}



function getPostLikes($post_id){
    $result = query("SELECT * FROM likes WHERE post_id=$post_id");
    confirmQuery($result);
    echo mysqli_num_rows($result);
}



function insert_categories(){

        global $connection;

        if(isset($_POST['submit'])){

            $cat_title = $_POST['cat_title'];

            if($cat_title == "" || empty($cat_title)){
                echo "This field should not be empty";
            }else{

                //$query = "INSERT into categories(cat_title) ";
                //$query .= "VALUE('{$cat_title}') ";
                $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?) ");
                mysqli_stmt_bind_param($stmt, 's', $cat_title);
                mysqli_stmt_execute($stmt);

                //$create_category_query = mysqli_query($connection, $query);

                if(!$stmt){
                    die('Query Failed' . mysqli_error($connection));
                }

            }
        }

}




function findAllCategories(){

    global $connection;

    $query = "SELECT * FROM categories ";
    $select_categories = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_categories)){
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];

     echo "<tr>";
     echo "<td>{$cat_id}</td>";
     echo "<td>{$cat_title}</td>";
     echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
     echo "<td><a href='categories.php?edit={$cat_id}'>EDIT</a></td>";
     echo "</tr>";

}
}

function deleteCategories(){
    global $connection;

    if(isset($_GET['delete'])){  
        $the_cat_id = $_GET['delete'];

        $query = "DELETE from categories WHERE cat_id = {$the_cat_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}

function user_online(){

    if(isset($_GET['onlineusers'])){


        global $connection;

        if(!$connection){
            session_start();
            include("../includes/db.php");

       

            $session = session_id();
            $time = time();
            $time_out_in_seconds = 60;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if($count == NULL){
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");

            }else{
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }

            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");

            echo $count_user = mysqli_num_rows($users_online_query);
        }
    }
    
    //if(!$count_user ){
    //    die('Query Failed: ' . mysqli_error($connection));
//}

}//closing of get request isset()

user_online();

function recordCount($table){
    global $connection;

    $query = "SELECT * FROM "  . $table;
    //echo $query;
    $select_all_posts = mysqli_query($connection, $query);
    $result = mysqli_num_rows($select_all_posts);
    
    //confirmQuery($result); This causes an error with zero returns
    
    
    return $result;
    
}


function checkStatus($table, $column, $status, $author=null, $username=null){
    global $connection;
    if(!$author || !$username){

    $query = "SELECT * FROM $table WHERE $column  = '$status'";
    }else{

    $query = "SELECT * FROM $table WHERE $column  = '$status' AND $author ='$username'";
    }
    $select_items = mysqli_query($connection, $query);
    $select_items_counts = mysqli_num_rows($select_items);
    //confirmQuery($select_items_counts); This causes an error with zero returns
    return $select_items_counts;
    
}







function ifItIsMethod($method=null){
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }
    return false;
}

function isLoggedIn(){
    if(isset($_SESSION['user_role'])){
        return true;
    }
    return false;
}


function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
        if(isLoggedIn()){
            redirect($redirectLocation);
        }
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
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_password = $row['user_password'];
        $db_firstname = $row['user_firstname'];
        $db_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
        $db_randSalt = $row['randSalt'];

        if (password_verify($password,$db_password)){
            $_SESSION['user_id'] = $db_user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_firstname;
            $_SESSION['lastname'] = $db_lastname;
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