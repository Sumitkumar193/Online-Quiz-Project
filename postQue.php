<?php
include_once 'assets/questionPost.php';

if(!isset($_SESSION['isLoggedIn'])){
    header("Location: login.php");
}
if(!isset($_SESSION['isTeacher'])){
    header("Location: home.php");
}

?>
<html lang="en">
<html lang="en">
<head>
    <title>Make Quiz!</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
</head>
<?php include 'assets/header.php';?>
<body>
<div class="container">

    <div class="form-controller" style="max-width: 100%;margin: 5%%;">
        <?php
        if ($_SESSION['isLoggedIn'] == 1) {
            if (($_SESSION['isTeacher'])==1) {
                include 'inc/queAdmin/addQue.inc';
            } else {
                echo 'You are not authorized to view this page';
                header("Location: home.php");
            }
        }
        ?>
    </div>

</div>
<footer>
    <?php include 'assets/footer.php' ?>
</footer>
</body>
</html>
