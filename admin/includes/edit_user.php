
<?php

if(isset($_GET['user_id'])){
    $the_user_id =  $_GET['user_id'];


    $query = "SELECT * FROM users WHERE user_id = $the_user_id";
    $select_users_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_users_query)){
          $user_id = $row['user_id'];
          $username = $row['username'];
          $user_firstname = $row['user_firstname'];
          $user_lastname = $row['user_lastname'];
          $user_email = $row['user_email'];
          $user_image = $row['user_image'];
          $user_role = $row['user_role'];
}

}






if(isset($_POST['edit_user'])){
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];

    $user_image = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name']; 
    $user_email = $_POST['user_email'];
    $user_password =$_POST['user_password'];
    //$user_date= date('d-m-y');

    move_uploaded_file($user_image_temp, "../images/$user_image");


    $query = "SELECT randSalt from users";
    $select_randsalt_query = mysqli_query($connection, $query);
    if(!$select_randsalt_query){
        die("Query Failed" . mysqli_error($connection));
    }

    $row = mysqli_fetch_array($select_randsalt_query);
    $salt = $row['randSalt'];
    $hashed_password= crypt($user_password, $salt);



    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_role = '{$user_role}', ";
    $query .= "username = '{$username}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_password = '{$hashed_password}' ";
    $query .= "WHERE user_id = '{$the_user_id}'";


    $edit_user_query = mysqli_query($connection, $query);

    confirmQuery($edit_user_query);


}

?>



<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
<label for="title">First Name</label>
<input type="text" value="<?php echo $user_firstname?>" class="form-control" name="user_firstname">
</div>
<div class="form-group">
<label for="title">Last Name</label>
<input type="text" value="<?php echo $user_lastname?>"class="form-control" name="user_lastname">
</div>
<div class="form-group">
<select name = "user_role" id="">



<option value="subscriber"><?php echo $user_role?></option>


<?php 
 if($user_role == 'admin'){
    echo '<option value="subscriber">subscriber</option>';
 }else{
     echo '<option value="admin">admin</option>';
 }


?>



</select>
</div>


<div class="form-group">
<label for="user_image">User Image</label>
<input type="file"  name="user_image">
</div>

<div class="form-group">
<label for="post_tags">Username</label>
<input type="text" value="<?php echo $username?>" class="form-control" name="username">
</div>

<div class="form-group">
<label for="post_content">Email</label>
<input type="email" value="<?php echo $user_email?>" class="form-control" name="user_email">
</div>
<div class="form-group">
<label for="post_content">Password</label>
<input type="password" value="<?php echo $user_passowrd?>" class="form-control" name="user_password">
</div>
<div class="form-group">
      <input class="btn btn-primary" type="submit" name="edit_user" value="Update User">
</div>





</form>