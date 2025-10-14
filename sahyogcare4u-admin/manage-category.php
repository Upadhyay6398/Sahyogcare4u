<?php
require("config.php");
require("lib/Pager.php");
include('lock.php');
$where = [];
$sql_count = "SELECT count(*) as total FROM `category` WHERE 1=1 ";
$stmt      = $DB->DB->prepare($sql_count);
$stmt->execute($where);
$total     = $stmt->fetchColumn();


$page  = isset($_GET['page']) ? intval($_GET['page']) : 1;

$page  = ($page > 0 ? $page : 1);

$pager = new Pager();
$pager->setTotalPage($total);
$pager->setLimit(50);
$pager->setPage($page);

$where['start'] = $pager->getStart();
$where['limit'] = $pager->getLimit();

$sql   = "SELECT * FROM `category` WHERE 1=1 ORDER BY id DESC LIMIT :start,:limit";
$stmt  = $DB->DB->prepare($sql);
$stmt->execute($where);
$rows = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <?php include("include/head.php"); ?>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   <script type="text/javascript" src="<?= BASE_URL ?>assets/widgets/parsley/parsley.js"></script>
   <style>
      .big_btn {
         width: 150px;
      }
   </style>
   <?php include("form/add-btn-hover-css.php"); ?>
</head>

<body>
   <?php include("include/header-include.php"); ?>
   <?php include("include/header.php"); ?>
   <?php include("include/sidebar.php"); ?>

   <div id="page-content-wrapper">
      <div id="page-content">
         <div class="container">
            <!--=========== Data table js ======-->
            <?php include("form/datatable-js-simple.php"); ?>

            <!--======*********======= page title div==***********==-->
            <div id="page-title">
               <h2>Manage Category</h2>
            </div>
            <!--=========*************= End====**********===========-->
            <?php
            
      if (isset($_SESSION['message'])) {
      $alertType = ($_SESSION['error'] == "success") ? "alert-success" : "alert-danger";
      echo "<div class='alert $alertType'>" . $_SESSION['message'] . "</div>";

         unset($_SESSION['message']);
         unset($_SESSION['error']);
      }     
      ?>

            <div class="row">
               <div class="col-md-12">
                  <div class="panel">
                     <div class="panel-heading">
                        <h4 class="panel-title">Manage Category</h4>
                        


                     </div>
                     <div class="panel-body">
                        <div class="example-box-wrapper">
        
                  
                           <table id="datatable-tabletoolsw" class="table table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                 <tr>
                                    <th>Sr.No.</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Url</th>
                                    <th>Status</th>
                                    <th>Date & Time</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                 </tr>
                              </thead>

                              <tbody>
                                 <?php
                                 $i = $pager->getStart() + 1;
                                 foreach ($rows as $row) {
                                 ?>
                                    <tr>
                                       <td><?= $i; $i++ ?></td>
                                       <td><?= $row['name'] ?></td>
                                       <td>
                                       <?php if (!empty($row['image'])): ?>
                                       <img src="<?= BASE_URL . $row['image']; ?>" alt="Category Image" width="50" height="50"><br>
                                       <a href="<?= BASE_URL . $row['image']; ?>" target="_blank">View </a>
                                                   <?php else: ?>
                                                <p>No Image available</p>
                                                 <?php endif; ?>
                                                
                                       </td>
                                       <td><?= $row['slug'] ?></td>
                                       <td><?= ($row['status'] == 1 ? 'Enable' : 'Disable') ?></td>
                                       <td><?= $row['tstp'] ?></td>
                                       <td>
                                       <a href="edit-category.php?id=<?=base64_encode($row['id'])?>" 
                                       onclick="return confirm('Are you sure you want to update this data?');">
                                        Update
                                     </a>
                                       </td>
                                       <td>
                                       <a href="delete-category.php?id=<?=base64_encode($row['id'])?>" 
                                       onclick="return confirm('Are you sure you want to delete this data?');">
                                        Delete
                                     </a>
                                       </td>

                                    </tr>
                                 <?php
                                 }
                                 ?>
                              </tbody>
                              
                           </table>
                           <a href="add-category.php">
                            <button class="btn btn-primary mb-3 panel-title" style="float: right;">
                         <i class="fa fa-plus" aria-hidden="true"></i>
                             </button>
                             </a>
                           <?php echo $pager->getPagination() ?>
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