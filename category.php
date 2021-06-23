<?php include "includes/header.php"?>
<?php include "includes/db.php" ?>

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
                $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id AND post_status = 'published' ";
                $select_all_posts_query = mysqli_query($connection, $query);
                $post_count = mysqli_num_rows($select_all_posts_query);

                if($post_count <1){
                    
                        echo "<h2>No Posts in Category</h2>";
                    
                }else{

                while($row = mysqli_fetch_assoc($select_all_posts_query)){
                    $post_id= $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'],0,100);

                    ?>
                     <h1 class="page-header">
                    <?php 
                    $query = "SELECT cat_title FROM categories WHERE cat_id = $post_category_id";
                    $select_category_query = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($select_category_query)){
                        $cat_title = $row['cat_title'];
                    }
                    
                    echo $cat_title;
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

                <?php }} }?>
           

                


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

        