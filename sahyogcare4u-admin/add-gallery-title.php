<?php include('config.php'); ?>
<?php include('lock.php');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= DEFAULT_TITLE ?> | Add Gallery Title</title>
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
                <h2>Add Gallery Title</h2>
            </div>

            <?php include("include/message.php"); ?>

            <div class="col-md-7">
                <div class="panel">

                    <div class="panel-heading">
                        <h4 class="panel-title">Add Galery Title</h4>
                    </div>

                    <div class="panel-body">

                        <div class="example-box-wrapper">
                            <form class="form-horizontal bordered-row" enctype="multipart/form-data" id="change-laverage-form" method="post" data-parsley-validate="">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Program Name</label>
                                    <div class="col-sm-6">
                                        <?php
                                        $sql = "SELECT * FROM `category` ORDER BY id DESC";
                                        $stmt = $DB->DB->prepare($sql);
                                        $stmt->execute();
                                        $rows = $stmt->fetchAll();
                                        ?>
                                        <select name="name" id="name" class="form-control" required>
                                            <option value="" disabled selected required>Select Program</option>
                                            <?php foreach ($rows as $row): ?>
                                                <option value="<?php echo htmlspecialchars($row['program_id']); ?>">
                                                    <?php echo htmlspecialchars($row['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Sub Program Name</label>
                                    <div class="col-sm-6">
                                        <?php
                                        $sql = "SELECT * FROM `programs` ORDER BY id DESC";
                                        $stmt = $DB->DB->prepare($sql);
                                        $stmt->execute();
                                        $rows = $stmt->fetchAll();
                                        ?>
                                        <select name="subprogramtitle" id="name" class="form-control" required>
                                            <option value="" disabled selected>Select Program</option>
                                            <?php foreach ($rows as $row): ?>
                                                <option value="<?php echo htmlspecialchars($row['	subprogram_id']); ?>">
                                                    <?php echo htmlspecialchars($row['subprogramtitle']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Do You Want to Add Event Name</label>
                                    <div class="col-sm-6">
                                        Yes <input type="radio" name="add_event" value="Yes"  />&nbsp;&nbsp;
                                        No <input type="radio" name="add_event" value="No"  /><br>
                                    </div>
                                </div>

                                <div class="form-group" id="eventNameGroup" style="display: none;">
                                    <label class="col-sm-3 control-label">Event Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="eventName" class="form-control" name="name" required/>
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
                                        <textarea type="text" id="editor2" class="form-control" name="meta_description"required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta Keyword</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="metakeyword" class="form-control" name="meta_keyword"required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" required id="status" name="status">
                                            <option value="1" selected>Enable</option>
                                            <option value="2">Disable</option>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radios = document.querySelectorAll('input[name="add_event"]');
            const eventNameGroup = document.getElementById('eventNameGroup');

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'Yes') {
                        eventNameGroup.style.display = 'block';
                    } else {
                        eventNameGroup.style.display = 'none';
                    }
                });
            });
        });
    </script>


</body>

</html>