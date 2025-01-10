<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Board</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Inline CSS -->
    <style>
        /* Reset and basic styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            
        }

        h2 {
            font-size: 1.5rem;
            margin: 1.5rem 0 1rem;
            color: #333;
        }

        .job-description {
            font-size: 15px; 
            color: #777; 
            line-height: 1.6; 
            margin: 15px 0;
            padding: 10px; 
            background-color: #f7f7f7; 
            border-left: 3px solid #007bff;
            border-radius: 4px; 
        }

        .btn-back {
            display: inline-block; 
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background-color: #007bff; 
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #0056b3; 
        }
    </style>
</head>
<body>
<header class="bg-dark text-white text-center py-3">
    <h1 class="text-white">Job Board</h1>
    <nav>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a href="auth/admin_dashboard.php" class="btn btn-light">Admin Dashboard</a>
    <?php endif; ?>
    </nav>
</header>
<div class="container">
    <!-- Main content area -->
   
