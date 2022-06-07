<?php
include 'assets/quizPost.php';
if(!isset($_SESSION['isLoggedIn'])){
    header("Location: login.php");
}
?>
<html lang="en">
<head>
    <title>Make Quiz!</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
</head>
<?php include 'assets/header.php';?>
<body>
<div class="container">


    <div class="form-controller" style="max-width: 75%;margin-left: 12.5%;margin-top: -2.5%;">
        <?php
        if ($_SESSION['isLoggedIn'] == 1) {
            if (($_SESSION['isTeacher'])==1) {
                include 'inc/quizAdmin/postQuiz.inc';
            } else {
                echo 'You are not authorized to view this page';
                header("Location: home.php");
            }
        }
        ?>
    </div>
</div>
<footer>
    <?php include "assets/footer.php";?>
</footer>
</body>
</html>
