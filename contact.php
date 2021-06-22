<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
 <?php
    if(isset($_POST['submit'])){

       
        $username = $_POST['username'];
        $user_email = $_POST['email'];
        $user_password =$_POST['password'];

        if(!empty($username) && !empty($user_email) && !empty($user_password)){

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
               
            $message = "Your Registration has been submitted";
           
            

        }else{
             $message= 'Registration Fields Cannot Be Blank';

            }
        

    }else{
        $message = "";
    }
 
    
 ?>
 

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
 
    <?php  include "includes/navigation.php"; ?>
    </nav>
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact Us</h1>
            
                    <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
                        <h6 class = "text center"><?php echo $message ?></h6>
                      
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="email" name="subject" id="subject" class="form-control" placeholder="Enter Your Subject">
                        </div>
                         <div class="form-group">
                            <textarea class="form-control" name="body" id="body" ></textarea>
                        </div>
                
                        <input type="submit" name='contact" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Contact Us">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
