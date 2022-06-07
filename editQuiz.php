<?php
include 'assets/server.php';
if($_SESSION['isTeacher'] === 0){
    header("Location: home.php");
}
?>
<html lang="en">
<head>
    <title>Edit Menu</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
</head>
<header>
    <?php include 'assets/header.php' ?>
</header>
<body>
<div class="container">
    <?php include "assets/errors.php";?>
    <table>
        <thead>
        <tr>
            <th colspan="2" rowspan="2" style="width: 40%">QuizName</th>
            <th rowspan="2">QuizCode</th>
            <th rowspan="2">Questions</th>
            <th colspan="2">Action</th>
        </tr>
        <tr>
            <th>edit</th>
            <th>delete</th>
        </tr>
        <tr>

        </tr>
        <?php
            include 'assets/quizEdit.php';
        ?>
        </thead>
    </table>
</div>
<footer>
    <?php include 'assets/footer.php' ?>
</footer>
</body>
</html>