<?php 
session_start();

// Check if the user is logged in by verifying 'user_id' is set
if (!isset($_SESSION['user_id'])) {
  header("Location: auth/login.php");
  exit();
}

// Set user role with default as 'user'
$user_role = $_SESSION['role'] ?? 'user';

require 'includes/functions.php'; 
include 'includes/header.php'; 

// Set limit of jobs per page
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$jobs = getJobs($limit, $offset); // Function to retrieve jobs based on limit and offset

// Check if action is set (view, edit, delete)
$action = $_GET['action'] ?? 'view';

// Handle add job form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    $title = $_POST['job_title'];
    $description = $_POST['job_description'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $salary_range = $_POST['salary_range'];
    
    addJob($title, $description, $company, $location, $salary_range);
    header("Location: index.php");
    exit();
}

// Display form or Delete job Based on Action
if ($action === 'add' || $action === 'edit') {
    include 'includes/job_board_clean.php';
} elseif ($action === 'delete') {
    $jobId = $_GET['id']; 
    deleteJob($jobId);
    header("Location: index.php");
    exit();
} else {
    $jobs = getJobs($limit, $offset);
}   
?>

<!-- Display job listings only when not adding or editing -->
<?php if ($action === 'view'): ?>
    <div class="container mt-4">
        <h2>Job Listings</h2>

        <!-- Only show Add Job and Admin Dashboard buttons for admin users -->
        <?php if ($user_role === 'admin'): ?>
            <a href="index.php?action=add" class="btn btn-success mb-3">Add Job</a>
            <a href="auth/admin_dashboard.php" class="btn btn-light mb-3">Admin Dashboard</a>
        <?php endif; ?>

        <ul class="row list-unstyled"> <!-- Bootstrap grid row and list -->
            <?php foreach ($jobs as $job): ?>
            <li class="col-md-6 col-lg-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo htmlspecialchars($job['title']); ?></h3>
                        <p class="card-text"><?php echo htmlspecialchars($job['company']); ?></p>

                        <!-- Buttons with Bootstrap style -->
                        <a href="job_details.php?id=<?php echo $job['id']; ?>" class="btn btn-primary">View Details</a> 

                        <!-- Only show edit and delete for admin users -->
                        <?php if ($user_role === 'admin'): ?>
                            <a href="index.php?action=edit&id=<?php echo $job['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="index.php?action=delete&id=<?php echo $job['id']; ?>" class="btn btn-danger">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>

        <?php
        $pdo = connectDb();
        $total_jobs = $pdo->query("SELECT COUNT(*) FROM jobs")->fetchColumn();
        $total_pages = ceil($total_jobs / $limit);
        ?>

        <!-- Pagination Links --> 
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="index.php?page=<?php echo $page - 1; ?>">Previous</a>
            <?php endif; ?>

            <?php if ($page < $total_pages): ?>
                <a href="index.php?page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        </div>

        <!-- Logout button -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <div style="margin-top: 40px; text-align: center;">
                <a href="auth/logout.php" class="btn btn-danger">Logout</a>
            </div>
        <?php endif; ?>

        <?php include 'includes/footer.php'; ?>
    </div>
<?php endif; ?>

    
