<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Activity logs</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link href="../Admin/admin_css/css/img/favicon.png" rel="icon">
  <link href="../Admin/admin_css/css/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="../Admin/admin_css/css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <<link href="../Admin/admin_css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../Admin/admin_css/css/style.css" rel="stylesheet">

 
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="../Admin/admin_css/css/img/logo.png" alt="">
        <span class="d-none d-lg-block">SeniorsFirst</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
          </a>
        </li><!-- End Search Icon-->

          </a><!-- End Notification Icon -->

          
          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->


        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="css/img/profile-img.jpg" alt="Profile" class="rounded-circle">
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
              <a class="dropdown-item d-flex align-items-center" href="#">
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
        <a class="nav-link collapsed" href="index.php">
          
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav"  href="cluster-purok-manage.php">
          <span>Cluster-Purok</span>
        </a>
       
      </li><!-- End Components Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="reg-seniors.php">
          
          <span>Registered Seniors</span>
        </a></li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          </i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
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
                <a href="Report-withoutPension.php">
                    <span>Without Pension</span>
                </a>
            </li>
            <li>
                <a class="nav-link collapsed" data-bs-target="#graphical-reports-nav" data-bs-toggle="collapse" href="Report-Graphical-withoutPensions.php">
                    <span>Graphical reports</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="graphical-reports-nav" class="nav-content collapse">
                    <li>
                      <a href="Report-Graphical-AgeReport.php">
                          <span><strong>Age Report</strong></span>
                      </a>
                  </li>
                    <li>
                        <a href="Report-Graphical-WithoutPension.php">
                            <span><strong>Without Pensions Reports</strong></span>
                        </a>
                    </li>
                    <li>
                        <a href="Report-GraphicalCP.php">
                            <span>Cluster/Purok</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link " data-bs-target="#icons-nav" data-bs-toggle="collapse" href="Activity-logs.php">
          <span>Activity logs</span>
        </a>
      </li>
      <li class="nav-item"></li>
        <a class="nav-link collapsed" data-bs-target="#icons-nav" href="archive_list.php">
          <span>Archive Lists</span>
        </a>
      </li><!-- End Icons Nav -->


    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <div class="pagetitle-content">
          <img src="../Admin/admin_css/css/img/regs-logo.PNG" alt="Dashboard Icon" class="page-icon">
          <h1>Activity Logs</h1>
      </div>
  </div><!-- End Page Title -->

  <section class="container my-5">
    <!-- Search and Filter -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex w-100 align-items-center">
            <!-- Filter Icon -->
            <button class="btn btn-outline-secondary me-2">
                <i class="fas fa-filter"></i>
            </button>
            <!-- Search Bar -->
            <div class="input-group flex-grow-1">
                <span class="input-group-text">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" class="form-control" placeholder="Search...">
            </div>
            <!-- Search Button -->
            <button class="btn btn-success ms-2">Search</button>
        </div>
    </div>

    <!-- User Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>DATE AND TIME</th>
                <th>ACCOUNT</th>
                <th>BHW</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2024/05/07 11:20AM</td>
                <td>RODOLFO E. VARGAS</td>
                <td>REMAR RELIQUIAS</td>
                <td><strong>SET STATUS: </strong> <span class="badge bg-success"> Active</span></td>
                <td>
                  <div style="display: flex; justify-content: center;">
                    <button class="btn action-btn" onclick="viewBHWInfo(1)" style="background-color: green; color: white;">
                      <i class="fas fa-undo"></i>
                    </button>
                  </div>
                </td>
            </tr>
            
            <tr>
                <td>2024/05/07 11:20AM</td>
                <td>RODOLFO E. VARGAS</td>
                <td>REMAR RELIQUIAS</td>
                <td><strong>SET ARRPROVAL: </strong> <span class="badge bg-success"> APPROVED</span></td>
                <td>
                  <div style="display: flex; justify-content: center;">
                    <button class="btn action-btn" onclick="viewBHWInfo(1)" style="background-color: green; color: white;">
                      <i class="fas fa-undo"></i>
                    </button>
                  </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-items-center mt-3" id="rowsPerPageSection">
      <span>1 of 1</span>
      <div class="pagination-controls d-flex align-items-center">
          <button class="btn btn-light"><i class="bi bi-chevron-left"></i></button>
          <input type="text" class="pagination-input mx-2" value="1/10">
          <button class="btn btn-light"><i class="bi bi-chevron-right"></i></button>
      </div>
  </div>
</div>
</section>
  </main>



<!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
   
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../Admin/admin_css/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../Admin/admin_css/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../Admin/admin_css/vendor/chart.js/chart.umd.js"></script>
  <script src="../Admin/admin_css/vendor/echarts/echarts.min.js"></script>
  <script src="../Admin/admin_css/vendor/quill/quill.js"></script>
  <script src="../Admin/admin_css/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../Admin/admin_css/vendor/tinymce/tinymce.min.js"></script>
  <script src="../Admin/admin_css/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../Admin/admin_css/css/js/main.js"></script>

</body>

</html>