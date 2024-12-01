<?php
// Start the session
session_start();

// Include the database configuration file
require_once '../db/db_config.php';

// Check if the user is logged in and has the 'brgy' role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'brgy') {
    header("Location: login.php"); // Redirect to login if not authorized
    exit();
}

// Function to fetch total clusters
function getTotalClusters($pdo) {
    $query = "SELECT COUNT(*) AS total_puroks FROM puroks";
    
    try {
        $stmt = $pdo->prepare($query); // Prepare the statement
        $stmt->execute(); // Execute the statement
        $row = $stmt->fetch(); // Fetch the result
        return $row['total_puroks']; // Return the total number of puroks
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // Handle query errors
    }
}

// Call the function to get the total clusters
$total_puroks = getTotalClusters($pdo);

// Debugging: Display the total number of puroks
echo "Total Puroks: " . $total_puroks; // You can comment this out after testing

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SeniorsFirst</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../Admin/admin_css/css/img/favicon.png" rel="icon">
  <link href="../Admin/admin_css/css/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../Admin/admin_css/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../Admin/admin_css/css/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../Admin/admin_css/css/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../Admin/admin_css/css/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../Admin/admin_css/css/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../Admin/admin_css/css/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../Admin/admin_css/css/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../Admin/admin_css/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="../Admin/admin_css/css/img/logo.png" alt="">
        <span class="d-none d-lg-block">SeniorsFirst</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->
    

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        

          </a><!-- End Messages Icon -->


          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../Admin/admin_css/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">Noel Layda</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Noel Layda</h6>
              <span>Admin</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../users/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
  

  <!-- ======= Sidebar ======= -->
   
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="index.php">
          </i><span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav"  href="cluster-purok-manage.php">
          <span>Cluster/Purok</span>
        </a>
      </li><!-- End Cluster-purok Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="reg-seniors.php">
          
          <span>Registered Seniors</span>
        </a></li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="Users-BHW.php">
              <span>BHW</span>
            </a>
          </li>
          <li>
            <a href="User-seniors.php">
              <span>Seniors</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
            <span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
                <a href="report_withoutPensions.php">
                    <span>Without Pension</span>
                </a>
            </li>
            <li>
                <a class="nav-link collapsed" data-bs-target="#graphical-reports-nav" data-bs-toggle="collapse" href="Reports-Graphical-WithoutPensionsReports.html">
                    <span>Graphical reports</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="graphical-reports-nav" class="nav-content collapse">
                    <li>
                      <a href="Reports-Graphical-AgeReport.html">
                          <span><strong>Age Report</strong></span>
                      </a>
                  </li>
                    <li>
                        <a href="Reports-Graphical-WithoutPension.html">
                            <span><strong>Without Pensions Reports</strong></span>
                        </a>
                    </li>
                    <li>
                        <a href="Report-GraphicalCP.html">
                            <span>Cluster/Purok</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav"  href="Activity-logs.php">
          <span>Activity log</span>
        </a>
      </li>
          
      <li class="nav-item"></li>
        <a class="nav-link collapsed" data-bs-target="#icons-nav"  href="archive_list.php">
          <span>Archive Lists</span>
        </a>
    

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <div class="pagetitle-content">
          <img src="../Admin/admin_css/css/img/Dash-logo.PNG" alt="Dashboard Icon" class="page-icon">
          <h1>Dashboard</h1>
      </div>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
          </ol>
      </nav>
  </div><!-- End Page Title -->

    <section class="py-5">
      <div class="container">
          <!-- First row -->
          <div class="row text-center g-4">
              <div class="col-md-6 d-flex justify-content-center">
                  <div class="container-box">
                      <img src="../Admin/admin_css/css/img/cluster-icon.PNG" alt="Cluster" class="image">
                      <div class="content">
                          <h5>CLUSTER</h5>
                          <div class="counter"><?php echo $total_puroks; ?></div>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 d-flex justify-content-center">
                  <div class="container-box">
                      <img src="../Admin/admin_css/css/img/withpension-icon.PNG" alt="With Pension" class="image">
                      <div class="content">
                          <h5>WITH PENSION</h5>
                          <div class="counter">234</div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- Second row -->
          <div class="row text-center g-4">
              <div class="col-md-6 d-flex justify-content-center">
                  <div class="container-box">
                      <img src="../Admin/admin_css/css/img/male-icon.PNG" alt="Male" class="image">
                      <div class="content">
                          <h5>MALE</h5>
                          <div class="counter">345</div>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 d-flex justify-content-center">
                  <div class="container-box">
                      <img src="../Admin/admin_css/css/img/reg-seniors-icon.PNG" alt="Registered Seniors" class="image">
                      <div class="content">
                          <h5>REGISTERED SENIORS</h5>
                          <div class="counter">456</div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- Third row -->
          <div class="row text-center g-4">
              <div class="col-md-6 d-flex justify-content-center">
                  <div class="container-box">
                      <img src="../Admin/admin_css/css/img/without-pen.PNG" alt="Without Pension" class="image">
                      <div class="content">
                          <h5>WITHOUT PENSION</h5>
                          <div class="counter">567</div>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 d-flex justify-content-center">
                  <div class="container-box">
                      <img src="../Admin/admin_css/css/img/fem-icon.PNG" alt="Female" class="image">
                      <div class="content">
                          <h5>FEMALE</h5>
                          <div class="counter">678</div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    
    
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../Admin/admin_css/css/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../Admin/admin_css/css/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../Admin/admin_css/css/vendor/chart.js/chart.umd.js"></script>
  <script src="../Admin/admin_css/css/vendor/echarts/echarts.min.js"></script>
  <script src="../Admin/admin_css/css/vendor/quill/quill.js"></script>
  <script src="../Admin/admin_css/css/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../Admin/admin_css/css/vendor/tinymce/tinymce.min.js"></script>
  <script src="../Admin/admin_css/css/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../Admin/admin_css/css/js/main.js"></script>


</body>

</html>