<?php
include 'auth.php';
include 'header.php'; // Protect this page
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question = $_POST['question'];
    $options = json_encode([$_POST['option_a'], $_POST['option_b'], $_POST['option_c'], $_POST['option_d']]);
    $correct_option = $_POST['correct_option'];

    $stmt = $pdo->prepare("INSERT INTO questions (question, options, correct_option) VALUES (?, ?, ?)");
    $stmt->execute([$question, $options, $correct_option]);
}
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <h2>Manage Questions</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Question</label>
            <textarea name="question" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Option A</label>
            <input type="text" name="option_a" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Option B</label>
            <input type="text" name="option_b" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Option C</label>
            <input type="text" name="option_c" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Option D</label>
            <input type="text" name="option_d" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Correct Option</label>
            <select name="correct_option" class="form-select" required>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Question</button>
    </form>
</div>
<?php include 'footer.php'; ?>
