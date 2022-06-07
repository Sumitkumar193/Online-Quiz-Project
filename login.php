<?php
include 'assets/server.php';
if(isset($_SESSION['isLoggedIn'])){
    header("Location: home.php");
}
?>


<html>
<head>
    <title>Login!</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
</head>
<header>
    <?php include 'assets/header.php'?>
</header>
<body>
<div class="container">
    <div id="form-controller">
        <h3>Login</h3>
        <?php include('assets/errors.php'); ?>
        <form action="login.php" method="post">
        <input type="text" class="form-control" name="email" value="<?php echo ''; ?>" placeholder="Email ID">
        <input type="password" class="form-control"  name="password" value="<?php echo ''; ?>" placeholder="Password" style="padding-top: 1%; margin-top: 2%">
        <button type="submit" class="btn btn-success" name="login_user" style="margin-top: 1.5%">Login</button>
        </form>
        <form method="get" action="registration.php">
            <button type="submit" class="btn btn-danger" style="margin-top: 1.5%">Register Here!</button>
        </form>
    </div>
</div>

<footer>
    <?php include 'assets/footer.php' ?>
</footer>
</body>
</html>

