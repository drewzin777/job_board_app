<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require '../includes/functions.php';
$pdo = connectDb();

// Initialize variables
$error = '';
$job = null;

// Get the job ID from the URL
if (isset($_GET['id'])) {
    $jobId = $_GET['id'];

    // Fetch the job details
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE id = ?");
    $stmt->execute([$jobId]);
    $job = $stmt->fetch(PDO::FETCH_ASSOC);

    //var_dump($job);     //Debugging
    //exit();             //Temp for debugg

    if (!$job) {
        $error = 'Job not found.';
    }
} else {
    $error = 'No job ID provided.';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $salary_range = $_POST['salary_range'];

    if (empty($title) || empty($description) || empty($company) || empty($location)) {
        $error = 'Please fill in all required fields.';
    } else {
        // Update the job in the database
        $stmt = $pdo->prepare("UPDATE jobs SET title = ?, description = ?, company = ?, location = ?, salary_range = ? WHERE id = ?");
        $stmt->execute([$title, $description, $company, $location, $salary_range, $jobId]);
        header("Location: admin_dashboard.php"); // Redirect back to the admin dashboard
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Job</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Job</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($job): ?>
        <form action="edit_job.php?id=<?php echo htmlspecialchars($jobId); ?>" method="post">
            <div class="form-group">
                <label>Job Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($job['title']); ?>" required>
            </div>
            <div class="form-group">
                <label>Job Description</label>
                <textarea name="description" class="form-control" required><?php echo htmlspecialchars($job['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Company</label>
                <input type="text" name="company" class="form-control" value="<?php echo htmlspecialchars($job['company']); ?>" required>
            </div>
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($job['location']); ?>" required>
            </div>
            <div class="form-group">
                <label>Salary Range</label>
                <input type="text" name="salary_range" class="form-control" value="<?php echo htmlspecialchars($job['salary_range']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
