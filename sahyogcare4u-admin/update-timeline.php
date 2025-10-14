<?php
include('config.php');
include('lock.php');

$subprogram_id1  = cleanId($_GET['id']);
$subprogram1     = $DB->getRowById('programs', $subprogram_id1);
$subprogram_id = cleanId($_GET['id']);
$subprogram = $DB->getRowById('subprogram_timelines', $subprogram_id);

if (empty($subprogram['id'])) { 
    header("Location: manage-program.php"); 
    exit(); 
}
$programtimelines = $DB->getRows('subprogram_gallery', ['subprogram_id' => $subprogram_id]);
if (isset($_POST['Submit'])) { 

    // Update entries
    if (!empty($_POST['title']) && isset($_FILES['image'])) {
        foreach ($_POST['title'] as $key => $title) {
            $entryId = isset($_POST['entry_id'][$key]) ? intval($_POST['entry_id'][$key]) : 0;
            $entryImage = "";

            // Handle image upload
            if (!empty($_FILES['image']['name'][$key])) {
                $ext = strtolower(pathinfo($_FILES['image']['name'][$key], PATHINFO_EXTENSION));
                if (in_array($ext, ['png', 'jpg', 'jpeg'])) {
                  
                    $entryImage = "uploads/" . uniqid() . "_" . basename($_FILES['image']['name'][$key]);

                  
                    if ($_FILES['image']['error'][$key] === UPLOAD_ERR_OK) {
                        move_uploaded_file($_FILES['image']['tmp_name'][$key], $entryImage);
                    } else {
                    
                        echo "Error uploading file.";
                        continue;
                    }
                } else {
                    echo "Invalid image format. Only PNG, JPG, JPEG allowed.";
                    continue;
                }
            } else {
               
                $entryImage = isset($_POST['existing_entry_image'][$key]) ? $_POST['existing_entry_image'][$key] : "";
            }

            $entryData = [
                'subprogram_id' => $subprogram_id,
                'title' => sanitizeString($title),
              
            ];

            if (!empty($entryImage)) {
                $entryData['image'] = $entryImage;
            }

            if ($entryId > 0) {
                $DB->update('subprogram_timelines', $entryData, $entryId);
            } else {
                $DB->insert('subprogram_timelines', $entryData);
            }
           

        }
       
    }
    header("Location: manage-program.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= DEFAULT_TITLE ?> | Update Sub Program Timeline</title>
    <?php include("include/head.php"); ?>
    <script type="text/javascript" src="assets/widgets/parsley/parsley.js"></script>
</head>
<body>
    <?php include("include/header.php"); ?>
    <?php include("include/sidebar.php"); ?>
    <div id="page-content-wrapper">
        <div id="page-content">
            <div id="page-title">
                <h2>Update Sub Program Timeline</h2>
            </div>
            <?php include("include/message.php"); ?>
            <div class="col-md-7">
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title">Update Sub Program Timeline</h4>
                    </div>
                    <div class="panel-body">
                        <div class="example-box-wrapper">
                            <form class="form-horizontal bordered-row" enctype="multipart/form-data" id="change-laverage-form" method="post" data-parsley-validate="">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Category Name</label>
                                    <div class="col-sm-6">
                                         <input type="text" id="documents" class="form-control" name="subprogram_id" value="<?php echo $subprogram1 ['subprogramtitle']; ?>" required readonly />
                                    </div>
                                </div>
                                <div id="form-container">
                                    <?php foreach ($programtimelines as $entry): ?>
                                        <div class="form-entry">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Timeline title</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="title[]" value="<?= htmlspecialchars($entry['title']) ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Timeline Icon</label>
                                                <div class="col-sm-6">
                                                    <input type="file" class="form-control" name="image[]" onchange="previewImage(this, 'img-<?= $entry['id'] ?>')">
                                                    <img id="img-<?= $entry['id'] ?>" src="uploads/<?= htmlspecialchars($entry['image']) ?>" alt="Preview" style="max-width: 100px; margin-top: 10px;" />

                                                </div>
                                            </div>
                                            <input type="hidden" name="entry_id[]" value="<?= $entry['id'] ?>">
                                            <input type="hidden" name="existing_entry_image[]" value="<?= $entry['image'] ?>">
                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-6 text-end">
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeEntry(this, 'form-container')">Delete</button>
                                                    <hr />
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
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
                        <input type="file" class="form-control" name="image[]" onchange="previewImage(this, '${uniqueId}')">
                        <img id="${uniqueId}" src="" alt="Preview" style="display: none; max-width: 100px; margin-top: 10px;" />
                         <p class="mt-4" style="font-size:12px;">Only Jpg ,Png and Jpeg are allowed (Maximum Image Size is 300Kb</p>
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
