<?php
include('config.php');
include('lock.php');


if (isset($_POST['Submit'])) {

 
    $resolvecasename = ($_POST['resolvecasename']);
    $title = ($_POST['title']);
    $age = ($_POST['age']);
    $resolvecasedescription = ($_POST['resolvecasedescription']);
    $status = ($_POST['status']);

  

    // Validation
    if (empty($resolvecasename)) {
        $error = "Please enter Resolve Case.";
    }  
    // Subprogram Image
    if (!empty($_FILES['resolvecaseimage']['name'])) {
        $ext_image = strtolower(pathinfo($_FILES['resolvecaseimage']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext_image, ['png', 'jpg', 'jpeg'])) {
            $error = "Only PNG, JPG, JPEG images are allowed.";
        } elseif ($_FILES['resolvecaseimage']['size'] > 3000000) {
            $error = "Maximum resolvecaseimage size allowed is 300KB.";
        } else {
            $resolvecaseimage = "uploads/" . time() . "_" . basename($_FILES['resolvecaseimage']['name']);

            if (!move_uploaded_file($_FILES['resolvecaseimage']['tmp_name'], $resolvecaseimage)) {
                $error = "Failed to upload resolvecaseimage.";
            }
        }
    }
    
  

    // Error redirect
    if (!empty($error)) {
        $_SESSION['msg'] = $error;
        $_SESSION['msg_type'] = "error";
        header("Location: add-resolvecase.php");
        exit();
    }

    $tstp = date("d-m-y h:i A");

    try {
        $data = [
         
          
            'resolvecasename' => $resolvecasename,
             'title' => $title,
             'age' => $age,
            'resolvecasedescription' => $resolvecasedescription,
            'resolvecaseimage' => $resolvecaseimage,
            'status' => $status
        ];

        $res = $DB->insert('resolvecase', $data);

        if ($res) {
            $_SESSION['msg'] = "Resolve Case added successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "Failed to add Resolve Case.".$e->getMessage();;
            $_SESSION['msg_type'] = "error";
        }
    } catch (Exception $e) {
        $_SESSION['msg'] = "Error: " . $e->getMessage();
        $_SESSION['msg_type'] = "error";
    }

    header("Location: manage-resolvecases.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= DEFAULT_TITLE ?> | Add Resolve Cases </title>
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
                <h2>Add Resolve Cases</h2>
            </div>

            <?php include("include/message.php"); ?>

            <div class="col-md-7">
                <div class="panel">

                    <div class="panel-heading">
                        <h4 class="panel-title">Add Resolve Cases</h4>
                    </div>

                    <div class="panel-body">

                        <div class="example-box-wrapper">
                            <form class="form-horizontal bordered-row" enctype="multipart/form-data" id="change-laverage-form" method="post" data-parsley-validate="">
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Patient Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="resolvecasename" class="form-control" name="resolvecasename" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Patient Title</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="title" class="form-control" name="title" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Patient Age</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="age" class="form-control" name="age" required>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-3 control-label">Patient Image</label>
                                    <div class="col-sm-6">
                                        <input type="file" id="resolvecaseimage" class="form-control" name="resolvecaseimage" required/>
                                        <p class="mt-4" style="font-size:12px;">Only Jpg ,Png and Jpeg are allowed (Maximum Image Size is 300Kb)</p>
                                    </div>
                                </div>
                                

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Description</label>
                                    <div class="col-sm-6">
                                        <textarea type="text" id="editor1" class="form-control" name="resolvecasedescription" ></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-6">
                                        <select class="form-control"  id="status" name="status">
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