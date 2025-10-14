<?php
require("config.php");
require("lib/Pager.php");
require('lock.php');

$where = [];
$sql_count = "SELECT count(*) as total FROM `payments` WHERE 1=1 ";
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

$sql   = "SELECT * FROM `payments` WHERE 1=1 ORDER BY id DESC LIMIT :start,:limit";
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
      .searchBtn
      {
          width:50%;
          padding:6px;
          margin-bottom:20px;
          border-radius: 15px;
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
               <h2>Manage Payments</h2>
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
        <div class="col-md-8">
            <input type="text" name="search" placeholder="Search Anything" id="userInputs" class="searchBtn">
            <button type="button" id="searchButton" class="btn btn-success">Search</button>
        </div>
    </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="panel">
                     <div class="panel-heading">
                        <h4 class="panel-title">Manage Payments</h4>
                        


                     </div>
                     <div class="panel-body">
                        <div class="example-box-wrapper">
                           <table id="datatable-tabletoolsw" class="table table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                 <tr>
                                    <th>Sr.No.</th>
                                 
                                  <th>Source</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Amount</th>
                                    <th>Download Receipt</th>
                                    <th>Status</th>
                                    <th>Time Stamp</th>
                                 </tr>
                              </thead>

                              <tbody id="searchData">
                                 <?php
                                 $i = $pager->getStart() + 1;
                                 foreach ($rows as $row) {
                                 ?>
                                    <tr>
                                       <td><?= $i; $i++ ?></td>
                                        <td><?= $row['source'] ?></td>
                                       <td><?= $row['name'] ?></td>
                                       <td><?= $row['email'] ?></td>
                                       <td><?= $row['mobile'] ?></td>
                                       <td><?= $row['amount'] ?></td>
                                       <td> <a href="<?= BASE_URL ?>receipt-form.php?id=<?=base64_encode($row['id'])?>" class="btn btn-danger "style="background:#5F5F5F">Receipt</a></td>
                                       <td><?= $row['payment_status'] ?></td>
                                       <td><?= $row['tstp'] ?></td>
                                      
                                      

                                    </tr>
                                 <?php
                                 }
                                 ?>
                              </tbody>
                              
                           </table>
                          
                           <?php echo $pager->getPagination() ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php include("include/footer-js.php"); ?>
     <script>
    document.getElementById('userInputs').addEventListener('input', function() {
        const userInput = this.value.trim().toLowerCase();
        const tableRows = document.querySelectorAll('#searchData tr');

        if (userInput.length >= 3) {
            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                if (rowText.includes(userInput)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        } else {
            tableRows.forEach(row => row.style.display = '');
        }
    });
</script>
</body>

</html>