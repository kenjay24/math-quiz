<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $level = $_POST['level'];
    $operator = $_POST['operator'];
    $num_questions = $_POST['num_questions'];
    
    if ($level === 'custom') {
        $custom_min = $_POST['custom_min'];
        $custom_max = $_POST['custom_max'];

        if (!is_numeric($custom_min) || !is_numeric($custom_max) || $custom_min < 1 || $custom_max < $custom_min) {
            $error = "Please provide valid numbers for the custom range (min and max).";
        } else {
            $_SESSION['level'] = $level;
            $_SESSION['custom_min'] = $custom_min;
            $_SESSION['custom_max'] = $custom_max;
        }
    } else {
        $_SESSION['level'] = $level;
    }
    
    if (!isset($error)) {
        $_SESSION['operator'] = $operator;
        $_SESSION['num_questions'] = $num_questions;

        header("Location: quiz.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Math Quiz Settings</title>
</head>
<body>
    <div class="container">
        <h1>Math Quiz</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?= $error; ?></p>
        <?php endif; ?>
        <form method="post" onsubmit="return validateForm();">
            <label for="level">Select Difficulty:</label>
            <input type="radio" name="level" value="1" required> Level 1 (1-10)<br>
            <input type="radio" name="level" value="2"> Level 2 (11-100)<br>
            <input type="radio" name="level" value="custom" id="custom-radio"> Custom Level (Enter Range)<br>
            <div id="custom-range">
                <label>Min:</label>
                <input type="number" name="custom_min" id="custom_min" min="1">
                <label>Max:</label>
                <input type="number" name="custom_max" id="custom_max" min="1">
            </div>
            <br>
            <label for="operator">Select Operator:</label>
            <input type="radio" name="operator" value="addition" required> Addition<br>
            <input type="radio" name="operator" value="subtraction"> Subtraction<br>
            <input type="radio" name="operator" value="multiplication"> Multiplication<br>
            <br>
            <label for="num_questions">Number of Questions:</label>
            <input type="number" name="num_questions" min="1" max="50" value="10" required>
            <br>
            <button type="submit">Start Quiz</button>
        </form>
    </div>

    <script>
        const customRadio = document.getElementById('custom-radio');
        const customRange = document.getElementById('custom-range');
        const customMin = document.getElementById('custom_min');
        const customMax = document.getElementById('custom_max');

        document.querySelectorAll('input[name="level"]').forEach((input) => {
            input.addEventListener('change', function () {
                customRange.style.display = this.value === 'custom' ? 'block' : 'none';
                if (this.value !== 'custom') {
                    customMin.value = '';
                    customMax.value = '';
                }
            });
        });

        function validateForm() {
            if (customRadio.checked) {
                const min = parseInt(customMin.value, 10);
                const max = parseInt(customMax.value, 10);

                if (isNaN(min) || isNaN(max) || min < 1 || max < min) {
                    alert("Please enter valid numbers for the custom range (min and max).");
                    return false;
                }
            }
            return true;
        }
    </script>
</body>
</html>
