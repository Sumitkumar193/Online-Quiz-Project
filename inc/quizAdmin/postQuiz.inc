<?php
$QuizCode = substr(md5(uniqid(mt_rand(), true)) , 0, 12);
?>

<div class="mb-3" style="max-width: 50%; margin: 25%;">

    <h3 style="text-align: center;">Step 1: Create Quiz</h3>
    <?php include "assets/errors.php"; ?>
    <form action="../../postQuiz.php" method="post">
        <label for="topic" class="form-label">Quiz Topic:</label>
        <input type="text" class="form-control" name="QuizTopic" placeholder="Enter Quiz Topic"><br>
        <label for="Score" class="form-label">Quiz Marks:</label>
        <input type="text" class="form-control" name="Score" VALUE="20" placeholder="Marks"><br>
        <button type="submit" name="submitQuiz" class="btn btn-primary">Next</button>
    </form>
    <br>
    <p style="text-align: center"><b>Note: Marks will be equally divided by number of questions.</b></p>
    <p style="text-align: center">Number of Question / Quiz Marks</p>
</div>