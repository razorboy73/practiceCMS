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
                           Posts
                            <small>Poster</small>
                        </h1>
                            <?php
                                if(isset($_GET['source'])){
                                    $source = $_GET['source'];
                                }else{
                                    $source = " ";
                                }

                                switch($source){
                                    case 'add_post';
                                    include "includes/add_post.php";
                                    break;

                                    case 'edit_post';
                                    include 'includes/edit_post.php';
                                    break;

                                    case '36';
                                    echo 'nice 36';
                                    break;

                                    default:
                                    include "includes/view_all_posts.php";
                                }

                              
                            ?>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
        <?php include "includes/admin-footer.php"; ?>