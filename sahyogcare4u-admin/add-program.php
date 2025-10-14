<?php
include('config.php');
include('lock.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['Submit'])) {

    function createSlug($string)
    {
        $slug = strtolower(trim($string));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }
    $subprogramtitle = ($_POST['subprogramtitle']);
    $subprogramdescription = ($_POST['subprogramdescription']);
    $status = ($_POST['status']);
    $category_id = ($_POST['category_id']);
    $metatitle=($_POST['metatitle']);
    $metadescription=$_POST['metadescription'];
    $metakeyword=$_POST['metakeyword'];


    $slug = createSlug($subprogramtitle);
    $subprogramimage = "";

    // Validation
    if (empty($subprogramtitle)) {
        $error = "Please enter Sub Program Title.";
    } elseif (empty($subprogramdescription)) {
        $error = "Please enter Sub Program Description.";
    }  
    // Subprogram Image
    if (!empty($_FILES['subprogramimage']['name'])) {
        $ext_image = strtolower(pathinfo($_FILES['subprogramimage']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext_image, ['png', 'jpg', 'jpeg'])) {
            $error = "Only PNG, JPG, JPEG images are allowed.";
        } elseif ($_FILES['subprogramimage']['size'] > 3000000) {
            $error = "Maximum subprogramimage size allowed is 300KB.";
        } else {
            $subprogramimage = "uploads/" . time() . "_" . basename($_FILES['subprogramimage']['name']);
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

    // Error redirect
    if (!empty($error)) {
        $_SESSION['msg'] = $error;
        $_SESSION['msg_type'] = "error";
        header("Location: add-program.php");
        exit();
    }

    $tstp = date("d-m-y h:i A");

    try {
        $data = [
         
          
            'subprogramtitle' => $subprogramtitle,
            'subprogramdescription' => $subprogramdescription,
            'subprogramimage' => $subprogramimage,
            'status' => $status,
            'category_id' => $category_id,
            'metatitle'     =>$metatitle,
            'subprogrambanner'=>$subprogrambanner,
            'metadescription'=>$metadescription,
            'metakeyword'   =>$metakeyword,
            'slug' => $slug
         
        ];

        $res = $DB->insert('programs', $data);

        if ($res) {
            $_SESSION['msg'] = "Program added successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "Failed to add program.".$e->getMessage();;
            $_SESSION['msg_type'] = "error";
        }
    } catch (Exception $e) {
        $_SESSION['msg'] = "Error: " . $e->getMessage();
        $_SESSION['msg_type'] = "error";
    }

    header("Location: manage-program.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= DEFAULT_TITLE ?> | Add Programs Sub Category</title>
    <?php
    include("include/head.php");
    ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
                <h2>Add Programs Sub Category</h2>
            </div>

            <?php include("include/message.php"); ?>

            <div class="col-md-7">
                <div class="panel">

                    <div class="panel-heading">
                        <h4 class="panel-title">Add Programs Sub Category</h4>
                    </div>

                    <div class="panel-body">

                        <div class="example-box-wrapper">
                            <form class="form-horizontal bordered-row" enctype="multipart/form-data" id="change-laverage-form" method="post" data-parsley-validate="">
                                 <div class="form-group">
                                    <label class="col-sm-3 control-label">Category Name</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="status" name="category_id" required>
                                            <option value="">Select Category</option>
                                            <?php
                                            $sql = "SELECT id, name FROM category";
                                            $stmt = $DB->DB->prepare($sql);
                                            $stmt->execute();
                                            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            if ($rows) {
                                                foreach ($rows as $row) {
                                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
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
                                        <input type="text" id="subprogramtitle" class="form-control" name="subprogramtitle" required>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-3 control-label">Sub Program Banner Image</label>
                                    <div class="col-sm-6">
                                        <input type="file" id="subprogrambanner" class="form-control" name="subprogrambanner" required/>
                                        <p class="mt-4" style="font-size:12px;">Only Jpg ,Png and Jpeg are allowed (Maximum Image Size is 300Kb)</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Sub Program Image</label>
                                    <div class="col-sm-6">
                                        <input type="file" id="subprogramimage" class="form-control" name="subprogramimage" required/>
                                        <p class="mt-4" style="font-size:12px;">Only Jpg ,Png and Jpeg are allowed (Maximum Image Size is 300Kb)</p>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Sub Program Description</label>
                                    <div class="col-sm-6">
                                        <textarea type="text" id="editor1" class="form-control" name="subprogramdescription" required></textarea>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Title</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="netatitle" class="form-control" name="metatitle" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Description</label>
                                    <div class="col-sm-6">
                                        <textarea type="text" id="metadescription" class="form-control" name="metadescription" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Keyword</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metakeyword" class="form-control" name="metakeyword" required>
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