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
    $meta_title        = sanitizeString($_POST['metatitle']);
    $meta_description  = sanitizeString($_POST['metadescription']);
    $meta_keyword      = sanitizeString($_POST['metakeyword']);
    $status            = sanitizeString($_POST['status']);
    $event_name        = sanitizeString($_POST['event_name']);
    $subprogram_id     = sanitizeString($_POST['subprogram_id']);
    $albumb_name       = isset($_POST['albumb_name']) ? sanitizeString($_POST['albumb_name']) : '';

    // Get Sub Program Title for Slug
    $stmt = $DB->DB->prepare("SELECT subprogramtitle FROM programs WHERE id = ?");
    $stmt->execute([$subprogram_id]);
    $subprogram = $stmt->fetch(PDO::FETCH_ASSOC);
    $subprogram_title = $subprogram ? $subprogram['subprogramtitle'] : '';

    // Generate Slug
    $combinedName = $subprogram_title . ' ' . $event_name;
    $slug = generateSlug($combinedName);

    if (empty($meta_title)) {
        $error = "Please enter Meta title.";
    } elseif (empty($meta_description)) {
        $error = "Please enter Meta Description.";
    } elseif (empty($meta_keyword)) {
        $error = "Please enter Meta Keyword.";
    } elseif (empty($event_name)) {
        $error = "Please enter Event Name.";
    }

    if (!empty($error)) {
        $_SESSION['msg'] = $error;
        $_SESSION['msg_type'] = "error";
        header("Location: add-albumb.php");
        exit();
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

    try {
        $data = [
            'metatitle'       => $meta_title,
            'metadescription' => $meta_description,
            'metakeyword'     => $meta_keyword,
            'status'          => $status,
            'event_name'      => $event_name,
            'slug'            => $slug,
            'subprogram_id'   => $subprogram_id,
            'image'           => $image ?? '',
            'albumb_name'     => $albumb_name
        ];

        $res = $DB->insert('albumb', $data);

        if ($res) {
            $_SESSION['msg'] = "Main Albumb added successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "Failed to add Main Albumb.";
            $_SESSION['msg_type'] = "error";
        }
    } catch (Exception $e) {
        $_SESSION['msg'] = "Error: " . $e->getMessage();
        $_SESSION['msg_type'] = "error";
    }

    header("Location: manage-albumb.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= DEFAULT_TITLE ?> | Add Main Emergency Case</title>
    <?php include("include/head.php"); ?>

    <script type="text/javascript" src="assets/widgets/parsley/parsley.js"></script>
</head>

<body>
    <?php include("include/header.php"); ?>
    <?php include("include/sidebar.php"); ?>

    <div id="page-content-wrapper">
        <div id="page-content">
            <div id="page-title">
                <h2>Add Main Albumb</h2>
            </div>

            <?php include("include/message.php"); ?>

            <div class="col-md-7">
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title">Add Main Albumb</h4>
                    </div>

                    <div class="panel-body">
                        <div class="example-box-wrapper">
                            <form class="form-horizontal bordered-row" enctype="multipart/form-data" id="change-laverage-form" method="post" data-parsley-validate="">

                              <div class="form-group">
                                    <label class="col-sm-3 control-label">Sub Program Name</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="status" name="subprogram_id" required>
                                            <option value="">Select Sub Program Name</option>
                                            <?php
                                            $sql = "SELECT id, subprogramtitle FROM programs";
                                            $stmt = $DB->DB->prepare($sql);
                                            $stmt->execute();
                                            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            if ($rows) {
                                                foreach ($rows as $row) {
                                                    echo '<option value="' . $row['id'] . '">' . $row['subprogramtitle'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No Programs found</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- Event Name -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Add Event Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="event_name" class="form-control" name="event_name" required>
                                    </div>
                                </div>

                                <!-- Add Album Name Option -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Do you want to add Album Name?</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="add_album" value="yes" id="yes" /> Yes<br><br>
                                        <input type="radio" name="add_album" value="no" id="no" checked /> No
                                    </div>
                                </div>

                                <!-- Album Name Input (Initially Hidden) -->
                                <div class="form-group" id="albumNameGroup" style="display: none;">
                                    <label class="col-sm-3 control-label">Add Album Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="albumb_name" class="form-control" name="albumb_name" />
                                    </div>
                                </div>
                                <div class="form-group">
                     <label class="col-sm-3 control-label"> Banner Image</label>
                    <div class="col-sm-6">
            <input type="file" class="form-control" name="image" required accept="image/*" />
            <p class="mt-2" style="font-size:12px;">Only JPG, PNG, JPEG allowed. Max Size 300KB</p>
                     </div>
                    </div>


                                <!-- Meta Title -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Title</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metatitle" class="form-control" name="metatitle" required>
                                    </div>
                                </div>

                                <!-- Meta Description -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Description</label>
                                    <div class="col-sm-6">
                                        <textarea id="metadescription" class="form-control" name="metadescription" required></textarea>
                                    </div>
                                </div>

                                <!-- Meta Keyword -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Keyword</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metakeyword" class="form-control" name="metakeyword" required>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="1" selected>Enable</option>
                                            <option value="2">Disable</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Submit Button -->
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

    <?php include("include/footer-js.php"); ?>

    <script>
        $(document).ready(function() {
            // Toggle Album Name field based on radio selection
            if ($('#no').is(':checked')) {
                $('#albumNameGroup').hide();
            }
            $("input[name='add_album']").on('change', function() {
                if ($(this).val() == 'yes') {
                    $('#albumNameGroup').show();
                } else {
                    $('#albumNameGroup').hide();
                }
            });
        });
    </script>
</body>

</html>
