<?php 
include("config.php");
include("lock.php");

// Slug generation function
function generateSlug($string) {
    $string = strtolower(trim($string));
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return rtrim($string, '-');
}

// Check sanitizeString() exists
if (!function_exists('sanitizeString')) {
    die("sanitizeString function is missing.");
}

if (isset($_POST['Submit'])) {
    
    // Sanitize all inputs
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
    $ifsc           =($_POST['ifsc']);
    $ifsc_understand    =($_POST['ifsc_understand']);
    $slug              = generateSlug($name);
    
    $image = '';
    $videoPath = '';

    // Validate required fields
    if (empty($name)) {
        $error = "Please enter name.";
    } elseif (empty($meta_title)) {
        $error = "Please enter Meta title.";
    } elseif (empty($description)) {
        $error = "Please enter Description.";
    } elseif (empty($meta_description)) {
        $error = "Please enter Meta Description.";
    } elseif (empty($meta_keyword)) {
        $error = "Please enter Meta Keyword.";
    }

    // Image upload
    if (empty($error) && !empty($_FILES['image']['name'])) {
        $ext_image = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowedImageExt = ['png', 'jpg', 'jpeg'];

        if (!in_array($ext_image, $allowedImageExt)) {
            $error = "Only PNG, JPG, and JPEG images are allowed.";
        } elseif ($_FILES['image']['size'] > 300 * 1024) { // 300 KB
            $error = "Maximum image size allowed is 300KB.";
        } else {
            $newImageName = uniqid('img_') . '.' . $ext_image;
            $imagePath = "uploads/" . $newImageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $error = "Failed to upload image.";
            } else {
                $image = $imagePath;
            }
        }
    }

    // Video upload
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
            $error = "Maximum allowed video size is 200MB.";
        } else {
            $newVideoName = uniqid('vid_') . '.' . $ext;
            $videoPathFull = "videos/" . $newVideoName;

            if (!move_uploaded_file($videoTmp, $videoPathFull)) {
                $error = "Failed to upload video.";
            } else {
                $videoPath = $videoPathFull;
            }
        }
    }

    // If there is any error, redirect back
    if (!empty($error)) {
        $_SESSION['msg'] = $error;
        $_SESSION['msg_type'] = "error";
        header("Location: add-emergencycase.php");
        exit();
    }

    $createdAt = date("d-m-y h:i A");

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
            'ifsc_understand'=>$ifsc_understand
        ];

        $res = $DB->insert('emergencycase', $data);

        if ($res) {
            $_SESSION['msg'] = "Emergency case added successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "Failed to add Emergency case.";
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
                        <h4 class="panel-title">Add Emergency Case</h4>
                    </div>

                    <div class="panel-body">

                        <div class="example-box-wrapper">
                          <form class="form-horizontal bordered-row" enctype="multipart/form-data" method="post" data-parsley-validate="">

    <!-- Patient Name -->
    <div class="form-group">
        <label class="col-sm-3 control-label">Patient Name</label>
        <div class="col-sm-6">
            <input type="text" required class="form-control" name="name" />
        </div>
    </div>

    <!-- Patient Disease -->
    <div class="form-group">
        <label class="col-sm-3 control-label">Patient Disease</label>
        <div class="col-sm-6">
            <input type="text" required class="form-control" name="disease" />
        </div>
    </div>

    <!-- Amount -->
    <div class="form-group">
        <label class="col-sm-3 control-label">Required Amount</label>
        <div class="col-sm-6">
            <input type="text" required class="form-control" name="amount" />
        </div>
    </div>

    <!-- Image -->
    <div class="form-group">
        <label class="col-sm-3 control-label">Patient Image</label>
        <div class="col-sm-6">
            <input type="file" class="form-control" name="image" required accept="image/*" />
            <p class="mt-2" style="font-size:12px;">Only JPG, PNG, JPEG allowed. Max Size 300KB</p>
        </div>
    </div>

    <!-- Description -->
    <div class="form-group">
        <label class="col-sm-3 control-label">Description</label>
        <div class="col-sm-6">
            <textarea required class="form-control" name="description" id="editor1"></textarea>
        </div>
    </div>

    <!-- Account No -->
    <div class="form-group">
        <label class="col-sm-3 control-label">Account No. (optional)</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="accountno" />
        </div>
    </div>

    <!-- Bank Name -->
    <div class="form-group">
        <label class="col-sm-3 control-label">Bank Name</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="bankname" />
        </div>
    </div>

    <!-- Branch -->
    <div class="form-group">
        <label class="col-sm-3 control-label">Branch</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="branch" />
        </div>
    </div>
 <div class="form-group">
        <label class="col-sm-3 control-label">IFSC Code</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="ifsc" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">IFSC Understand</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="ifsc_understand" />
        </div>
    </div>
    <!-- Video -->
    <div class="form-group">
        <label class="col-sm-3 control-label">Video (optional)</label>
        <div class="col-sm-6">
            <input type="file" class="form-control" name="video" accept="video/*" />
        </div>
    </div>

    <!-- Meta Title -->
    <div class="form-group">
        <label class="col-sm-3 control-label">Meta Title</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="meta_title" required />
        </div>
    </div>

    <!-- Meta Description -->
    <div class="form-group">
        <label class="col-sm-3 control-label">Meta Description</label>
        <div class="col-sm-6">
            <textarea class="form-control" name="meta_description" id="editor2" required></textarea>
        </div>
    </div>

    <!-- Meta Keyword -->
    <div class="form-group">
        <label class="col-sm-3 control-label">Meta Keyword</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="meta_keyword" required />
        </div>
    </div>

    <!-- Status -->
    <div class="form-group">
        <label class="col-sm-3 control-label">Status</label>
        <div class="col-sm-6">
            <select class="form-control" name="status" required>
                <option value="1" selected>Enable</option>
                <option value="2">Disable</option>
            </select>
        </div>
    </div>

    <!-- Submit -->
    <div class="text-center pad20A">
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