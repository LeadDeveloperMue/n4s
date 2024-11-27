<?php
include 'db.php'; // Ensure $pdo is initialized before using it
include 'auth.php'; // Only include once
include 'functions.php'; // Include functions to access fetchQuizResults()
include 'header.php'; // Include functions to access fetchQuizResults()

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Make sure the session is started before accessing session variables
// Get the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Fetch the quiz results for this user
$results = fetchQuizResults($pdo, $user_id);

// Get the total number of questions and score
$total_questions = count($results);
$score = calculateScore($results);

// Pass mark for the quiz
$pass_mark = 22;
?>
<div class="container mt-5">
    <h2>Quiz Results</h2>
    <div class="containerx">
    <p>Total Questions: <strong><?= $total_questions ?></strong></p>
    <p>Your Score: <strong><?= $score ?> / <?= $total_questions ?></strong></p>
    <p>Status: 
        <strong class="<?= $score >= $pass_mark ? 'text-success' : 'text-danger' ?>">
            <?= $score >= $pass_mark ? 'Pass' : 'Fail' ?>
        </strong>
    </p>
    <a href="quiz.php" class="btn <?= $score >= $pass_mark ? 'btn-primary' : 'btn-warning' ?>">
        <?= $score >= $pass_mark ? 'Take Another Quiz' : 'Try Again' ?>
    </a>
</div>

</div>
<?php include 'footer.php'; ?>
