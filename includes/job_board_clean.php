<?php 
$isEditing = isset($_GET['id']);

if ($isEditing) {
    $job = getJobById($_GET['id']);
} else {
    $job = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['job_title'];
    $description = $_POST['job_description'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $salary_range = $_POST['salary_range'];

    if ($isEditing) {
        updateJob($_GET['id'], $title, $description, $company, $location, $salary_range);
    } else {
        addJob($title, $description, $company, $location, $salary_range);
    }
    header("Location: index.php");
    exit;
}
?>


<h2><?php echo $isEditing ? 'Edit Job' : 'Add Job'; ?></h2>
<!-- Job Posting Form -->
<form action="index.php?action=add" method="post">
    <div class="form-group">
        <label>Job Title</label>
        <input type="text" name="job_title" class="form-control" value="<?php echo $job['title'] ?? ''; ?>" required>
    </div>
    <div class="form-group">
        <label>Job Description</label>
        <textarea name="job_description" class="form-control" required><?php echo $job['description'] ?? ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Company</label>
        <input type="text" name="company" class="form-control" value="<?php echo $job['company'] ?? ''; ?>" required>
    </div>
    <div class="form-group">
        <label>Location</label>
        <input type="text" name="location" class="form-control" value="<?php echo $job['location'] ?? ''; ?>" required>
    </div>
    <div class="form-group">
        <label>Salary Range</label>
        <input type="text" name="salary_range" class="form-control" value="<?php echo $job['salary_range'] ?? ''; ?>">
    </div>

    <!-- Button alignment -->
    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary"><?php echo $isEditing ? 'Update Job' : 'Add Job'; ?></button>
        <a href="index.php" class="btn btn-secondary mb-3">Back to Main Page</a>
    </div>
</form>
