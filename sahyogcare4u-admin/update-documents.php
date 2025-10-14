<?php
include('config.php');
include('lock.php');

$emergencycase_id = cleanId($_GET['id']);
$emergencycase = $DB->getRowById('emergencycase', $emergencycase_id);



$documents = $DB->getRows('documents', ['emergencycase_id' => $emergencycase_id]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['title'])) {
        foreach ($_POST['title'] as $key => $title) {
            $entryId = isset($_POST['entry_id'][$key]) ? intval($_POST['entry_id'][$key]) : 0;
            $existingDocument = $_POST['existing_entry_document'][$key] ?? '';
            $docTitle = trim($title);
            $uploadedFilePath = $existingDocument;

            if (!empty($_FILES['documents']['name'][$key])) {
                $file = $_FILES['documents'];
                $fileName = $file['name'][$key];
                $fileTmp = $file['tmp_name'][$key];
                $fileSize = $file['size'][$key];
                $fileError = $file['error'][$key];
                $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Allow PDF, JPG, JPEG
                $allowedExtensions = ['pdf', 'jpg', 'jpeg'];
                $maxSize = 3 * 1024 * 1024;

                if (in_array($ext, $allowedExtensions) && $fileSize <= $maxSize && $fileError === UPLOAD_ERR_OK) {
                    $safeFileName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($fileName, PATHINFO_FILENAME));
                    $newName = 'documents/' . uniqid($safeFileName . '_') . '.' . $ext;

                    if (move_uploaded_file($fileTmp, $newName)) {
                        $uploadedFilePath = $newName;
                    }
                }
            }

            $data = [
                'emergencycase_id' => $emergencycase_id,
                'name' => $docTitle,
                'documents' => $uploadedFilePath
            ];

            if ($entryId > 0) {
                $DB->update('documents', $data, $entryId);
            } else {
                $DB->insert('documents', $data);
            }
        }
    }

    header("Location: manage-emergencycase.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= DEFAULT_TITLE ?> | Update Emergency Case Documents</title>
    <?php include("include/head.php"); ?>
</head>
<body>
<?php include("include/header.php"); ?>
<?php include("include/sidebar.php"); ?>
<div id="page-content-wrapper">
    <div id="page-content">
        <div id="page-title"><h2>Update Emergency Case Documents</h2></div>
        <?php include("include/message.php"); ?>

        <div class="col-md-8">
            <div class="panel">
                <div class="panel-heading"><h4 class="panel-title">Manage Documents</h4></div>
                <div class="panel-body">
                    <form class="form-horizontal bordered-row" enctype="multipart/form-data" method="post">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Emergency Case</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="<?= htmlspecialchars($emergencycase['name']) ?>" disabled>
                            </div>
                        </div>

                        <div id="form-container">
                            <?php foreach ($documents as $index => $doc): ?>
                                <div class="form-entry">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Document Title</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="title[]" value="<?= htmlspecialchars($doc['name']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Document File</label>
                                        <div class="col-sm-6">
                                            <input type="file" name="documents[]" class="form-control" accept=".pdf">
                                            <?php if (!empty($doc['documents'])): ?>
                                                <p>
                                                    <a href="<?= $doc['documents'] ?>" target="_blank">View Current PDF</a>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <input type="hidden" name="entry_id[]" value="<?= $doc['id'] ?>">
                                    <input type="hidden" name="existing_entry_document[]" value="<?= $doc['documents'] ?>">
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-6">
                                                  <a href="delete-documents.php?id=<?= base64_encode($doc['id']) ?>"
   onclick="return confirm('Are you sure you want to delete this Documents from the database?');"
   class="btn btn-sm btn-danger">Delete</a>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-primary" onclick="addEntry()">Add Document</button>
                        </div>
                        <br>
                        <div class="text-center">
                            <input type="submit" name="Submit" value="Save" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<?php include("include/footer-js.php"); ?>

<script>
function removeEntry(button) {
    const entry = button.closest('.form-entry');
    entry.remove();
}

function addEntry() {
    const container = document.getElementById("form-container");
    const div = document.createElement("div");
    div.className = "form-entry";
    div.innerHTML = `
        <div class="form-group">
            <label class="col-sm-3 control-label">Document Title</label>
            <div class="col-sm-6">
                <input type="text" name="title[]" class="form-control" placeholder="e.g. Discharge Summary" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Document File</label>
            <div class="col-sm-6">
                <input type="file" name="documents[]" class="form-control" accept=".pdf" required>
                <p style="font-size:12px;">Only PDF allowed. Max size 3MB.</p>
            </div>
        </div>
        <input type="hidden" name="entry_id[]" value="0">
        <input type="hidden" name="existing_entry_document[]" value="">
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeEntry(this)">Delete</button>
                <hr>
            </div>
        </div>
    `;
    container.appendChild(div);
}
</script>
</body>
</html>
