<?php
include("config.php");
include("lock.php");

if (isset($_POST['Submit'])) {

    $name = sanitizeString($_POST['name']);
    $meta_title = sanitizeString($_POST['meta_title']);
    $meta_description = sanitizeString($_POST['meta_description']);
    $meta_keyword = sanitizeString($_POST['meta_keyword']);
    $tstp = date("Y-m-d H:i:s");


    $error = "";

    if (empty($name)) {
        $error = "Please enter name.";
    } elseif (empty($meta_title)) {
        $error = "Please enter Meta title.";
    } elseif (empty($meta_description)) {
        $error = "Please enter Meta Description.";
    } elseif (empty($meta_keyword)) {
        $error = "Please enter Meta Keyword.";
    }

    if (!empty($error)) {
        $_SESSION['msg'] = $error;
        $_SESSION['msg_type'] = "error";
        header("Location: add-subprogram.php");
        exit();
    }

    // Main Program Insert
    try {
        $programData = [
            'name' => $name,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keyword' => $meta_keyword,
            'tstp' => date("Y-m-d H:i:s")  // Correct timestamp format
        ];

        $res = $DB->insert('subprogram', $programData);

        if ($res) {
            $program_id = $DB->lastInsertId();
           

            // Create 'uploads' folder if not exist
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }

            // Program Entries
            if (!empty($_POST['title'])) {
                foreach ($_POST['title'] as $key => $title) {
                    $entryImage = "";

                    if (!empty($_FILES['image']['name'][$key])) {
                        $ext = strtolower(pathinfo($_FILES['image']['name'][$key], PATHINFO_EXTENSION));
                        if (in_array($ext, ['png', 'jpg', 'jpeg'])) {
                            $entryImage = "uploads/" . uniqid() . "_" . basename($_FILES['image']['name'][$key]);
                            move_uploaded_file($_FILES['image']['tmp_name'][$key], $entryImage);
                        }
                    }

                    $entryData = [
                        'program_id' => $program_id,
                        'title' => sanitizeString($title),
                        'image' => $entryImage,
                        'tstp' => $tstp
                    ];

                    $DB->insert('program_entries', $entryData);
                }
            }
            // Gallery Images
            if (!empty($_FILES['galleryimage']['name'])) {
                foreach ($_FILES['galleryimage']['name'] as $key => $galleryName) {
                    $galleryImage = "";

                    if (!empty($galleryName)) {
                        $ext = strtolower(pathinfo($galleryName, PATHINFO_EXTENSION));
                        if (in_array($ext, ['png', 'jpg', 'jpeg'])) {
                            $galleryImage = "uploads/" . uniqid() . "_" . basename($galleryName);
                            move_uploaded_file($_FILES['galleryimage']['tmp_name'][$key], $galleryImage);
                        }

                        $galleryData = [
                            'program_id' => $program_id,
                            'image' => $galleryImage,
                            'tstp' => $tstp
                        ];

                        $DB->insert('program_gallery', $galleryData);
                    }
                }
            }

            $_SESSION['msg'] = "Program and entries added successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "Failed to add program.";
            $_SESSION['msg_type'] = "error";
        }
    } catch (Exception $e) {
        $_SESSION['msg'] = "Error: " . $e->getMessage();
        $_SESSION['msg_type'] = "error";
    }

    header("Location: add-subprogram.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= DEFAULT_TITLE ?> | Add Subprogram</title>
    <?php
    include("include/head.php");
    ?>

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
                <h2>Add Sub Program</h2>
            </div>

            <?php include("include/message.php"); ?>

            <div class="col-md-7">
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title">Add Sub Program</h4>
                    </div>

                    <div class="panel-body">

                        <div class="example-box-wrapper">
                            <form class="form-horizontal bordered-row" enctype="multipart/form-data" id="change-laverage-form" method="post" data-parsley-validate="">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Sub Program Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="name" required class="form-control" name="name" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta title</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metatitle" class="form-control" name="meta_title" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Description</label>
                                    <div class="col-sm-6">
                                        <textarea type="text" id="metadescription" class="form-control" name="meta_description" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Keyword</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metakeyword" class="form-control" name="meta_keyword" required>
                                    </div>
                                </div>
                                <div id="form-container"></div>

                                <div class="text-center pad20A">
                                    <button type="button" class="btn btn-primary" onclick="addEntry()">Add Program Entry</button>
                                </div>
                                <div id="gallery-container"></div>
                                <div class="text-center pad20A">
                                    <button type="button" class="btn btn-primary" onclick="addGalleryEntry()">Add Gallery Entry</button>
                                </div>
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
          <label class="col-sm-3 control-label">Program title</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="title[]" placeholder="Enter Program Title" required>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label">Program Image</label>
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

  // Gallery Entry
  function addGalleryEntry() {
      const container = document.getElementById('gallery-container');
      const div = document.createElement('div');
      div.className = "form-entry";
      const uniqueId = 'img-' + Date.now();

      div.innerHTML = `
        <div class="form-group">
          <label class="col-sm-3 control-label">Gallery Image</label>
          <div class="col-sm-6">
            <input type="file" class="form-control" name="galleryimage[]" onchange="previewImage(this, '${uniqueId}')" required>
            <img id="${uniqueId}" src="" alt="Preview" style="display: none; max-width: 100px; margin-top: 10px;" />
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-6 text-end">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeEntry(this, 'gallery-container')">Delete</button>
            <hr />
          </div>
        </div>
      `;
      container.appendChild(div);
  }
</script>

</body>

</html>