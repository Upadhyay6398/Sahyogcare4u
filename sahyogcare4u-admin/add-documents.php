<?php
include('config.php');
include('lock.php');

$emergencycase_id  = cleanId($_GET['id']);
$emergencycase     = $DB->getRowById('emergencycase', $emergencycase_id);



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_FILES['documents']['name'][0])) {
        $totalFiles = count($_FILES['documents']['name']);
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg'];
        $maxSize = 3 * 1024 * 1024;

        for ($i = 0; $i < $totalFiles; $i++) {
            $fileName     = $_FILES['documents']['name'][$i];
            $fileTmpName  = $_FILES['documents']['tmp_name'][$i];
            $fileSize     = $_FILES['documents']['size'][$i];
            $fileError    = $_FILES['documents']['error'][$i];
            $fileType     = $_FILES['documents']['type'][$i];
            $docName      = isset($_POST['doc_names'][$i]) ? trim($_POST['doc_names'][$i]) : '';

            if ($fileError === UPLOAD_ERR_OK) {
                if (!in_array($fileType, $allowedTypes)) {
                    echo "Only PDF and JPG/JPEG files are allowed for " . htmlspecialchars($fileName) . "<br>";
                    continue;
                }

                if ($fileSize > $maxSize) {
                    echo "The file " . htmlspecialchars($fileName) . " exceeds the 3MB size limit.<br>";
                    continue;
                }

                $randomNumber = rand(100000, 999999);
                $fileNameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = $fileNameWithoutExt . '-' . $randomNumber . '.' . $fileExtension;

                $uploadDir = 'documents/';
                $uploadFile = $uploadDir . $newFileName;

                if (file_exists($uploadFile)) {
                    echo "The file " . htmlspecialchars($newFileName) . " already exists. Please rename the file and try again.<br>";
                    continue;
                }

                if (move_uploaded_file($fileTmpName, $uploadFile)) {
                    $stmt = $DB->DB->prepare("INSERT INTO documents (emergencycase_id, documents, name) VALUES (?, ?, ?)");
                    $stmt->execute([$emergencycase_id, $uploadFile, $docName]);
                } else {
                    echo "Error saving file: " . htmlspecialchars($fileName) . "<br>";
                }
            } else {
                echo "Error with file upload: " . htmlspecialchars($fileName) . "<br>";
            }
        }

        header("Location: manage-emergencycase.php");
        exit();
    } else {
        echo "Please select at least one document to upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= DEFAULT_TITLE ?> | Add Emergency Case Documents</title>
    <?php include("include/head.php"); ?>
    <script src="assets/widgets/parsley/parsley.js"></script>
</head>
<body>
<?php include("include/header.php"); ?>
<?php include("include/sidebar.php"); ?>
<div id="page-content-wrapper">
    <div id="page-content">
        <div id="page-title">
            <h2>Add Emergency Case Documents</h2>
        </div>

        <?php include("include/message.php"); ?>

        <div class="col-md-7">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">Add Emergency Case Documents</h4>
                </div>
                <div class="panel-body">
                    <div class="example-box-wrapper">
                        <form class="form-horizontal bordered-row" enctype="multipart/form-data" method="POST" data-parsley-validate="">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Emergency Case</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $emergencycase['name']; ?>" disabled />
                                </div>
                            </div>

                            <div id="form-container"></div>

                            <div class="text-center pad20A">
                                <button type="button" class="btn btn-primary" onclick="addEntry()">Add Document</button>
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
function addEntry() {
    const container = document.getElementById("form-container");
    const div = document.createElement("div");
    div.className = "form-entry";
    const uniqueId = 'img-' + Date.now();

    div.innerHTML = `
        <div class="form-group">
            <label class="col-sm-3 control-label">Document Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="doc_names[]" placeholder="e.g. Echo Report" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Document File</label>
            <div class="col-sm-6">
                <input type="file" class="form-control" name="documents[]" onchange="previewImage(this, '${uniqueId}')" required>
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

function removeEntry(button, containerId) {
    const container = document.getElementById(containerId);
    if (container.children.length > 1) {
        button.closest('.form-entry').remove();
    } else {
        alert("At least one entry is required.");
    }
}

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
</script>
</body>
</html>
