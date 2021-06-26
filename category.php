<?php include "includes/header.php"?>
<?php include "includes/db.php" ?>
<?php include "./admin/functions.php" ?>
<?php session_start();?>


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
            if(isset($_GET['category'])){
                $post_category_id = $_GET['category'];

                if(is_admin($_SESSION['username'])){
                $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ?");
                
                }else{
                $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ?");
                $published = 'published';
            }

                if(isset($stmt1)){
                    mysqli_stmt_bind_param($stmt1, "i", $post_category_id);
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                    $stmt = $stmt1;
                }else{
                    mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                    $stmt = $stmt2;
                }


                

                $post_count = mysqli_stmt_num_rows($stmt);
                echo $post_count;

                if($post_count == 0){
                    
                        echo "<h2>No Posts in Category</h2>";
                    
                }

                while(mysqli_stmt_fetch($stmt)):
                  

                    ?>
                     <h1 class="page-header">
                    <?php 
                    // $query = "SELECT cat_title FROM categories WHERE cat_id = $post_category_id";
                    // $select_category_query = mysqli_query($connection, $query);
                    // while($row = mysqli_fetch_array($select_category_query)){
                    //     $cat_title = $row['cat_title'];
                    // }
                    
                    // echo $cat_title;
                    ?>
                    <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id?>"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                    <hr>
                    <a href="post.php?p_id=<?php echo $post_id?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""></a>
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>

                <?php endwhile;} else{
                    header("Location: index.php");
                }
                         
                            ?>
           

                


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

        