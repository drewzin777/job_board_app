<?php 
require '../includes/functions.php';
$pdo = connectDb(); 
$error = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Get user input from form
    $username = trim($_POST['username']);
    $email = trim($_POST['email']); 
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    //Validate input
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required.'; 
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check if username or email already exist
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ?'); 
        $stmt->execute([$username, $email]); 
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            $error = 'Username or email already taken.'; 
        } else {
            //Hash password
            $password_hash = password_hash($password, PASSWORD_DEFAULT); 

            //insert user into database
            $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)'); 
            $stmt->execute([$username, $email, $password_hash]);

            //Redirect to login page after registration
            header("Location: login.php"); 
            exit();
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Register</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error);  ?></div>
        <?php endif; ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <p class="mt-3">Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
