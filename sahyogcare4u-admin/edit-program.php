<?php
include("config.php");
include("lock.php");

$program_id  = cleanId($_GET['id']);
$program     = $DB->getRowById('programs', $program_id);

if (empty($program['id'])) {
    header("Location: manage-program.php");
    exit();
}

if (isset($_POST['Submit'])) {

    // Function to create a slug
    function createSlug($string)
    {
        $slug = strtolower(trim($string));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }

    // Sanitize input values
    
    
    $subprogramtitle = ($_POST['subprogramtitle']);
    $subprogramdescription = ($_POST['subprogramdescription']);
      $metatitle=($_POST['metatitle']);
    $metadescription=$_POST['metadescription'];
    $metakeyword=$_POST['metakeyword'];
    $status = ($_POST['status']);
    $category_id = ($_POST['category_id']);

    $error = "";
  
    $subprogramimage = $program['subprogramimage'];  // Default value, in case no new file is uploaded

    // Validation
    if (empty($subprogramtitle)) {
        $error = "Please Sub Program Title";
    } 

    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }


   

    // Handle subprogram image upload
    if (!empty($_FILES['subprogramimage']['name'])) {
        $ext = strtolower(pathinfo($_FILES['subprogramimage']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['png', 'jpg', 'jpeg'])) {
            $error = "Only PNG, JPG, and JPEG images are allowed for subprogramimage.";
        } elseif ($_FILES['subprogramimage']['size'] > 300000) {
            $error = "Maximum subprogramimage size allowed is 300KB.";
        } else {
            $subprogramimage = $upload_dir . uniqid() . "_" . basename($_FILES['subprogramimage']['name']);
            if (!move_uploaded_file($_FILES['subprogramimage']['tmp_name'], $subprogramimage)) {
                $error = "Failed to upload subprogramimage.";
            }
        }
    }


     // Subprogram Banner Image
    if (!empty($_FILES['subprogrambanner']['name'])) {
        $ext_image = strtolower(pathinfo($_FILES['subprogrambanner']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext_image, ['png', 'jpg', 'jpeg'])) {
            $error = "Only PNG, JPG, JPEG images are allowed.";
        } elseif ($_FILES['subprogrambanner']['size'] > 3000000) {
            $error = "Maximum subprogrambanner size allowed is 300KB.";
        } else {
            $subprogrambanner = "uploads/" . time() . "_" . basename($_FILES['subprogrambanner']['name']);
            if (!move_uploaded_file($_FILES['subprogrambanner']['tmp_name'], $subprogrambanner)) {
                $error = "Failed to upload subprogrambanner.";
            }
        }
    }
    if (!empty($error)) {
        $_SESSION['msg'] = $error;
        $_SESSION['msg_type'] = "error";
        header("Location: edit-program.php?id=$program_id");
        exit();
    }

    // Create slug from program name or subprogram title
    $slug = createSlug($subprogramtitle);  // You can adjust the field to use for slug generation

    $tstp = date("Y-m-d H:i:s");

    try {
        // Prepare data for update
        $data = [

            'subprogramtitle' => $subprogramtitle,
            'subprogramdescription' => $subprogramdescription,
            'subprogramimage' => $subprogramimage,
            'status' => $status,
            'category_id' => $category_id,
            'subprogrambanner'=>$subprogrambanner,
            'metatitle'=>$metatitle,
            'metadescription'=>$metadescription,
            'metakeyword'   =>$metakeyword,
            'slug' => $slug
        ];

        $res = $DB->update('programs', $data, $program_id);

        if ($res) {
            $_SESSION['msg'] = "Program updated successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "Failed to update Program.";
            $_SESSION['msg_type'] = "error";
        }
    } catch (Exception $e) {
        $_SESSION['msg'] = "Error: " . $e->getMessage();
        $_SESSION['msg_type'] = "error";
    }

    header("Location: edit-program.php?id=$program_id");
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= DEFAULT_TITLE ?> | Update  Program Sub Category</title>
    <?php
    include("include/head.php");
    ?>
    <script type="text/javascript" src="assets/widgets/parsley/parsley.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
</head>

<body>
    <?php
    include("include/header.php");
    include("include/sidebar.php");
    ?>


    <div id="page-content-wrapper">
        <div id="page-content">
            <div id="page-title">
                <h2>Update Program Sub Category</h2>
            </div>

            <?php include("include/message.php"); ?>

            <div class="col-md-7">
                <div class="panel">

                    <div class="panel-heading">
                        <h4 class="panel-title">Update Program Sub Category</h4>
                    </div>

                    <div class="panel-body">

                        <div class="example-box-wrapper">
                            <form class="form-horizontal bordered-row" enctype="multipart/form-data" id="change-laverage-form" method="post" data-parsley-validate="">
                                 <div class="form-group">
                                    <label class="col-sm-3 control-label">Category Name</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" required id="status" name="category_id">
                                            <option value="">Select Category</option>
                                            <?php
                                            // Fetch all categories
                                            $sql = "SELECT id, name FROM category";
                                            $stmt = $DB->DB->prepare($sql);
                                            $stmt->execute();
                                            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            $selected_category = $program['category_id'] ?? '';  // Make sure this is 'category_id' if it's stored in the DB as such

                                            if ($rows) {
                                                foreach ($rows as $row) {
                                                    // Compare category_id with selected_category
                                                    $selected = ($row['id'] == $selected_category) ? 'selected' : '';
                                                    echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['name'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No categories found</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Sub Program Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="subprogramtitle" class="form-control" name="subprogramtitle" required value="<?php echo $program['subprogramtitle'];?>">
                                    </div>
                                </div>
                            <div class="form-group">
                                    <label class="col-sm-3 control-label">Sub Program Banner Image</label>
                                    <div class="col-sm-6">
                                        <input type="file" id="image" class="form-control" name="subprogrambanner" />
                                        <?php if (!empty($program['subprogrambanner'])): ?>
                                            <img src="<?= BASE_URL . $program['subprogrambanner']; ?>" alt="Sub program Image" width="100" height="100"><br>
                                             <p class="mt-4" style="font-size:12px;">Only Jpg ,Png and Jpeg are allowed (Maximum Image Size is 300Kb or(1280 × 539))</p>
                                            <a href="<?= BASE_URL . $program['subprogrambanner']; ?>" target="_blank">View </a>
                                        <?php else: ?>
                                            <br>
                                            <strong>
                                                <p>No Image available</p>
                                            </strong>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Sub Program Image</label>
                                    <div class="col-sm-6">
                                        <input type="file" id="image" class="form-control" name="subprogramimage" />
                                        <?php if (!empty($program['subprogramimage'])): ?>
                                            <img src="<?= BASE_URL . $program['subprogramimage']; ?>" alt="Sub program Image" width="100" height="100"><br>
                                             <p class="mt-4" style="font-size:12px;">Only Jpg ,Png and Jpeg are allowed (Maximum Image Size is 300Kb or(1280 × 539))</p>
                                            <a href="<?= BASE_URL . $program['subprogramimage']; ?>" target="_blank">View </a>
                                        <?php else: ?>
                                            <br>
                                            <strong>
                                                <p>No Image available</p>
                                            </strong>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Sub Program Description</label>
                                    <div class="col-sm-6">
                                        <textarea type="text" id="editor1" class="form-control" name="subprogramdescription" required><?php echo $program['subprogramdescription'];?></textarea>
                                    </div>
                                </div>  
                                  <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Title</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="netatitle" class="form-control" name="metatitle" value="<?php echo $program['metatitle'];?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Description</label>
                                    <div class="col-sm-6">
                                        <textarea type="text" id="metadescription" class="form-control" name="metadescription" required><?php echo $program['metadescription'];?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Keyword</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metakeyword" class="form-control" name="metakeyword" required value="<?php echo $program['metakeyword'];?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" required id="status" name="status">
                                            <option value="1" <?= ($program['status'] == 1 ? $selected : '') ?>>Enable</option>
                                            <option value="2" <?= ($program['status'] == 2 ? $selected : '') ?>>Disable</option>
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