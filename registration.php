<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
 <?php include "functions.php"; ?>
 

 

 <?php
    if($_SERVER['REQUEST_METHOD']=="POST"){


    $username = trim($_POST['username']);
    $user_email = trim($_POST['email']);
    $user_password =trim($_POST['password']);

    $error = [
        'username'=> '',
        'email'=>'',
        'password'=>''

    ];
    if(strlen($username) < 4){
        $error['username'] = 'Username must be longer';
    }
    if($username == ''){
        $error['username'] = 'Username cant be blank';
    }
    if(username_exists($username)){
        $error['username'] = 'Username exists, pick another';
    }


    
    if($user_email == ''){
        $error['email'] = 'Email cant be blank';
    }
    if(email_exists($user_email)){
        $error['email'] = 'Email exists in our system. <a herf="index.php">Please Log In</a>';
    }

    if($user_password == ''){
        $error['password'] = "password cant be blank";
    }


    foreach($error as $key => $value){
        if(empty($value)){
            unset($error[$key]);
            
        }
    }//end of registration/login foreach loop

    if(empty($error)) {
        register_user($username, $user_email, $user_password);
        login_user($username, $user_password);
    }
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
                <h1>Register</h1>
            
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                       
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username"
                            autocomplete="on";
                            value = "<?php echo isset($username)? $username: '' ?>">

                            <p><?php echo isset($error['username'])? $error['username']: '' ;?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com"
                            autocomplete="on";
                            value = "<?php echo isset($email)? $error: '' ?>">
                            <p><?php echo isset($error['email'])? $error['email']: '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <p><?php echo isset($error['password'])? $error['password']: '' ?></p>
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
