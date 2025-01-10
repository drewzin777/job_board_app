<?php
session_start(); 

//Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");  //Redirect if not admin
    exit();
}

//Include functions file to access add job function
require_once '../includes/functions.php';

//Chceck if form is submitted 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['job_title']);
    $description = htmlspecialchars($_POST['job_description']);
    $company = htmlspecialchars($_POST['company']);
    $location = htmlspecialchars($_POST['location']);
    $salary_range = htmlspecialchars($_POST['salary_range']);

    //Call addjob function to add a new job
    addJob($title, $description, $company, $location, $salary_range); 

    //Redirect back to admin dashboard page 
    header("Location: admin_dashboard.php?message=Job added successfully"); 
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Job</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Add Job</h2>
    <form action="add_job.php" method="POST">
        <div class="form-group">
            <label for="job_title">Job Title</label>
            <input type="text" id="job_title" name="job_title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="job_description">Job Description</label>
            <textarea id="job_description" name="job_description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="company">Company</label>
            <input type="text" id="company" name="company" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="salary_range">Salary Range</label>
            <input type="text" id="salary_range" name="salary_range" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Add Job</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>