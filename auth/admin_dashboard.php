<?php 
session_start();

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");     // Redirect to login if not an admin
    exit();
}

require '../includes/functions.php';
$pdo = connectDb();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container-fluid {
            max-width: 100%;
            overflow-x: hidden;
        }

        .table-responsive {
            overflow-x: auto;
        }

        @media (max-width: 768px) {
            .row {
                flex-direction: column;
            }
            aside {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 576px) {
            .btn {
                font-size: 0.8rem;
                padding: 0.25rem 0.5rem;
            }
            .table td, .table th {
                white-space: normal;
            }
        }
    </style>
</head>
<body>

<header class="dashboard-header text-center py-3">
    <h1>Admin Dashboard</h1>
</header>

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-3 col-lg-2 bg-light p-3">
            <h5>Navigation</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="../index.php" class="nav-link">Dashboard Home</a></li>
                <li class="nav-item"><a href="add_job.php" class="nav-link">Add Job</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
            </ul>
        </aside>

        <!-- Main content -->
         <main class="col-md-9 col-lg-10">
            <!-- Total job posting count -->
            <?php $totalJobs = $pdo->query("SELECT COUNT(*) FROM jobs")->fetchColumn(); ?>
            <p><strong>Total Job Postings:</strong> <?php echo $totalJobs; ?></p>

            <!-- Job listings table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Location</th>
                            <th>Salary</th>
                            <th>Date Posted</th>
                            <th>Actions</th>
                        </tr>   
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM jobs ORDER BY date_posted DESC"); 
                        while ($job = $stmt->fetch()) {
                            echo "<tr>
                                <td>" . htmlspecialchars($job['title']) . "</td>
                                <td>" . htmlspecialchars($job['company']) . "</td>
                                <td>" . htmlspecialchars($job['location']) . "</td>
                                <td>" . htmlspecialchars($job['salary_range']) . "</td>
                                <td>" . htmlspecialchars($job['date_posted']) . "</td>
                                <td>
                                   <a href='edit_job.php?id=" . $job['id'] . "' class='btn btn-primary btn-sm'>Edit</a>
                                   <a href='delete_job.php?id=" . $job['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this job?\");'>Delete</a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

            
