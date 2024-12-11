<?php
session_start();

if (!isset($_SESSION['score'], $_SESSION['wrong'], $_SESSION['num_questions'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_destroy();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Quiz Results</title>
</head>
<body>
    <div class="container">
        <h1>Quiz Results</h1>
        <table>
            <tr>
                <th>Total Questions</th>
                <th>Correct Answers</th>
                <th>Wrong Answers</th>
                <th>Accuracy</th>
            </tr>
            <tr>
                <td><?= $_SESSION['num_questions']; ?></td>
                <td><?= $_SESSION['score']; ?></td>
                <td><?= $_SESSION['wrong']; ?></td>
                <td><?= round(($_SESSION['score'] / $_SESSION['num_questions']) * 100, 2); ?>%</td>
            </tr>
        </table>
        <form method="post">
            <button type="submit">Restart Quiz</button>
        </form>
    </div>
</body>
</html>
