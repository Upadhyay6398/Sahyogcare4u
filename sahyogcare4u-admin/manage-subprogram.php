<?php
require("config.php");
require("lock.php");
require("lib/Pager.php");

$where = [];
$sql_count = "SELECT COUNT(DISTINCT sp.id) as total FROM subprogram sp";
$stmt = $DB->DB->prepare($sql_count);
$stmt->execute();
$total = $stmt->fetchColumn();

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = ($page > 0 ? $page : 1);

$pager = new Pager();
$pager->setTotalPage($total);
$pager->setLimit(20);
$pager->setPage($page);

$start = $pager->getStart();
$limit = $pager->getLimit();

// Fetch programs with entries and gallery
$sql = "
    SELECT 
        sp.id AS program_id, sp.name, sp.meta_title, sp.meta_description, sp.meta_keyword, sp.tstp,
        pe.id AS entry_id, pe.title AS entry_title, pe.image AS entry_image,
        pg.id AS gallery_id, pg.image AS gallery_image
    FROM subprogram sp
    LEFT JOIN program_entries pe ON sp.id = pe.program_id
    LEFT JOIN program_gallery pg ON sp.id = pg.program_id
    ORDER BY sp.id DESC
    LIMIT :start, :limit
";

$stmt = $DB->DB->prepare($sql);
$stmt->bindValue(":start", $start, PDO::PARAM_INT);
$stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();

$programs = [];
foreach ($rows as $row) {
    $pid = $row['program_id'];
    if (!isset($programs[$pid])) {
        $programs[$pid] = [
            'name' => $row['name'],
            'meta_title' => $row['meta_title'],
            'meta_description' => $row['meta_description'],
            'meta_keyword' => $row['meta_keyword'],
            'tstp' => $row['tstp'],
            'entries' => [],
            'gallery' => []
        ];
    }
    if (!empty($row['entry_id'])) {
        $programs[$pid]['entries'][$row['entry_id']] = [
            'title' => $row['entry_title'],
            'image' => $row['entry_image']
        ];
    }
    if (!empty($row['gallery_id'])) {
        $programs[$pid]['gallery'][$row['gallery_id']] = $row['gallery_image'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("include/head.php"); ?>
    <style>
        .entry-img,
        .gallery-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            margin: 2px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <?php include("include/header-include.php"); ?>
    <?php include("include/header.php"); ?>
    <?php include("include/sidebar.php"); ?>

    <div id="page-content-wrapper">
        <div id="page-content">
            <div class="container">
                <div id="page-title">
                    <h2>Manage Subprograms</h2>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title">Manage Subprogram</h4>
                            </div>
                            <div class="panel-body">
                                <div class="example-box-wrapper">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sr.No.</th>
                                                <th>Name</th>
                                                <th>Meta Title</th>
                                                <th>Entries Title</th>
                                                <th>Entries Image</th>
                                                <th>Gallery Image</th>
                                                <th>Date & Time</th>
                                                <th>Update</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = $start + 1;
                                            foreach ($programs as $pid => $program) {
                                                echo "<tr>";
                                                echo "<td>" . $i++ . "</td>";
                                                echo "<td>" . htmlspecialchars($program['name']) . "</td>";
                                                echo "<td>" . htmlspecialchars($program['meta_title']) . "</td>";

                                                // Entries Title (multiple entries in one cell)
                                                echo "<td>";
                                                if (!empty($program['entries'])) {
                                                    foreach ($program['entries'] as $entry) {
                                                        echo "<div>" . htmlspecialchars($entry['title']) . "</div> <br/><hr/>";
                                                    }
                                                } else {
                                                    echo "<em>No Entries</em>";
                                                }
                                                echo "</td>";

                                                // Gallery Title (You can adjust this if you want a title instead)
                                                echo "<td>";
                                                if (!empty($program['entries'])) {
                                                    foreach ($program['entries'] as $entry) {
                                                        if (!empty($entry['image'])) {
                                                            echo '<a href="delete-subenteries.php>
                                                            echo <i class="fa fa-times" aria-hidden="true"></i></a>';
                                                            echo "<img class='entry-img' src='" . htmlspecialchars($entry['image']) . "'> <br/><hr/>";
                                                           
                                                        }
                                                    }
                                                } else {
                                                    echo "<em>No Entry Images</em>";
                                                }
                                                echo "</td>";

                                                // Gallery Images
                                                echo "<td>";
                                                if (!empty($program['gallery'])) {
                                                    foreach ($program['gallery'] as $img) {
                                                        echo "<img class='gallery-img' src='" . htmlspecialchars($img) . "'><br/><hr/>";
                                                    }
                                                } else {
                                                    echo "<em>No Gallery</em>";
                                                }
                                                echo "</td>";

                                                echo "<td>" . $program['tstp'] . "</td>";

                                                // Update/Delete Buttons
                                                echo "<td><a href='update-subprogram.php?id=" . base64_encode($pid) . "' onclick='return confirm(\"Are Your Sure You want to update this data\")'>Update</a></td>";
                                                echo "<td><a href='delete-subprogram.php?id=" . base64_encode($pid) . "' onclick='return confirm(\"Are you sure You want to Delete this Data?\")'>Delete</a></td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include("include/footer-js.php"); ?>
</body>

</html>