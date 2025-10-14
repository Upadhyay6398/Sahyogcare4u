<?php
include("config.php");
include("lock.php");

function generateSlug($string) {
    $string = strtolower(trim($string));
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return rtrim($string, '-');
}

if (isset($_POST['Submit'])) {
    if (!function_exists('sanitizeString') || !function_exists('getProductImageName') || !function_exists('insertKeyWords')) {
        die("Required functions are missing.");
    }

    $name              = ($_POST['name']);
    $description         = ($_POST['description']);
    $meta_title        = ($_POST['meta_title']);
    $meta_description  = ($_POST['meta_description']);
    $meta_keyword      = ($_POST['meta_keyword']);
    $status            = ($_POST['status']);
   $show_home_page = isset($_POST['show_home_page']) ? 1 : 0;
    $slug              = generateSlug($name);
    $image = '';
$middleimage = '';


    if (empty($name)) {
        $error = "Please enter name.";
    } elseif (empty($meta_title)) {
        $error = "Please enter Meta title.";
    } 
    elseif (empty($description)) {
        $error = "Please enter Description.";
    } elseif (empty($meta_description)) {
        $error = "Please enter Meta Description.";
    } elseif (empty($meta_keyword)) {
        $error = "Please enter Meta Keyword.";
    } elseif (!empty($_FILES['image']['name'])) {
        $ext_image = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if (!in_array($ext_image, ['png', 'jpg', 'jpeg'])) {
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
        header("Location: add-category.php");
        exit();
    }

    $tstp = date("d-m-y h:i A"); 

    try {
        $data = [
            'name'             => $name,
            'description'      => $description,
            'slug'             => $slug,
            'meta_title'       => $meta_title,
            'meta_description' => $meta_description,
            'meta_keyword'     => $meta_keyword,
            'image'            => $image,
            'show_home_page'            => $show_home_page,
            'middleimage'       => $middleimage,
            'status'           => $status
           
        ];

        $res = $DB->insert('category', $data);

        if ($res) {
            $_SESSION['msg'] = "Category added successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "Failed to add category.";
            $_SESSION['msg_type'] = "error";
        }
    } catch (Exception $e) {
        $_SESSION['msg'] = "Error: " . $e->getMessage();
        $_SESSION['msg_type'] = "error";
    }

    header("Location: manage-category.php");
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
                                    <label class="col-sm-3 control-label">Category name</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="name" required class="form-control" name="name" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Category Image</label>
                                    <div class="col-sm-6">
                                        <input type="file" id="image" class="form-control" name="image" />
                                        <p class="mt-4" style="font-size:12px;">Only Jpg ,Png and Jpeg are allowed (Maximum Image Size is 300Kb or(1280 × 539))</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Middle Image</label>
                                    <div class="col-sm-6">
                                        <input type="file" id="middleimage" class="form-control" name="middleimage" />
                                        <p class="mt-4" style="font-size:12px;">Only Jpg ,Png and Jpeg are allowed (Maximum Image Size is 300Kb or(1280 × 539))</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Middle Description</label>
                                    <div class="col-sm-6">
                                        <textarea type="text" id="editor1" class="form-control" name="description" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta title</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metatitle" class="form-control" name="meta_title">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Description</label>
                                    <div class="col-sm-6">
                                        <textarea type="text" id="editor2" class="form-control" name="meta_description"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Keyword</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metakeyword" class="form-control" name="meta_keyword">
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
                                
                                 <div class="form-group">
                                    <label class="col-sm-3 control-label">Show on Home Page</label>
  <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="show_home_page">
  
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
   <script src="tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
  tinymce.init({
    selector: '#editor',
    plugins: 'code',
    toolbar: 'code',
    valid_elements: '*[*]',
    extended_valid_elements: 'div[*],script[*],iframe[*]'
  });
  
    tinymce.init({
    selector: '#editor1',
    plugins: 'code',
    toolbar: 'code',
    valid_elements: '*[*]',
    extended_valid_elements: 'div[*],script[*],iframe[*]'
  });
  
   tinymce.init({
    selector: '#editor2',
    plugins: 'code',
    toolbar: 'code',
    valid_elements: '*[*]',
    extended_valid_elements: 'div[*],script[*],iframe[*]'
  });
  
  tinymce.init({
    selector: '#editor3',
    plugins: 'code',
    toolbar: 'code',
    valid_elements: '*[*]',
    extended_valid_elements: 'div[*],script[*],iframe[*]'
  });
  
  tinymce.init({
    selector: '#editor4',
    plugins: 'code',
    toolbar: 'code',
    valid_elements: '*[*]',
    extended_valid_elements: 'div[*],script[*],iframe[*]'
  });
</script>
</body>

</html>