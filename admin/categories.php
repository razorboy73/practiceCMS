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
                           Welcome to Admin Island
                            <small>Author</small>
                        </h1>
                        <div class="col-xs-6">

            <?php

                    insert_categories();
            ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat-title">Add Category</label>
                                <input type="text" class="form-control" name="cat_title">
                            </div>
                            <div class="form-group">
                                <input class ="btn btn-primary" type="submit" name="submit" value="Add Category">
                            </div>
                            
                            
                        </form>

                        <?php // update and include query

                        if(isset($_GET['edit'])){
                            $cat_id = $_GET["edit"];

                            include "includes/update-categories.php";

                        }

                        ?>

                        </div><!-- Add category form -->
                        <div class="col-xs-6">


                       
                            <table class="table table-border table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php //Find All Categories
                                
                                findAllCategories();
                               
                    

                            //Delete Query

                            deleteCategories();
                             
                            ?>


                                
                                
                                
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
        <?php include "includes/admin-footer.php"; ?>