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

$stmt = $pdo->prepare("SELECT * FROM puroks");
$stmt->execute();
$puroks = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $purokId = isset($_POST['purok_name']) ? $_POST['purok_name'] : null;
  $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : null;
  $contactNumber = isset($_POST['contact_number']) ? $_POST['contact_number'] : null;
  $username = isset($_POST['username']) ? $_POST['username'] : null;
  $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

  // Check if any required field is null
  if (is_null($purokId) || is_null($fullname) || is_null($contactNumber) || is_null($username) || is_null($password)) {
    $_SESSION['message'] = 'All fields are required.';
    $_SESSION['message_type'] = 'error';
  } else {
      // Fetch purok_name using the purokId
      $stmt = $pdo->prepare("SELECT purok_name FROM puroks WHERE purok_id = :purokId");
      $stmt->bindParam(':purokId', $purokId);
      $stmt->execute();
      $purok = $stmt->fetch(PDO::FETCH_ASSOC);

      $_SESSION['message'] = 'BHW account successfully added!';
      $_SESSION['message_type'] = 'success';
      
      // Check if purok_name is found
      if ($purok) {
          $purokName = $purok['purok_name'];

          // Prepare SQL statement to insert BHW account
          $stmt = $pdo->prepare("INSERT INTO BHW (purok_name, fullname, contact_number, username, password, role, created_at) VALUES (:purokName, :fullname, :contactNumber, :username, :password, 'bhw', NOW())");

          // Bind parameters
          $stmt->bindParam(':purokName', $purokName);
          $stmt->bindParam(':fullname', $fullname);
          $stmt->bindParam(':contactNumber', $contactNumber);
          $stmt->bindParam(':username', $username);
          $stmt->bindParam(':password', $password);

          // Execute the statement
          if ($stmt->execute()) {
              echo "<script>alert('BHW account successfully added!');</script>";
          } else {
              echo "<script>alert('Error adding BHW account.');</script>";
          }
      } else {
          echo "<script>alert('Invalid Purok ID.');</script>";
      }
  }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Users - BHW</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link href="../Admin/admin_css/img/favicon.png" rel="icon">
  <link href="../Admin/admin_css/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Vendor CSS Files -->
  <link href="../Admin/admin_css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../Admin/admin_css/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../Admin/admin_css/style.css" rel="stylesheet">
  <link href="../Admin/admin_css/css/style.css" rel="stylesheet">

 
</head>

<body>
  <style>
    .badge {
  cursor: pointer;
  outline: 1px solid black; /* Customize the color and thickness of the outline */
}

.badge:hover {
  outline: 1px solid black; /* Customize the hover outline color */
}

.btn-outline-secondary {
    font-size: 18px; /* Adjust icon size */
    color: #6c757d;  /* Icon color */
}

.btn-outline-secondary:hover {
    color: red; /* Icon color on hover */
}
  </style>

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
        <a class="nav-link collapsed " data-bs-target="#components-nav"  href="cluster-purok-manage.php">
          <span>Cluster-Purok</span>
        </a>
       
      </li><!-- End Components Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="reg-seniors.php">
          
          <span>Registered Seniors</span>
        </a></li><!-- End Forms Nav -->

        <li class="nav-item">
          <a class="nav-link " data-bs-target="#tables-nav" data-bs-toggle="collapse" href="Users-BHW.html">
            <span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="tables-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
            <li>
              <a href="Users-BHW.php" class="active">
                <i class="bi bi-circle"></i><span>BHW</span>
              </a>
            </li>
            <li>
              <a href="User-seniors.php" >
                <i class="bi bi-circle"></i><span>Seniors</span>
              </a>
            </li>
          </ul>
        </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="charts-chartjs.html">
              <i class="bi bi-circle"></i><span>Chart.js</span>
            </a>
          </li>
          <li>
            <a href="charts-apexcharts.html">
              <i class="bi bi-circle"></i><span>ApexCharts</span>
            </a>
          </li>
          <li>
            <a href="charts-echarts.html">
              <i class="bi bi-circle"></i><span>ECharts</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <span>Activity log</span>
        </a>
      </li>

      <li class="nav-item"></li>
        <a class="nav-link collapsed" data-bs-target="#icons-nav"  href="archive_list.php">
          <span>Archive Lists</span>
        </a>
      </li><!-- End Icons Nav -->


    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

  <div class="pagetitle">
  <div class="pagetitle-content">
    <img src="../Admin/admin_css/css/img/bhw.PNG" alt="Dashboard Icon" class="page-icon">
      <h1><strong>BHW Accounts</strong></h1></div>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item active">Users / BHW accounts</li>
          </ol>
      </nav><!-- End Page Title -->

    <section class="flex-column align-items-center min-vh-50 p-4 bg-light" id="contentContainer">
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
                        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                    </div>
                    <!-- Search Button -->
                    <button class="btn btn-success ms-2" id="searchButton">Search</button>
                </div>
                <!-- ADD BHW Button -->
                <button class="btn btn-primary ms-3" onclick="addNewSection()">
                    <i class="fas fa-plus"></i> Add BHW
                </button>
            </div>
    
            <!-- Table -->
            <table class="table table-striped" id="bhwTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cluster/Purok</th>
                        <th>Name</th>
                        <th>Contact #</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      // Query to fetch user data
                      $stmt = $pdo->query("SELECT bhw.*, bhw_profile.* FROM BHW INNER JOIN bhw_profile ON BHW.bhw_id = bhw_profile.bhw_id");
                      $count = 1;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                          $status = $row['status']; // Assuming 'status' is a column in the 'BHW' table
                          $badgeClass = ($status === 'inactive') ? 'bg-danger' : 'bg-success';
                          $badgeText = ($status === 'inactive') ? 'Inactive' : 'Active';

                          echo "<tr>";
                          echo "<td>" . $count++ . "</td>";
                          echo "<td>" . htmlspecialchars($row['purok_name']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['contact_number']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['zone'] . " Brgy. " . $row['brgy'] . " " . $row['city']) . ", " . $row['province']. "</td>";
                          echo "<td class='status-cell'>
                                  <span class='badge " . $badgeClass . "' data-bhw-id='" . $row['bhw_id'] . "' data-status='" . $status . "' onclick='toggleStatus(this)'>" . $badgeText . "</span>
                                </td>";
                          echo "<td class='action-column'>
                                <!-- Archive Icon -->
                                <a href='archive.php?bhw_id=" . $row['bhw_id'] . "' class='btn btn-outline-secondary' title='Archive'>
                                    <i class='fas fa-archive'></i>
                                </a>
                                </td>";                           
                          echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-end align-items-center mt-3" id="excel">
            <button class="btn btn-secondary" onclick="window.location.href='export_bhw.php'">Export to Excel</button>
            </div>
    
            <!-- Rows per page section -->
            <div class=" d-flex justify-content-end align-items-center mt-3" id="rowsPerPageSection">
                <label for="rowsPerPage" class="mr-2">Rows per page:</label>
                <select id="rowsPerPage" class="form-control w-auto">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
    </section>

     <!-- New Section for Adding BHW -->
     <section id="profilePopupSectionBHWuser" class="d-none">
      <div class="d-flex justify-content-center align-items-center min-vh-100">
          <div class="profile-form-containerBHWuser border rounded p-4 bg-light">
              <div class="text-center mb-3">
                  <i class="profile-iconBHWuser fas fa-user fa-2x"></i>
                  <h2 class="profile-titleBHWuser mt-2">BHW Profile Information</h2>
              </div>
              <?php
                if (isset($_SESSION['message'])) {
                    echo "<div class='alert alert-" . ($_SESSION['message_type'] == 'success' ? 'success' : 'danger') . "'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message'], $_SESSION['message_type']);
                }
              ?>
              <form method="POST" action="Users-BHW.php" enctype="multipart/form-data">
                  <div class="form-group">
                      <label class="form-labelBHWuser" for="clusterNameBHWuser">Cluster Name</label>
                      <div class="input-group">
                          <select id="purok_select" name="purok_name" class="form-inputBHWuser input-extendedBHWuser" onchange="handleClusterChange()">
                              <option value="">Select a cluster/Purok</option>
                              <?php foreach ($puroks as $purok): ?>
                                <option value="<?= $purok['purok_id']; ?>"><?= htmlspecialchars($purok['purok_name']); ?></option>
                            <?php endforeach; ?>
                          </select>
                          <input type="text" id="custom_purok_name" name="custom_purok_name" class="form-inputBHWuser input-extendedBHWuser d-none" placeholder="Type custom cluster name" />
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="form-labelBHWuser" for="fullNameBHWuser">Full Name</label>
                              <input type="text" class="form-inputBHWuser input-roundedBHWuser" id="fullname" name="fullname">
                          </div>
                          <div class="form-group">
                              <label class="form-labelBHWuser" for="usernameBHWuser">Username</label>
                              <input type="text" class="form-inputBHWuser input-roundedBHWuser" id="username" name="username">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="form-labelBHWuser" for="contactNumberBHWuser">Contact Number</label>
                              <input type="text" class="form-inputBHWuser input-roundedBHWuser" id="contact_number" name="contact_number">
                          </div>
                          <div class="form-group">
                              <label class="form-labelBHWuser" for="passwordBHWuser">Password</label>
                              <input type="password" class="form-inputBHWuser input-roundedBHWuser" id="password" name="password">
                          </div>
                      </div>
                  </div>
                  <div class="button-group-centerBHWuser mt-4">
                      <button type="submit" class="btn-save-profileBHWuser" onclick="saveAccount()">Add Account</button>
                      <button type="button" class="btn-cancel-profileBHWuser" onclick="cancelAccount()">Cancel</button>
                  </div>
              </form>
          </div>
      </div>
  </section>
  
  <!-- JavaScript to Fetch Data and Populate Table -->
  <script>

    function addNewSection() {
            // Hide the entire content container and rows per page section
            document.getElementById('contentContainer').style.display = 'none';
            document.getElementById('rowsPerPageSection').style.display = 'none';
            // Show the popup section
            document.getElementById('profilePopupSectionBHWuser').classList.remove('d-none');
        }

        // Get the form element
  function saveAccount() {
            const form = document.querySelector('form');

            // Submit the form via POST
            form.submit();
        }

        function cancelAccount() {
            // Logic to cancel the account creation (e.g., hide the form)
            document.getElementById('profilePopupSectionBHWuser').classList.add('d-none');
            document.getElementById('contentContainer').style.display = 'block';
            document.getElementById('rowsPerPageSection').style.display = 'flex'; 
        }

        // Function to filter the table based on the search input
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#bhwTable tbody tr');

            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                let found = false;

                // Check each cell for the search term
                for (let cell of cells) {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        found = true;
                        break; // If a match is found, no need to check other cells
                    }
                }

                // Show or hide the row based on the search term
                row.style.display = found ? '' : 'none';
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
    // When a badge is clicked
    document.querySelectorAll('.status-cell .badge').forEach(function(badge) {
        badge.addEventListener('click', function() {
            // Get the current status from data-status attribute
            var currentStatus = badge.getAttribute('data-status');
            var bhwId = badge.getAttribute('data-bhw-id');

            // Toggle status
            var newStatus = (currentStatus === 'active') ? 'inactive' : 'active';

            // Update badge class and text
            if (newStatus === 'inactive') {
                badge.classList.remove('bg-success');
                badge.classList.add('bg-danger');
                badge.textContent = 'Inactive';
            } else {
                badge.classList.remove('bg-danger');
                badge.classList.add('bg-success');
                badge.textContent = 'Active';
            }

            // Update data-status attribute to reflect the new status
            badge.setAttribute('data-status', newStatus);

            // Send AJAX request to update the status in the database
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../Admin/update_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText); // This is for debugging
                }
            };
            // Send bhw_id and new status to the server
            xhr.send('bhw_id=' + bhwId + '&status=' + newStatus);
        });
    });
});


</script>
  
  
  </main><!-- End #main -->

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
  <script src="assets/js/main.js"></script>

</body>

</html>