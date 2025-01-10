<!-- includes/footer.php -->
</div> <!-- End of main content container -->

<footer class="bg-dark text-white text-center py-3">
    <p>&copy; <?php echo date("Y"); ?> Job Board</p>
</footer>

<!-- Bootstrap and jQuery JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional JavaScript -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteLinks = document.querySelectorAll('a[href*="delete"]');
        deleteLinks.forEach(link => {
            link.addEventListener("click", function(event) {
                if (!confirm("Are you sure you want to delete this job?")) {
                    event.preventDefault();
                }
            });
        });
    });
</script>
</body>
</html>
