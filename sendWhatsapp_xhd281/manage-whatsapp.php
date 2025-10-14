<?php
require("config.php");
require("lib/Pager.php");
require('lock.php');

// Get status counts
$statusCountSql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                    SUM(CASE WHEN status = 'sent' THEN 1 ELSE 0 END) as sent_count,
                    SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) as failed_count
                   FROM whatsapp_logs";
$statusStmt = $DB->DB->prepare($statusCountSql);
$statusStmt->execute();
$statusCounts = $statusStmt->fetch(PDO::FETCH_ASSOC);

$where = [];
$sql_count = "SELECT count(*) as total FROM `whatsapp_logs` WHERE 1=1 ";
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

$sql   = "SELECT w.* 
          FROM `whatsapp_logs` w 
          WHERE 1=1 
          ORDER BY w.id DESC 
          LIMIT :start,:limit";
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
               <h2>Manage WhatsApp Messages</h2>
            </div>
            <!--=========*************= End====**********===========-->
            <?php
            if (isset($_SESSION['msg'])) {
               $alertType = ($_SESSION['msg_type'] == "success") ? "alert-success" : "alert-danger";
               echo "<div class='alert $alertType'>" . $_SESSION['msg'] . "</div>";
               unset($_SESSION['msg']);
               unset($_SESSION['msg_type']);
            }
            ?>
            
            <!-- Status Dashboard Cards -->
            <div class="row" style="margin-bottom: 20px;">
               <div class="col-md-3">
                  <div class="panel" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                     <div class="panel-body text-center">
                        <h1 style="margin: 10px 0; color: white;"><?= number_format($statusCounts['total']) ?></h1>
                        <h4 style="margin: 0; color: white;"><i class="fa fa-list"></i> Total Messages</h4>
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="panel" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                     <div class="panel-body text-center">
                        <h1 style="margin: 10px 0; color: white;"><?= number_format($statusCounts['pending_count']) ?></h1>
                        <h4 style="margin: 0; color: white;"><i class="fa fa-clock-o"></i> Pending</h4>
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="panel" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                     <div class="panel-body text-center">
                        <h1 style="margin: 10px 0; color: white;"><?= number_format($statusCounts['sent_count']) ?></h1>
                        <h4 style="margin: 0; color: white;"><i class="fa fa-check-circle"></i> Sent</h4>
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="panel" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                     <div class="panel-body text-center">
                        <h1 style="margin: 10px 0; color: white;"><?= number_format($statusCounts['failed_count']) ?></h1>
                        <h4 style="margin: 0; color: white;"><i class="fa fa-times-circle"></i> Failed</h4>
                     </div>
                  </div>
               </div>
            </div>
            <!-- End Status Dashboard Cards -->

            <div class="row">
               <div class="col-md-12">
                  <div class="panel">
                     <div class="panel-heading">
                        <h4 class="panel-title">Manage WhatsApp Messages</h4>
                        <div class="panel-heading-controls">
                          
                           <a href="bulk-upload-whatsapp.php" class="btn btn-primary" style="margin-right: 5px;">
                              <i class="glyph-icon icon-upload"></i> Bulk Upload
                           </a>
                           <a href="send-whatsapp.php" class="btn btn-success">
                              <i class="glyph-icon icon-plus"></i> Send Single Message
                           </a>
                        </div>
                     </div>
                     <div class="panel-body">
                        <div class="example-box-wrapper">
                           <table id="datatable-tabletoolsw" class="table table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                 <tr>
                                    <th>Sr.No.</th>
                                    <th>Donor Name</th>
                                    <th>Mobile</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date & Time</th>
                                    <th>Delete</th>
                                 </tr>
                              </thead>

                              <tbody>
                                 <?php
                                 $i = $pager->getStart() + 1;
                                 foreach ($rows as $row) {
                                 ?>
                                    <tr>
                                       <td><?= $i ?></td>
                                       <td><?= htmlspecialchars($row['name']) ?></td>
                                       <td><?= htmlspecialchars($row['mobile']) ?></td>
                                       <td>₹<?= number_format($row['amount'], 2) ?></td>
                                       <td>
                                          <?php if ($row['status'] == 'sent'): ?>
                                             <span class="label label-success">Sent</span>
                                          <?php elseif ($row['status'] == 'pending'): ?>
                                             <span class="label label-warning">Pending</span>
                                          <?php else: ?>
                                             <span class="label label-danger">Failed</span>
                                          <?php endif; ?>
                                       </td>
                                       <td><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></td>
                                       <td>
                                          <a href="delete-whatsapp.php?id=<?= $row['id'] ?>" 
                                             class="btn btn-danger btn-sm"
                                             onclick="return confirm('Are you sure you want to delete this record?')">
                                             <i class="glyph-icon icon-trash"></i> Delete
                                          </a>
                                       </td>
                                    </tr>
                                 <?php
                                    $i++;
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
   </div>

   <?php include("include/footer-js.php"); ?>
</body>
</html>
