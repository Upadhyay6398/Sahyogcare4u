<?php 
include("config.php"); 
include("lock.php");  

$emergencycase_id  = cleanId($_GET['id']); 
$emergencycase     = $DB->getRowById('mainemergencycase', $emergencycase_id); 


if (empty($emergencycase['id'])) { 
    $_SESSION['msg'] = "Main Emergency Case  not found."; 
    header("Location: manage-mainemergencycase.php"); 
    exit();
}  
if (isset($_POST['Submit'])) { 
 
    $meta_title       = ($_POST['metatitle']); 
    $meta_description = ($_POST['metadescription']); 
    $meta_keyword     = ($_POST['metakeyword']); 
    $status           = ($_POST['status']); 
   
    $error            = "";  

    // Validations  
    if (empty($meta_title)) { 
        $error = "Please enter a Meta title."; 
    } elseif (empty($meta_description)) { 
        $error = "Please enter a Meta Description."; 
    } elseif (empty($meta_keyword)) { 
        $error = "Please enter a Meta Keyword."; 
    }
  
    
    if (!empty($error)) { 
        $_SESSION['msg'] = $error; 
        $_SESSION['msg_type'] = "error"; 
        header("Location: edit-mainemergencycase.php?id=$emergencycase_id"); 
        exit(); 
    }  

    try { 
        $data = [ 
           
            'metatitle'       => $meta_title, 
            'metadescription' => $meta_description, 
            'metakeyword'     => $meta_keyword,  
            'status'           => $status
           
        ]; 
        
        $res = $DB->update('mainemergencycase', $data, $emergencycase_id); 

        if ($res) { 
            $_SESSION['msg'] = " Main Emergency Case updated successfully!"; 
            $_SESSION['msg_type'] = "success"; 
        } else { 
            $_SESSION['msg'] = "Failed to update Main Emergency Case."; 
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
    <title><?= DEFAULT_TITLE ?> |Update Main Emergency Case</title>
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
                <h2>Update Main Emergency Case</h2>
            </div>

            <?php include("include/message.php"); ?>

            <div class="col-md-7">
                <div class="panel">

                    <div class="panel-heading">
                        <h4 class="panel-title">Update Main Emergency Case</h4>
                    </div>

                    <div class="panel-body">

                        <div class="example-box-wrapper">
                            <form class="form-horizontal bordered-row" enctype="multipart/form-data" id="change-laverage-form" method="post" data-parsley-validate="">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta title</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metatitle" class="form-control" name="metatitle" value="<?= $emergencycase['metatitle'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Description</label>
                                    <div class="col-sm-6">
                                        <textarea type="text" id="editor1" class="form-control" name="metadescription"><?=$emergencycase['metadescription'];?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Keyword</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metakeyword" class="form-control" name="meta_keyword" value="<?=$emergencycase['metakeyword'];?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" required id="status" name="status">
                                        <option value="1" <?= ($emergencycase['status'] == 1 ? $selected : '') ?>>Enable</option>
                                        <option value="2" <?= ($emergencycase['status'] == 2 ? $selected : '') ?>>Disable</option>
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