<?php include("templates/header.php");?>
    <section class="slider-content-area py-4 px-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <ul class="nav nav-tabs" id="sliderTab" role="tablist">

                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="all-slider" data-bs-toggle="tab" href="#slider-home" role="tab" aria-controls="slider-home" aria-selected="true">All Slider</a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="addnew-slider" data-bs-toggle="tab" href="#addnewslider" role="tab" aria-controls="addnewslider" aria-selected="false">Add New</a>
                        </li>

                    </ul>

                    <div class="tab-content" id="sliderTabContent">

                        <div class="tab-pane fade show active" id="slider-home" role="tabpanel" aria-labelledby="all-slider">

                            <table class="table table-bordered border-success table-sm mt-3">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="5%">Image</th>
                                        <th width="20%">Title</th>
                                        <th width="55%">Description</th>
                                        <th width="5%">Author</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $show_query = "SELECT*FROM sliders";
                                        $show_result = mysqli_query($db, $show_query);

                                        if(mysqli_num_rows($show_result) > 0){
                                            while($show = mysqli_fetch_assoc($show_result)){
                                                echo '
                                                    <tr>
                                                        <td width="5%">'.$show['slider_id'].'</td>

                                                        <td width="5%"><img src="assets/images/sliders/'.$show['slider_img'].'" width="100" height="100"></td>

                                                        <td width="20%">'.$show['slider_title'].'</td>

                                                        <td width="55%">'.$show['slider_des'].'</td>

                                                        <td width="5%">'.$show['created_by'].'</td>

                                                        <td class="text-center" width="10%">
                                                ';       
                                                            
                                                
                                                if($_SESSION['user_role'] == 'admin'){
                                                    echo '
                                                        <a href="" class="btn btn-outline-info btn-sm"><i class="far fa-eye"></i></a>

                                                        &nbsp;

                                                        <a href="update.php?update_slide='.$show['slider_id'].'" class="btn btn-outline-warning btn-sm"><i class="far fa-edit"></i></a>

                                                        &nbsp;

                                                        <a href="'.$template_path.'.php?delete_slide='.$show['slider_id'].'" class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                                    ';
                                                }elseif($_SESSION['user_role'] == 'editor'){
                                                    echo '
                                                        <a href="" class="btn btn-outline-info btn-sm"><i class="far fa-eye"></i></a>

                                                        &nbsp;

                                                        <a href="update.php?update_slide='.$show['slider_id'].'" class="btn btn-outline-warning btn-sm"><i class="far fa-edit"></i></a>
                                                    ';
                                                }else{
                                                    echo '
                                                        <a href="" class="btn btn-outline-info btn-sm"><i class="far fa-eye"></i></a>
                                                    ';
                                                }
                                                            
                                                echo'        
                                                        </td>
                                                    </tr>
                                                ';
                                            }
                                        }else{
                                            echo '
                                                <tr>
                                                    <td colspan="6" class="text-center text-danger">No data found!!</td>
                                                </tr>
                                            ';
                                        }
                                    ?>
                                    
                                </tbody>
                            </table>
                            
                        </div>

                        <div class="tab-pane fade" id="addnewslider" role="tabpanel" aria-labelledby="addnew-slider">

                            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data" class="mt-3">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="slider_title" class="form-label">Title</label>
                                            <input type="text" name="slider_title" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="slider_img" class="form-label">Image</label>
                                            <input type="file" name="slider_img" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="slider_des" class="form-label">Example textarea</label>
                                            <textarea class="form-control" rows="3" name="slider_des" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" name="create_slider" class="btn btn-outline-success btn-lg">Add slider</button>
                                    </div>
                                </div>
                                
                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

    <?php

        // Slide Insert
        if(isset($_POST['create_slider'])){

            $sl_title   = $_POST['slider_title'];
            $sl_des     = $_POST['slider_des'];
            $created_by = $_SESSION['username'];

            // Upload image to dist folder
            $sl_img     = $_FILES['slider_img']['name'];
            $sl_img_tmp = $_FILES['slider_img']['tmp_name'];
            move_uploaded_file($sl_img_tmp, "assets/images/sliders/$sl_img");

            insertSlide($sl_title, $sl_img, $sl_des, $created_by, $con);
        }

        if(isset($_GET['delete_slide'])){
            $slide_id = $_GET['delete_slide'];

            deleteSlide($con, $slide_id);
        }
    ?>
<?php include("templates/footer.php"); ?>