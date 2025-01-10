<?php
require 'includes/functions.php';
$pdo = connectDb();
$id = $_GET['id'] ?? null;

//fetch job details
$stmt = $pdo->prepare('SELECT * FROM jobs WHERE id = ?'); 
$stmt->execute([$id]);
$job = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
<?php if ($job): ?>
    <div class="card p-4 shadow-lg">
    <h1 class="card-title text-primary"><?php echo htmlspecialchars($job['title']); ?></h1>
            <p class="text-muted"><strong>Company:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
            <p><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary_range']); ?></p>
            <div class="bg-light border-left border-primary p-3 my-3 rounded">
                <p class="mb-0"><?php echo htmlspecialchars($job['description']); ?></p>
            </div>
            <p class="text-muted"><small>Posted on: <?php echo htmlspecialchars($job['date_posted']); ?></small></p>
            <a href="index.php" class="btn btn-primary mt-3">Back to Job Listings</a>
        </div>
    <?php else: ?>
        <p class="text-danger">Job not found.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
