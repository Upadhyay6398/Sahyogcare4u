<?php 
include("config.php"); 
include("lock.php");  

$category_id  = cleanId($_GET['id']); 
$category     = $DB->getRowById('slider', $category_id); 

if (empty($category['id'])) { 
    $_SESSION['msg'] = "Slider not found."; 
    header("Location: manage-slider.php"); 
    exit();
}  


if (isset($_POST['Submit'])) { 
  
    $status           = sanitizeString($_POST['status']); 
    $priority            = sanitizeString($_POST['priority']);
    $image            = $category['image'];   
   
    $error            = "";  

    
    
     if (!empty($_FILES['image']['name'])) { 
        
        $ext_image = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));  

        if (!in_array($ext_image, ['png', 'jpg', 'jpeg'])) { 
            $error = "Only PNG, JPG, and JPEG images are allowed."; 
        } elseif ($_FILES['image']['size'] > 3000000) { 
            $error = "Maximum image size allowed is 3MB."; 
        } else { 
            $upload_dir = "uploads/";  
            if (!is_dir($upload_dir)) { 
                mkdir($upload_dir, 0777, true);  
            } 

            $image = $upload_dir . time() . "_" . basename($_FILES['image']['name']);  

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image)) { 
                $error = "Failed to upload image."; 
            } 
        } 
    }  
    if (!empty($error)) { 
        $_SESSION['msg'] = $error; 
        $_SESSION['msg_type'] = "error"; 
        header("Location: edit-slider.php?id=$category_id"); 
        exit(); 
    }  

    $tstp = date("d-m-y h:i:s A"); 

    try { 
        $data = [ 
           
            'image'            => $image, 
            'priority'            => $priority,
            'status'           => $status
           
        ]; 
        
        $res = $DB->update('slider', $data, $category_id); 

        if ($res) { 
            $_SESSION['msg'] = "Slider updated successfully!"; 
            $_SESSION['msg_type'] = "success"; 
        } else { 
            $_SESSION['msg'] = "Failed to update Slider."; 
            $_SESSION['msg_type'] = "error"; 
        } 
    } catch (Exception $e) { 
        $_SESSION['msg'] = "Error: " . $e->getMessage(); 
        $_SESSION['msg_type'] = "error"; 
    }  

    header("Location: edit-slider.php?id=$category_id");
    exit();
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= DEFAULT_TITLE ?> | Add Slider</title>
    <?php
    include("include/head.php");
    ?>
</head>

<body>
    <?php
    include("include/header.php");
    include("include/sidebar.php");
    ?>
    <div id="page-content-wrapper">
        <div id="page-content">
            <div id="page-title">
                <h2>Update Slider </h2>
            </div>

            <?php include("include/message.php"); ?>

            <div class="col-md-7">
                <div class="panel">

                    <div class="panel-heading">
                        <h4 class="panel-title">Update Slider</h4>
                    </div>

                    <div class="panel-body">

                        <div class="example-box-wrapper">
                            <form class="form-horizontal bordered-row" enctype="multipart/form-data" id="change-laverage-form" method="post" data-parsley-validate="">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Slider Image</label>
                                    <div class="col-sm-6">
                                        <input type="file" id="image" class="form-control" name="image" />
                                        <?php if (!empty($category['image'])): ?>
                                       <img src="<?= BASE_URL . $category['image']; ?>" alt="Category Image" width="100" height="100"><br>
                                       <a href="<?= BASE_URL . $category['image']; ?>" target="_blank">View </a>
                                       <?php else: ?>
                                        <br>
                                                <strong><p>No Image available</p></strong>
                                                 <?php endif; ?>
                                       
                                    </div>
                                </div>
                               <div class="form-group">
                                    <label class="col-sm-3 control-label">Priority</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="priority" required class="form-control" name="priority" value="<?php echo $category['priority'];?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" required id="status" name="status">
                                        <option value="1" <?= ($category['status'] == 1 ? $selected : '') ?>>Enable</option>
                                        <option value="2" <?= ($category['status'] == 2 ? $selected : '') ?>>Disable</option>
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


</body>

</html>