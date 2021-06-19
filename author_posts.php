<?php include "includes/header.php"?>
<?php include "includes/db.php" ?>
<?php session_start(); ?>


    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <?php include "includes/navigation.php"?>
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">


            <?php 
                if(isset($_GET['author']))
                    $post_id = $_GET["p_id"];
                    $post_author = $_GET["author"];
            ?>

          
                <h1 class="page-header">
                    All posts by <?php echo $post_author ?>
                    <small>Secondary Text</small>
                </h1>


                <?php

                $query = "SELECT * FROM posts WHERE post_author = '$post_author' AND  post_status = 'published'";
                $select_all_posts_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_all_posts_query)){
   
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];

                    ?>

                    <!-- First Blog Post -->
                <h2>
                <a href="post.php?p_id=<?php echo $post_id?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                by <?php echo $post_author ?>        
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
               

                <hr>

                <?php }  ?>


                <!-- Blog Comments -->

                <?php

                if(isset($_POST['create_comment'])){

                    $the_post_id = $_GET["p_id"];
                    $comment_author = $_POST['comment_author'];
                    $comment_email =  $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];

                    if(!empty($comment_author)&&!empty($comment_email)&&!empty($comment_content)){

                        $query = "INSERT into comments(comment_post_id,comment_author,comment_email,comment_content,comment_status,comment_date) ";
                        $query .= "VALUE({$the_post_id},'{$comment_author}','{$comment_email}','{$comment_content}','unapproved',now()) ";


                        $create_comment_query = mysqli_query($connection, $query);

                            if(!$create_comment_query){
                                die('Query Failed: ' . mysqli_error($connection));
                            }

                        $query = "UPDATE posts SET post_comment_count = post_comment_count +1 WHERE post_id = $the_post_id";
                        $update_comment_query = mysqli_query($connection, $query);

                        if(!$update_comment_query){
                            die('Query Failed: ' . mysqli_error($connection));
                        }

                    }else{
                            //echo "<div class='well'><b>These fields can't be blank</b></div>";
                            echo "<script>alert('Comment Fields Cannot Be Blank')</script>";
                        
                        }
                      


                        
                    }




                    

                    ?>





               

               

                        


                 


                <!-- Comment -->
               



            </div>

            <!-- Blog Sidebar Widgets Column -->
         <div class="col-md-4">
            <?php include "includes/sidebar.php"?>

            </div>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php include "includes/footer.php"?>

         