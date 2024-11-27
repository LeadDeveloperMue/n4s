<?php
// Fetch all questions from the database
function fetchQuestions($pdo) {
    $stmt = $pdo->query("SELECT * FROM questions ORDER BY id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Save user's answer
function saveUserAnswer($pdo, $user_id, $question_id, $selected_option) {
    $stmt = $pdo->prepare("SELECT correct_option FROM questions WHERE id = ?");
    $stmt->execute([$question_id]);
    $correct_option = $stmt->fetchColumn();

    $is_correct = $correct_option === $selected_option;

    $stmt = $pdo->prepare("INSERT INTO quiz_attempts (user_id, question_id, selected_option, is_correct) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $question_id, $selected_option, $is_correct]);
}

// Fetch quiz results for a user
function fetchQuizResults($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT q.id, q.question, q.correct_option, qa.selected_option, qa.is_correct 
                           FROM quiz_attempts qa
                           JOIN questions q ON qa.question_id = q.id
                           WHERE qa.user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Calculate the user's score
function calculateScore($results) {
    return array_reduce($results, function ($carry, $result) {
        return $carry + ($result['is_correct'] ? 1 : 0);
    }, 0);
}
?>
