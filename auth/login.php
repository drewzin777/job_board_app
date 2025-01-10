<?php 
session_start();

require '../includes/functions.php';
$pdo = connectDb(); 
$error = ''; 

// Ensure the role is pulled from session if set, or default to 'user'
$user_role = $_SESSION['role'] ?? 'user';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input from form
    $username_or_email = trim($_POST['username_or_email']);
    $password = $_POST['password']; 

    // Check if fields are empty
    if (empty($username_or_email) || empty($password)) {
        $error = 'Please fill in both fields.';
    } else {
        // Check if user exists by username or email
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? OR email = ?'); 
        $stmt->execute([$username_or_email, $username_or_email]);
        $user = $stmt->fetch();

        // Verify password
        if ($user && password_verify($password, $user['password_hash'])) {
            // Start a session and store user info
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];   // Store role in session

            // Redirect based on role
            if ($_SESSION['role'] === 'admin') {
                header("Location: admin_dashboard.php"); 
            } else {
                header("Location: /job_board/index.php"); // Adjust as needed
            }
            exit(); 
        } else {
            // Invalid login
            $error = 'Invalid username/email or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Login</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?> 
    <form action="login.php" method="post">
        <div class="form-group">
            <label>Username or Email</label>
            <input type="text" name="username_or_email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <p class="mt-3">Don't have an account? <a href="register.php">Register here</a>.</p>
</div>
</body>
</html>
