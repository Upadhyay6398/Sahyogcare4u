<?php
include("config.php");
include("lock.php");



if (isset($_POST['Submit'])) {
  

   
    $meta_title        = ($_POST['metatitle']);
    $meta_description  = ($_POST['metadescription']);
    $meta_keyword      = ($_POST['metakeyword']);
    $status            = ($_POST['status']);
   


    if (empty($meta_title)) {
        $error = "Please enter Meta title.";
    } 
    elseif (empty($meta_description)) {
        $error = "Please enter Meta Description.";
    } elseif (empty($meta_keyword)) {
        $error = "Please enter Meta Keyword.";
    } 

    if (!empty($error)) {
        $_SESSION['msg'] = $error;
        $_SESSION['msg_type'] = "error";
        header("Location: add-mainemergencycase.php");
        exit();
    }

    try {
        $data = [
           
            'metatitle'       => $meta_title,
            'metadescription' => $meta_description,
            'metakeyword'     => $meta_keyword,
            'status'           => $status
           
        ];

        $res = $DB->insert('mainemergencycase', $data);

        if ($res) {
            $_SESSION['msg'] = "Main Emergency Case added successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "Failed to add Main Emergency Case.";
            $_SESSION['msg_type'] = "error";
        }
    } catch (Exception $e) {
        $_SESSION['msg'] = "Error: " . $e->getMessage();
        $_SESSION['msg_type'] = "error";
    }

    header("Location: manage-mainemergencycase.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= DEFAULT_TITLE ?> | Add Main Emergency Case</title>
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
                <h2>Add Main Emergency Case</h2>
            </div>

            <?php include("include/message.php"); ?>

            <div class="col-md-7">
                <div class="panel">

                    <div class="panel-heading">
                        <h4 class="panel-title">Add Main Emergency Case</h4>
                    </div>

                    <div class="panel-body">

                        <div class="example-box-wrapper">
                            <form class="form-horizontal bordered-row" enctype="multipart/form-data" id="change-laverage-form" method="post" data-parsley-validate="">
                              
                               
                               
                               
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta title</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metatitle" class="form-control" name="metatitle">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Description</label>
                                    <div class="col-sm-6">
                                        <textarea type="text" id="editor" class="form-control" name="metadescription"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Keyword</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metakeyword" class="form-control" name="metakeyword">
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