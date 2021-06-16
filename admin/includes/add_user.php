
<?php
   
    if(isset($_POST['create_user'])){
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
 


        $query = "INSERT into users(user_firstname,user_lastname,user_role,username,user_email,user_password) ";
        $query .= "VALUE('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}','{$user_password}') ";


        $create_user_query = mysqli_query($connection, $query);

        confirmQuery($create_user_query);

        echo "<div class='well'>User Added: <a href='users.php'>View Users</a></div>";
 
    }

?>

<?php ?>



<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label for="title">First Name</label>
    <input type="text" class="form-control" name="user_firstname">
</div>
<div class="form-group">
    <label for="title">Last Name</label>
    <input type="text" class="form-control" name="user_lastname">
</div>
<div class="form-group">
<select name = "user_role" id="">
    <option value="subscriber">Select Options</option>
    <option value="admin">Admin</option>
    <option value="subscriber">Subscriber</option>

</select>
</div>


<div class="form-group">
    <label for="user_image">User Image</label>
    <input type="file"  name="user_image">
</div>

<div class="form-group">
    <label for="post_tags">Username</label>
    <input type="text" class="form-control" name="username">
</div>

<div class="form-group">
    <label for="post_content">Email</label>
    <input type="email" class="form-control" name="user_email">
</div>
<div class="form-group">
    <label for="post_content">Password</label>
    <input type="password" class="form-control" name="user_password">
</div>
<div class="form-group">
          <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
 </div>





</form>