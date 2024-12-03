<?php
// Start the session
session_start();

// Include the database configuration file
require_once '../db/db_config.php';

// Check if user is logged in and has the 'brgy' role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'brgy') {
    header("Location: ../users/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetch_purok_data'])) {
  // Prepare the query to count approved users per purok
  $query = "SELECT p.purok_name, COUNT(up.approval_status) AS approved_count
            FROM puroks p
            LEFT JOIN user_profile up ON p.purok_name = up.purok_name
            WHERE up.approval_status = 'approved'
            GROUP BY p.purok_name
            ORDER BY FIELD(p.purok_name, 'Zone 1', 'Zone 2', 'Dalaguete', 'Ols', 'Obong', 
                           'Salvacion', 'Hospital Site', 'Baybay Bacuyangan', 'Cubay', 'Bongyod', 
                           'Canlabac', 'Sangke', 'Catmon', 'Housing', 'Spur 3', 'Codianan', 
                           'Spur A2', 'Spur 4', 'Spur 1', 'Inoli')";

  // Execute the query
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  
  // Fetch the result and encode it as JSON
  echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Graphical Cluster / Purok</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link href="../Admin/admin_css/css/img/favicon.png" rel="icon">
  <link href="../Admin/admin_css/css/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="css/GraphicalR-Withoutpen.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../Admin/admin_css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../Admin/admin_css/css/style.css" rel="stylesheet">
  <link href="../Admin/admin_css/css/GraphicalR-Withoutpen.css" rel="stylesheet">
 
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
        <a class="nav-link collapsed " data-bs-target="#components-nav"  href="cluster-purok-manage.php">
          <span>Cluster-Purok</span>
        </a>
       
      </li><!-- End Components Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="reg-seniors.php">
          
          <span>Registered Seniors</span>
        </a></li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="Users-BHW.php">
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
        <a class="nav-link" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="report_withoutPensions.php">
            <span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
            <li>
                <a href="report_withoutPensions.php">
                    </i><span>Without Pension</span>
                </a>
            </li>
            <li>
                <a class="nav-link collapsed" data-bs-target="#graphical-reports-nav" data-bs-toggle="collapse" href="Report-Graphical-AgeReport.php">
                <span>Graphical reports</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="graphical-reports-nav" class="nav-content collapse show">
                  <li>
                    <a href="Report-Graphical-AgeReport.php" >
                        <i class="bi bi-circle"></i><span><strong>Age Report</strong></span>
                    </a>
                </li>
                    <li>
                        <a href="Report-Graphical-WithoutPension.php" >
                            <i class="bi bi-circle"></i><span><strong>Without Pensions Reports</strong></span>
                        </a>
                    </li>
                    <li>
                        <a href="Report-GraphicalCP.php" class="active">
                          <i class="bi bi-circle"></i><span><span>Cluster/Purok</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li><!-- End Icons Nav -->
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav"  href="Activity-logs.php">
          <span>Activity logs</span>
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
          <img src="../Admin/admin_css/css/img/regs-logo.PNG" alt="Dashboard Icon" class="page-icon">
          <h1>Cluster / Purok  Report</h1>
      </div>
  </div><!-- End Page Title -->
  <form class="report-form">
    <section class="pension-report-section">
      <div class="report-content">
          <div class="report-table">
              <h2 style="font-weight: bold;">Report By Cluster / Purok</h2>
              <table id="purokTable">
                  <tr>
                      <th>Cluster Name</th>
                      <th>Number</th>
                  </tr>
              </table>
          </div>
  
          <div class="graph">
              <button class="print-button" onclick="printSection()">Print</button>
              <h2>Graphical Representation Clusters / Purok</h2>
              <canvas id="purokChart" width="400" height="200"></canvas>
          </div>
      </div>
  </section>
  
</form>

<script>
  // Function to fetch data and render the table and graph
  async function fetchPurokData() {
            try {
                // Fetch data from the server
                const response = await fetch('?fetch_purok_data=true');
                const data = await response.json();
                
                // Render the table
                const tableBody = document.querySelector('#purokTable tbody');
                tableBody.innerHTML = '';  // Clear any previous rows
                data.forEach(item => {
                    const row = document.createElement('tr');
                    const cell1 = document.createElement('td');
                    const cell2 = document.createElement('td');
                    cell1.textContent = item.purok_name;
                    cell2.textContent = item.approved_count;
                    row.appendChild(cell1);
                    row.appendChild(cell2);
                    tableBody.appendChild(row);
                });

                // Prepare data for the graph
                const labels = data.map(item => item.purok_name);
                const counts = data.map(item => item.approved_count);

                // Create the graph using Chart.js
                const ctx = document.getElementById('purokChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar', // Bar chart
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Approved Count',
                            data: counts,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        // Call the function to fetch data and render table and chart
        fetchPurokData();

  // Function to print the report section
  function printSection() {
      const printContents = document.querySelector('.pension-report-section').innerHTML;
      const originalContents = document.body.innerHTML;
      
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
  }

  // Call the generateChart function when the page loads
  window.onload = generateChart;
</script>
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