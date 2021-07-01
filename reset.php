<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<?php  include "includes/navigation.php"; ?>
</nav>

<?php
$verified = false;
if(!isset($_GET['email']) && !isset($_GET['token'])){

    redirect('index.php');
}


//$email = 'joshadamkerbel@gmail.com';
//$token = 'a27e1f579c75543908d1b7a95597344c3adf690e913b5b40f4adca28e65304e969b6eac982545a4a927e59eda0cdebc852db';
if($stmt = mysqli_prepare($connection, 'SELECT username, user_email, token FROM users WHERE token = ?')){

    mysqli_stmt_bind_param($stmt, "s", $_GET['token']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $username, $email, $token);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    //echo $username;

    /* if($_GET['token'] !== $token || $_GET['email'] !== $email){
        redirect('index');
    }
     */
   
}
if(isset($_POST['password']) && isset($_POST['confirmPassword'])){
    if ($_POST['password']===$_POST['confirmPassword']){
        echo "The passwords match";
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
        
        if($stmt = mysqli_prepare($connection, "UPDATE users SET token = '', user_password = '{$hashedPassword}' WHERE user_email= ?")){

            mysqli_stmt_bind_param($stmt, 's', $_GET['email']);
            mysqli_stmt_execute($stmt);

            if(mysqli_stmt_affected_rows($stmt)>=1){

                redirect('/cms/login.php');
            }
            mysqli_stmt_close($stmt);
           


        }else{
            echo "Bad query";
        }
   
    }
}

?>



<!-- Page Content -->
<div class="container">



    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">


                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                            <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>

                            </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<hr>

<?php include "includes/footer.php";?>

</div> <!-- /.container -->