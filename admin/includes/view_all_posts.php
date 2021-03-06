<?php

include("delete_modal.php");
    if(isset($_POST['checkBoxArray'])){


        //foreach($_POST['checkBoxArray'] as  $checkBoxValue){
               
         $bulk_options = $_POST['bulk_options'];
            //print_r($_POST['checkBoxArray']);
        //}

            switch($bulk_options){

               case "published":
                    foreach($_POST['checkBoxArray'] as $post_id){
                        $query = "UPDATE posts SET ";
                        $query .= "post_status = '{$bulk_options}' ";
                        $query .= "WHERE post_id = '{$post_id}'";
                        $update_post_status = mysqli_query($connection, $query);

                    confirmQuery($update_post_status);
                    }
                    echo "<p class='well bg-success'>Posts Updated To Publish</p>";
                
                break;
                
               case "draft":
                    foreach($_POST['checkBoxArray'] as $post_id){
                        $query = "UPDATE posts SET ";
                        $query .= "post_status = '{$bulk_options}' ";
                        $query .= "WHERE post_id = {$post_id}";
                        $update_post_status  = mysqli_query($connection, $query);

                    confirmQuery($update_post_status);
                    }
                    echo "<p class='well bg-success'>Posts Updated To Draft</p>";
                
             break;

                case "clone":
                foreach($_POST['checkBoxArray'] as $post_id){    
                    $query = "SELECT * FROM posts WHERE post_id = {$post_id} ";
                    $select_post_query = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_array($select_post_query)){

                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_category_id = $row['post_category_id'];
                        $post_status = $row['post_status'];
        
                        $post_image = $row['post_image'];
                        
                
                        $post_tags = $row['post_tags'];
                        $post_content = $row['post_content'];
                        $post_date = date('d-m-y');
                        $post_comment_count = 0;
                
                       
                
                        $query = "INSERT into posts(post_category_id,post_title,post_author,post_date,post_image,post_content,post_tags,post_comment_count,post_status) ";
                        $query .= "VALUE({$post_category_id},'Copy of {$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}',0,'draft') ";
                
                
                        $create_copy_query = mysqli_query($connection, $query);
                
                        confirmQuery($create_copy_query);
                
                    }
                }
                       
                        echo "<div class='well'>Post Copied</div>";
                
                

             break;
               case "delete":
                foreach($_POST['checkBoxArray'] as $post_id){
                    $query = "DELETE from posts WHERE ";
                    $query .= "post_id = {$post_id}";
                    $update_post_status = mysqli_query($connection, $query);

                confirmQuery($update_post_status);
                }
                echo "<p class='well bg-success'>Post(s) Deleted</p>";
            
                break;
            }
     }
        
    
?>




<form action="" method='post'>
    <table class="table table-bordered table-hover">

        <div id="bulkOptionsContainer" class="col-xs-4">

            <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="clone">Clone</option>
            <option value="delete">Delete</option>

            </select>
        </div>
         <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New Post</a>

         </div>
         
         
            <thead>
                <tr>
                <th> <input id="selectAllBoxes" type="checkbox"> </th>
                <th>ID</th>
                <th>Author</th>
                 <th>Title (click to view)</th>
                 <th>Category</th>
                  <th>Status</th>
                 <th>Image</th>
                  <th>Tags</th>
                   <th>Comments</th>
                    <th>Date</th>
                    
                    <th>Edit</th>
                     <th>Delete</th>
                     <th>Views (click to reset views)</th>
                
                                    
                                </tr>
                            </thead>
                        
                            <tbody>
                            <?php

                            $user = currentUser();
                             
                              $query = "SELECT posts.post_id, posts.post_title, posts.post_author, posts.post_category_id, posts.post_status, posts.post_image, ";
                              $query .= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title ";
                              $query .= "FROM posts ";
                              $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id WHERE post_author = '$user' ORDER BY posts.post_id DESC";
                              $select_posts = mysqli_query($connection, $query);
                          
                              while($row = mysqli_fetch_assoc($select_posts)){
                                    $post_id = $row['post_id'];
                                    $post_title = $row['post_title'];
                                    $post_author = $row['post_author'];
                                    $post_category_id = $row['post_category_id'];
                                    $post_status = $row['post_status'];
                                    $post_image = $row['post_image'];
                                    $post_tags = $row['post_tags'];
                                    $post_comments = $row['post_comment_count'];
                                    $post_date = $row['post_date'];
                                    $post_views_count = $row['post_views_count'];
                                    $category_title = $row['cat_title'];
                                    $category_id = $row['cat_id'];


                                    echo "<tr>";
                                    ?>

                                    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>

                                    <?php
                                    echo "<td>{$post_id}</td>";
                                    echo "<td>{$post_author}</td>";
                                    echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";

                                

                                    echo "<td>{$category_title}</td>";
                                    


                                    echo "<td>{$post_status}</td>";
                                    echo "<td ><img width='100' src='../images/{$post_image}' alt='images'</td>";
                                    echo "<td>{$post_tags}</td>";

                                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                                    $send_comment_query = mysqli_query($connection, $query);
                                    $row = mysqli_fetch_array($send_comment_query);
                                    $post_comment_count = mysqli_num_rows($send_comment_query);

                                    if($post_comment_count >0){
                                        $comment_id  = $row['comment_id'];

                                    echo "<td><a href ='post_comments.php?id=$post_id'>{$post_comment_count}</a></td>";
                                    }else{
                                       echo "<td>{$post_comment_count}</td>";
                                    }

                                    echo "<td>{$post_date}</td>";
                                    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";

                                        ?>

                                        <form method="post" action="">
                                            <input type="hidden" name ="post_id" value="<?php echo $post_id?>">
                                        <?php
                                           echo '<td><input class= "btn btn-danger" type="submit" name="delete" value = "Delete"></td>';
                                        ?>
                                        
                                        </form>
                                        <?php


                                    //echo "<td><a  rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
                                    echo "<td><a href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
                                    echo "</tr>";
                              }

                            ?>

                                


                                   
                            
                            </tbody>
                        </table>
</form>

                        <?php
                          if(isset($_POST['delete'])){  
                            $the_post_id = $_POST['post_id'];
                    
                            $query = "DELETE from posts WHERE post_id = {$the_post_id} ";
                            $delete_query = mysqli_query($connection, $query);
                            header("Location: posts.php");
                          }
                      
                        ?>
                         <?php
                          if(isset($_GET['reset'])){  
                            $the_post_id = $_GET['reset'];
                    
                            $query = "UPDATE posts SET post_views_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $_GET['reset']) ." ";
                            $delete_query = mysqli_query($connection, $query);
                            header("Location: posts.php");
                          
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


        <script>
        $(document).ready(function(){

            $(".delete_link").on('click', function(){
                var id = $(this).attr("rel");
                var delete_url = "posts.php?delete=" + id + " ";

                $(".modal_delete_link").attr("href", delete_url);

                $("#myModal").modal('show')
            })

            });
        
        </script>