<?php
include('config.php');
include('lock.php');


$programs_id  = cleanId($_GET['id']);
$programs     = $DB->getRowById('programs', $programs_id);

if (isset($_POST['Submit'])) {
    $subprogram_id = $_POST['subprogram_id'];
    $titles = $_POST['title']; 
    $images = $_FILES['image']; 

    $stmt = $DB->DB->prepare("INSERT INTO subprogram_timelines (subprogram_id, title, image) VALUES (?, ?, ?)");

    // Loop through each timeline entry
    for ($i = 0; $i < count($titles); $i++) {
        $title = $titles[$i];

        // Handle image upload
        $image_name = '';
        if (!empty($images['name'][$i])) {
            $image_name = time() . '-' . basename($images['name'][$i]);
            $target_dir = 'uploads/';
            $target_file = $target_dir . $image_name;

            if (move_uploaded_file($images['tmp_name'][$i], $target_file)) {
                // Successfully uploaded
            } else {
               
                echo 'Error uploading image for timeline: ' . $title;
                continue;
            }
        }

        // Insert the data into the database
        $stmt->execute([$subprogram_id, $title, $image_name]);
    }

header('Location:manage-program.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= DEFAULT_TITLE ?> | Add Sub Program Timeline</title>
    <?php include("include/head.php"); ?>
    <script type="text/javascript" src="assets/widgets/parsley/parsley.js"></script>
</head>
<body>
    <?php include("include/header.php"); ?>
    <?php include("include/sidebar.php"); ?>
    <div id="page-content-wrapper">
        <div id="page-content">
            <div id="page-title">
                <h2>Add Sub Program Timeline</h2>
            </div>
            <?php include("include/message.php"); ?>
            <div class="col-md-7">
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title">Add Sub Program Timeline</h4>
                    </div>
                    <div class="panel-body">
                        <div class="example-box-wrapper">
                            <form class="form-horizontal bordered-row" enctype="multipart/form-data" id="change-laverage-form" method="post" data-parsley-validate="">
                                 <div class="form-group">
                                <input type="hidden" name="subprogram_id" value="<?php echo $programs['id']; ?>" />
                                <label class="col-sm-3 control-label">Sub Program Name</label>
                                <div class="col-sm-6">
                                    <input type="text" id="subprogram_id" class="form-control"  value="<?php echo $programs['subprogramtitle'];?>" required disabled />
                                </div>
                            </div>
                                <div id="form-container"></div>
                                <div class="text-center pad20A">
                                    <button type="button" class="btn btn-primary" onclick="addEntry()">Add Sub Program Timeline</button>
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

        // Program Entry
        function addEntry() {
            const container = document.getElementById("form-container");
            const div = document.createElement("div");
            div.className = "form-entry";
            const uniqueId = 'img-' + Date.now();

            div.innerHTML = `
                <div class="form-group">
                    <label class="col-sm-3 control-label">Timeline title</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="title[]" placeholder="Enter Timeline Title" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Timeline Icon</label>
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
