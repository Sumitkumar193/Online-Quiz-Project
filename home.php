<?php
include 'assets/server.php';
if(!isset($_SESSION['isLoggedIn'])){
    header("Location: login.php");
}

?>
<html lang="en">
<head>
    <title>Home!</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
</head>
<?php include 'assets/header.php';?>
<body>
<div class="container">
        <?php
        if ($_SESSION['isLoggedIn'] == 1) {

            echo "<p style='margin-top: 7.5%; font-weight: bold; font-size: large;'>Hello, " . $_SESSION['name'] . "<br>Welcome to our quiz project!!</p>";
            if (($_SESSION['isTeacher'])==1) {
                include 'inc/dashboard/aDashboard.inc';
            } else {
                include 'inc/dashboard/uDashboard.inc';
            }
        }?>
</div>
<footer>
    <?php include 'assets/footer.php' ?>
</footer>
</body>
</html>