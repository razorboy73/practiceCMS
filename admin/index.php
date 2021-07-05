
<?php include "includes/admin-header.php"; ?>

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
                           Administrative User Interface
                            <small> <?php 
                           
                           echo strtoupper(get_user_name());
                            
                            ?></small>
                           
                        </h1>
                        
                    </div>
                </div>
                <!-- /.row -->
                       
                <!-- /.row -->
                
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                        <?php
                       
                        $post_counts = recordCount("posts WHERE post_status = 'published' AND post_author = '$_SESSION[username]' ");
                
                        echo "<div class='huge'>{$post_counts}</div>";

                        ?>
                  
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                        <div class="col-xs-9 text-right">
                        <?php
                        
                        $comment_counts = recordCount("comments WHERE comment_status = 'approved'AND comment_author = '$_SESSION[username]'");
                        echo "<div class='huge'>{$comment_counts}</div>"
                        ?>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                       
                        $user_counts = recordCount("users WHERE user_role = 'admin' AND username = '$_SESSION[username]'");
                        echo "<div class='huge'>{$user_counts}</div>"
                        ?>
                    <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                       
                        $category_counts = recordCount("categories");
                        echo "<div class='huge'>{$category_counts}</div>"
                        ?>
                        
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
                <!-- /.row -->

                <!--gathering counts ll posts, draft posts, unapproved comments, subscribers-->
                <?php
                $query = "SELECT * FROM posts WHERE post_author = '$_SESSION[username]'";
                $select_all_posts = mysqli_query($connection, $query);
                $post_all_posts_counts = mysqli_num_rows($select_all_posts);
               
               
                $post_draft_counts = checkStatus('posts', 'post_status', 'draft', 'post_author', $_SESSION['username']);
             
                
                $unapproved_comment_counts = checkStatus('comments', 'comment_status', 'unapproved','comment_author', $_SESSION['username']);
                
             
                 $subscriber_counts = checkStatus('users', 'user_role', 'subscriber','username', $_SESSION['username']);


                ?>





                <div class="row">

                
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Count',],



          <?php

          $element_text = ["All Posts","Active Posts", "Drafts", "Comments", "Unapproved Comments", "Admin", "Subscribers", "Categories",];
          $element_count =[$post_all_posts_counts, $post_counts, $post_draft_counts, $comment_counts, $unapproved_comment_counts, $user_counts,  $subscriber_counts, $category_counts];

          for($i = 0; $i <8; $i++){

            echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";

          }

          ?>
      
        ]);

        var options = {
          chart: {
            title: 'Content Statistics',
            subtitle: 'Posts, Comments, User, and Categories',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>


                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
        <?php include "includes/admin-footer.php"; ?>