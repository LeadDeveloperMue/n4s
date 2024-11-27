<?php
// Function to fetch questions from the database
function fetchQuestions($pdo) {
    $stmt = $pdo->query("SELECT * FROM questions ORDER BY id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//fetch all questions
function fetchQuizResults($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT * FROM results WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}


// Function to save quiz results
function saveQuizResults($pdo, $user_id, $score, $quiz_id) {
    $stmt = $pdo->prepare("INSERT INTO results (user_id, quiz_id, score) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $quiz_id, $score]);
}

// Function to validate user login credentials
function validateLogin($pdo, $email, $password) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        return $user; // Return user data if login is successful
    }
    return false; // Return false if login fails
}

// Function to register a new user
function registerUser($pdo, $email, $password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->execute([$email, $hashed_password]);
    return $pdo->lastInsertId(); // Return the new user ID
}

// Function to check if a user exists by email
function userExists($pdo, $email) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetchColumn() > 0;
}

// Function to get a user's progress in the quiz
function getUserProgress($pdo, $user_id, $quiz_id) {
    $stmt = $pdo->prepare("SELECT score FROM results WHERE user_id = ? AND quiz_id = ?");
    $stmt->execute([$user_id, $quiz_id]);
    return $stmt->fetch();
}

// Function to get the user's last quiz score
function getLastQuizScore($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT score FROM results WHERE user_id = ? ORDER BY date_taken DESC LIMIT 1");
    $stmt->execute([$user_id]);
    return $stmt->fetchColumn();
}

// Function to check if a user is an admin
function isAdmin($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    return $user['role'] === 'admin';
}
// Add this function to functions.php
function calculateScore($results) {
    $score = 0;

    foreach ($results as $result) {
        // Assuming the 'correct' field in $results indicates whether the answer is correct
        if (isset($result['correct']) && $result['correct'] == 1) {
            $score++;
        }
    }

    return $score;
}
?>
