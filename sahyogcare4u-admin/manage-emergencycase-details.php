<?php
require("config.php");
require("lock.php");
require("lib/Pager.php");

// Count total emergency cases
$sql_count = "SELECT COUNT(DISTINCT id) as total FROM emergencycasedetails";
$total = $DB->DB->query($sql_count)->fetchColumn();

// Pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$pager = new Pager();
$pager->setTotalPage($total);
$pager->setLimit(20);
$pager->setPage($page);

$start = $pager->getStart();
$limit = $pager->getLimit();
$sql = "
    SELECT 
        ecd.id AS emergencycase_id,
        ecd.name,
        ecd.disease,
        ecd.age,
        ecd.hospital,
        ecd.doctor,
        ecd.description,
        ecd.video,
        ecd.category_id,
        ecd.meta_title,
        ecd.meta_description,
        ecd.meta_keyword,
        ecd.status,
        ecd.tstp,

        pi.id AS image_id,
        pi.image AS patient_image,

        pd.id AS document_id,
        pd.document AS patient_document

    FROM emergencycasedetails ecd
    LEFT JOIN patient_images pi ON ecd.id = pi.emergencycase_id
    LEFT JOIN patient_documents pd ON ecd.id = pd.emergencycase_id
    ORDER BY ecd.id DESC
    LIMIT :start, :limit
";

$stmt = $DB->DB->prepare($sql);
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group by emergencycase_id
$cases = [];
foreach ($rows as $row) {
    $id = $row['emergencycase_id'];

    if (!isset($cases[$id])) {
        $cases[$id] = [
            'name' => $row['name'],
            'meta_title' => $row['meta_title'],
            'disease' => $row['disease'], 
            'meta_description' => $row['meta_description'],
            'meta_keyword' => $row['meta_keyword'],
            'tstp' => $row['tstp'],
            'images' => [],
            'documents' => []
        ];
    }

    if (!empty($row['patient_image'])) {
        $cases[$id]['images'][] = $row['patient_image'];
    }

    if (!empty($row['patient_document'])) {
        $cases[$id]['documents'][] = $row['patient_document'];
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
</head>

<body>
    <?php include("include/header-include.php"); ?>
    <?php include("include/header.php"); ?>
    <?php include("include/sidebar.php"); ?>

    <div id="page-content-wrapper">
        <div id="page-content">
            <div class="container">
                <div id="page-title">
                    <h2>Manage Emergency Cases</h2>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title">Emergency Case List</h4>
                            </div>
                            <div class="panel-body">
                                <div class="example-box-wrapper">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sr.No.</th>
                                                <th>Name</th>
                                                <th>Patient Disease</th>
                                                <th>Patient Images</th>
                                                <th>Documents</th>
                                                <th>Date & Time</th>
                                                <th>Update</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = $start + 1;
                                            foreach ($cases as $case_id => $case) {
                                                echo "<tr>";
                                                echo "<td>" . $i++ . "</td>";
                                                echo "<td>" . htmlspecialchars($case['name']) . "</td>";
                                                echo "<td>" . htmlspecialchars($case['disease']) . "</td>";

                                                // Patient Images
                                                echo "<td>";
                                                if (!empty($case['images'])) {
                                                    foreach ($case['images'] as $img) {
                                                        echo "<img class='entry-img' src='" . htmlspecialchars($img) . "'><br/><hr/>";
                                                    }
                                                } else {
                                                    echo "<em>No Images</em>";
                                                }
                                                echo "</td>";

                                                // Documents
                                                echo "<td>";
                                                if (!empty($case['documents'])) {
                                                    foreach ($case['documents'] as $doc) {
                                                        echo "<a href='" . htmlspecialchars($doc) . "' target='_blank'>" . basename($doc) . "</a><br/><hr/>";
                                                    }
                                                } else {
                                                    echo "<em>No Documents</em>";
                                                }
                                                echo "</td>";

                                                echo "<td>" . $case['tstp'] . "</td>";
                                                echo "<td><a href='update-emergencycase-details.php?id=" . base64_encode($case_id) . "' onclick='return confirm(\"Are you sure you want to update this record?\")'>Update</a></td>";
                                                echo "<td><a href='delete-emergencycase-details.php?id=" . base64_encode($case_id) . "' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a></td>";
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
    </div>
</body>

</html>
