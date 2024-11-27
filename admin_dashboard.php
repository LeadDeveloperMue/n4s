<?php
include 'auth.php'; // Protect this page
include 'header.php'; // Protect this page
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <h2>Admin Dashboard</h2>
    <a href="edit_question.php" class="btn btn-success">Manage Questions</a>
</div>
<?php include 'footer.php'; ?>
