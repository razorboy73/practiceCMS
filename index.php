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
            <h1 class="page-header">
                    Page
                    <small>Secondary Text</small>
            </h1>

                <?php
                  $per_page=7;

                 if(isset($_GET['page'])){
                  
                   
                    $page= $_GET['page'];

                 }else{
                    $page = "";
                     }
                if($page == "" || $page ==1){
                        $page_1 = 0;
                }else {
                    $page_1 = ($page *$per_page)-$per_page;
                }

                $select_post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
                $find_count = mysqli_query($connection, $select_post_query_count);
                $count = mysqli_num_rows($find_count);

                echo $count = ceil($count/$per_page);
                
                   
                
                $query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $page_1, $per_page";
                $select_all_posts_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_all_posts_query)){
                        $post_id= $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'],0,100);
                        $post_status = $row['post_status'];

                        if($post_status == 'published'){

                    }
                    ?>
                  

                    <!-- First Blog Post -->
                            <h2>
                                <a href="post.php?p_id=<?php echo $post_id?>"><?php echo $post_title ?></a>
                            </h2>
                            <p class="lead">
                                by <a href="author_posts.php?author=<?php echo $post_author?>&p_id=<?php echo $post_id?>"><?php echo $post_author ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                            <hr>
                            <a href="post.php?p_id=<?php echo $post_id?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""></a>
                            <hr>
                            <p><?php echo $post_content ?></p>
                            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                            <hr>

                <?php }  ?>
           
         
                


            </div>

            <!-- Blog Sidebar Widgets Column -->
         <div class="col-md-4">
            <?php include "includes/sidebar.php"?>

            </div>

        </div>
        <!-- /.row -->

        <hr>
        <ul class="pager">
        <?php
        for($x=1; $x<=$count; $x++){


        if($x==$page){
            echo "<li><a class='active_link' href='index.php?page={$x}'>{$x}</a></li>";
        }else{
            echo "<li><a href='index.php?page={$x}'>{$x}</a></li>";
             }
        }
          ?>              
        </ul>
        <!-- Footer -->
        <?php include "includes/footer.php"?>

        