<?php
include "assets/server.php";
if($_SESSION['isTeacher'] === 0){
    header("Location: home.php");
}
?>
<html lang="en">
<head>
    <title>Edit a Question!</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="/css/styles.css" rel="stylesheet" />
</head>
<header>
    <?php include 'assets/header.php' ?>
</header>
<body>
<div class="container">
    <table>
        <tr>
            <th colspan="2" rowspan="2" style="width: 10%">QNo</th>
            <th rowspan="2" style="width: 70%">Question</th>
            <th colspan="2" style="20%">Action</th>
        </tr>
        <tr>
            <th>edit</th>
            <th>delete</th>
        </tr>
        <?php include 'assets/queEdit.php';?>
    </table>
</div>
<footer>
    <?php include 'assets/footer.php' ?>
</footer>
</body>
</html>