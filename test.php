<?php include "includes/header.php"?>
<?php include "includes/db.php" ?>
<?php session_start(); ?>
<?php
echo loggedInUserID();

if(userLikedThisPost(136)){
    echo "User Like It";
}else{
    echo "user did not like it";
}
?>


   <!-- Footer -->
   <?php include "includes/footer.php"?>