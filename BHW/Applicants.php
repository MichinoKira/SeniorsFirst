<?php
// Start the session
session_start();

// Include the database configuration file
require_once '../db/db_config.php';

// Check if the user is logged in and has the 'brgy' role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'bhw') {
    header("Location: login.php"); // Redirect to login if not authorized
    exit();
}

// Fetch the BHW profile name based on the logged-in BHW ID
$bhw_ID = $_SESSION['username']; // Get the BHW ID from the session

try {
    // Prepare a statement to get the full name from the bhw_profile table
    $stmt = $pdo->prepare("SELECT * FROM bhw_profile WHERE bhw_id = :bhw_ID");
    $stmt->bindParam(':bhw_ID', $bhw_ID, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the profile data
    $bhw_profile = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the profile was found
    if ($bhw_profile) {
        $name = $bhw_profile['name'];
    } else {
        $name = "Unknown BHW"; // Fallback if no profile is found
    }
} catch (PDOException $e) {
    echo "Error fetching BHW profile: " . $e->getMessage();
    exit();
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Applicants</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link href="../Admin/admin_css/img/favicon.png" rel="icon">
  <link href="../Admin/admin_css/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="../Admin/admin_css/styles.css">
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

  <!-- Template Main CSS File -->
  <link href="../Admin/admin_css/style.css" rel="stylesheet">

 
</head>

<style>
  /* Default dropdown color */
.status-dropdown {
    color: white; /* Black text by default */
    text-align: center;
    background-color: white;
    border-radius: 30px;
    font-size: 13px;
    margin-top: 8px;
    font-weight: bold;
}

/* Specific colors for each status */
.status-dropdown.status-pending {
    background-color: gray;
}

.status-dropdown.status-approved {
    background-color: green;
}

.status-dropdown.status-denied {
    background-color: red;
}
</style>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="BHW-Dashboard.php" class="logo d-flex align-items-center">
        <img src="../Admin/admin_css/img/logo.png" alt="">
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
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['username']; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo htmlspecialchars($name); ?></h6>
              <span><?php echo htmlspecialchars($_SESSION['role']); ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="BHW_profile.php">
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
        <a class="nav-link collapsed " href="BHW-Dashboard.php">
          
          
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link " data-bs-target="#components-nav"  href="Applicants.php">
          <span>Applicants</span>
        </a>
        
      </li><!-- End Cluster-purok Nav -->

      <li class="nav-item">
        <a href="registered_seniors.php" class="nav-link collapsed" data-bs-target="#forms-nav" >
          <span>Registered Seniors</span>
        </a>
      </li><!-- End Forms Nav -->
     
    </ul>
    

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <div class="pagetitle-content">
          <img src="../Admin/admin_css/css/img/regs-logo.PNG" alt="Dashboard Icon" class="page-icon">
          <h1>Applicants</h1>
      </div>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="BHW-Dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Applicants</li>
          </ol>
      </nav>
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
                <th>#</th>
                <th>Name</th>
                <th>Address</th>
                <th>Birthdate</th>
                <th>Gender</th>
                <th>Approval</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
          // Query to fetch data
          $stmt = $pdo->query("SELECT * FROM bhw 
INNER JOIN bhw_profile ON bhw.bhw_id = bhw_profile.parent_id 
INNER JOIN user_profile ON bhw.purok_name = user_profile.purok_name 
WHERE bhw.purok_name = user_profile.purok_name
            ");
          $count = 1;

          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $status = $row['status']; // Status from the profile table

              echo "<tr>";
              echo "<td>" . $count++ . "</td>";
              echo "<td>" . htmlspecialchars($row['firstname'] . " " . $row['lastname']) . "</td>";
              echo "<td>" . htmlspecialchars($row['purok_name'] . " Brgy. " . $row['brgy'] . " " . $row['city']) . ", " . $row['province'] . "</td>";
              echo "<td>" . htmlspecialchars($row['dob']) . "</td>";
              echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
              echo "<td class='status-cell'>
                      <select class='form-select status-dropdown' data-parent-id='" . $row['parent_id'] . "'>
                          <option value='pending' " . ($status === 'pending' ? 'selected' : '') . ">Pending</option>
                          <option value='approved' " . ($status === 'approved' ? 'selected' : '') . ">Approved</option>
                          <option value='denied' " . ($status === 'denied' ? 'selected' : '') . ">Denied</option>
                      </select>
                    </td>";
              echo "<td class='action-column'>
                    <a href='archive.php?bhw_id=" . $row['bhw_id'] . "' class='btn btn-outline-secondary' title='Archive'>
                        <i class='fas fa-archive'></i>
                    </a>
                    </td>";
              echo "</tr>";
          }
        ?>
        </tbody>
    </table>

    <!-- Pagination Controls -->
    <div class="d-flex justify-content-between align-items-center mt-3" id="rowsPerPageSection">
        <span>1-1 of 1</span>
        <div class="pagination-controls d-flex align-items-center">
            <button class="btn btn-light"><i class="bi bi-chevron-left"></i></button>
            <input type="text" class="pagination-input mx-2" value="1/10">
            <button class="btn btn-light"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
</section>

<!-- Modal for Viewing Data -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Senior Citizen Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Details will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>

    <!-- JavaScript to Manage Popup and Save Logic -->
    <script>

document.addEventListener("DOMContentLoaded", function () {
    const statusDropdowns = document.querySelectorAll(".status-dropdown");

    function updateDropdownColor(dropdown) {
        const value = dropdown.value;
        dropdown.classList.remove("status-pending", "status-approved", "status-denied");

        if (value === "pending") {
            dropdown.classList.add("status-pending");
        } else if (value === "approved") {
            dropdown.classList.add("status-approved");
        } else if (value === "denied") {
            dropdown.classList.add("status-denied");
        }
    }

    // Initialize colors for existing dropdowns
    statusDropdowns.forEach(dropdown => {
        updateDropdownColor(dropdown);

        dropdown.addEventListener("change", function () {
            updateDropdownColor(this);

            const parentId = this.getAttribute("data-parent-id");
            const newStatus = this.value;

            // AJAX request to update status in the database
            fetch(`update_status.php`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ parent_id: parentId, status: newStatus }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Status updated successfully!");
                } else {
                    alert("Failed to update status. Please try again.");
                }
            })
            .catch(error => {
                console.error("Error updating status:", error);
            });
        });
    });
});



    </script>
</main>


<!-- End #main -->

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