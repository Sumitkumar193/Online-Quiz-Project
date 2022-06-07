<?php
include 'assets/server.php';
if(isset($_SESSION['isLoggedIn'])){
    header("Location: home.php");
}
?>

<html lang="en">
<head>
    <title>Registration!</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
</head>
<header>
    <?php include 'assets/header.php' ?>
</header>
<body>
<div class="container">
    <div id="form-controller">
        <h4>Registration is open!</h4>
        <form method="post" action="registration.php">
            <?php include('assets/errors.php');?>
            <input type="text" class="form-control" value="<?php echo ''?>" required name="username" placeholder="Name" style="padding-top: 1%; margin-top: 2%">
            <input type="email" class="form-control" value="<?php echo ''?>" required name="email" placeholder="Email ID" style="padding-top: 1%; margin-top: 2%">
            <input type="password" class="form-control" value="<?php echo '' ?>" required name="password_1" placeholder="Input Password" style="padding-top: 1%; margin-top: 2%">
            <input type="password" class="form-control" value="<?php echo '' ?>" required name="password_2" placeholder="Confirm Password" style="padding-top: 1%; margin-top: 2%">
            <button type="submit" class="btn btn-success" name="reg_user" style="margin-top: 1.5%">Sign Up</button>
        </form>
        <form method="get" action="login.php">
            <button type="submit" class="btn btn-danger" style="margin-top: 1.5%">Already have account?</button>
        </form>
        <br><p><b><i>Note: for teacher's registration create account and contact administrator</i></b></p>
    </div>
</div>
</body>
<footer>
    <?php include 'assets/footer.php' ?>
</footer>
</html>