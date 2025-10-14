<?php
include("config.php");
include("lock.php");



if (isset($_POST['Submit'])) {

    $status            = sanitizeString($_POST['status']);
    $priority            = sanitizeString($_POST['priority']);
    $image = '';

   if (!empty($_FILES['image']['name'])) {
        $ext_image = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if (!in_array($ext_image, ['png', 'jpg', 'jpeg','webp'])) {
            $error = "Only PNG, JPG, JPEG images are allowed.";
        } elseif ($_FILES['image']['size'] > 300000) {
            $error = "Maximum image size allowed is 300KB.";
        } else {
            $image = "uploads/" . time() . "_" . basename($_FILES['image']['name']);
            
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
                $error = "Failed to upload image.";
            }
        }
    }
    // Middle  Image
    if (!empty($_FILES['middleimage']['name'])) {
        $ext_image = strtolower(pathinfo($_FILES['middleimage']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext_image, ['png', 'jpg', 'jpeg'])) {
            $error = "Only PNG, JPG, JPEG images are allowed.";
        } elseif ($_FILES['middleimage']['size'] > 300000) {
            $error = "Maximum middleimage size allowed is 300KB.";
        } else {
            $middleimage = "uploads/" . time() . "_" . basename($_FILES['middleimage']['name']);
            if (!move_uploaded_file($_FILES['middleimage']['tmp_name'], $middleimage)) {
                $error = "Failed to upload middleimage.";
            }
        }
    }


    if (!empty($error)) {
        $_SESSION['msg'] = $error;
        $_SESSION['msg_type'] = "error";
        header("Location: add-slider.php");
        exit();
    }

    $tstp = date("d-m-y h:i A"); 

    try {
        $data = [
            
            'image'            => $image,
            'priority'          =>$priority,
            'status'           => $status
           
        ];

        $res = $DB->insert('slider', $data);

        if ($res) {
            $_SESSION['msg'] = "Slider added successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "Failed to add Slider.";
            $_SESSION['msg_type'] = "error";
        }
    } catch (Exception $e) {
        $_SESSION['msg'] = "Error: " . $e->getMessage();
        $_SESSION['msg_type'] = "error";
    }

    header("Location: manage-slider.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= DEFAULT_TITLE ?> | Add Category</title>
    <?php
    include("include/head.php");
    ?>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>




    <script type="text/javascript" src="assets/widgets/parsley/parsley.js"></script>
</head>

<body>
    <?php
    include("include/header.php");
    include("include/sidebar.php");
    ?>


    <div id="page-content-wrapper">
        <div id="page-content">
            <div id="page-title">
                <h2>Add Category </h2>
            </div>

            <?php include("include/message.php"); ?>

            <div class="col-md-7">
                <div class="panel">

                    <div class="panel-heading">
                        <h4 class="panel-title">Add category</h4>
                    </div>

                    <div class="panel-body">

                        <div class="example-box-wrapper">
                            <form class="form-horizontal bordered-row" enctype="multipart/form-data" id="change-laverage-form" method="post" data-parsley-validate="">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Slider Image</label>
                                    <div class="col-sm-6">
                                        <input type="file" id="image" class="form-control" name="image" />
                                        <p class="mt-4" style="font-size:12px;">Only Jpg ,Png and Jpeg are allowed (Maximum Image Size is 300Kb or(1280 × 539))</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Priority</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="priority" required class="form-control" name="priority" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" required id="status" name="status">
                                            <option value="1" selected>Enable</option>
                                            <option value="2">Disable</option>
                                        </select>
                                    </div>
                                </div>
                                

                                <div class=" text-center pad20A ">
                                    <input type="submit" class="btn btn-success" name="Submit" value="Confirm" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>



        </div>
    </div>
    <?php
    include("include/footer-js.php");
    ?>
<script>
  ClassicEditor
    .create(document.querySelector('#editor1'))
    .catch(error => {
      console.error(error);
    });

  ClassicEditor
    .create(document.querySelector('#editor2'))
    .catch(error => {
      console.error(error);
    });
</script>


</body>

</html>