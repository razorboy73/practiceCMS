<?php include "includes/admin-header.php"; ?>


<?php

if(isset($_SESSION['username'])){

    $the_username = $_SESSION['username'];
}
?>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
           
        <?php include "includes/admin-navigation.php"; ?>
            
        </nav>




        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Users
                            <small>the big people</small>

                    
                        </h1>



                                <?php
                             


                                $query = "SELECT * FROM users WHERE username = '$the_username' ";
                                $select_user_profile_query = mysqli_query($connection, $query);

                                while($row = mysqli_fetch_assoc($select_user_profile_query)){
                                    $user_id = $row['user_id'];

                                    $username = $row['username'];
                                    $user_password= $row['user_password'];
                                    $user_firstname = $row['user_firstname'];
                                    $user_lastname = $row['user_lastname'];
                                    $user_email = $row['user_email'];
                                    $user_image = $row['user_image'];
                                    $user_role = $row['user_role'];
                            }



                            //Inserting updated user data
                            if(isset($_POST['update_profile'])){
                                $user_firstname = $_POST['user_firstname'];
                                $user_lastname = $_POST['user_lastname'];
                               
                                $username = $_POST['username'];
                            
                                $user_image = $_FILES['user_image']['name'];
                                $user_image_temp = $_FILES['user_image']['tmp_name']; 
                                $user_email = $_POST['user_email'];
                                $user_password =$_POST['user_password'];
                                //$user_date= date('d-m-y');
                            
                                move_uploaded_file($user_image_temp, "../images/$user_image");


                                if(!empty($user_password)){

                                    $query_password = "SELECT user_password FROM users WHERE user_id = $user_id";
                                    $get_user_query = mysqli_query($connection, $query_password);
                                    confirmQuery($get_user_query);
                        
                                    $row = mysqli_fetch_array($get_user_query);
                                    $db_user_password = $row['user_password'];
                                }
                                if($db_user_password != $user_password){
                                    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost'=>12));
                                }
                            
                            
                                $query = "UPDATE users SET ";
                                $query .= "user_firstname = '{$user_firstname}', ";
                                $query .= "user_lastname = '{$user_lastname}', ";
                                $query .= "user_role = '{$user_role}', ";
                                $query .= "username = '{$username}', ";
                                $query .= "user_email = '{$user_email}', ";
                                $query .= "user_password = '{$hashed_password}' ";
                                $query .= "WHERE user_id = '{$user_id}'";
                            
                            
                                $update_user_query = mysqli_query($connection, $query);
                            
                                confirmQuery($update_user_query);
                            
                            
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
                            <input class="btn btn-primary" type="submit" name="update_profile" value="Update Profile">
                        </div>





</form>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
        <?php include "includes/admin-footer.php"; ?>