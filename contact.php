<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
 <?php
    if(isset($_POST['contact'])){

       
        $to= "joshadamkerbel@gmail.com";
        $subject = $_POST['subject'];
        $body =$_POST['body'];

        
        // the message
        $msg = $body;

        // use wordwrap() if lines are longer than 70 characters
        $msg = wordwrap($msg,70);

        // send email
        mail($to,$subject,$msg);


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
            
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                    
                      
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Your Subject">
                        </div>
                         <div class="form-group">
                            <textarea class="form-control" name="body" id="body"></textarea>
                        </div>
                
                        <input type="submit" name="contact" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Contact Us">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
