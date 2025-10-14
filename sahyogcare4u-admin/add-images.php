<?php
include('config.php');
include('lock.php');

$emergencycase_id  = cleanId($_GET['id']);
$emergencycase     = $DB->getRowById('emergencycase', $emergencycase_id);

if (empty($emergencycase['id'])) {
    header("Location: manage-emergencycase.php");
    exit();
}

if (isset($_POST['Submit'])) {
   
    $images = $_FILES['image']; 

    $stmt = $DB->DB->prepare("INSERT INTO emergencycase_images (emergencycase_id, image) VALUES (?, ?)");

    for ($i = 0; $i < count($images['name']); $i++) {
        $image_name = '';
        if (!empty($images['name'][$i])) {
            $image_name = time() . '-' . basename($images['name'][$i]);
            $target_dir = 'uploads/';
            $target_file = $target_dir . $image_name;

            if (move_uploaded_file($images['tmp_name'][$i], $target_file)) {
                // Upload success
            } else {
                echo 'Error uploading image for emergency case.';
                continue;
            }
        }

        $stmt->execute([$emergencycase_id, $image_name]);
    }

    header('Location: manage-emergencycase.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= DEFAULT_TITLE ?> | Add Emergency Case Images</title>
    <?php include("include/head.php"); ?>
    <script type="text/javascript" src="assets/widgets/parsley/parsley.js"></script>
</head>
<body>
<?php include("include/header.php"); ?>
<?php include("include/sidebar.php"); ?>
<div id="page-content-wrapper">
    <div id="page-content">
        <div id="page-title">
            <h2>Add Emergency Case Images</h2>
        </div>
        <?php include("include/message.php"); ?>

        <div class="col-md-7">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">Add Emergency Case Images</h4>
                </div>
                <div class="panel-body">
                    <div class="example-box-wrapper">
                        <form class="form-horizontal bordered-row" enctype="multipart/form-data" method="post" data-parsley-validate="">

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Emergency Case</label>
                                <div class="col-sm-6">
                                    <input type="text" id="documents" class="form-control" name="emergencycase_id" value="<?php echo $emergencycase['name'];?>" required disabled />
                                </div>
                            </div>

                            <div id="form-container"></div>

                            <div class="text-center pad20A">
                                <button type="button" class="btn btn-primary" onclick="addEntry()">Add EmergencyCase Images</button>
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
            <label class="col-sm-3 control-label">Gallery Image</label>
            <div class="col-sm-6">
                <input type="file" class="form-control" name="image[]" onchange="previewImage(this, '${uniqueId}')" required />
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
