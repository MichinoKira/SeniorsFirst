<?php
// Start the session
session_start();

// Check if user is logged in and has the 'brgy' role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'brgy') {
    header("Location: ../users/login.php");
    exit();
}

// Include the database configuration file
require_once '../db/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $purok_id = $_POST['purok_id'] ?? null; // Existing purok_id for update
  $purok_name = $_POST['purok_name'] ?? null;
  $contact_person = $_POST['contact_person'] ?? null;
  $contact_number = $_POST['contact_number'] ?? null;
  $email_address = $_POST['email_address'] ?? null;

  if ($purok_name && $contact_person && $contact_number && $email_address) {
      try {
          // Begin a transaction
          $pdo->beginTransaction();

          if ($purok_id) {
              // Update existing record
              $stmt = $pdo->prepare("UPDATE puroks 
                  SET purok_name = ?, contact_person = ?, contact_number = ?, email_address = ?
                  WHERE purok_id = ?
              ");
              $stmt->execute([$purok_name, $contact_person, $contact_number, $email_address, $purok_id]);

              // Update parent_id for the updated record
              $updateStmt = $pdo->prepare("UPDATE puroks SET parent_id = ? WHERE purok_id = ?");
              $updateStmt->execute([$purok_id, $purok_id]);
          } else {
              // Insert new record
              $stmt = $pdo->prepare("INSERT INTO puroks (purok_name, contact_person, contact_number, email_address) 
                  VALUES (?, ?, ?, ?)
              ");
              $stmt->execute([$purok_name, $contact_person, $contact_number, $email_address]);

              // Get the last inserted purok_id
              $new_purok_id = $pdo->lastInsertId();

              // Update parent_id for the new record
              $updateStmt = $pdo->prepare("UPDATE puroks SET parent_id = ? WHERE purok_id = ?");
              $updateStmt->execute([$new_purok_id, $new_purok_id]);
          }

          // Commit the transaction
          $pdo->commit();

          $action = $purok_id ? 'updated' : 'added';
          echo "<script>alert('Purok $action successfully!');</script>";
      } catch (Exception $e) {
          // Rollback if there's an error
          $pdo->rollBack();
          die("Error: " . $e->getMessage());
      }
  } else {
      echo "Error: Please provide all required fields.";
  }
} else {
  echo "Invalid request method.";
}



// Fetch all purok records from the database
$stmt = $pdo->prepare("SELECT * FROM puroks");
$stmt->execute();
$puroks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Cluster / Purok - Manage</title>
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
  <link href="../Admin/admin_css/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../Admin/admin_css/css/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../Admin/admin_css/css/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../Admin/admin_css/css/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../Admin/admin_css/css/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../Admin/admin_css/css/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../Admin/admin_css/css/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../Admin/admin_css/css/style.css" rel="stylesheet">

 
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="../Admin/admin_css/img/logo.png" alt="">
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
        <a class="nav-link collapsed" href="index.php">
          
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link " data-bs-target="#components-nav"  href="cluster-purok-manage.php">
          <span>Cluster/Purok</span>
        </a>
       
      </li><!-- End Components Nav -->
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
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <span>Activity log</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav"  href="archive_list.php">
          <span>Archive Lists</span>
        </a>
      </li><!-- End Icons Nav -->


    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">
    <div class="pagetitle-content">
    <img src="../Admin/admin_css/css/img/cluster.PNG" alt="Dashboard Icon" class="page-icon">
        <h1><strong>Cluster / Purok</strong></h1>
    </div><!-- End Page Title -->

    <nav>

          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Cluster/Purok</li>
          </ol>
      </nav>
    <section class=" flex-column align-items-center min-vh-50 p-4 bg-light" id="contentContainer">
      <div class="container">
            <!-- Search Form with Magnifying Glass -->
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
                        <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                    </div>
                    <!-- Search Button -->
                    <button class="btn btn-success ms-2" onclick="searchTable()">Search</button>
                </div>
                <!-- ADD PUROK Button -->
                <button class="btn btn-primary ms-3" onclick="addNewSection()">
                    <i class="fas fa-plus"></i> Add Cluster Purok
                </button>
            </div>

            <!-- Table -->
            <table class="table table-striped" id="purokTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cluster Name</th>
                        <th>Contact Person</th>
                        <th>Contact Number</th>
                        <th>Email Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                    // Loop through each purok record and create a row in the table
                    foreach ($puroks as $index => $purok) {
                      echo "<tr>";
                      echo "<td>" . ($index + 1) . "</td>";
                      echo "<td>" . htmlspecialchars($purok['purok_name']) . "</td>";
                      echo "<td>" . htmlspecialchars($purok['contact_person']) . "</td>";
                      echo "<td>" . htmlspecialchars($purok['contact_number']) . "</td>";
                      echo "<td>" . htmlspecialchars($purok['email_address']) . "</td>";
                      echo "<td>
                            <button class='btn btn-link p-0' onclick='editPurok(" . $purok['purok_id'] . ")'> <i class='fas fa-edit'></i> </button>
                            </td>";
                      echo "</tr>";
                   }
                  ?>
                </tbody>
            </table>

            <!-- Rows per page section -->
            <div class="d-flex justify-content-end align-items-center mt-3" id="rowsPerPageSection">
            <span>1-1 of 1</span>
            <div class="pagination-controls d-flex align-items-center">
                  <button class="btn btn-light"><i class="bi bi-chevron-left"></i></button>
                  <input type="text" class="pagination-input mx-2" value="1/10">
                  <button class="btn btn-light"><i class="bi bi-chevron-right"></i></button>
              </div>
            </div>
        </div>
    </section>

    <!-- New Section for Adding Cluster -->
    <section id="popupSection" class="d-none">
        <div class="d-flex justify-content-center align-items-center min-vh-50 section-border">
            <div class="form-container border rounded p-4 bg-light">
                <div class="text-center mb-4">
                    <i class="fas fa-home fa-2x" style="color: black;"></i>
                    <h2 class="mt-2 underline">Cluster/Purok Information</h2>
                </div>
                <form method="POST" action="cluster-purok-manage.php" enctype="multipart/form-data">
                <input type="hidden" id="purok_id" name="purok_id" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="purok_name">Cluster/Purok Name</label>
                                <input type="text" class="form-control input-border" id="purok_name" name="purok_name" required>
                            </div>
                            <div class="form-group">
                                <label for="contact_number">Contact Number</label>
                                <input type="text" class="form-control input-border" id="contact_number" name="contact_number" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_person">Contact Person</label>
                                <input type="text" class="form-control input-border" id="contact_person" name="contact_person" required>
                            </div>
                            <div class="form-group">
                                <label for="email_address">Email Address</label>
                                <input type="email" class="form-control input-border" id="email_address" name="email_address" required>
                            </div>
                        </div>
                    </div>
                    <div class="button-group d-flex justify-content-between mt-3">
                        <button type="submit" class="btn btn-save">Save</button>
                        <button type="button" class="btn btn-cancel" onclick="cancelAddCluster()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- JavaScript to Manage Popup and Save Logic -->
    <script>
        function addNewSection() {
            // Hide the entire content container and rows per page section
            document.getElementById('contentContainer').style.display = 'none';
            document.getElementById('rowsPerPageSection').style.display = 'none';
            


            // Show the popup section
            document.getElementById('popupSection').classList.remove('d-none');
        }

        function cancelAddCluster() {
            // Show the content container and rows per page section
            document.getElementById('contentContainer').style.display = 'block';
            document.getElementById('rowsPerPageSection').style.display = 'flex'; 

            // Hide the popup section
            document.getElementById('popupSection').classList.add('d-none');
        }

        document.getElementById('searchInput').addEventListener('input', function() {
    const searchQuery = this.value; // Get the current value of the search input

    // Send the search query to the PHP script
    fetch('search_purok.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ query: searchQuery }), // Pass the search query
    })
    .then(response => response.json())
    .then(data => {
        const tbody = document.querySelector('#purokTable tbody');
        tbody.innerHTML = ''; // Clear existing data

        // Populate the table with fetched data
        data.forEach((row, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${index + 1}</td>
                <td>${row.purok_name}</td>
                <td>${row.contact_person}</td>
                <td>${row.contact_number}</td>
                <td>${row.email_address}</td>
                <td>
                    <button class="btn btn-sm btn-primary">Edit</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    })
    .catch(error => console.error('Error:', error));
});

        function editPurok(purokId) {
            // Fetch the purok details from the database
            fetch('get_purok.php?purok_id=' + purokId)
                .then(response => response.json())
                .then(data => {
                    // Populate the form fields with the existing data
                    document.getElementById('purok_name').value = data.purok_name;
                    document.getElementById('contact_person').value = data.contact_person;
                    document.getElementById('contact_number').value = data.contact_number;
                    document.getElementById('email_address').value = data.email_address;

                    // Store the ID in a hidden field or variable
                    document.getElementById('purok_id').value = data.purok_id;

                    // Show the popup section
                    document.getElementById('popupSection').classList.remove('d-none');
                    document.getElementById('contentContainer').style.display = 'none';
                    document.getElementById('rowsPerPageSection').style.display = 'none';
                })
                .catch(error => console.error('Error:', error));
        }

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
  <script src="../Admin/admin_css/js/main.js"></script>

</body>

</html>