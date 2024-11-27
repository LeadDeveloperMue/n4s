<?php
include 'auth.php';
include 'header.php'; ?>
<div class="container mt-5">
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome to N4S Driving Quiz</h1>
        <p class="lead">Test your driving knowledge based on the Zimbabwean Highway Code.</p>
        <hr class="my-4">
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>You are logged in as <strong><?= $_SESSION['user_email'] ?></strong>.</p>
            <a class="btn btn-primary btn-lg" href="quiz.php" role="button">Start Quiz</a>
            <a class="btn btn-secondary btn-lg" href="results.php" role="button">View Results</a>
        <?php else: ?>
            <p>Login or register to take the quiz and track your progress.</p>
            <a class="btn btn-primary btn-lg" href="login.php" role="button">Login</a>
            <a class="btn btn-secondary btn-lg" href="register.php" role="button">Register</a>
        <?php endif; ?>
    </div>
</div>
<?php include 'footer.php'; ?>
