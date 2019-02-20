<?php
session_start();
if(isset($_SESSION['company_id']))
{
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive admin dashboard and web application ui kit. Stylized tables to allow audience grabs the information in a glance.">
    <meta name="keywords" content="table, toolbar">

    <title>Reports | Purchase report</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
    <link href="../assets/css/core.min.css" rel="stylesheet">
    <link href="../assets/css/app.min.css" rel="stylesheet">
    <link href="../assets/css/style.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../datatables/CSS/buttons.bootstrap4.min.css" />
    <link rel="stylesheet" href="../datatables/CSS/dataTables.bootstrap4.min.css" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="../assets/img/apple-touch-icon.png">
    <link rel="icon" href="../assets/img/favicon.png">

  </head>

  <body class="sidebar-folded">

    <!-- Preloader -->
    <div class="preloader">
      <div class="spinner-dots">
        <span class="dot1"></span>
        <span class="dot2"></span>
        <span class="dot3"></span>
      </div>
    </div>
    <?php require_once('mainSidebar.php');?>
    <!-- Topbar -->
    <?php require_once('mainTopbar.php');?>
    <!-- END Topbar -->
    <!-- Main container -->
    <main>

      <header class="header bg-ui-general">
        <div class="header-action">
          <nav class="nav">
            <a class="nav-link" href="openingclosingReport.php">Stock Report</a>
            <a class="nav-link active" href="#">Purchase Report</a>
              <a class="nav-link" href="stockLedger.php">Stock Ledger</a>
            <!-- <a class="nav-link" href="customers.php">Customers</a>
            <a class="nav-link" href="products.php">Products and Services</a> -->
          </nav>
        </div>
      </header><!--/.header -->
      <div class="main-content">
        <div class="row">

          <div class="col-lg-12">
            <div class="card">
          <div class="card-body">
          <form class="validation" id="reportForm">
          <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                      <label class="require">From Date</label>
                  <input type="text" class="form-control" id="fromDate" tabindex="1" name="fromDate" data-placement="left" data-provide="datepicker" required>
                </div>
              </div>
                <div class="col-sm-2">
                  <div class="form-group">
                      <label class="require">To Date</label>
                  <input type="text" class="form-control" id="toDate" tabindex="2" name="toDate" data-placement="right" data-provide="datepicker"  required>
                </div>
              </div>
              <div class="col-sm-2">
                  <div class="form-group">
                    <div class="h-30px"></div>
                      <button class="btn btn-label  btn-primary" onclick="DisplayPurchaseReportTblDataOnclick()" type="button"><label><i class="ti-search fs-20"></i></label> Submit</button>
                  </div>
              </div>
          </div>
          </form>
          </div>
        </div>
        </div>


          <div class="col-lg-12">
            <div class="card">
              <h4 class="card-title"><strong>Purchase Report</strong></h4>
              <div class="card-body table-responsive" id="noDataDiv" style="display:none">

              </div>
              <div class="card-body table-responsive" id="allSalesTbldiv">

              <table class="table table-striped table-bordered" id="allSalesTbl" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th>#</th>
                      <th>Product/Service Name</th>
                      <th>Description</th>
                      <th>Date</th>
                      <th>Quantity</th>
                      <th>Rate</th>
                      <th>Purchase Total</th>
                      <th>Supplier Name</th>
                    </tr>
                  </thead>
                  <tbody id="tblData" >

                  </tbody>
                </table>

              </div>
            </div>
          </div>

        </div>


      </div><!--/.main-content -->


      <!-- Footer -->
      <footer class="site-footer">
        <div class="row">
          <div class="col-md-6">
            <p class="text-center text-md-left">Copyright © 2017 <a href="http://thetheme.io/theadmin">TheAdmin</a>. All rights reserved.</p>
          </div>

          <div class="col-md-6">
            <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
              <li class="nav-item">
                <a class="nav-link" href="../help/articles.html">Documentation</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../help/faq.html">FAQ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="https://themeforest.net/item/theadmin-responsive-bootstrap-4-admin-dashboard-webapp-template/20475359?license=regular&amp;open_purchase_for_item_id=20475359&amp;purchasable=source&amp;ref=thethemeio">Purchase Now</a>
              </li>
            </ul>
          </div>
        </div>
      </footer>
      <!-- END Footer -->

    </main>
    <!-- END Main container -->



    <!-- Global quickview -->
    <div id="qv-global" class="quickview" data-url="../assets/data/quickview-global.html">
      <div class="spinner-linear">
        <div class="line"></div>
      </div>
    </div>
    <!-- END Global quickview -->



    <!-- Scripts -->
    <script src="../assets/js/core.min.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/js/script.min.js"></script>
    <script src="../assets/vendor/moment/moment.min.js"></script>
    <!-- DataTables Links -->
    <script src="../datatables/jquery.dataTables.min.js"></script>
    <script src="../datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../datatables/dataTables.buttons.min.js"></script>
    <script src="../datatables/buttons.bootstrap4.min.js"></script>
    <script src="../datatables/jszip.min.js"></script>
    <script src="../datatables/pdfmake.min.js"></script>
    <script src="../datatables/vfs_fonts.js"></script>
    <script src="../datatables/buttons.html5.min.js"></script>
    <script src="../datatables/buttons.print.min.js"></script>
    <script src="../datatables/buttons.colVis.min.js"></script>
    <!-- Page Script -->
    <script src="../js/purchaseReport.js"></script>
  </body>
</html>
<?php
}
else {
  header("Location:login.php");
}
 ?>
