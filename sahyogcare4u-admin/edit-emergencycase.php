<?php
include("config.php");
include("lock.php");

$emergencycase_id  = cleanId($_GET['id']);
$emergencycase     = $DB->getRowById('emergencycase', $emergencycase_id);

if (empty($emergencycase['id'])) {
    header("Location: manage-emergencycase.php");
    exit();
}

if (isset($_POST['Submit'])) {

    function generateSlug($string) {
        $string = strtolower(trim($string));
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        return rtrim($string, '-');
    }

    $name              = ($_POST['name']);
    $disease           = ($_POST['disease']);
    $amount            = ($_POST['amount']);
    $bankname          = ($_POST['bankname']);
    $accountno         = ($_POST['accountno']);
    $branch            = ($_POST['branch']);
    $description       = ($_POST['description']);
    $meta_title        = ($_POST['meta_title']);
    $meta_description  = ($_POST['meta_description']);
    $meta_keyword      = ($_POST['meta_keyword']);
    $status            = ($_POST['status']);
    $ifsc            = ($_POST['ifsc']);
    $ifsc_understand=($_POST['ifsc_understand']);
    
    $slug              = generateSlug($name);
    $image = $emergencycase['image'];  // Default to existing image
    $videoPath = $emergencycase['video']; // Default to existing video

    // Validate and process uploaded image
    if (!empty($_FILES['image']['name'])) {
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
    // Validate and process uploaded video
    if (empty($error) && !empty($_FILES['video']['name'])) {
        $videoName = $_FILES['video']['name'];
        $videoTmp = $_FILES['video']['tmp_name'];
        $ext = strtolower(pathinfo($videoName, PATHINFO_EXTENSION));
        $mimeType = mime_content_type($videoTmp);
        $videoSize = $_FILES['video']['size'];

        $allowedExt = ['mp4', 'mov', 'avi', 'webm'];
        $allowedMime = ['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/webm'];
        $maxVideoSize = 200 * 1024 * 1024; // 200 MB

        if (!in_array($ext, $allowedExt)) {
            $error = "Only MP4, MOV, AVI, and WEBM videos are allowed.";
        } elseif (!in_array($mimeType, $allowedMime)) {
            $error = "Invalid video MIME type.";
        } elseif ($videoSize > $maxVideoSize) {
            $error = "Maximum allowed video size is 20MB.";
        } else {
            $newVideoName = uniqid('vid_') . '.' . $ext;
            $videoPath = "videos/" . $newVideoName;
            if (!move_uploaded_file($videoTmp, $videoPath)) {
                $error = "Failed to upload video.";
            }
        }
    }

    if (!empty($error)) {
        $_SESSION['msg'] = $error;
        $_SESSION['msg_type'] = "error";
        header("Location: add-emergencycase.php");
        exit();
    }

    $tstp = date("d-m-y h:i A"); 

    try {
        $data = [
            'name'             => $name,
            'disease'          => $disease,
            'amount'           => $amount,
            'bankname'         => $bankname,
            'accountno'        => $accountno,
            'branch'           => $branch,
            'description'      => $description,
            'slug'             => $slug,
            'meta_title'       => $meta_title,
            'meta_description' => $meta_description,
            'meta_keyword'     => $meta_keyword,
            'image'            => $image,
            'video'            => $videoPath,
            'status'           => $status,
            'ifsc'              =>$ifsc,
            'ifsc_understand'   =>$ifsc_understand
        ];

        $res = $DB->update('emergencycase', $data, $emergencycase_id);

        if ($res) {
            $_SESSION['msg'] = "Emergency case updated successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "Failed to update emergency case.";
            $_SESSION['msg_type'] = "error";
        }
    } catch (Exception $e) {
        $_SESSION['msg'] = "Error: " . $e->getMessage();
        $_SESSION['msg_type'] = "error";
    }

    header("Location: manage-emergencycase.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= DEFAULT_TITLE ?> | Add Emergency Case</title>
    <?php
    include("include/head.php");
    ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script type="text/javascript" src="assets/widgets/parsley/parsley.js"></script>
</head>
</head>

<body>
    <?php
    include("include/header.php");
    include("include/sidebar.php");
    ?>


    <div id="page-content-wrapper">
        <div id="page-content">
            <div id="page-title">
                <h2>Update Emergency Case</h2>
            </div>

            <?php include("include/message.php"); ?>

            <div class="col-md-7">
                <div class="panel">

                    <div class="panel-heading">
                        <h4 class="panel-title">Update Emergency Case</h4>
                    </div>

                    <div class="panel-body">

                        <div class="example-box-wrapper">
                            <form class="form-horizontal bordered-row" enctype="multipart/form-data" id="change-laverage-form" method="post" data-parsley-validate="">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Patinet Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="name" required class="form-control" name="name" value="<?php echo $emergencycase['name'];?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Patinet Disease</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="disease" required class="form-control" name="disease" value="<?php echo $emergencycase['disease'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Required Amount</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="amount"  class="form-control" name="amount" required value="<?php echo $emergencycase['amount'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Patient Image</label>
                                    <div class="col-sm-6">
                                        <input type="file" id="image" class="form-control" name="image" />
                                        <?php if (!empty($emergencycase['image'])): ?>
                                            <img src="<?= BASE_URL . $emergencycase['image']; ?>" alt="Patient Image" width="100" height="100"><br>
                                             <p class="mt-4" style="font-size:12px;">Only Jpg ,Png and Jpeg are allowed (Maximum Image Size is 300Kb or(1280 × 539))</p>
                                            <a href="<?= BASE_URL . $emergencycase['image']; ?>" target="_blank">View </a>
                                        <?php else: ?>
                                            <br>
                                            <strong>
                                                <p>No Image available</p>
                                            </strong>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Video(if any)</label>
                                    <div class="col-sm-6">
                                        <input type="file" id="video" class="form-control" name="video" accept="video/*" />

                                        <?php if (!empty($emergencycase['video'])): ?>
                                            <video width="320" height="240" controls style="margin-top: 10px;">
                                                <source src="videos/<?= $emergencycase['video'] ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        <?php endif; ?>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Patinet Description</label>
                                    <div class="col-sm-6">
                                        <textarea type="text" id="editor" required class="form-control" name="description" ><?php echo $emergencycase['description'];?></textarea>
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Patinet Account No.(if any)</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="name"  class="form-control" name="accountno" value="<?php echo $emergencycase['accountno'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Bank Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="name" class="form-control" name="bankname"  value="<?php echo $emergencycase['bankname'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Branch</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="branch"  class="form-control" name="branch" value="<?php echo $emergencycase['branch'];?>"/>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-3 control-label">IFSC Code</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="branch"  class="form-control" name="ifsc" value="<?php echo $emergencycase['ifsc'];?>"/>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">IFSC Understand </label>
                                    <div class="col-sm-6">
                                        <input type="text" id="branch"  class="form-control" name="ifsc_understand" value="<?php echo $emergencycase['ifsc_understand'];?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta title</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metatitle" class="form-control" name="meta_title" required value="<?php echo $emergencycase['meta_title'];?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Description</label>
                                    <div class="col-sm-6">
                                        <textarea type="text" id="editor1" class="form-control" name="meta_description"  required><?php echo $emergencycase['meta_description'];?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Keyword</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metakeyword" class="form-control" name="meta_keyword" value="<?php echo $emergencycase['meta_keyword'];?>" required>
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