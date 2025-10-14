<?php
include('config.php');
include('lock.php');

$programs_id  = cleanId($_GET['id']);
$programs     = $DB->getRowById('albumb', $programs_id);

if (empty($programs['id'])) {
    header("Location: manage-albumb.php");
    exit();
}

$titles = [];
$errors = [];
$old_data = [];

if (isset($_POST['Submit'])) {
    $subprogram_id = $_POST['subprogram_id'];
    $titles = $_POST['title']; 
    $images = $_FILES['image']; 

    $stmt = $DB->DB->prepare("INSERT INTO subprogram_gallery (subprogram_id, title, image) VALUES (?, ?, ?)");

    for ($i = 0; $i < count($titles); $i++) {
        $title = $titles[$i];
        $image_name = '';
        $image_error = '';

        if (!empty($images['name'][$i])) {
            $file_size = $images['size'][$i];
            $file_tmp = $images['tmp_name'][$i];
            $original_name = basename($images['name'][$i]);

            if ($file_size > 307200) {
                $errors[$i] = "Image '$original_name' is larger than 300 KB.";
                $old_data[] = ['title' => $title, 'error' => $errors[$i]];
                continue;
            }

            $image_name = time() . '-' . $original_name;
            $target_dir = 'uploads/';
            $target_file = $target_dir . $image_name;

            if (move_uploaded_file($file_tmp, $target_file)) {
                $stmt->execute([$subprogram_id, $title, $image_name]);
            } else {
                $errors[$i] = "Failed to upload image '$original_name'.";
                $old_data[] = ['title' => $title, 'error' => $errors[$i]];
            }
        } else {
            $old_data[] = ['title' => $title, 'error' => 'Image file is missing.'];
        }
    }

    if (empty($errors)) {
        header('Location: manage-albumb.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= DEFAULT_TITLE ?> | Add Sub Program Gallery</title>
    <?php include("include/head.php"); ?>
    <script src="assets/widgets/parsley/parsley.js"></script>
</head>
<body>
<?php include("include/header.php"); ?>
<?php include("include/sidebar.php"); ?>
<div id="page-content-wrapper">
    <div id="page-content">
        <div id="page-title">
            <h2>Add Sub Program Gallery</h2>
        </div>
        <?php include("include/message.php"); ?>

        <div class="col-md-7">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">Add Sub Program Gallery</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $e): ?>
                                    <li><?= htmlspecialchars($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="example-box-wrapper">
                        <form class="form-horizontal bordered-row" enctype="multipart/form-data" method="post" data-parsley-validate="">
                            <input type="hidden" name="subprogram_id" value="<?php echo $programs['id']; ?>" />
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Sub Program Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $programs['event_name'];?>" disabled />
                                </div>
                            </div>

                            <div id="form-container">
                                <?php
                                if (!empty($old_data)) {
                                    foreach ($old_data as $index => $entry) {
                                        $title = htmlspecialchars($entry['title']);
                                        $error = $entry['error'] ?? '';
                                        echo <<<HTML
<div class="form-entry">
    <div class="form-group">
        <label class="col-sm-3 control-label">Timeline title</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="title[]" value="{$title}" >
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Gallery Image</label>
        <div class="col-sm-6">
            <input type="file" class="form-control" name="image[]" required>
            <div class="text-danger">{$error}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6 text-end">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeEntry(this, 'form-container')">Delete</button>
            <hr />
        </div>
    </div>
</div>
HTML;
                                    }
                                }
                                ?>
                            </div>

                            <div class="text-center pad20A">
                                <button type="button" class="btn btn-primary" onclick="addEntry()">Add Sub Program Gallery</button>
                            </div>

                            <div class="text-center pad20A">
                                <input type="submit" class="btn btn-success" name="Submit" value="Save" />
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
function previewImage(input, imgId) {
    const img = document.getElementById(imgId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        img.style.display = 'none';
    }
}

function removeEntry(button, containerId) {
    const container = document.getElementById(containerId);
    if (container.children.length > 1) {
        button.closest('.form-entry').remove();
    } else {
        alert("At least one entry is required.");
    }
}

function addEntry() {
    const container = document.getElementById("form-container");
    const div = document.createElement("div");
    div.className = "form-entry";
    const uniqueId = 'img-' + Date.now();

    div.innerHTML = `
        <div class="form-group">
            <label class="col-sm-3 control-label">Timeline title</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="title[]" placeholder="Enter Gallery Title" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Gallery Image</label>
            <div class="col-sm-6">
                <input type="file" class="form-control" name="image[]" onchange="previewImage(this, '${uniqueId}')" required>
                <img id="${uniqueId}" src="" alt="Preview" style="display: none; max-width: 100px; margin-top: 10px;" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6 text-end">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeEntry(this, 'form-container')">Delete</button>
                <hr />
            </div>
        </div>
    `;
    container.appendChild(div);
}
</script>

</body>
</html>
