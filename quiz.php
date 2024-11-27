<?php
include 'auth.php';
include 'db.php';
include 'functions.php';

// Reset quiz progress
if (!isset($_SESSION['quiz_progress']) || isset($_GET['reset'])) {
    unset($_SESSION['quiz_progress']);
    $_SESSION['quiz_progress'] = []; // Initialize progress
}

// Fetch questions for the quiz
$questions = fetchQuestions($pdo);

// Check if reset is requested
if (isset($_GET['reset']) && $_GET['reset'] == 1) {
    unset($_SESSION['quiz_progress']); // Clear previous progress
}
// Redirect to quiz start
if (!empty($questions)) {
    header('Location: quiz.php');
    exit;
} else {
    echo "No questions available.";
}
// Redirect to the first question if questions exist
if (!empty($questions)) {
    $_SESSION['quiz_progress'] = []; // Initialize progress
    header('Location: quiz.php'); // Change to your actual quiz starting logic
    exit;
} else {
    echo "No questions available. Please contact the administrator.";
}
// Check if the quiz has already started
if (!isset($_SESSION['quiz_start_time'])) {
    $_SESSION['quiz_start_time'] = time();
}

$time_limit = 8 * 60; // 8 minutes in seconds
$time_left = $time_limit - (time() - $_SESSION['quiz_start_time']);

if ($time_left <= 0) {
    header('Location: results.php');
    exit;
}

// Current question index
$current_question_index = isset($_GET['q']) ? (int) $_GET['q'] : 0;
if ($current_question_index >= $total_questions) {
    header('Location: results.php');
    exit;
}

$current_question = $questions[$current_question_index];
?>
<div class="container mt-5">
    <h2>Driving Quiz</h2>
    <div id="timer" class="text-danger mb-3">
        Time Left: <span id="time-left"><?= gmdate("i:s", $time_left) ?></span>
    </div>
    <form method="POST" action="save_quiz_progress.php">
        <input type="hidden" name="question_id" value="<?= $current_question['id'] ?>">
        <h5><?= ($current_question_index + 1) . ". " . $current_question['question'] ?></h5>
        <?php foreach (json_decode($current_question['options']) as $key => $option): ?>
            <div class="form-check">
                <input type="radio" name="answer" value="<?= chr(65 + $key) ?>" class="form-check-input">
                <label class="form-check-label"><?= chr(65 + $key) ?>. <?= $option ?></label>
            </div>
        <?php endforeach; ?>
        <div class="mt-3">
            <?php if ($current_question_index > 0): ?>
                <a href="quiz.php?q=<?= $current_question_index - 1 ?>" class="btn btn-secondary">Previous</a>
            <?php endif; ?>
            <?php if ($current_question_index < $total_questions - 1): ?>
                <a href="quiz.php?q=<?= $current_question_index + 1 ?>" class="btn btn-primary">Next</a>
            <?php else: ?>
                <button type="submit" class="btn btn-success">Submit Quiz</button>
            <?php endif; ?>
        </div>
    </form>
</div>
<script>
    const timerElement = document.getElementById("time-left");
    let timeLeft = <?= $time_left ?>;

    setInterval(() => {
        if (timeLeft <= 0) {
            window.location.href = "results.php";
        } else {
            timeLeft--;
            timerElement.textContent = new Date(timeLeft * 1000).toISOString().substr(14, 5);
        }
    }, 1000);
</script>
<?php include 'footer.php'; ?>
