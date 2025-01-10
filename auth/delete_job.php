<?php
session_start(); 

//Include the database connetionfile
require_once '../includes/functions.php';

//Check if the job ID is provided via GET request
if (isset($_GET['id'])) {
    $jobId = intval($_GET['id']); 

    //Call the delete Job Id to delete job by id
    deleteJob($jobId);

    //Redirect back to admin dashboard
    header("Location: admin_dashboard.php?message=Job deleted successfully"); 
    exit(); 
} else {
    echo "No job ID provided.";
}
?>